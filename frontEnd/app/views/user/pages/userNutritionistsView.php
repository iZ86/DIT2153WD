<?php
// Include necessary files for the header, navbar.

class NutritionistsView {
    /** Instance variable that is going to store the nutritionists information as an associative array. */
    private $data;

    /** Constructor that is going to retreive the nutritionists information. */
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
    public function renderNutritionists() {
        foreach($this->data as $datas) {
            ?>
            <div class="ml-10 font-montserrat">
            <p>Name: <?= htmlspecialchars($datas['firstName']) . ' ' . htmlspecialchars($datas['lastName']) ?></p>
            <p>Qualification: <?= htmlspecialchars($datas['type']) ?> </p>
            <br>
            <p>Bio:</p>
            <p class="w-3/5"><?= htmlspecialchars($datas['description']) ?></p>
            </div>
            <?php
            }
    }

    public function renderConfirmBookingOverlay() {
    ?>
    
    <?php
    }

    public function renderBookingFormOverlay() {
    ?>
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">   
        <form class="flex flex-col gap-y-5 mt-3 pb-3 w-full justify-center items-center needs-validation" action="" method="GET" novalidate>
            <div>
                <label class="font-nunito" for="nutritionist">Nutritionist:</label><br>
                <select required class="w-72 border-b-[1px] border-b-black border-solid font-nunito" name="nutritionist" id="nutritionist" placeholder="SELECT NUTRITIONIST">
                    <option value="" disabled selected hidden>SELECT NUTRITIONIST</option>
                
                    <?php /*
                    // Use the controller to fetch nutritionists for the dropdown
                    $totalNutritionists = $controller->getTotalNutritionist();
                    if (is_int($totalNutritionists) && $totalNutritionists > 0) {
                        for ($i = 1; $i <= $totalNutritionists; $i++) {
                            $nutritionist = $controller->getNutritionistById($i);
                            if ($nutritionist !== false) {
                                echo '<option value="' . htmlspecialchars($nutritionist["nutritionistID"]) . '">' . htmlspecialchars($nutritionist["firstName"]) . '</option>'; // Use nutritionist ID as value
                            }
                        }
                    } else {
                        echo '<option value="" disabled>No nutritionists available</option>';
                    }*/
                    ?>
                </select> 
            </div>

            <div>
                <label class="font-nunito" for="date">Date:</label><br>
                <input required class="w-72 border-b-[1px] border-black border-solid" type="date" name="date" id="date">
            </div>

            <div>
                <label class="font-nunito" for="time">Time:</label><br>
                <select required class="w-72 border-b-[1px] border-black border-solid" name="time" id="time" placeholder="SELECT TIME">
                    <option value="" disabled selected hidden>SELECT AN AVAILABLE TIME</option>
                    <option value="hi" >Hi</option>
                </select> 
            </div>

            <div>
                <label class="font-nunito" for="desc">Description:</label><br>
                <textarea class="pl-3 border-[1px] border-black border-solid rounded-md font-nunito resize-none" name="desc" id="desc" rows="4" cols="32" placeholder="Please Tell Us Your GOAL or Any Concern"></textarea> 
            </div>

            <div class="text-center">
                <p class="font-bold text-sm font-nunito">RM20 for each Consultation Session*</p>
            </div>
            <button type="submit" class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Confirm Booking</button>
        </form>
        </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-body flex flex-col justify-center items-center font-montserrat">
            <i class="bx bx-check-circle bx-lg bg-green-500" style="color: #22c55e;"></i>
            <p class="text-xl font-bold mt-3">Booking Confirmed</p>
            <p>Thank you for choosing our Nutritionist!</p>
            <p>We will provide you the best service</p>
            <button type="button" class="text-red-500" data-bs-dismiss="modal"><u>Close Window</u></button>
        </div>
        </div>
    </div>
    </div>
    <a class="btn btn-primary mt-2" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Make a Reservation</a>
    <?php
    }

    /** Renders the navbar. */
    public function renderNavbar() {
        include __DIR__ . '/../components/navBar.php';
    }
    
    /** Renders the header of the view. */
    public function renderHeader() {
        include __DIR__ . '/../components/header.php';

    }

    /** Reners the footer */
    public function renderFooter() {
        include __DIR__ . '/../components/footer.php';
    }

    /** Renders the content */
    public function renderContent() {
        ?>
        <section class="bg-white-bg">
    <div class="flex flex-col items-center justify-center">
        <h1 class="mt-12 text-4xl font-bold text-[#02463E] font-montserrat">Meet Our Nutritionists</h1>

        <div class="flex items-center justify-center gap-x-10 mt-10">
            <img class="w-3/4 h-72" src="../../public/images/nutrition_header.png" alt="Nutrition.png">
            <div class="border border-[#666666] border-solid h-[17rem]"></div>
            <div class="flex flex-col">
                <p class="font-bold text-[#00796B] font-montserrat text-xl">Why do you need a Nutritionist?</p>
                <br>
                <p class="text-sm text-[#00796B] font-montserrat w-96 leading-6">
                    A nutritionist is essential for creating personalized diet plans that support fitness goals,
                    prevent chronic diseases, and educate individuals on healthier food choices. They help 
                    manage special dietary needs, promote overall well-being, and ensure proper nutrition 
                    complements exercise for better results. In a fitness center, a nutritionist is key to 
                    achieving balanced health and optimal performance.
                </p>
            </div>
        </div>
        <?= $this->renderBookingFormOverlay(); ?>

        <div class="bg-white mt-32 flex flex-col items-center justify-center">
            <div class="py-5 my-20 px-44 flex flex-col items-center justify-center border border-black border-solid rounded-xl">
                
            </div>

            <div class="flex flex-col">
                <div class="mx-20 pl-10 py-10 flex border border-black border-solid rounded-lg shadow-[0_0_20px_0_rgba(0,0,0,0.25)]">
                    <div class="bg-[#ECECEC] w-96 h-48 rounded-2xl flex justify-center items-center">
                        <img src="../../public/images/emily_nutritionist.png" alt="Nutritionist.png">
                    </div>

                    <div class="ml-10 font-montserrat">
                        <?=
                        /** Function that calls the renderNutritionists() function to show all the nutritionists. */ 
                        $this->renderNutritionists(); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<style>
select {
    color: rgba(0, 0, 0, 0.4); /* Default color when nothing is selected */
}

select:valid {
    color: black; /* Change color to black when an option is selected */
}

select:invalid {
    color: rgba(0, 0, 0, 0.4); /* Grey color when no selection */
}

select option {
    color: black; /* Black color when expanding the dropdown box*/
}

/* When date is not selected */
input[type="date"] {
    color: rgba(0, 0, 0, 0.4); /* Grey color */
}

/* When a date is selected */
input[type="date"]:valid {
    color: black; /* Black color when a valid date is selected */
}
</style>
<script>

</script>

    <?php
    }
}
?>