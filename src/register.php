<?php
/**
 * Setup a post type to work with this system
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
class register {

	/**
	 * Register post type -- if needed -- and run intial query
	 *
	 * @param string $post_type_name Name of post type
	 * @param array $post_type_args Post type args
	 */
	public function __construct( $post_type_name, $post_type_args ){
		$this->maybe_register_post_type( $post_type_name, $post_type_args );
		post_factory::create( $post_type_name );

	}

	/**
	 * Register post type if needed
	 *
	 * @param string $post_type_name Name of post type
	 * @param array $post_type_args Post type args
	 */
	protected function maybe_register_post_type( $post_type_name, $post_type_args ) {
		if ( false == post_type_exists( $post_type_name ) ) {
			new \shelob9\posts\register_a_post_type( $post_type_name, $post_type_args );

		}
	}


}
