<?php
require '../../views/user/pages/userFeedbackView.php';
require '../../models/user/userFeedbackModel.php';
session_start();

$userFeedbackModel = new userFeedbackModel(require '../../config/db_connection.php');

$feedbacks = $userFeedbackModel->getAllFeedbacks();
$userFeedbackView = new userFeedbackView($feedbacks);
$userFeedbackView->renderView();
