<?php
/* Open Source SciLifeLab Theme Functions */


// Load jQuery
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
	wp_enqueue_script('jquery');
}
