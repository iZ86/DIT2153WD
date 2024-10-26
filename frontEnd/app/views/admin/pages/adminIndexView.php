<?php 

class AdminIndexView {
    /** Constructor for the object. */
    public function __construct() {

    }

    /** Renders the whole view. */
    public function renderView() : void {
        $this->renderHeader();
        $this->renderSidebar();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    /** Renders the header. */
    public function renderHeader() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/adminHeader.php';
    }

    /** Renders the sidebar. */
    public function renderSidebar() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/adminSidebar.php';
    }

    /** Renders the navbar. */
    public function renderNavbar() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/adminNavbar.php';
    }

    /** Renders the footer. */
    public function renderFooter() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/adminFooter.php';
    }

    /** Renders the content. */
    public function renderContent() : void {?>
    <section class="p-6 space-y-6">
        <p class="text-3xl mx-4 font-bold">Dashboard</p>

        <div class="grid grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl">
                <h2 class="text-gray-600 font-medium">Users</h2>
                <p class="text-3xl font-semibold mt-2">0</p>
            </div>
            <div class="bg-white p-6 rounded-2xl">
                <h2 class="text-gray-600 font-medium">Classes</h2>
                <p class="text-3xl font-semibold mt-2">0</p>
            </div>
            <div class="bg-white p-6 rounded-2xl">
                <h2 class="text-gray-600 font-medium">Nutritionists</h2>
                <p class="text-3xl font-semibold mt-2">0</p>
            </div>
            <div class="bg-white p-6 rounded-2xl">
                <h2 class="text-gray-600 font-medium">Instructors</h2>
                <p class="text-3xl font-semibold mt-2">0</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl h-80 col-span-2">
                <h2 class="text-gray-600 font-bold mb-4">Upcoming Schedules</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl row-span-2">
                <h2 class="text-gray-600 font-bold mb-4">Latest Feedbacks</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl h-80 col-span-2">
                <h2 class="text-gray-600 font-bold mb-4">Latest Transactions</h2>
            </div>
        </div>
    </section>
<?php
    }
}
