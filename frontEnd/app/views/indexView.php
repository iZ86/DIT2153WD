<?php

class IndexView {
    // Constructor for the object
    public function __construction() {

    }

    /** Renders the whole view. */
    public function renderView() : void {
        $this->renderHeader();
        $this->renderNavbar();
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
    public function renderContent(): void {
    }

}
