<?php

class UserTrackBMIView {
    /** BMI data. */
    private $bmiDataArray;
    
    /** Constructor for the object. */
    public function __construct($bmiDataArray) {
        $this->bmiDataArray = $bmiDataArray;
    }

    /** Renders the whole view. */
    public function renderView() : void {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    /** Renders the header. */
    public function renderHeader() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userHeader.php';
    }

    /** Renders the navbar. */
    public function renderNavbar() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userNavbar.php';
    }

    /** Renders the footer. */
    public function renderFooter() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userFooter.php';
    }

    /** Renders ONE card of BMI data. */
    private function renderOneBMIDataRow($bmiID) {?>
    <div id=<?php echo $bmiID; ?> class="basis-32 bg-gray-400 flex items-center border-b-2 border-gray-mid shrink-0 hover:bg-gray-400 cursor-pointer" onclick="openEditBMIDataModal(<?php echo $bmiID . ')';?>">
        <img src="../../public/images/track_bmi_icon.png" class="w-16 h-16 mx-8">
        <div class="flex-col">
            <p id=<?php echo '"' . $bmiID . 'Text"'; ?> class="mb-0 text-white font-bold text-lg drop-shadow-dark"></p>
        </div>
    </div>
    <?php
    }

    /** Renders bmi data partial view. */
    private function renderBMIDataPartialView() {?>
    <div class="flex min-h-192 max-h-192">
        <div class="mx-auto basis-192 border-2 bg-white flex flex-col border-gray-dove overflow-auto <?php if (sizeof($this->bmiDataArray) == 0) { echo "justify-center";}?>">
            <?php
            if (sizeof($this->bmiDataArray) > 0) {
                foreach ($this->bmiDataArray as $key => $value) {
                    $this->renderOneBMIDataRow($value['bmiID']);
                }
            } else if (date($_GET['date']) === date('Y-m-d')) {
                echo '<p class="text-black font-bold text-3xl mx-auto" style="opacity: 0.2;">You did not measure your BMI today :&#40;</p>';
            }
            
            ?>
        </div>
    </div>
    <?php
    }

    /** Renders the date pagination. */
    public function renderDatePagination() {?>
    <div class="flex items-center mb-14">
        <div class="mx-auto flex items-center text-3xl justify-center basis-96">
            <input type="button" id="previousDate" name="previousDate" value="<" class="p-4" onclick="previousDate()">

            <input type="date" id="dateOfBMI" name="dateOfBMI"
            value=<?php echo '"' . $_GET['date'] . '"';?> class="bg-slate-100 w-72 rounded py-1 border-2" oninput="redirectTrackBMIPage()"
            max=<?php echo '"' . date('Y-m-d') . '"';?>
            >
            
            <?php 
            if (date($_GET['date']) !== date('Y-m-d')) {?>
            <input type="button" id="nextDate" name="nextDate" value=">" class="p-4" onclick="nextDate()">
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }

    /** Renders the content. */
    public function renderContent(): void {?>
    <section class="font-montserrat bg-blue-user flex flex-col pt-20 pb-48 justify-center">
        <h1 class="text-4xl font-bold mx-auto mb-20">Track BMI</h1>

        <div class="flex min-h-64 mb-32">
            <div class="mx-auto basis-256 bg-gray-400 rounded-2xl flex flex-col items-center">
                <img src="../../public/images/track_bmi_icon.png" class="w-16 h-16 mb-10" style="margin-top: 20px;">
                <div class="text-white font-bold text-3xl drop-shadow-dark text-center">
                    <p class="mb-0" id="bmiStatusMessage"></p>
                    <p class="mb-0" id="bmiEncouragementMessage"></p>
                </div>
            </div>
        </div>

        
        <?php $this->renderDatePagination(); ?>

        <?php $this->renderBMIDataPartialView(); ?>
                
            
        <div class="flex mt-4 mb-20">
            <input type="button" value="Add" class="bg-white hover:bg-gray-light drop-shadow-dark rounded-4xl font-bold mx-auto px-8 py-4 cursor-pointer" onclick="openAddBMIDataModal()">
        </div>
        
        

    </section>

    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10"></div>


    <div id="bmiDataModal" class="absolute inset-0 flex items-center justify-center z-20 top-296 modal hidden font-montserrat">
        <div class="flex flex-col items-center bg-gray-400 w-full rounded-2xl shadow-lg modal-content basis-144 min-h-144">
            <img src="../../public/images/track_bmi_icon.png" class="w-16 h-16 mt-10 mb-5">
            <h2 id="modalTitle" class="text-3xl text-white font-bold drop-shadow-dark mb-5"></h2>
            <hr class="w-full mb-5">
            <form action="<?php echo $_SERVER['PHP_SELF'] . "?date=" . $_GET['date']; ?>" method="POST">
                <input type="hidden" id="bmiID" name="bmiID">

                <div class="flex mt-8 min-w-100 items-between">
                    <div class="flex flex-col justify-between text-white drop-shadow-dark font-semibold text-2xl">
                        <label for="age">Age:</label>
                        <label for="gender">Gender:</label>
                        <label for="height">Height:</label>
                        <label for="weight">Weight:</label>
                        <label for="time">Time:</label>
                    </div>
                    <div class="flex flex-col justify-between min-h-40">
                        <input type="number" id="age" name="age" class="border-2 rounded-lg">
                        <div class="flex">
                            <input type="radio" id="maleRadio" name="gender" value="male" class="border-2 rounded-lg">
                            <label for="gender">Male</label>
                            <input type="radio" id="femaleRadio" name="gender" value="female" class="border-2 rounded-lg">
                            <label for="gender">Female</label>
                        </div>
                        <div class="flex">
                            <input type="text" id="height" name="height" class="border-2 rounded-lg">
                            <select name="heightUnit" id="heightUnit" class="bg-white rounded-lg border-2 text-shadow-dark text-black">
                                <option value="m" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "m") { echo "selected"; }?>>Meters (m)</option>
                                <option value="cm" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "cm") { echo "selected"; }?>>Centimeters (cm)</option>
                                <option value="ft" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "ft") { echo "selected"; }?>>Foot (ft)</option>
                            </select>
                        </div>
                        <div class="flex">
                            <input type="text" id="weight" name="weight" class="border-2 rounded-lg">
                            <select name="weightUnit" id="weightUnit" class="bg-white rounded-lg border-2 text-shadow-dark text-black">
                                <option value="Kg" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "Kg") { echo "selected"; }?>>Kilograms (Kg)</option>
                                <option value="g" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "g") { echo "selected"; }?>>Grams (g)</option>
                                <option value="lb" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "lb") { echo "selected"; }?>>Foot (ft)</option>
                            </select>
                        </div>
                        <input type="time" id="time" name="time" class="rounded-lg border2">
                    </div>
                    

                </div>

                <div class="flex flex-row-reverse justify-center mt-28 mb-14">
                    <input type="submit" id="submitBMIDataButton" name="submitBMIDataButton" value="" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                    <input type="button" id="deleteBMIDataButton" name="deleteBMIDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 hidden rounded-lg shadow-lg mr-2 cursor-pointer" onclick="openDeleteConfirmationModal()">
                    <input type="button" value="Close" onclick="closeBMIDataModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                </div>

                <div id="confirmationModal" class="absolute inset-0 flex items-center justify-center hidden z-30 modal font-montserrat">
                    <div class="flex flex-col items-center justify-center bg-white w-full rounded-2xl shadow-lg modal-content basis-96 min-h-64">
                        
                        <h2 id="confirmationModalTitle" class="text-3xl text-black font-bold mb-5 text-center">Are you sure you want to delete this BMI data?</h2>
                        <div class ="flex flex-row-reverse">
                            <input type="submit" id="submitDeleteBMIDataButton" name="submitDeleteBMIDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                            <input type="button" value="Close" onclick="closeConfirmationModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

        <style>
            .modal {
                transition: opacity 0.3s ease, transform 0.3s ease;
                opacity: 0;
                transform: scale(0.9);
                pointer-events: none;
            }

            .modal.show {
                opacity: 1;
                transform: scale(1);
                pointer-events: auto;
            }
        </style>
    
    <!-- Embed php array of ids of the bmi data rows to be used to convert the amount drank based on unit. -->
    <input type="hidden" id="phpArrayOfBMIData" value="
    <?php 
    echo htmlspecialchars(json_encode($this->bmiDataArray));
    ?>
    ">
    <!-- Embed php current pagination. -->
    <input type="hidden" id="currentPaginationDate" value="
    <?php 
    echo htmlspecialchars(json_encode($_GET['date']));
    ?>
    ">

    <script src="../../public/js/user/userTrackBMIScript.js">
    </script>
    <?php
    }
}