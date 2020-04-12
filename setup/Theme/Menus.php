<?php

namespace Theme;

class Menus {

	public function __construct(){

		add_action('init', function(){

			register_nav_menus([
				'main' => 'Main Navigation Menu',
				'mobile' => 'Mobile Navigation Menu',
				'footer' => 'Footer Navigation Menu'
			]);

		});

	}

}