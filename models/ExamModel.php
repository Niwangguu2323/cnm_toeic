<?php
require_once __DIR__ . '/../config/db.php';

class ExamModel {
    private $conn;

    public function __construct() {
        $db = new toeic();
        $this->conn = $db->ketnoi();
    }

    public function xuatDuLieu($sql) {
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            http_response_code(500);
            echo json_encode(["error" => "Truy vấn thất bại: " . mysqli_error($this->conn)]);
            return;
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }

}
