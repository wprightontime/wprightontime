<?php

namespace Wprightontime\Table;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

use WP_List_Table;

class BaseTable extends WP_List_Table
{
    public $table_data = [];

    public $raw_data;

    public function prepare_items()
    {
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );
        if (! empty($this->raw_data)) {
            $this->prepareData();
        
            $per_page = 20;
            $current_page = $this->get_pagenum();
            $total_items = count( $this->table_data );

            $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page'    => $per_page
            ) );
            $this->items = array_slice( $this->table_data,( ( $current_page-1 )* $per_page ), $per_page );
        }
    }

    public function get_bulk_actions()
    {
        $actions = array();
        return $actions;
    }
}