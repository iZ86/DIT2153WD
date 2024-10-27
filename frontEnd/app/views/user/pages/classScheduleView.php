
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
    $startOfWeek = strtotime("last Monday +$weekOffset week");
    $instructorOffset = $_GET['instructor'];

    // Array to store each day's date for the current week
    $daysOfWeek = [];
    for ($i = 0; $i < 7; $i++) {
    $daysOfWeek[] = date('j/n/Y', strtotime("+$i day", $startOfWeek));

    }?>

    <section class="bg-[#F1FAFF]">
    <div class="flex justify-center items-center relative">
        <a href="./instructor.php" class="bx bx-chevron-left bx-lg ml-20 absolute left-20 top-10"></a>

        <div class="flex flex-col">
            <div class="flex flex-col font-bold font-montserrat text-4xl items-center my-5">
                <p>Yoga Class</p>
                <P>Instructor: <?= $this->instructorName; ?></p>
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
                                <th class="date"><?= $date ?></th>
                                <?php foreach (['8:00', '10:00', '13:00', '15:00', '17:00'] as $time): ?>
                                    <td>
                                        <?php
                                        $classFound = false;
                                        foreach ($this->data as $class) {
                                            if (date('j/n/Y', strtotime($class['scheduledOn'])) === $date && date('H:i', strtotime($class['scheduledOn'])) === $time) {
                                                ?> <p class="w-full h-full bg-[#E3E3E3] font-montserrat font-bold text-xl flex justify-center items-center hover:bg-[#00F587] transition ease-in-out duration-500 hover:text-white">Class Available!</p> <?php
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


            <div class="flex justify-end mt-3 gap-x-5">
                <a href="?instructor=<?= $instructorOffset ?>&week=<?= $weekOffset - 1 ?>" class="bx bx-chevron-left bx-md"></a>
                <a href="?instructor=<?= $instructorOffset ?>&week=<?= $weekOffset + 1 ?>" class="bx bx-chevron-right bx-md"></a>
            </div>

        </div>
    </div>
    </section>

    <style>
    tr, th, td {
        border: 1px solid #EEEEEE;

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
    }
    </style>
    <?php
    }
    }
?>