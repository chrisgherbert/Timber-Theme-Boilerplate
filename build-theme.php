<?php

/**
 * Project Build Script
 */

// Run install/build commands
$install_commands = [
	'composer install', // Install Composer dependencies
	"npm ci", // Install Node dependencies
	"npm run production", // Build script for front end (JS and CSS)
];

foreach ($install_commands as $command){
	echo shell_exec($command);
}
