<?php

class UserTrackWaterConsumptionView {
    
    /** Constructor for the object. */
    public function __construct() {
    }

    /** Renders the whole view. */
    public function renderView() : void {
        $this->renderHeader();
        $this->renderNavbar();
        $this->renderContent();
        $this->renderFooter();
    }

    /** Renders the header. */
    public function renderHeader() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userHeader.php';
    }

    /** Renders the navbar. */
    public function renderNavbar() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userNavbar.php';
    }

    /** Renders the footer. */
    public function renderFooter() : void {
        // Use __DIR__ to prevent referencing issues, as this object is called by other php files.
        include __DIR__ . '/../components/userFooter.php';
    }

    /** Renders the content. */
    public function renderContent(): void {?>



    <?php
    }
}