<?php
require_once __DIR__ . '/../config/db.php';

class ReadingModel {
    private $conn;

    public function __construct() {
        $db = new ketnoi();
        $this->conn = $db->moketnoi();
    }

    public function getAllPassages() {
        $sql = "SELECT passage_id, exam_id, LEFT(content, 300) AS preview FROM reading_passage";
        $result = mysqli_query($this->conn, $sql);
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
}
