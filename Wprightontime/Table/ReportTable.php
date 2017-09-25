<?php

namespace Wprightontime\Table;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

class ReportTable extends BaseTable
{
    public function __construct()
    {
        global $status, $page;
        parent::__construct( array(
            'singular'  => __( 'report', 'wprightontime' ),
            'plural'    => __( 'reports', 'wprightontime' ),
            'ajax'      => false
        ) );
        add_action( 'admin_head', array( $this, 'columnHeader' ) );            
    }

    public function columnHeader()
    {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
        if( 'wprightontime' != $page )
        return;
        echo '<style type="text/css">';
        echo '.wp-list-table .column-id { width: 5%; }';
        echo '.wp-list-table .column-calldate { width: 40%; }';
        echo '.wp-list-table .column-httpcode { width: 35%; }';
        echo '.wp-list-table .column-status { width: 20%;}';
        echo '</style>';
    }

    public function no_items() {
        _e( 'No reports found.', 'wprightontime' );
    }

    public function column_default( $item, $column_name )
    {
        switch( $column_name ) { 
            case 'calldate':
            case 'httpcode':
            case 'status':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'calldate'  => array('calldate',false)
        );
        return $sortable_columns;
    }

    public function get_columns()
    {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'calldate'  => __( 'Call date/time', 'wprightontime' ),
            'httpcode'  => __( 'Http status code (*)', 'wprightontime' ),
            'status'    => __( 'Status', 'wprightontime' )
        );
         return $columns;
    }

    public function prepareData()
    {
        foreach ($this->raw_data as $report) {
            $this->table_data[] = array(
                'calldate'  => $report->timestamp,
                'httpcode'  => $report->http_code,
                'status'    => $report->status
            );
        }
        return true;
    }
}