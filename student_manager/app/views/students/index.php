<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Sinh viên - Ajax MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center text-primary">QUẢN LÝ SINH VIÊN (AJAX - MVC)</h2>
        
        <div class="card p-3 mb-4 bg-light">
            <h5 id="formTitle">Thêm sinh viên mới</h5>
            <form id="studentForm">
                <input type="hidden" id="studentId" name="id">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="code" name="code" placeholder="Mã SV" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Họ tên" required>
                    </div>
                    <div class="col-md-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="dob" name="dob">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success w-100">Lưu</button>
                    </div>
                </div>
                <div class="mt-2 text-secondary" id="formMessage"></div>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="cancelBtn" style="display:none;">Hủy</button>
            </form>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Mã SV</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Ngày sinh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
                </tbody>
        </table>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>