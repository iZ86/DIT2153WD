<?php

class AdminNutritionistsView {
    private $nutritionists;
    private $schedules;

    public function __construct($nutritionists, $schedules) {
        $this->nutritionists = $nutritionists;
        $this->schedules = $schedules;
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
                    <h2 class="text-2xl font-bold">Nutritionists</h2>
                    <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2" onclick="openNutritionistModal()">
                        <i class="bx bxs-plus-circle"></i>
                        <span>Add Nutritionist</span>
                    </button>
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
                        <th class="py-4 px-6 border-b border-gray-200">Type</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php while ($nutritionist = $this->nutritionists->fetch_assoc()): ?>
                        <tr class="bg-white">
                            <td class="p-3">
                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                            </td>
                            <td class="p-3"><?php echo $nutritionist['nutritionistID']; ?></td>
                            <td class="p-3"><?php echo $nutritionist['firstName'] . ' ' . $nutritionist['lastName']; ?></td>
                            <td class="p-3"><?php echo $nutritionist['phoneNo']; ?></td>
                            <td class="p-3"><?php echo $nutritionist['email']; ?></td>
                            <td class="p-3"><?php echo $nutritionist['gender']; ?></td>
                            <td class="p-3">
                                <span class="bg-blue-100 text-blue-700 text-sm font-medium px-3 py-1 rounded-lg"><?php echo $nutritionist['type']; ?></span>
                            </td>
                            <td class="p-3 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600" onclick="openEditNutritionistModal(<?php echo $nutritionist['nutritionistID']; ?>, '<?php echo addslashes($nutritionist['firstName']); ?>', '<?php echo addslashes($nutritionist['lastName']); ?>', '<?php echo addslashes($nutritionist['phoneNo']); ?>', '<?php echo addslashes($nutritionist['email']); ?>', '<?php echo addslashes($nutritionist['gender']); ?>', '<?php echo addslashes($nutritionist['type']); ?>')">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <button class="text-gray-500 hover:text-red-600" onclick="deleteNutritionist(<?php echo $nutritionist['nutritionistID']; ?>)">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Nutritionists Schedule</h2>
                    <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2" onclick="openScheduleModal()">
                        <i class="bx bxs-plus-circle"></i>
                        <span>Add Schedule</span>
                    </button>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
                <table class="min-w-full table-auto border-collapse w-full">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 w-12 border-b border-gray-200">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </th>
                        <th class="py-4 px-6 border-b border-gray-200">Schedule ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Nutritionist Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Booking Date</th>
                        <th class="py-4 px-6 border-b border-gray-200">Status</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php while ($schedule = $this->schedules->fetch_assoc()):
                        $currentDate = new DateTime();
                        $bookingDate = new DateTime($schedule['bookingDate']);
                        $status = ($bookingDate < $currentDate) ? "Inactive" : "Active";
                        ?>
                        <tr class="bg-white">
                            <td class="p-3">
                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                            </td>
                            <td class="p-3"><?php echo $schedule['nutritionistScheduleID']; ?></td>
                            <td class="p-3"><?php echo $schedule['nutritionistName']; ?></td>
                            <td class="p-3"><?php echo date('d M Y', strtotime($schedule['bookingDate'])); ?></td>
                            <td class="p-3 mt-4">
                                <span class="bg-<?php echo $status === 'Active' ? 'green' : 'red'; ?>-100 text-<?php echo $status === 'Active' ? 'green' : 'red'; ?>-700 text-sm font-medium px-3 py-1 rounded-lg">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td class="p-3 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600" onclick="openEditScheduleModal(<?php echo $schedule['nutritionistScheduleID']; ?>, '<?php echo addslashes($schedule['bookingDate']); ?>', '<?php echo addslashes($schedule['bookingTime']); ?>', '<?php echo addslashes($schedule['nutritionistID']); ?>')">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <!--TODO: Delete function-->
                                <button class="text-gray-500 hover:text-red-600" onclick="deleteSchedule(<?php echo $schedule['nutritionistScheduleID']; ?>)">
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

        <!-- Modal for Nutritionist -->
        <div id="nutritionistModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 id="nutritionistModalTitle" class="text-2xl font-semibold mb-4">Add Nutritionist</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="nutritionistID" name="nutritionistID">
                    <label class="block text-gray-700 text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                    <input name="firstName" type="text" id="firstName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Last Name <span class="text-red-500">*</span></label>
                    <input name="lastName" type="text" id="lastName" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Phone No <span class="text-red-500">*</span></label>
                    <input name="phoneNo" type="text" id="phoneNo" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Email <span class="text-red-500">*</span></label>
                    <input name="email" type="email" id="email" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" id="gender" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Type <span class="text-red-500">*</span></label>
                    <input name="type" type="text" id="type" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeNutritionistModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitNutritionistButton" name="addNutritionistButton" value="Add Nutritionist" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for Schedule -->
        <div id="scheduleModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 id="scheduleModalTitle" class="text-2xl font-semibold mb-4">Add Schedule</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="nutritionistScheduleID" id="nutritionistScheduleID">
                    <label class="block text-gray-700 text-sm font-medium">Nutritionist <span class="text-red-500">*</span></label>
                    <select name="nutritionistID" id="nutritionistID" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Select Nutritionist</option>
                        <?php
                        // Reset the nutritionists pointer to fetch data for the dropdown
                        $this->nutritionists->data_seek(0);
                        while ($nutritionist = $this->nutritionists->fetch_assoc()): ?>
                            <option value="<?php echo $nutritionist['nutritionistID']; ?>"><?php echo $nutritionist['firstName'] . ' ' . $nutritionist['lastName']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Booking Date <span class="text-red-500">*</span></label>
                    <input name="bookingDate" type="date" id="bookingDate" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Booking Time <span class="text-red-500">*</span></label>
                    <input name="bookingTime" type="time" id="bookingTime" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeScheduleModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitScheduleButton" name="addScheduleButton" value="Add Schedule" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
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
            function openNutritionistModal() {
                const modal = document.getElementById('nutritionistModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeNutritionistModal() {
                const modal = document.getElementById('nutritionistModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                    clearNutritionistModalFields();
                }, 300);
            }

            function openEditNutritionistModal(nutritionistID, firstName, lastName, phoneNo, email, gender, type) {
                const modal = document.getElementById('nutritionistModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                document.getElementById('nutritionistID').value = nutritionistID;
                document.getElementById('firstName').value = firstName;
                document.getElementById('lastName').value = lastName;
                document.getElementById('phoneNo').value = phoneNo;
                document.getElementById('email').value = email;
                document.getElementById('gender').value = gender;
                document.getElementById('type').value = type;
                document.getElementById('nutritionistModalTitle').innerText = 'Edit Nutritionist';

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function openScheduleModal() {
                const modal = document.getElementById('scheduleModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeScheduleModal() {
                const modal = document.getElementById('scheduleModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                    clearScheduleModalFields();
                }, 300);
            }

            function openEditScheduleModal(scheduleID, bookingDate, bookingTime, nutritionistID) {
                const modal = document.getElementById('scheduleModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                document.getElementById('nutritionistScheduleID').value = scheduleID;
                document.getElementById('nutritionistID').value = nutritionistID;
                document.querySelector('select[name="nutritionistID"]').value = nutritionistID;
                document.getElementById('bookingDate').value = bookingDate;
                document.getElementById('bookingTime').value = bookingTime;
                document.getElementById('scheduleModalTitle').innerText = 'Edit Schedule';

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }


            function clearNutritionistModalFields() {
                document.getElementById('nutritionistID').value = '';
                document.getElementById('firstName').value = '';
                document.getElementById('lastName').value = '';
                document.getElementById('phoneNo').value = '';
                document.getElementById('email').value = '';
                document.getElementById('gender').value = '';
                document.getElementById('type').value = '';
            }

            function clearScheduleModalFields() {
                document.getElementById('nutritionistScheduleID').value = '';
                document.getElementById('bookingDate').value = '';
                document.getElementById('bookingTime').value = '';
                document.getElementById('nutritionistID').value = '';
            }
        </script>
        <?php
    }
}