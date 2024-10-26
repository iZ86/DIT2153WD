<?php

class AdminClassesView {
    private $classes;
    private $schedules;

    public function __construct($classes, $schedules) {
        $this->classes = $classes;
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
                    <h2 class="text-2xl font-bold">Classes</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                            <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button onclick="openClassModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class="bx bxs-plus-circle"></i>
                            <span>Add Class</span>
                        </button>
                        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" style="left: 240px; width: calc(100% - 250px);"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
                <table class="min-w-full table-auto border-collapse w-full">
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
                        <tr class="bg-white">
                            <td class="p-3"><?php echo $class['fitnessClassID']; ?></td>
                            <td class="p-3"><?php echo $class['name']; ?></td>
                            <td class="p-3"><?php echo $class['description']; ?></td>
                            <td class="p-3 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600" onclick="openEditClassModal(<?php echo $class['fitnessClassID']; ?>, '<?php echo $class['name']; ?>', '<?php echo $class['description']; ?>')">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <button class="text-gray-500 hover:text-red-600">
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
                    <h2 class="text-2xl font-bold">Classes Schedule</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
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
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Schedule ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Class Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Instructor</th>
                        <th class="py-4 px-6 border-b border-gray-200">Pax</th>
                        <th class="py-4 px-6 border-b border-gray-200">Scheduled On</th>
                        <th class="py-4 px-6 border-b border-gray-200">Created Date</th>
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
                            <td class="p-3"><?php echo date('d M Y', strtotime($schedule['scheduledOn'])); ?></td>
                            <td class="p-3"><?php echo date('d M Y', strtotime($schedule['createdOn'])); ?></td>
                            <td class="p-3 flex justify-center space-x-2">
                                <!--TODO: Pop up edit modal-->
                                <button class="text-gray-500 hover:text-blue-600">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <button class="text-gray-500 hover:text-red-600">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div id="classModal" class="fixed inset-0 flex items-center justify-center hidden">
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
                        <button type="button" onclick="closeClassModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="submitClassButton" name="addClassButton" value="Add Class" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="scheduleModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <!--TODO: Allow to choose options for class name and instructor-->
                <h2 id="scheduleModalTitle" class="text-2xl font-semibold mb-4">Add Schedule</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <label class="block text-gray-700 text-sm font-medium">Class Name <span class="text-red-500">*</span></label>
                    <input name="scheduleClassName" type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Instructor <span class="text-red-500">*</span></label>
                    <input name="instructor" type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Pax <span class="text-red-500">*</span></label>
                    <input name="pax" type="number" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Scheduled On <span class="text-red-500">*</span></label>
                    <input name="scheduledOn" type="date" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeScheduleModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="submitScheduleButton" name="addScheduleButton" value="Add Schedule" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openClassModal() {
                document.getElementById('classModal').classList.remove('hidden');
                document.getElementById('modalOverlay').classList.remove('hidden');
                document.getElementById('classModalTitle').innerText = 'Add Class';
                document.getElementById('submitClassButton').name = 'addClassButton';
                document.getElementById('submitClassButton').value = 'Add Class';
                clearClassModalFields();
            }

            function openEditClassModal(id, name, description) {
                document.getElementById('classModal').classList.remove('hidden');
                document.getElementById('modalOverlay').classList.remove('hidden');
                document.getElementById('classModalTitle').innerText = 'Edit Class';
                document.getElementById('fitnessClassID').value = id;
                document.getElementById('className').value = name;
                document.getElementById('classDescription').value = description;
                document.getElementById('submitClassButton').name = 'editClassButton';
                document.getElementById('submitClassButton').value = 'Edit Class';
            }

            function closeClassModal() {
                document.getElementById('classModal').classList.add('hidden');
                document.getElementById('modalOverlay').classList.add('hidden');
                clearClassModalFields();
            }

            function clearClassModalFields() {
                document.getElementById('fitnessClassID').value = '';
                document.getElementById('className').value = '';
                document.getElementById('classDescription').value = '';
            }

            function openScheduleModal() {
                document.getElementById('scheduleModal').classList.remove('hidden');
                document.getElementById('modalOverlay').classList.remove('hidden');
                document.getElementById('scheduleModalTitle').innerText = 'Add Schedule';
                clearScheduleModalFields();
            }

            function closeScheduleModal() {
                document.getElementById('scheduleModal').classList.add('hidden');
                document.getElementById('modalOverlay').classList.add('hidden');
                clearScheduleModalFields();
            }

            function clearScheduleModalFields() {
                document.querySelector('input[name="scheduleClassName"]').value = '';
                document.querySelector('input[name="instructor"]').value = '';
                document.querySelector('input[name="pax"]').value = '';
                document.querySelector('input[name="scheduledOn"]').value = '';
            }
        </script>
        <?php
    }
}
