<?php

class userFeedbackView {
    private $feedbacks;

    public function __construct($feedbacks) {
        $this->feedbacks = $feedbacks;
    }

    public function renderView() : void {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    public function renderHeader() : void {
        include __DIR__ . '/../components/userHeader.php';
    }
    
    public function renderNavbar() : void {
        include __DIR__ . '/../components/userNavbar.php';
    }

    public function renderFooter() : void {
        include __DIR__ . '/../components/userFooter.php';
    }

    public function renderContent() : void {
?>

<section class="p-6 space-y-6 bg-indigo-50">
    <div class="mx-auto" style="width: 900px">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Feedbacks</h2>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-900">
                    <i class="bx bx-filter text-2xl"></i>
                </button>

                <div class="relative">
                    <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                    <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                    <i class="bx bxs-plus-circle"></i>
                    <span>Create</span>
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto overflow-y-auto mx-auto" style="height: 600px; width: 900px">
        <table class="table-auto border-collapse w-full">
            <thead class="">
                <tr class="text-gray-500 font-medium text-left">
                    <th class="p-3 mt-4 border-b border-gray-200">Status</th>
                    <th class="p-3 mt-4 border-b border-gray-200">No</th>
                    <th class="p-3 mt-4 border-b border-gray-200">Topic</th>
                    <th class="p-3 mt-4 border-b border-gray-200">Created</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-left overflow-y-auto">
                <?php while ($feedback = $this->feedbacks->fetch_assoc()): ?>
                <tr class="bg-white">
                    <td class="p-3 mt-4">
                        <span
                        <?php 
                            $class = "text-sm font-medium px-3 py-1 rounded-lg";
                            if ($feedback['status'] == "Open") {
                                $class .= " bg-orange-100 text-orange-700";
                            } else if ($feedback['status'] == "Closed") {
                                $class .= " bg-green-100 text-green-700";
                            } else {
                                $class .= " bg-gray-300 text-gray-700";
                            } 
                        ?>
                        class="<?= $class ?>"><?php echo $feedback['status']; ?></span>
                    </td>
                    <td class="p-3 mt-4"><?php echo $feedback['feedbackID']; ?></td>
                    <td class="p-3 mt-4"><?php echo $feedback['topic']; ?></td>
                    <td class="p-3 mt-4"><?php echo $feedback['createdOn']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
<?php
    }
}