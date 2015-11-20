<?php
/**
 * Query posts
 *
 * Heavy copypasta from https://carlalexander.ca/designing-class-manage-wordpress-posts/ by Carl Alexander.
 *
 * @package   shelob9\posts
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Josh Pollock
 */

namespace shelob9\posts;

/**
 * Class posts
 *
 * @package shelob9\posts
 */
class posts {


	/**
	 * WordPress query object.
	 *
	 * @var \WP_Query
	 */
	private $query;

	/**
	 * Constructor.
	 *
	 * @param \WP_Query $query
	 */
	public function __construct( \WP_Query $query ) {
		$this->query = $query;
	}

	/**
	 * Get currently queried posts
	 *
	 * @return array
	 */
	public function get_posts() {
		return $this->query->posts;

	}

	/**
	 * Get current query object
	 *
	 * @return \WP_Query
	 */
	public function get_query(){
		return $this->query;

	}

	/**
	 * Get current post count
	 *
	 * @return int
	 */
	public function total() {
		return $this->query->post_count;
	}

	/**
	 * Find posts written by the given author.
	 *
	 * @param \WP_User $author
	 * @param int $limit
	 *
	 * @return \WP_Post[]
	 */
	public function find_by_author( \WP_User $author, $limit = 10 ) {
		return $this->find( array(
			'author'         => $author->ID,
			'posts_per_page' => $limit,
		) );
	}

	/**
	 * Find a post using the given post ID.
	 *
	 * @param int $id
	 *
	 * @return \WP_Post|null
	 */
	public function find_by_id( $id ) {
		return $this->find_one( array( 'p' => $id ) );

	}

	/**
	 * Save a post into the repository. Returns the post ID or a WP_Error.
	 *
	 * @param array $post Post args to be passed to wp_insert_post/ wp_update_post
	 * @param array $metas Optional. An array of meta fields to save
	 *
	 * @return int|\WP_Error ID of post or WP_Error if not saved
	 */
	public function save( array $post, array $metas = array() ) {
		if ( ! empty( $post[ 'ID' ] ) ) {
			$id =  wp_update_post( $post, true );
		}else{
			$id = wp_insert_post( $post, true );
		}

		if( ! is_wp_error( $id ) && ! empty( $metas ) ) {
			$this->save_metas( $metas, $id );

		}

		return $id;



	}

	/**
	 * Find all post objects for the given query.
	 *
	 * @param array $query
	 *
	 * @return \WP_Post[]
	 */
	private function find( array $query ) {
		$query = array_merge( array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		), $query );

		return $this->query->query( $query );
	}

	/**
	 * Find a single post object for the given query. Returns null
	 * if it doesn't find one.
	 *
	 * @param array $query
	 *
	 * @return \WP_Post|null
	 */
	private function find_one( array $query ) {
		$query = array_merge( $query, array(
			'posts_per_page' => 1,
		) );

		$posts = $this->find( $query );

		return ! empty( $posts[0] ) ? $posts[0] : null;
	}

	/**
	 * Save post meta fields
	 *
	 * @param array $metas Array of meta fields to save key=>$value
	 * @param int $id Post ID
 	 */
	protected function save_metas( array $metas, $id ) {
		foreach ( $metas as $key => $value ) {
			update_post_meta( $id, $key, $value );
		}
	}

}
