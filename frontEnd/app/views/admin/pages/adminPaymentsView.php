<?php

class AdminPaymentsView {
    private $payments;
    private $adminPaymentsModel;
    private $users;
    private $totalPagesPayments;
    private $currentPage;

    public function __construct($payments, $adminPaymentsModel, $users, $totalPagesPayments, $currentPage) {
        $this->payments = $payments;
        $this->adminPaymentsModel = $adminPaymentsModel;
        $this->users = $users;
        $this->totalPagesPayments = $totalPagesPayments;
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
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Payments</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 540px;">
                <table class="min-w-full table-auto border-collapse w-full">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Details</th>
                        <th class="py-4 px-6 border-b border-gray-200">Username</th>
                        <th class="py-4 px-6 border-b border-gray-200">Amount (RM)</th>
                        <th class="py-4 px-6 border-b border-gray-200">Date</th>
                        <th class="py-4 px-6 border-b border-gray-200">Status</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                    <?php while ($payment = $this->payments->fetch_assoc()):
                        $totalAmount = $this->adminPaymentsModel->getTotalAmountByPaymentID($payment['paymentID']);
                        $username = $this->adminPaymentsModel->getUsernameByUserID($payment['userID']);
                        ?>
                        <tr class="bg-white">
                            <td class="p-3"><?php echo '#' . $payment['paymentID']; ?></td>
                            <td class="p-3"><?php echo $payment['type']; ?></td>
                            <td class="p-3"><?php echo $username; ?></td>
                            <td class="p-3"><?php echo number_format($totalAmount, 2); ?></td>
                            <td class="p-3"><?php echo date('Y-m-d H:i', strtotime($payment['createdOn'])); ?></td>
                            <td class="p-3">
                                <span class="bg-<?php echo $payment['status'] === 'Failed' ? 'red' : ($payment['status'] === 'Pending' ? 'orange' : 'green'); ?>-100 text-<?php echo $payment['status'] === 'Failed' ? 'red' : ($payment['status'] === 'Pending' ? 'orange' : 'green'); ?>-700 text-sm font-medium px-3 py-1 rounded-lg"><?php echo $payment['status']; ?></span>
                            </td>
                            <td class="p-3 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600" onclick="openEditPaymentModal(<?php echo $payment['paymentID']; ?>, '<?php echo $payment['type']; ?>', '<?php echo $totalAmount; ?>', '<?php echo $payment['createdOn']; ?>', '<?php echo $payment['status']; ?>', '<?php echo $payment['userID']; ?>')">
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
                    <ul class="flex space-x-2">
                        <?php for ($i = 1; $i <= $this->totalPagesPayments; $i++): ?>
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

        <div id="filterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Payments</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="scheduleFilterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="paymentID">Payment ID</option>
                        <option value="details">Details</option>
                        <option value="username">Username</option>
                        <option value="date">Date</option>
                        <option value="status">Status</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="../admin/payments.php" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="paymentModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 max-h-screen overflow-y-auto sm:mx-6 lg:mx-8">
                <h2 id="paymentModalTitle" class="text-2xl font-semibold mb-4">Edit Payment</h2>
                <hr class="py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" id="paymentID" name="paymentID">
                    <input type="hidden" name="createdOn" value="<?php echo date('Y-m-d H:i:s'); ?>">

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Details <span class="text-red-500">*</span></label>
                            <input name="type" type="text" id="type" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Username <span class="text-red-500">*</span></label>
                            <select name="userID" id="userID" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                                <option value="">Select User</option>
                                <?php while ($user = $this->users->fetch_assoc()): ?>
                                    <option value="<?php echo $user['registeredUserID']; ?>"><?php echo $user['username']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Amount (RM) <span class="text-red-500">*</span></label>
                    <input name="amount" type="number" id="amount" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-lg py-2 px-3" required>
                        <option value="">Select Status</option>
                        <option value="Completed">Completed</option>
                        <option value="Pending">Pending</option>
                        <option value="Failed">Failed</option>
                    </select>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closePaymentModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <button type="submit" id="submitPaymentButton" name="editPaymentButton" value="Edit Payment" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Save Changes</button>
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

            function openEditPaymentModal(paymentID, type, amount, createdOn, status, userID) {
                const modal = document.getElementById('paymentModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');

                document.getElementById('paymentID').value = paymentID;
                document.getElementById('type').value = type;
                document.getElementById('amount').value = amount;
                document.getElementById('status').value = status;
                document.getElementById('userID').value = userID;

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);
            }

            function closePaymentModal() {
                const modal = document.getElementById('paymentModal');
                const overlay = document.getElementById('modalOverlay');

                modal.classList.remove('show');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
                clearPaymentModalFields();
            }

            function clearPaymentModalFields() {
                document.getElementById('paymentID').value = '';
                document.getElementById('type').value = '';
                document.getElementById('userID').value = '';
                document.getElementById('amount').value = '';
                document.getElementById('status').value = '';
            }
        </script>
        <?php
    }
}