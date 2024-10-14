<?php include '../components/header.php'; ?>
<?php include '../components/sidebar.php'; ?>
<?php include '../components/navbar.php'; ?>

<section class="p-6 space-y-6">
    <div class="mx-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Payments</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                    <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
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
                    <th class="py-4 px-6 border-b border-gray-200">Details</th>
                    <th class="py-4 px-6 border-b border-gray-200">UID</th>
                    <th class="py-4 px-6 border-b border-gray-200">Amount (RM)</th>
                    <th class="py-4 px-6 border-b border-gray-200">Date</th>
                    <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-center">
                <tr class="bg-white">
                    <td class="p-3 mt-4">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                    </td>
                    <td class="p-3 mt-4">#230907106</td>
                    <td class="p-3 mt-4">Monthly Subscription</td>
                    <td class="p-3 mt-4">10001</td>
                    <td class="p-3 mt-4">35.00</td>
                    <td class="p-3 mt-4">2024-09-05 / 12:00</td>
                    <td class="p-3  mt-4 flex justify-center space-x-2">
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
                    <td class="p-3">#230907105</td>
                    <td class="p-3">Monthly Subscription</td>
                    <td class="p-3">10002</td>
                    <td class="p-3">70.00</td>
                    <td class="p-3">2024-08-30 / 08:35</td>
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