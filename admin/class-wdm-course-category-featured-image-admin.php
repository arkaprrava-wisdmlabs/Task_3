<?php
if( ! class_exists( 'WDM_Plugin_Admin' )){
    class WDM_Course_Category_Featured_Image_Admin{
        /**
         * plugin name
         *
         * @var [type]
         */
        protected $plugin_name;
        protected $plugin_dir_url;
        /**
         * defines plugin name
         *
         * @param [type] $plugin_name
         */
        public function __construct($plugin_name, $plugin_dir_url){
            $this->plugin_name = $plugin_name;
            $this->plugin_dir_url = $plugin_dir_url;
        }
        /**
         * requires and always check for the woocommerce plugin
         *
         * @return void
         */
        public function wdm_has_dependencies() {
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
        /**
         * add custom fields for category featured image in create page
         *
         * @param [type] $taxonomy
         * @return void
         */
        public function wdm_admin_enqueue_scripts(){
            wp_enqueue_script( 'admin-js', $this->plugin_dir_url.'admin/assets/js/admin.js', array('jquery'), null, true);
            wp_localize_script( 'admin-js', 'translations', array(
                'change' => __('Change Image', 'cfi'),
                'add' => __('Add new image', 'cfi'),
                'delete' => __('Delete', 'cfi'),
                'clear' => __('Clear Image', 'cfi')
            ) );
        }
        public function wdm_add_course_terms_form_fields($taxonomy){
            if( $taxonomy === 'ld_course_category' ){
                ?>
                <div class="form-field">
                    <label for="featured_image_id"><?php esc_html_e( 'Featured image', 'cfi' ) ?></label>
                    <div id="image-preview"></div>
                    <input id="upload_image_button" type="button" class="button" style="margin: 3px 1px;" value="<?php esc_html_e( 'Add new image', 'cfi' ) ?>"/>
                    <input id="delete_image_button" type="button" class="button" style="margin: 3px 1px;" value="<?php esc_html_e( 'Delete', 'cfi' )?>"/>
                    <?php wp_nonce_field( 'fi_id_set', 'featured_image_id_set' ); ?>
                    <input type='hidden' name='featured_image_id' id='featured_image_id' value="">
                </div>
                <?php
            }
        }
        /**
         * add custom fields for category featured image in edit page
         *
         * @param [type] $tag
         * @param [type] $taxonomy
         * @return void
         */
        function wdm_edit_course_terms_form_fields($tag, $taxonomy){
            $image_id = get_term_meta($tag->term_id, 'featured_image_id', true);
            $button_text = "Add New Image";
            if(!empty($image_id)){
                $image_url = esc_url( wp_get_attachment_url( $image_id ) );
                $button_text = "Change Image";
                $image_text = '<img src="'.$image_url.'" alt="image preview" width="100px" />';
            }
            if($taxonomy === 'ld_course_category'){
                ?>
                <tr class="form-field">
                    <th><label for="featured_image_id"><?php esc_html_e( 'Featured image', 'cfi' ) ?></label></th>
                    <td>
                        <div id="image-preview">
                            <?php if(!empty($image_text)){ echo $image_text; } ?>
                        </div>
                        <input id="upload_image_button" type="button" class="button" style="margin: 3px 1px;" value="<?php esc_html_e( $button_text, 'cfi' ) ?>"/>
                        <input id="delete_image_button" type="button" class="button" style="margin: 3px 1px;" value="<?php esc_html_e( 'Delete', 'cfi' )?>"/>
                        <?php wp_nonce_field( 'fi_id_set', 'featured_image_id_set' ); ?>
                        <input type='hidden' name='featured_image_id' id='featured_image_id' value="<?php if(!empty($image_id)){ echo $image_id; } ?>">
                    </td>
                </tr>
                <?php
            }
        }
        /**
         * saves the tem category image ids in term meta table
         *
         * @param [type] $term_id
         * @param [type] $taxonomy
         * @return void
         */
        public function wdm_save_terms($term_id, $taxonomy){
            if ( array_key_exists( 'featured_image_id', $_POST ) ) {
                if ( isset( $_POST['featured_image_id'] ) && ! empty( $_POST['featured_image_id'] ) ) {
                    if ( check_admin_referer( 'fi_id_set', 'featured_image_id_set' ) ) {
                        $featured_image_id = intval( $_POST['featured_image_id'] );
                        if ( 0 < $featured_image_id ) {
                            update_term_meta( $term_id, 'featured_image_id', $featured_image_id );
                        } else {
                            delete_term_meta( $term_id, 'featured_image_id' );
                        }
                    }
                }
            }
        }
    }
}