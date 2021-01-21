<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TheTagMixer
 * @subpackage TheTagMixer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    TheTagMixer
 * @subpackage TheTagMixer/public
 * @author     Your Name <email@example.com>
 */
class TheTagMixer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $thetagmixer    The ID of this plugin.
	 */
	private $thetagmixer;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $thetagmixer       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $thetagmixer, $version ) {

		$this->thetagmixer = $thetagmixer;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TheTagMixer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TheTagMixer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->thetagmixer, plugin_dir_url( __FILE__ ) . 'css/thetagmixer-public.css', array(), $this->version, 'all' );
        
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TheTagMixer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TheTagMixer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->thetagmixer, plugin_dir_url( __FILE__ ) . 'js/thetagmixer-public.js', array( 'jquery' ), $this->version, false );
        
	}

	//this is going to add our tagmixer code after the body content
	public function tagmixeraddition($ourcontent){

		//add some stuff after the content
		//$thetagmixercode = 'Hello this is after the body content.';

		//restructure the content
		//$ourcontent = $ourcontent . $thetagmixercode;

		//return the new body content
		//return $ourcontent;

	}

	public function thetagmixshorty(){
		//this is our shortcode for the tag mixer
		echo('hello world I am the shortcode firing!');
	}

    

}
