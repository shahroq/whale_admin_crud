<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class Contacts_List_Table extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'Contact', //Singular label
            'plural'   => 'Contacts', //plural label, also this well be one of the table css class
            'ajax'     => false //We won't support Ajax for this table
        ) );
    }

    /**
     * Retrieve items data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */    
    public static function get_items( $per_page = 5, $page_number = 1 ) {

    	global $wpdb;

    	$sql = "SELECT * FROM {$wpdb->prefix}contacts";

    	if ( ! empty( $_REQUEST['orderby'] ) ) {
        	$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
          	$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }else{
        	$sql .= ' ORDER BY contact_id DESC ';
        }

      	$sql .= " LIMIT $per_page";
      	$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

      	$result = $wpdb->get_results( $sql, 'ARRAY_A' ); //print_r($result);
      	return $result;
    }

    /**
     * Delete a item.
     *
     * @param int $id contact_id
     */
    public static function delete_item( $id ) {
    	global $wpdb;

    	$wpdb->delete(
        	"{$wpdb->prefix}contacts",
          	[ 'contact_id' => $id ],
          	[ '%d' ]
        );
    }

    /**
     * Returns the count of items in the database.
     *
     * @return null|string
     */
    public static function item_count() {
    	global $wpdb;

    	$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}contacts";

    	return $wpdb->get_var( $sql );
    }

    /**
     * Render a column when no column specific method exists.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
    	switch ( $column_name ) {
            case 'name':
                return $item[ $column_name ];
            case 'email':
                return $item[ $column_name ];
            case 'message':
                return $item[ $column_name ];
        	case 'date':
            	return $item[ $column_name ];
          	default:
            	return print_r( $item, true ); //Show the whole array for troubleshooting purposes
      	}
    }

    /**
     * Method for first column which contains edit/delete 
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_email( $item ) {

    	//Build row actions
        $actions = array(
         	'delete'    => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>',$_REQUEST['page'],'delete',$item['contact_id']),
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(ID:%2$s)</span>%3$s',
            /*$1%s*/ $item['email'],
            /*$2%s*/ $item['contact_id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
    	return sprintf(
        	'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['contact_id']
      	);
    }

    /**
     * Render perisan date (remove 0 when wp-parsidate installed)
     */
    function column_subscribe_date0( $item ) {
        global $wpp_settings;
        $format = 'Y-m-d H:i:s';
        if ( $wpp_settings['conv_dates'] == 'disable' )
            return parsidate( $format, $item['date'], 'eng' );
        else
            return parsidate( $format, $item['date'] );
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
    	$columns = [
        	'cb' => '<input type="checkbox" />',
        	'email' => __( 'Email', 'whale' ),
            'name' => __( 'Name', 'whale' ),
            'message' => __( 'Message', 'whale' ),
        	'date' => __( 'Date', 'whale' ),
        ];

    	return $columns;
    }

    public function get_sortable_columns() {
      	$sortable_columns = array(
        	'email' => array( 'email', true ),
            'name' => array( 'name', true ),
        	'date' => array( 'subscribe_date', true )
      	);
		return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
    	$actions = [
        	'bulk-delete' => 'Delete',
        ];
    	return $actions;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

    	$columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );


    	/** Process bulk action */
    	$this->process_bulk_action();

    	$per_page     = $this->get_items_per_page( 'items_per_page', 5 );
    	$current_page = $this->get_pagenum();
    	$total_items  = self::items_count();

    	$this->items = self::get_items( $per_page, $current_page );

    	$this->set_pagination_args( [
        	'total_items' => $total_items, //WE have to calculate the total number of items
        	'per_page'    => $per_page //WE have to determine how many items to show on a page
        ] );
    }

    public function process_bulk_action() {

    	//Detect when a bulk action is being triggered...
        if ( $this->current_action() === 'delete' ) {
        	self::delete_item( absint( $_GET['id'] ) );
        	wp_redirect( esc_url( add_query_arg() ) );
        	exit;
    	}
      
        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' ) ) {
  
        	$delete_ids = esc_sql( $_POST['bulk-delete'] );

        	// loop over the array of item IDs and delete them
        	foreach ( $delete_ids as $id ) {
            	self::delete_item( $id );
          	}

        	wp_redirect( esc_url( add_query_arg() ) );
        	exit;
        }
    }

}