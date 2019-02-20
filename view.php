<?php
/*
*
Plugin Name: Location Plugin
Plugin URI: Techlaunch.online
Description: Plugin to display all locations of a business.
Author: Rasif Ashrafi
Version: 1.0.0
Author URI: rashrafi.techlaunch.online
*
*/

$plugin_url = WP_PLUGIN_URL . '/new_map';

function plugin_install() {

   global $wpdb;
   return true;

}

function option_menu() {

   add_options_page(
       'Location Plugin',
       'Location Plugin',
       'manage_options',
       'Location Plugin',
       'option_page'
   );

}

add_action('admin_menu', 'option_menu');

function option_page() {

   if( !current_user_can( 'manage_options' ) ) {

       wp_die( 'Access Denied' );

   }

   global $plugin_url;
   global $name;

   if( isset( $_POST['form_submitted'] ) ) {

       $hidden_field = esc_html( $_POST['form_submitted'] );

       if( $hidden_field == 'Y' ) {

           $name = esc_html( $_POST['name'] );

           $location =  getName($name );

       }

   }

   require('location.php');
}

function getName($name){

   $url = 'https://www.google.com/maps/search/?api=1&amp;query=' . $name;

   
?>
<div class="main">
   <div class="inside">
       <article class="plugin">
           <div class="location">
               <h1 class="head">Location :
                   <?= $name; ?>
               </h1>
               <div id="icon"><a href="<?= $url; ?>" class="map">Show Location Map</a></div>
           </div>
       </article>
   </div>
</div>

<?php
}
function plugin_deactivate()
{
   global $wpdb;
   echo "deactivate";
}

add_action('wp_enqueue_scripts', 'getName');
register_activation_hook(__FILE__, 'plugin_install');
register_deactivation_hook(__FILE__, 'plugin_deactivate');
?>