<?php
/**
 * Plugin Name: Learndash LMS - Course Category Featured Image
 * Plugin URI: https://github.com/arkaprrava-wisdmlabs/task_3.git
 * Description: Adds Category image to Learndash Course Categories
 * Version: 1.0.0
 * Author: Arkaprava
 * Text Domain: wdm_cfi
 * 
 * @package wdm
 */

defined( 'ABSPATH' ) || die;

if( ! class_exists( 'WDM_Course_Category_Featured_Image_Plugin' ) ){
    class WDM_Course_Category_Featured_Image_Plugin{
        protected $plugin_name;
        public function __construct($plugin_name){
            $this->plugin_name = $plugin_name;
            $this->define_admin_hooks();
            $this->define_public_hooks();
        }
        public function define_admin_hooks(){
            require_once plugin_dir_path( __FILE__ ) . 'admin/class-wdm-course-category-featured-image-admin.php';
            $admin = new WDM_Course_Category_Featured_Image_Admin($this->plugin_name);
            add_action( 'admin_init',array( $admin, 'wdm_has_learndash' ) , 10, 0);
        }
        public function define_public_hooks(){
            require_once plugin_dir_path( __FILE__ ) . 'public/class-wdm-course-category-featured-image-public.php';
            $public = new WDM_Course_Category_Featured_Image_Public($this->plugin_name);
            // add_action( 'hook', array( $public, 'function' ), 10, 0);
        }
    }
}
new WDM_Course_Category_Featured_Image_Plugin(plugin_basename( __FILE__ ));