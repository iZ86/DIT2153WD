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
    <section class="font-montserrat bg-blue-user flex flex-col pt-20 pb-48">
        <h1 class="text-4xl font-bold mx-auto mb-20">Track Water Consumption</h1>

        <div class="flex mx-auto min-w-256 min-h-64 mb-32">
            <div class="basis-256 bg-blue-vivid rounded-2xl flex flex-col items-center">
                <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mb-10" style="margin-top: 20px;">
                <div class="text-white font-bold text-3xl drop-shadow-dark">
                    <p class="mb-0">Yo have drank [5L] today!</p>
                    <p class="mb-0">[Keep up the good work!]</p>
                </div>
            </div>
        </div>

        <div class="flex min-h-192 mx-auto">
            <div class="min-w-192 border-2 bg-white flex flex-col border-gray-dove">
                <div class="basis-32 bg-blue-vivid flex items-center border-b-2 border-gray-mid">
                    <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mx-8">
                    <div class="flex-col">
                        <p class="mb-0 text-white font-bold text-lg drop-shadow-dark">[You have drank XL at XX:XX]</p>
                    </div>
                </div>
                <div class="basis-32 bg-blue-vivid flex items-center border-b-2 border-gray-mid">
                    <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mx-8">
                    <div class="flex-col">
                        <p class="mb-0 text-white font-bold text-lg drop-shadow-dark">[You have drank XL at XX:XX]</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex mx-auto mt-4 mb-8">
            <input type="button" value="Add" class="bg-white drop-shadow-dark rounded-4xl" style="padding: 16px 32px 16px 32px;">
        </div>
        
        <div class="flex items-center mx-auto text-3xl">
            <p><</p>
            <p>Today ▼</p>
            <p>></p>
        </div>

    </section>



    <?php
    }
}