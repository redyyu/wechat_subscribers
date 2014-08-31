<?php
class WPWSL_General{
	
	
	private $file_general_tpl='_general.php';
	private $file_edit_tpl='_edit.php';

	
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
        $menu_title=__('Custom Replies', 'WPWSL');
        $capability='edit_pages';
        $menu_slug=WPWSL_GENERAL_PAGE;
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
    	if(isset($_GET['edit'])){
			require_once( $this->file_edit_tpl);
		}else{
			require_once( $this->file_general_tpl);
		}
    }

}

?>