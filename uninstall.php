<?php

	// For a clean uninstall of the plugin
	if(!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
		exit();
	}
	else {
		delete_option('widget_minimalisttagcloud');
	}

?>