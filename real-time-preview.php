<?php
/*
  Plugin Name: Real Time Page Customization Add On
  Description: This plugin allows you to style and visualize pages in real time
  Author: Neha Bahadure
  Version: 1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
add_action('add_meta_boxes', 'rtp_add_meta_box');

function rtp_add_meta_box() {
    $screens = ['page'];
    add_meta_box('rtp_meta_box_div_id', 'Customization Options', 'rtp_display_meta_box', $screens, 'normal');
}

add_action('admin_enqueue_scripts', 'rtp_backend_scripts');

if (!function_exists('rtp_backend_scripts')) {

    function rtp_backend_scripts($hook) {

        wp_enqueue_media();
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        wp_enqueue_script('rtp-admin-js', plugin_dir_url(__FILE__) . 'admin/js/admin.js');
    }

}
add_action('wp_enqueue_scripts', 'rtp_frontend_scripts');

function rtp_frontend_scripts($hook) {

    wp_enqueue_script('jquery');
    wp_enqueue_script('rtp-front-js', plugin_dir_url(__FILE__) . 'includes/js/custom.js', array('jquery'));
    global $post;
    $post_id = 0;
    if (is_object($post)) {
        $post_id = $post->ID;
    }

    $rtp_header_color =   get_post_meta($post->ID, 'header_color', true );
    $rtp_heading_fs =   get_post_meta($post->ID, 'heading_fs', true );
    $rtp_banner_color =   get_post_meta($post->ID, 'banner_color', true );
    $rtp_main_btn_color =   get_post_meta($post->ID, 'main_btn_color', true );
    $rtp_var = array('post_id' => $post_id, 
    
    'rtp_header_color' => $rtp_header_color,
    'rtp_banner_color' => $rtp_banner_color,
    'rtp_main_btn_color' => $rtp_main_btn_color,
    'rtp_heading_fs' => $rtp_heading_fs,

);

  

    wp_localize_script('rtp-front-js', 'rtp_js_var', $rtp_var);
}

if (!function_exists('rtp_display_meta_box')) {

    function rtp_display_meta_box($post) {
        $custom = get_post_custom($post->ID);
        $header_color = ( isset($custom['header_color'][0]) ) ? $custom['header_color'][0] : '';
        $heading_fs = ( isset($custom['heading_fs'][0]) ) ? $custom['heading_fs'][0] : '';
        
        
        $banner_color = ( isset($custom['banner_color'][0]) ) ? $custom['banner_color'][0] : '';
        
        $main_btn_color = ( isset($custom['main_btn_color'][0]) ) ? $custom['main_btn_color'][0] : '';
        wp_nonce_field('rtp_display_meta_box_action', 'rtp_display_metabox_nonce');
        ?>
        <script>
            jQuery(document).ready(function ($) {
                $('.color_field').each(function () {
                    $(this).wpColorPicker();
                });
            });
        </script>
        <div class="pagebox">

        <p><?php esc_attr_e('Header Background Color', 'rtp'); ?></p>
            <input class="color_field banner_color" type="hidden" name="banner_color" value="<?php esc_attr_e($banner_color); ?>"/>

            <p><?php esc_attr_e('Main Heading Color.', 'rtp'); ?></p>
            <input class="color_field header_color" type="hidden" name="header_color" value="<?php esc_attr_e($header_color); ?>"/>
            
          <p>  
          <?php esc_attr_e('Main Heading Font Size (in px)', 'rtp'); ?>
           </p>
          <select name="heading_fs" class="heading_fs">
          <option value="">Default</option>
                <?php 
                    $option_values =  range(14, 70); 

                    foreach($option_values as $key => $value) 
                    {
                        if($value == get_post_meta($post->ID, "heading_fs", true))
                        {
                            ?>
                                <option selected><?php echo $value; ?></option>
                            <?php    
                        }
                        else
                        {
                            ?>
                                <option><?php echo $value; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>

            <br>

            <p><?php esc_attr_e('Button Color', 'rtp'); ?></p>

            <input class="color_field main_btn_color" type="hidden" name="main_btn_color" value="<?php esc_attr_e($main_btn_color); ?>"/>
            
            
            
            
        </div>
        <?php
    }

}

//Callback function to display HTML of Metabox Static Page Attributes
if (!function_exists('rtp_save_preview_meta_box')) {

    function rtp_save_preview_meta_box($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
                return;
            }

        if ( ! isset( $_POST['rtp_display_metabox_nonce'] )  || ! wp_verify_nonce( $_POST['rtp_display_metabox_nonce'], 'rtp_display_meta_box_action' ) ){
            return;
        }

        if (isset($_POST['header_color'])) {
             $header_color = ($_POST["header_color"] != '') ? $_POST["header_color"] : '';
            update_post_meta($post_id, "header_color", $header_color);
        }

        if (isset($_POST['heading_fs'])) {
            $heading_fs = ($_POST["heading_fs"] != '') ? $_POST["heading_fs"] : '';
            update_post_meta($post_id, "heading_fs", $heading_fs);
        }


        if (isset($_POST['banner_color'])) {
            $banner_color = ($_POST["banner_color"] != '') ? $_POST["banner_color"] : '';
            update_post_meta($post_id, "banner_color", $banner_color);
        }
        if (isset($_POST['main_btn_color'])) {
            $main_btn_color = ($_POST["main_btn_color"] != '') ? $_POST["main_btn_color"] : '';
            update_post_meta($post_id, "main_btn_color", $main_btn_color);
        }
    }

}
add_action('save_post', 'rtp_save_preview_meta_box');


function rtp_head_style(){
    ?>
<style>
#wpadminbar{ display: none;}
h1, header .navbar-area, .main-btn {transition: .5s;}

</style>
<?php


}

add_action('wp_head', 'rtp_head_style');
