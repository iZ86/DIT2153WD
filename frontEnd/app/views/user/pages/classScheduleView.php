<?php
class FitnessClassView {
    /** Instance variable that is going to store the nutritionists information as an associative array. */
    private $data;
    private $instructorName;

    /** Constructor that is going to retreive the nutritionists information. */
    public function __construct($data, $instructorName) {
        $this->data = $data;
        $this->instructorName = $instructorName;
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

    public function renderContent() {
        // Get the current week start date based on the given 'week' parameter
        $weekOffset = isset($_GET['week']) ? intval($_GET['week']) : 0;
        $instructorOffset = isset($_GET['instructor']) ? intval($_GET['instructor']) : null;

        if ($instructorOffset === null) {
            echo "<p>Error: Instructor ID is missing.</p>";
            return;
        }

        // Calculate the start of the week based on the current date and the week offset
        $currentDate = new DateTime();
        $currentDate->modify("Monday this week");
        $currentDate->modify("+$weekOffset week");
        $startOfWeek = $currentDate->getTimestamp();

        // Array to store each day's date for the current week
        $daysOfWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $daysOfWeek[] = date('j/n/Y', strtotime("+$i day", $startOfWeek));
        }
        ?>

        <section class="bg-[#F1FAFF] pb-48">
            <div class="flex justify-center items-center relative">
                <a href="./classes.php" class="bx bx-chevron-left bx-lg ml-20 absolute left-20 top-10"></a>

                <div class="flex flex-col">
                    <div class="flex flex-col font-bold font-montserrat text-4xl items-center my-5">
                        <p>Yoga Class</p>
                        <p>Instructor: <?= htmlspecialchars($this->instructorName); ?></p>
                    </div>

                    <table class="border border-black border-solid text-center">
                        <tr class="bg-[#9C9292] text-white">
                            <th>Routine</th>
                            <th>8:00 AM</th>
                            <th>10:00 AM</th>
                            <th>1:00 PM</th>
                            <th>3:00 PM</th>
                            <th>5:00 PM</th>
                        </tr>

                        <?php foreach ($daysOfWeek as $date): ?>
                            <tr>
                            <?php
                            list($day, $month, $year) = explode('/', $date);
                            $timestamp = mktime(0, 0, 0, $month, $day, $year);
                            ?>

                                <th class="date"><?= htmlspecialchars($date) ?><br><?= date('l', $timestamp) ?></th>
                                <?php foreach (['8:00', '10:00', '13:00', '15:00', '17:00'] as $time): ?>
                                    <td>
                                        <?php
                                        $classFound = false;
                                        foreach ($this->data as $class) {
                                            if (date('j/n/Y', strtotime($class['scheduledOn'])) === $date && date('H:i', strtotime($class['scheduledOn'])) === $time) {
                                                ?>
                                                <button onclick="openModal()" class="w-full h-full bg-[#E3E3E3] font-montserrat font-bold text-xl flex justify-center items-center hover:bg-[#00F587] transition ease-in-out duration-500 hover:text-white cursor-pointer">Class Available!</button>
                                                <?php
                                                $classFound = true;
                                                break;
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <div class="flex justify-end mt-3 gap-x-5 items-center">
                        <p class="font-bold font-montserrat">Week: <?= $weekOffset + 1 ?></p>
                        <a href="?instructor=<?= $instructorOffset ?>&week=<?= $weekOffset - 1 ?>" class="bx bx-chevron-left bx-md"></a>
                        <a href="?instructor=<?= $instructorOffset ?>&week=<?= $weekOffset + 1 ?>" class="bx bx-chevron-right bx-md"></a>
                    </div>
                </div>
            </div>
        </section>
        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="userModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content">
                <div class="flex justify-between items-center text-center pb-4">
                    <h2 id="modalTitle" class="text-2xl font-semibold text-red-500">Confirmation</h2>
                    <button type="button" onclick="closeModal()" class="text-4xl font-bold">&times;</button>
                </div>
                <hr class="py-2">
                <div class="flex flex-col justify-center items-center">
                    <p class="font-montserrat text-xl mt-4 font-semibold">Are you sure you want to confirm the booking?</p>
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                        <div class="flex gap-x-10 mt-8">
                            <button class="rounded-md px-8 py-2 bg-blue-button text-white font-bold" onclick="confirmBookingCloseModal()" name="confirm-fitness-class-booking" id="confirmed">Yes</button>
                            <input type="hidden" name="scheduledOn" value="<?= $class['scheduledOn'] ?>">
                            <input type="hidden" name="fitnessClassID" value="<?= $_GET['fitnessClassID'] ?>">
                            <input type="hidden" name="instructorID" value="<?= $_GET['instructor'] ?>">
                            <button class="rounded-md px-8 py-2 bg-gray-mid text-white font-bold" onclick="closeModal()">No</button>
                        </div>
                        </form>

                </div>
            </div>
        </div>
        <style>
            tr, th, td {
                border: 1px solid #EEEEEE;
            }

            th {
                padding: 10px 30px;
            }

            td {
                width: 200px;
                height: 100px;
            }

            .date {
                color: white;
                background-color: black;
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

                modal.classList.remove('show');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    overlay.classList.add('hidden');
                }, 300);
            }

            function confirmBookingCloseModal() {
                closeModal();
                alert("Booking has been made, you're good to go!");
                window.location.href = './classes.php';
            }
        </script>
        <?php
    }
    }
?>