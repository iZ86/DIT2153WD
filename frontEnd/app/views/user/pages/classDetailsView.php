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
    public function renderInstructor() {
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
                
            </div>
        </div>
    </div>
</section>
    <?php
    }
    }
?>
