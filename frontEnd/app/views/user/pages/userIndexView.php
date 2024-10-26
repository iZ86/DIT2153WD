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
        <h1 class="text-5xl font-bold ml-12"><?php echo "Welcome back, " . $this->username; ?></h1>

        <!-- Upcoming schedules -->
        <div class="flex flex-col mt-24">
            <h2 class="text-4xl font-bold ml-12">Upcoming schedules</h2>

            <div class="flex items-center justify-between mt-14 mx-16">


                <input type="button" id="previousSchedule" name="previousSchedule" value="<" class="w-8 h-20 text-4xl font-bold bg-gray-200">

                <!-- Schedule card layout -->
                <div class="flex items-center">

                    
                    <div class="w-64 h-64 bg-purple-100 rounded-2xl">
                    </div>
                    
                    
                </div>

                <input type="button" id="nextSchedule" name="nextSchedule" value=">" class="w-8 h-20 text-4xl font-bold bg-gray-200">
            </div>

        </div>

        <!-- Feedback Updates -->
        <div class="flex flex-col mt-48">
            <h2 class="text-4xl font-bold ml-12">Feedback Updates</h2>

            <div class="flex items-center justify-between mt-14 mx-16">


                <input type="button" id="previousFeedback" name="previousFeedback" value="<" class="w-8 h-20 text-4xl font-bold bg-gray-200">

                <!-- Feedback card layout -->
                <div class="flex items-center">

                    
                    <div class="w-64 h-64 bg-purple-100 rounded-2xl">
                    </div>
                    
                    
                </div>

                <input type="button" id="nextFeedback" name="nextFeedback" value=">" class="w-8 h-20 text-4xl font-bold bg-gray-200">
            </div>

        </div>

        <!-- Tracker -->
        <div class="flex flex-col mt-48">
            <h2 class="text-4xl font-bold ml-12">Tracker</h2>

            <div class="flex items-center justify-between mt-14 mx-16">


                <input type="button" id="previousTracker" name="previousTracker" value="<" class="w-8 h-20 text-4xl font-bold bg-gray-200">

                <!-- Tracker card layout -->
                <div class="flex items-center">

                    
                    <div class="w-64 h-64 bg-purple-100 rounded-2xl">
                    </div>
                    
                    
                </div>

                <input type="button" id="nextTracker" name="nextTracker" value=">" class="w-8 h-20 text-4xl font-bold bg-gray-200">
            </div>

        </div>
    
        
    </section>

    <?php
    }

}
