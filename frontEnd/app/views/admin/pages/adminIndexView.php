<?php

class AdminIndexView {
    private $usersCount;
    private $classesCount;
    private $nutritionistsCount;
    private $instructorsCount;

    public function __construct($usersCount, $classesCount, $nutritionistsCount, $instructorsCount) {
        $this->usersCount = $usersCount;
        $this->classesCount = $classesCount;
        $this->nutritionistsCount = $nutritionistsCount;
        $this->instructorsCount = $instructorsCount;
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

            <div class="bg-white p-6 rounded-2xl h-80 col-span-2">
                <h2 class="text-gray-600 font-bold mb-4">Upcoming Schedules</h2>
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500">No upcoming schedules.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl h-80 col-span-2">
                <h2 class="text-gray-600 font-bold mb-4">Latest Transactions</h2>
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500">No records found in the last 3 days.</p>
                </div>
            </div>

        </section>
        <?php
    }
}