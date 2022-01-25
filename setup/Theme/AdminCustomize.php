<?php

namespace Theme;

class AdminCustomize {

	public function __construct(){

		add_action('login_head', [$this, 'custom_login_logo']);

		// Change title field placeholder text for candidate CPT
		add_filter( 'enter_title_here', [$this, 'change_candidate_title_field_placeholder'] );


		// Remove comments features
		add_action( 'admin_menu', function(){
			remove_menu_page( 'edit-comments.php' );
		});
		add_action('init', function(){
			remove_post_type_support('post', 'comments');
			remove_post_type_support('page', 'comments');
		}, 100);
		add_action( 'wp_before_admin_bar_render', function(){
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('comments');
		});

	}

	public function change_candidate_title_field_placeholder($title){

		$screen = get_current_screen();
		
		if  ($screen->post_type == 'candidate') {
			$title = 'Candidate\'s Full Name';
		}
		
		return $title;

	}

	/**
	 * Customize the logo displayed on the Wordpress login page
	 */
	public function custom_login_logo() {
		echo '<style type="text/css">
		h1 a { background-image: url('.get_bloginfo('template_directory').'/assets/img/logo.png) !important;
		 background-size: 100% !important;
		 width: 100% !important;
		 height: 55px !important;
		 pointer-events: none;
		}
		</style>';
	}

}