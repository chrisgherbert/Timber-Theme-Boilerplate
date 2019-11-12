<?php
/**
 * Class for adding data to the global Timber $context
 */

namespace Theme\Timber;

use Timber\Menu;

class Context {

	public function __construct(){
		add_filter('timber_context', array($this, 'add_menus'));
		add_filter('timber_context', array($this, 'add_site_options'));
	}

	public function add_menus($context){
		$context['main_menu'] = new Menu('Main Navigation Menu');
		$context['footer_menu'] = new Menu('Main Footer Menu');
		$context['mobile_menu'] = new Menu('Main Mobile Menu');
		return $context;
	}

	public function add_site_options($context){
		$context['site_options_social'] = get_option('site_options');
		$context['site_options_tracking'] = get_option('site_options_tracking');
		$context['site_options_footer'] = get_option('site_options_footer');
		return $context;
	}

}