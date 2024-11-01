<?php
class AdminClassesView {
    private $classes;
    private $schedules;
    private $instructors;
    private $totalPagesClasses;
    private $totalPagesSchedules;
    private $currentPage;
    private $noClassesFound;
    private $noSchedulesFound;

    public function __construct($classes, $schedules, $instructors, $totalPagesClasses, $totalPagesSchedules, $currentPage, $noClassesFound, $noSchedulesFound) {
        $this->classes = $classes;
        $this->schedules = $schedules;
        $this->instructors = $instructors;
        $this->totalPagesClasses = $totalPagesClasses;
        $this->totalPagesSchedules = $totalPagesSchedules;
        $this->currentPage = $currentPage;
        $this->noClassesFound = $noClassesFound;
        $this->noSchedulesFound = $noSchedulesFound;
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
                        <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
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
                    <?php if ($this->noClassesFound): ?>
                        <tr>
                            <td colspan="4" class="py-4">No records found.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($class = $this->classes->fetch_assoc()): ?>
                            <tr class="bg-white class-row">
                                <td class="p-3"><?php echo $class['fitnessClassID']; ?></td>
                                <td class="p-3"><?php echo $class['name']; ?></td>
                                <td class="p-3"><?php echo $class['description']; ?></td>
                                <td class="p-3 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600"
                                            onclick="openPhotoModal('<?php echo $class['fitnessClassImageFilePath']; ?>')">
                                        <i class="bx bx-image"></i>
                                    </button>
                                    <button class="text-gray-500 hover:text-blue-600"
                                            onclick="openEditClassModal(<?php echo $class['fitnessClassID']; ?>, '<?php echo ($class['name']); ?>', '<?php echo ($class['description']); ?>')">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
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
                        <button onclick="openScheduleFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
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
                        <th class="py-4 px-6 border-b border-gray-200">Status</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php if ($this->noSchedulesFound): ?>
                        <tr>
                            <td colspan="7" class="py-4">No records found.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($schedule = $this->schedules->fetch_assoc()): ?>
                            <tr class="bg-white">
                                <td class="p-3"><?php echo $schedule['fitnessClassScheduleID']; ?></td>
                                <td class="p-3"><?php echo $schedule['className']; ?></td>
                                <td class="p-3"><?php echo $schedule['instructor']; ?></td>
                                <td class="p-3"><?php echo $schedule['pax']; ?></td>
                                <td class="p-3"><?php echo date('d M Y h:i A', strtotime($schedule['scheduledOn'])); ?></td>
                                <td class="p-3 mt-4">
                                        <span class="bg-<?php echo $schedule['status'] === 'Upcoming' ? 'blue' : ($schedule['status'] === 'In Progress' ? 'green' : 'gray'); ?>-100 text-<?php echo $schedule['status'] === 'Upcoming' ? 'blue' : ($schedule['status'] === 'In Progress' ? 'green' : 'gray'); ?>-700 text-sm font-medium px-3 py-1 rounded-lg">
                                            <?php echo $schedule['status']; ?>
                                        </span>
                                </td>
                                <td class="p-3 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openEditScheduleModal(<?php echo $schedule['fitnessClassScheduleID']; ?>, '<?php echo $schedule['fitnessClassID']; ?>', '<?php echo $schedule['instructorID']; ?>', '<?php echo $schedule['pax']; ?>', '<?php echo date('Y-m-d', strtotime($schedule['scheduledOn'])); ?>', '<?php echo date('H:i', strtotime($schedule['scheduledOn'])); ?>')">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
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

        <div id="photoModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-xl p-6">
                <img id="photoModalImage" src="" alt="Classes Photo" class="rounded-lg">
                <button onclick="closePhotoModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mt-4">Close</button>
            </div>
        </div>

        <div id="filterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Classes</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="name">Name</option>
                        <option value="description">Description</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="keywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="../admin/classes.php"class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="scheduleFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Schedule</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="scheduleFilterType" id="scheduleFilterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="className">Class Name</option>
                        <option value="instructor">Instructor</option>
                        <option value="pax">Pax</option>
                        <option value="status">Status</option>
                        <option value="scheduledOn">Scheduled On</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="scheduleKeywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeScheduleFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="../admin/classes.php" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="classModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 max-h-screen overflow-y-auto sm:mx-6 lg:mx-8">
                <h2 id="classModalTitle" class="text-2xl font-semibold mb-4">Add Class</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="fitnessClassID" id="fitnessClassID">

                    <label class="block text-gray-700 text-sm font-medium">Class Name <span class="text-red-500">*</span></label>
                    <input name="name" type="text" id="className" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="classDescription" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required></textarea>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Upload Image</label>
                    <input type="file" name="classImage" accept="image/*" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1">

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeClassModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitClassButton" name="addClassButton" value="Add Class" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="scheduleModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 max-h-screen overflow-y-auto sm:mx-6 lg:mx-8">
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
            function openPhotoModal(imagePath) {
                document.getElementById('photoModalImage').src = imagePath;
                const modal = document.getElementById('photoModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closePhotoModal() {
                const modal = document.getElementById('photoModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
            }

            function openFilterModal() {
                const modal = document.getElementById('filterModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeFilterModal() {
                const modal = document.getElementById('filterModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
            }

            function openScheduleFilterModal() {
                const modal = document.getElementById('scheduleFilterModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeScheduleFilterModal() {
                const modal = document.getElementById('scheduleFilterModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
            }

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
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = 'https://placehold.co/640x360/png?text=No+Image+Available';
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
