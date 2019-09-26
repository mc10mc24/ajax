<?php

/* ADDING COLUMN TITLE */
add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column',11);
function custom_shop_order_column($columns)
{
	$new_columns = ( is_array( $columns ) ) ? $columns : array();
	$new_columns['get_product'] = __( 'Product');
   return $new_columns;
}

/* adding Kids details in order column */
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 10, 2 );
function custom_orders_list_column_content( $column ){
	global $post, $woocommerce, $the_order, $wpdb;
    $order_id = $the_order->id;
	$order = new WC_Order($order_id);
    $items = $order->get_items();

	foreach ($items as $item_id => $item) {
		$itemData = (array)$item;
		$dataItem = $itemData["\0*\0" . 'data'];
		$productName = $dataItem['name'];
		switch ( $column )
		{

			case 'get_product' :
					echo $productName;
				break;
			case 'get_hardbound' :
				$hardBound = $hardBoundCover[0]->order_item_name;
				if($productName == 'Superkid’s League Book'){
					if($hardBound == 'Hard bound cover'){
						echo '<a href="admin.php?page=hardboundcover&order_id='.$order_id.'" target="_blank"><div style="border:1px sold green; height:20px; width:30px;background-color:green;color:#fff; text-align:center;">Yes</div></a>';
					} else {
						echo '<a href="admin.php?page=hardboundcover&order_id='.$order_id.'" target="_blank"><div style="border:1px sold red; height:20px; width:30px;background-color:red;color:#fff; text-align:center;">No</div></a>';
					}
				}
				break;
			
			case 'shipping_address' :
				$billing_landmark = wc_get_order_item_meta( $item_id, 'billing_landmark', true );
				$billing_house_number = wc_get_order_item_meta( $item_id, 'billing_house_number', true );				
				$billing_street_address = wc_get_order_item_meta( $item_id, 'billing_street_address', true );				
				$columns[ 'shipping_address' ] =  $billing_house_number.$billing_street_address.$billing_landmark;
				break;
			case 'billing_address' :
				$billing_landmark = wc_get_order_item_meta( $item_id, 'billing_landmark', true );
				$billing_house_number = wc_get_order_item_meta( $item_id, 'billing_house_number', true );
				$billing_street_address = wc_get_order_item_meta( $item_id, 'billing_street_address', true );
				
				$columns[ 'billing_address' ] =  $billing_house_number.$billing_street_address.$billing_landmark;
				break;
		}
	}
	
}

?>