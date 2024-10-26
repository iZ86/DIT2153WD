<?php

class AdminUsersView {
    private $users;

    public function __construct($users) {
        $this->users = $users;
    }

    public function renderView() : void {
        $this->renderHeader();
        $this->renderSidebar();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    public function renderHeader() : void {
        include __DIR__ . '/../components/adminHeader.php';
    }

    public function renderSidebar() : void {
        include __DIR__ . '/../components/adminSidebar.php';
    }

    public function renderNavbar() : void {
        include __DIR__ . '/../components/adminNavbar.php';
    }

    public function renderFooter() : void {
        include __DIR__ . '/../components/adminFooter.php';
    }

    public function renderContent() : void {
        ?>
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
                    <?php while ($user = $this->users->fetch_assoc()): ?>
                        <tr class="bg-white">
                            <td class="p-3 mt-4"><?php echo $user['registeredUserID']; ?></td>
                            <td class="p-3 mt-4"><?php echo $user['fullName']; ?></td>
                            <td class="p-3 mt-4"><?php echo $user['phoneNo']; ?></td>
                            <td class="p-3 mt-4"><?php echo $user['email']; ?></td>
                            <td class="p-3 mt-4"><?php echo $user['gender']; ?></td>
                            <td class="p-3 mt-4">
                                <span class="bg-<?php echo $user['membershipStatus'] === 'Active' ? 'green' : 'red'; ?>-100 text-<?php echo $user['membershipStatus'] === 'Active' ? 'green' : 'red'; ?>-700 text-sm font-medium px-3 py-1 rounded-lg"><?php echo $user['membershipStatus']; ?></span>
                            </td>
                            <td class="p-3 mt-4 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600" onclick="openEditModal(<?php echo $user['registeredUserID']; ?>, '<?php echo $user['firstName']; ?>', '<?php echo $user['lastName']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phoneNo']; ?>', '<?php echo $user['gender']; ?>', '<?php echo $user['dateOfBirth']; ?>')">
                                    <i class="bx bx-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div id="userModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Add User</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="registeredUserID" name="registeredUserID">
                    <label class="block text-gray-700 text-sm font-medium">Email <span class="text-red-500">*</span></label>
                    <input name="email" type="email" id="email" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                            <input name="firstName" type="text" id="firstName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                            <input name="lastName" type="text" id="lastName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                            <input name="dateOfBirth" type="date" id="dateOfBirth" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Phone Number <span class="text-red-500">*</span></label>
                    <input name="phoneNo" type="tel" id="phoneNo" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Password <span class="text-red-500">*</span></label>
                    <input name="password" type="password" id="password" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="submitButton" name="editUserButton" value="Edit User" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openModal() {
                document.getElementById('userModal').classList.remove('hidden');
                document.getElementById('modalOverlay').classList.remove('hidden');
                document.getElementById('modalTitle').innerText = 'Add User';
                document.getElementById('submitButton').name = 'addUserButton';
                document.getElementById('submitButton').value = 'Add User';
                clearModalFields();
            }

            function openEditModal(id, firstName, lastName, email, phoneNo, gender, dateOfBirth) {
                document.getElementById('userModal').classList.remove('hidden');
                document.getElementById('modalOverlay').classList.remove('hidden');
                document.getElementById('modalTitle').innerText = 'Edit User';
                document.getElementById('registeredUserID').value = id;
                document.getElementById('firstName').value = firstName;
                document.getElementById('lastName').value = lastName;
                document.getElementById('email').value = email;
                document.getElementById('phoneNo').value = phoneNo;
                document.getElementById('gender').value = gender;
                document.getElementById('dateOfBirth').value = dateOfBirth;
                document.getElementById('submitButton').name = 'editUserButton';
                document.getElementById('submitButton').value = 'Edit User';
            }

            function closeModal() {
                document.getElementById('userModal').classList.add('hidden');
                document.getElementById('modalOverlay').classList.add('hidden');
                clearModalFields();
            }

            function clearModalFields() {
                document.getElementById('registeredUserID').value = '';
                document.getElementById('firstName').value = '';
                document.getElementById('lastName').value = '';
                document.getElementById('email').value = '';
                document.getElementById('phoneNo').value = '';
                document.getElementById('gender').value = '';
                document.getElementById('dateOfBirth').value = '';
                document.getElementById('password').value = '';
            }
        </script>
        <?php
    }
}
