<?php
include "thuvien.php";
include "function_bill_admin.php";

if(isset($_POST['id']) && isset($_POST['trangthai'])) {
    $bill = new bill();
    $id = $_POST['id'];
    $trangthai = $_POST['trangthai'];
    
    // Kiểm tra trạng thái hợp lệ
    $allowedStatuses = ['Chưa Duyệt', 'Đã Duyệt', 'Đang Giao','Đã Giao'];
    if(!in_array($trangthai, $allowedStatuses)) {
        echo 'error';
        exit;
    }
    
    if($bill->update_trangthai($id, $trangthai)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>