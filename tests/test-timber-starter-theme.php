<?php

	class TestTimberStarterTheme extends WP_UnitTestCase {

		function setUp() {
			self::_setupStarterTheme();
			require_once(get_template_directory().'/functions.php');
		}

		function tearDown() {
			switch_theme('twentythirteen');
		}

		function testFunctionsPHP() {
			$context = Timber::context();
			$this->assertEquals('StarterSite', get_class($context['site']));
			$this->assertTrue(current_theme_supports('post-thumbnails'));
			$this->assertEquals('bar', $context['foo']);
		}

		function testLoading() {
			$str = Timber::compile('tease.twig');
			$this->assertStringStartsWith('<article class="tease tease-" id="tease-">', $str);
			$this->assertStringEndsWith('</article>', $str);
		}

		static function _setupStarterTheme(){
			$dest = WP_CONTENT_DIR.'/themes/timber-starter-theme/';
			$src = __DIR__.'/../../timber-starter-theme/';
			if (is_dir($src)) {
				self::_copyDirectory($src, $dest);
				switch_theme('timber-starter-theme');
			} else {
				echo 'no its not';
			}
		}

		static function _copyDirectory($src, $dst){
			$dir = opendir($src);
			@mkdir($dst);
			while(false !== ( $file = readdir($dir)) ) {
			    if (( $file != '.' ) && ( $file != '..' )) {
			        if ( is_dir($src . '/' . $file) ) {
			            self::_copyDirectory($src . '/' . $file,$dst . '/' . $file);
			        }
			        else {
			            copy($src . '/' . $file,$dst . '/' . $file);
			        }
			    }
			}
			closedir($dir);
		}

	}
