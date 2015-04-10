<?php

/**
 * Plugin Name: 3D Model Viewer
 * Plugin URI: https://wordpress.org/plugins/3d-model-viewer/
 * Description: The first live 3D plugin for wordpress
 * Version: 1.1
 * Author: Joerg Viola
 * Author URI: http://www.joergviola.de
 */


class WP_3D {
	
	// Constructor
	public function __construct() {
		add_shortcode( '3D', array('WP_3D', 'shortcode_3d') );
		add_action( 'wp_enqueue_scripts', array('WP_3D', 'add_scripts') );
		add_filter('mime_types',array('WP_3D', 'add_custom_mime_types'));
	}
	
	// Activate the plugin
	public static function activate() {
	}
	
	// Deactivate the plugin
	public static function deactivate() {
	}
	
	// Add link to the settings page
	function admin_menu_hook() {
		// Do nothing so far ;)
	}
	
	function add_custom_mime_types($mimes){
		return array_merge($mimes,array (
			'dae' => 'model/vnd.collada+xml',
		));
	}
		
	public function add_scripts() {
		wp_register_script('threejs', plugins_url('js/three.min.js', __FILE__), array(),'1.1', false);
		wp_enqueue_script('threejs');
		wp_register_script('collada-loader', plugins_url('js/loaders/ColladaLoader.js', __FILE__), array(),'1.1', false);
		wp_enqueue_script('collada-loader');
		wp_register_script('obj-loader', plugins_url('js/loaders/OBJLoader.js', __FILE__), array(),'1.1', false);
		wp_enqueue_script('obj-loader');
		wp_register_script('orbital', plugins_url('js/controls/OrbitControls.js', __FILE__), array(),'1.1', false);
		wp_enqueue_script('orbital');
	}
	
	
	// The 3D shortcode
	public function shortcode_3d($atts, $content = null) {
		$width = self::get($atts['width'], '500');
		$height = self::get($atts['height'], '300');
		$background = self::get($atts['background'], 'ffffff');
		$opacity = self::get($atts['opacity'], 1);
		$modelPosition = self::get($atts['model-position'], '0,0,0');
		$modelScale = self::get($atts['model-scale'], '1,1,1');
		$ambient = self::get($atts['ambient'], '404040');
		$directional = explode(':', self::get($atts['directional'], '1,1,1:ffffff'));
		$directionalPosition = $directional[0];
		$directionalColor = $directional[1];
		$cssClass = self::get($atts['class']);
		$cssStyle = self::get($atts['style']);
		$id = self::get($atts['id'], 'stage');
		
		global $wpdb, $post;
		$result = $wpdb->get_col($wpdb->prepare("SELECT guid FROM $wpdb->posts WHERE guid LIKE '%%%s' and post_parent=%d;", $atts['model'], $post->ID ));
		$model = $result[0];
		$camera = self::createVector($atts['camera'], '50,50,30');
		
		ob_start();
		require('output.php');
		return ob_get_clean();
	}
	
	private static function get(&$var, $default=null) {
	    return isset($var) ? $var : $default;
	}	
	
	private static function createVector(&$string, $default="0,0,0") {
	    $string = self::get($string, $default);
	    return explode(',', $string);
	}
}

register_activation_hook(__FILE__, array('WP_3D', 'activate'));
register_deactivation_hook(__FILE__, array('WP_3D', 'deactivate'));
$wp3d = new WP_3D();
