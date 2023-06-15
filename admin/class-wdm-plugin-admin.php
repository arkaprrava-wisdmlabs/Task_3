<?php
if( ! class_exists( 'WDM_Plugin_Admin' )){
    class WDM_Plugin_Admin{
        $plugin_name;
        public function __construct($plugin_name){
            $thiss->plugin_name = $plugin_name;
        }
    }
}