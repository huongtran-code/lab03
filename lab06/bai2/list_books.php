<?php
$books = json_decode(file_get_contents('../data/books.json'), true);
?>
<table border="1">
    <tr><th>Mã</th><th>Tên</th><th>Tác giả</th><th>Năm</th><th>Thể loại</th><th>SL</th></tr>
    <?php foreach ($books as $b): ?>
    <tr>
        <td><?= htmlspecialchars($b['id']) ?></td>
        <td><?= htmlspecialchars($b['title']) ?></td>
        <td><?= htmlspecialchars($b['author']) ?></td>
        <td><?= htmlspecialchars($b['year']) ?></td>
        <td><?= htmlspecialchars($b['cat']) ?></td>
        <td><?= htmlspecialchars($b['qty']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>