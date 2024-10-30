<?php 
class GuestSignUpView {

    // Constructor for the object
    public function __construction() {
    }  

    /** Renders the whole view. */
    public function renderView() : void {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
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

    /** Renders the background. */
    public function renderContent() : void { ?>
    <section class="bg-blue-user font-montserrat flex flex-col pt-10 pb-48">
        <form method="post" action=<?php echo $_SERVER['PHP_SELF']?>>
            <div class="bg-white p-6 rounded-3xl shadow-lg mx-auto flex flex-col" style="width:800px">
                <?php
                    // If there is error, display error message
                    if (isset($_SESSION['signUpError'])) {
                        if ($_SESSION['signUpError'] === 1) {
                            $errorMsg = "Unsuccessful registration. Please do not leave empty fields.";
                        } else if ($_SESSION['signUpError'] === 2) {
                            $errorMsg = "Unsuccessful registration. Username already exists.";
                        } else if ($_SESSION['signUpError'] === 3) {
                            $errorMsg = "Unsuccessful registration. Email already exists.";
                        } else if ($_SESSION['signUpError'] === 4) {
                            $errorMsg = "Unsuccessful registration. Verification mail failed to send.";
                        } else if ($_SESSION['signUpError'] === 5) {
                            $errorMsg = "Unsuccessful registration. Error during registration.";
                        }
                        echo "<div class='bg-red-200 text-center m-3 text-gray-600 p-3 rounded-lg'>$errorMsg</div>";
                    }

                    // if successful registration, display success message
                    if (isset($_SESSION['signUpSuccess'])) {
                        $errorMsg = "Successful registration. Please verify your email.";
                        echo "<div class='bg-green-200 text-center m-3 text-gray-600 p-3 rounded-lg'>$errorMsg</div>";
                    }
                ?>
                <div class="flex justify-center">
                    <img class="w-40 h-20" src="../public/images/Logo.png" alt="Logo.png">
                </div>
                <div class="flex flex-row mx-auto mt-6">
                    <div class="flex flex-col">
                        <p class="w-fit mb-4">Username</p>
                        <input type="text" name="username" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6"
                        <?php 
                        // Persist inputted data, if error.
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpUsername'] . '"';
                            }
                        ?>
                        >
                        <p class="w-fit mb-4">Password</p>
                        <input type="password" name="password" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6"
                        <?php 
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpPassword'] . '"';
                            }
                        ?>
                        >
                        <p class="w-fit mb-4">First Name</p>
                        <input type="text" name="firstName" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6"
                        <?php 
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpFirstName'] . '"';
                            }
                        ?>
                        >
                        <p class="w-fit mb-4">Last Name</p>
                        <input type="text" name="lastName" class="bg-slate-100 w-72 rounded py-1 px-2"
                        <?php 
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpLastName'] . '"';
                            }
                        ?>
                        >
                    </div>
                    <div class="flex flex-col ml-10">
                        <p class="w-fit mb-4">Email</p>
                        <input type="text" name="email" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6"
                        <?php 
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpEmail'] . '"';
                            }
                        ?>
                        >
                        <p class="w-fit mb-4">Phone Number</p>
                        <input type="text" name="phoneNo" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6"
                        <?php 
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpPhoneNo'] . '"';
                            }
                        ?>
                        >
                        <p class="w-fit mb-4">Date of Birth</p>
                        <input type="date" name="dateOfBirth" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6"
                        <?php 
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpDateOfBirth'] . '"';
                            }
                        ?>
                        >
                        <p class="w-fit mb-4">Gender</p>
                        <select type="dropdown" name="gender" class="bg-slate-100 w-72 rounded py-1 px-2"
                        <?php 
                            if (isset($_SESSION['signUpError'])) {
                                echo 'value="' . $_SESSION['signUpGender'] . '"';
                            }
                        ?>
                        >
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="flex justify-center">
                        <div class="flex flex-row space-x-2 mb-4 mx-auto text-slate-700">
                            <input type="checkbox" name="termsAndConditions">
                            <p>I agree to the terms and conditions</p>
                        </div>
                    </div>
                    <input type="submit" name="signUp" value="Sign Up" class="mb-6 bg-blue-light hover:bg-blue-neon text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 w-40 mx-auto">
                </div>
            </div>
        </form>

    </section>

    <?php
    }

}
?>
