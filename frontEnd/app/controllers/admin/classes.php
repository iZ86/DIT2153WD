<?php
// Include necessary view and model files
require '../../views/admin/pages/adminClassesView.php';
require '../../models/admin/adminClassesModel.php';

// Start a new session or resume the existing session
session_start();

// Check if the admin is logged in, if not redirect to the login page
if (!isset($_SESSION['adminID'])) {
    header("Location: ../../controllers/login.php");
    exit;
}

// Instantiate the AdminClassesModel with the database connection
$adminClassesModel = new AdminClassesModel(require '../../config/db_connection.php');

// Check if the request method is POST to handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the "Add Class" form submission
    if (isset($_POST['addClassButton']) && $_POST['addClassButton'] === "Add Class") {
        // Retrieve and trim form input values
        $name = trim($_POST['name']);
        $price = trim($_POST['price']);
        $description = trim($_POST['description']);
        $imagePath = '';

        // Check if an image file is uploaded
        if (!empty($_FILES['classImage']['name'])) {
            $targetDir = "../../public/images/classImages/";

            // Create the directory if it doesn't exist
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Define the target file path for the uploaded image
            $originalFileName = basename($_FILES['classImage']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            // Validate if the uploaded file is an image
            $check = getimagesize($_FILES['classImage']['tmp_name']);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            // Allow only certain file types for the image
            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileType), $allowedTypes)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['classImage']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        // Check if all required fields are filled
        if (!empty($name) && !empty($price) && !empty($description)) {
            // Add the new class using the model
            $adminClassesModel->addClass($name, $price, $description, $imagePath);

            // Set a success message in the session
            $_SESSION['successMessage'] = "Added new class successfully.";

            // Redirect to the same page to avoid form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Handle the "Edit Class" form submission
    if (isset($_POST['editClassButton']) && $_POST['editClassButton'] === "Edit Class") {
        // Retrieve and trim form input values
        $fitnessClassID = $_POST['fitnessClassID'];
        $name = trim($_POST['name']);
        $price = trim($_POST['price']);
        $description = trim($_POST['description']);
        $imagePath = '';

        // Check if a new image file is uploaded
        if (!empty($_FILES['classImage']['name'])) {
            $targetDir = "../../public/images/classImages/";

            // Create the directory if it doesn't exist
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Define the target file path for the uploaded image
            $originalFileName = basename($_FILES['classImage']['name']);
            $targetFilePath = $targetDir . $originalFileName;

            // Validate if the uploaded file is an image
            $check = getimagesize($_FILES['classImage']['tmp_name']);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            // Allow only certain file types for the image
            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileType), $allowedTypes)) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['classImage']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        // Check if all required fields are filled
        if (!empty($fitnessClassID) && !empty($name) && !empty($price) && !empty($description)) {
            // Edit the class using the model
            $adminClassesModel->editClass($fitnessClassID, $name, $price, $description, $imagePath);

            // Set a success message in the session
            $_SESSION['successMessage'] = "Edited class record successfully.";

            // Redirect to the same page to avoid form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Handle the "Add Schedule" form submission
    if (isset($_POST['addScheduleButton']) && $_POST['addScheduleButton'] === "Add Schedule") {
        // Retrieve form input values
        $fitnessClassID = $_POST['fitnessClassID'];
        $scheduledOnDate = $_POST['scheduledOnDate'];
        $scheduledOnTime = $_POST['scheduledOnTime'];
        $pax = $_POST['pax'];
        $instructorID = $_POST['instructorID'];

        // Combine date and time into a single datetime string
        $scheduledOn = $scheduledOnDate . ' ' . $scheduledOnTime;

        // Check if all required fields are filled
        if (!empty($fitnessClassID) && !empty($scheduledOn) && !empty($pax) && !empty($instructorID)) {
            // Add the new schedule using the model
            $adminClassesModel->addSchedule($fitnessClassID, $scheduledOn, $pax, $instructorID);

            // Set a success message in the session
            $_SESSION['successMessage'] = "Added new schedule successfully.";

            // Redirect to the same page to avoid form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Handle the "Edit Schedule" form submission
    if (isset($_POST['editScheduleButton'])) {
        // Retrieve form input values
        $fitnessClassScheduleID = $_POST['fitnessClassScheduleID'];
        $fitnessClassID = $_POST['fitnessClassID'];
        $instructorID = $_POST['instructorID'];
        $pax = $_POST['pax'];
        $scheduledOnDate = $_POST['scheduledOnDate'];
        $scheduledOnTime = $_POST['scheduledOnTime'];

        // Combine date and time into a single datetime string
        $scheduledOn = $scheduledOnDate . ' ' . $scheduledOnTime;

        // Edit the schedule using the model
        $adminClassesModel->editSchedule($fitnessClassScheduleID, $fitnessClassID, $scheduledOn, $pax, $instructorID);

        // Set a success message in the session
        $_SESSION['successMessage'] = "Edited class schedule records successfully.";

        // Redirect to the same page to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Pagination logic
$limit = 10; // Number of records per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page number
$offset = ($currentPage - 1) * $limit; // Calculate offset for SQL query

// Filter classes based on selected filter type and keywords
$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '';
$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';

if (!empty($filterType)) {
    if ($filterType === 'name') {
        // Fetch classes filtered by name
        $classes = $adminClassesModel->getFilteredClassesByName($keywords, $limit, $offset);
    } elseif ($filterType === 'description') {
        // Fetch classes filtered by description
        $classes = $adminClassesModel->getFilteredClassesByDescription($keywords, $limit, $offset);
    }
} else {
    // Fetch all classes without filters
    $classes = $adminClassesModel->getClasses($limit, $offset);
}

// Filter schedules based on selected filter type and keywords
$scheduleFilterType = isset($_GET['scheduleFilterType']) ? $_GET['scheduleFilterType'] : '';
$scheduleKeywords = isset($_GET['scheduleKeywords']) ? $_GET['scheduleKeywords'] : '';

if (!empty($scheduleFilterType)) {
    // Fetch schedules based on filter criteria
    $schedules = $adminClassesModel->getFilteredSchedules($limit, $offset, $scheduleFilterType, $scheduleKeywords);
} else {
    // Fetch all schedules without filters
    $schedules = $adminClassesModel->getSchedules($limit, $offset);
}

// Check if no classes or schedules were found
$noClassesFound = $classes->num_rows === 0;
$noSchedulesFound = $schedules->num_rows === 0;

// Retrieve all instructors for dropdown selections
$instructors = $adminClassesModel->getAllInstructors();

// Calculate total pages for pagination
$totalClasses = $adminClassesModel->getTotalClasses();
$totalSchedules = $adminClassesModel->getTotalSchedules();
$totalPagesClasses = ceil($totalClasses / $limit);
$totalPagesSchedules = ceil($totalSchedules / $limit);

// Instantiate the view and render it
$adminClassesView = new AdminClassesView($classes, $schedules, $instructors, $totalPagesClasses, $totalPagesSchedules, $currentPage, $noClassesFound, $noSchedulesFound);
$adminClassesView->renderView();