<?php include '../components/header.php'; ?>
<?php include '../components/sidebar.php'; ?>
<?php include '../components/navbar.php'; ?>


<section class="p-6 space-y-6">
    <div class="mx-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Feedbacks</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                    <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                    <i class="bx bxs-plus-circle"></i>
                    <span>Add Type</span>
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
        <table class="min-w-full table-auto border-collapse w-full">
            <thead>
                <tr class="text-gray-500 font-medium text-center">
                    <th class="py-4 px-6 w-12 border-b border-gray-200"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                    </th>
                    <th class="py-4 px-6 border-b border-gray-200">ID</th>
                    <th class="py-4 px-6 border-b border-gray-200">Topic</th>
                    <th class="py-4 px-6 border-b border-gray-200">UID</th>
                    <th class="py-4 px-6 border-b border-gray-200">Date</th>
                    <th class="py-4 px-6 border-b border-gray-200">Status</th>
                    <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-center">
                <tr class="bg-white">
                    <td class="p-3 mt-4">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                    </td>
                    <td class="p-3 mt-4">FE0002</td>
                    <td class="p-3 mt-4">Improve Facilities</td>
                    <td class="p-3 mt-4">10001</td>
                    <td class="p-3 mt-4">2024-08-15 / 08:00</td>
                    <td class="p-3 mt-4">
                        <span class="bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-lg">Completed</span>
                    </td>
                    <td class="p-3 mt-4 flex justify-center space-x-2">
                        <button class="text-gray-500 hover:text-blue-600">
                            <i class="bx bx-pencil"></i>
                        </button>
                        <button class="text-gray-500 hover:text-red-600">
                            <i class="bx bx-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr class="bg-white">
                    <td class="p-3">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                    </td>
                    <td class="p-3">FE0001</td>
                    <td class="p-3">Payment Problem</td>
                    <td class="p-3">10002</td>
                    <td class="p-3">2024-08-14 / 12:36</td>
                    <td class="p-3">
                        <span class="bg-red-100 text-red-700 text-sm font-medium px-3 py-1 rounded-lg">Cancelled</span>
                    </td>
                    <td class="p-3 flex justify-center space-x-2">
                        <button class="text-gray-500 hover:text-blue-600">
                            <i class="bx bx-pencil"></i>
                        </button>
                        <button class="text-gray-500 hover:text-red-600">
                            <i class="bx bx-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php include '../components/footer.php'; ?>