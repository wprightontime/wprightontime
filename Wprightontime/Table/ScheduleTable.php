<?php

namespace Wprightontime\Table;

if (! defined('WPROT_ROOT')) {
    die("Can't touch this...");
}

class ScheduleTable extends BaseTable
{
    public function __construct()
    {
        global $status, $page;
        parent::__construct( array(
            'singular'  => __( 'schedule', 'wprightontime' ),
            'plural'    => __( 'schedules', 'wprightontime' ),
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
        echo '.wp-list-table .column-schedule { width: 40%; }';
        echo '.wp-list-table .column-due { width: 35%; }';
        echo '</style>';
    }

    public function no_items() {
        _e( 'No scheduled calls found, try to add a call first.', 'wprightontime' );
    }

    public function column_default( $item, $column_name )
    {
        switch( $column_name ) { 
            case 'schedule':
            case 'due':
                return $item[ $column_name ];
            default:
                return print_r( $item, true );
        }
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'schedule'  => array('schedule',false)
        );
        
        return $sortable_columns;
    }

    public function get_columns()
    {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'schedule'  => __( 'Next Calls', 'wprightontime' ),
            'due'       => __( 'Due in', 'wprightontime' )
        );

         return $columns;
    }

    public function prepareData()
    {
        foreach ($this->raw_data as $schedule) {
            $this->table_data[] = array(
                'schedule'  => $schedule->time,
                'due'       => $schedule->due
            );
        }

        return true;
    }
}