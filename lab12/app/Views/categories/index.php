<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .table-action-btn { width: 35px; height: 35px; padding: 0; line-height: 35px; text-align: center; }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-list-task"></i> Danh sách Danh mục</h4>
                <a href="index.php?c=category&a=create" class="btn btn-light btn-sm fw-bold">
                    <i class="bi bi-plus-lg"></i> Thêm mới
                </a>
            </div>
            
            <div class="card-body">
                <form action="index.php" method="GET" class="row g-3 mb-4">
                    <input type="hidden" name="c" value="category">
                    <input type="hidden" name="a" value="index">
                    
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   value="<?php echo htmlspecialchars($keyword); ?>" 
                                   placeholder="Nhập tên danh mục cần tìm...">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i> Tìm
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">ID</th>
                                <th>Tên Danh mục</th>
                                <th width="15%" class="text-center">Trạng thái</th>
                                <th width="15%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <tr>
                                        <td class="text-center fw-bold text-muted"><?php echo $cat['id']; ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($cat['name']); ?></td>
                                        <td class="text-center">
                                            <?php if ($cat['status'] == 1): ?>
                                                <span class="badge bg-success rounded-pill">Hoạt động</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary rounded-pill">Ngưng hoạt động</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="index.php?c=category&a=edit&id=<?php echo $cat['id']; ?>" 
                                               class="btn btn-primary btn-sm table-action-btn" title="Sửa">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="index.php?c=category&a=delete&id=<?php echo $cat['id']; ?>" 
                                               class="btn btn-danger btn-sm table-action-btn" 
                                               title="Xóa"
                                               onclick="return confirm('Cảnh báo: Bạn có chắc chắn muốn xóa danh mục này không?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Không tìm thấy dữ liệu nào.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>