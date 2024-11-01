<?php
$enable = isset(self::$options['thnks_enable']) ? self::$options['thnks_enable'] : 'desactive';
?>
<div class="row align-items-center">
  <div class="col-12 col-md-4">
    <input type="hidden" value="<?php echo $enable;?>" name="thnks_options[thnks_enable]" id="thnks_enable">
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
      <input type="radio" class="btn-check" name="option_thnks_enable" id="active" autocomplete="off"
      <?php echo ($enable == 'active')? 'checked': ''; ?>
      >
      <label class="btn btn-outline-primary" for="active"><?php esc_html_e('Active','thnks'); ?></label>
      <input type="radio" class="btn-check" name="option_thnks_enable" id="desactive" autocomplete="off"
      <?php echo ($enable == 'desactive')? 'checked': ''; ?>
      >
      <label class="btn btn-outline-primary" for="desactive" ><?php esc_html_e('Desactive','thnks'); ?></label>
    </div>
  </div>
</div>