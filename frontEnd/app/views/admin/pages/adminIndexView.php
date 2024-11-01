<?php

class AdminIndexView {
    private $usersCount;
    private $classesCount;
    private $nutritionistsCount;
    private $instructorsCount;
    private $upcomingClassSchedules;
    private $upcomingNutritionistSchedules;
    private $latestTransactions;

    public function __construct($usersCount, $classesCount, $nutritionistsCount, $instructorsCount, $upcomingClassSchedules, $upcomingNutritionistSchedules, $latestTransactions) {
        $this->usersCount = $usersCount;
        $this->classesCount = $classesCount;
        $this->nutritionistsCount = $nutritionistsCount;
        $this->instructorsCount = $instructorsCount;
        $this->upcomingClassSchedules = $upcomingClassSchedules;
        $this->upcomingNutritionistSchedules = $upcomingNutritionistSchedules;
        $this->latestTransactions = $latestTransactions;
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

    public function renderContent() : void {?>
        <section class="p-6 space-y-6">
            <p class="text-3xl mx-4 font-bold">Dashboard</p>

            <div class="grid grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Users</h2>
                    <p class="text-3xl font-semibold mt-2"><?php echo $this->usersCount; ?></p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Classes</h2>
                    <p class="text-3xl font-semibold mt-2"><?php echo $this->classesCount; ?></p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Nutritionists</h2>
                    <p class="text-3xl font-semibold mt-2"><?php echo $this->nutritionistsCount; ?></p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Instructors</h2>
                    <p class="text-3xl font-semibold mt-2"><?php echo $this->instructorsCount; ?></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-600 font-bold">Upcoming Class Schedules</h2>
                        <a href="../admin/classes.php" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                    </div>
                    <?php if (empty($this->upcomingClassSchedules)): ?>
                        <p class="text-gray-500">No upcoming classes scheduled found.</p>
                    <?php else: ?>
                        <ul class="space-y-4">
                            <?php foreach ($this->upcomingClassSchedules as $schedule): ?>
                                <li class="p-6 rounded-lg bg-violet-50">
                                    <p class="font-bold mb-2"><?php echo date('j F Y, g:i A', strtotime($schedule['scheduledOn'])); ?></p>
                                    <p>Class Name: <span class="font-medium"><?php echo $schedule['className']; ?></span> ( <span class="font-medium"><?php echo $schedule['pax']; ?></span> Pax )</p>
                                    <p>Instructor: <span class="font-medium"><?php echo $schedule['instructorFirstName'] . ' ' . $schedule['instructorLastName']; ?></span> ( ID: <span class="font-medium"><?php echo $schedule['instructorID']; ?></span> )</p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-600 font-bold">Upcoming Nutritionist Schedules</h2>
                        <a href="../admin/nutritionists.php" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                    </div>
                    <?php if (empty($this->upcomingNutritionistSchedules)): ?>
                        <p class="text-gray-500">No upcoming nutritionist schedules found.</p>
                    <?php else: ?>
                        <ul class="space-y-4">
                            <?php foreach ($this->upcomingNutritionistSchedules as $schedule): ?>
                                <li class="p-6 rounded-lg bg-blue-50">
                                    <p class="font-bold mb-2"><?php echo date('j F Y, g:i A', strtotime($schedule['scheduleDateTime'])); ?></p>
                                    <p>Nutritionist: <span class="font-medium"><?php echo $schedule['nutritionistFirstName'] . ' ' . $schedule['nutritionistLastName']; ?></span> ( ID: <span class="font-medium"><?php echo $schedule['nutritionistID']; ?></span> )</p>
                                    <p>Price: <span class="font-medium">RM <?php echo number_format($schedule['price'], 2); ?></span></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-md col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-gray-600 font-bold">Latest Transaction Records</h2>
                    <a href="../admin/payments.php" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                </div>
                <div class="flex flex-col space-y-2">
                    <?php if (empty($this->latestTransactions)): ?>
                        <p class="text-gray-500">No transactions found.</p>
                    <?php else: ?>
                        <ul class="space-y-4">
                            <?php foreach ($this->latestTransactions as $transaction): ?>
                                <li class="p-4 rounded-lg bg-red-50">
                                    <p class="font-semibold mb-2">Payment ID #<span class="font-medium"><?php echo $transaction['paymentID']; ?></span></p>
                                    <p>Type: <span class="font-medium"><?php echo $transaction['type']; ?></span></p>
                                    <p>Status: <span class="font-medium"><?php echo $transaction['status']; ?></span></p>
                                    <p>Date: <span class="font-medium"><?php echo date('F j, Y, g:i A', strtotime($transaction['createdOn'])); ?></span></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}