<?php
// Include necessary file path.
require __DIR__ . '/../../../config/config.php';
class ClassesView {
    private $data;
    private $classesImageStyles = "class h-96 w-64 object-cover rounded-2xl mt-4 box-border border border-solid border-white shadow-[12px_17px_51px_rgba(0,0,0,0.22)] backdrop-blur transition-all-[0.5s]";

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

    public function renderClasses() {
        foreach($this->data as $classes) {?>
        <div class="mt-12">
                <h1 class="font-montserrat font-bold text-4xl">Other Classes:</h1>
                <div class="flex flex-row">
                    <div class="">
                        <img class="<?= $this->classesImageStyles ?>" src="<?=IMAGE_FILE_PATH?><?= $classes['fitnessClassImageFilePath'] ?>" alt="Yoga.jpg">
                        <p class="text-center font-bold font-aoboshi mt-2 text-xl"><?= $classes['name'] ?></p>
                    </div>
                </div>
            </div>
        <?php
        }
    }

    public function renderContent() {?>
    <?php  ?>

    <section class="bg-white">
        <div class="w-full relative">
            <img class="w-full" src="<?=IMAGE_FILE_PATH?>Yoga_header.png" alt="Yoga.png">
            <h1 class="absolute top-40 left-64 text-5xl font-bold text-[#59485b] font-orelega">Transform with</h1>
            <h1 class="absolute top-56 left-64 text-5xl font-bold font-orelega">our Fitness Classes</h1>
            <p class="absolute top-72 left-64 font-montserrat w-1/3">To inspire and transform individuals through fun, high-energy fitness classes that promote physical
                strength, mental well-being, and a sense of community for all fitness levels.
            </p>
            <a href="" class="px-5 py-2 bg-[#F4F3E5] absolute top-1/2 mt-10 left-64 rounded-2xl font-medium">VIEW CLASSES</a>
        </div>

        <div class="flex flex-col mt-10 ml-20">
            <div class="relative">
                <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="mt-12">
                <h1 class="font-montserrat font-bold text-4xl">Subscribed Classes:</h1>
                <div class="flex flex-row">
                    <div class="">
                        <img class="<?= $this->classesImageStyles ?>" src="<?=IMAGE_FILE_PATH?>Pilates.jpg" alt="Pilates.jpg">
                        <p class="text-center font-bold font-aoboshi mt-2 text-xl">Pilates</p>
                    </div>
                </div>
            </div>

            <?= $this->renderClasses(); ?>
        </div>
    </section>
    <style>
    .class {
    cursor: pointer;
    transition: all 0.5s;
    }

    .class:hover{
        border: 1px solid black;
        transform: scale(1.05);
    }

    .class:active {
    transform: scale(0.95) rotateZ(1.7deg);
    box-shadow: 30px 30px 51px rgba(0,0,0,0.3);
    }
    </style>
    <?php

    }
}
