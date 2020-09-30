<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cmsminds.com/
 * @since      1.0.0
 *
 * @package    Wp_Post_Export
 * @subpackage Wp_Post_Export/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Post_Export
 * @subpackage Wp_Post_Export/admin
 * @author     Chandani Vadaria <chandani@cmsminds.com>
 */
class Wp_Post_Export_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Post_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Post_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-post-export-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Post_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Post_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script(  'wp-custom-post-export', plugin_dir_url( __FILE__ ) . 'js/wp-post-export-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'wp-custom-post-export', 'ajax_url', admin_url( 'admin-ajax.php' ) );

	}
	
	public function load_export_custom_data_callback(){
	    /* default post argument */
        $arg_post = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
		
        global $post;
        $post_data = get_posts($arg_post); // Get default post data
		
        if ($post_data) {
			$posts_data_arr = '';
            $posts_data_key = array('Post ID','Post Title','Post Content','Post Excerpt','Post Status', 'URL', 'Categories', 'Tags','Author','Featured Image Url','Published Date');
           
            foreach ($post_data as $post) {
                setup_postdata($post);
                  
				/* Get Category Data */  
                $categories = get_the_category();
                $cats = array();
                if (!empty($categories)) {
                    foreach ( $categories as $category ) {
                        $cats[] = $category->name;
                    }
                }
				
				/* Get Tag Data */
                $post_tags = get_the_tags();
                $tags = array();
                if (!empty($post_tags)) {
                    foreach ($post_tags as $tag) {
                        $tags[] = $tag->name;
                    }
                }
  
				/* Get Thumbnail Data */
				$featured_img_src = array();
				if (has_post_thumbnail()) {
					$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail_size' );
					$featured_img_src[] = $imgsrc[0];
				}
			    $posts_data_value []= array(get_the_ID(),get_the_title(),get_the_content(),get_the_excerpt(),get_post_status(),get_the_permalink(), implode(",", $cats), implode(",", $tags),get_the_author(),implode(",", $featured_img_src),get_the_date());
            }
			
			//return Key and Value for Post data
			return $this->outputdata( $posts_data_key,$posts_data_value );
			
			}
		}
		
		public function outputdata($data_key,$data_value ) {
		
			if ( !empty( $data_value ) ):
				$fp = fopen( 'php://output', 'w' );
				
				fputcsv( $fp,$data_key); // Put file in Key 
				
				foreach ( $data_value AS $values ): // Put file in Value 
					fputcsv( $fp, $values );
				endforeach;

				fclose( $fp );
				
			endif;

			wp_die();
		}
}