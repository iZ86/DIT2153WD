<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - Admin Dashboard</title>
    <link rel="stylesheet" href="../../../public/css/output.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="bg-indigo-50 min-h-full flex flex-col">

<div class="container mx-auto p-6 w-full lg:max-w-screen-xl h-full">
    <div class="flex items-center mb-10 mt-5 ml-3">
        <a href="../../../views/admin/pages/index.php" class="flex items-center justify-center text-xl text-gray-600 p-2 bg-indigo-100 hover:bg-indigo-200 rounded-lg transition">
            <i class='bx bx-chevrons-left' ></i>
        </a>
        <h2 class="text-2xl font-semibold ml-6">Admin Profile</h2>
    </div>

    <div class="bg-white rounded-3xl p-6 flex flex-col lg:flex-row justify-between h-full lg:h-auto">
        <div class="w-full lg:w-2/3 mb-6 lg:mb-0 lg:pl-4 lg:pr-4 mt-2">
            <h3 class="text-lg font-semibold mb-6">Profile Information</h3>

            <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm text-gray-600 mb-2" for="admin-id">Admin ID</label>
                    <input type="text" id="admin-id" class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2" value="1000001" disabled>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2" for="first-name">First Name</label>
                    <input type="text" id="first-name" class="w-full border border-gray-300 rounded-lg p-2" value="Admin">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2" for="last-name">Last Name</label>
                    <input type="text" id="last-name" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Enter Last Name">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2" for="username">Username</label>
                    <input type="text" id="username" class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2" value="admin" disabled>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2" for="email">Email</label>
                    <input type="email" id="email" class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2" value="admin@huanfitness.com" disabled>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2" for="gender">Gender</label>
                    <input type="text" id="gender" class="w-full border border-gray-300 rounded-lg p-2" value="Male">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2" for="dob">Date of Birth</label>
                    <input type="date" id="dob" class="w-full border border-gray-300 rounded-lg p-2" value="2024-05-20">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-2" for="phone">Phone Number</label>
                    <input type="text" id="phone" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Enter Phone Number">
                </div>

                <div class="mb-6">
                    <label class="block text-sm text-gray-600 mb-2" for="salary">Monthly Salary</label>
                    <input type="text" id="salary" class="w-full border border-gray-300 bg-gray-100 rounded-lg p-2" value="RM 5,000.00" disabled>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <button class="w-full bg-indigo-600 text-white font-bold py-3 rounded-full hover:bg-indigo-500 transition">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="w-full lg:w-1/3 flex items-center justify-center lg:h-[70vh]">
            <div class="flex flex-col items-center justify-center">
                <h3 class="text-lg font-semibold text-gray-600 mb-5">Profile Photo</h3>
                <div class="relative flex flex-col items-center">
                    <img src="../../../public/images/avatar.png" alt="Profile Photo" class="w-48 h-48 rounded-3xl shadow-lg object-cover mb-10">
                    <button class="bg-gray-900 text-white py-1.5 px-10 rounded-full hover:bg-gray-700 transition">Upload Photo</button>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>