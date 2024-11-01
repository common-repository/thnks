<select id="product-thnks" name="thnks_options_products[thnks_products]" style="width: 350px">
  <?php
  foreach( $args['items'] as $item ):
    ?>
    <option value="<?php echo esc_attr( $item['id'] ); ?>" image="<?php echo $item['image']?>"
      <?php
      isset( self::$options_products['thnks_products'] ) ? selected( $item['id'], self::$options_products['thnks_products'], true ) : '';
      ?>
    ><?php echo esc_html( ucfirst( $item['titulo'] ) ); ?></option>
  <?php endforeach; ?>
</select>