<?php
/* -------------------------------------------- *
 * Class Definition								*
 * -------------------------------------------- */
 
//This part is our very own WP_List_Table

class WPWSL_History_Table extends WP_List_Table {

	private $rawData = array();
	    
	public function __construct($data){
		global $status, $page;
		$this->rawData=$data;
	    parent::__construct( array(
	        'singular'  => 'tpl',     //singular name of the listed records
	        'plural'    => 'tpls',   //plural name of the listed records
	        'ajax'      => false        //does this table support ajax?
			) );
	
	}
	
	public function no_items() {
		_e( 'No records','WPWSL');
	}
	

	
	public function get_columns(){
	    $columns = array(
					'cb'        => '<input type="checkbox" />',
					'openid' => __( 'open ID' ),
					'keyword'  => __( 'Keyword','WPWSL' ),
					'is_match'  => __( 'Match', 'WPWSL' ),
					'time'  => __( 'Date', 'WPWSL' )
					);
	    return $columns;
	}
	
	public function column_default( $item, $column_name ) {
		switch( $column_name ) { 
		    case 'openid':
		    case 'keyword':
		    case 'is_match':
		    case 'time':
		        return $item[ $column_name ];
		    default:
		        return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
		}
	}

	public function column_cb($item) {
	    return sprintf(
	        '<input type="checkbox" name="record[]" value="%s" />', $item['ID']
	    );    
	}
	public function get_bulk_actions() {
		$actions = array(
			'delete'    => __('Delete','WPWSL')
		);
		return $actions;
	}
	
	public function get_sortable_columns() {
		$sortable_columns = array(
							'openid'  => array('openid',false),
							'keyword' => array('keyword',false),
							'is_match' => array('is_match',false),
							'time' => array('time',false)
							);
		return $sortable_columns;
	}
	public function prepare_items() {
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( 
									   $this->get_columns(),		// columns
									   array(),			// hidden
									   $sortable
									);
		global $wpdb;
		$db_table=DB_TABLE_WPWSL_HISTORY;
		$total = $wpdb->get_results("select count(id) as total from $db_table");
		$this->set_pagination_args( array(
				'total_items' => $total[0]->total,                  //WE have to calculate the total number of items
				'per_page'    => SELECT_ROWS_AMOUNT                    //WE have to determine how many items to show on a page
				));
		$this->items  = $this->rawData;
	}
}
 
?>