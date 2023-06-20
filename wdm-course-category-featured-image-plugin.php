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
        /**
         * plugin name
         *
         * @var [type]
         */
        protected $plugin_name;
        /**
         * plugin_dir_url
         *
         * @var [type]
         */
        protected $plugin_dir_url;
        /**
         * defines plugin name and plugin dir url for the class
         *
         * @param [type] $plugin_name
         * @param [type] $plugin_dir_url
         */
        public function __construct($plugin_name, $plugin_dir_url){
            $this->plugin_name = $plugin_name;
            $this->plugin_dir_url = $plugin_dir_url;
            $this->define_admin_hooks();
            $this->define_public_hooks();
        }
        /**
         * defines admin hooks
         *
         * @return void
         */
        public function define_admin_hooks(){
            require_once plugin_dir_path( __FILE__ ) . 'admin/class-wdm-course-category-featured-image-admin.php';
            $admin = new WDM_Course_Category_Featured_Image_Admin($this->plugin_name);
            add_action( 'admin_init',array( $admin, 'wdm_has_learndash' ) , 10, 0);
            add_action( 'ld_course_category_edit_form_fields',array( $admin, 'wdm_edit_course_terms_form_fields') , 10, 2 );
            add_action( 'ld_course_category_add_form_fields', array( $admin, 'wdm_add_course_terms_form_fields'), 10, 1 );
            add_action('create_term', array( $admin, 'wdm_save_terms') , 10, 2);
            add_action('edit_terms', array( $admin, 'wdm_save_terms'), 10, 2);
        }
        /**
         * defines public hooks
         *
         * @return void
         */
        public function define_public_hooks(){
            require_once plugin_dir_path( __FILE__ ) . 'public/class-wdm-course-category-featured-image-public.php';
            $public = new WDM_Course_Category_Featured_Image_Public($this->plugin_dir_url);
            add_action( 'wp_enqueue_scripts',array( $public, 'wdm_enqueue_styles' ) , 10, 0);
            add_shortcode( 'shortcode',array( $public, 'wdm_shortcode' ) , 10, 1);
        }
    }
}
new WDM_Course_Category_Featured_Image_Plugin(plugin_basename( __FILE__ ), plugin_dir_url( __FILE__ ));