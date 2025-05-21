<?php
require_once __DIR__ . '/../config/db.php';

class ExamModel {
    public $conn;

    public function __construct() {
        $db = new ketnoi();
        $this->conn = $db->moketnoi();
    }
    public function getConn() {
    return $this->conn;
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

    public function updateQuestion($data) {
        $sql = "UPDATE exam_question 
                SET content = ?, 
                    audio_url = ?, 
                    correct_answer = ?, 
                    option_1 = ?, 
                    option_2 = ?, 
                    option_3 = ?, 
                    option_4 = ?, 
                    passage_id = ?,
                    listening_id = ?
                WHERE question_id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["error" => "Lỗi prepare: " . $this->conn->error]);
            return false;
        }

        $stmt->bind_param(
            "sssssssiii",
            $data['content'],
            $data['audio_url'],
            $data['correct_answer'],
            $data['option_1'],
            $data['option_2'],
            $data['option_3'],
            $data['option_4'],
            $data['passage_id'],
            $data['question_id'],
            $data['listening_id']
        );

        if ($stmt->execute()) {
            return true;
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Lỗi execute: " . $stmt->error]);
            return false;
        }
    }

    public function getAllExams() {
    $sql = "SELECT exam_id, title, type, duration_minutes, difficulty_level FROM exam";
    $result = mysqli_query($this->conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($this->conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}
    public function getAllReadingExams() {
        $sql = "SELECT exam_id, title, type, duration_minutes, difficulty_level 
                FROM exam 
                WHERE type = 'Reading'";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($this->conn));
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
    public function getAllListeningExams() {
        $sql = "SELECT exam_id, title, type, duration_minutes, difficulty_level 
                FROM exam 
                WHERE type = 'Listening'";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($this->conn));
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
}
