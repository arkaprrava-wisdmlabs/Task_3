<?php
if( ! class_exists( 'WDM_Plugin_Public' )){
    class WDM_Course_Category_Featured_Image_Public{
        /**
         * plugin direcory url
         *
         * @var [type]
         */
        protected $plugin_dir_url;
        /**
         * defines the plugin directory url
         *
         * @param [type] $plugin_name
         */
        public function __construct($plugin_dir_url){
            $this->plugin_dir_url = $plugin_dir_url;
        }
        /**
         * registerd and enqueued style for the shortcode in the frontend
         *
         * @return void
         */
        public function wdm_enqueue_styles(){
            wp_register_style( 'shortcode_css', $this->plugin_dir_url.'public/assets/css/shortcode-css.css');
            wp_enqueue_style( 'shortcode_css' );
        }
        /**
         * add a shortcode to show th course catgories in the frontend
         *
         * @param [type] $atts
         * @return void
         */
        public function wdm_shortcode($atts){
            $out = '<div class="course-category">';
            $course_text = learndash_get_custom_label( 'course' );
            $head = '<center class="course_category_heading"><h2>'.__( $course_text.' Categories', 'wdm_cfi').'</h2></center>';
            $number_of_course_category = 0;
            if(isset($atts['categorynumber'])){
                $number_of_course_category = $atts['categorynumber'];
            }
            $page_link = get_permalink();
            $content_style = '';
            $card_style = '';
            $category_link = '';
            $category_page = get_page_by_title( $course_text.' Categories');
            if(!empty($category_page)){
                if( $category_page->post_status === 'publish' ){
                    $category_link = get_permalink( $category_page );
                }
            }
            if($page_link === $category_link){
                $content_style = 'style="margin-left:-40px"';
                $card_style = 'style="width:360px;"';
            }
            else{
                $out .= $head;
            }
            if( empty( $category_link ) ){
                $category_link = $page_link;
            }
            $out .= '<div class="course_category_content"'.$content_style.' >';
            $terms = get_terms(array( 'taxonomy' => 'ld_course_category', 'number' => $number_of_course_category ));
            if( empty($terms) ){
                $out .= '<p>'.__('No '.$course_text.' Category found', 'wdm_cfi') .'</p></div>';
                return $out;
            }
            $a = 0;
            foreach($terms as $term){
                if($a%3 === 0){
                    $out .= '<div class="row">';
                }
                $term_id = $term->term_id;
                $image_id = intval( get_term_meta( $term_id, 'featured_image_id', true ) );
                $image_url= plugin_dir_url(__FILE__).'assets/images/course-category-image.jpeg';
                if($image_id > 0){
                    $image_url = esc_url( wp_get_attachment_url( $image_id ) );
                }
                $out .= '<a href="'.get_term_link($term, 'ld_course_category').'"><div class="course_category_card"'.$card_style.' >';
                $out .= '<div class="figure"><img src="'.$image_url.'" alt="'.$course_text.' Category image"></div>';
                $out .= '<div class="course_category_card_content">';
                $out .= '<h4>'.$term->name.'</h4>';
                $count = $term->count;
                $text = ' '.$course_text.'s';
                if($count < 2){
                    $text = ' '.$course_text;
                }
                $out .= '<p>'.$term->count.__($text, 'wdm_cfi').'</p>';
                $out .= '</div>';
                $out .= '</div></a>';
                if($a%3 === 2){
                    $out .= '</div>';
                }
                $a += 1;
            }
            $out .= '</div>';
            if( $number_of_course_category > 0 ){
                $out .= '<center class="course_category_link"><a href="'.$category_link.'"><button>'.__('See More', 'wdm_cfi').'</button></a></center>';
            }
            $out .= '</div>';
            return $out;
        }
    }
}