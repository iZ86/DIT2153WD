<?php
require '../../models/nutritionistModel.php';
require '../../views/user/pages/userNutritionistsView.php';

$nutritionistModel = new NutritionistModel(require '../../config/db_connection.php');
$nutritionistsView = new NutritionistsView($nutritionistModel->getAllNutritionist());

$nutritionistsView->renderView();

/** Function to return a nutritionist by their ID. */
function getNutritionistById(int $id) { 
    global $nutritionistModel; 
    return $nutritionistModel->getById($id);
} 