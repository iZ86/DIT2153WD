<?php

class UserTrackWaterConsumptionView {
    /** Water consumption data. */
    private $waterConsumptionDataArray;
    
    /** Constructor for the object. */
    public function __construct($waterConsumptionDataArray) {
        $this->waterConsumptionDataArray = $waterConsumptionDataArray;
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

    /** Renders ONE card of water consumption data. */
    private function renderOneWaterConsumptionDataRow($waterConsumptionDataID, $waterConsumptionDataLitres, $waterConsumptionDataRecordedOnTime) {?>
    <div class="basis-32 bg-blue-vivid flex items-center border-b-2 border-gray-mid shrink-0 hover:bg-blue-mid cursor-pointer">
        <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mx-8">
        <div class="flex-col">
            <p id=<?php echo '"' . $waterConsumptionDataID . '"'; ?> class="mb-0 text-white font-bold text-lg drop-shadow-dark"><?php echo "You have drank " . $waterConsumptionDataLitres . " at " . $waterConsumptionDataRecordedOnTime;?></p>
        </div>
    </div>
    <?php
    }

    /** Renders water consumption data partial view. */
    private function renderWaterConsumptionDataPartialView() {?>
    <div class="flex min-h-192 max-h-192">
        <div class="mx-auto basis-192 border-2 bg-white flex flex-col border-gray-dove overflow-auto <?php if (sizeof($this->waterConsumptionDataArray) == 0) { echo "justify-center";}?>">
            <?php
            if (sizeof($this->waterConsumptionDataArray) > 0) {
                for ($i = 0; $i < sizeof($this->waterConsumptionDataArray); $i++) {
                    $this->renderOneWaterConsumptionDataRow($this->waterConsumptionDataArray[$i]['waterConsumptionID'], $this->waterConsumptionDataArray[$i]['milliliters'], $this->waterConsumptionDataArray[$i]['recordedOnTime']);
                }
            } else if (date($_GET['date']) === date('Y-m-d')) {
                echo '<p class="text-black font-bold text-3xl mx-auto" style="opacity: 0.2;">You have not drank any water today :&#40;</p>';
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

        <input type="date" id="dateOfWaterConsumption" name="dateOfWaterConsumption"
        value=<?php echo '"' . $_GET['date'] . '"';?> class="bg-slate-100 w-72 rounded py-1 border-2" oninput="redirectTrackWaterConsumptionPage()"
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
        <h1 class="text-4xl font-bold mx-auto mb-20">Track Water Consumption</h1>

        <div class="flex min-h-64 mb-32">
            <div class="mx-auto basis-256 bg-blue-vivid rounded-2xl flex flex-col items-center">
                <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mb-10" style="margin-top: 20px;">
                <div class="text-white font-bold text-3xl drop-shadow-dark">
                    <p class="mb-0">Yo have drank [5L] today!</p>
                    <p class="mb-0">[Keep up the good work!]</p>
                </div>
            </div>
        </div>

        
        <?php $this->renderDatePagination(); ?>
        
        <div class="flex items-center mb-14">
            <div class="mx-auto flex items-center text-3xl justify-center basis-96">
                <select name="unit" id="amountDrankUnit" class="bg-white rounded-lg border-2 text-shadow-dark text-black bg-slate-100 w-72 rounded py-1 border-2" oninput="convertAmountDrankOfAllWaterConsumptionDataRow('amountDrankUnit');createSessionForUnitSelected('amountDrankUnit')">
                    <option value="mL" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "mL") { echo "selected"; }?>>Milliliters (mL)</option>
                    <option value="L" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "L") { echo "selected"; }?>>Liters (L)</option>
                    <option value="oz" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "oz") { echo "selected"; }?>>Ounces (oz)</option>
                </select>
            </div>
        </div>

        <?php $this->renderWaterConsumptionDataPartialView(); ?>
                
            
        <div class="flex mt-4 mb-20">
            <input type="button" value="Add" class="bg-white hover:bg-gray-light drop-shadow-dark rounded-4xl font-bold mx-auto px-8 py-4 cursor-pointer" onclick="openAddWaterConsumptionModal()">
        </div>
        
        

    </section>

    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10"></div>


    <div id="addWaterConsumptionModal" class="absolute inset-0 flex items-center justify-center hidden z-20 top-328 modal font-montserrat">
        <div class="flex flex-col items-center bg-blue-vivid w-full rounded-2xl shadow-lg modal-content basis-144 min-h-128">
            <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mt-10 mb-5">
            <h2 id="modalTitle" class="text-3xl text-white font-bold drop-shadow-dark mb-5">Add Water Consumption Data</h2>
            <hr class="w-full mb-5">
            <form action="<?php echo $_SERVER['PHP_SELF'] . "?date=" . $_GET['date']; ?>" method="POST">
                    

                <div class="flex mt-8 justify-between min-w-100">
                    <div class="flex flex-col justify-between items-end gap-y-2 font-semibold text-2xl">
                        <div class="flex">
                            

                            <select name="unit" id="unit" class="bg-white rounded-lg border-2 text-shadow-dark text-black" oninput="convertAmountDrankOfAllWaterConsumptionDataRow('unit');createSessionForUnitSelected('unit')">
                                <option value="mL" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "mL") { echo "selected"; }?>>Milliliters (mL)</option>
                                <option value="L" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "L") { echo "selected"; }?>>Liters (L)</option>
                                <option value="oz" <?php if (isset($_SESSION['unit']) && $_SESSION['unit'] === "oz") { echo "selected"; }?>>Ounces (oz)</option>
                            </select>
                            <label for="amountDrank" class="text-white drop-shadow-dark">:</label>
                        </div>

                        <label for="time" class="text-white drop-shadow-dark">Time:</label>

                    </div>

                    <div class="flex flex-col gap-y-2 justify-between">
                        <input type="number" id="amountDrank" name="amountDrank" class="rounded-lg border-2">
                        <input type="time" id="time" name="time" class="rounded-lg border-2">
                    </div>

                </div>

                <div class="flex justify-center mt-28">
                    <input type="button" value="Close" onclick="closeAddWaterConsumptionModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                    <input type="submit" name="addWaterConsumptionDataButton" value="Add" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg cursor-pointer">
                    <input type="submit" name="deleteWaterConsumptionDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 hidden rounded-lg shadow-lg cursor-pointer">
                    <input type="submit" name="saveWaterConsumptionDataButton" value="Save" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 hidden rounded-lg shadow-lg cursor-pointer">
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
    
    <!-- Embed php array of ids of the water consumption data rows to be used to convert the amount drank based on unit. -->
     <input type="hidden" id="phpArrayOfWaterConsumptionData" value="
     <?php 
     echo htmlspecialchars(json_encode($this->waterConsumptionDataArray));
     ?>
     ">

    <script src="../../public/js/user/userTrackWaterConsumptionScript.js">
    </script>
    <?php
        // If there is a 'unit' saved in the session, automatically convert the amount drank in water consumption data row to the corrct unit.
        // This is used to "save" the unit the user has chosen.
        if (isset($_SESSION['unit']) && ($_SESSION['unit'] === "mL" || $_SESSION['unit'] === "L" || $_SESSION['unit'] === "oz")) {
                echo "<script> convertAmountDrankOfAllWaterConsumptionDataRow('amountDrankUnit'); </script>";
        }
    }
}