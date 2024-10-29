<?php

class AdminClassesView {
    private $classes;
    private $schedules;
    private $instructors;
    private $totalPagesClasses;
    private $totalPagesSchedules;
    private $currentPage;

    public function __construct($classes, $schedules, $instructors, $totalPagesClasses, $totalPagesSchedules, $currentPage) {
        $this->classes = $classes;
        $this->schedules = $schedules;
        $this->instructors = $instructors;
        $this->totalPagesClasses = $totalPagesClasses;
        $this->totalPagesSchedules = $totalPagesSchedules;
        $this->currentPage = $currentPage;
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

        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Classes</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" id="classSearch" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                            <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button onclick="openClassModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class="bx bxs-plus-circle"></i>
                            <span>Add Class</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
                <table class="min-w-full table-auto border-collapse w-full" id="classesTable">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Class ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Description</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php while ($class = $this->classes->fetch_assoc()): ?>
                        <tr class="bg-white class-row">
                            <td class="p-3"><?php echo $class['fitnessClassID']; ?></td>
                            <td class="p-3"><?php echo $class['name']; ?></td>
                            <td class="p-3"><?php echo $class['description']; ?></td>
                            <td class="p-3 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600" onclick="openEditClassModal(<?php echo $class['fitnessClassID']; ?>, '<?php echo addslashes($class['name']); ?>', '<?php echo addslashes($class['description']); ?>')">
                                    <i class="bx bx-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <nav aria-label="Page navigation">
                    <ul class="flex space-x-2 mr-4">
                        <?php for ($i = 1; $i <= $this->totalPagesClasses; $i++): ?>
                            <li>
                                <a href="?page=<?php echo $i; ?>" class="px-4 py-2 border rounded-md
                        <?php echo $i == $this->currentPage ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500 hover:bg-indigo-600 hover:text-white'; ?>
                        transition">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </section>

        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Classes Schedule</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" id="classSearch" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                            <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button onclick="openScheduleModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class="bx bxs-plus-circle"></i>
                            <span>Add Schedule</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
                <table class="min-w-full table-auto border-collapse w-full">
                    <thead>

                    <!--TODO: Add a status row which is active or inactive-->
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Schedule ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Class Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Instructor</th>
                        <th class="py-4 px-6 border-b border-gray-200">Pax</th>
                        <th class="py-4 px-6 border-b border-gray-200">Scheduled On</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php while ($schedule = $this->schedules->fetch_assoc()): ?>
                        <tr class="bg-white">
                            <td class="p-3"><?php echo $schedule['fitnessClassScheduleID']; ?></td>
                            <td class="p-3"><?php echo $schedule['className']; ?></td>
                            <td class="p-3"><?php echo $schedule['instructor']; ?></td>
                            <td class="p-3"><?php echo $schedule['pax']; ?></td>
                            <td class="p-3"><?php echo date('d M Y h:i A', strtotime($schedule['scheduledOn'])); ?></td>
                            <td class="p-3 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600" onclick="openEditScheduleModal(<?php echo $schedule['fitnessClassScheduleID']; ?>, '<?php echo $schedule['fitnessClassID']; ?>', '<?php echo $schedule['instructorID']; ?>', <?php echo $schedule['pax']; ?>, '<?php echo $schedule['scheduledOn']; ?>')">
                                    <i class="bx bx-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <nav aria-label="Page navigation">
                    <ul class="flex space-x-2 mr-4">
                        <?php for ($i = 1; $i <= $this->totalPagesSchedules; $i++): ?>
                            <li>
                                <a href="?page=<?php echo $i; ?>" class="px-4 py-2 border rounded-md
                        <?php echo $i == $this->currentPage ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500 hover:bg-indigo-600 hover:text-white'; ?>
                        transition">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="classModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 id="classModalTitle" class="text-2xl font-semibold mb-4">Add Class</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="fitnessClassID" name="fitnessClassID">
                    <label class="block text-gray-700 text-sm font-medium">Class Name <span class="text-red-500">*</span></label>
                    <input name="name" type="text" id="className" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="classDescription" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required></textarea>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeClassModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitClassButton" name="addClassButton" value="Add Class" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="scheduleModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 id="scheduleModalTitle" class="text-2xl font-semibold mb-4">Add Schedule</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="fitnessClassScheduleID" id="fitnessClassScheduleID">
                    <label class="block text-gray-700 text-sm font-medium">Class Name <span class="text-red-500">*</span></label>
                    <select name="fitnessClassID" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Select Class</option>
                        <?php
                        $this->classes->data_seek(0);
                        while ($class = $this->classes->fetch_assoc()): ?>
                            <option value="<?php echo $class['fitnessClassID']; ?>"><?php echo $class['name']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Instructor <span class="text-red-500">*</span></label>
                    <select name="instructorID" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Select Instructor</option>
                        <?php
                        $this->instructors->data_seek(0);
                        while ($instructor = $this->instructors->fetch_assoc()): ?>
                            <option value="<?php echo $instructor['instructorID']; ?>"><?php echo $instructor['fullName']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Pax <span class="text-red-500">*</span></label>
                    <input name="pax" type="number" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Scheduled On <span class="text-red-500">*</span></label>
                    <div class="flex space-x-4">
                        <input name="scheduledOnDate" type="date" id="scheduledOnDate" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <input name="scheduledOnTime" type="time" id="scheduledOnTime" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeScheduleModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitScheduleButton" name="addScheduleButton" value="Add Schedule" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openClassModal() {
                const modal = document.getElementById('classModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeClassModal() {
                const modal = document.getElementById('classModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                    clearClassModalFields();
                }, 300);
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

            function openEditClassModal(id, name, description) {
                const modal = document.getElementById('classModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');
                document.getElementById('classModalTitle').innerText = 'Edit Class';
                document.getElementById('fitnessClassID').value = id;
                document.getElementById('className').value = name;
                document.getElementById('classDescription').value = description;
                document.getElementById('submitClassButton').name = 'editClassButton';
                document.getElementById('submitClassButton').value = 'Edit Class';

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function openEditScheduleModal(fitnessClassScheduleID, fitnessClassID, instructorID, pax, scheduledOn) {
                const modal = document.getElementById('scheduleModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');
                document.getElementById('scheduleModalTitle').innerText = 'Edit Schedule';
                document.getElementById('fitnessClassScheduleID').value = fitnessClassScheduleID;
                document.querySelector('select[name="fitnessClassID"]').value = fitnessClassID;
                document.querySelector('select[name="instructorID"]').value = instructorID;
                document.querySelector('input[name="pax"]').value = pax;

                const date = new Date(scheduledOn);
                const formattedDate = date.toISOString().split('T')[0];
                const formattedTime = date.toTimeString().split(' ')[0].substring(0, 5);

                document.getElementById('scheduledOnDate').value = formattedDate;
                document.getElementById('scheduledOnTime').value = formattedTime;
                document.getElementById('submitScheduleButton').name = 'editScheduleButton';
                document.getElementById('submitScheduleButton').value = 'Edit Schedule';

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function clearClassModalFields() {
                document.getElementById('fitnessClassID').value = '';
                document.getElementById('className').value = '';
                document.getElementById('classDescription').value = '';
            }

            function clearScheduleModalFields() {
                document.querySelector('select[name="fitnessClassID"]').value = '';
                document.querySelector('select[name="instructorID"]').value = '';
                document.querySelector('input[name="pax"]').value = '';
                document.querySelector('input[name="scheduledOnDate"]').value = '';
                document.querySelector('input[name="scheduledOnTime"]').value = '';
            }
        </script>
        <?php
    }
}
