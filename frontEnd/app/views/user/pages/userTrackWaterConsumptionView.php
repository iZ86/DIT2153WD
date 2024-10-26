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
            <img src="../../public/images/track-water-consumption-icon.png" class="w-16 h-16 mb-10" style="margin-top: 20px;">
            <div class="text-white font-bold text-3xl drop-shadow-dark">
                <p class="mb-0">Yo have drank [5L] today!</p>
                <p class="mb-0">[Keep up the good work!]</p>
            </div>
        </div>

        <!-- Today Track -->
        <div class="flex flex-col">
            <div class="flex">
                <h2 class="text-4xl font-bold ml-20">Today</h2>
                <input type="button" id="addNewWaterConsumptionData" value="+">
            </div>

            <div class="flex items-center justify-between mt-14 mx-24">


                <input type="button" id="previousFeedback" name="previousFeedback" value="<" class="w-8 h-20 text-4xl font-bold bg-gray-200">

                <!-- Feedback card layout -->
                <div class="flex items-center">

                    
                    <div class="w-64 h-64 bg-purple-100 rounded-2xl">
                    </div>
                    
                    
                </div>

                <input type="button" id="nextFeedback" name="nextFeedback" value=">" class="w-8 h-20 text-4xl font-bold bg-gray-200">
            </div>
        </div>

    </section>



    <?php
    }
}