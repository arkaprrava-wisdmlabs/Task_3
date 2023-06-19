<?php
if( ! class_exists( 'WDM_Plugin_Admin' )){
    class WDM_Course_Category_Featured_Image_Admin{
        /**
         * plugin name
         *
         * @var [type]
         */
        protected $plugin_name;
        /**
         * defines plugin name
         *
         * @param [type] $plugin_name
         */
        public function __construct($plugin_name){
            $this->plugin_name = $plugin_name;
        }
        /**
         * requires and always check for the woocommerce plugin
         *
         * @return void
         */
        public function wdm_has_learndash() {
            if ( is_admin() && current_user_can( 'activate_plugins' ) &&  (!is_plugin_active( 'category-featured-image/categoryfeaturedimage.php') || !is_plugin_active( 'sfwd-lms/sfwd_lms.php') )) {
                add_action( 'admin_notices',array( $this, 'wdm_admin_notice' ), 10, 0);

                deactivate_plugins( $this->plugin_name ); 

                if ( isset( $_GET['activate'] ) ) {
                    unset( $_GET['activate'] );
                }
            }
        }
        /**
         * displays admin notice on dependency plugin not active
         *
         * @return void
         */
        public function wdm_admin_notice(){
            ?><div class="error"><p><?php _e( 'Sorry, but Course Category Featured Image Plugin requires the LearnDash and Category Featured Image plugin both to be installed and active.' ); ?></p></div><?php
        }
    }
}