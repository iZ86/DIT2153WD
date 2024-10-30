<?php

class GuestLogInView {
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
    <section class="bg-blue-user flex flex-col pt-10 pb-48">
        <div class="bg-white p-6 rounded-3xl shadow-lg mx-auto flex flex-col items-center" style="width:800px">
            <?php
                // If there is error in login, display error message
                if (isset($_SESSION['loginError'])) {
                    if ($_SESSION['loginError'] === 1) {
                        $errorMsg = "Unsuccessful login. Please do not leave empty fields.";
                    } else if ($_SESSION['loginError'] === 2) {
                        $errorMsg = "Unsuccessful login. Incorrect credentials.";
                    } else if ($_SESSION['loginError'] === 3) {
                        $errorMsg = "Unsuccessful login. Please verify email to log in.";
                    }
                    echo "<div class='w-full bg-red-200 text-center m-3 text-gray-600 p-3 rounded-lg'>$errorMsg</div>";
                }

                // If there is error in email verification, display error message
                if (isset($_SESSION['loginVerificationError'])) {
                    if ($_SESSION['loginVerificationError'] === 0) {
                        echo "<div class='w-full bg-green-200 text-center m-3 text-gray-600 p-3 rounded-lg'>Email verification successful. Please log in to continue.</div>";
                    } else if ($_SESSION['loginVerificationError'] === 1) {
                        echo "<div class='w-full bg-red-200 text-center m-3 text-gray-600 p-3 rounded-lg'>Email verification unsuccessful. Incorrect token.</div>";
                    }
                }

            ?>
            <img src="../public/images/Logo.png" class="w-64 h-32 mb-12">
            <form class="flex flex-col mb-8 w-full" method="post" action=<?php echo $_SERVER['PHP_SELF']?>>
                <label class="text-l w-72 mx-auto">Username</label>
                <input type="text" name="username" class="bg-slate-100 rounded py-1 px-2 mb-6 w-72 mx-auto"
                <?php 
                    // Persist inputted data, if error.
                    if (isset($_SESSION['loginError'])) {
                        echo 'value="' . $_SESSION['usernameInput'] . '"';
                    }
                ?>
                >
                <label class="text-l w-72 mx-auto">Password</label>
                <input type="password" name="password" class="bg-slate-100 rounded py-1 px-2 mb-9 w-72 mx-auto"
                <?php 
                    if (isset($_SESSION['loginError'])) {
                        echo 'value="' . $_SESSION['passwordInput'] . '"';
                    }
                ?>
                >
                <input type="submit" name="loginButton" value="Log In" class="mb-6 bg-blue-light hover:bg-blue-neon text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 w-40 mx-auto">
            </form>
            <div class="underline mb-2 text center text-gray-dove text-base font-semibold flex flex-col items-center">
                <a href="signup.php">Dont have an account? Sign Up</a>
                <a href="forgotPassword.php">Forgot Password</a>
            </div>
        </div>
    </section>
    <?php
    }
}

