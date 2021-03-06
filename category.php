<?php

/*
=========================================
CONFIGURATION
=========================================
*/
$config__batch = 500;
// Category ID to assign the tweets to
$config__category_id = 2;
// Look for posts not in these categories
$config__not_in = array( 2 );
// Name of the file generated by the Twitter Archive
$config__path_import = dirname(__FILE__) . '/../wp-admin/includes/import.php';
$config__path_admin = dirname(__FILE__) . '//../wp-admin/includes/admin.php';
// Where is the WP Load located
$config__wpload_path = "../wp-load.php";

/*
=========================================
STOP RIGHT HERE
=========================================
(Unless you know what you're doing)
*/
// We are in a subfolder
include_once($config__wpload_path);
require_once $config__path_import;
require_once $config__path_admin;

echo "<pre>";

function parse_posts() {
	// Calculate how much time this thing takes
	$time_start = microtime(true);

	global $wp_filesystem,
        $wpdb,
        $config__batch,
        $config__category_id,
        $config__not_in;

        $query = new WP_Query(
          array(
            'posts_per_page' => $config__batch,
            'category__not_in' => $config__not_in
            )
        );

        // The Loop
        if ( $query->have_posts() ) {
          $counter = 0;
          while ( $query->have_posts() ) {
              $query->the_post();

              wp_set_post_categories( get_the_ID(), array($config__category_id));

              $counter++;
          }

          echo $counter . " posts updated.";

        } else {
          echo "No posts found <br><br>";
        }

        /* Restore original Post Data */
        wp_reset_postdata();

	$time_end = microtime(true);
	echo "<br><br>It took me " . ($time_end - $time_start) . " seconds to do this.";
} // End of the parse_files()

parse_posts();