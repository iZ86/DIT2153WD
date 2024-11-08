<?php
// Include necessary file path.
require __DIR__ . '/../../../config/config.php';
class NutritionistsView {
    /** Instance variable that is going to store the nutritionists information as an associative array. */
    private $nutritionistInformation;
    private $nutritionistDateTime;
    /** Constructor that is going to retreive the nutritionists information. */
    public function __construct($nutritionistInformation, $nutritionistDateTime) {
        $this->nutritionistInformation = $nutritionistInformation;
        $this->nutritionistTime = $nutritionistDateTime;
    }

    /** Renders the userNutritionists page. */
    public function renderView() {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }
    public function renderNutritionists() {
        if($this->nutritionistInformation) {
            foreach($this->nutritionistInformation as $nutritionistInformations) {
                ?>
                <div class="mx-20 pl-10 py-10 flex border border-black border-solid rounded-lg shadow-[0_0_20px_0_rgba(0,0,0,0.25)] mt-20">

                <div class="bg-[#ECECEC] w-96 h-48 rounded-2xl flex justify-center items-center">
                    <img src="<?=$nutritionistInformations['nutritionistImageFilePath']?>" alt="Nutritionist.png">
                </div>
                <div class="ml-10 font-montserrat">
                <p>Name: <?= htmlspecialchars($nutritionistInformations['firstName']) . ' ' . htmlspecialchars($nutritionistInformations['lastName']) ?></p>
                <p>Qualification: <?= htmlspecialchars($nutritionistInformations['type']) ?> </p>
                <br>
                <p>Bio:</p>
                <p class="w-3/5"><?= htmlspecialchars($nutritionistInformations['description']) ?></p>
                </div>
                </div>
                <?php
            }
        } else {?>
            <h1 class="text-2xl font-bold text-center">Currently No Nutritionist!</h1>
        <?php
    }
    }

    /** Fetches the nutritionists name from database and renders it in dropdown. */
    public function renderNutritionistsName() {
        if($this->nutritionistInformation) {
            foreach($this->nutritionistInformation as $nutritionist) {
                ?>
                <option value="<?= strtolower(htmlspecialchars($nutritionist['nutritionistID'])) ?>">
                    <?= htmlspecialchars($nutritionist['firstName']) . ' ' . htmlspecialchars($nutritionist['lastName']) ?>
                </option>
                <?php
            }
        } else {?>
            <option value="">Currently No Nutritionist!</option>
        <?php
        }
    }

    public function getAvailableDateTime() {
        if($this->nutritionistDateTime) {
            foreach ($this->nutritionistDateTime as $nutritionistDateTimes) {
                echo "<option value='" . htmlspecialchars($nutritionistDateTimes['nutritionistScheduleID']) . "'>" . htmlspecialchars($nutritionistDateTimes['scheduleDateTime']) . "</option>";
            }
        } else {?>
            <p>Currently No Schedule!</p>
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
        include __DIR__ . '/../components/userFooter.php';
    }

    /** Renders the content */
    public function renderContent() {
        ?>
    <section class="bg-white-bg pb-48">
    <div class="flex flex-col items-center justify-center">
        <h1 class="mt-8 text-4xl font-bold text-[#02463E] font-montserrat">Meet Our Nutritionists</h1>
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
        <?php
        if($this->nutritionistInformation) {?>
        <button onclick="openModal()" class="mt-5 bg-indigo-500 hover:bg-indigo-600 text-white hover:text-gray-mid font-bold py-3 px-5 rounded-lg items-center space-x-2 flex">
            <span>Book a Nutritionist</span>
        </button>
        <?php
        } else {?>
         <button class="mt-5 bg-indigo-500 hover:bg-indigo-600 text-white hover:text-gray-mid font-bold py-3 px-5 rounded-lg items-center space-x-2 flex">
            <span>Currently No Nutritionist!</span>
        </button>
        <?php
        }
        ?>
        <div class="bg-white flex flex-col items-center justify-center">
            <div class="flex flex-col">
                    <div class="ml-10 font-montserrat">
                        <?=
                        /** Function that calls the renderNutritionists() function to show all the nutritionists. */
                        $this->renderNutritionists();
                        ?>
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
                <select required class="w-72 border-b-[1px] border-b-black border-solid font-nunito" name="nutritionist" id="nutritionist" onchange="fetchOptions()">
                    <option value="" disabled selected hidden>SELECT NUTRITIONIST</option>
                    <?= $this->renderNutritionistsName(); ?>
                </select>
            </div>

            <div>
                <label class="font-nunito" for="date">Date & Time:</label><br>
                <select required class="w-72 border-b-[1px] border-black border-solid" name="date-time" id="date-time">
                    <option value="" disabled selected hidden>SELECT AN AVAILABLE DATE & TIME</option>
                    <?= $this->getAvailableDateTime(); ?>
                </select>
            </div>

            <div class="text-center">
                <p class="font-bold text-sm font-nunito">RM20 for each Consultation Session*</p>
            </div>
            <button name="confirm-booking-nutritionist" value="Confirm" onclick="openConfirmBookingModal()" type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">Confirm Booking</button>
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
<script language="javascript" type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script language="javascript" type="text/javascript">
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

    modal.classList.remove('show');
    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}

function fetchOptions() {
    const nutritionistID = document.getElementById("nutritionist").value;
    const dateTimeDropdown = document.getElementById("date-time");

    // Clear previous date options
    dateTimeDropdown.innerHTML = "";

    if (nutritionistID !== "") {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "nutritionist.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText); // Parse the JSON response

                if (response.success) {
                    // Populate new date options
                    response.data.forEach(function(dateTime) {
                        const option = document.createElement("option");
                        option.value = dateTime;
                        option.textContent = dateTime; // Set the display text
                        dateTimeDropdown.appendChild(option); // Add option to the dropdown
                    });
                } else {
                    // Handle the error if needed
                    console.error("Failed to fetch available dates");
                }
            }
        };
        xhr.send(`nutritionistID=${encodeURIComponent(nutritionistID)}`);
    }
}

</script>
<?php
}
}
?>