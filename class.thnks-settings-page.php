<?php
if( !class_exists( 'Thnks_Settings_Page') ){
  class Thnks_Settings_Page{

    public static $options;
    public static $options_default;
    public static $options_styles;
    public static $options_products;

    public function  __construct(){
      self::$options = get_option('thnks_options');
      self::$options_default = get_option('thnks_options_default');
      self::$options_styles = get_option('thnks_options_styles');
      self::$options_products = get_option('thnks_options_products');
      add_action('admin_init',array($this, 'admin_init'));

    }
    //    Crear FIELDS
    public function admin_init(){

      //Register Settings
      register_setting(
        'thnks_group',
        'thnks_options',
        array($this, 'thnks_validate')
      );
      //Register Default Thnks
      register_setting(
        'thnks_group2',
        'thnks_options_default',
        array($this, 'thnks_validate')
      );
      //Register Custom styles
      register_setting(
        'thnks_group3',
        'thnks_options_styles',
        array($this, 'thnks_validate')
      );
      //Register Products
      register_setting(
        'thnks_group4',
        'thnks_options_products',
        array($this, 'thnks_validate')
      );
      // Add Section Settings
      add_settings_section(
        'thnks_main_section',
        esc_html__('Settings','thnks'),
        null,
        'thnks_page1'
      );
      // Add Section Default Thnks
      add_settings_section(
        'thnks_default_section',
        esc_html__('Default page','thnks'),
        null,
        'thnks_page2'
      );
      // Add Section Custom styles
      add_settings_section(
        'thnks_styles_section',
        esc_html__('Custom styles','thnks'),
        null,
        'thnks_page3'
      );
      // Add Section Custom styles
      add_settings_section(
        'thnks_products_section',
        esc_html__('Products','thnks'),
        null,
        'thnks_page4'
      );

      // Enable Thnks
      add_settings_field(
        'thnks_enable',
        esc_html__('Enable the custom template of the Thnks plugin','thnks'),
        array($this,'thnks_enable_callback'),
        'thnks_page1',
        'thnks_main_section',
        array(
          'label_for' => 'thnks_enable',
          'class' => 'container-label'
        )
      );

      // Image for Thnks Page
      add_settings_field(
        'thnks_image',
        esc_html__('Select image for thank you page','wa-bubble'),
        array($this,'thnks_image_callback'),
        'thnks_page2',
        'thnks_default_section',
        array(
          'label_for' => 'thnks_image',
          'class' => 'container-label'
        )
      );

      // Thank you message.
      add_settings_field(
        'thnks_thank_you_message',
        esc_html__('Write the thank you message','thnks'),
        array($this,'thnks_thank_you_message_callback'),
        'thnks_page2',
        'thnks_default_section',
        array(
          'label_for' => 'thank_you_message',
          'class' => 'container-label w-600'
        )
      );

      // Message to provide information
      add_settings_field(
        'thnks_provide_information',
        esc_html__('Message to provide information','thnks'),
        array($this,'thnks_provide_information_callback'),
        'thnks_page2',
        'thnks_default_section',
        array(
          'label_for' => 'thnks_provide_information',
          'class' => 'container-label w-600'
        )
      );

      // Message to provide information
      add_settings_field(
        'thnks_information_channel',
        esc_html__('Information channel','thnks'),
        array($this,'thnks_information_channel_callback'),
        'thnks_page2',
        'thnks_default_section',
        array(
          'label_for' => 'thnks_information_channel',
          'class' => 'container-label w-300'
        )
      );

      // Custom styles - Color
      add_settings_field(
        'thnks_custom_color',
        esc_html__('Choose the base color','thnks'),
        array($this,'thnks_custom_color_callback'),
        'thnks_page3',
        'thnks_styles_section',
        array(
          'label_for' => 'thnks_custom_color',
          'class' => 'container-label '
        )
      );

      // Custom styles - Color
      add_settings_field(
        'thnks_custom_color_bg',
        esc_html__('Choose the background color','thnks'),
        array($this,'thnks_custom_color_bg_callback'),
        'thnks_page3',
        'thnks_styles_section',
        array(
          'label_for' => 'thnks_custom_color_bg',
          'class' => 'container-label '
        )
      );

      // Custom styles - Color Metadata
      add_settings_field(
        'thnks_custom_order_meta_color',
        esc_html__('Choose a color for the background of the order metadata. (Order No. - Date - Payment method)','thnks'),
        array($this,'thnks_custom_order_meta_color_callback'),
        'thnks_page3',
        'thnks_styles_section',
        array(
          'label_for' => 'thnks_custom_order_meta_color',
          'class' => 'container-label '
        )
      );

      // Custom styles - Color Support Box
      add_settings_field(
        'thnks_custom_support_color',
        esc_html__('Choose a background color for the order support box.','thnks'),
        array($this,'thnks_custom_support_color_callback'),
        'thnks_page3',
        'thnks_styles_section',
        array(
          'label_for' => 'thnks_custom_support_color',
          'class' => 'container-label '
        )
      );

      //Get Products
      $args = array(
        'type' => array('simple', 'variable'),
        'return' => 'objects',
      );
      $products = wc_get_products( $args );
      $productArray =[];
      foreach ( $products as $product ) {
        $productImage = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );
        $productArray[] = [
          'id' => $product->get_id(),
          'titulo' => $product->get_name(),
          'image' =>$productImage[0],
          'permalink' => get_permalink($product->get_id())
        ];
      }
      add_settings_field(
        'thnks_products',
        esc_html__('Select the product that will appear below the thank you page','thnks'),
        array($this,'thnks_products_callback'),
        'thnks_page4',
        'thnks_products_section',
        array(
          'items' => $productArray,
          'label_for' => 'thnks_products',
          'class' => 'container-label '

        )
      );

      // Custom Product - Color Button
      add_settings_field(
        'thnks_custom_text_color_button',
        esc_html__('Choose the text color of the button "see product"','thnks'),
        array($this,'thnks_custom_text_color_button'),
        'thnks_page4',
        'thnks_products_section',
        array(
          'label_for' => 'thnks_custom_text_color_button',
          'class' => 'container-label '
        )
      );

      // Custom Product - Color Button
      add_settings_field(
        'thnks_custom_color_button',
        esc_html__('Choose the color of the button "see product"','thnks'),
        array($this,'thnks_custom_color_button_callback'),
        'thnks_page4',
        'thnks_products_section',
        array(
          'label_for' => 'thnks_custom_color_button',
          'class' => 'container-label '
        )
      );

      // Custom Product - Color Button Hover
      add_settings_field(
        'thnks_custom_color_button_hover',
        esc_html__('Choose the hover color of the "see product" button','thnks'),
        array($this,'thnks_custom_color_button_hover_callback'),
        'thnks_page4',
        'thnks_products_section',
        array(
          'label_for' => 'thnks_custom_color_button_hover',
          'class' => 'container-label '
        )
      );

    }

    public function thnks_enable_callback($args){
      require_once (THNKS_PATH . 'views/fields/settings/enable-thnks.php');
    }
    public function thnks_image_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/image.php');
    }
    public function thnks_thank_you_message_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/thank-you-message.php');
    }
    public function thnks_provide_information_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/provide-information.php');
    }
    public function thnks_information_channel_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/information-channel.php');
    }
    public function thnks_custom_color_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/default-colors.php');
    }
    public function thnks_custom_color_bg_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/background-color.php');
    }
    public function thnks_products_callback($args){
      require_once (THNKS_PATH . 'views/fields/products/products-selector.php');
    }
    public function thnks_custom_color_button_callback($args){
      require_once (THNKS_PATH . 'views/fields/products/products-color-btn.php');
    }
    public function thnks_custom_color_button_hover_callback($args){
      require_once (THNKS_PATH . 'views/fields/products/products-color-btn-hover.php');
    }
    public function thnks_custom_text_color_button($args){
      require_once (THNKS_PATH . 'views/fields/products/products-text-color-btn.php');
    }
    public function thnks_custom_order_meta_color_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/metabox-color.php');
    }
    public function thnks_custom_support_color_callback($args){
      require_once (THNKS_PATH . 'views/fields/default-template/support-box-color.php');
    }

    public function thnks_validate( $input ){
      $new_input = array();
      foreach( $input as $key => $value ){
        switch ($key){
          case 'thnks_enable':
            if( empty( $value )){
              $value = esc_html__('desactive','thnks');
            }
            $new_input[$key] = sanitize_text_field( $value );
            // Verificar si el valor es "active"
            if ($new_input[$key] == 'active') {
              // Instanciar la clase
              $ChangeTemplate = new ThankyouPageTemplate();
              $ChangeTemplate->filter($new_input[$key]);
            }
            break;
          case 'thnks_image':
            if( empty( $value )){
              $value = THNKS_URL . 'assets/img/thnks.png';
            }
            $new_input[$key] = sanitize_url( $value );
            break;
          default:
            $new_input[$key] = sanitize_text_field( $value );
            break;
        }
      }

      return $new_input;
    }


  }
}

