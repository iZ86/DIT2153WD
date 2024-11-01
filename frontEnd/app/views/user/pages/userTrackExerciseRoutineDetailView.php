<?php

class UserTrackExerciseRoutineDetailView {
    /** Exercise dataset. */
    private $exerciseDataset;
    /** Exercise routine detail dataset. */
    private $exerciseRoutineDetailDataset;
    
    /** Constructor for the object. */
    public function __construct($exerciseDataset, $exerciseRoutineDetailDataset) {
        $this->exerciseDataset = $exerciseDataset;
        $this->exerciseRoutineDetailDataset = $exerciseRoutineDetailDataset;
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

    /** Renders ONE card of exercise routine detail data. */
    private function renderOneExerciseRoutineDetailDataRow($exerciseRoutineDetailID) {?>
    <div id=<?php echo $exerciseRoutineDetailID; ?> class="basis-32 bg-orange-400 flex items-center border-b-2 border-gray-mid shrink-0 hover:bg-orange-600 cursor-pointer" onclick="openEditExerciseRoutineDetailDataModal(<?php echo $exerciseRoutineDetailID . ')';?>">
        <img src="../../public/images/track_exercise_routine_detail_icon.png" class="w-16 h-16 mx-8">
        <div class="flex-col">
            <p id=<?php echo '"' . $exerciseRoutineDetailID . 'Text"'; ?> class="mb-0 text-white font-bold text-lg drop-shadow-dark"></p>
        </div>
    </div>
    <?php
    }

    /** Renders exercise routine detail dataset partial view. */
    private function renderExerciseRoutineDetailDatasetPartialView() {?>
    <div class="flex min-h-192 max-h-192">
        <div class="mx-auto basis-192 border-2 bg-white flex flex-col border-gray-dove overflow-auto <?php if (sizeof($this->exerciseRoutineDetailDataset) == 0) { echo "justify-center";}?>">
            <?php
            if (sizeof($this->exerciseRoutineDetailDataset) > 0) {
                foreach ($this->exerciseRoutineDetailDataset as $key => $exerciseRoutineDetailData) {
                    $this->renderOneExerciseRoutineDetailDataRow($exerciseRoutineDetailData['exerciseRoutineDetailID']);
                }
            } else if (date($_GET['date']) === date('Y-m-d')) {
                echo '<p class="text-black font-bold text-3xl mx-auto" style="opacity: 0.2;">You have not exercise today :&#40;</p>';
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

            <input type="date" id="dateOfExerciseRoutineDetail" name="dateOfExerciseRoutineDetail"
            value=<?php echo '"' . $_GET['date'] . '"';?> class="bg-slate-100 w-72 rounded py-1 border-2" oninput="redirectTrackExerciseRoutineDetailPage()"
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

    /** Renders the exercise partial view. */
    public function renderExerciseContent() {?>
    <div class="flex justify-center items-center mb-14 mx-auto text-3xl">
            <form action="<?php echo $_SERVER['PHP_SELF'] . "?date=" . $_GET['date']; ?>" method="POST">
                <label for="exerciseID">Exercise:</label>
                <select name="exerciseID" id="exerciseID" class="bg-white rounded-lg border-2 text-shadow-dark text-black bg-slate-100 w-72 rounded py-1 border-2">
                </select>
        
                <input type="button" id="addExerciseDataButton" name="addExerciseDataButton" value="Add" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer" onclick="openAddExerciseDataModal()">
                <input type="button" id="updateExerciseDataButton" name="updateExerciseDataButton" value="Update" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer" onclick="openEditExerciseDataModal()">
                <div id="exerciseDataModal" class="absolute inset-0 flex items-center justify-center hidden z-20 top-328 modal font-montserrat">
                    <div class="flex flex-col items-center bg-orange-400 w-full rounded-2xl shadow-lg modal-content basis-144 min-h-128">
                        <img src="../../public/images/track_exercise_routine_detail_icon.png" class="w-16 h-16 mt-10 mb-5">
                        <h2 id="exerciseDataModalTitle" class="text-3xl text-white font-bold drop-shadow-dark mb-5"></h2>
                        <hr class="w-full mb-5">
                            <div class="flex mt-8 min-w-100 justify-center  text-2xl gap-x-2">
                                <label for="exerciseName" class="text-white drop-shadow-dark font-semibold">Exercise:</label>
                                <input type="text" id="exerciseName" name="exerciseName" class="rounded-lg border-2">
                            </div>

                            <div class="flex flex-row-reverse justify-center mt-28">
                                <input type="submit" id="submitExerciseDataButton" name="submitExerciseDataButton" value="" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                                <input type="button" id="deleteExerciseDataButton" name="deleteExerciseDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 hidden rounded-lg shadow-lg mr-2 cursor-pointer" onclick="openDeleteExerciseDataConfirmationModal()">
                                <input type="button" value="Close" onclick="closeExerciseDataModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                            </div>

                            <div id="deleteExerciseDataConfirmationModal" class="absolute inset-0 flex items-center justify-center hidden z-30 modal font-montserrat">
                                <div class="flex flex-col items-center justify-center bg-white w-full rounded-2xl shadow-lg modal-content basis-96 min-h-64">
                                                
                                    <h2 id="deleteExerciseDataConfirmationModalTitle" class="text-lg text-black font-bold mb-5 text-center">Are you sure you want to delete this exercise data? This action cannot be undone. NOTE: This wlll delete ALL EXERCISE ROUTINE DETAIL data.</h2>
                                    <div class ="flex flex-row-reverse">
                                        <input type="submit" id="submitDeleteExerciseDataButton" name="submitDeleteExerciseDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                                        <input type="button" value="Close" onclick="closeDeleteExerciseDataConfirmationModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </form>
    </div>
    <?php
    }

    /** Renders the content. */
    public function renderContent(): void {?>
    <section class="font-montserrat bg-blue-user flex flex-col pt-20 pb-48 justify-center">
        <h1 class="text-4xl font-bold mx-auto mb-20">Track Exercise Routine</h1>

        <div class="flex min-h-64 mb-32">
            <div class="mx-auto basis-256 bg-orange-400 rounded-2xl flex flex-col items-center">
                <img src="../../public/images/track_exercise_routine_detail_icon.png" class="w-16 h-16 mb-10" style="margin-top: 20px;">
                <div class="text-white font-bold text-3xl drop-shadow-dark text-center">
                    <p class="mb-0" id="exerciseRoutineDetailStatusMessage"></p>
                    <p class="mb-0" id="exerciseRoutineDetailEncouragementMessage"></p>
                </div>
            </div>
        </div>

        
        <?php $this->renderDatePagination(); ?>
        
        <?php $this->renderExerciseContent(); ?>

        <?php $this->renderExerciseRoutineDetailDatasetPartialView(); ?>
                
            
        <div class="flex mt-4 mb-20">
            <input type="button" value="Add" class="bg-white hover:bg-gray-light drop-shadow-dark rounded-4xl font-bold mx-auto px-8 py-4 cursor-pointer" onclick="openAddExerciseRoutineDetailDataModal()">
        </div>
        
        

    </section>

    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10"></div>


    <div id="exerciseRoutineDetailDataModal" class="absolute inset-0 flex items-center justify-center hidden z-20 top-328 modal font-montserrat">
        <div class="flex flex-col items-center bg-orange-400 w-full rounded-2xl shadow-lg modal-content basis-144 min-h-128">
            <img src="../../public/images/track_exercise_routine_detail_icon.png" class="w-16 h-16 mt-10 mb-5">
            <h2 id="exerciseRoutineDetailDataModalTitle" class="text-3xl text-white font-bold drop-shadow-dark mb-5"></h2>
            <hr class="w-full mb-5">
            <form action="<?php echo $_SERVER['PHP_SELF'] . "?date=" . $_GET['date']; ?>" method="POST">
                <input type="hidden" id="exerciseRoutineDetailID" name="exerciseRoutineDetailID">
                    

                <div class="flex mt-8 justify-between gap-x-2 min-w-100">
                    <div class="flex flex-col items-end font-semibold text-2xl">

                        <label for="exerciseIDForExerciseRoutineDetail" class="text-white drop-shadow-dark">Exercise:</label>
                        <label for="weight" class="text-white drop-shadow-dark">Weights:</label>
                        <label for="rep" class="text-white drop-shadow-dark">Reps:</label>
                        <label for="note" class="text-white drop-shadow-dark mt-2">Note:</label>
                        <label for="time" class="text-white drop-shadow-dark mt-auto">Time:</label>

                    </div>

                    <div class="flex flex-col gap-y-2">
                        <select name="exerciseIDForExerciseRoutineDetail" id="exerciseIDForExerciseRoutineDetail" class="bg-white rounded-lg border-2 text-shadow-dark text-black">
                        </select>
                        <div class="flex">

                            <input type="number" id="weight" name="weight" class="rounded-lg border-2">
                            <select name="weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView"
                            id="weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView"
                            class="bg-white rounded-lg border-2 text-shadow-dark text-black"
                            oninput="createSessionForWeightUnitSelected();">
                                <option value="Kg" <?php if (isset($_SESSION['weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView']) &&
                                $_SESSION['weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView'] === "Kg") { echo "selected"; }?>>Kilograms (Kg)</option>
                                <option value="g" <?php if (isset($_SESSION['weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView']) &&
                                $_SESSION['weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView'] === "g") { echo "selected"; }?>>Grams (g)</option>
                                <option value="lb" <?php if (isset($_SESSION['weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView']) &&
                                $_SESSION['weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView'] === "lb") { echo "selected"; }?>>Pounds (lb)</option>
                            </select>
                        </div>
                        <input type="rep" id="rep" name="rep" class="rounded-lg border-2">
                        <textarea id="note" name="note" class="rounded-lg border-2" rows="4" cols="20"></textarea>
                        <input type="time" id="time" name="time" class="rounded-lg border-2">
                    </div>

                </div>

                <div class="flex flex-row-reverse justify-center mt-28 mb-14">
                    <input type="submit" id="submitExerciseRoutineDetailDataButton" name="submitExerciseRoutineDetailDataButton" value="" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                    <input type="button" id="deleteExerciseRoutineDetailDataButton" name="deleteExerciseRoutineDetailDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 hidden rounded-lg shadow-lg mr-2 cursor-pointer" onclick="openDeleteExerciseRoutineDetailDataConfirmationModal()">
                    <input type="button" value="Close" onclick="closeExerciseRoutineDetailDataModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                </div>

                <div id="deleteExerciseRoutineDetailDataConfirmationModal" class="absolute inset-0 flex items-center justify-center hidden z-30 modal font-montserrat">
                    <div class="flex flex-col items-center justify-center bg-white w-full rounded-2xl shadow-lg modal-content basis-96 min-h-64">
                        
                        <h2 id="deleteExerciseRoutineDetailDataConfirmationModalTitle" class="text-3xl text-black font-bold mb-5 text-center">Are you sure you want to delete this exercise routine detail data?</h2>
                        <div class ="flex flex-row-reverse">
                            <input type="submit" id="submitDeleteExerciseRoutineDetailDataButton" name="submitDeleteExerciseRoutineDetailDataButton" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
                            <input type="button" value="Close" onclick="closeDeleteExerciseRoutineDetailDataConfirmationModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
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
    
    <!-- Embed php array of ids of the exercise routine detail dataset to be used to convert the amount drank based on unit. -->
    <input type="hidden" id="phpExerciseRoutineDetailDataset" value="
    <?php 
    echo htmlspecialchars(json_encode($this->exerciseRoutineDetailDataset));
    ?>
    ">
    <!-- Embed php array of ids of the exercise routine detail dataset to be used to convert the amount drank based on unit. -->
    <input type="hidden" id="phpExerciseDataset" value="
    <?php 
    echo htmlspecialchars(json_encode($this->exerciseDataset));
    ?>
    ">
    <!-- Embed php current pagination. -->
    <input type="hidden" id="currentPaginationDate" value="
    <?php 
    echo htmlspecialchars(json_encode($_GET['date']));
    ?>
    ">

    <script src="../../public/js/user/userTrackExerciseRoutineDetailScript.js">
    </script>
    <?php
    }
}