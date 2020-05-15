<?php
/**
 * Plugin Name: Automate Likes/Smiles
 * Plugin URI:  https://github.com/chigozieorunta/wp-automate-likes
 * Description: A basic automation WordPress plugin for likes/smiles.
 * Version:     1.0.0
 * Author:      Chigozie Orunta
 * Author URI:  https://github.com/chigozieorunta
 * License:     MIT
 * Text Domain: wp-automate-likes
 * Domain Path: ./
 */

//Define Plugin Path
define("WPAUTOMATE", plugin_dir_url(__FILE__));

wpAutomateLikes::getInstance();

/**
 * Class wpAutomateLikes
 */
class wpAutomateLikes {
    
    /**
	 * Constructor
	 *
	 * @since  1.0.0
	 */
    public function __construct() {
		add_action("init", array(get_called_class(), 'registerShortCode'));
		add_action('automateHook', array(get_called_class(), 'registerAutomateSchedule'));
		add_action("admin_init", array(get_called_class(), 'registerAutomateFields'));
        add_action('admin_menu', array(get_called_class(), 'registerAutomateMenu'));
		add_action('wp_enqueue_scripts', array(get_called_class(), 'registerAutomateScripts'));
	}
 
	/**
	 * Register Automate Short Code
	 *
     * @access public
	 * @since  1.0.0
	 */

	public static function registerShortCode() {
		add_shortcode('automate_likes', array(get_called_class(), 'automateShortCode'));
		$firstDayInMonth = strtotime('first day of this month', strtotime("midnight", current_time('timestamp')));
        wp_schedule_single_event($firstDayInMonth, 'automateHook');
    }
    
    /**
	 * Initialize Automate Short Code
	 *
     * @access public
	 * @since  1.0.0
	 */

	public static function automateShortCode() {
	    ob_start();
	?>
	    <span style="<?= get_option(automate_styling); ?>"><?= get_option(automate_likes); ?></span>
	<?
    }
	
	/**
	 * Schedule Automate Likes/Smiles Increase every first day of the month...
	 *
     * @access public
	 * @since  1.0.0
	*/
    public static function registerAutomateSchedule() {
		$increment = get_option(automate_increment) ? get_option(automate_increment) : 0;
        $automate_likes = get_option(automate_likes) + $increment;
    	update_option('automate_likes', $automate_likes);
    }
    
    /**
	 * Register Automate Fields
	 *
     * @access public
	 * @since  1.0.0
	 */
	
	public static function registerAutomateFields() {
	    require_once('wp-automate-register-fields.php');
	}

	public static function admin_automate_likes() {
	    require_once('fields/automate-likes.php');
	}

	public static function admin_automate_increment() {
	    require_once('fields/automate-increment.php');
	}

	public static function admin_automate_styling() {
	    require_once('fields/automate-styling.php');
	}

	/**
	 * Register Menu Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerAutomateMenu() {
        add_menu_page(
            'AutomateLikes', 
            'Automate Likes', 
            'manage_options', 
            'AutomateLikes', 
            array(get_called_class(), 'registerAutomateAdmin')
        );
	} 
	
	/**
	 * Register Admin Method
	 *
     * @access public
	 * @since  1.0.0
	 */
    public static function registerAutomateAdmin() {
        require('wp-automate-register-html.php');	
	?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php
				    settings_fields("section");
				    do_settings_sections("automate-options");      
				    submit_button(); 
				?>          
			</form>
		</div>
	<?php
	}

    /**
	 * Register Scripts Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerScripts() {
		wp_register_style('automate-css', WPAUTOMATE.'css/automate.css');
		wp_enqueue_style('automate-css');
	}

    /**
	 * Points the class, singleton.
	 *
	 * @access public
	 * @since  1.0.0
	 */
    public static function getInstance() {
        static $instance;
        if($instance === null) $instance = new self();
        return $instance;
    }

}

?>
