<?php
$image = isset(self::$options_default['thnks_image']) ? esc_attr(self::$options_default['thnks_image']) : '';


if( $image ) {
  ?>

  <a href="#" class="marcode-upl "><img width="300" src="<?php echo $image; ?>" /> </a>
  <a href="#" class="marcode-rmv"><?php echo esc_attr_e('Remove image','thnks')?></a>
  <input type="hidden" name="thnks_options_default[thnks_image]" class="image-url" value="<?php echo $image; ?>">

  <?php
}else{ ?>
  <a href="#" class="marcode-upl button-upl"><?php echo esc_attr_e('Upload image','thnks')?></a>
  <input type="hidden" class="marcode-img-2 image-url" name="thnks_options_default[thnks_image]"  value="">
  <a href="#" class="marcode-rmv" style="display:none"><?php echo esc_attr_e('Remove image','thnks')?></a>
  <?php
}