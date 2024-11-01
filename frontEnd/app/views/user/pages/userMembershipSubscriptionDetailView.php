<?php
class UserMembershipSubscriptionDetailView {
    
    /** Fitness class dataset. */
    private $fitnessClassDataset;
    /** Membership data. */
    private $membershipData;
    public function __construct($fitnessClassDataset, $membershipData) {
        $this->fitnessClassDataset = $fitnessClassDataset;
        $this->membershipData = $membershipData;
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


    /** Render one class selection. */
    public function renderOneClassSelection($fitnessClassID, $fitnessClassName, $fitnessClassPrice) : void {?>
    <div id="<?php echo $fitnessClassID . "ClassSelection";?>" class="flex items-center justify-between bg-gray-400 px-9 py-3 rounded hover:bg-gray-600 mb-3 cursor-pointer" onclick="renderFitnessClassDetail(<?php echo $fitnessClassID;?>)">
        <label><?php echo $fitnessClassName . " (RM" . $fitnessClassPrice . ")";?></label>
        <input id="<?php echo $fitnessClassID;?>" type="checkbox" class="w-6 h-6 accent-orange-500">
    </div>
    <?php
    }

    /** Render class selection content. */
    public function renderFitnessClassSelectionContent() {?>
    <div class="mt-10">
                    <div class="bg-gray-200 felex-col rounded outline-black border-2 border-black">
                        <!--Classes Header-->
                        <h2 class="bg-orange-500 text-3xl rounded py-3 w-full font-bold">Classes</h2>

                        <!--Class Labels Container-->
                        <div id="fitnessClasses" class="flex flex-col p-6 font-semibold text-2xl">
                            <?php

                            if (sizeof($this->fitnessClassDataset) > 0) {
                                foreach ($this->fitnessClassDataset as $fitnessClassID =>$value) {
                                    $this->renderOneClassSelection($fitnessClassID, $this->fitnessClassDataset[$fitnessClassID]["name"], $this->fitnessClassDataset[$fitnessClassID]["price"]);
                                }
                            }
                            
                            ?>

                        </div>
                        <?php
                        if (sizeof($this->fitnessClassDataset) > 0) {?>
                        <input type="button" value="Proceed to payment" class="rounded-2xl font-semibold bg-gray-400 hover:bg-gray-600 px-9 py-3 mb-3 rounded cursor-pointer" onclick="proceedToPayment()">
                        <?php
                        }
                        ?>
                        
                    </div>
                </div>

    <?php
    }

    /** Render fitness class detail content. */
    public function renderFitnessClassDetailContent() {?>
    <div class="w-1/2 min-h-192 invisible" id="fitnessClassDetail">
                <h2 class="bg-gray-400 text-2xl rounded-t-lg p-2.5 outline-black border-2 border-black font-bold">Class Details</h2>
                <div class="bg-gray-200 px-6 pb-10 rounded-b-lg outline-black border-2 border-black">
                    <h3 id="fitnessClassDetailName" class="bg-gray-200 rounded p-2 text-xl"></h3>
                    <img id="fitnessClassImage" src="" alt="" class="rounded-lg mb-4 w-full max-h-60">
                    <p id="fitnessClassDescription" class="text-gray-700 mb-4">
                    </p>
                    <input type="hidden" id="fitnessClassDetailID" value="">
                    <p id="fitnessClassDetailPrice" class="text-xl font-semibold mb-4"></p>
                    <button id="addFitnessClassSelectionButton" class="bg-gray-500 text-white px-12 py-3 rounded-lg hover:bg-gray-600" onclick="addFitnessClassSelection()">ADD</button>
                    <button id="removeFitnessClassSelectionButton" class="bg-gray-500 text-white px-12 py-3 rounded-lg hidden hover:bg-gray-600" onclick="removeFitnessClassSelection()">Remove</button>
                </div>
            </div>
        
    <?php
    }

    /** Renders the content. */
    public function renderContent(): void {?>
    <section class="pt-20 pb-48 bg-blue-user font-montserrat">
        <!-- change name -->
        <h1 id="membershipTitle" class="ml-40 mb-20 text-4xl font-bold">Monthly Membership</h1>
        <!--Main Flex Container-->
        <div class="flex text-center space-x-14 max-w-5xl mx-auto text-xl w-full">
            <!--Left Section: Membership and Classes-->
            <div class="w-1/2 px-2">
                <!-- change name. -->
                <div class="flex justify-center bg-gray-400 rounded-t-lg outline-black border-2 border-black">
                    <h2 id="membershipName" class="bg-gray-400 text-2xl rounded-t-lg p-2 font-bold">Monthly Membership</h2>
                </div>
                <div class="flex justify-center bg-gray-200 space-x-2 rounded-b-lg outline-black border-2 border-black">
                    <h2 id="membershipPrice" class="bg-gray-200 text-2xl font-light rounded-b-lg p-2">RM 50 per month</h2>
                </div>

                <?php $this->renderFitnessClassSelectionContent();?>

            </div>

            <!--Right Section: Class Details-->
            <?php $this->renderFitnessClassDetailContent();?>
        </div>
    </section>

    <!-- Embeds the php fitnessClassDataset for JS -->
    <input type="hidden" id="phpFitnessClassDataset" value="
    <?php 
    echo htmlspecialchars(json_encode($this->fitnessClassDataset));
    ?>
    ">
    <!-- Embeds the php membershipData for js -->
    <input type="hidden" id="phpMembershipData" value="
    <?php 
    echo htmlspecialchars(json_encode($this->membershipData));
    ?>
    ">
    <script src="../../public/js/user/userMembershipSubscriptionDetailScript.js"></script>
    <?php
    }
}
