<?php

/*
=========================================
CONFIGURATION
=========================================
*/
// Post author ID
$config__author_id = 1;
// Category ID to assign the tweets to
$config__category_id = 18;
// Name of the file generated by the Twitter Archive
$config__path_archive = dirname(__FILE__) . '/tweet.js';
$config__path_import = dirname(__FILE__) . '/../wp-admin/includes/import.php';
$config__path_admin = dirname(__FILE__) . '//../wp-admin/includes/admin.php';
$config__post_title = "Tweet";
// When creating the actual query
$config__post_type = "post";
// Your twitter username
$config__twitter_user = "ricard_dev";
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

function parse_files() {
	global $wp_filesystem,
				$wpdb,
				$config__author_id,
				$config__category_id,
				$config__path_archive,
				$config__post_title,
				$config__post_type,
				$config__twitter_user;

	WP_Filesystem();

	$tweets = array();

	$tweet_json = file_get_contents( $config__path_archive );
	$tweet_json = preg_replace( '/^[^\[]*/', '', $tweet_json );
	$tweets = json_decode( $tweet_json );

	// DELETE
	echo "<pre>";

	if ( is_array( $tweets ) ) {
		$number_of_tweets = count($tweets);
		for ($i = 0; $i < 20; $i++) {
			$tweet = $tweets[$i];

			print_r($tweet);

			// Parse/adjust dates
			$post_date_gmt = strtotime( $tweet->created_at );
			$post_date_gmt = gmdate( 'Y-m-d H:i:s', $post_date_gmt );
			$post_date     = get_date_from_gmt( $post_date_gmt );

			/*
				Add the URL to the tweet
				Hardcode my twitter handle, Twitter will redirect to the
				Correct user if the status ID does not match the user.
			*/

			$tweet_url = " \n\n" . "https://twitter.com/" . $config__twitter_user . "/status/" . $tweet->id_str;

			// Clean up content a bit
			$post_content = $wpdb->escape( html_entity_decode( trim( $tweet->full_text . $tweet_url) ) );

			// Handle entities supplied by Twitter
			if ( count( $tweet->entities->urls ) ) {
				foreach ( $tweet->entities->urls as $url )
					$post_content = str_replace( $url->url, $url->expanded_url, $post_content );
			}

			// $twitter_permalink       = "https://twitter.com/{$tweet->user->screen_name}/status/{$tweet->id_str}";
			// $in_reply_to_user_id     = !empty( $tweet->in_reply_to_user_id_str ) ? $tweet->in_reply_to_user_id_str : '';
			// $in_reply_to_screen_name = !empty( $tweet->in_reply_to_screen_name ) ? $tweet->in_reply_to_screen_name : '';
			// $in_reply_to_status_id   = !empty( $tweet->in_reply_to_status_id_str ) ? $tweet->in_reply_to_status_id_str : '';

			$post = array(
				'post_author'    => $config__author_id,
				'post_category'  => array($config__category_id),
				'post_date'      =>  $post_date,
				'post_date_gmt'  =>  $post_date_gmt,
				'post_status'    => 'publish',
				'post_title'     => $config__post_title,
				'post_content'   => $post_content,
				'post_type'      => $config__post_type
			);

			$post_id = wp_insert_post( $post );

			print_r($post);
		}
	}
} // End of the parse_files()

parse_files();