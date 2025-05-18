<?php
class ketnoi {
    public function moketnoi() {
        $conn = mysqli_connect('localhost', 'root', '');
        if (!$conn) {
            echo "Kết nối dữ liệu thất bại";
            return null;
        } else {
            mysqli_select_db($conn, "toeicdb");
            mysqli_query($conn, "SET NAMES 'utf8'");
            return $conn;
        }
    }
}
?>
