<?php
require_once __DIR__ . '/../../models/ExamModel.php';

$model = new ExamModel();
$exam_id = $_REQUEST["id"];
$model->xuatDuLieu("SELECT * FROM exam_question where exam_id='$exam_id'"); 
?>
