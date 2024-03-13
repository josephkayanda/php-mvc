<?php

/**
 * Pagination class for handling pagination links.
 */

namespace Core;

// Ensure the script is accessed only through the application
defined('ROOTPATH') OR exit('Access Denied!');

class Pager
{
    // Properties to store configuration and links
    public $links        = array();
    public $offset       = 0;
    public $page_number  = 1;
    public $start        = 1;
    public $end          = 1;
    public $limit        = 10;
    public $nav_class    = "";
    public $ul_class     = "pagination justify-content-center";
    public $li_class     = "page-item";
    public $a_class      = "page-link";

    /**
     * Constructor to initialize the Pager object.
     *
     * @param int $limit   The number of records to display per page.
     * @param int $extras  The number of extra page links to show.
     */
    public function __construct($limit = 10, $extras = 1)
    {
        // Retrieve the current page number from the URL
        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page_number = $page_number < 1 ? 1 : $page_number;

        // Calculate start and end page numbers for pagination links
        $this->end = $page_number + $extras;
        $this->start = $page_number - $extras;
        if ($this->start < 1) {
            $this->start = 1;
        }

        // Calculate offset for retrieving records from the database
        $this->offset = ($page_number - 1) * $limit;

        // Set properties
        $this->page_number = $page_number;
        $this->limit = $limit;

        // Construct the current URL for pagination links
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $current_link = ROOT . "/" . $url . '?' . trim(str_replace("url=", "", str_replace($url, "", $_SERVER['QUERY_STRING'])), '&');
        $current_link = !strstr($current_link, "page=") ? $current_link . "&page=1" : $current_link;

        // Handle URL formatting
        if (!strstr($current_link, "?")) {
            $current_link = str_replace("&page=", "?page=", $current_link);
        }

        // Generate URLs for first and next links
        $first_link = preg_replace('/page=[0-9]+/', "page=1", $current_link);
        $next_link = preg_replace('/page=[0-9]+/', "page=" . ($page_number + $extras + 1), $current_link);

        // Store links in the $links property
        $this->links['first'] = $first_link;
        $this->links['current'] = $current_link;
        $this->links['next'] = $next_link;
    }

    /**
     * Display the pagination links.
     *
     * @param int|null $record_count  The total number of records (optional).
     */
    public function display($record_count = null)
    {
        // Set record_count to the default limit if not provided
        if ($record_count == null)
            $record_count = $this->limit;

        // Check whether to display pagination based on record count and current page number
        if ($record_count == $this->limit || $this->page_number > 1) {
            ?>
            <!-- HTML markup for pagination -->
            <br class="clearfix">
            <div>
                <nav class="<?= $this->nav_class ?>">
                    <ul class="<?= $this->ul_class ?>">
                        <!-- First link -->
                        <li class="<?= $this->li_class ?>"><a class="<?= $this->a_class ?>" href="<?= $this->links['first'] ?>">First</a></li>

                        <?php
                        // Loop through page numbers and generate links
                        for ($x = $this->start; $x <= $this->end; $x++):
                            ?>
                            <li class="<?= $this->li_class ?> <?= ($x == $this->page_number) ? ' active ' : ''; ?>">
                                <a class="<?= $this->a_class ?>" href="<?= preg_replace('/page=[0-9]+/', "page=" . $x, $this->links['current']) ?>">
                                    <?= $x ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next link -->
                        <li class="<?= $this->li_class ?>"><a class="<?= $this->a_class ?>" href="<?= $this->links['next'] ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
            <?php
        }
    }
}

