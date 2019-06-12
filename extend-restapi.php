<?php
/**
 * The plugin bootstrap file
 *
 * @wordpress-plugin
 * Plugin Name:       Extend RestApi
 * Plugin URI:        ABC
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            bhautik gosai
 * Author URI:        https://github.com/bhautikgosai96/extend-restapi
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       extend-restapi
 */
// Extend rest response
add_action( 'rest_api_init', 'extend_rest_post_response' );
function extend_rest_post_response() {
	register_rest_field( 'post',
		'cat_name',
		array(
			'get_callback'    => 'get_cat_name',
			'update_callback' => null,
			'schema'          => null,
	 	)
	);
}
function get_cat_name( $object, $field_name, $request ) {
	$cats = $object['categories'];
	$res = [];
	$ob = [];
	foreach ( $cats as $x ) {
		$cat_id = (int) $x;
		$cat = get_category( $cat_id );
		if ( is_wp_error( $cat ) ) {
			$res[] = '';
		} else {
			$ob['name'] = isset( $cat->name ) ? $cat->name : '';
			$ob['id']   = isset( $cat->term_id ) ? $cat->term_id : '';
			$ob['slug'] = isset( $cat->slug ) ? $cat->slug : '';
			$res[] = $ob;
		}
	}
	return $res;
}
