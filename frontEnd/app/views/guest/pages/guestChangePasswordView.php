<?php

class GuestChangePasswordView {
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
            <h2 class="text-2xl font-bold mx-auto" style="width: 500px">Change Password</h2>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto mx-auto flex flex-col items-center" style="width: 500px;">
            <?php
                if (isset($_SESSION['changePasswordError'])) {
                    if ($_SESSION['changePasswordError'] === 1) {
                        $errorMsg = "Unsuccessful password change. Token does not exist.";
                    } else if ($_SESSION['changePasswordError'] === 2) {
                        $errorMsg = "Unsuccessful password change. Do not leave empty fields.";
                    } else if ($_SESSION['changePasswordError'] === 3) {
                        $errorMsg = "Unsuccessful password change. Passwords do not match.";
                    }
                    echo "<div class='w-full bg-red-200 text-center mb-6 text-gray-600 p-3 rounded-lg'>$errorMsg</div>";
                }

                if (isset($_SESSION['changePasswordSuccess'])) {
                    echo "<div class='w-full bg-green-200 text-center mb-6 text-gray-600 p-3 rounded-lg'>Password successfully changed! Head to the login page to continue.</div>";
                }
            ?>
            <div class="flex flex-col">
                <form action="<?= $_SERVER['PHP_SELF'] . '?token=' . $_SESSION['changePasswordToken'] ?>" method="post">
                    <p class="w-fit mb-4">New Password</p>
                    <input type="password" name="newPassword" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <p class="w-fit mb-4">Repeat Password</p>
                    <input type="password" name="newPasswordRepeat" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <input type="submit" name="changePassword" value="Change Password" class="mb-6 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 w-40 mx-auto">
                </form>
            </div>
        </div>

    </section>
    <?php
    }
}