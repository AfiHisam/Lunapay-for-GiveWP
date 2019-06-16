<?php

class Give_lunapay_Settings_Metabox {
  static private $instance;

  private function __construct() {

  }

  static function get_instance() {
    if (null === static::$instance) {
      static::$instance = new static();
    }

    return static::$instance;
  }

  /**
   * Setup hooks.
   */
  public function setup_hooks() {
    if (is_admin()) {
      add_action('admin_enqueue_scripts', array($this, 'enqueue_js'));
      add_filter('give_forms_lunapay_metabox_fields', array($this, 'give_lunapay_add_settings'));
      add_filter('give_metabox_form_data_settings', array($this, 'add_lunapay_setting_tab'), 0, 1);
    }
  }

  public function add_lunapay_setting_tab($settings) {
    if (give_is_gateway_active('lunapay')) {
      $settings['lunapay_options'] = apply_filters('give_forms_lunapay_options', array(
        'id'        => 'lunapay_options',
        'title'     => __('lunapay', 'give'),
        'icon-html' => '<span class="give-icon give-icon-purse"></span>',
        'fields'    => apply_filters('give_forms_lunapay_metabox_fields', array()),
      ));
    }

    return $settings;
  }

  public function give_lunapay_add_settings($settings) {

    // Bailout: Do not show offline gateways setting in to metabox if its disabled globally.
    if (in_array('lunapay', (array) give_get_option('gateways'))) {
      return $settings;
    }

    $is_gateway_active = give_is_gateway_active('lunapay');

    //this gateway isn't active
    if (!$is_gateway_active) {
      //return settings and bounce
      return $settings;
    }

    //Fields
    $check_settings = array(

      array(
        'name'    => __('lunapay', 'give-lunapay'),
        'desc'    => __('Do you want to customize the donation instructions for this form?', 'give-lunapay'),
        'id'      => 'lunapay_customize_lunapay_donations',
        'type'    => 'radio_inline',
        'default' => 'global',
        'options' => apply_filters('give_forms_content_options_select', array(
          'global'   => __('Global Option', 'give-lunapay'),
          'enabled'  => __('Customize', 'give-lunapay'),
          'disabled' => __('Disable', 'give-lunapay'),
        )
        ),
      ),
      array(
        'name'        => __('Client ID', 'give-lunapay'),
        'desc'        => __('Enter your Client ID, found in your lunapay Account Settings.', 'give-lunapay'),
        'id'          => 'lunapay_client_id',
        'type'        => 'text',
        'row_classes' => 'give-lunapay-key',
      ),
      array(
        'name'        => __('Secret Key', 'give-lunapay'),
        'desc'        => __('Enter your Secret Key, found in your lunapay Account Settings.', 'give-lunapay'),
        'id'          => 'lunapay_secret_key',
        'type'        => 'text',
        'row_classes' => 'give-lunapay-key',
      ),
    
    );

    return array_merge($settings, $check_settings);
  }

  public function enqueue_js($hook) {
    if ('post.php' === $hook || $hook === 'post-new.php') {
      wp_enqueue_script('give_lunapay_each_form', GIVE_lunapay_PLUGIN_URL . '/includes/js/meta-box.js');
    }
  }

}
Give_lunapay_Settings_Metabox::get_instance()->setup_hooks();