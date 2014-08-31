<?php
class WPWSL_Settings{
	
	private $page_slug=WPWSL_SETTINGS_PAGE;
	private $capability='edit_pages';
	
	private $option_group='wpwsl_settings_option_group';
	private $option_name=WPWSL_SETTINGS_OPTION;
	
	private $file_settings_tpl='_settings.php';

	private static $_instance;
	
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
     
    public static function get_instance(){
	    if(!isset(self::$_instance)){
	    	$c=__CLASS__;
	    	self::$_instance=new $c;
	    }
	    return self::$_instance;
    }
    
    public function __clone(){
    	trigger_error('Clone is not allow' ,E_USER_ERROR);
    }
    
    private function __construct(){
    	
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ));
       	//add_action( 'admin_init', array( $this, 'page_init' ), 999 );
    }

    /**
     * Add options page
     */
    public function add_plugin_page(){
        // This page will be under "Settings"
        $page_title=__('WeChat Subscribers Settings', 'WPWSL');
        $menu_title=__('WeChat Subscribers Settings', 'WPWSL');
        $capability='manage_options';
        $menu_slug=WPWSL_SETTINGS_PAGE;
        
        add_options_page(
        	$page_title,
        	$menu_title,
        	$capability,
        	$menu_slug,
        	array( $this, 'create_admin_page' )
        );
        
        $this->page_init();
    }

    /**
     * Options page callback
     */
    public function create_admin_page(){
        // Set class property
        $this->options = get_option( $this->option_name );
		require_once( $this->file_settings_tpl );
    }

    /**
     * Register and add settings
     */
    public function page_init(){        
        register_setting(
            $this->option_group, // Option group
            $this->option_name, // Option name
            array( $this, 'sanitize' ) // Sanitize
        ); 
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ){
        $new_input = array();

        foreach($input as $key=>$obj){        	
        	if(isset( $input[$key])){
        		if($key=='token'){
        			$obj=trim($obj);
        			$obj=str_replace( ' ', '',$obj);
        			$obj = preg_replace('/[^A-Za-z0-9\-_]/','',$obj);
        		}
        	    $new_input[$key] = sanitize_text_field( $obj );
        	}
        }
        return $new_input;
    }
}

?>