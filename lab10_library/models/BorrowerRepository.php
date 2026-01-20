<?php
require_once APP_ROOT . '/config/Database.php';

class BorrowerRepository {
    private $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM borrowers ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    public function create($data) {
        $sql = "INSERT INTO borrowers (full_name, phone) VALUES (:full_name, :phone)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}
?>