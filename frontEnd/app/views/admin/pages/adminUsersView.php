<?php include '../components/header.php'; ?>
<?php include '../components/sidebar.php'; ?>
<?php include '../components/navbar.php'; ?>

    <section class="p-6 space-y-6">
        <div class="mx-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold">Users</h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                        <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>

                    <button onclick="openModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                        <i class="bx bxs-plus-circle"></i>
                        <span>Add User</span>
                    </button>

                    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" style="left: 240px; width: calc(100% - 250px);"></div>

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
                    <th class="py-4 px-6 border-b border-gray-200">Name</th>
                    <th class="py-4 px-6 border-b border-gray-200">Phone</th>
                    <th class="py-4 px-6 border-b border-gray-200">Email</th>
                    <th class="py-4 px-6 border-b border-gray-200">Gender</th>
                    <th class="py-4 px-6 border-b border-gray-200">Membership</th>
                    <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 text-center">
                <tr class="bg-white">
                    <td class="p-3 mt-4">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                    </td>

                    <!--TODO: username below the first name and last name-->
                    <td class="p-3 mt-4">1</td>
                    <td class="p-3 mt-4">Emily Johnson</td>
                    <td class="p-3 mt-4">(60) 18-666 8888</td>
                    <td class="p-3 mt-4">emily@gmail.com</td>
                    <td class="p-3 mt-4">Male</td>
                    <td class="p-3 mt-4">
                        <span class="bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-lg">Active</span>
                    </td>
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
                    <td class="p-3">2</td>
                    <td class="p-3">Anabelle Tan</td>
                    <td class="p-3">(60) 12-520 1314</td>
                    <td class="p-3">anbtan@gmail.com</td>
                    <td class="p-3 mt-4">Male</td>
                    <td class="p-3 mt-4">
                        <span class="bg-red-100 text-red-700 text-sm font-medium px-3 py-1 rounded-lg">Inactive</span>
                    </td>
                    <td class="p-3 flex justify-center space-x-2">
                        <button class="text-gray-500 hover:text-blue-600" onclick="openEditModal()">
                            <i class="bx bx-pencil"></i>
                        </button>
                        <button class="text-gray-500 hover:text-red-600 delete-button" onclick="openDeleteModal()">
                            <i class="bx bx-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>

    <div id="addUserModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
            <h2 class="text-2xl font-semibold mb-4">Add User</h2>
            <hr class="py-2">
            <form>
                <label class="block text-gray-700 text-sm font-medium">Email <span class="text-red-500">*</span></label>
                <input type="email" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none" required>

                <label class="block text-gray-700 text-sm font-medium mt-4">Username <span class="text-red-500">*</span></label>
                <input type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none" required>

                <div class="flex space-x-4 mt-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none" required>
                    </div>
                </div>

                <div class="flex space-x-4 mt-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                        <select class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <label class="block text-gray-700 text-sm font-medium mt-4">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none" required>

                <label class="block text-gray-700 text-sm font-medium mt-4">Password <span class="text-red-500">*</span></label>
                <input type="password" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-red-200 focus:border-red-500 outline-none" required>

                <div class="flex justify-end mt-10">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editUserModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
            <h2 class="text-2xl font-semibold mb-4">Edit User</h2>
            <hr class="py-2">
            <form>
                <!-- User ID and Username (Read-Only) -->
                <div class="flex space-x-4 mt-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">User ID</label>
                        <input type="text" value="2" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 bg-gray-100" readonly>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Username</label>
                        <input type="text" value="anabelle123" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 bg-gray-100" readonly>
                    </div>
                </div>

                <!-- Email Field -->
                <label class="block text-gray-700 text-sm font-medium mt-4">Email <span class="text-red-500">*</span></label>
                <input type="email" value="anbtan@gmail.com" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                <!-- First Name and Last Name Field -->
                <div class="flex space-x-4 mt-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                        <input type="text" value="Anabelle" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" value="Tan" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                    </div>
                </div>

                <!-- Date of Birth and Gender Field -->
                <div class="flex space-x-4 mt-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" value="2005-05-20" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                        <select class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                            <option value="Female" selected>Female</option>
                            <option value="Male">Male</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <label class="block text-gray-700 text-sm font-medium mt-4">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" value="(60) 12-520 1314" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none" required>

                <!-- Password Field -->
                <label class="block text-gray-700 text-sm font-medium mt-4">Password <span class="text-red-500">*</span></label>
                <input type="password" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                <!-- Action Buttons -->
                <div class="flex justify-end mt-6">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg mr-2">Close</button>
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteConfirmModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-sm font-semibold leading-6 text-gray-900" id="modal-title">Delete account</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to delete this user account? This user data will be permanently removed. This action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" class="confirm-delete-button inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                        <button type="button" class="cancel-button mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include '../components/footer.php'; ?>

<script>
    function openModal() {
        document.getElementById('addUserModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addUserModal').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    }

    function openEditModal() {
        document.getElementById('editUserModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editUserModal').classList.add('hidden');
        document.getElementById('modalOverlay').classList.add('hidden');
    }


    function openDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }

    // Function to close the modal
    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
    }

    function confirmDelete() {
        closeDeleteModal();
        alert("User account deactivated successfully.");
    }

    // Add event listeners for the buttons within the modal
    document.addEventListener("DOMContentLoaded", function() {
        // Open modal on delete button click
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', openDeleteModal);
        });

        // Close modal on cancel button click
        document.querySelector('.cancel-button').addEventListener('click', closeDeleteModal);

        // Confirm delete action on deactivate button click
        document.querySelector('.confirm-delete-button').addEventListener('click', confirmDelete);
    });
</script>