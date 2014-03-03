<?php
/**
 * Pco base plugin
 *
 * @package Pco Base Plugin
 * @author  Patrick Hesselberg & James Bonham @Peytz & Co
 *
 * Plugin Name:       Pco Base Plugin
 * Plugin URI:        https://github.com/Peytz-WordPress/pco-bpl
 * Description:       A base plugin for pco
 * Version:           0.1
 * Author:            Peytz & Co (Patrick Hesselberg & James Bonham)
 * Author URI:        http://peytz.dk/medarbejdere/
 * Text Domain:       pco-bpl
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/Peytz-WordPress/pco-bpl
 */

// Do not access this file directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Pco_Base_Plugin {
	/**
	 * @var object Instance of this class.
	 */
	private static $instance;

	/**
	 * @var string Filename of this class.
	 */
	public $file;

	/**
	 * @var string Basename of this class.
	 */
	public $basename;

	/**
	 * @var string Plugins directory for this plugin.
	 */
	public $plugin_dir;

	/**
	 * @var string Plugins url for this plugin.
	 */
	public $plugin_url;

	/**
	 * @var string Lang dir for this plugin.
	 */
	public $lang_dir;

	/**
	 * @var array Objects of this class.
	 */
	public $objects = array();

	/**
	 * Do not load this more than once.
	 */
	private function __construct() {}

	/**
	 * Returns the instance of this class.
	 */
	public static function instance() {
		if( ! isset( self::$instance ) ) {
			self::$instance = new self;
			self::$instance->setup();
			self::$instance->includes();
		}

		return self::$instance;
	}

	/**
	 * General setup.
	 */
	private function setup() {
		$this->file       = __FILE__;
		$this->basename   = plugin_basename( $this->file );
		$this->plugin_url = plugin_dir_url( $this->file );
		$this->plugin_dir = plugin_dir_path( $this->file );
		$this->lang_dir   = $this->plugin_dir . 'languages';
	}

	/**
	 * Include files.
	 */
	private function includes() {
		require $this->plugin_dir . 'includes/functions.php';
		require $this->plugin_dir . 'includes/pco-base.php';
	}

	public function get_object( $object ) {
		if( array_key_exists( $object, $this->objects ) ) {
			return $this->objects[$object];
		}

		return false;
	}

	public function get_objects() {
		return $this->objects;
	}

	public function add_object( $object ) {
		if( !array_key_exists( $object, $this->objects ) ) {
			$this->objects[$object] = new $object;

			return true;
		}

		return false;
	}
}

function pco_base() {
	return Pco_Base_Plugin::instance();
}

add_action( 'plugins_loaded', 'pco_base' );
echo "<pre>"; die(print_r(pco_base()));

