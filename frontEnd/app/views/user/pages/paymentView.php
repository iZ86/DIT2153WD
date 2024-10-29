
<?php
class PaymentView {
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
    <section class="px-32 space-y-6 bg-blue-user pt-10 pb-28">
    <h1 class="text-3xl font-bold font-sans">Monthly Membership</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <div class="flex space-x-14">
        <!--Billing Address-->
        <div class="bg-gray-100 p-6 w-1/2 rounded-lg border border-black">
            <h1 class="text-3xl font-bold font-sans">Billing Address</h1>
            <div class="grid grid-cols-2 gap-4 font-semibold text-xl">
                <div class="col-span-2 mt-4">
                    <label for="email">Email Address</label>
                    <input required type="email" name="email" id="email" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div>
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div>
                    <label for="lastName">Last Name</label>
                    <input required type="text" name="lastName" id="lastName" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div class="col-span-2 mt-4">
                    <label for="addressLine1">Address</label>
                    <input required type="text" name="address" id="address" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div>
                    <label for="country">Country</label>
                    <input required type="text" name="country" id="country" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div>
                    <label for="zipCode">Zip Code</label>
                    <input required type="text" name="zipCode" id="zipCode" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div>
                    <label for="city">City</label>
                    <input required type="text" name="city" id="city" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div>
                    <label for="state">State</label>
                    <input required type="text" name="state" id="state" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
                <div class="col-span-2">
                    <label for="phoneNumber">Phone Number</label>
                    <input required type="tel" name="phoneNumber" id="phoneNumber" class="w-full p-2 border border-gray-400 rounded-lg">
                </div>
            </div>
        </div>

        <!--Order Summary-->
        <div class="bg-gray-100 p-4 w-1/2 rounded-lg flex flex-col space-y-6 border border-black">
            <h1 class="text-3xl font-bold">Order Summary</h1>
            <div class="space-y-4">
                <h3 class="pb-2 font-normal text-2xl"><?= $_GET['order'] ?> <span class="float-right">RM <?= $_GET['price'] ?></span></h3>

                <!-- Horizontal Line -->
                <div class="border border-gray-500 border-solid mb-6"></div>
                <h2 class="text-2xl font-semibold">Grand Total <span class="float-right">RM<?= $_GET['price'] ?></span></h2>
            </div>

            <!--Payment Method-->
            <div class="font-semibold text-xl">
                <h1 class="text-3xl font-bold">Payment Method</h1>
                <!--Payment Method Box-->
                <div class="flex bg-purple-200 rounded-t-lg mt-3">
                    <div class="flex items-center">
                    <img src="../../public/images/visa.png" alt="Visa Card" class="w-24 ml-3">
                    <span class="">Credit / Debit Card</span>
                    <input required type="radio" name="card" id="card" class="w-5 h-5 ml-3">
                    </div>
                </div>
                <div class="flex justify-end bg-gray-200 p-2 space-x-2 rounded-b-lg">
                    <img src="../../public/images/unionPay.png" alt="Union Pay Card" class="h-8">
                    <img src="../../public/images/mastercard.png" alt="Mastercard" class="h-8">
                </div>
                <div class="space-y-4">
                    <div class="mt-4">
                        <label for="cardNumber">Card Number</label>
                        <input required type="tel" name="cardNumber" id="cardNumber" class="w-full p-2 border border-gray-400 rounded-lg">
                    </div>
                    <div>
                        <label for="nameOnCard">Name on Card</label>
                        <input required type="tel" name="nameOnCard" id="nameOnCard" class="w-full p-2 border border-gray-400 rounded-lg">
                    </div>
                    <!--Expiration Date-->
                    <div class="grid grid-cols-1 space-x-2">
                        <div>
                            <label for="expirationMonth" class="rounded-lg">Expiration Date
                            <select required name="expirationMonth" id="expirationMonth" class="w-full px-2 py-2.5 mb-2 border border-gray-400 rounded-lg">
                                <option value="" disabled selected>Month</option>
                                <option value="01">01 - January</option>
                                <option value="02">02 - February</option>
                                <option value="03">03 - March</option>
                                <option value="04">04 - April</option>
                                <option value="05">05 - May</option>
                                <option value="06">06 - June</option>
                                <option value="07">07 - July</option>
                                <option value="08">08 - August</option>
                                <option value="09">09 - September</option>
                                <option value="10">10 - October</option>
                                <option value="11">11 - November</option>
                                <option value="12">12 - December</option>
                            </select>
                            <select required name="expirationYear" id="expirationYear" class="w-full px-2 py-2.5 mt-2 rounded-lg border border-gray-400">
                                <option value="" disabled selected>Year</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                            </select>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="securityCode">Security Code (CVV / CVC)</label>
                        <input required type="tel" name="securityCode" id="securityCode" class="w-full p-2 mb-4 border rounded-lg">
                    </div>
                </div>
                <button type="submit" value="Subscribe" name="subscribe" id="subscribe" class="bg-orange-500 font-bold text-2xl hover:bg-orange-300 rounded-lg px-2 py-2 w-full">Subscribe</button>
            </div>
        </div>
    </div>
    </form>
</section>
    <?php
    }
}
