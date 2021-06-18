<?php
/**
 * Welcart item base class
 *
 * @package  Welcart
 */

namespace Welcart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Item class
 *
 * The Welcart item class handles individual product data.
 *
 * @since 2.2.2
 */
class ItemData {

	/**
	 * ID for this object.
	 *
	 * @since 2.2.2
	 * @var int
	 */
	protected $id = 0;

	/**
	 * Core data for this object. Name value pairs (name + default value).
	 *
	 * @since 2.2.2
	 * @var array
	 */
	protected $data = array(
		'itemCode'               => '',
		'itemName'               => '',
		'itemRestriction'        => null,
		'itemPointrate'          => 0,
		'itemGpNum1'             => 0,
		'itemGpNum2'             => 0,
		'itemGpNum3'             => 0,
		'itemGpDis1'             => 0,
		'itemGpDis2'             => 0,
		'itemGpDis3'             => 0,
		'itemOrderAcceptable'    => 0,
		'itemShipping'           => 0,
		'itemDeliveryMethod'     => array(),
		'itemShippingCharge'     => 0,
		'itemIndividualSCharge'  => 0,
		'atobarai_propriety'     => 0,
		'itemOption'             => array(),
		'itemSKU'                => array(),
		'item_charging_type'     => 0,
		'item_division'          => 'shipped',
		'dlseller_date'          => '',
		'dlseller_file'          => '',
		'dlseller_interval'      => '',
		'dlseller_validity'      => '',
		'dlseller_version'       => '',
		'dlseller_author'        => '',
		'item_chargingday'       => '',
		'item_frequency'         => '',
		'wcad_regular_unit'      => '',
		'wcad_regular_interval'  => '',
		'wcad_regular_frequency' => '',
		'select_sku_switch'      => 0,
		'select_sku_display'     => 0,
		'select_sku'             => array(),
	);

	/**
	 * Extra data for this object. Name value pairs (name + default value).
	 *
	 * @since 2.2.2
	 * @var array
	 */
	protected $extra_data = array();

	/**
	 * Get the item if ID is passed, otherwise the item is empty.
	 * This class should not be instantiated.
	 * The wc_get_item() function should be used instead.
	 *
	 * @param mixed $the_item Post object or post ID of the item.
	 */
	public function __construct( $the_item = 0 ) {
		if ( is_numeric( $the_item ) && $the_item > 0 ) {
			$this->set_id( $the_item );
		} elseif ( ! empty( $the_item->ID ) ) {
			$this->set_id( absint( $the_item->ID ) );
		} else {
			$this->set_id( 0 );
		}

		$this->set_data( $this->id );
	}

	/**
	 * Set ID.
	 *
	 * @param int $id ID.
	 */
	public function set_id( $id ) {
		$this->id = absint( $id );
	}

	/**
	 * Set data.
	 *
	 * @since  2.2.2
	 * @param int $post_id post ID of the Item.
	 */
	public function set_data( $post_id ) {

		if ( 0 === $post_id ) {
			return false;
		}

		$post_data = get_post( $post_id, ARRAY_A );
		if ( null === $post_data ) {
			return false;
		}

		$_meta = get_post_meta( $post_id );

		foreach ( $_meta as $key => $arr ) {

			$value_arr    = array();
			$value        = '';
			$meta_num     = count( $arr );
			$reserved_key = ltrim( $key, '_' );

			if ( 1 === $meta_num ) {

				$value = maybe_unserialize( $arr[0] );
				if ( '_iopt_' === $key ) {
					$temp['itemOption'][0] = $value;
				} elseif ( '_isku_' === $key ) {
					$temp['itemSKU'][0] = $value;
				} elseif ( array_key_exists( $reserved_key, $this->data ) ) {
					$temp[ $reserved_key ] = $value;
				} else {
					$this->extra_data[ $key ] = $value;
				}
			} else {

				foreach ( $arr as $ind => $v ) {
					$value_arr[] = maybe_unserialize( $v );
				}
				if ( '_iopt_' === $key ) {
					$temp['itemOption'] = $value_arr;
				} elseif ( '_isku_' === $key ) {
					$temp['itemSKU'] = $value_arr;
				} elseif ( array_key_exists( $reserved_key, $this->data ) ) {
					$temp[ $reserved_key ] = $value_arr;
				} else {
					$this->extra_data = $value_arr;
				}
			}
		}
		$item_data  = $temp;
		$this->data = array_merge( $post_data, $this->data, $item_data, $this->extra_data );
	}

	/**
	 * Returns all data for this object.
	 *
	 * @since  2.2.2
	 * @return array
	 */
	public function get_item() {
		if ( ! isset( $this->data['ID'] ) ) {
			return false;
		} else {
			return array_merge( $this->data, $this->extra_data );
		}
	}

	/**
	 * Returns all sku data for this object.
	 *
	 * @since  2.2.2
	 * @param string $keyflag Regenerate skus with sku value as skus index.
	 * @return array
	 */
	public function get_skus( $keyflag = 'sort' ) {

		$isku = $this->data['itemSKU'];
		$skus = array();

		foreach ( $isku as $sku ) {
			$key = isset( $sku[ $keyflag ] ) ? $sku[ $keyflag ] : $sku['sort'];

			$skus[ $key ] = $sku;
		}
		$skus = apply_filters( 'wel_get_skus', $skus, $this->data, $keyflag );
		ksort( $skus );
		return $skus;
	}

	/**
	 * Returns sku data by sku code.
	 *
	 * @since  2.2.2
	 * @param string $sku_code Sku code to get.
	 * @return array
	 */
	public function get_sku( $sku_code ) {
		$skus = $this->get_skus( 'code' );
		$sku  = isset( $skus[ $sku_code ] ) ? $skus[ $sku_code ] : false;
		return $sku;
	}

	/**
	 * Returns post ID by item code.
	 *
	 * @since  2.2.2
	 * @param string $item_code Item code to get post ID.
	 * @return int Post ID.
	 */
	public function get_id_by_item_code( $item_code ) {
		global $wpdb;

		$cache_key = 'wel_post_id_by_code_' . $item_code;

		$id = wp_cache_get( $cache_key );
		if ( false === $id ) {
			$id    = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT `post_id` FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s",
					'_itemCode',
					$item_code
				)
			);
			if ( null !== $id ) {
				wp_cache_set( $cache_key, $id );
			}
		}

		if ( null === $id ) {
			return false;
		} else {
			return $id;
		}
	}
}
