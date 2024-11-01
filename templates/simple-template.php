<?php
/**
 * Template Name: Simple Template
 * Description: A simple template.
 */


get_header();
$order = wc_get_order( $GLOBALS['wp']->query_vars['order-received'] );

$base_color ='';
$thnks_color = Thnks_Settings_Page::$options_styles['thnks_custom_color'] ?? '';
if ($thnks_color && $thnks_color != '#0d6efd') {
  echo "<style>.base-color{color:".esc_attr($thnks_color)." !important;}</style>";
  $base_color = 'base-color';
}

$thnks_custom_color_bg = isset(Thnks_Settings_Page::$options_styles['thnks_custom_color_bg']) && Thnks_Settings_Page::$options_styles['thnks_custom_color_bg'] != '#4364FF' ? Thnks_Settings_Page::$options_styles['thnks_custom_color_bg'] : '#4364FF';
if ( is_order_received_page() ) {
  ?>
  <style>
      body{
          background-color:<?php echo esc_attr($thnks_custom_color_bg);?> !important;
      }
  </style>
  <?php
}
?>


<section class="thnks-wrap ">
  <div class="container ">
    <div id="order-header" class="row mb-40">
        <img class="img-thnks" src="<?php
        $thnks_image = Thnks_Settings_Page::$options_default['thnks_image'];
        if(isset($thnks_image)){
          echo esc_attr($thnks_image);
        }else{
          echo THNKS_URL . 'assets/img/thnks.png;';
        }
        ?>" alt="Thnks">
        <p class="short-message mt-20"><?php
          $thnks_message = Thnks_Settings_Page::$options_default['thnks_thank_you_message'];
          if (isset($thnks_message)){
            echo esc_html($thnks_message);
          }else{
            echo esc_html_e('Thanks for your purchase! We are glad that you have chosen our products.','thnks');
          }

          ?></p>
      <?php
      $thnks_custom_order_meta_color = isset(Thnks_Settings_Page::$options_styles['thnks_custom_order_meta_color']) && Thnks_Settings_Page::$options_styles['thnks_custom_order_meta_color'] != '#eaeaea' ? Thnks_Settings_Page::$options_styles['thnks_custom_order_meta_color'] : '#eaeaea';
      ?>
      <style>
          .meta-data-order-details{
              background-color:<?php echo esc_attr($thnks_custom_order_meta_color);?> !important;
          }
      </style>
      <p class="meta-data-order-details">
        <span><b><?php echo esc_html_e('Order:','thnks'); ?></b> <?php echo $order->get_order_number();?></span>
        <span><b><?php echo esc_html_e('Date:','thnks'); ?></b> <?php echo $order->get_date_created()->format('Y-m-d');?></span>
        <span><b><?php echo esc_html_e('Payment method:','thnks'); ?></b> <?php echo $order->get_payment_method_title();?></span>
      </p>
    </div>
    <div id="order-details-title" class="row">
        <h2 class="title-order-details <?php echo esc_attr($base_color);?>"><?php echo esc_html_e('Order Details','thnks'); ?></h2>
    </div>
    <div id="order-details" class="row mt-30">
      <?php
      $items = $order->get_items();
      $total = $order->get_total();
      ?>
      <div class="header-table">
        <p><?php echo esc_html_e('Products','thnks')?></p>
        <p><?php echo esc_html_e('Total','thnks')?></p>
      </div>
      <div class="body-table">
        <?php
        foreach ($items as $item) {
          $product = $item->get_product();
          $product_name = esc_html($product->get_name());
          $product_image = $product->get_image();
          $quantity = $item->get_quantity();
          $price = $product->get_price();
          $total_price =  $quantity * $price ;
        ?>
        <div class="product-item">
          <div class="product">
            <?php echo wp_kses_post($product_image); ?>
            <p><?php echo esc_html($product_name); ?></p>
          </div>
          <div class="product-total">
            <?php echo wc_price($total_price); ?>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="footer-table">
        <div class="subtotal">
          <p class="title"><?php echo esc_html_e('Subtotal','thnks')?></p>
          <p><?php echo '$'.$order->get_subtotal();;?></p>
        </div>
        <div class="shipping">
          <p class="title"><?php echo esc_html_e('Shipping','thnks')?></p>
          <p><?php echo  '$'.$order->get_shipping_total(); ?></p>
        </div>
        <div class="total">
          <p class="title font-blue <?php echo esc_attr($base_color);?>"><?php echo esc_html_e('Total','thnks')?></p>
          <p class="font-blue <?php echo esc_attr($base_color);?>"><b><?php echo wc_price($total);?></b></p>
        </div>
      </div>
    </div>

    <div id="customer-details" class="row mt-30 mb-50">
      <h3 class="title-customer-details mb-10 <?php echo esc_attr($base_color);?>"><?php echo esc_html_e('Customer Details','thnks'); ?></h3>
      <div class=" additional-data">
        <div class="customer-data">
          <p class="full-name c-data">
          <span>
            <b><?php echo esc_html_e('Name','thnks'); ?>:</b>
          </span>
            <?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?>
          </p>
          <p class="email c-data">
          <span>
            <b><?php echo esc_html_e('E-mail','thnks'); ?>:</b>
          </span>
            <?php echo $order->get_billing_email(); ?>
          </p>
          <p class="phone c-data">
          <span>
            <b><?php echo esc_html_e('Phone','thnks'); ?>:</b>
          </span>
            <?php echo $order->get_billing_phone(); ?>
          </p>
          <p class="billing c-data">
          <span>
            <b><?php echo esc_html_e('Billing Address','thnks'); ?>:</b>
          </span><br>
            <?php
            $billing_address = $order->get_formatted_billing_address();
            $billing_address = str_replace('<br/>', ', ', $billing_address);
            echo $billing_address; ?>
          </p>
        </div>
        <div class="attention">
          <?php
          $thnks_custom_support_color = isset(Thnks_Settings_Page::$options_styles['thnks_custom_support_color']) && Thnks_Settings_Page::$options_styles['thnks_custom_support_color'] != '#eaeaea' ? Thnks_Settings_Page::$options_styles['thnks_custom_support_color'] : '#eaeaea';
          ?>
          <style>
              .a-data{
                  background-color:<?php echo esc_attr($thnks_custom_support_color);?> !important;
              }
          </style>
          <div class="a-data">
            <p class="attention-message">
              <?php
              $thnks_provide_info = Thnks_Settings_Page::$options_default['thnks_provide_information'];
              if (isset($thnks_provide_info)){
                echo esc_html($thnks_provide_info);
              }else{
                echo esc_html_e('Do you have any questions with your order? Feel free to contact us.','thnks');
              }
              ?>
            </p>
            <p class="attention-contact">
              <?php
                $thnks_info_channel = Thnks_Settings_Page::$options_default['thnks_information_channel'];
                if (isset($thnks_info_channel)){
                  echo esc_html($thnks_info_channel);
                }else{
                  echo esc_attr('hi@marcode.site');
                }
              ?>
            </p>
          </div>
        </div>
      </div>

    </div>

    <div id="products-promotion" class="row">
      <div class="content-product-promotion">
        <?php
        $thnks_product = Thnks_Settings_Page::$options_products['thnks_products'];
        if (isset($thnks_product)){
          $product = wc_get_product($thnks_product);
          $product_image =$product->get_image();
          $permalink = esc_url($product->get_permalink());
          $title = esc_html($product->get_name());
          $description = esc_html($product->get_short_description());
          $regular_price =$product->get_regular_price();
          $sale_price = $product->get_sale_price();
          if ($sale_price) {
            $price = wc_price($sale_price);
            $regular_price = '<del>' . wc_price($regular_price) . '</del>';
          } else {
            $price = wc_price($regular_price);
            $regular_price = '';
          }
          ?>
          <div class="product-promotion">
            <div class="image">
              <?php echo wp_kses_post($product_image);?>
            </div>
            <div class="product-data">
              <div class="title"><?php echo esc_html($title);?></div>
              <div class="description"><?php echo esc_html($description);?></div>
              <div class="price"><?php echo sanitize_text_field($regular_price . ' '. $price);?></div>
              <?php
              $thnks_custom_color_button = isset(Thnks_Settings_Page::$options_products['thnks_custom_color_button']) && Thnks_Settings_Page::$options_products['thnks_custom_color_button'] != '#4364FF' ? Thnks_Settings_Page::$options_products['thnks_custom_color_button'] : '#4364FF';
              $thnks_custom_color_button_hover = isset(Thnks_Settings_Page::$options_products['thnks_custom_color_button_hover']) && Thnks_Settings_Page::$options_products['thnks_custom_color_button_hover'] != '#003E9B' ? Thnks_Settings_Page::$options_products['thnks_custom_color_button_hover'] : '#003E9B';
              $thnks_custom_text_color_button = isset(Thnks_Settings_Page::$options_products['thnks_custom_text_color_button']) && Thnks_Settings_Page::$options_products['thnks_custom_text_color_button'] != '#FFFFFF' ? Thnks_Settings_Page::$options_products['thnks_custom_text_color_button'] : '#FFFFFF';
               ?>
              <style>
                .permalink{
                    background-color:<?php echo esc_attr($thnks_custom_color_button);?> !important;
                }
                .permalink:hover{
                    background-color:<?php echo esc_attr($thnks_custom_color_button_hover);?> !important;
                }
                .permalink a{
                    color:<?php echo esc_attr($thnks_custom_text_color_button);?> !important;
                }
              </style>

              <div class="permalink"><a href="<?php echo esc_url($permalink);?>"><?php echo esc_attr_e('Visit the product.','thnks')?></a></div>
            </div>
          </div>

          <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>

<?php //if ( isset( $order ) ) : ?>
<!--  <p>Order ID: --><?php //echo $order->get_id(); ?><!--</p>-->
<!--  <p>Order Status: --><?php //echo $order->get_status(); ?><!--</p>-->
<?php //endif; ?>

<?php
get_footer();