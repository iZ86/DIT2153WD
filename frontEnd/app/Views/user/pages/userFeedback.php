<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<section class="p-6 space-y-6 bg-indigo-50">
    <div class="mx-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Feedbacks</h2>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-900">
                    <i class="bx bx-filter text-2xl"></i>
                </button>

                <div class="relative">
                    <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                    <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                    <i class="bx bxs-plus-circle"></i>
                    <span>Create</span>
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
        <table class="min-w-full table-auto border-collapse w-full">
            <thead>
                <tr class="text-gray-500 font-medium text-left">
                    <th class="p-3 mt-4 border-b border-gray-200">Status</th>
                    <th class="p-3 mt-4 border-b border-gray-200">No</th>
                    <th class="p-3 mt-4 border-b border-gray-200">Topic</th>
                    <th class="p-3 mt-4 border-b border-gray-200">Date</th>
                    <th class="p-3 mt-4 border-b border-gray-200">Time</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-left">
                <tr class="bg-white">
                    <!--TODO: username below the first name and last name-->
                    <td class="p-3 mt-4">
                        <span class="bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-lg">Open</span>
                    </td>
                    <td class="p-3 mt-4">1</td>
                    <td class="p-3 mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a sollicitudin lorem. Etiam ullamcorper scelerisque ipsum, tempor egestas tellus laoreet eget. Fusce commodo eu ipsum vitae molestie.</td>
                    <td class="p-3 mt-4">15/10/24</td>
                    <td class="p-3 mt-4">12:10</td>
                </tr>
                <tr class="bg-white">
                    <!--TODO: username below the first name and last name-->
                    <td class="p-3 mt-4">
                        <span class="bg-red-100 text-red-700 text-sm font-medium px-3 py-1 rounded-lg">Closed</span>
                    </td>
                    <td class="p-3 mt-4">2</td>
                    <td class="p-3 mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                    <td class="p-3 mt-4">19/10/24</td>
                    <td class="p-3 mt-4">08:10</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php include '../components/footer.php'; ?>