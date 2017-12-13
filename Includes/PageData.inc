<?php
class PageData {
    /**
     * Title of the current page.
     * "My Budget Buddy" by default.
     *
     * @var string
     */
    public $title = "My Budget Buddy";
    
    /**
     * Whether this is an admin-only page
     * or not.
     *
     * @var bool
     */
    public $adminOnly = false;
    
    /**
     * Whether this page uses JQuery.
     * 
     * @var bool
     */
    public $useJQuery = true;
    
    /**
     * Whether this page uses bootstrap.
     * 
     * @var bool
     */
    public $useBootstrap = true;
}

?>