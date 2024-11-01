<?php
class ProfileView {
    private $userDetails;
    public function __construct($userDetails) {
        $this->userDetails = $userDetails;
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
    <section class="bg-blue-user min-h-full flex flex-col pb-48">

    <div class="container mx-auto p-6 w-full lg:max-w-screen-xl h-full">
        <div class="flex items-center mb-10 mt-5 ml-3">
            <button onclick="window.history.go(-1); return false;" class="flex items-center justify-center text-xl text-gray-600 p-2 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition">
                <i class='bx bx-chevrons-left'></i>
            </button>
            <h2 class="text-2xl font-semibold ml-6">User Profile</h2>
        </div>

        <div class="bg-white rounded-3xl p-6 flex flex-col lg:flex-row justify-between h-full lg:h-auto">
            <div class="w-full lg:w-2/3 mb-6 lg:mb-0 lg:pl-4 lg:pr-4 mt-2">
                <h3 class="text-lg font-semibold mb-6">Profile Information</h3>

                <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm text-gray-600 mb-2" for="user-id">User ID</label>
                        <input type="text" id="user-id" class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['registeredUserID'] ?? ''); ?>" disabled>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2" for="first-name">First Name</label>
                        <input type="text" id="first-name" name="firstName" class="w-full border border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['firstName'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2" for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="lastName" class="w-full border border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['lastName'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2" for="username">Username</label>
                        <input type="text" id="username" class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['username'] ?? ''); ?>" disabled>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2" for="email">Email</label>
                        <input type="email" id="email" class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['email'] ?? ''); ?>" disabled>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2" for="gender">Gender</label>
                        <input type="text" id="gender" name="gender" class="w-full border border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['gender'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2" for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="w-full border border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['dob'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2" for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="w-full border border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($this->userDetails['phone'] ?? ''); ?>" required>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-full hover:bg-indigo-500 transition">Save Changes</button>
                    </div>
                </form>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="w-full lg:w-1/3 flex items-center justify-center lg:h-[70vh]">
                    <div class="flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold text-gray-600 mb-5">Profile Photo</h3>
                        <div class="relative flex flex-col items-center">
                            <div class="aspect-w-1 aspect-h-1 w-48">
                                <img src="<?php echo htmlspecialchars($this->userDetails['profileImageFilePath'] ?? '../../public/images/avatar.png'); ?>" alt="Profile Photo" class=" rounded-3xl shadow-lg object-cover mb-10">
                            </div>
                            <input type="file" id="profile-photo" name="profilePhoto" class="hidden" accept="image/*" onchange="this.form.submit();">
                            <button type="button" class="bg-gray-900 text-white py-1.5 px-10 rounded-full hover:bg-gray-700 transition" onclick="document.getElementById('profile-photo').click();">Upload Photo</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php
    }
}