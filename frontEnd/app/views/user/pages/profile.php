<?php
class ProfileView {
    private $data;
    public function __construct($data) {
        $this->data = $data;
    }

    /** Renders the userNutritionists page. */
    public function renderView() {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    /** Renders the navbar. */
    public function renderNavbar() {
        include __DIR__ . '/../components/userNavbar.php';
    }

    /** Renders the header of the view. */
    public function renderHeader() {
        include __DIR__ . '/../components/userHeader.php';

    }

    /** Reners the footer */
    public function renderFooter() {
        include __DIR__ . '/../components/userFooter.php';
    }

    public function renderContent() {?>
    <section>
    <div class="px-32 bg-blue-50 min-h-screen pb-28 pt-10">
        <div class="flex items-center justify-center mr-28">
            <div class="">
                <div class="flex">
                    <div class="w-96 text-center flex flex-col justify-center items-center">
                    <h1 class="font-bold text-3xl">My Profile</h1>
                        <img src="../../public/images/profile.png" alt="profile picture" class="mt-3 rounded-full h-24 w-24 object-cover">
                        <h2 class="mt-2 text-2xl font-semibold text-orange-600">Sky Foo</h2>
                        <button class="mt-10 bg-orange-500 text-white text-xl px-6 py-3 rounded-xl">Upload New Avatar</button>
                        <button class="mt-3 bg-gray-300 text-orange-500 text-xl px-20 py-3 rounded-xl">Delete</button>
                        <div class="mt-10">
                            <!--Text area for Biography-->
                            <label class="text-2xl font-semibold flex justify-center" for="bio">Biography</label>
                            <textarea class="mt-4 p-2 border rounded-md text-gray-700" name="bio" id="bio" rows="7" cols="35"></textarea>
                        </div>
                    </div>
                    <!-- Vertical Line -->
                    <div class="border border-black mr-20 ml-20"></div>
                    <!--Right Section (Account Info and User Info)-->
                    <form action="">
                    <div class="">
                        <!--Account Info-->
                        <div class="pb-12">
                            <div class="flex border-b border-black w-full gap-x-64 items-center pb-3">
                                <h2 class="text-xl w-max font-bold font-montserrat">Account Info</h2>
                                <!--Save and Cancel Buttons-->
                                <div class="flex gap-x-3">
                                    <button class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-400">Cancel</button>
                                    <button class="bg-blue-button text-white px-8 py-2 rounded hover:bg-blue-600">Save</button>
                                </div>
                            </div>

                            <div class="mt-5 space-y-2">
                                <div>
                                    <label class="text-lg font-semibold font-montserrat" for="username">Username</label><br>
                                    <input class="w-80 mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="username" id="username" placeholder="What is your Username?" disabled>
                                </div>
                                <div>
                                    <label class="text-lg font-semibold font-montserrat" for="password">Password</label><br>
                                    <input class="w-80 mt-1 px-3 py-2 border rounded-md" type="password" name="password" id="password" placeholder="What is your Password?">
                                </div>
                                <div>
                                    <label class="text-lg font-semibold font-montserrat" for="email">Email</label><br>
                                    <input class="w-80 mt-1 px-3 py-2 border rounded-md" type="email" name="email" id="email" placeholder="What is your Email?">
                                </div>
                                <div>
                                    <label class="text-lg font-semibold font-montserrat" for="phoneNumber">Phone Number</label><br>
                                    <input class="w-80 mt-1 px-3 py-2 border rounded-md" type="tel" name="phoneNumber" id="phoneNumber" placeholder="What is your Phone Number?">
                                </div>
                                <div>
                                    <label class="text-lg font-semibold font-montserrat" for="userID">User ID</label><br>
                                    <input class="w-80 mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="userID" id="userID" placeholder="What is your User ID?" disabled>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!--User Info-->
                        <div>
                            <div class="flex border-b border-black w-full gap-x-64 items-center pb-3">
                                <h2 class="text-xl w-max font-bold font-montserrat">Account Info</h2>
                            </div>

                            <div class="grid grid-cols-2 grid-rows-2 mt-3 gap-x-14 gap-y-3">
                            <div>
                                <label class="text-lg font-semibold font-montserrat">First Name</label><br>
                                <input class="w-64 mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="firstName" id="firstName" placeholder="What is your First Name?" disabled>
                            </div>
                            <div>
                                <label class="text-lg font-semibold font-montserrat" for="lastName">Last Name</label><br>
                                <input class="w-64 mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="lastName" id="lastName" placeholder="What is your Last Name?" disabled>
                            </div>
                            <div>
                                <label class="text-lg font-semibold font-montserrat">Date of Birth</label><br>
                                <input class="w-64 mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="dateOfBirth" id="dateOfBirth" placeholder="What is your Date of Birth?" disabled>
                            </div>
                            <div>
                                <label for="gender" class="text-lg font-semibold font-montserrat">Gender</label><br>
                                <select name="gender" id="gender" class="w-64 mt-1 px-3 py-2 border rounded-md bg-white">
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Croissant</option>
                                    <option>Prefer not to say</option>
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
}