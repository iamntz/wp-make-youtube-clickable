<?php

/*
Plugin Name: Clickable Youtube Thumbs
Description: Convert youtube links into image preview that will automatically play video when clicked
Author: Ionuț Staicu
Version: 1.0.0
Author URI: http://ionutstaicu.com
Slug: Clickable_Youtube_Thumbs
 */

if (!defined('ABSPATH')) {
	exit;
}

//require_once( 'vendor/autoload.php' );

define('CLICKABLE_YT_VERSION', '1.0.0');

define('CLICKABLE_YT_BASEFILE', __FILE__);
define('CLICKABLE_YT_URL', plugin_dir_url(__FILE__));
define('CLICKABLE_YT_PATH', plugin_dir_path(__FILE__));

add_action('plugins_loaded', function () {
	load_plugin_textdomain('Clickable_Youtube_Thumbs', false, dirname(plugin_basename(__FILE__)) . '/lang');
});

add_action('wp_enqueue_scripts', function () {
	wp_register_script('Clickable_Youtube_Thumbs', plugins_url('Clickable_Youtube_Thumbs.js', CLICKABLE_YT_BASEFILE), [], CLICKABLE_YT_VERSION, true);
	wp_register_style('Clickable_Youtube_Thumbs', plugins_url('Clickable_Youtube_Thumbs.css', CLICKABLE_YT_BASEFILE), [], CLICKABLE_YT_VERSION);

	wp_enqueue_style( 'Clickable_Youtube_Thumbs' );
});

add_filter('get_comment_text', function ($content, $comment, $args) {
	$embeds = array_map(function ($item) {
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $item, $matches);
		if (!empty($matches)) {
			wp_enqueue_script( 'Clickable_Youtube_Thumbs' );

			return sprintf('<a href="%s" data-youtube-id="%s" class="clickable-yt"><i class="clickable-yt-control"></i><img src="//img.youtube.com/vi/%s/hqdefault.jpg" alt=""></a>', $matches[0], $matches[1], $matches[1]);
		}
		return $item;
	}, explode("\n", $content));

	return implode("\n", $embeds);
}, 5, 3);
