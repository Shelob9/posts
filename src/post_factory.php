<?php
/**
 * Create a new posts object
 *
 * @package   shelob9\posts
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Josh Pollock
 */

namespace shelob9\posts;

/**
 * Class post_factory
 *
 * @package shelob9\posts
 */
class post_factory {
	/**
	 * Holds instances of the post query classes
	 *
	 * @var
	 */
	private static $instances;

	/**
	 * Create an instance of the post query class
	 *
	 * @param string $post_type Name of post type
	 */
	public static function create( $post_type ) {
		self::$instances[ $post_type ] = new posts( $post_type );

	}

	/**
	 * Get an instance of the post type query class created with this factory
	 *
	 * @param string $post_type Name of post type
	 *
	 * @return posts|void
	 */
	public static function get( $post_type ){
		if( ! isset( self::$instances[ $post_type ] ) ) {
			self::create( $post_type );
		}

		if( isset( self::$instances[ $post_type ] ) ){
			return self::$instances[ $post_type ];
		}

	}

}

