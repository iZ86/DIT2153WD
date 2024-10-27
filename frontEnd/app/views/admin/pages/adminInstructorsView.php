<?php
class AdminInstructorsView {
    private $instructors;

    public function __construct($instructors) {
        $this->instructors = $instructors;
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
            <!--TODO: AJAX Button Page-->
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Instructors</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                            <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2" onclick="openInstructorModal()">
                            <i class="bx bxs-plus-circle"></i>
                            <span>Add Instructor</span>
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
                            <th class="py-4 px-6 border-b border-gray-200">Name</th>
                            <th class="py-4 px-6 border-b border-gray-200">Phone</th>
                            <th class="py-4 px-6 border-b border-gray-200">Email</th>
                            <th class="py-4 px-6 border-b border-gray-200">Gender</th>
                            <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                        <?php while ($instructor = $this->instructors->fetch_assoc()): ?>
                            <tr class="bg-white">
                                <td class="p-3">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                                </td>
                                <td class="p-3"><?php echo $instructor['instructorID']; ?></td>
                                <td class="p-3"><?php echo $instructor['firstName'] . ' ' . $instructor['lastName']; ?></td>
                                <td class="p-3"><?php echo $instructor['phoneNo']; ?></td>
                                <td class="p-3"><?php echo $instructor['email']; ?></td>
                                <td class="p-3"><?php echo $instructor['gender']; ?></td>
                                <td class="p-3 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openEditInstructorModal(<?php echo $instructor['instructorID']; ?>)">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                    <button class="text-gray-500 hover:text-red-600" onclick="deleteInstructor(<?php echo $instructor['instructorID']; ?>)">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="instructorModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 id="instructorModalTitle" class="text-2xl font-semibold mb-4">Add Instructor</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="instructorID" name="instructorID">

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                            <input name="firstName" type="text" id="firstName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                            <input name="lastName" type="text" id="lastName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Email <span class="text-red-500">*</span></label>
                    <input name="email" type="email" id="email" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="w-full border border-gray-300 rounded-lg py-2 px-3" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                            <input name="dateOfBirth" type="date" id="dateOfBirth" class="w-full border border-gray-300 rounded-lg py-2 px-3" required>
                        </div>
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Phone No <span class="text-red-500">*</span></label>
                    <input name="phoneNo" type="text" id="phoneNo" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Weight</label>
                            <input name="weight" type="text" id="weight" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Height</label>
                            <input name="height" type="text" id="height" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">
                        </div>
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Certification</label>
                    <input name="certification" type="text" id="certification" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <label class="block text-gray-700 text-sm font-medium mt-4">Description</label>
                    <textarea name="description" id="description" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1"></textarea>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeInstructorModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitInstructorButton" name="addInstructorButton" value="Add Instructor" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <style>
            .modal {
                transition: opacity 0.3s ease, transform 0.3s ease;
                opacity: 0;
                transform: scale(0.9);
                pointer-events: none;
            }

            .modal.show {
                opacity: 1;
                transform: scale(1);
                pointer-events: auto;
            }
        </style>

        <script>
            function openInstructorModal() {
                const modal = document.getElementById('instructorModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeInstructorModal() {
                const modal = document.getElementById('instructorModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
                clearInstructorModalFields();
            }

            function openEditInstructorModal(instructorID) {
                fetch(`../../controllers/admin/instructors.php?action=getInstructorDetails&id=${instructorID}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            const modal = document.getElementById('instructorModal');
                            const overlay = document.getElementById('modalOverlay');

                            modal.classList.remove('hidden');
                            overlay.classList.remove('hidden');

                            document.getElementById('instructorID').value = data.instructorID;
                            document.getElementById('firstName').value = data.firstName;
                            document.getElementById('lastName').value = data.lastName;
                            document.getElementById('phoneNo').value = data.phoneNo;
                            document.getElementById('email').value = data.email;
                            document.getElementById('gender').value = data.gender;
                            document.getElementById('weight').value = data.weight;
                            document.getElementById('height').value = data.height;
                            document.getElementById('description').value = data.description;
                            document.getElementById('certification').value = data.certification;
                            document.getElementById('dateOfBirth').value = data.dateOfBirth;
                            document.getElementById('instructorModalTitle').innerText = 'Edit Instructor';
                            document.getElementById('submitInstructorButton').name = 'editInstructorButton';
                            document.getElementById('submitInstructorButton').value = 'Edit Instructor';

                            setTimeout(() => {
                                modal.classList.add('show');
                            }, 10);
                        } else {
                            console.error('No data found for the instructor.');
                        }
                    })
                    .catch(error => console.error('Error fetching instructor details:', error));
            }

            function clearInstructorModalFields() {
                document.getElementById('instructorID').value = '';
                document.getElementById('firstName').value = '';
                document.getElementById('lastName').value = '';
                document.getElementById('phoneNo').value = '';
                document.getElementById('email').value = '';
                document.getElementById('gender').value = '';
                document.getElementById('weight').value = '';
                document.getElementById('height').value = '';
                document.getElementById('description').value = '';
                document.getElementById('certification').value = '';
                document.getElementById('dateOfBirth').value = '';
            }
        </script>
        <?php
    }
}
