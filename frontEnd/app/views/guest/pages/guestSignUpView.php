<?php 


class GuestSignUpView {

    // Constructor for the object
    public function __construction() {

    }  

    /** Renders the whole view. */
    public function __invoke() : void {
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

<section class="bg-blue-user font-montserrat flex flex-col pt-16 pb-48">
    <div class="">
        <h2 class="text-2xl font-bold mx-auto" style="width: 800px">Sign Up</h2>
    </div> 
    <form method="post" action=<?php echo $_SERVER['PHP_SELF']?>>
        <div class="bg-white p-6 rounded-3xl shadow-lg mx-auto flex flex-col" style="width:800px">
            <div class="flex justify-center">
                <img class="w-40 h-20" src="../public/images/Logo.png" alt="Logo.png">
            </div>
            <div class="flex flex-row mx-auto mt-6">
                <div class="flex flex-col">
                    <p class="w-fit mb-4">Email</p>
                    <input type="text" id="email" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <p class="w-fit mb-4">Password</p>
                    <input type="password" id="password" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <p class="w-fit mb-4">Username</p>
                    <input type="text" id="username" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <p class="w-fit mb-4">Phone Number</p>
                    <input type="text" id="phoneNumber" class="bg-slate-100 w-72 rounded py-1 px-2">
                </div>
                <div class="flex flex-col ml-10">
                    <p class="w-fit mb-4">First name</p>
                    <input type="text" id="firstName" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <p class="w-fit mb-4">Last Name</p>
                    <input type="text" id="lastName" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <p class="w-fit mb-4">Date of Birth</p>
                    <input type="date" id="dateOfBirth" class="bg-slate-100 w-72 rounded py-1 px-2 mb-6">
                    <p class="w-fit mb-4">Gender</p>
                    <select type="dropdown" id="Gender" class="bg-slate-100 w-72 rounded py-1 px-2">
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <div class="flex justify-center">
                    <div class="flex flex-row space-x-2 mb-4 mx-auto text-slate-700">
                        <input type="checkbox">
                        <p>I agree to the terms and conditions</p>
                    </div>
                </div>
                <input type="submit" value="Sign Up" class="mb-6 bg-blue-light hover:bg-blue-neon text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 w-40 mx-auto">
            </div>
        </div>
    </form>

</section>

    <?php
    }

}
?>
