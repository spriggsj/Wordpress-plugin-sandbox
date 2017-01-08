<?php
/*
Plugin Name: Snappy List Builder mine
Plugin URI:  https://github.com/spriggsj/Wordpress-plugin-sandbox/tree/master/wp-content/plugins/snappy-list-builder
Description: Plugin build email lists and developed with udemy course
Version:    1.0
Author:      Jason Spriggs
Author URI:  https://teammahout.com
License:    GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /snappy-list-builder-mine
*/

/* !0. TABLE OF CONTENTS */

/*

1.0 HOOKS
	1.1 register all custom shortcode
2.0 SHORTCODES
	2.1 slb_register shortcode()
	2.2 slb_form_shortcode()
3.0 FILTERS
4.0 EXTERNAL SCRIPTS
5.0 ACTIONS
6.0 HEADERS
7.0 CUSTOM POST TYPES
8.0 ADMIN PAGES
9.0 SETTINGS

*/


/* !1. HOOKS */

// 1.1
// hint: registers all our custom shortcodes on init
add_action('init', 'slb_register_shortcodes');

/*
2.0 SHORTCODES EXAMPLE
	2.1 EXAMPLE
	hint: register shortcode
     function sub_register_shortcodes() {
                           txt in [   ]     call function
          add_shortcodes( ‘ string $tag’ , callback $func)
     }
*/
     // 2.1

// hint: registers all our custom shortcodes
function slb_register_shortcodes() {
     
     add_shortcode('slb_form', 'slb_form_shortcode');
     
}

/*
     2.2 EXAMPLE
     hint:returns html string or displays html to screen
*/
function slb_form_shortcode( $args, $content=“”){
     //set up output variable  / the form html
     $output = '
          <div class=“slb”>
               <form id=“slb_form” name=“slb_form” class=“slb_form” method=“post”>
                    <p class=“slb_input_container”>
                         <label>Your Name</label><br/>
                         <input type=“text” name=“slb_fname” placeholder=“first name” />
                         <input type=“text” name=“slb_lname” placeholder=“last name” />
                    </p>
                    <p class="slb-input-container">
                    
                         <label>Your Email</label><br />
                         <input type="email" name="slb_email" placeholder="ex. you@email.com" />
                    
                    </p>';

               if( strlen($content)):
               		$output .= '<div class="slb_content">' . wpautop($content);
               endif;

     $output .= '<p class=“slb_input_container”>
                         <input type=“submit” name=“slb_submit” value="Sign Me Up">
                 </p>
               </form>
          </div>'
     ;
// return our results in html
return $output;

}

