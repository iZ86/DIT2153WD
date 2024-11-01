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
                    <h2 class="text-gray-600 font-bold mb-4">Upcoming Class Schedules</h2>
                    <?php if (empty($this->upcomingClassSchedules)): ?>
                        <p class="text-gray-500">No upcoming classes schedule founds.</p>
                    <?php else: ?>
                        <ul class="space-y-4">
                            <?php foreach ($this->upcomingClassSchedules as $schedule): ?>
                                <li class="border p-4 rounded-lg shadow">
                                    <p class="font-semibold"><?php echo date('F j, Y, g:i A', strtotime($schedule['scheduledOn'])); ?></p>
                                    <p>Instructor ID: <span class="font-medium"><?php echo $schedule['instructorID']; ?></span></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-gray-600 font-bold mb-4">Upcoming Nutritionist Schedules</h2>
                    <?php if (empty($this->upcomingNutritionistSchedules)): ?>
                        <p class="text-gray-500">No upcoming nutritionist schedules found.</p>
                    <?php else: ?>
                        <ul class="space-y-4">
                            <?php foreach ($this->upcomingNutritionistSchedules as $schedule): ?>
                                <li class="border p-4 rounded-lg shadow">
                                    <p class="font-semibold"><?php echo date('F j, Y, g:i A', strtotime($schedule['scheduleDateTime'])); ?></p>
                                    <p>Nutritionist ID: <span class="font-medium"><?php echo $schedule['nutritionistID']; ?></span></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-md col-span-2">
                <h2 class="text-gray-600 font-bold mb-4">Latest Transactions</h2>
                <div class="flex flex-col space-y-2">
                    <?php if (empty($this->latestTransactions)): ?>
                        <p class="text-gray-500">No transactions found.</p>
                    <?php else: ?>
                        <ul class="space-y-4">
                            <?php foreach ($this->latestTransactions as $transaction): ?>
                                <li class="border p-4 rounded-lg shadow">
                                    <p class="font-semibold">Payment ID: <span class="font-medium"><?php echo $transaction['paymentID']; ?></span></p>
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