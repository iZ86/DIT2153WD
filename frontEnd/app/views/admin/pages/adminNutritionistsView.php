<?php

class AdminNutritionistsView {
    private $nutritionists;
    private $schedules;
    private $bookings;
    private $totalPagesNutritionists;
    private $totalPagesSchedules;
    private $totalPagesBookings;
    private $currentPage;
    private $noNutritionistsFound;
    private $noSchedulesFound;
    private $noBookingsFound;

    public function __construct($nutritionists, $schedules, $bookings, $totalPagesNutritionists, $totalPagesSchedules, $totalPagesBookings, $currentPage, $noNutritionistsFound, $noSchedulesFound, $noBookingsFound) {
        $this->nutritionists = $nutritionists;
        $this->schedules = $schedules;
        $this->bookings = $bookings;
        $this->totalPagesNutritionists = $totalPagesNutritionists;
        $this->totalPagesSchedules = $totalPagesSchedules;
        $this->totalPagesBookings = $totalPagesBookings;
        $this->currentPage = $currentPage;
        $this->noNutritionistsFound = $noNutritionistsFound;
        $this->noSchedulesFound = $noSchedulesFound;
        $this->noBookingsFound = $noBookingsFound;
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
                    <div class="flex items-center space-x-4">
                        <button onclick="openNutritionistFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2" onclick="openNutritionistModal()">
                            <i class="bx bxs-plus-circle"></i>
                            <span>Add Nutritionist</span>
                        </button>
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
                        <th class="py-4 px-6 border-b border-gray-200">Type</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php if ($this->noNutritionistsFound): ?>
                        <tr>
                            <td colspan="7" class="py-4">No records found.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($nutritionist = $this->nutritionists->fetch_assoc()): ?>
                            <tr class="bg-white">
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
                        <?php for ($i = 1; $i <= $this->totalPagesNutritionists; $i++): ?>
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
                    <h2 class="text-2xl font-bold">Nutritionists Schedule</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openScheduleFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2" onclick="openScheduleModal()">
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
                        <th class="py-4 px-6 border-b border-gray-200">Nutritionist Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Scheduled On</th>
                        <th class="py-4 px-6 border-b border-gray-200">Price</th>
                        <th class="py-4 px-6 border-b border-gray-200">Status</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php if ($this->noSchedulesFound): ?>
                        <tr>
                            <td colspan="6" class="py-4">No records found.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($schedule = $this->schedules->fetch_assoc()): ?>
                            <tr class="bg-white">
                                <td class="p-3"><?php echo $schedule['nutritionistScheduleID']; ?></td>
                                <td class="p-3"><?php echo $schedule['nutritionistName']; ?></td>
                                <td class="p-3"><?php echo date('d M Y H:i', strtotime($schedule['scheduleDateTime'])); ?></td>
                                <td class="p-3"><?php echo number_format($schedule['price'], 2); ?></td>
                                <td class="p-3">
                                    <span class="bg-<?php echo $schedule['status'] === 'Upcoming' ? 'blue' : ($schedule['status'] === 'In Progress' ? 'green' : 'gray'); ?>-100 text-<?php echo $schedule['status'] === 'Upcoming' ? 'blue' : ($schedule['status'] === 'In Progress' ? 'green' : 'gray'); ?>-700 text-sm font-medium px-3 py-1 rounded-lg">
                                        <?php echo $schedule['status']; ?>
                                    </span>
                                </td>
                                <td class="p-3 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openEditScheduleModal(<?php echo $schedule['nutritionistScheduleID']; ?>, '<?php echo addslashes($schedule['scheduleDateTime']); ?>', '<?php echo number_format($schedule['price'], 2); ?>', '<?php echo $schedule['nutritionistID']; ?>')">
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

        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Nutritionist Bookings</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openBookingFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2" onclick="openBookingModal()">
                            <i class="bx bxs-plus-circle"></i>
                            <span>Add Booking</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
                <table class="min-w-full table-auto border-collapse w-full">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Booking ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Nutritionist Name</th>
                        <th class="py-4 px-6 border-b border-gray-200">Schedule ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Username</th>
                        <th class="py-4 px-6 border-b border-gray-200">Description</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php if ($this->noBookingsFound): ?>
                        <tr>
                            <td colspan="6" class="py-4">No records found.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($booking = $this->bookings->fetch_assoc()): ?>
                            <tr class="bg-white">
                                <td class="p-3"><?php echo $booking['nutritionistBookingID']; ?></td>
                                <td class="p-3"><?php echo $booking['nutritionistName']; ?></td>
                                <td class="p-3"><?php echo $booking['nutritionistScheduleID']; ?></td>
                                <td class="p-3"><?php echo $booking['username']; ?></td>
                                <td class="p-3"><?php echo $booking['description']; ?></td>
                                <td class="p-3 flex justify-center">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openEditBookingModal(<?php echo $booking['nutritionistBookingID']; ?>, '<?php echo addslashes($booking['description']); ?>', '<?php echo $booking['nutritionistScheduleID']; ?>')">
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
                        <?php for ($i = 1; $i <= $this->totalPagesBookings; $i++): ?>
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

        <!-- Nutritionist Filter Modal -->
        <div id="nutritionistFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Nutritionists</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="nutritionistFilterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="nutritionistID">Nutritionist ID</option>
                        <option value="name">Name</option>
                        <option value="phone">Phone</option>
                        <option value="email">Email</option>
                        <option value="gender">Gender</option>
                        <option value="type">Type</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="nutritionistKeywords" type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeNutritionistFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="../admin/nutritionists.php" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Schedule Filter Modal -->
        <div id="scheduleFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Schedule</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="scheduleFilterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="scheduleID">Schedule ID</option>
                        <option value="nutritionistName">Nutritionist Name</option>
                        <option value="scheduledOn">Scheduled On (YYYY-MM-DD)</option>
                        <option value="price">Price</option>
                        <option value="status">Status</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="scheduleKeywords" type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeScheduleFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="../admin/nutritionists.php" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Booking Filter Modal -->
        <div id="bookingFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Bookings</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="bookingFilterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="bookingID">Booking ID</option>
                        <option value="nutritionistName">Nutritionist Name</option>
                        <option value="scheduleID">Schedule ID</option>
                        <option value="username">Username</option>
                        <option value="description">Description</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="bookingKeywords" type="text" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeBookingFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="../admin/nutritionists.php" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="nutritionistModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 max-h-screen overflow-y-auto sm:mx-6 lg:mx-8">
                <h2 id="nutritionistModalTitle" class="text-2xl font-semibold mb-4">Add Nutritionist</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="nutritionistID" name="nutritionistID">
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

                    <label class="block text-gray-700 text-sm font-medium mt-4">Email <span class="text-red-500">*</span></label>
                    <input name="email" type="email" id="email" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Phone Number <span class="text-red-500">*</span></label>
                    <input name="phoneNo" type="text" id="phoneNo" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

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

        <div id="scheduleModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 max-h-screen overflow-y-auto sm:mx-6 lg:mx-8">
                <h2 id="scheduleModalTitle" class="text-2xl font-semibold mb-4">Add Schedule</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="nutritionistScheduleID" id="nutritionistScheduleID">
                    <label class="block text-gray-700 text-sm font-medium">Nutritionist <span class="text-red-500">*</span></label>
                    <select name="nutritionistID" id="nutritionistID" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Select Nutritionist</option>
                        <?php
                        $this->nutritionists->data_seek(0);
                        while ($nutritionist = $this->nutritionists->fetch_assoc()): ?>
                            <option value="<?php echo $nutritionist['nutritionistID']; ?>"><?php echo $nutritionist['firstName'] . ' ' . $nutritionist['lastName']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Schedule Date & Time <span class="text-red-500">*</span></label>
                    <input name="scheduleDateTime" type="datetime-local" id="scheduleDateTime" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Price <span class="text-red-500">*</span></label>
                    <input name="price" type="number" step="0.01" id="price" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeScheduleModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitScheduleButton" name="addScheduleButton" value="Add Schedule" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="bookingModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 max-h-screen overflow-y-auto sm:mx-6 lg:mx-8">
                <h2 id="bookingModalTitle" class="text-2xl font-semibold mb-4">Edit Booking</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="nutritionistBookingID" name="nutritionistBookingID">

                    <label class="block text-gray-700 text-sm font-medium">Description <span class="text-red-500">*</span></label>
                    <input name="description" type="text" id="description" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Nutritionist <span class="text-red-500">*</span></label>
                    <select name="nutritionistID" id="nutritionistID" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Select Nutritionist</option>
                        <?php
                        $this->nutritionists->data_seek(0);
                        while ($nutritionist = $this->nutritionists->fetch_assoc()): ?>
                            <option value="<?php echo $nutritionist['nutritionistID']; ?>" <?php echo ($nutritionist['nutritionistID'] == $currentNutritionistID) ? 'selected' : ''; ?>>
                                <?php echo $nutritionist['firstName'] . ' ' . $nutritionist['lastName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Schedule <span class="text-red-500">*</span></label>
                    <select name="nutritionistScheduleID" id="nutritionistScheduleID" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Select Schedule</option>
                        <?php
                        $this->schedules->data_seek(0);
                        while ($schedule = $this->schedules->fetch_assoc()): ?>
                            <option value="<?php echo $schedule['nutritionistScheduleID']; ?>" <?php echo ($schedule['nutritionistScheduleID'] == $currentScheduleID) ? 'selected' : ''; ?>>
                                <?php echo date('d M Y H:i', strtotime($schedule['scheduleDateTime'])); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeBookingModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitBookingButton" name="editBookingButton" value="Edit Booking" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
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
            function openNutritionistFilterModal() {
                const modal = document.getElementById('nutritionistFilterModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeNutritionistFilterModal() {
                const modal = document.getElementById('nutritionistFilterModal');
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

            function openBookingFilterModal() {
                const modal = document.getElementById('bookingFilterModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeBookingFilterModal() {
                const modal = document.getElementById('bookingFilterModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
            }

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
                document.getElementById('submitNutritionistButton').name = 'editNutritionistButton';
                document.getElementById('submitNutritionistButton').value = 'Edit Nutritionist';
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

            function openEditScheduleModal(scheduleID, scheduleDateTime, price, nutritionistID) {
                const modal = document.getElementById('scheduleModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                document.getElementById('nutritionistScheduleID').value = scheduleID;
                document.getElementById('nutritionistID').value = nutritionistID;
                document.querySelector('select[name="nutritionistID"]').value = nutritionistID;
                document.getElementById('scheduleDateTime').value = scheduleDateTime;
                document.getElementById('price').value = price;
                document.getElementById('submitScheduleButton').name = 'editScheduleButton';
                document.getElementById('submitScheduleButton').value = 'Edit Schedule';
                document.getElementById('scheduleModalTitle').innerText = 'Edit Schedule';

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function openBookingModal() {
                const modal = document.getElementById('bookingModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closeBookingModal() {
                const modal = document.getElementById('bookingModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                    clearBookingModalFields();
                }, 300);
            }

            function openEditBookingModal(nutritionistBookingID, description, nutritionistScheduleID, nutritionistID) {
                const modal = document.getElementById('bookingModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                document.getElementById('nutritionistBookingID').value = nutritionistBookingID;
                document.getElementById('description').value = description;
                document.getElementById('nutritionistID').value = nutritionistID;
                document.getElementById('nutritionistScheduleID').value = nutritionistScheduleID;
                document.getElementById('bookingModalTitle').innerText = 'Edit Booking';

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
                document.getElementById('scheduleDateTime').value = '';
                document.getElementById('price').value = '';
                document.querySelector('select[name="nutritionistID"]').value ='';
            }

            function clearBookingModalFields() {
                document.getElementById('nutritionistBookingID').value = '';
                document.getElementById('description').value = '';
                document.getElementById('nutritionistScheduleID').value = '';
            }
        </script>
        <?php
    }
}