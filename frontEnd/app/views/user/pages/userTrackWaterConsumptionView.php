<?php

class UserTrackWaterConsumptionView {
    
    /** Constructor for the object. */
    public function __construct() {
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

    /** Renders the content. */
    public function renderContent(): void {?>
    <section class="font-montserrat bg-blue-user flex flex-col pt-16 pb-48">
        <h1 class="text-4xl font-bold ml-20 mb-14">Track Water Consumption</h1>

        <div class="mx-20 basis-64 bg-blue-vivid rounded-2xl flex flex-col items-center mb-32">
            <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mb-10" style="margin-top: 20px;">
            <div class="text-white font-bold text-3xl drop-shadow-dark">
                <p class="mb-0">Yo have drank [5L] today!</p>
                <p class="mb-0">[Keep up the good work!]</p>
            </div>
        </div>

        <!-- One day of water consumption data. -->
        <div class="flex flex-col mb-32">
            <div class="flex items-center">
                <h2 class="text-4xl font-bold ml-20 mr-6">Today</h2>
                <input type="button" id="addNewWaterConsumptionData" value="+" class="text-6xl font-bold bg-gray-mid text-gray-light rounded-full w-15">
            </div>

            <div class="flex items-center justify-between mt-14 mx-24">

                <input type="button" id="previousWaterConsumptionData" name="previousWaterConsumptionData" value="<" class="w-8 h-20 text-4xl font-bold bg-gray-200">

                <!-- Water consumption card layout -->
                <div class="flex items-center">

                    
                    <div class="w-64 h-64 bg-blue-vivid rounded-2xl flex flex-col items-center justify-center drop-shadow-dark">
                        <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mt-14 mb-3">
                        <p class="text-white font-bold text-lg drop-shadow-dark mb-12">[Drank 1L at XX:XX]</p>
                    
                    </div>
                    
                    
                </div>

            <input type="button" id="nextWaterConsumptionData" name="nextWaterConsumptionData" value=">" class="w-8 h-20 text-4xl font-bold bg-gray-200">
            </div>
        

        
        </div>

        <!-- One day of water consumption data. -->
        <div class="flex flex-col mb-32">
            <div class="flex items-center">
                <h2 class="text-4xl font-bold ml-20 mr-6">Today</h2>
                <input type="button" id="addNewWaterConsumptionData" value="+" class="text-6xl font-bold bg-gray-mid text-gray-light rounded-full w-15">
            </div>

            <div class="flex items-center justify-between mt-14 mx-24">

                <input type="button" id="previousWaterConsumptionData" name="previousWaterConsumptionData" value="<" class="w-8 h-20 text-4xl font-bold bg-gray-200">

                <!-- Water consumption card layout -->
                <div class="flex items-center">

                    
                    <div class="w-64 h-64 bg-blue-vivid rounded-2xl flex flex-col items-center justify-center drop-shadow-dark">
                        <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mt-14 mb-3">
                        <p class="text-white font-bold text-lg drop-shadow-dark mb-12">[Drank 1L at XX:XX]</p>
                    
                    </div>
                    
                    
                </div>

            <input type="button" id="nextWaterConsumptionData" name="nextWaterConsumptionData" value=">" class="w-8 h-20 text-4xl font-bold bg-gray-200">
            </div>
        

        
        </div>
        

    </section>



    <?php
    }
}