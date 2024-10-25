<?php include '../components/header.php'; ?>
<?php include '../components/navBar.php'; ?>

<section>
    <div class="bg-gray-100 min-h-screen p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 relative">
            <!--"My Profile" Heading-->
            <h1 class="font-bold font-nunito text-2xl mb-6">My Profile</h1>
            <div class="flex flex-col-1 justify-around">
                <!--Left Section (Profile Picture, Avatar Upload, Biography)-->
                <div class="w-96 text-center mb-6">
                    <img src="../../../public/images/profile.png" alt="profile picture" class="mx-auto rounded-full h-24 w-24 object-cover">
                    <h2 class="mt-10 text-xl font-semibold text-orange-600">Sky Foo</h2>
                    <button class="mt-12 bg-orange-500 text-white text-xl px-6 py-3 rounded-xl">Upload New Avatar</button><br>
                    <button class="mt-4 text-orange-500 text-xl px-6 py-3 rounded-xl">Delete</button>
                    <div class="mt-12">
                        <!--Text area for Biography-->
                        <label class="text-lg font-semibold flex justify-center" for="bio">Biography</label>
                        <textarea class="w-full mt-4 p-4 border rounded-md text-gray-700" name="bio" id="bio" rows="6" cols="6" placeholder=""></textarea>
                    </div>
                </div>
                <!-- Vertical Line -->
                <div class="border border-gray-500 border-solid ml-10"></div>
                <!--Right Section (Account Info and User Info)-->
                <div class="mx-auto ml-10">
                    <!--Account Info-->
                    <div class="border-b pb-16 mb-10">
                        <h2 class="text-lg font-semibold">Account Info</h2>
                        <div>
                            <label class="block text-sm text-gray-600" for="username">Username</label>
                            <input class="w-96 mt-1 mb-4 px-3 py-2 border rounded-md" type="text" name="username" id="username" placeholder="What is your Username?" disabled>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600" for="password">Password</label>
                            <input class="w-full mt-1 mb-4 px-3 py-2 border rounded-md" type="password" name="password" id="password" placeholder="What is your Password??">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600" for="email">Username</label>
                            <input class="w-full mt-1 mb-4 px-3 py-2 border rounded-md" type="email" name="email" id="email" placeholder="What is your Email?">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600" for="phoneNumber">Phone Number</label>
                            <input class="w-full mt-1 mb-4 px-3 py-2 border rounded-md" type="tel" name="phoneNumber" id="phoneNumber" placeholder="What is your Phone Number?">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600" for="userID">User ID</label>
                            <input class="w-full mt-1 mb-4 px-3 py-2 border rounded-md" type="text" name="userID" id="userID" placeholder="What is your User ID?" disabled>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600" for="joinedDate">Joined Date</label>
                            <input class="w-full mt-1 px-3 py-2 border rounded-md" type="datetime-local" name="joinedDate" id="joinedDate" placeholder="What is your Joined Date?" disabled>
                        </div>
                    </div>
                    <!-- Horizontal Line -->
                    <div class="border border-gray-500 border-solid mb-6"></div>
                    <!--User Info-->
                    <div>
                        <h2 class="text-lg font-semibold">User Info</h2>
                        <div>
                            <label class="block text-sm text-gray-600" for="firstName">First Name</label>
                            <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md" type="text" name="firstName" id="firstName" placeholder="What is your First Name?" disabled>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600" for="lastName">Last Name</label>
                            <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md" type="text" name="lastName" id="lastName" placeholder="What is your Last Name?" disabled>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600" for="dateOfBirth">Date of Birth</label>
                            <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md" type="text" name="dateOfBirth" id="dateOfBirth" placeholder="What is your Date of Birth?" disabled>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-2 disabled">Gender</label>
                            <select>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Croissant</option>
                                <option>Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                    <!--Save and Cancel Buttons-->
                    <div class="mt-12 flex justify-end space-x-4">
                        <button class="bg-orange-500 text-white px-4 py-2 rounded-md">Cancel</button>
                        <button class="bg-blue-button text-white px-4 py-2 rounded-md">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../components/footer.php'; ?>
</section>
