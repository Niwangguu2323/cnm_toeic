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
        // Trích xuất dữ liệu từ mảng $data
        $question_id = $data['question_id'];
        $content = $data['content'];
        $correct_answer = $data['correct_answer'];
        $option_1 = $data['option_1'];
        $option_2 = $data['option_2'];
        $option_3 = $data['option_3'];
        $option_4 = $data['option_4'];

        $sql = "UPDATE exam_question 
                SET content = ?, 
                    correct_answer = ?, 
                    option_1 = ?, 
                    option_2 = ?, 
                    option_3 = ?, 
                    option_4 = ?
                WHERE question_id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["error" => "Lỗi prepare: " . $this->conn->error]);
            return false;
        }

        $stmt->bind_param(
            "ssssssi",
            $content,
            $correct_answer,
            $option_1,
            $option_2,
            $option_3,
            $option_4,
            $question_id
        );

        if ($stmt->execute()) {
            // Kiểm tra xem có hàng nào bị ảnh hưởng không
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Không có dữ liệu nào được cập nhật"]);
                return false;
            }
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Lỗi execute: " . $stmt->error]);
            return false;
        }
    }

    public function insertExam($data) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // 1. Thêm bài thi vào bảng exam
            $sql = "INSERT INTO exam (title, type, duration_minutes, difficulty_level) 
                    VALUES (?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi prepare khi thêm bài thi: " . $this->conn->error);
            }
            
            $stmt->bind_param(
                "ssii",
                $data['title'],
                $data['type'],
                $data['duration_minutes'],
                $data['difficulty_level']
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi execute khi thêm bài thi: " . $stmt->error);
            }
            
            // Lấy ID bài thi vừa thêm
            $exam_id = $this->conn->insert_id;
            
            // 2. Thêm các câu hỏi vào bảng exam_question nếu có
            if (!empty($data['questions'])) {
                $question_sql = "INSERT INTO exam_question (exam_id, content, correct_answer, option_1, option_2, option_3, option_4) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                $question_stmt = $this->conn->prepare($question_sql);
                if (!$question_stmt) {
                    throw new Exception("Lỗi prepare khi thêm câu hỏi: " . $this->conn->error);
                }
                
                foreach ($data['questions'] as $question) {
                    $question_stmt->bind_param(
                        "issssss",
                        $exam_id,
                        $question['content'],
                        $question['correct_answer'],
                        $question['option_1'],
                        $question['option_2'],
                        $question['option_3'],
                        $question['option_4']
                    );
                    
                    if (!$question_stmt->execute()) {
                        throw new Exception("Lỗi execute khi thêm câu hỏi: " . $question_stmt->error);
                    }
                }
                
                $question_stmt->close();
            }
            
            // Commit transaction nếu mọi thứ OK
            $this->conn->commit();
            
            return [
                "success" => true,
                "exam_id" => $exam_id,
                "message" => "Thêm bài thi thành công"
            ];
            
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->conn->rollback();
            
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }
    
    // Hàm xóa bài thi
    public function deleteExam($exam_id) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();
        
        try {
            // 1. Xóa các câu hỏi liên quan đến bài thi
            $delete_questions_sql = "DELETE FROM exam_question WHERE exam_id = ?";
            $delete_questions_stmt = $this->conn->prepare($delete_questions_sql);
            
            if (!$delete_questions_stmt) {
                throw new Exception("Lỗi prepare khi xóa câu hỏi: " . $this->conn->error);
            }
            
            $delete_questions_stmt->bind_param("i", $exam_id);
            
            if (!$delete_questions_stmt->execute()) {
                throw new Exception("Lỗi execute khi xóa câu hỏi: " . $delete_questions_stmt->error);
            }
            
            $delete_questions_stmt->close();
            
            // 2. Xóa bài thi
            $delete_exam_sql = "DELETE FROM exam WHERE exam_id = ?";
            $delete_exam_stmt = $this->conn->prepare($delete_exam_sql);
            
            if (!$delete_exam_stmt) {
                throw new Exception("Lỗi prepare khi xóa bài thi: " . $this->conn->error);
            }
            
            $delete_exam_stmt->bind_param("i", $exam_id);
            
            if (!$delete_exam_stmt->execute()) {
                throw new Exception("Lỗi execute khi xóa bài thi: " . $delete_exam_stmt->error);
            }
            
            // Kiểm tra xem có bài thi nào bị xóa không
            if ($delete_exam_stmt->affected_rows == 0) {
                throw new Exception("Không tìm thấy bài thi với ID: " . $exam_id);
            }
            
            $delete_exam_stmt->close();
            
            // Commit transaction nếu mọi thứ OK
            $this->conn->commit();
            
            return [
                "success" => true,
                "message" => "Xóa bài thi thành công"
            ];
            
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->conn->rollback();
            
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
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
    public function getAllFullExams() {
        $sql = "SELECT exam_id, title, type, duration_minutes, difficulty_level 
                FROM exam 
                WHERE type = 'full'";
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
