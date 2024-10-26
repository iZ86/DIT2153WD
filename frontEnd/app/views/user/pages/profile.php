<?php include '../components/header.php'; ?>
<?php include '../components/navBar.php'; ?>

<section>
    <div class="bg-blue-300 w-full min-h-screen p-6 relative" style="background-color: aliceblue">
        <!--"My Profile" Heading-->
        <h1 class="font-bold font-nunito text-3xl absolute top-4 left-12 ml-24">My Profile</h1>

        <div class="flex items-center justify-center min-h-screen">
            <div class="max-w-6xl mx-auto rounded-lg shadow-md p-6 mt-20">
                <div class="flex flex-col-1 md:flex-row justify-between">
                    <!--Left Section (Profile Picture, Avatar Upload, Biography)-->
                    <div class="w-96 text-center mb-6 ml-10">
                        <img src="../../../public/images/profile.png" alt="profile picture" class="mx-auto rounded-full h-24 w-24 object-cover">
                        <h2 class="mt-10 text-xl font-semibold text-orange-600">Sky Foo</h2>
                        <button class="mt-32 bg-orange-500 text-white text-xl px-6 py-3 rounded-xl">Upload New Avatar</button><br>
                        <button class="mt-4 text-orange-500 text-xl px-6 py-3 rounded-xl" style="background-color: #9ca3af">Delete</button>
                        <div class="mt-12">
                            <!--Text area for Biography-->
                            <label class="text-lg font-semibold flex justify-center" for="bio">Biography</label>
                            <textarea class="w-full mt-4 p-4 border rounded-md text-gray-700" name="bio" id="bio" rows="6" cols="6" placeholder=""></textarea>
                        </div>
                    </div>
                    <!-- Vertical Line -->
                    <div class="border border-gray-500 border-solid mx-20 my-4"></div>
                    <!--Right Section (Account Info and User Info)-->
                    <div class="mx-auto ml-10">
                        <!--Account Info-->
                        <div class="border-b pb-16 mb-10">
                            <div class="flex justify-evenly">
                                <h2 class="text-2xl font-semibold mb-4">Account Info</h2>
                                <!--Save and Cancel Buttons-->
                                <div class="space-x-4 ml-10">
                                    <button class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-500">Cancel</button>
                                    <button class="bg-blue-button text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                                </div>
                            </div>
                            <!-- Horizontal Line -->
                            <div class="border border-gray-500 border-solid mb-6"></div>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-lg font-light" for="username">Username</label><br>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md bg-white type="text" name="username" id="username" placeholder="What is your Username?" disabled>
                                </div>
                                <div>
                                    <label class="block text-lg font-light" for="password">Password</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md" type="password" name="password" id="password" placeholder="What is your Password?">
                                </div>
                                <div>
                                    <label class="block text-lg font-light" for="email">Email</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md" type="email" name="email" id="email" placeholder="What is your Email?">
                                </div>
                                <div>
                                    <label class="block text-lg font-light" for="phoneNumber">Phone Number</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md" type="tel" name="phoneNumber" id="phoneNumber" placeholder="What is your Phone Number?">
                                </div>
                                <div>
                                    <label class="block text-lg font-light" for="userID">User ID</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md bg-white" type="text" name="userID" id="userID" placeholder="What is your User ID?" disabled>
                                </div>
                                <div>
                                    <label class="block text-lg font-light" for="joinedDate">Joined Date</label>
                                    <input class="w-full mt-1 px-3 py-2 border rounded-md bg-white" type="datetime-local" name="joinedDate" id="joinedDate" placeholder="What is your Joined Date?" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- Horizontal Line -->
                        <div class="border border-gray-500 border-solid mb-6"></div>
                        <!--User Info-->
                        <div>
                            <h2 class="text-2xl font-semibold mb-4">User Info</h2>
                            <div>
                                <label class="block text-lg font-light" for="firstName">First Name</label>
                                <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md bg-white" type="text" name="firstName" id="firstName" placeholder="What is your First Name?" disabled>
                            </div>
                            <div>
                                <label class="block text-lg font-light" for="lastName">Last Name</label>
                                <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md bg-white" type="text" name="lastName" id="lastName" placeholder="What is your Last Name?" disabled>
                            </div>
                            <div>
                                <label class="block text-lg font-light" for="dateOfBirth">Date of Birth</label>
                                <input class="w-full mt-1 px-3 py-2 mb-4 border rounded-md bg-white" type="text" name="dateOfBirth" id="dateOfBirth" placeholder="What is your Date of Birth?" disabled>
                            </div>
                            <div>
                                <label class="block text-lg font-light disabled">Gender</label><br>
                                <select class="mt-2 text-lg box-border w-24 h-10">
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
    <?php include '../components/footer.php'; ?>
</section>
