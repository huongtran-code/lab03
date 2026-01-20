<?php
// SỬA DÒNG NÀY
require_once APP_ROOT . '/config/Database.php';

class BorrowRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        $sql = "SELECT b.*, br.full_name FROM borrows b 
                JOIN borrowers br ON b.borrower_id = br.id 
                ORDER BY b.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT b.*, br.full_name FROM borrows b JOIN borrowers br ON b.borrower_id = br.id WHERE b.id = :id");
        $stmt->execute(['id' => $id]);
        $borrow = $stmt->fetch();

        if ($borrow) {
            $sqlItems = "SELECT bi.*, k.title, k.author FROM borrow_items bi 
                         JOIN books k ON bi.book_id = k.id 
                         WHERE bi.borrow_id = :id";
            $stmtItems = $this->db->prepare($sqlItems);
            $stmtItems->execute(['id' => $id]);
            $borrow['items'] = $stmtItems->fetchAll();
        }
        return $borrow;
    }

    public function createTransaction($borrower_id, $borrow_date, $note, $items) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO borrows (borrower_id, borrow_date, note) VALUES (:bid, :bdate, :note)");
            $stmt->execute(['bid' => $borrower_id, 'bdate' => $borrow_date, 'note' => $note]);
            $borrowId = $this->db->lastInsertId();

            foreach ($items as $item) {
                $bookId = $item['book_id'];
                $qty = $item['qty'];
                if ($qty <= 0) continue;

                $stmtCheck = $this->db->prepare("SELECT qty FROM books WHERE id = :id FOR UPDATE");
                $stmtCheck->execute(['id' => $bookId]);
                $book = $stmtCheck->fetch();

                if (!$book || $book['qty'] < $qty) {
                    throw new Exception("Sách ID $bookId không đủ tồn kho (Còn: " . ($book['qty'] ?? 0) . ")");
                }

                $stmtUpdate = $this->db->prepare("UPDATE books SET qty = qty - :qty WHERE id = :id");
                $stmtUpdate->execute(['qty' => $qty, 'id' => $bookId]);

                $stmtItem = $this->db->prepare("INSERT INTO borrow_items (borrow_id, book_id, qty) VALUES (:brid, :bkid, :qty)");
                $stmtItem->execute(['brid' => $borrowId, 'bkid' => $bookId, 'qty' => $qty]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
?>