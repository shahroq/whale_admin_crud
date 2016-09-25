<?php 
//print_r($_POST);
global $wpdb;
$errors = array();
$messages = array();
$table = $wpdb->prefix . "subscribers";

if ( isset( $_POST['Submit'] ) ) {

        $subscriber_id = isset( $_POST['subscriber_id'] ) ? intval( $_POST['subscriber_id'] ) : 0;
        $email = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
        $active = isset( $_POST['active'] ) ? sanitize_text_field( $_POST['active'] ) : 0;

        //validate:
        if(!is_email( $email )) $errors[] = __( 'Invalid Email', 'whale' );

        if(count($errors)==0){
            //insert or update
            if($subscriber_id==0){
                //insert
                $wpdb->insert(
                                $table, //table
                                array('email' => $email, 'active' => $active, 'date' => date('Y-m-d H:i:s') ) //data
                            );
                $messages[] = __( 'Successfully Added', 'whale' );
            }else{
                //update
                $wpdb->update(
                                $table, //table
                                array('email' => $email, 'active' => $active), //data
                                array('subscriber_id' => $subscriber_id) //where
                            );
                $messages[] = __( 'Successfully updated', 'whale' );
            }
        }
}    


//echo $id;
$page_title = __( 'Add New Subscriber', 'whale' );
$btn_label = __( 'Add', 'whale' );
$item = new stdClass();

if($id>0) {
    $page_title = __( 'Edit Subscriber', 'whale' );
    $btn_label = __( 'Update', 'whale' );
    $item = whale_get_record( $id );
}
//print_r($item);
?>

<div class="wrap">
    <h1><?php echo $page_title; ?></h1>
    
    <?php if(count($errors)>0){ ?>
    <div id="message" class="notice notice-error is-dismissible">
        <?php foreach ($errors as $value) echo "<p>".$value."</p>"; ?>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
    </div>
    <?php } ?>

    <?php if(count($messages)>0){ ?>
    <div id="message" class="notice notice-success is-dismissible">
        <?php foreach ($messages as $value) echo "<p>".$value."</p>"; ?>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
    </div>
    <?php } ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-email">
                    <th scope="row">
                        <label for="email"><?php _e( 'Email', 'whale' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" class="regular-text" placeholder="" value="<?php echo (isset($item->email)) ? esc_attr( $item->email ):''; ?>" />
                    </td>
                </tr>
                <tr class="row-active">
                    <th scope="row">
                        <?php _e( 'Active', 'whale' ); ?>
                    </th>
                    <td>
                        <?php
                        $active = isset($item->active)?$item->active:1;
                        ?>
                        <label for="active"><input type="checkbox" name="active" id="active" value="1" <?php checked( $active, 1 ); ?> /> <?php _e( '', 'whale' ); ?></label>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="subscriber_id" value="<?php echo (isset($item->subscriber_id)) ? $item->subscriber_id:0; ?>">

        <?php submit_button( $btn_label, 'primary', 'Submit' ); ?>

    </form>
</div>