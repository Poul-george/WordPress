<?php
/**
 * Welcart Item Functions
 *
 * Functions for product related.
 *
 * @package Welcart
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main function for returning products, uses the Welcart_Item class.
 *
 * @since 2.2.2
 *
 * @param mixed $the_item Post object or post ID of the item.
 * @return ItemData|null|false
 */
function wel_get_item( $the_item = false ) {
	$WelItem = new Welcart\ItemData( $the_item );
	return $WelItem->get_item();
}

/**
 * Function for returning products by item code.
 *
 * @since 2.2.2
 *
 * @param string $item_code Item code of the item.
 * @return ItemData|null|false
 */
function wel_get_item_by_code( $item_code ) {
	$WelItem = new Welcart\ItemData();
	$post_id = $WelItem->get_id_by_item_code( $item_code );
	$WelItem->set_data( $post_id );
	return $WelItem->get_item();
}

/**
 * The function for returning sku data, uses the Welcart_Item class.
 *
 * @since 2.2.2
 *
 * @param mixed  $the_item Post object or post ID of the item.
 * @param string $sku_code SKU code of the item.
 * @return ItemData|null|false
 */
function wel_get_sku( $the_item = false, $sku_code ) {
	$WelItem = new Welcart\ItemData( $the_item );
	return $WelItem->get_sku( $sku_code );
}

/**
 * Check if the item sku is out of stock.
 *
 * @since 2.2.2
 *
 * @param mixed  $the_item Post object or post ID of the item.
 * @param string $sku_code SKU code of the item.
 * @return boolean Return true if in stock, false otherwise.
 */
function wel_has_stock( $the_item, $sku_code ) {
	global $usces;

	$WelItem = new Welcart\ItemData( $the_item );
	$item    = $WelItem->get_item();
	$sku     = $WelItem->get_sku( $sku_code );
	$status  = (int) $sku['stock'];
	$stock   = $sku['stocknum'];
	$iOAp    = $item['itemOrderAcceptable'];

	if ( 1 !== $iOAp ) {

		if ( false !== $stock
			&& ( 0 < (int) $stock || WCUtils::is_blank( $stock ) )
			&& false !== $status
			&& 2 > $status
		) {
			$res = true;
		} else {
			$res = false;
		}
	} else {

		if ( false !== $status && 2 > $status ) {
			$res = true;
		} else {
			$res = false;
		}
	}

	return $res;
}
