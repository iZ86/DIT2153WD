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
        include __DIR__ . '/../components/userHeader.php';
    }

    /** Renders the content */
    public function renderContent() { ?>
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
        <button onclick="openModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
            <span>Book a Nutritionist</span>
        </button>


        <div class="bg-white mt-32 flex flex-col items-center justify-center">
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

<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="userModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content">
        <div class="flex justify-between items-center text-center pb-4">
        <h2 id="modalTitle" class="text-2xl font-semibold">Make Reservation</h2>
        <button type="button" onclick="closeModal()" class="text-4xl font-bold">&times;</button>
        </div>
        <hr class="py-2">
        <form class="flex flex-col gap-y-5 mt-3 pb-3 w-full justify-center items-center" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <div>
                <label class="font-nunito" for="nutritionist">Nutritionist:</label><br>
                <select required class="w-72 border-b-[1px] border-b-black border-solid font-nunito" name="nutritionist" id="nutritionist" placeholder="SELECT NUTRITIONIST">
                    <option value="" disabled selected hidden>SELECT NUTRITIONIST</option>
                    <option value="Hi">Hi</option>
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
            <button onclick="openConfirmBookingModal()" type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">Confirm Booking</button>
        </form>
    </div>
</div>
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

.modal {
    transition: opacity 0.3s ease, transform 0.3s ease;
    opacity: 0;
    transform: scale(0.9);
    pointer-events: none;
}

.modal.show {
    opacity: 1;
    transform: scale(1);
    pointer-events: auto;
}

</style>
<script>
function openModal() {
    const modal = document.getElementById('userModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('userModal');
    const overlay = document.getElementById('modalOverlay');
    let nutritionist = document.getElementsById('nutritionist');
    let date = document.getElementById('date');
    let time = document.getElementById('time');

    modal.classList.remove('show');
    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}
</script>

<?php
}
}
?>