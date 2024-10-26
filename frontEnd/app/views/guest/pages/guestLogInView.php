<?php

class GuestLogInView {
    /** Constructor for the object. */
    public function __construction() {
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
    <section class="font-montserrat bg-blue-user flex flex-col pt-16 pb-48">
        
        <div class="bg-white py-11 px-72 rounded-3xl shadow-lg mx-auto flex flex-col items-center">
            <!-- This src is referenced RELATIVE to controllers/login.php, as this code is called from that file. -->
            <img src="../public/images/Logo.png" class="w-64 h-32 mb-12">
            <!-- This object is only called at controllers/login.php, so the PHP_SELF will reference the login.php. -->
            <form class="flex flex-col mb-8 w-full" method="post" action=<?php echo $_SERVER['PHP_SELF']?>>
                
                <label class="text-xl font-bold">Username</label>
                <input type="text" name="username" class="bg-slate-100 rounded py-1 px-2 mb-6" 
                <?php 
                // Persist the username inputted, if invalid.
                if (isset($_SESSION['invalidLogin'])) {
                    echo 'value="' . $_SESSION['usernameInput'] . '"';
                }
                ?>
                >

                <label class="text-xl font-bold">Password</label>
                <input type="password" name="password" class="bg-slate-100 rounded py-1 px-2 mb-9"
                <?php 
                // Persist the username inputted, if invalid.
                if (isset($_SESSION['invalidLogin'])) {
                    echo 'value="' . $_SESSION['passwordInput'] . '"';
                }
                ?>
                >

                <div class="flex justify-center mb-2 gap-2">
                    
                    <input type="checkbox" name="keepMeLoggedInCheckBox" 
                    <?php 
                    if (isset($_SESSION['invalidLogin']) && (isset($_SESSION['keepMeLoggedInInput']) && $_SESSION['keepMeLoggedInInput'] === "on")) { 
                        echo 'checked="checked"'; 
                    }
                    ?>
                    >

                    <label class="font-semibold text-gray-dove text-base">Keep me logged in</label>
                </div>

                <!-- Invalid login warning -->
                <?php 
                if (isset($_SESSION['invalidLogin'])) {?>
                <label class="text-red-600 mx-auto">Invalid username/password</label>
                <?php
                }
                ?>
                <input type="submit" name="loginButton" value="Log In" class="bg-blue-light hover:bg-blue-neon px-8 py-4 mx-auto rounded-lg text-white text-sm font-bold">

            </form>
            <!-- Other options -->
            <div class="underline mb-2 text center text-gray-dove text-base font-semibold flex flex-col items-center">
                <a href="signup.php">Dont have an account? Sign Up</a>
                <a href="forgotPassword.php">Forgot Password</a>
            </div>

            
        </div>

    </section>
    <?php
    }
}

