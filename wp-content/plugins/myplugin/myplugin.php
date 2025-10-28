<?php
/*
Plugin Name: My Custom Plugin
Description: A simple plugin that displays a custom footer message.
Version: 1.0
Author: Deepak
*/

add_filter('admin_footer_text', 'my_custom_footer');
function my_custom_footer() {
    echo '<span id="footer-thankyou">Developed by Bharat Singh | Deployed via Jenkins CI/CD</span>';
}

