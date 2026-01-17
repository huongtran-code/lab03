$(document).ready(function() {
    // 1. Load danh sách khi mở trang
    loadStudents();

    function loadStudents() {
        $.ajax({
            url: 'index.php?c=student&a=get_list',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let rows = '';
                    response.data.forEach(st => {
                        rows += `
                            <tr>
                                <td>${st.id}</td>
                                <td>${st.code}</td>
                                <td>${st.full_name}</td>
                                <td>${st.email}</td>
                                <td>${st.dob}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit" data-id="${st.id}">Sửa</button>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="${st.id}">Xóa</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#studentTableBody').html(rows);
                }
            }
        });
    }

    // 2. Xử lý Submit Form (Thêm mới hoặc Cập nhật)
    $('#studentForm').submit(function(e) {
        e.preventDefault();
        
        let id = $('#studentId').val();
        let action = id ? 'update' : 'create'; // Nếu có ID là update, không là create
        
        $.ajax({
            url: `index.php?c=student&a=${action}`,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    loadStudents(); // Tải lại bảng
                    resetForm();    // Xóa form
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // 3. Xử lý nút Sửa (Đổ dữ liệu lên form)
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $.ajax({
            url: 'index.php?c=student&a=edit',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let st = response.data;
                    $('#studentId').val(st.id);
                    $('#code').val(st.code);
                    $('#fullName').val(st.full_name);
                    $('#email').val(st.email);
                    $('#dob').val(st.dob);
                    
                    $('#formTitle').text('Cập nhật sinh viên');
                    $('#cancelBtn').show();
                }
            }
        });
    });

    // 4. Xử lý nút Xóa
    $(document).on('click', '.btn-delete', function() {
        if (confirm('Bạn có chắc muốn xóa sinh viên này?')) {
            let id = $(this).data('id');
            $.ajax({
                url: 'index.php?c=student&a=delete',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        loadStudents(); // Tải lại danh sách
                    } else {
                        alert('Không thể xóa!');
                    }
                }
            });
        }
    });

    // 5. Nút Hủy (Reset form về trạng thái thêm mới)
    $('#cancelBtn').click(function() {
        resetForm();
    });

    function resetForm() {
        $('#studentForm')[0].reset();
        $('#studentId').val('');
        $('#formTitle').text('Thêm sinh viên mới');
        $('#cancelBtn').hide();
    }
});