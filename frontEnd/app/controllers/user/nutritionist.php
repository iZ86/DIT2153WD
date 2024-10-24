<?php
require_once '../../models/nutritionistModel.php';
require_once '../../views/user/pages/userNutritionistsView.php';

$nutritionistModel = new NutritionistModel(require '../../config/db_connection.php');
$nutritionistsView = new NutritionistsView($nutritionistModel->getAllNutritionist());

$nutritionistsView();
/** Function to get the total number of nutritionists. */
function getTotalNutritionist() {
    global $nutritionistModel;
    return $nutritionistModel->countTotal();
}

/** Function to return a nutritionist by their ID. */
function getNutritionistById(int $id) { 
    global $nutritionistModel; 
    return $nutritionistModel->getById($id);
}   

/** Funtion to return all the nutritionists information that is going to show to the user. */
function userNutritionist() {
    global $nutritionistsView; 
    if ($nutritionistsView !== null) {
        return $nutritionistsView->__invoke();
    }
    return null; 
}
