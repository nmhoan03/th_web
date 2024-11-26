<?php 

include "ketnoi.php";

class bill extends ketnoi{
    public $id;
    public $name;
    public $address;
    public $tel;
    public $email;
    public $total;
    public $pttt;
    
    function hienthi(){
        $sql = "SELECT * FROM `bill` ";
        $result = mysqli_query($this->conn,$sql);
        return $result;
    }
    function hienthi_bill($id){
        $sql = "SELECT * FROM bill    WHERE id = '$id'";
        $result = mysqli_query($this->conn,$sql);
        return $result;
    
    }
    function delete_bill($id){
        $sql = "DELETE FROM `bill` WHERE id = '$id'";
        $result = mysqli_query($this->conn, $sql);
    
        if($result) {
            // Xóa cả các sản phẩm trong cart liên quan đến bill này
            $sql_delete_cart = "DELETE FROM `cart` WHERE idbill = '$id'";
            mysqli_query($this->conn, $sql_delete_cart);
            
            echo "<script>alert('Đã hủy đơn hàng và gửi thông báo đến khách hàng')</script>";
            echo "<script>window.history.back()</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra')</script>";
        }
    }

    function update_trangthai($id, $trangthai) {
        $sql = "UPDATE bill SET trangthai = '$trangthai' WHERE id = $id";
        $result = mysqli_query($this->conn, $sql);
        
        if($result) {
            return true;
        }
        return false;
    }

}

?>