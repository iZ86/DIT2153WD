<?php
    class ClassDetails {
    /** Instance variable that is going to store the intructor information as an associative array. */
    private $data;

    /** Constructor that is going to retreive the intructors information. */
    public function __construct($data) {
        $this->data = $data;
    }

    public function renderView() {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }
    public function renderInstructors() {
        foreach($this->data as $datas) {
            $dob = new DateTime($datas['dateOfBirth']);
            $currentDate = new DateTime(); // Get the current date
            $age = $currentDate->diff($dob)->y; // Calculate age by getting the year difference

            ?>
            <div class="flex font-montserrat mt-4 mb-14">
                <img class="object-cover w-64" src="../../public/images/<?= htmlspecialchars($datas['instructorImageFilePath']) ?>" alt="">

                <div class="flex flex-col ml-20">
                <p class="font-montserrat font-bold text-2xl"><?= htmlspecialchars($datas['firstName']) . ' ' . htmlspecialchars($datas['lastName']) ?></p>
                <p class="text-[#676767] mt-2"><?= htmlspecialchars($datas['description']) ?></p>
                <div class="space-y-2 mt-4">
                <div class="flex gap-x-48 border-b border-[#676767] border-dashed text-xl font-bold pb-2"><p class="text-red-500">AGE </p><p class="text-[#676767] font-normal"><?= $age ?></p></div>
                <div class="flex gap-x-36 border-b border-[#676767] border-dashed text-xl font-bold pb-2"><p class="text-red-500">WEIGHT </p><p class="ml-1 text-[#676767] font-normal"><?= htmlspecialchars($datas['weight']) ?></p></div>
                <div class="flex gap-x-36 border-b border-[#676767] border-dashed text-xl font-bold pb-2"><p class="text-red-500">HEIGHT </p><p class="ml-3 text-[#676767] font-normal"><?= htmlspecialchars($datas['height']) ?></p></div>
                <div class="flex gap-x-16 border-b border-[#676767] border-dashed text-xl font-bold pb-2"><p class="text-red-500">CERTIFICATION </p><p class="ml-2 text-[#676767] font-normal"><?= htmlspecialchars($datas['certification']) ?></p></div>
                </div>
                <a href="./fitness-class.php?instructor=<?= htmlspecialchars($datas['instructorID']) ?>" class="w-fit p-2 rounded-lg mt-4 text-white font-semibold font-nunito bg-blue-button">View Schedule</a>
                </div>
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
        include __DIR__ . '/../components/userFooter.php';
    }

    public function renderContent() {
        ?>
<section class="flex justify-center items-center">
    <div class="flex flex-col mt-10 justify-center items-center w-3/5">
        <img class="object-cover" src="../../public/images/Yoga.jpg" alt="Yoga.jpg">

        <p class="font-orelega text-7xl self-start mt-4">YOGA</p>

        <p class="font-montserrat mt-3"> Our Yoga class is designed to balance the mind, body, and spirit through a series of postures,
            breathing techniques, and meditation. Whether you're a beginner or an experienced practitioner,
            this class offers a range of yoga styles to accommodate all levels of flexibility and strength.
        </p>

        <div class="grid grid-cols-3 gap-x-2 gap-y-4 mt-6 font-orelega">
            <div class="flex justify-start items-center">
                <i class="bx bxs-badge-check text-blue-500 bx-sm mr-2"></i>
                <p>Increase Flexiblility and Balance</p>
            </div>

            <div class="flex justify-start items-center">
                <i class="bx bxs-badge-check text-blue-500 bx-sm mr-2"></i>
                <p>Builds Muscle Strength</p>
            </div>

            <div class="flex justify-start items-center">
                <i class="bx bxs-badge-check text-blue-500 bx-sm mr-2"></i>
                <p>Reduces Stress and Anxiety</p>
            </div>

            <div class="flex justify-start items-center">
                <i class="bx bxs-badge-check text-blue-500 bx-sm mr-2"></i>
                <p>Improves Posture and Alignment</p>
            </div>

            <div class="flex jsutify-start items-center">
                <i class="bx bxs-badge-check text-blue-500 bx-sm mr-2"></i>
                <p>Promotes Better Breathing and Mindfulness</p>
            </div>
        </div>

        <div class="flex flex-col w-full justify-start mt-20">
            <div class="font-montserrat">
                <p class="text-red-500">CLASSES</p>
                <p class="font-bold text-3xl mt-3">YOUR COACHES</p>
            </div>

            <div>
                <?= $this->renderInstructors(); ?>
            </div>
        </div>
    </div>
</section>
    <?php
    }
    }
?>
