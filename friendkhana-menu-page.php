<?php

function friendkhana_menu_page() {
  friendkhana_add_stylesheet();
  ?>
  <div class="wrap fk-wrap">

    <div id="dashboard-widgets-wrap">
      <div id="dashboard-widgets" class="metabox-holder">
        <div id="postbox-container-1" class="postbox-container">
          <div class="card fk-card">
            <h2>
              <img class="fk-header" src="<?php echo plugins_url('/images/header.png', __FILE__) ?>" />
            </h2>
            <form method="post" action="options.php">
              <?php settings_fields( 'friendkhana' ); ?>
              <?php do_settings_sections( 'friendkhana' ); ?>

              <table class="form-table">
                <tr valign="top">
                  <th scope="row">Auto Track ID</th>
                  <td><input type="text" name="autotrackid" value="<?php echo esc_attr( get_option('autotrackid') ); ?>" /></td>
                </tr>
              </table>

              <?php submit_button(); ?>
            </form>
          </div>
        </div>

        <div id="postbox-container-2" class="postbox-container fk-centered fk-support">
          <img class="fk-support-img" src="<?php echo plugins_url('/images/footprint.png', __FILE__) ?>"/>
          <a href=''>How to track your WooCommerce users?</a>
          <div class="fk-explanation">Track your users to know the conversion rate for your Quizzes.</div>
        </div>

      </div>
    </div>

    <div class="fk-banner fk-centered">
      <img class="fk-banner-img fk-aligned-middle" src="<?php echo plugins_url('/images/key.png', __FILE__) ?>" />
      <span class="fk-banner-body">
        Customization will be the key to determine the success of any business in the future
      </span>
    </div>

    <div class="clearfix"></div>

    <div class="fk-title fk-centered">
      <img class="fk-full-width" src="<?php echo plugins_url('/images/title.png', __FILE__) ?>" />
    </div>

    <div class="clearfix"></div>

    <div>
      <div class="fk-col-third fk-centered fk-selling-point">
        <img class="fk-selling-point-img" src="<?php echo plugins_url('/images/saas.png', __FILE__) ?>" />
        <div class="fk-selling-point-body">SaaS solution to make Quizzes</div>
      </div>
      <div class="fk-col-third fk-centered fk-selling-point">
        <img class="fk-selling-point-img" src="<?php echo plugins_url('/images/hook.png', __FILE__) ?>" />
        <div class="fk-selling-point-body">Get leads and categorize your users</div>
      </div>
      <div class="fk-col-third fk-centered fk-selling-point">
        <img class="fk-selling-point-img" src="<?php echo plugins_url('/images/woocommerce.png', __FILE__) ?>" />
        <div class="fk-selling-point-body">Easy integration in your WooCommerce store</div>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="fk-slogan fk-centered">
      <div class="fk-slogan-container"><img class="fk-slogan-img" src="<?php echo plugins_url('/images/attractive.png', __FILE__) ?>" /></div>
      <div class="fk-slogan-body">
        Our attractive and easy to answer Quizzes make increases your conversion rate three times
        higher than most popular surveys solutions
      </div>
      <div class="fk-slogan-container"><img class="fk-slogan-img" src="<?php echo plugins_url('/images/easy.png', __FILE__) ?>" /></div>
    </div>

    <div class="clearfix"></div>

    <div class="fk-process">
      <div class="fk-col-third fk-item-1"><span>Real time information</span></div>
      <div class="fk-col-third fk-item-2"><span>New data base</span></div>
      <div class="fk-col-third fk-item-3"><span>More personalized experience for your users</span></div>
    </div>

    <div class="clearfix"></div>

    <img class="fk-full-width" src="<?php echo plugins_url('/images/beforeafter.png', __FILE__) ?>" />

    <div class="clearfix"></div>

    <img class="fk-full-width" src="<?php echo plugins_url('/images/personalized.png', __FILE__) ?>" />
  </div>
<?php
}
?>
