<?php
// Include necessary file path.
require __DIR__ . '/../../../config/config.php';
class MembershipView {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }
    /** Renders the userNutritionists page. */
    public function renderView() {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    /** Renders the navbar. */
    public function renderNavbar() {
        include __DIR__ . '/../components/userNavbar.php';
    }

    /** Renders the header of the view. */
    public function renderHeader() {
        include __DIR__ . '/../components/userHeader.php';

    }

    /** Reners the footer */
    public function renderFooter() {
        include __DIR__ . '/../components/userFooter.php';
    }

    public function renderContent() {?>
    <section class="pb-28">
        <div class="w-full-relative">
            <img class="w-full" src="../../public/images/membershipBanner.png" alt="membership banner">
        </div>
        <div class="text-center mt-10">
            <p class="font-montserrat text-2xl"><b>WE OFFER VARIOUS PROGRAMS TO MEET YOUR NEEDS.</b> WHETHER YOU WANT TO BOOST YOUR ATHLETIC PERFORMANCE, BUILD MUSCLE, OR LOSE FAT, WE HAVE THE RIGHT PLAN FOR YOU.</p>
        </div>
        <div class="font-montserrat font-bold text-2xl">
            <div class="flex justify-around pt-24">
                <div class="flex flex-col items-center pr-4">
                    <img class="w-36 h-36" src="../../public/images/muscle_gain.png" alt="muscle gain">
                    <p class="p-14">MUSCLE GAIN</p>
                </div>
                <div class="flex flex-col items-center">
                    <img class="w-37 h-36" src="../../public/images/performance.png" alt="performance icon">
                    <p class="p-14">PERFORMANCE</p>
                </div>
                <div class="flex flex-col items-center">
                    <img class="w-36 h-36" src="../../public/images/workout_plan.png" alt="workout plan icon">
                    <p class="p-14">WORKOUT PLAN</p>
                </div>
                <div class="flex flex-col items-center pl-2">
                    <img class="w-37 h-36" src="../../public/images/weight_loss.png" alt="weight loss icon">
                    <p class="p-14">WEIGHT LOSS</p>
                </div>
            </div>
        </div>
        <div class="bg-orange-500 text-white p-2 rounded-2xl shadow-lg mx-auto mt-10 mb-10 max-w-4xl relative">
            <img src="../../public/images/white_title.png" alt="HUAN white title" class="absolute top-3 left-0 w-52">
            <h1 class="text-4xl font-bold font-montserrat mt-20 ml-5">Membership Active</h1>
            <p class="text-lg font-semibold font-nunito ml-5">Monthly Membership</p>
            <p class="pb-10 ml-5">Your subscription will automatically renew on <b>Sep 26 2024</b> and you'll be charged <b>RM95</b></p>
            <div class="mb-11 mt-20">
                <button class="bg-white text-orange-500 px-6 py-3 rounded-2xl hover:bg-gray-200 text-lg font-nunito ml-5 mr-4">Cancel Plan</button>
                <button class="bg-white text-orange-500 px-6 py-3 rounded-2xl hover:bg-gray-200 text-lg font-nunito mr-4">View Current Plan</button>
                <button class="bg-white text-orange-500 px-6 py-3 rounded-2xl hover:bg-gray-200 text-lg font-nunito">Switch Plans</button>
            </div>
            <div class="absolute bottom-4 right-2 w-44">
                <img src="../../public/images/white_strongman.png" alt="white logo">
            </div>
        </div>
        <div class="bg-gray-200 text-blue-600 font-nunito p-6 rounded-2xl shadow-lg mx-auto mt-16 max-w-2xl relative">
            <h1 class="text-4xl font-bold text-center">Body Transformation Program</h1>
            <h1 class="font-black text-3xl text-center mt-2">RM50</h1>
            <ul class="list-disc list-inside mt-4">
                <li>Body weight and water consumption data management</li>
                <li>Personalized workout plan</li>
                <li>Personal specialized nutritionist</li>
                <li>Fitness classes</li>
                <li>Online support</li>
            </ul>
            <div class="flex justify-center mt-6">
                <a href="subscriptionDetails.php">
                    <button class="bg-blue-600 text-white text-xl font-black px-6 py-4 rounded-xl hover:bg-blue-700">JOIN NOW</button>
                </a>
            </div>
        </div>
    </section>
    <?php
    }
}