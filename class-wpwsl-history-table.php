<?php
error_log('Debug class history table: memory usage: ' . memory_get_peak_usage());

/* -------------------------------------------- *
 * Class Definition								*
 * -------------------------------------------- */

//This part is our very own WP_List_Table

class WPWSL_History_Table extends WP_List_Table
{

    private $rawData = [];

    public function __construct($data)
    {
        global $status, $page;
        $this->rawData = $data;
        parent::__construct([
            'singular' => 'tpl', //singular name of the listed records
            'plural' => 'tpls', //plural name of the listed records
            'ajax' => false //does this table support ajax?
        ]);
    }

    public function no_items()
    {
        _e('No records', 'WPWSL');
    }

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox" />',
            'openid' => __('open ID'),
            'keyword' => __('Keyword', 'WPWSL'),
            'is_match' => __('Match', 'WPWSL'),
            'time' => __('Date', 'WPWSL')
        ];
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name)
        {
            case 'openid':
            case 'keyword':
            case 'is_match':
            case 'time':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="record[]" value="%s" />', $item['ID']
        );
    }

    public function get_bulk_actions()
    {
        return [
            'delete' => __('Delete', 'WPWSL')
        ];
    }

    public function get_sortable_columns()
    {
        return [
            'openid' => [
                'openid',
                false],
            'keyword' => [
                'keyword',
                false],
            'is_match' => [
                'is_match',
                false],
            'time' => [
                'time',
                false]
        ];
    }

    public function prepare_items()
    {
        $this->_column_headers = [
            $this->get_columns(), // columns
            [], // hidden
            $this->get_sortable_columns()
        ];
        global $wpdb;
        $db_table = DB_TABLE_WPWSL_HISTORY;
        $total = $wpdb->get_results("select count(id) as total from $db_table");
        $this->set_pagination_args([
            'total_items' => $total[0]->total, //We have to calculate the total number of items
            'per_page' => SELECT_ROWS_AMOUNT //We have to determine how many items to show on a page
        ]);
        $this->items = $this->rawData;
    }

}
