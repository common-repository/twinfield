<?php

namespace Pronamic\WP\Twinfield\Article;

/**
 * ArticleMetaBox
 *
 * Used to display the metabox and determine which
 * post type the metabox should show on.
 *
 * To get the metabox to show on your post, just add
 * 'twinfield_article' to the supports parameter.
 *
 * Actions used:
 * ----------------
 *
 * add_meta_boxes
 * save_post
 *
 * ----------------
 *
 * @since 0.0.1
 *
 * @package Pronamic\WP\Twinfield
 * @subpackage Article
 * @author Leon Rowland <leon@rowland.nl>
 * @copyright (c) 2013, Leon Rowland
 * @version 0.0.1
 */

class ArticleMetaBox {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	/**
	 * Determines where to show the meta box. It will
	 * get all post types, loop through and check if the
	 * post type supports 'twinfield_article'
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 * @return void
	 */
	public function add_meta_boxes( $post_type ) {
		if ( post_type_supports( $post_type, 'twinfield_article' ) ) {
			add_meta_box(
				'pronamic_twinfield_article',
				__( 'Twinfield Article', 'twinfield' ),
				array( $this, 'view' ),
				$post_type,
				'normal',
				'default'
			);
		}
	}

	/**
	 * Displays the metabox contents
	 *
	 * Loads the view file from ~/views/Pronamic/WP/Article/articlemetabox_view
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 * @param WP_Post $post
	 * @return void
	 */
	public function view( $post ) {
		// Get current id information
		$twinfield_article_code    = get_post_meta( $post->ID, '_twinfield_article_code', true );
		$twinfield_subarticle_code = get_post_meta( $post->ID, '_twinfield_subarticle_code', true );

		// Make the view
		global $twinfield_plugin;

		$twinfield_plugin->display( 'views/meta-box-article.php', array(
			'twinfield_article_code'    => $twinfield_article_code,
			'twinfield_subarticle_code' => $twinfield_subarticle_code,
		) );
	}

	/**
	 * Saves the article meta box information
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 * @param string $post_id
	 * @param WP_Post $post
	 * @return void
	 */
	public function save( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['twinfield_article_nonce'] ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'twinfield_article_nonce'), 'twinfield_article' ) ) {
			return;
		}

		if ( ! post_type_supports( $post->post_type, 'twinfield_article' ) ) {
			return;
		}

		$twinfield_article_code    = filter_input( INPUT_POST, 'twinfield_article_code', FILTER_SANITIZE_STRING );
		if ( empty( $twinfield_article_code ) ) {
			delete_post_meta( $post_id, '_twinfield_article_code' );
		} else {
			update_post_meta( $post_id, '_twinfield_article_code', $twinfield_article_code );
		}

		$twinfield_subarticle_code = filter_input( INPUT_POST, 'twinfield_subarticle_code', FILTER_SANITIZE_STRING );
		if ( empty( $twinfield_subarticle_code ) ) {
			delete_post_meta( $post_id, '_twinfield_subarticle_code' );
		} else {
			update_post_meta( $post_id, '_twinfield_subarticle_code', $twinfield_subarticle_code );
		}
	}
}
