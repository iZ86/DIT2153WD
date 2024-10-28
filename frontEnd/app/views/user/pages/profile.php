<?php include __DIR__ .  '/../components/userHeader.php'; ?>
<?php include __DIR__ .  '/../components/userNavbar.php'; ?>

<?php
require_once '../../../controllers/user/user-profile-management.php';
require_once '../../../config/db_connection.php';

session_start();

// Check if the user is logged in and get the user ID from the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID

    // Initialize the controller and fetch user data
    $controller = new UserProfileManagement();
    $user = $controller->getUserData($userId); // Fetch user data
} else {
    // Redirect to login or sign-up if user is not logged in
    header('Location: guestSignUpView.php');
    exit;
}
?>

<section>
    <div class="px-32 bg-blue-50 min-h-screen">
        <!--"My Profile" Heading-->
        <h1 class="font-bold text-3xl">My Profile</h1>
        <div class="flex items-center justify-center min-h-screen">
            <div class="max-w-6xl border border-black rounded-lg shadow-md py-10 px-20 mt-20">
                <div class="flex flex-col-1 md:flex-row justify-between">
                    <!--Left Section (Profile Picture, Avatar Upload, Biography)-->
                    <div class="w-96 text-center mb-6 ml-10">
                        <img src="../../../public/images/profile.png" alt="profile picture" class="mx-auto rounded-full h-24 w-24 object-cover">
                        <h2 class="mt-10 text-2xl font-semibold text-orange-600">Sky Foo</h2>
                        <button class="mt-32 bg-orange-500 text-white text-xl px-6 py-3 rounded-xl">Upload New Avatar</button><br>
                        <button class="mt-4 bg-gray-300 text-orange-500 text-xl px-20 py-3 rounded-xl">Delete</button>
                        <div class="mt-20">
                            <!--Text area for Biography-->
                            <label class="text-2xl font-semibold flex justify-center" for="bio">Biography</label>
                            <textarea class="w-full h-52 mt-4 p-2 border rounded-md text-gray-700" name="bio" id="bio" rows="6" cols="6"></textarea>
                        </div>
                    </div>
                    <!-- Vertical Line -->
                    <div class="border border-black mx-20 my-4"></div>
                    <!--Right Section (Account Info and User Info)-->
                    <div class="mx-auto ml-10">
                        <!--Account Info-->
                        <div class="pb-12">
                            <div class="flex justify-evenly">
                                <h2 class="text-2xl font-semibold mb-4">Account Info</h2>
                                <!--Save and Cancel Buttons-->
                                <div class="space-x-4 ml-10">
                                    <button class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-400">Cancel</button>
                                    <button class="bg-blue-button text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                                </div>
                            </div>
                            <!-- Horizontal Line -->
                            <div class="border border-gray-500 border-solid mb-6"></div>
                            <div class="space-y-6">
                                <div>
                                    <label class="text-lg font-light" for="username">Username</label><br>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="username" id="username" placeholder="What is your Username?" disabled>
                                </div>
                                <div>
                                    <label class="text-lg font-light" for="password">Password</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md" type="password" name="password" id="password" placeholder="What is your Password?">
                                </div>
                                <div>
                                    <label class="text-lg font-light" for="email">Email</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md" type="email" name="email" id="email" placeholder="What is your Email?">
                                </div>
                                <div>
                                    <label class="text-lg font-light" for="phoneNumber">Phone Number</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md" type="tel" name="phoneNumber" id="phoneNumber" placeholder="What is your Phone Number?">
                                </div>
                                <div>
                                    <label class="text-lg font-light" for="userID">User ID</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="userID" id="userID" placeholder="What is your User ID?" disabled>
                                </div>
                                <div>
                                    <label class="text-lg font-light" for="joinedDate">Joined Date</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md bg-white" type="datetime-local" name="joinedDate" id="joinedDate" placeholder="What is your Joined Date?" disabled>
                                </div>
                            </div>
                        </div>

                        <!--User Info-->
                        <div>
                            <h2 class="text-2xl font-semibold mb-4">User Info</h2>
                            <!-- Horizontal Line -->
                            <div class="border border-gray-500 border-solid mb-6"></div>
                            <div>
                                <label class="text-lg font-light" for="firstName">First Name</label>
                                <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md bg-white" type="text" name="firstName" id="firstName" placeholder="What is your First Name?" disabled>
                            </div>
                            <div>
                                <label class="text-lg font-light" for="lastName">Last Name</label>
                                <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md bg-white" type="text" name="lastName" id="lastName" placeholder="What is your Last Name?" disabled>
                            </div>
                            <div>
                                <label class="text-lg font-light" for="dateOfBirth">Date of Birth</label>
                                <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md bg-white" type="text" name="dateOfBirth" id="dateOfBirth" placeholder="What is your Date of Birth?" disabled>
                            </div>
                            <div>
                                <label for="gender" class="text-lg font-light disabled">Gender</label><br>
                                <select name="gender" id="gender" class="w-full px-2 py-2.5 border border-gray-400 rounded-lg">
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Croissant</option>
                                    <option>Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ .  '/../components/userFooter.php'; ?>
</section>
<form method="POST" action="../../../views/user/pages/profile.php">
    <label>Username:</label>
    <input type="text" name="username" value="<?php echo $user['username']; ?>" readonly><br>

    <label>User ID:</label>
    <input type="text" name="user_id" value="<?php echo $user['user_id']; ?>" readonly><br>

    <label>Joined Date:</label>
    <input type="text" name="joined_date" value="<?php echo $user['joined_date']; ?>" readonly><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>

    <label>Phone Number:</label>
    <input type="text" name="phone_number" value="<?php echo $user['phone_number']; ?>"><br>

    <button type="submit">Save Changes</button>
</form>
<?php
require_once '../../../controllers/user/user-profile-management.php';
require_once '../../../config/db_connection.php'; // Assuming you have a DB config

$controller = new UserProfileManagement();
$userId = 1; // Example user ID (you can replace with session or dynamic value)
$user = $controller->getProfile($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->updateProfile($userId, $_POST);
    header('Location: profile.php'); // Redirect to avoid form resubmission
    exit;
}
?>
