<div class="wrap thnks-admin-container vh-100">
  <div class="header-settings-thnks">
    <h1 class="title-thnks"><?php echo esc_html(get_admin_page_title());?></h1>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card w-100 mw-100 bg-white">
          <div class="card-body">
            <div class="container ">
              <div class="row align-items-center">
                <div class="col-12 col-md-9">
                  <ul class="nav nav-pills align-items-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><?php esc_html_e('Settings','thnks'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-default-thnks-tab" data-bs-toggle="pill" data-bs-target="#pills-default-thnks" type="button" role="tab" aria-controls="pills-default" aria-selected="false"><?php esc_html_e('Default page','thnks'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-default-styles-tab" data-bs-toggle="pill" data-bs-target="#pills-default-styles" type="button" role="tab" aria-controls="default-styles" aria-selected="false"><?php esc_html_e('Custom styles','thnks'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-products-tab" data-bs-toggle="pill" data-bs-target="#pills-products" type="button" role="tab" aria-controls="products" aria-selected="false"><?php esc_html_e('Product','thnks'); ?></button>
                    </li>
                  </ul>
                </div>
                <div class="col-12 col-md-3 text-end">
                </div>
              </div>
            </div>
            <hr>
            <div class="container mt-2">
              <div class="row">
                <div class="col-12">

                    <div class="tab-content" id="pills-tabContent">
                      <!-- TAB 1-->
                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <form action="options.php" method="post" id="form-enable">
                        <?php
                        settings_fields('thnks_group');
                        do_settings_sections('thnks_page1');
                        ?>
                        <?php submit_button(esc_html__('Save Settings','thnks')); ?>
                        </form>
                      </div>
                      <!-- TAB 2-->
                      <div class="tab-pane fade show" id="pills-default-thnks" role="tabpanel" aria-labelledby="pills-default-thnks-tab" tabindex="0">
                        <form action="options.php" method="post" id="form-enable">
                        <?php
                        settings_fields('thnks_group2');
                        do_settings_sections('thnks_page2');
                        ?>
                        <?php submit_button(esc_html__('Save Default page','thnks')); ?>
                        </form>
                      </div>
                      <!-- TAB 3-->
                      <div class="tab-pane fade show" id="pills-default-styles" role="tabpanel" aria-labelledby="pills-default-styles-tab" tabindex="0">
                        <form action="options.php" method="post" id="form-enable">
                          <?php
                          settings_fields('thnks_group3');
                          do_settings_sections('thnks_page3');
                          ?>
                          <?php submit_button(esc_html__('Save Custom styles','thnks')); ?>
                        </form>
                      </div>
                      <!-- TAB 4-->
                      <div class="tab-pane fade show" id="pills-products" role="tabpanel" aria-labelledby="pills-products-tab" tabindex="0">
                        <form action="options.php" method="post" id="form-enable">
                          <?php
                          settings_fields('thnks_group4');
                          do_settings_sections('thnks_page4');
                          ?>
                          <?php submit_button(esc_html__('Save Product','thnks')); ?>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
