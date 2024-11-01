<?php

class UserPaymentSuccessView {

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
    <section class="font-montserrat bg-blue-user flex flex-col pt-20 pb-48 items-center justify-center">
        <img src="../../public/images/Logo.png" class="w-64 h-full" alt="Logo.png">
        <h1 class="text-4xl font-bold">Payment Confirmed!</h1>
        <p class="text-lg mb-20">Thank you! Your transaction has been completed.</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input type="submit" name="submitReturnToIndexButton" value="Return to home page" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2 cursor-pointer">
            </form>
    </section>


    <?php
    }
}