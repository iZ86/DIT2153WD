<?php

class UserMembershipView {
    /** active membership subscription data of user.
     * If empty array, means membership is inactive.
     */
    private $activeMembershipSubscriptionData;
    /** Total price. */
    private $totalPrice;

    public function __construct($activeMembershipSubscriptionData, $totalPrice) {
        $this->activeMembershipSubscriptionData = $activeMembershipSubscriptionData;
        $this->totalPrice = $totalPrice;
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

    /** Renders the footer */
    public function renderFooter() {
        include __DIR__ . '/../components/userFooter.php';
    }

    /** Renders the content to display membership status if membership is active. */
    public function renderMembershipActiveStatusContent() {?>
    <div class="flex bg-orange-500 text-white rounded-2xl shadow-lg mt-10 min-w-192 min-h-80">
        <div class="flex-col justify-start basis-144">
            <img src="../../public/images/white_title.png" alt="HUAN white title" class="w-52">
            <h1 class="text-4xl font-bold ml-7">Membership Active</h1>
            <p class="text-lg font-semibold ml-7"><?php echo $this->activeMembershipSubscriptionData["membershipType"] . " " . $this->activeMembershipSubscriptionData["name"]?></p>
            <div class="flex">
                <p class="ml-7 basis-128">Your subscription will expire on <b><?php echo $this->activeMembershipSubscriptionData["endOn"]?></b>.</p>
            </div>
            <div class="flex items-end">
                <div class="flex max-h-12 ml-7 mt-16">
                    <button class="bg-white text-orange-500 px-6 py-3 font-semibold rounded-3xl hover:bg-gray-200 text-base mr-4">View Current Plan</button>
                </div>
                    
            </div>
        </div>
        <div class="flex-col mt-auto">
           <img src="../../public/images/white_strongman.png" alt="white logo" class="">
        </div>       
    </div>
    <?php
    }

    /** Renders the content to display membership status if membership is inactive. */
    public function renderMembershipInactiveStatusContent() {?>
    <div class="flex bg-gray-500 text-white rounded-2xl shadow-lg mt-10 min-w-192 min-h-80">
        <div class="flex-col justify-start basis-144">
            <img src="../../public/images/white_title.png" alt="HUAN white title" class="w-52">
            <h1 class="text-4xl font-bold ml-7">Membership Inactive</h1>
            <div class="flex">
                <p class="ml-7 max-w-128">Get incredible rich features to enhance your experience, with membership, 
                cancel anytime, starting at only RM50!</p>
            </div>
            <div class="flex items-end">
                <div class="flex max-h-12 ml-7 mt-17">
                    <input type="button" id="getMembershipButton"
                    value="Get Membership"
                    class="bg-orange-500 text-white px-6 py-3 font-semibold rounded-3xl hover:bg-orange-700 text-base cursor-pointer"
                    onclick="getMembership()">
                </div>
                    
            </div>
        </div>
        <div class="flex-col mt-auto">
           <img src="../../public/images/white_strongman.png" alt="white logo" class="">
        </div>       
    </div>
    <?php    
    }

    public function renderContent() {?>
    <section class="flex flex-col items-center pb-48 pt-20 bg-blue-user font-montserrat">

        <?php 
        if (sizeof($this->activeMembershipSubscriptionData) > 0) {
            $this->renderMembershipActiveStatusContent();
        } else {
            $this->renderMembershipInactiveStatusContent();
        }
            
        ?>
        <div id="membershipStandardBanner" class="bg-gray-200 text-blue-600 p-6 rounded-2xl shadow-lg mx-auto mt-16 max-w-2xl">
            <h1 class="text-4xl font-bold text-center">Membership Standard</h1>
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
    <script src="../../public/js/user/userMembershipScript.js"></script>
    <?php
    }
}