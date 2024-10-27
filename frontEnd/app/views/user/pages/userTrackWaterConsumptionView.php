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
    private function renderOneWaterConsumptionDataPartialView($waterConsumptionDataLitres, $waterConsumptionDataRecordedOnTime) {?>
    <div class="basis-32 bg-blue-vivid flex items-center border-b-2 border-gray-mid">
        <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mx-8">
        <div class="flex-col">
            <p class="mb-0 text-white font-bold text-lg drop-shadow-dark"><?php echo "You have drank " . $waterConsumptionDataLitres . " at " . $waterConsumptionDataRecordedOnTime?></p>
        </div>
    </div>
    <?php
    }

    /** Renders water consumption data partial view. */
    private function renderWaterConsumptionDataPartialView() {?>
    <div class="flex min-h-192">
        <div class="mx-auto basis-192 border-2 bg-white flex flex-col border-gray-dove">
            <?php
            for ($i = 0; $i < sizeof($this->waterConsumptionDataArray); $i++) {
                $this->renderOneWaterConsumptionDataPartialView($this->waterConsumptionDataArray[0]['litres'], $this->waterConsumptionDataArray[0]['recordedOnTime']);
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

        

        

        <?php
        $this->renderWaterConsumptionDataPartialView();
        ?>
                
            
        <div class="flex mt-4 mb-20">
            <input type="button" value="Add" class="bg-white drop-shadow-dark rounded-4xl font-bold mx-auto px-8 py-4">
        </div>
        
        

    </section>

    <script src=../../public/js/user/userTrackWaterConsumptionScript.js>
    </script>


    <?php
    }
}