<?php

class AdminNutritionistsView {
    private $nutritionists;

    public function __construct($nutritionists) {
        $this->nutritionists = $nutritionists;
    }

    public function renderView() : void {
        $this->renderHeader();
        $this->renderSidebar();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    public function renderHeader() : void {
        include __DIR__ . '/../components/adminHeader.php';
    }

    public function renderSidebar() : void {
        include __DIR__ . '/../components/adminSidebar.php';
    }

    public function renderNavbar() : void {
        include __DIR__ . '/../components/adminNavbar.php';
    }

    public function renderFooter() : void {
        include __DIR__ . '/../components/adminFooter.php';
    }

    public function renderContent() : void {
        ?>
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Nutritionists</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" class="pl-12 pr-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-1 focus:ring-indigo-200 focus:border-indigo-500 outline-none text-gray-700 w-64" placeholder="Search...">
                            <i class="bx bx-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class="bx bxs-plus-circle"></i>
                            <span>Add Nutritionist</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 600px;">
                <table class="min-w-full table-auto border-collapse w-full">
                    <thead>
                        <tr class="text-gray-500 font-medium text-center">
                            <th class="py-4 px-6 w-12 border-b border-gray-200">
                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                            </th>
                            <th class="py-4 px-6 border-b border-gray-200">ID</th>
                            <th class="py-4 px-6 border-b border-gray-200">Name</th>
                            <th class="py-4 px-6 border-b border-gray-200">Phone</th>
                            <th class="py-4 px-6 border-b border-gray-200">Email</th>
                            <th class="py-4 px-6 border-b border-gray-200">Gender</th>
                            <th class="py-4 px-6 border-b border-gray-200">Type</th>
                            <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center">
                        <tr class="bg-white">
                            <td class="p-3 mt-4">
                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                            </td>
                            <td class="p-3 mt-4">1</td>
                            <td class="p-3 mt-4">Adam Ong</td>
                            <td class="p-3 mt-4">(60)18-999 0000</td>
                            <td class="p-3 mt-4">adamong@yahoo.com</td>
                            <td class="p-3 mt-4">Male</td>
                            <td class="p-3 mt-4">
                                <span class="bg-blue-100 text-blue-700 text-sm font-medium px-3 py-1 rounded-lg">Certified Nutritionist</span>
                            </td>
                            <td class="p-3  mt-4 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <button class="text-gray-500 hover:text-red-600">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="bg-white">
                            <td class="p-3">
                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                            </td>
                            <td class="p-3">2</td>
                            <td class="p-3">Fibian Tham</td>
                            <td class="p-3">(60)12-777 0000</td>
                            <td class="p-3">fibiantham@gmail.com</td>
                            <td class="p-3">Male</td>
                            <td class="p-3 mt-4">
                                <span class="bg-blue-100 text-blue-700 text-sm font-medium px-3 py-1 rounded-lg">Sports Nutrition Specialist</span>
                            </td>
                            <td class="p-3 flex justify-center space-x-2">
                                <button class="text-gray-500 hover:text-blue-600">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <button class="text-gray-500 hover:text-red-600">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <?php
    }
}