<?php
/**
 * Plugin Name: Thnks
 * Plugin URI: https://marcode.site/plugin/thnks/
 * Description: Thnks.
 * Version: 1.0
 * Requires at least: 5.6
 * Requires PHP: 7.0
 * Author: Marco Mireles
 * Author URI: https://marcomireles.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: thnks
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if (!function_exists('is_plugin_active')) {
  include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

if (!class_exists('Thnks_Page')){
  class Thnks_Page{

    public function __construct(){


      if (!is_plugin_active('woocommerce/woocommerce.php')) {
        add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
        return;
      }

      $this->define_constants();
      $this->load_textdomain();
      add_action('admin_menu', array($this,'add_menu'));
      require_once( THNKS_PATH . 'class.change-template.php' );
      $ChangeTemplate = new ThankyouPageTemplate();
      require_once (THNKS_PATH . 'class.thnks-settings-page.php');
      $Thnks_Settings_Page = new Thnks_Settings_Page();

      add_action('wp_enqueue_scripts',array($this,'register_frontend_scripts'),999);
      add_action('admin_enqueue_scripts', array($this,'register_admin_scripts'), 999);

    }
    /**
     * Define Constants
     */
    public function define_constants(){
      // Path/URL to root of this plugin, with trailing slash.
      define ( 'THNKS_PATH', plugin_dir_path( __FILE__ ) );
      define ( 'THNKS_URL', plugin_dir_url( __FILE__ ) );
      define ( 'THNKS_VERSION', '0.5' );
    }
    /**
     * Textdomain - Translate
     */
    public function load_textdomain(){
      load_plugin_textdomain(
        'thnks',
        false,
        dirname(plugin_dir_path(__FILE__)).'/languages'
      );
    }
    /**
     * Add Admin Menus
     */
    public function add_menu(){
      add_menu_page(
        esc_html__('Thnks plugin settings','thnks'),
        'Thnks plugin settings',
        'manage_options',
        'thnks_page_admin',
        array($this,'thnks_settings_page'),
        'dashicons-store',
        50
      );
    }
    /*
    * Callback Settings Page
    */
    public function thnks_settings_page(){
      if (!current_user_can('manage_options')){
        return;
      }
      if (isset($_GET['settings-updated'])){
        add_settings_error('thnks_options','thnks_message',esc_html__('Settings Saved','thnks'),'success');
      }
      settings_errors('thnks_options');
      require_once (THNKS_PATH . 'views/settings-page.php');
    }
    /*
     * Register admin script
     */
    public function register_admin_scripts($hook){

      if( $hook == 'toplevel_page_thnks_page_admin'){
        wp_enqueue_script('jquery');
        wp_enqueue_script('thnks-admin-custom-js', THNKS_URL .'assets/js/custom.js', array('jquery'), THNKS_VERSION, true );
        wp_enqueue_script('thnks-admin-js', THNKS_URL .'vendor/js/bootstrap.bundle.min.js', array('jquery'), THNKS_VERSION, true );
        wp_enqueue_style( 'thnks-admin-css', THNKS_URL . 'vendor/css/bootstrap.min.css',array(),THNKS_VERSION,'all' );
        wp_enqueue_style( 'thnks-admin-custom-css', THNKS_URL . 'assets/css/custom.min.css',array(),THNKS_VERSION,'all' );
        wp_register_style('font-nunito','https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap',array(),THNKS_VERSION,'all');
        wp_enqueue_style( 'select2-css', THNKS_URL .'vendor/css/select2.css',array(),THNKS_VERSION,'all' );
        wp_enqueue_script('select2-js', THNKS_URL .'vendor/js/select2.js', array(), THNKS_VERSION, false );

        if ( ! did_action( 'wp_enqueue_media' ) ) {
          wp_enqueue_media();
        }
      }
    }
    /*
     * Register frontend script
     */
    public function register_frontend_scripts(){
      wp_enqueue_style('thnks-custom-frontend',THNKS_URL . 'assets/css/custom-frontend.min.css',array(),THNKS_VERSION,'all');
    }
    /*
     * Admin Notices WooCommerce
     */
    public function admin_notice_missing_main_plugin() {
      if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
      $message = sprintf(
      /* translators: 1: Plugin name 2: Elementor */
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'thnks' ),
        '<strong>' . esc_html__( 'Thnks', 'thnks' ) . '</strong>',
        '<strong>' . esc_html__( 'WooCommerce', 'thnks' ) . '</strong>'
      );
      printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    /**
     * Activate the plugin
     */
    public static function activate(){
      update_option('rewrite_rules', '' );

    }

    /**
     * Deactivate the plugin
     */
    public static function deactivate(){
      flush_rewrite_rules();
    }

    /**
     * Uninstall the plugin
     */
    public static function uninstall(){
      delete_option('thnks_options');
    }

    /*
     * Uninstall the plugin
     */
    public function filter_plugin_row_meta( $links_array, $plugin_file_name, $plugin_data, $status )
    {

      if (strpos($plugin_file_name, basename(__FILE__))) {
        // You can still use `array_unshift()` to add links at the beginning.
        $links_array[] = '<b><a target="_blank" href="https://marcode.site/plugin/thnks/">Upgrade to pro⭐</a></b>';
      }
      return $links_array;
    }
  }
}

// Plugin Instantiation
if (class_exists( 'Thnks_Page' )){

  // Installation and uninstallation hooks
  register_activation_hook( __FILE__, array( 'Thnks_Page', 'activate'));
  register_deactivation_hook( __FILE__, array( 'Thnks_Page', 'deactivate'));
  register_uninstall_hook( __FILE__, array( 'Thnks_Page', 'uninstall' ) );

  // Instatiate the plugin class
  $thnks_page = new Thnks_Page();
}