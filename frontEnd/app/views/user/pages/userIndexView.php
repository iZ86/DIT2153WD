<?php

class UserIndexView {

    /** Username of the user logged in. */
    private $username;
    
    /** Constructor for the object. */
    public function __construct($username) {
        $this->username = $username;
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
    
    <section class="flex flex-col font-montserrat bg-blue-user pt-16 pb-48">
        <h1 class="text-5xl font-bold ml-40"><?php echo "Welcome back, " . $this->username; ?></h1>


        <!-- Tracker -->
        <div class="flex flex-col mt-48">
            <h2 class="text-4xl font-bold ml-40">Tracker</h2>

            <div class="flex items-center justify-around mt-14 mx-24">

 
                <a href="track-water-consumption.php">
                    <div class="flex flex-col justify-center items-center w-64 h-64 bg-blue-vivid hover:bg-blue-mid rounded-2xl cursor-pointer" onclick="goToTrackWater()">
                        <img src="../../public/images/track_water_consumption_icon.png" class="w-16 h-16 mt-10 mb-5">
                        <p class="text-white drop-shadow-dark font-semibold text-2xl text-center">Track Water Consumption</p>
                    </div>
                </a>

                <a href="track-weight.php">
                    <div class="flex flex-col justify-center items-center w-64 h-64 bg-yellow-500 hover:bg-yellow-700  rounded-2xl cursor-pointer" onclick="goToWeight()">
                        <img src="../../public/images/track_weight_icon.png" class="w-16 h-16 mt-10 mb-5">
                        <p class="text-white drop-shadow-dark font-semibold text-2xl text-center">Track Weight</p>
                    </div>
                </a>

                <a href="track-exercise-routine-detail.php">
                    <div class="flex flex-col justify-center items-center w-64 h-64 bg-orange-400 hover:bg-orange-600 rounded-2xl cursor-pointer" onclick="goToBMI()">
                        <img src="../../public/images/track_exercise_routine_detail_icon.png" class="w-16 h-16 mt-10 mb-5">
                        <p class="text-white drop-shadow-dark font-semibold text-2xl text-center">Track Exercise Routine Detail</p>
                    </div>
                </a>

                <a href="track-bmi.php">
                    <div class="flex flex-col justify-center items-center w-64 h-64 bg-gray-400 hover:bg-gray-600 rounded-2xl cursor-pointer" onclick="goToBMI()">
                        <img src="../../public/images/track_bmi_icon.png" class="w-16 h-16 mt-10 mb-5">
                        <p class="text-white drop-shadow-dark font-semibold text-2xl text-center">Track BMI</p>
                    </div>
                </a>

                
            </div>

        </div>
    
        
    </section>

    <?php
    }

}
