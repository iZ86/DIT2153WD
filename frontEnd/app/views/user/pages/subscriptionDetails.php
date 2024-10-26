<?php include __DIR__ .  '/../components/userHeader.php'; ?>
<?php include __DIR__ .  '/../components/userNavbar.php'; ?>

<section class="px-32 space-y-12 bg-blue-100">
    <h1 class="text-2xl font-bold">Monthly Membership</h1>
    <!--Main Flex Container-->
    <div class="flex text-center space-x-14 max-w-5xl mx-auto text-xl w-full">
        <!--Left Section: Membership and Classes-->
        <div class="w-1/2 px-2">
            <div class="flex justify-center bg-gray-400 rounded-t-lg">
                <h2 class="bg-gray-400 text-2xl rounded-t-lg p-2">Monthly Membership</h2>
            </div>
            <div class="flex justify-center bg-gray-200 space-x-2 rounded-b-lg">
                <h2 class="bg-gray-200 text-2xl font-light rounded-b-lg p-2">RM 50 per month</h2>
            </div>
            <div class="mt-10">
                <div class="bg-gray-200 rounded outline-black border-2 border-black">
                    <!--Classes Header-->
                    <h2 class="bg-orange-500 text-3xl rounded py-3 w-full">Classes</h2>

                    <!--Class Labels Container-->
                    <div class="p-6 font-semibold text-2xl">
                        <label class="flex items-center justify-between bg-gray-400 px-9 py-3 rounded mb-3">
                            <span>Yoga (RM 15)</span>
                            <input type="checkbox" class="w-6 h-6 accent-orange-500">
                        </label>
                        <label class="flex items-center justify-between bg-gray-400 px-9 py-3 rounded mb-3">
                            <span>Pilates (RM 15)</span>
                            <input type="checkbox" class="w-6 h-6 accent-orange-500">
                        </label>
                        <label class="flex items-center justify-between bg-gray-400 px-9 py-3 rounded mb-3">
                            <span>Dance (RM 15)</span>
                            <input type="checkbox" class="w-6 h-6 rounded-lg accent-orange-500">
                        </label>
                        <label class="flex items-center justify-between bg-gray-400 px-9 py-3 rounded mb-3">
                            <span>Zumba (RM 15)</span>
                            <input type="checkbox" class="w-6 h-6 rounded-lg accent-orange-500">
                        </label>
                        <label class="flex items-center justify-between bg-gray-400 px-9 py-3 rounded mb-3">
                            <span>Barre (RM 15)</span>
                            <input type="checkbox" class="w-6 h-6 accent-orange-500">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!--Right Section: Class Details-->
        <div class="w-1/2">
            <h2 class="bg-gray-400 text-2xl rounded p-2.5">Class Details</h2>
            <div class="bg-gray-200 px-6 pb-10 rounded-lg">
                <h3 class="bg-gray-200 rounded p-2 text-xl">Pilates Class</h3>
                <img src="../../../public/images/Pilates.jpg" alt="Pilates Class" class="rounded-lg mb-4 w-full">
                <p class="text-gray-700 mb-4">
                    Our Pilates class offers a powerful mix of core strengthening, flexibility, and body toning. Whether
                    you're aiming to improve posture, build muscle, or reduce stress, Pilates is perfect for all fitness
                    levels.
                </p>
                <p class="text-xl font-semibold mb-4">RM 15 (per month)</p>
                <a href="../../../views/user/pages/payment.php">
                    <button class="bg-gray-500 text-white px-12 py-3 rounded-lg hover:bg-gray-600">ADD</button>
                </a>
            </div>
        </div>
    </div>
    <?php include __DIR__ .  '/../components/userFooter.php'; ?>
</section>
