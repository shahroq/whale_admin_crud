<?php

/**
 * Admin Menu
 */
class Forms_Admin_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page( 
                        __( 'Forms', 'whale' ), 
                        __( 'Forms', 'whale' ), 
                        'manage_options', 
                        'forms', 
                        array( $this, 'plugin_page' ), 
                        'dashicons-groups', 
                        null 
                    );
        /** Sub Menu **/
        add_submenu_page( 
                        'forms', 
                        __( 'Subscribers', 'whale' ), 
                        __( 'Subscribers', 'whale' ), 
                        'manage_options', 
                        'subscribers', 
                        array( $this, 'plugin_page' ) 
                    );
        add_submenu_page( 
                        'forms', 
                        __( 'Contacts', 'whale' ), 
                        __( 'Contacts', 'whale' ), 
                        'manage_options', 
                        'contacts', 
                        array( $this, 'plugin_page' ) 
                    );
        remove_submenu_page('forms', 'forms');

    }


    /**
     * Handles the plugin pages
     */
    public function plugin_page() {
        $page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        if($page=='subscribers'){

                // subscribers
                include dirname(__FILE__) . '/subscribers/class-list-table.php';
                include dirname(__FILE__) . '/subscribers/functions.php';

                switch ($action) {
                    case 'new':
                        $template = dirname( __FILE__ ) . '/subscribers/views/form.php';
                        break;
                    case 'edit':
                        $template = dirname( __FILE__ ) . '/subscribers/views/form.php';
                        break;
                    default:
                        $template = dirname( __FILE__ ) . '/subscribers/views/list.php';
                        break;
                } 

        }
        if($page=='contacts'){

                // contacts
                include dirname(__FILE__) . '/contacts/class-list-table.php';
                include dirname(__FILE__) . '/contacts/functions.php';

                switch ($action) {
                    case 'new':
                        $template = dirname( __FILE__ ) . '/contacts/views/form.php';
                        break;
                    case 'edit':
                        $template = dirname( __FILE__ ) . '/contacts/views/form.php';
                        break;
                    default:
                        $template = dirname( __FILE__ ) . '/contacts/views/list.php';
                        break;
                } 
            
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}