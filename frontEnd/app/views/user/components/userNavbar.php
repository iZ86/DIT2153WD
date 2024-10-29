<?php session_start(); ?>
<nav class="z-40 relative">
    <div class="bg-white flex py-3 px-12 font-montserrat justify-between">
        <img class="w-40 h-20" src="../../public/images/Logo.png" alt="Logo.png">

        <div class="px-11 flex items-center gap-x-14">
            <div class="flex font-bold space-x-14 text-lg">
                <a href="">Home</a>
                <a href="">Explore</a>
                <a href="">Nutritionists</a>
                <a href="">Feedbacks</a>
            </div>

            <div class="flex justify-center items-center">
                <p><?= isset($_SESSION['username']) ? $_SESSION['username'] : "Guest"; ?></p>
                <div class="border border-black border-solid rounded-full w-10 h-10 ml-4"></div>
            </div>

        </div>


    </div>
</nav>