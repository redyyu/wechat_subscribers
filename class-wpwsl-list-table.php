<?php
/* -------------------------------------------- *
 * Class Definition								*
 * -------------------------------------------- */
 
//This part is our very own WP_List_Table

class WPWSL_List_Table extends WP_List_Table {

	private $rawData = array();
	private $found_data = array();
  
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
		_e( 'No Item found.','WPWSL');
	}
	
	public function column_default( $item, $column_name ) {
		switch( $column_name ) { 
		    case 'title':
		    case 'type':
		    case 'date':
		    case 'trigger_by':
		        return $item[ $column_name ];
		    default:
		        return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
		}
	}
	
	public function get_sortable_columns() {
		$sortable_columns = array(
							'title'  => array('title',false),
							'type' => array('type',false),
							'date' => array('date',false),
							'trigger_by' => array('trigger_by',false)
							);
		return $sortable_columns;
	}
	
	public function get_columns(){
	    $columns = array(
					'cb'        => '<input type="checkbox" />',
					'title' => __( 'Title', 'WPWSL' ),
					'type'  => __( 'Type', 'WPWSL' ),
					'date'  => __( 'Date', 'WPWSL' ),
					'trigger_by'  => __( 'Trigger by', 'WPWSL' ),
					);
	    return $columns;
	}
	
	public function usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'ID';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'desc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
	}
	
	public function column_title($item){
		$actions = array(
		        'edit'      => sprintf('<a href="'.menu_page_url(WPWSL_GENERAL_PAGE, false).'&edit=%s">'.__('Edit','WPWSL').'</a>',$item['ID']),
		        'delete'    => sprintf('<a href="'.menu_page_url(WPWSL_GENERAL_PAGE, false).'&delete=%s">'.__('Delete','WPWSL').'</a>',$item['ID']),
		    );
		
		return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
	}
	
	public function get_bulk_actions() {
		$actions = array(
			'delete'    => __('Delete','WPWSL')
		);
		return $actions;
	}
	
//	public function process_bulk_action() {
//		
//	    if ( 'delete' === $this->current_action() ) {
//	    	if(isset($_GET['tpl'])){
//		        foreach($_GET['tpl'] as $tpl){
//		        	foreach($this->rawData as $key=>$dt){
//		        		if($dt['ID']==$tpl){
//		        			unset($this->rawData[$key]);
//		        		}
//		        	}
//		        	
//		        }
//	        }
//	    }
//	}
	
	public function column_cb($item) {
	    return sprintf(
	        '<input type="checkbox" name="tpl[]" value="%s" />', $item['ID']
	    );    
	}
	
	public function extra_tablenav( $which ) {
		if ( $which == "top" ){
			//The code that goes before the table is here
			//echo 'top';
		}
		if ( $which == "bottom" ){
			//The code that goes after the table is there
			//echo 'bottom';
		}
	}	

	
	public function prepare_items() {
		//$this->process_bulk_action();
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		usort( $this->rawData, array( &$this, 'usort_reorder' ) );
		$per_page = 10;
		$current_page = $this->get_pagenum();

		$total_items = count( $this->rawData );
		
		// only ncessary because we have sample data
    $current_page_idx = ( $current_page-1 ) * $per_page;
		$this->found_data = array_slice($this->rawData, 
                                    $current_page_idx,
                                    $per_page );
    
		$this->set_pagination_args( array(
				'total_items' => $total_items, 
        //WE have to calculate the total number of items
				'per_page'    => $per_page 
        //WE have to determine how many items to show on a page
		));
		$this->items = $this->found_data;
    
	}
}
 
?>