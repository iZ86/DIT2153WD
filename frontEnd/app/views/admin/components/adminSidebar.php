<aside class="w-64 bg-white h-screen fixed">
    <div class="p-4">
        <a href="../../../views/admin/pages/index.php">
            <img src="../../../public/images/Logo.png" alt="Logo" class="w-48 mx-auto">
        </a>
    </div>

    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>

    <nav class="px-6 text-gray-700">
        <h2 class="text-gray-500 mt-2 mb-5 px-5 font-medium">Menu</h2>
        <ul class="space-y-4">
            <li>
                <a href="../../../views/admin/pages/index.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'index.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bxs-dashboard text-base"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../pages/adminUsersView.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'adminUsersView.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-user text-base"></i>
                    <span class="font-medium">Users</span>
                </a>
            </li>
            <li>
                <a href="../pages/adminClassesView.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'adminClassesView.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-book text-base"></i>
                    <span class="font-medium">Classes</span>
                </a>
            </li>
            <li>
                <a href="../pages/adminNutritionistsView.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'adminNutritionistsView.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-food-menu text-base"></i>
                    <span class="font-medium">Nutritionists</span>
                </a>
            </li>
            <li>
                <a href="../pages/adminInstructorsView.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'adminInstructorsView.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-run text-base"></i>
                    <span class="font-medium">Instructors</span>
                </a>
            </li>
            <li>
                <a href="../pages/adminPaymentsView.php"
                   class="flex items-center space-x-6 py-3 px-5 <?php echo $current_page == 'adminPaymentsView.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-credit-card text-base"></i>
                    <span class="font-medium">Payments</span>
                </a>
            </li>
            <li>
                <a href="../pages/adminFeedbacksView.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'adminFeedbacksView.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-message-square-dots text-base"></i>
                    <span class="font-medium">Feedbacks</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>