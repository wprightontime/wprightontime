<?php

namespace Wprightontime\Table;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

class JobTable extends BaseTable
{
    public function __construct()
    {
        global $status, $page;
        
        parent::__construct( array(
            'singular'  => __( 'call', 'wprightontime' ),
            'plural'    => __( 'calls', 'wprightontime' ),
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
        echo '.wp-list-table .column-calltime { width: 70%; }';
        echo '.wp-list-table .column-status { width: 25%; }';
        echo '</style>';
    }

    public function no_items() {
        _e( 'Sorry, no calls found. Please add a new call.', 'wprightontime' );
    }

    public function column_default( $item, $column_name )
    {
        switch( $column_name ) { 
            case 'calltime':
            case 'status':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }

    public function get_columns()
    {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'calltime'  => __( 'Call Time', 'wprightontime' ),
            'status'    => __( 'Status', 'wprightontime' )
        );
         return $columns;
    }

    public function column_calltime($item)
    {
        $actions = array(
                    'edit'      => sprintf('<a href="?page=%s&tab=%s&jobupdt=%s">Edit</a>',$_REQUEST['page'],'calls',$item['ID']),
                    'delete'    => sprintf('<a href="admin-post.php?action=call_form&page=%s&api_action=%s&endpoint=%s&val=%s">Delete</a>',$_REQUEST['page'],'delete', 'jobs', $item['ID']),
                );
        return sprintf('%1$s %2$s', $item['calltime'], $this->row_actions($actions) );
    }

    public function prepareData()
    {
        foreach ($this->raw_data as $job) {
            $this->table_data[] = [
                'ID'        => $job->id,
                'calltime'  => $job->string,
                'status'    => $this->getCallStatus()
            ];
        }
        return true;
    }

    private function getCallStatus()
    {
        // return $this->raw_data['plan'] == false ? esc_html__('Inactive', 'wprightontime') : esc_html__('Active', 'wprightontime');
    }
    
}