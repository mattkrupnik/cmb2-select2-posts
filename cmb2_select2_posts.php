<?php
/**
 * Plugin Name: CMB2 Select2 Posts
 * Plugin URI:  https://github.com/mattkrupnik/cmb2-select2-posts
 * Description: Enable to select post by Select2
 * Version:     1.1.2
 * Author:      Matt Krupnik
 * Author URI:  http://mattkrupnik.com
 * License:     GPLv2+
 */


class OWN_Select2_Posts {

	const VERSION = '1.1.2';

	public function hooks() {
    
		add_filter( 'cmb2_render_own_select2_posts',  array( $this, 'own_select2_posts_field' ), 10, 5 );
		add_action( 'wp_ajax_results', array( $this, 'results' ), 10, 5 );
    
	}

	public function own_select2_posts_field( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {

		// Only enqueue scripts if field is used.
		$this->setup_admin_scripts();

		echo $field_type_object->select( array(
			'class'            => 'own-select2-posts-field',
			'options'          => $field->escaped_value ? '<option value="'.$field->escaped_value.'">'.get_the_title( $field->escaped_value ).'</option>' : $field->args( 'placeholder' ),
			'data-placeholder' => $field->args( 'placeholder' ),
			'data-type'        => $field->post_type(),
			'style'            => 'width:'.$field->width().'',
		) );
		
	}

	public function results() {

		$search = like_escape( $_REQUEST['list_search'] );
		$post_type = $_REQUEST['post_type'];

		add_filter('posts_where', function( $where ) use ($search) {
			$where .= (" AND post_title LIKE '%" . $search . "%'");
			return $where;
		});
		 
		$post_query = new WP_Query(
			array(
			  'post_type'   => $post_type,
			  'post_status' => 'publish',
			)
		);

		// If we don't have any results
		if ( empty( $post_query->posts ) ) {
			wp_send_json_error( $_POST );
		}

		$results  = array();
		foreach ( $post_query->posts as $post ) {

			$results[] = array(
				'id'   => $post->ID,
				'text' => $post->post_title
			);
		}
			
		echo json_encode( $results );
		die();
    
	}
	

	
	public function setup_admin_scripts() {

		wp_enqueue_style( 'cmb2_select2_posts_select_css',  '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css', array(), self::VERSION );
		wp_enqueue_script( 'cmb2_select2_posts_select_js',  '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array(), self::VERSION );
		wp_enqueue_script( 'cmb2_select2_posts_js',  plugins_url( 'js/cmb2_select2_posts.js', __FILE__ ), array(), self::VERSION );
		wp_localize_script( 'cmb2_select2_posts_js', 'cmb2_select2_posts_results', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}
  
}
$own_select2_posts = new OWN_select2_posts();
$own_select2_posts->hooks();
