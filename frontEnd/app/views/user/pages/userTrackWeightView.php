<?php

class UserTrackWeightView {
    /** Weight data. */
    private $weightDataset;
    
    /** Constructor for the object. */
    public function __construct($weightDataset) {
        $this->weightDataset = $weightDataset;
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

    /** Renders ONE card of weightdata. */
    private function renderOneWeightDataRow($weightID) {?>
    <div id=<?php echo $weightID; ?> class="basis-32 bg-yellow-500 flex items-center border-b-2 border-gray-mid shrink-0 hover:bg-yellow-700 cursor-pointer" onclick="openEditWeightDataModal(<?php echo $weightID . ')';?>">
        <img src="../../public/images/track_weight_icon.png" class="w-16 h-16 mx-8">
        <div class="flex-col">
            <p id=<?php echo '"' . $weightID . 'Text"'; ?> class="mb-0 text-white font-bold text-lg drop-shadow-dark"></p>
        </div>
    </div>
    <?php
    }

    /** Renders weight data partial view. */
    private function renderWeightDataPartialView() {?>
    <div class="flex min-h-192 max-h-192">
        <div class="mx-auto basis-192 border-2 bg-white flex flex-col border-gray-dove overflow-auto <?php if (sizeof($this->weightDataset) == 0) { echo "justify-center";}?>">
            <?php
            if (sizeof($this->weightDataset) > 0) {
                foreach ($this->weightDataset as $key => $value) {
                    $this->renderOneWeightDataRow($value['weightID']);
                }
            } else if (date($_GET['date']) === date('Y-m-d')) {
                echo '<p class="text-black font-bold text-3xl mx-auto" style="opacity: 0.2;">You have not weigh yourself today';
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

            <input type="date" id="dateOfWeight" name="dateOfWeight"
            value=<?php echo '"' . $_GET['date'] . '"';?> class="bg-slate-100 w-72 rounded py-1 border-2" oninput="redirectTrackWeightPage()"
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
        <h1 class="text-4xl font-bold mx-auto mb-20">Track Weight</h1>

        <div class="flex min-h-64 mb-32">
            <div class="mx-auto basis-256 bg-yellow-500 rounded-2xl flex flex-col items-center">
                <img src="../../public/images/track_weight_icon.png" class="w-16 h-16 mb-10" style="margin-top: 20px;">
                <div class="text-white font-bold text-3xl drop-shadow-dark text-center">
                    <p class="mb-0" id="weightStatusMessage"></p>
                    <p class="mb-0" id="weightEncouragementMessage"></p>
                </div>
            </div>
        </div>

        
        <?php $this->renderDatePagination(); ?>
        
        <div class="flex items-center mb-14">
            <div class="mx-auto flex items-center text-3xl justify-center basis-96">
                <select name="weightUnitInUserTrackWeightView" 
                id="weightUnitInUserTrackWeightView"
                class="bg-white rounded-lg border-2 text-shadow-dark text-black bg-slate-100 w-72 rounded py-1 border-2"
                oninput="convertWeightOfAllWeightDataRow('weightUnitInUserTrackWeightView');
                createSessionForWeightUnitSelected();
                updateWeightMessages()">
                    
                    <option value="Kg" <?php if (isset($_SESSION['weightUnitInUserTrackWeightView']) &&
                    $_SESSION['weightUnitInUserTrackWeightView'] === "Kg") { echo "selected"; }?>>Kilograms (Kg)</option>
                    <option value="g" <?php if (isset($_SESSION['weightUnitInUserTrackWeightView']) &&
                    $_SESSION['weightUnitInUserTrackWeightView'] === "g") { echo "selected"; }?>>Grams (g)</option>
                    <option value="lb" <?php if (isset($_SESSION['weightUnitInUserTrackWeightView']) &&
                    $_SESSION['weightUnitInUserTrackWeightView'] === "lb") { echo "selected"; }?>>Pounds (lb)</option>
                    
                </select>
            </div>
        </div>

        <?php $this->renderWeightDataPartialView(); ?>
                
            
        <div class="flex mt-4 mb-20">
            <input type="button" value="Add" class="bg-white hover:bg-gray-light drop-shadow-dark rounded-4xl font-bold mx-auto px-8 py-4 cursor-pointer" onclick="openAddWeightDataModal()">
        </div>
        
        

    </section>

    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10"></div>


    <div id="weightDataModal" class="absolute inset-0 flex items-center justify-center hidden z-20 top-328 modal font-montserrat">
        <div class="flex flex-col items-center bg-yellow-500 w-full rounded-2xl shadow-lg modal-content basis-144 min-h-128">
            <img src="../../public/images/track_weight_icon.png" class="w-16 h-16 mt-10 mb-5">
            <h2 id="modalTitle" class="text-3xl text-white font-bold drop-shadow-dark mb-5"></h2>
            <hr class="w-full mb-5">
            <form action="<?php echo $_SERVER['PHP_SELF'] . "?date=" . $_GET['date']; ?>" method="POST">
                <input type="hidden" id="weightID" name="weightID">
                    

                <div class="flex mt-8 justify-between gap-x-2 min-w-100">
                    <div class="flex flex-col justify-between items-end gap-y-2 font-semibold text-2xl">
                        <div class="flex">
                            

                            <select name="weightUnitInWeightDataModalInUserTrackWeightView"
                            id="weightUnitInWeightDataModalInUserTrackWeightView"
                            class="bg-white rounded-lg border-2 text-shadow-dark text-black"
                            oninput="convertWeightOfAllWeightDataRow('weightUnitInWeightDataModalInUserTrackWeightView');
                            createSessionForWeightUnitSelected();
                            updateWeightMessages()">

                                <option value="Kg" <?php if (isset($_SESSION['weightUnitInUserTrackWeightView']) &&
                                $_SESSION['weightUnitInUserTrackWeightView'] === "Kg") { echo "selected"; }?>>Kilograms (Kg)</option>
                                <option value="g" <?php if (isset($_SESSION['weightUnitInUserTrackWeightView']) &&
                                $_SESSION['weightUnitInUserTrackWeightView'] === "g") { echo "selected"; }?>>Grams (g)</option>
                                <option value="lb" <?php if (isset($_SESSION['weightUnitInUserTrackWeightView']) &&
                                $_SESSION['weightUnitInUserTrackWeightView'] === "lb") { echo "selected"; }?>>Pounds (lb)</option>

                            </select>
                            <label for="weight" class="text-white drop-shadow-dark">:</label>
                        </div>

                        <label for="time" class="text-white drop-shadow-dark">Time:</label>

                    </div>

                    <div class="flex flex-col gap-y-2 justify-between">
                        <input type="number" id="weight" name="weight" class="rounded-lg border-2">
                        <input type="time" id="time" name="time" class="rounded-lg border-2">
                    </div>

                </div>

                <div class="flex flex-row-reverse justify-center mt-28">
                    <input type="submit" id="submitWeightDataButton" name="submitWeightDataButton" value="" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                    <input type="button" id="deleteWeightDataButton" name="deleteWeightDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 hidden rounded-lg shadow-lg mr-2 cursor-pointer" onclick="openDeleteConfirmationModal()">
                    <input type="button" value="Close" onclick="closeWeightDataModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                </div>

                <div id="confirmationModal" class="absolute inset-0 flex items-center justify-center hidden z-30 modal font-montserrat">
                    <div class="flex flex-col items-center justify-center bg-white w-full rounded-2xl shadow-lg modal-content basis-96 min-h-64">
                        
                        <h2 id="confirmationModalTitle" class="text-lg text-black font-bold mb-5 text-center">Are you sure you want to delete this weight data? This action cannot be UNDONE.</h2>
                        <div class ="flex flex-row-reverse">
                            <input type="submit" id="submitDeleteWeightDataButton" name="submitDeleteWeightDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
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
    
    <!-- Embed php array of ids of the weight data rows to be used to convert the amount drank based on unit. -->
    <input type="hidden" id="phpWeightDataset" value="
    <?php 
    echo htmlspecialchars(json_encode($this->weightDataset));
    ?>
    ">
    <!-- Embed php current pagination. -->
    <input type="hidden" id="currentPaginationDate" value="
    <?php 
    echo htmlspecialchars(json_encode($_GET['date']));
    ?>
    ">

    <script src="../../public/js/user/userTrackWeightScript.js">
    </script>
    <?php
    }
}