<?php
if( ! class_exists( 'WDM_Plugin_Public' )){
    class WDM_Plugin_Public{
        protected $plugin_name;
        public function __construct($plugin_name){
            $this->plugin_name = $plugin_name;
        }
    }
}