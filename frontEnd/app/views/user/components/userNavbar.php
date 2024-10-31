<nav class="z-40 relative">
    <script src="../../public/js/user/userNavbarScript.js"></script>
    <div class="bg-white flex py-3 px-12 font-montserrat justify-between">
        <img class="w-40 h-20 cursor-pointer" src="../../public/images/Logo.png" alt="Logo.png" onclick="redirectToIndex()">
        <?php $currentPage = basename($_SERVER['PHP_SELF']);?>
        <div class="px-11 flex items-center gap-x-14">
            <div class="flex font-bold space-x-14 text-lg">
                <a href="index.php" class="<?php echo $currentPage === "index.php" ? "text-orange-400" : "text-black hover:text-orange-400"?>" >Home</a>
                <a href="nutritionist.php" class="<?php echo $currentPage === "nutritionist.php" ? "text-orange-400" : "text-black hover:text-orange-400"?>">Nutritionists</a>
            </div>

            <div class="flex justify-center items-center">
                <p><?= isset($_SESSION['username']) ? $_SESSION['username'] : "Guest"; ?></p>
                <div class="border border-black border-solid rounded-full w-10 h-10 ml-4"></div>
            </div>

        </div>


    </div>
</nav>