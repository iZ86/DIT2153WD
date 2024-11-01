<nav class="z-40 relative">
    <script src="../../public/js/user/userNavbarScript.js"></script>
    <div class="bg-white flex py-3 px-12 font-montserrat justify-between">
        <img class="w-40 h-20 cursor-pointer" src="../../public/images/Logo.png" alt="Logo.png" onclick="redirectToIndex()">
        <?php $currentPage = basename($_SERVER['PHP_SELF']);?>
        <div class="px-11 flex items-center gap-x-14">
            <div class="flex font-bold space-x-14 text-lg">
                <a href="index.php" class="<?php echo $currentPage === "index.php" ? "text-orange-400" : "text-black hover:text-orange-400"?>" >Home</a>
                <a href="fitness-class.php" class="<?php echo $currentPage === "fitness-class.php" ? "text-orange-400" : "text-black hover:text-orange-400"?>">Fitness Classes</a>
                <a href="nutritionist.php" class="<?php echo $currentPage === "nutritionist.php" ? "text-orange-400" : "text-black hover:text-orange-400"?>">Nutritionists</a>
                <a href="membership.php" class="<?php echo $currentPage === "membership.php" ? "text-orange-400" : "text-black hover:text-orange-400"?>">Membership</a>
            </div>

            <div class="relative">
                <button id="dropdownToggle" class="flex items-center space-x-2 mr-2">
                    <span class="font-semibold text-gray-700 mr-2"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></span>
                    <img src="../../public/images/avatar.png" alt="User Avatar" class="w-10 h-10 rounded-full">
                </button>

                <div id="dropdownMenu" class="absolute right-0 mt-2 p-2 w-48 bg-white border border-gray-200 rounded-lg hidden">
                    <a href="profile.php"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bxs-user text-base'></i>
                        <span class="font-medium">View Profile</span>
                    </a>
                    <a href="billing.php"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bxs-user text-base'></i>
                        <span class="font-medium">Billing</span>
                    </a>
                    <a href="../logout.php"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bx-log-out text-base'></i>
                        <span class="font-medium">Log Out</span>
                    </a>
                </div>
            </div>

        </div>


    </div>
</nav>
<script>
        document.getElementById('dropdownToggle').addEventListener('click', function () {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            const toggleButton = document.getElementById('dropdownToggle');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (!toggleButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
</script>