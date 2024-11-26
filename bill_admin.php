<?php
include './authMiddlware.php';
// Kiểm tra quyền truy cập,1 là tài khoản quản lý, 0 là tài khoản người dùng
if (!checkLoginAndPermission(1)) {
    echo "<script>alert('Bạn không có quyền truy cập vào trang này.'); windown.location.back();</script>";
    exit();
}
?>
<?php include "headerquantri.php"; ?>
<?php
include "thuvien.php";
include "function_bill_admin.php";
$bill = new bill();
$result = $bill->hienthi();
$count = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .container {
            background-color: sandybrown;
            padding-bottom: 10px;
        }

        .container th,
        .container tr,
        .container h2,
        .container td {
            color: black;
            border-color: black;
        }

        .container th {
            text-align: center;
            background-color: yellowgreen;
            border-color: black !important;
        }

        .container h2 {
            text-align: center;
            width: 100%;
            padding-top: 10px;
            font-weight: 700;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 30px;
        }

        .container td {
            background-color: white;
        }

        .container button:hover {
            background-color: yellow;
            color: black;

        }

        .container button {
            border-radius: 7px;

            margin-left: 250px;
            margin-top: 10px;
            font-size: 15px;
        }

        .container td {
            background-color: white;
        }

        .container button:hover {
            background-color: yellow;
            color: black;

        }

        .container button {
            border-radius: 7px;

            margin-left: 2000px !important;
            margin-top: 10px;
            font-size: 15px;
        }

        .example {
            padding: 0px 20px 0px 20px;
        }

        .table {
            padding: 0px 150px 0px 270px !important;
            font-size: 22px;
        }

        th,
        td {
            padding: 10px !important;
        }
    </style>
</head>

<body>

    <div class="example">
        <div class="container">
            <div class="row">
                <h2>Quản Lý Thông Tin Đơn Đặt Hàng</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Tel</th>
                            <th>Email</th>
                            <th>Thanh Toán</th>
                            <th>Trạng thái</th>
                            <th></th>
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <?PHP echo $row["id"] ?>
                                    </td>
                                    <td>
                                        <?PHP echo $row["name"] ?>
                                    </td>
                                    <td>
                                        <?PHP echo $row["address"] ?>
                                    </td>
                                    <td>
                                        <?PHP echo $row["tel"] ?>
                                    </td>
                                    <td>
                                        <?PHP echo $row["email"] ?>
                                    </td>
                                    <td>
                                        <?PHP echo $row["total"] * 1000 ?>
                                    </td>
                                    <td>
                                        <select name="status" class="form-control status-select" data-id="<?php echo $row['id']; ?>">
                                            <option value="Chưa Duyệt" <?php if ($row['trangthai'] === 'Chưa Duyệt') echo 'selected'; ?>>
                                                Chưa Duyệt
                                            </option>
                                            <option value="Đã Duyệt" <?php if ($row['trangthai'] === 'Đã Duyệt') echo 'selected'; ?>>
                                                Đã Duyệt
                                            </option>
                                            <option value="Đang Giao" <?php if ($row['trangthai'] === 'Đang Giao') echo 'selected'; ?>>
                                                Đang Giao
                                            </option>
                                            <option value="Đã Giao" <?php if ($row['trangthai'] === 'Đã Giao') echo 'selected'; ?>>
                                                Đã Giao
                                            </option>
                                           
                                        </select>
                                    </td>
                                    <!-- <td>
                                   
                                </td> -->
                                    <td>
                                        <a href="xoabill.php?id=<?PHP echo $row["id"] ?>" style="text-decoration: none">Hủy đơn</a>
                                    </td>
                                    <!-- <td>
                                   <a href="" style="text-decoration: none">Đã Vận Chuyển</a>
                                </td> -->
                                </tr>

                        <?PHP
                            }
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy tất cả các select có class status-select
        const statusSelects = document.querySelectorAll('.status-select');

        statusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                const status = this.value;

                // Tạo object FormData
                const formData = new FormData();
                formData.append('id', id);
                formData.append('trangthai', status);

                // Gửi request đến file xử lý PHP
                fetch('update_trangthai.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            alert('Cập nhật trạng thái thành công!');
                        } else {
                            alert('Có lỗi xảy ra khi cập nhật trạng thái!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra!');
                    });
            });
        });
    });
</script>

</html>