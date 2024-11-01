<?php

class UserBillingView {

    /** Transaction History datset. */
    private $transactionHistoryDataset;
    
    /** Constructor for the object. */
    public function __construct($transactionHistoryDataset) {
        $this->transactionHistoryDataset = $transactionHistoryDataset;
    }

    /** Renders the whole view. */
    public function renderView() : void {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    /** Renders the header. */
    public function renderHeader() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userHeader.php';
    }

    /** Renders the navbar. */
    public function renderNavbar() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userNavbar.php';
    }

    /** Renders the footer. */
    public function renderFooter() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userFooter.php';
    }

    /** Renders one paymentID section. */
    public function renderOnePaymentIDSection($paymentID) : void {?>
    <!-- expandable remove when closed -->
    <div id=<?php echo $paymentID;?>>
            <!-- expandable title bar -->
            <div class="flex py-7 px-10 text-lg justify-between items-center cursor-pointer text-center" onclick="extendPaymentIDSection(<?php echo $paymentID;?>)">
               <p id="<?php echo $paymentID . "paymentID";?>" class="basis-28"></p>
                <p id="<?php echo $paymentID . "description";?>" class="basis-28 ml-8"></p>
                <p id="<?php echo $paymentID . "date";?>" class="basis-28 ml-4"></p>
                <p id="<?php echo $paymentID . "status";?>" class="basis-28"></p>
                <p id="<?php echo $paymentID . "amount";?>" class="basis-28 mr-6"></p>
                <p id="<?php echo $paymentID . "arrow";?>" class="font-semibold transform rotate-180"></p>
            </div>
            <!-- expandable content wrapper -->
            <div class="expandable--content-wrapper ">
                <!-- expandable content -->
                <div class="bg-gray-300 mx-10 rounded flex flex-col overflow-hidden">
                    <div class="flex flex-col font-semibold p-5">
                        <h4 class="text-lg">Payment Details</h4>
                        <h5 id="<?php echo $paymentID . "paymentType";?>" class="text-md"></h5>
                            <div class="flex items-start gap-x-3">
                                <p class="text-small">Items:</p>
                                <div id="<?php echo $paymentID . "items";?>" class="flex-col">
                                    
                                </div>
                            </div>
                        
                    </div>
                    <hr class="w-full bg-white">
                    <div class="flex flex-col font-semibold p-5">
                       <p id="<?php echo $paymentID . "totalAmount";?>" class="text-small">Total: RM95</p>
                    </div>
                        
                </div>
            </div>
                
        </div>
    <hr class="bg-gray-300">
    
    <?php
    }

    /** Renders all payment ID Sections. */
    public function renderAllPaymentIDSections() {
        for ($i = 0; $i < sizeof($this->transactionHistoryDataset); $i++) {
            $this->renderOnePaymentIDSection($this->transactionHistoryDataset[$i]["payment"]["paymentID"]);
        }
    }



     /** Renders the content. */
    public function renderContent(): void {?>
    <section class="font-montserrat bg-blue-user flex flex-col pt-20 pb-48">
        <h1 class="text-4xl font-bold mb-20 ml-40">Transaction History</h1>

        <div class="flex flex-col mx-auto bg-white rounded-2xl max-w-256 min-w-256 min-h-192 select-none">
            

            <div class="flex py-7 px-10 text-lg font-semibold justify-between">
                <p >Payment ID</p>
                <p>Description</p>
                <p>Date</p>
                <p class="ml-4">Status</p>
                <p class="ml-2">Amount</p>
                <p class="invisible"><</p>
            </div>
            <hr>
            <?php $this->renderAllPaymentIDSections(); ?>

            
            

        </div>

        <div class="flex items-center mx-auto mt-14">
                <?php 
                if ($_GET['page'] < 1) {
                    echo '<input type="button" id="previousDate" name="previousDate" value="<" class="px-4 text-2xl" onclick="goToPage(' . $_GET['page'] + 1 .')">';
                }
                ?>
                <p class="text-2l"><?php echo "Page " . $_GET['page']?></p>
                <?php 
                if (sizeof($this->transactionHistoryDataset) === 10) {
                    echo '<input type="button" id="nextDate" name="nextDate" value=">" class="px-4 text-2xl" onclick="goToPage(' . $_GET['page'] - 1 .')">';
                }
                ?>
                

        </div>
    </section>
    <style>
        .expandable--open {
            margin-bottom: 28px;
        }

        .expandable--open .expandable--content-wrapper {
            grid-template-rows: 1fr;
        }

        .expandable--content-wrapper {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.3s ease-out;
        }
    </style>

    <!-- Embed php array of ids of the weight data rows to be used to convert the amount drank based on unit. -->
    <input type="hidden" id="phpTransactionHistoryDataset" value="
    <?php 
    echo htmlspecialchars(json_encode($this->transactionHistoryDataset));
    ?>
    ">


    <script src="../../public/js/user/userBillingScript.js"></script>
    <?php
    }
}