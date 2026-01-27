<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm Full CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">📦 Quản lý Sản phẩm</h2>

        <div class="card p-3 mb-4 shadow-sm">
            <div class="row g-3">
                <div class="col-md-9">
                    <input type="text" id="searchInput" class="form-control" placeholder="🔍 Tìm kiếm theo tên hoặc mã...">
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-primary w-100" onclick="openModal()">
                        + Thêm Sản phẩm
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Mã SP</th>
                            <th>Tên Sản phẩm</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thêm Sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <input type="hidden" id="p_id" name="id">
                        
                        <div class="mb-3">
                            <label>Mã Sản phẩm</label>
                            <input type="text" class="form-control" id="p_code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label>Tên Sản phẩm</label>
                            <input type="text" class="form-control" id="p_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label>Giá (VNĐ)</label>
                            <input type="number" class="form-control" id="p_price" name="price" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="saveProduct()">Lưu lại</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const API_URL = 'index.php?page=api';
        let productModal; // Biến giữ đối tượng Modal

        document.addEventListener("DOMContentLoaded", () => {
            productModal = new bootstrap.Modal(document.getElementById('productModal'));
            loadProducts(""); 
        });

        // 1. Search Logic
        document.getElementById('searchInput').addEventListener('input', function() {
            loadProducts(this.value);
        });

        async function loadProducts(keyword) {
            const res = await fetch(`${API_URL}&action=search&q=${encodeURIComponent(keyword)}`);
            const json = await res.json();
            const tbody = document.getElementById('productTableBody');
            tbody.innerHTML = '';

            if(json.success && json.data.length > 0) {
                json.data.forEach(p => {
                    const price = new Intl.NumberFormat('vi-VN').format(p.price);
                    tbody.innerHTML += `
                        <tr>
                            <td>${p.id}</td>
                            <td><span class="badge bg-info text-dark">${p.code}</span></td>
                            <td>${p.name}</td>
                            <td>${price} đ</td>
                            <td>
                                <button class="btn btn-warning btn-sm me-2" onclick="editProduct(${p.id})">✏ Sửa</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteProduct(${p.id})">🗑 Xóa</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
            }
        }

        // 2. Mở Modal (Mode Thêm)
        function openModal() {
            document.getElementById('productForm').reset(); // Xóa trắng form
            document.getElementById('p_id').value = '';     // ID rỗng => Thêm mới
            document.getElementById('modalTitle').innerText = 'Thêm Sản phẩm mới';
            productModal.show();
        }

        // 3. Mở Modal (Mode Sửa - Load dữ liệu cũ)
        async function editProduct(id) {
            try {
                const res = await fetch(`${API_URL}&action=show&id=${id}`);
                const json = await res.json();
                
                if (json.success) {
                    const p = json.data;
                    document.getElementById('p_id').value = p.id;
                    document.getElementById('p_code').value = p.code;
                    document.getElementById('p_name').value = p.name;
                    document.getElementById('p_price').value = p.price;
                    
                    document.getElementById('modalTitle').innerText = 'Cập nhật Sản phẩm';
                    productModal.show();
                }
            } catch (e) { alert('Lỗi tải dữ liệu'); }
        }

        // 4. Lưu (Xử lý chung cho Thêm & Sửa)
        async function saveProduct() {
            const id = document.getElementById('p_id').value;
            const form = document.getElementById('productForm');
            const formData = new FormData(form);

            // Nếu có ID -> Gọi action UPDATE, ngược lại -> STORE
            const action = id ? 'update' : 'store';
            
            try {
                const res = await fetch(`${API_URL}&action=${action}`, {
                    method: 'POST',
                    body: formData
                });
                const json = await res.json();

                if (json.success) {
                    alert(json.message);
                    productModal.hide();     // Ẩn modal
                    loadProducts(document.getElementById('searchInput').value); // Load lại bảng
                } else {
                    alert(json.message);
                }
            } catch (e) {
                console.error(e);
                alert('Có lỗi xảy ra!');
            }
        }

        // 5. Xóa (Như cũ)
        async function deleteProduct(id) {
            if (!confirm('Xóa sản phẩm này?')) return;
            const formData = new FormData();
            formData.append('id', id);
            await fetch(`${API_URL}&action=delete`, { method: 'POST', body: formData });
            loadProducts(document.getElementById('searchInput').value);
        }
    </script>
</body>
</html>