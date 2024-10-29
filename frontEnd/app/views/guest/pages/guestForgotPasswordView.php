<?php

class GuestForgotPasswordView {
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
    <section class="p-6 space-y-6 bg-indigo-50 pb-72">
        <div class="">
            <h2 class="text-2xl font-bold mx-auto" style="width: 500px">Forgot Password</h2>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto mx-auto flex flex-col items-center" style="width: 500px;">
            <form method="post" class="flex flex-col pb-4">
                <p class="w-fit mb-4">Email</p>
                <input type="text" name="email" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                <input type="submit" name="request" value="Request" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 ml-2">
            </form>
        </div>

    </section>
    <?php
    }
}