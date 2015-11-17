<?php
/**
 * Register post types
 *
 * @package   shelob9\posts
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Josh Pollock
 */

namespace shelob9\posts;

/**
 * Class register
 *
 * @package shelob9\posts
 */
class register_a_post_type {

	/**
	 * Register a post type
	 *
	 * @param string $post_type_name Name of post type
	 * @param array $args Post type args
	 */
	public function __construct( $post_type_name, $args ) {
		register_post_type( $post_type_name, $args );
	}

}
