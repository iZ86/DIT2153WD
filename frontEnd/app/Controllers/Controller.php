<?php
require_once __DIR__ . '/../Models/nutritionistModel.php';

class Controller {
    private $nutritionistModel;

    public function __construct($databaseConn) {
        $this->nutritionistModel = new NutritionistModel($databaseConn);
    }   

    // Function to get the total number of nutritionists
    public function getTotalNutritionist() {
        return $this->nutritionistModel->countTotal();
    }

    // Function to get a nutritionist by their ID
    public function getNutritionistById(int $id) {  
        return $this->nutritionistModel->getById($id);
    }   
}