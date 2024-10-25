<?php

class IndexView {
    // Constructor for the object
    public function __construction() {

    }

    /** Renders the whole view. */
    public function renderView() : void {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
    }

    /** Renders the header of the view. */
    public function renderHeader() : void {
        include __DIR__ . '/../components/header.php';
    }

    /** Renders the navbar. */
    public function renderNavbar() : void {
        include __DIR__ . '/../components/navbar.php';
    }

    /** Renders the content. */
    public function renderContent(): void {?>
    
    <section class="bg-blue-user">
        <h1 class="text-5xl font-bold mt-12 ml-12">Welcome back, USERNAME</h1>

        
    
        
    </section>

    <?php
    }

}
