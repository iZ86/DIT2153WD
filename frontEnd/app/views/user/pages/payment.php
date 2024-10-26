<?php include __DIR__ .  '/../components/userHeader.php'; ?>
<?php include __DIR__ .  '/../components/userNavbar.php'; ?>

<section>
    <!--Main Flex Container-->
    <div>
        <h1 class="text-2xl font-bold font-sans ml-24 mb-11">Monthly Membership</h1>
        <!--Billing Address-->
        <div class="bg-gray-300">
            <h1 class="text-2xl font-bold font-sans">Billing Address</h1>
            <div>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="flex flex-col">
                <div>
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" id="firstName">
                </div>
                <div>
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" id="lastName">
                </div>
                <div>
                    <label for="addressLine1">Address Line 1</label>
                    <input type="text" name="addressLine1" id="addressLine1">
                </div>
                <div>
                    <label for="addressLine2">Address Line 1</label>
                    <input type="text" name="addressLine2" id="addressLine2">
                </div>
                <div>
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country">
                </div>
                <div>
                    <label for="zipCode">Zip Code</label>
                    <input type="number" name="zipCode" id="zipCode">
                </div>
                <div>
                    <label for="city">City</label>
                    <input type="text" name="city" id="city">
                </div>
                <div>
                    <label for="state">Zip Code</label>
                    <input type="text" name="state" id="state">
                </div>
                <div>
                    <label for="phoneNumber">Zip Code</label>
                    <input type="tel" name="phoneNumber" id="phoneNumber">
                </div>
            </div>
        </div>

        <!--Order Summary-->
        <div class="flex flex-col justify-evenly">
            <h3>Monthly Membership</h3><h3>RM 50</h3>
            <h3>Pilates</h3><h3>RM 15</h3>
            <h3>Zumba</h3><h3>RM 15</h3>
            <h2>Grand Total</h2><h3>RM 80</h3>
        </div>
        <div>
            <h1>Payment Method</h1>
            <label>
                <span>Credit / Debit Card</span>
                <input type="checkbox" class="w-6 h-6 accent-orange-500">
            </label>
            <div>
                <div>
                    <label for="cardNumber">Card Number</label>
                    <input type="tel" name="cardNumber" id="cardNumber">
                </div>
                <div>
                    <label for="nameOnCard">Name on Card</label>
                    <input type="tel" name="nameOnCard" id="nameOnCard">
                </div>
                <div>
                    <label for="expirationDate">Expiration Date</label>
                    <input type="tel" name="expirationDate" id="expirationDate">
                </div>
                <div>
                    <label for="securityCode">Security Code</label>
                    <input type="tel" name="securityCode" id="securityCode">
                </div>
            </div>
        </div>
    </div>
</section>
