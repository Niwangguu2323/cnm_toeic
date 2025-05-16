<?php
require_once __DIR__ . '/../../models/ExamModel.php';

$model = new ExamModel();
$model->xuatDuLieu("SELECT * FROM exam"); 
?>
