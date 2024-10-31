<?php
require __DIR__ . '/../../../config/config.php';
    class ClassDetails {
    /** Instance variable that is going to store the intructor information as an associative array. */
    private $data;
    private $fitnessClassID;
    private $instructor;

    /** Constructor that is going to retreive the intructors information. */
    public function __construct($data, $instructor) {
        $this->data = $data;
        $this->fitnessClassID = $_GET['fitnessClassID'];
        $this->instructor = $instructor;
    }

    public function renderView() {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    public function renderFitnessClassName() {
        if($this->data) {
            $fitnessClassName = htmlspecialchars($this->data['name']);
            echo "<p class='font-orelega text-7xl self-start mt-4'>{$fitnessClassName}</p>";
        } else {?>
            <p class='font-orelega text-7xl self-start mt-4'>Currently No Class!</p>
        <?php
        }
    }

    public function renderFitnessClassImage() {
        if($this->data) {
            $fitnessClassImage = htmlspecialchars($this->data['fitnessClassImageFilePath']);
            echo "<img class='object-cover' src='" . IMAGE_FILE_PATH . "{$fitnessClassImage}' alt='Fitness Class Image'>";
        }
    }

    public function renderInstructors() {
        // Fetch instructors related to the fitness class
       if($this->instructor) {
        foreach ($this->instructor as $datas) {
            $dob = new DateTime($datas['dateOfBirth']);
            $currentDate = new DateTime();
            $age = $currentDate->diff($dob)->y;
            ?>
            <div class='flex font-montserrat mt-4 mb-14'>
                <img class='object-cover w-64' src="<?=IMAGE_FILE_PATH . htmlspecialchars($datas['instructorImageFilePath']) ?>" alt='Instructor Image'>
                    <div class='flex flex-col ml-20'>
                    <p class='font-montserrat font-bold text-2xl'><?= htmlspecialchars($datas['firstName']) . ' ' . htmlspecialchars($datas['lastName']) ?></p>
                    <p class='text-[#676767] mt-2'><?= htmlspecialchars($datas['description']) ?></p>
                        <div class='space-y-2 mt-4'>
                            <div class='flex gap-x-48 border-b border-[#676767] border-dashed text-xl font-bold pb-2'><p class='text-red-500'>AGE </p><p class='text-[#676767] font-normal'><?= $age ?></p></div>
                                <div class='flex gap-x-36 border-b border-[#676767] border-dashed text-xl font-bold pb-2'><p class='text-red-500'>WEIGHT </p><p class='ml-1 text-[#676767] font-normal'><?= htmlspecialchars($datas['weight']) ?></p></div>
                                    <div class='flex gap-x-36 border-b border-[#676767] border-dashed text-xl font-bold pb-2'><p class='text-red-500'>HEIGHT </p><p class='ml-3 text-[#676767] font-normal'><?= htmlspecialchars($datas['height']) ?></p></div>
                                        <div class='flex gap-x-16 border-b border-[#676767] border-dashed text-xl font-bold pb-2'><p class='text-red-500'>CERTIFICATION </p><p class='ml-2 text-[#676767] font-normal'><?= htmlspecialchars($datas['certification']) ?></p></div>
                        </div>
                        <a href='./fitness-class-schedule.php?instructor=<?=htmlspecialchars($datas['instructorID'])?>&fitnessClassID=<?=htmlspecialchars($this->fitnessClassID)?>' class='w-fit p-2 rounded-lg mt-4 text-white font-semibold font-nunito bg-blue-button'>View Schedule</a>
                    </div>
            </div>
            <?php
        }
       } else {?>
            <p class="text-2xl font-bold">Currently No Instructor!</p>
        <?php
       }
    }

    public function renderNavbar() {
        include __DIR__ . '/../components/userNavbar.php';
    }

    public function renderHeader() {
        include __DIR__ . '/../components/userHeader.php';
    }

    public function renderFooter() {
        include __DIR__ . '/../components/userFooter.php';
    }

    public function renderContent() {
        ?>
        <section class='flex justify-center items-center'>
            <div class='flex flex-col mt-10 justify-center items-center w-3/5'>
                <?= $this->renderFitnessClassImage(); ?>
                <?= $this->renderFitnessClassName(); ?>

                <?php
                if($this->data) {?>
                    <p class='font-montserrat mt-3'><?= htmlspecialchars($this->data['description']) ?></p>
                <?php
                } else {?>
                    <p class='font-montserrat mt-3'>No Description</p>
                <?php
                }
                ?>

                <div class='grid grid-cols-3 gap-x-2 gap-y-4 mt-6 font-orelega'>
                    <div class='flex justify-start items-center'>
                        <i class='bx bxs-badge-check text-blue-500 bx-sm mr-2'></i>
                        <p>Increase Flexibility and Balance</p>
                    </div>
                    <div class='flex justify-start items-center'>
                        <i class='bx bxs-badge-check text-blue-500 bx-sm mr-2'></i>
                        <p>Builds Muscle Strength</p>
                    </div>
                    <div class='flex justify-start items-center'>
                        <i class='bx bxs-badge-check text-blue-500 bx-sm mr-2'></i>
                        <p>Reduces Stress and Anxiety</p>
                    </div>
                    <div class='flex justify-start items-center'>
                        <i class='bx bxs-badge-check text-blue-500 bx-sm mr-2'></i>
                        <p>Improves Posture and Alignment</p>
                    </div>
                    <div class='flex justify-start items-center'>
                        <i class='bx bxs-badge-check text-blue-500 bx-sm mr-2'></i>
                        <p>Promotes Better Breathing and Mindfulness</p>
                    </div>
                </div>

                <div class='flex flex-col w-full justify-start mt-20'>
                    <div class='font-montserrat'>
                        <p class='text-red-500'>CLASSES</p>
                        <p class='font-bold text-3xl mt-3'>YOUR COACHES</p>
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