<div class="wrap">
    <h1><?php _e( 'Subscribers', 'whale' ); ?> <a href="<?php echo admin_url( 'admin.php?page=subscribers&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', 'whale' ); ?></a></h1>

    <form method="post">
        <!--
        <input type="hidden" name="page" value="list_table">
        -->
        <?php
        $list_table = new Subscribers_List_Table();
        $list_table->prepare_items();
        //$list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>
</div>