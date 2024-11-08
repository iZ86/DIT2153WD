<?php

class GuestIndexView {
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
        include __DIR__ . '/../components/guestHeader.php';
    }

    /** Renders the navbar. */
    public function renderNavbar() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/guestNavbar.php';
    }

    /** Renders the footer. */
    public function renderFooter() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/guestFooter.php';
    }

    /** Renders the content. */
    public function renderContent() : void {?>
<section class="p-6 space-y-6 bg-indigo-50">

    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto mx-auto flex flex-col items-center" style="width:1300px">
        <img src="../public/images/guestIndex1.png" class="" >
        <div class="flex flex-row space-x-2 overflow-x-auto mt-4">
            <img src="../public/images/guestIndex2.png" style="height: 600px">
            <img src="../public/images/guestIndex3.png" style="height: 600px">
            <img src="../public/images/guestIndex4.png" style="height: 600px">
        </div>
        <form class="font-medium text-center p-6 mt-4 flex flex-col" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
            At Huan Fitness center, we empower individuals to achieve holistic health through personalized fitness plans, nutrition guidance, and continuous support. Our mission is to create a welcoming community where everyone can thrive, track their progress, and embrace a healthier lifestyle. Together, we strive to inspire and motivate each other on the journey to wellness.
            <input type="submit" name="submit" value="Join Us Today!" class="bg-orange-400 hover:bg-orange-500 text-white text-sm font-medium py-2 px-4 rounded-full w-40 mx-auto mt-4">
        </form>
    </div>
</section>
<?php
    }
}
