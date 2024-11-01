<?php
class ThankyouPageTemplate {

  private $enable;


  public function __construct() {
    add_action('init', array($this, 'set_enable_value'));
    add_filter( 'template_include', array( $this, 'change_template_thankyou_page' ), 9999 );
  }

  public function set_enable_value() {
    $options = get_option('thnks_options');
    $this->enable = isset($options['thnks_enable']) ? $options['thnks_enable'] : 'desactive';
  }

  public function filter($enable){
    add_filter( 'template_include', array( $this, 'change_template_thankyou_page' ), 9999 );
  }

  public function change_template_thankyou_page( $template ) {
    if($this->enable == 'active'){
      if ( is_wc_endpoint_url( 'order-received' ) && ! empty( $GLOBALS['wp']->query_vars['order-received'] ) ) {
        $order = wc_get_order( $GLOBALS['wp']->query_vars['order-received'] );
        $order_id  = $order->get_id();
        $new_template = $this->the_new_template();
        return $new_template;
      }
    }
    return $template;
  }
  public function get_the_order_items($order_id){
    $order = wc_get_order($order_id);
    $items = $order->get_items();
    $ids_productos = array();

    foreach ($items as $item) {
      $ids_productos[] = $item->get_product_id();
    }

    return $ids_productos;
  }
  public function the_new_template(){
    $new_template = THNKS_PATH . 'templates/simple-template.php';
    return $new_template;
  }

}