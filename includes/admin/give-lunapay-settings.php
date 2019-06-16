<?php

/**
 * Class Give_lunapay_Settings
 *
 * @since 3.0.2
 */
class Give_lunapay_Settings {

  /**
   * @access private
   * @var Give_lunapay_Settings $instance
   */
  static private $instance;

  /**
   * @access private
   * @var string $section_id
   */
  private $section_id;

  /**
   * @access private
   *
   * @var string $section_label
   */
  private $section_label;

  /**
   * Give_lunapay_Settings constructor.
   */
  private function __construct() {

  }

  /**
   * get class object.
   *
   * @return Give_lunapay_Settings
   */
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

    $this->section_id    = 'lunapay';
    $this->section_label = __('lunapay', 'give-lunapay');

    if (is_admin()) {
      // Add settings.
      add_filter('give_settings_gateways', array($this, 'add_settings'), 99);
    }
  }

  /**
   * Add setting section.
   *
   * @param array $sections Array of section.
   *
   * @return array
   */
  public function add_section($sections) {
    $sections[$this->section_id] = $this->section_label;

    return $sections;
  }

  /**
   * Add plugin settings.
   *
   * @param array $settings Array of setting fields.
   *
   * @return array
   */
  public function add_settings($settings) {

    $give_lunapay_settings = array(
      array(
        'name' => __('Lunapay Settings', 'give-lunapay'),
        'id'   => 'give_title_lunapay',
        'type' => 'give_title',
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

    return array_merge($settings, $give_lunapay_settings);
  }
}

Give_lunapay_Settings::get_instance()->setup_hooks();