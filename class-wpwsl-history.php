<?php
class WPWSL_History{

    private $file_history_tpl='_history.php';
    private $file_charts_tpl='_charts.php';
	
	private static $_instance;

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
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    }

    /**
     * Add page
     */
    public function add_plugin_page(){
        // This page will be under Content manage section.
        $parent_slug=WPWSL_GENERAL_PAGE;
        $page_title=__('WeChat Subscribers', 'WPWSL');
        $menu_title=__('Statistics', 'WPWSL');
        $capability='edit_pages';
        $menu_slug=WPWSL_HISTORY_PAGE;
        add_submenu_page( 
        	$parent_slug,
        	$page_title,
        	$menu_title,
        	$capability,
        	$menu_slug,
        	array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page(){
        if(isset($_GET['charts'])){
           require_once($this->file_charts_tpl);
        }else{
		   require_once( $this->file_history_tpl);
        }
    }

}

?>