<?php
class dataList
{
	var $table;			//テーブル名
	var $rows;			//データ
	var $action;		//アクション
	var $startRow;		//表示開始行番号
	var $maxRow;		//最大表示行数
	var $currentPage;	//現在のページNo
	var $firstPage;		//最初のページNo
	var $previousPage;	//前のページNo
	var $nextPage;		//次のページNo
	var $lastPage;		//最終ページNo
	var $naviMaxButton;	//ページネーション・ナビのボタンの数
	var $dataTableNavigation;	//ナヴィゲーションhtmlコード
	var $arr_period;	//表示データ期間
	var $arr_search;	//サーチ条件
	var $searchSql;		//簡易絞込みSQL
	var $searchSkuSql;	//SKU絞り込み
	var $searchSwitchStatus;	//サーチ表示スイッチ
	var $columns;		//データカラム
	var $sortColumn;	//現在ソート中のフィールド
	var $sortOldColumn;
	var $sortSwitchs;	//各フィールド毎の昇順降順スイッチ
	var $userHeaderNames;	//ユーザー指定のヘッダ名
	var $action_status, $action_message;
	var $pageLimit;		//ページ制限
	var $management_status;	//処理ステータス
	var $selectSql;
	var $joinTableSql;
	var $period_initial_index;
	var $period_specified_index;
	var $placeholder_escape;
    var $data_cookie;
    var $startdate;
    var $enddate;

	//Constructor
	function __construct($tableName, $arr_column)
	{
		$this->table = $tableName;
		$this->columns = $arr_column;
		$this->rows = array();

		$this->maxRow = apply_filters( 'usces_filter_orderlist_maxrow', 30 );
		$this->naviMaxButton = 11;
		$this->firstPage = 1;
		$this->action_status = 'none';
		$this->action_message = '';
		$this->pageLimit = 'on';
		$this->selectSql = '';
		$this->joinTableSql = '';

        $this->period_initial_index = apply_filters( 'usces_filter_order_list_arr_period_initial_index', 3, $this );
        $this->period_specified_index = apply_filters( 'usces_filter_order_list_arr_period_specified_index', 6, $this );

        $this->getCookie();
        $this->SetDefaultParam();
        $this->SetParamByQuery();
        $this->validationSearchParameters();

        $arr_period = array(__('This month', 'usces'), __('Last month', 'usces'), __('The past one week', 'usces'), __('Last 30 days', 'usces'), __('Last 90days', 'usces'), __('All', 'usces'), __('Period specified', 'usces'));
        $this->arr_period = apply_filters( 'usces_filter_order_list_arr_period', $arr_period, $this );


		$management_status = array(
			'duringorder' => __('temporaly out of stock', 'usces'),
			'cancel' => __('Cancel', 'usces'),
			'completion' => __('It has sent it out.', 'usces'),
			'estimate' => __('An estimate', 'usces'),
			'adminorder' => __('Management of Note', 'usces'),
			'continuation' => __('Continuation', 'usces'),
			'termination' => __('Termination', 'usces')
			);
		$this->management_status = apply_filters( 'usces_filter_management_status', $management_status, $this );

		$this->SetSelects();
		$this->SetJoinTables();
	}

	function SetSelects()
	{
		global $wpdb;

		$status_sql = '';
		foreach( $this->management_status as $status_key => $status_name ) {
			$status_sql .= $wpdb->prepare(" WHEN LOCATE(%s, order_status) > 0 THEN %s", $status_key, $status_name );
		}

		$select = array(
			"ID",
			"meta.meta_value AS `deco_id`",
			"DATE_FORMAT(order_date, '%Y-%m-%d %H:%i') AS `date`",
			"mem_id",
			"CONCAT(order_name1, ' ', order_name2) AS `name`",
			"order_pref AS `pref`",
			"order_delivery_method AS `delivery_method`",
			"(order_item_total_price - order_usedpoint + order_discount + order_shipping_charge + order_cod_fee + order_tax) AS `total_price`",
			"order_payment_name AS `payment_name`",
			"CASE WHEN LOCATE('noreceipt', order_status) > 0 THEN '".__('unpaid', 'usces')."' 
				 WHEN LOCATE('receipted', order_status) > 0 THEN '".__('payment confirmed', 'usces')."' 
				 WHEN LOCATE('pending', order_status) > 0 THEN '".__('Pending', 'usces')."' 
				 ELSE '&nbsp;' 
			END AS `receipt_status`",
			"CASE {$status_sql} 
				 ELSE '".__('new order', 'usces')."' 
			END AS `order_status`",
			"order_modified"
		);
		$this->selectSql = apply_filters( 'usces_filter_order_list_sql_select', $select, $status_sql, $this );
	}

	function SetJoinTables()
	{
		global $wpdb;
		$meta_table = $wpdb->prefix.'usces_order_meta';
		$ordercart_table = $wpdb->prefix.'usces_ordercart';
		$ordercartmeta_table = $wpdb->prefix.'usces_ordercart_meta';
		$join_table = array(
			" LEFT JOIN {$meta_table} AS `meta` ON ID = meta.order_id AND meta.meta_key = 'dec_order_id'"." \n",
			" LEFT JOIN {$ordercart_table} AS `cart` ON ID = cart.order_id"." \n"
		);
		$this->joinTableSql = apply_filters( 'usces_filter_order_list_sql_jointable', $join_table, $meta_table, $this );
	}

	function MakeTable()
	{
		$this->SetParam();
		switch ($this->action){

			case 'searchOut':
				$this->SearchOut();
				$res = $this->GetRows();
				break;

			case 'collective_order_reciept':
				check_admin_referer( 'order_list', 'wc_nonce' );
				usces_all_change_order_reciept($this);
				$res = $this->GetRows();
				break;

			case 'collective_order_status':
				check_admin_referer( 'order_list', 'wc_nonce' );
				usces_all_change_order_status($this);
				$res = $this->GetRows();
				break;

			case 'collective_delete':
				check_admin_referer( 'order_list', 'wc_nonce' );
				usces_all_delete_order_data($this);
				$this->SetTotalRow();
				$res = $this->GetRows();
				break;

            case 'searchIn':
            case 'refresh':
            case 'returnList':
            case 'changeSort':
            case 'changePage':
			default:
                $this->SearchIn();
				$res = $this->GetRows();
				break;
		}

		$this->SetNavi();
		$this->SetHeaders();

		if($res){

			return TRUE;

		}else{
			return FALSE;
		}
	}

	//DefaultParam
	function SetDefaultParam()
	{
        $this->startRow = isset($this->data_cookie['startRow']) ? $this->data_cookie['startRow'] : 0;
        $this->currentPage = isset($this->data_cookie['currentPage']) ? $this->data_cookie['currentPage'] : 1;
        $this->sortColumn = (isset($this->data_cookie['sortColumn'])) ? $this->data_cookie['sortColumn'] :'ID';
        $this->searchSwitchStatus = (isset($this->data_cookie['searchSwitchStatus'])) ? $this->data_cookie['searchSwitchStatus'] : 'OFF';
        $this->searchSql = (isset($this->data_cookie['searchSql'])) ? $this->data_cookie['searchSql'] : '';
        $this->searchSkuSql = (isset($this->data_cookie['searchSkuSql'])) ? $this->data_cookie['searchSkuSql'] : '';
        if (isset($this->data_cookie['arr_search'])) {
            $this->arr_search = $this->data_cookie['arr_search'];
        } else {
            $arr_search = array( 'period'=>$this->period_initial_index, 'column'=>'', 'word'=>'', 'sku'=>'', 'skuword'=>'' );
            $this->arr_search = apply_filters( 'usces_filter_order_list_arr_search', $arr_search, $this );
        }
        if (isset($this->data_cookie['sortSwitchs'])) {
            $this->sortSwitchs = $this->data_cookie['sortSwitchs'];
        } else {
            foreach($this->columns as $key => $value ){
                $this->sortSwitchs[$value] = 'DESC';
            }
        }
        $this->startdate = (isset($_REQUEST['startdate'])) ? $_REQUEST['startdate'] : ((isset($this->data_cookie['startdate'])) ? $this->data_cookie['startdate'] : '');
        $this->enddate = (isset($_REQUEST['enddate'])) ? $_REQUEST['enddate'] : ((isset($this->data_cookie['enddate'])) ? $this->data_cookie['enddate'] : '');
		$this->SetTotalRow();
	}

	function SetParam()
	{
		$this->startRow = ($this->currentPage-1) * $this->maxRow;
	}

	function SetParamByQuery()
	{
		global $wpdb;

		if(isset($_REQUEST['changePage'])){

			$this->action = 'changePage';
			$this->currentPage = (int)$_REQUEST['changePage'];
            $this->sortColumn = (isset($data_cookie['sortColumn'])) ? $this->data_cookie['sortColumn'] : $this->sortColumn;
            $this->sortSwitchs = (isset($this->data_cookie['sortSwitchs'])) ? $this->data_cookie['sortSwitchs'] : $this->sortSwitchs;
            $this->userHeaderNames = (isset($this->data_cookie['userHeaderNames'])) ? $this->data_cookie['userHeaderNames'] : $this->userHeaderNames;
            $this->searchSwitchStatus = (isset($this->data_cookie['searchSwitchStatus'])) ? $this->data_cookie['searchSwitchStatus'] : $this->searchSwitchStatus;
            $this->searchSql = (isset($this->data_cookie['searchSql'])) ? $this->data_cookie['searchSql'] : $this->searchSql;
            $this->searchSkuSql = (isset($this->data_cookie['searchSkuSql'])) ? $this->data_cookie['searchSkuSql'] : $this->searchSkuSql;
            $this->arr_search = (isset($this->data_cookie['arr_search'])) ? $this->data_cookie['arr_search'] : $this->arr_search;
            $this->totalRow = (isset($this->data_cookie['totalRow'])) ? $this->data_cookie['totalRow'] : $this->totalRow;
            $this->selectedRow = (isset($this->data_cookie['selectedRow'])) ? $this->data_cookie['selectedRow'] : $this->selectedRow;
            $this->placeholder_escape = (isset($this->data_cookie['placeholder_escape'])) ? $this->data_cookie['placeholder_escape'] : $this->placeholder_escape;

		}else if(isset($_REQUEST['changeSort'])){
			$this->action = 'changeSort';
			$this->sortOldColumn = $this->sortColumn;
			$this->sortColumn = str_replace('`', '', $_REQUEST['changeSort']);
            $this->sortSwitchs = (isset($this->data_cookie['sortSwitchs'])) ? $this->data_cookie['sortSwitchs'] : $this->sortSwitchs;
			$this->sortSwitchs[$this->sortColumn] = ('ASC' == $_REQUEST['switch']) ? 'ASC' : 'DESC';
            $this->currentPage = (isset($this->data_cookie['currentPage'])) ? $this->data_cookie['currentPage'] : $this->currentPage;
            $this->userHeaderNames = (isset($this->data_cookie['userHeaderNames'])) ? $this->data_cookie['userHeaderNames'] : $this->userHeaderNames;
            $this->searchSql = (isset($this->data_cookie['searchSql'])) ? $this->data_cookie['searchSql'] : $this->searchSql;
            $this->searchSkuSql = (isset($this->data_cookie['searchSkuSql'])) ? $this->data_cookie['searchSkuSql'] : $this->searchSkuSql;
            $this->arr_search = (isset($this->data_cookie['arr_search'])) ? $this->data_cookie['arr_search'] : $this->arr_search;
            $this->totalRow = (isset($this->data_cookie['totalRow'])) ? $this->data_cookie['totalRow'] : $this->totalRow;
            $this->selectedRow = (isset($this->data_cookie['selectedRow'])) ? $this->data_cookie['selectedRow'] : $this->selectedRow;
            $this->placeholder_escape = (isset($this->data_cookie['placeholder_escape'])) ? $this->data_cookie['placeholder_escape'] : $this->placeholder_escape;

		} else if(isset($_REQUEST['searchIn'])){

			$this->action = 'searchIn';
			$this->arr_search['column'] = isset($_REQUEST['search']['column']) ? str_replace('`', '', $_REQUEST['search']['column']) : '';
			$this->arr_search['sku'] = isset($_REQUEST['search']['sku']) ? $_REQUEST['search']['sku'] : '';
			$this->arr_search['word'] = isset($_REQUEST['search']['word']) ? $_REQUEST['search']['word'] : '';
			$this->arr_search['skuword'] = isset($_REQUEST['search']['skuword']) ? $_REQUEST['search']['skuword'] : '';
			$this->arr_search['period'] = isset($_REQUEST['search']['period']) ? (int)$_REQUEST['search']['period'] : $this->period_initial_index;
			$this->searchSwitchStatus = isset($_REQUEST['searchSwitchStatus']) ? $_REQUEST['searchSwitchStatus'] : '';
			$this->currentPage = 1;
            $this->sortColumn = (isset($this->data_cookie['sortColumn'])) ? $this->data_cookie['sortColumn'] : $this->sortColumn;
            $this->sortSwitchs = (isset($this->data_cookie['sortSwitchs'])) ? $this->data_cookie['sortSwitchs'] : $this->sortSwitchs;
            $this->userHeaderNames = (isset($this->data_cookie['userHeaderNames'])) ? $this->data_cookie['userHeaderNames'] : $this->userHeaderNames;
            $this->totalRow = (isset($this->data_cookie['totalRow'])) ? $this->data_cookie['totalRow'] : $this->totalRow;
			$this->placeholder_escape = $wpdb->placeholder_escape();



		}else if(isset($_REQUEST['searchOut'])){

			$this->action = 'searchOut';
			$this->arr_search['column'] = '';
			$this->arr_search['word'] = '';
			$this->arr_search['sku'] = '';
			$this->arr_search['skuword'] = '';
			$this->arr_search['period'] = (isset($this->data_cookie['arr_search']['period'])) ? $this->data_cookie['arr_search']['period'] : $this->arr_search['period'];
			$this->searchSwitchStatus = isset($_REQUEST['searchSwitchStatus']) ? str_replace(',', '', $_REQUEST['searchSwitchStatus']) : '';
			$this->currentPage = 1;
            $this->sortColumn = (isset($this->data_cookie['sortColumn'])) ? $this->data_cookie['sortColumn'] : $this->sortColumn;
            $this->sortSwitchs = (isset($this->data_cookie['sortSwitchs'])) ? $this->data_cookie['sortSwitchs'] : $this->sortSwitchs;
            $this->userHeaderNames = (isset($this->data_cookie['userHeaderNames'])) ? $this->data_cookie['userHeaderNames'] : $this->userHeaderNames;
            $this->totalRow = (isset($this->data_cookie['totalRow'])) ? $this->data_cookie['totalRow'] : $this->totalRow;
			$this->placeholder_escape = '';

		}else if(isset($_REQUEST['refresh'])){

			$this->action = 'refresh';
            $this->currentPage = (isset($this->data_cookie['currentPage'])) ? $this->data_cookie['currentPage'] : $this->currentPage;
            $this->sortColumn = (isset($this->data_cookie['sortColumn'])) ? $this->data_cookie['sortColumn'] : $this->sortColumn;
            $this->sortSwitchs = (isset($this->data_cookie['sortSwitchs'])) ? $this->data_cookie['sortSwitchs'] : $this->sortSwitchs;
            $this->userHeaderNames = (isset($this->data_cookie['userHeaderNames'])) ? $this->data_cookie['userHeaderNames'] : $this->userHeaderNames;
            $this->searchSwitchStatus = (isset($this->data_cookie['searchSwitchStatus'])) ? $this->data_cookie['searchSwitchStatus'] : $this->searchSwitchStatus;
            $this->searchSql = (isset($this->data_cookie['searchSql'])) ? $this->data_cookie['searchSql'] : $this->searchSql;
            $this->searchSkuSql = (isset($this->data_cookie['searchSkuSql'])) ? $this->data_cookie['searchSkuSql'] : $this->searchSkuSql;
            $this->arr_search = (isset($this->data_cookie['arr_search'])) ? $this->data_cookie['arr_search'] : $this->arr_search;
            $this->totalRow = (isset($this->data_cookie['totalRow'])) ? $this->data_cookie['totalRow'] : $this->totalRow;
            $this->selectedRow = (isset($this->data_cookie['selectedRow'])) ? $this->data_cookie['selectedRow'] : $this->selectedRow;
			$this->placeholder_escape = '';

		}else if(isset($_REQUEST['collective'])){

			$this->action = 'collective_' . str_replace(',', '', $_POST['allchange']['column']);
            $this->currentPage = (isset($this->data_cookie['currentPage'])) ? $this->data_cookie['currentPage'] : $this->currentPage;
            $this->sortColumn = (isset($this->data_cookie['sortColumn'])) ? $this->data_cookie['sortColumn'] : $this->sortColumn;
            $this->sortSwitchs = (isset($this->data_cookie['sortSwitchs'])) ? $this->data_cookie['sortSwitchs'] : $this->sortSwitchs;
            $this->userHeaderNames = (isset($this->data_cookie['userHeaderNames'])) ? $this->data_cookie['userHeaderNames'] : $this->userHeaderNames;
            $this->searchSwitchStatus = (isset($this->data_cookie['searchSwitchStatus'])) ? $this->data_cookie['searchSwitchStatus'] : $this->searchSwitchStatus;
            $this->searchSql = (isset($this->data_cookie['searchSql'])) ? $this->data_cookie['searchSql'] : $this->searchSql;
            $this->searchSkuSql = (isset($this->data_cookie['searchSkuSql'])) ? $this->data_cookie['searchSkuSql'] : $this->searchSkuSql;
            $this->arr_search = (isset($this->data_cookie['arr_search'])) ? $this->data_cookie['arr_search'] : $this->arr_search;
            $this->totalRow = (isset($this->data_cookie['totalRow'])) ? $this->data_cookie['totalRow'] : $this->totalRow;
            $this->selectedRow = (isset($this->data_cookie['selectedRow'])) ? $this->data_cookie['selectedRow'] : $this->selectedRow;
            $this->placeholder_escape = (isset($this->data_cookie['placeholder_escape'])) ? $this->data_cookie['placeholder_escape'] : $this->placeholder_escape;

		}else{

			$this->action = 'default';
			$this->placeholder_escape = '';
		}
	}

    function validationSearchParameters(){
        $default_sku_columns = ['item_code', 'item_name'];
        if('none' != $this->arr_search['column'] && !in_array($this->arr_search['column'], $this->columns)){
            if(is_array($this->arr_search['word']) && count($this->arr_search['word']) && in_array($key = key($this->arr_search['word']),$this->columns)){
                $this->arr_search['column'] = $key;
            }
            else{
                $this->arr_search['column'] = 'none';
            }
        }
        if('none' != $this->arr_search['sku'] && !in_array($this->arr_search['sku'], $default_sku_columns)){

            if(is_array($this->arr_search['skuword']) && count($this->arr_search['skuword']) && in_array($key = key($this->arr_search['skuword']),$default_sku_columns)){

                $this->arr_search['sku'] = $key;
            }
            else{
                $this->arr_search['sku'] = 'none';
            }
        }
    }

	//GetRows
	function GetRows()
	{
		global $wpdb;
		$where = $this->GetWhere();
		$order = ' ORDER BY `' . esc_sql($this->sortColumn) . '` ' . esc_sql($this->sortSwitchs[$this->sortColumn]);
		$order = apply_filters( 'usces_filter_order_list_get_orderby', $order, $this );

		$select = '';
		foreach( $this->selectSql as $value ) {
			$select .= $value.", ";
		}
		$select = rtrim( $select, ", " );
		$select .= ", item_name, item_code";
		$query = apply_filters( 'usces_filter_order_list_select', $select, $this);
		$join_table = '';
		foreach( $this->joinTableSql as $value ) {
			$join_table .= $value;
		}
		$query = "SELECT ".$select." \n"."FROM {$this->table} "."\n".$join_table.$where."\n".$order;
		$query = apply_filters( 'usces_filter_order_list_get_rows', $query, $this);
		$wpdb->show_errors();

		if( $this->placeholder_escape ){
			add_filter( 'query', array( $this, 'remove_ph') );
		}

		$rows = $wpdb->get_results($query, ARRAY_A);
		$this->selectedRow = ( $rows && is_array( $rows ) ) ? count( $rows ) : 0;
		if($this->pageLimit == 'off') {
			$this->rows = (array)$rows;
		} else {
			$this->rows = array_slice((array)$rows, $this->startRow, $this->maxRow);
		}

		return $this->rows;
	}

	public function remove_ph( $query ) {
		return str_replace( $this->placeholder_escape, '%', $query );
	}

	function SetTotalRow()
	{
		global $wpdb;
		$where = '';
		if( $this->period_specified_index == $this->arr_search['period'] ) {
			if( isset($_REQUEST['startdate']) ) {
				$startdate = $_REQUEST['startdate'];
			}
//			elseif( isset($this->data_cookie['startdate']) and ( isset($_GET['changePage']) or isset($_GET['changeSort']) or isset($_REQUEST['searchIn']) ) ) {
//				$startdate = $this->data_cookie['startdate'];
//			}
			else {
                $startdate = $this->data_cookie['startdate'];
			}

			if( isset($_REQUEST['enddate']) ) {
				$enddate = $_REQUEST['enddate'];
			}
//			elseif( isset($this->data_cookie['enddate']) and ( isset($_GET['changePage']) or isset($_GET['changeSort']) or isset($_REQUEST['searchIn']) ) ) {
//				$enddate = $this->data_cookie['enddate'];
//			}
			else {
                $enddate = $this->data_cookie['enddate'];
			}
			if( '' != $startdate or '' != $enddate ) {
				if( '' == $enddate ) {
					$where = " WHERE order_date >= '{$startdate}'";
				} elseif( '' == $startdate ) {
					$where = " WHERE order_date <= '{$enddate}'";
				} elseif( $startdate == $enddate ) {
					$where = " WHERE order_date BETWEEN '{$startdate} 00:00:00' AND '{$startdate} 23:59:59'";
				} else {
					$where = " WHERE order_date >= '{$startdate}' AND order_date <= '{$enddate}'";
				}
			}
		}
		$query = "SELECT COUNT(ID) AS `ct` FROM {$this->table}".apply_filters( 'usces_filter_order_list_sql_where', $where, $this );
		$query = apply_filters( 'usces_filter_order_list_set_total_row', $query, $this);
		$res = $wpdb->get_var($query);
		$this->totalRow = $res;
	}

	function GetWhere()
	{
		global $wpdb;
		$str = '';
		$where = "";
		if( $this->period_specified_index == $this->arr_search['period'] ) {
            if( isset($_REQUEST['startdate']) ) {
                $startdate = $_REQUEST['startdate'];
            }
//			elseif( isset($this->data_cookie['startdate']) and ( isset($_GET['changePage']) or isset($_GET['changeSort']) or isset($_REQUEST['searchIn']) ) ) {
//				$startdate = $this->data_cookie['startdate'];
//			}
            else {
                $startdate = $this->data_cookie['startdate'];
            }

            if( isset($_REQUEST['enddate']) ) {
                $enddate = $_REQUEST['enddate'];
            }
//			elseif( isset($this->data_cookie['enddate']) and ( isset($_GET['changePage']) or isset($_GET['changeSort']) or isset($_REQUEST['searchIn']) ) ) {
//				$enddate = $this->data_cookie['enddate'];
//			}
            else {
                $enddate = $this->data_cookie['enddate'];
            }
			if( '' != $startdate or '' != $enddate ) {
				if( '' == $enddate ) {
					$where = " WHERE order_date >= '{$startdate}'";
				} elseif( '' == $startdate ) {
					$where = " WHERE order_date <= '{$enddate}'";
				} elseif( $startdate == $enddate ) {
					$where = " WHERE order_date BETWEEN '{$startdate} 00:00:00' AND '{$startdate} 23:59:59'";
				} else {
					$where = " WHERE order_date >= '{$startdate}' AND order_date <= '{$enddate}'";
				}
			}
		} else {
			$thismonth = date('Y-m-01 00:00:00');
			$lastmonth = date('Y-m-01 00:00:00', mktime(0, 0, 0, date('m')-1, 1, date('Y')));
			$lastweek = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m'), date('d')-7, date('Y')));
			$last30 = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m'), date('d')-30, date('Y')));
			$last90 = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m'), date('d')-90, date('Y')));
			switch ( $this->arr_search['period'] ) {
				case 0:
					$where = $wpdb->prepare(" WHERE order_date >= %s ", $thismonth );
					break;
				case 1:
					$where = $wpdb->prepare(" WHERE order_date >= %s AND order_date < %s ", $lastmonth, $thismonth );
					break;
				case 2:
					$where = $wpdb->prepare(" WHERE order_date >= %s ", $lastweek );
					break;
				case 3:
					$where = $wpdb->prepare(" WHERE order_date >= %s ", $last30 );
					break;
				case 4:
					$where = $wpdb->prepare(" WHERE order_date >= %s ", $last90 );
					break;
				case 5:
					$where = "";
					break;
			}
		}
		if( !WCUtils::is_blank($where) ){
			if( !WCUtils::is_blank($this->searchSkuSql) ){
				$where .= ' AND ' . $this->searchSkuSql;
			}
		}else{
			if( !WCUtils::is_blank($this->searchSkuSql) ){
				$where = ' WHERE ' . $this->searchSkuSql;
			}
		}
		$str = apply_filters( 'usces_filter_order_list_sql_where', $where, $this );

		$str .= " \n" . " GROUP BY `ID` ";

		$having = '';
		if( !WCUtils::is_blank($this->searchSql) ){
			$having = ' HAVING ' . $this->searchSql;
		}
		$having = apply_filters( 'usces_filter_order_list_sql_having', $having, $this );

		if( !WCUtils::is_blank($having) ){
			$str .= $having;
		}

		return apply_filters( 'usces_filter_order_list_get_where', $str, $this );
	}

	function SearchIn()
	{
		global $wpdb;
		switch ($this->arr_search['column']) {
			case 'ID':
				$column = 'ID';
				$this->searchSql = $wpdb->prepare('`' . $column . '` = %d', $this->arr_search['word']['ID']);
				break;
			case 'deco_id':
				$column = 'deco_id';
				$this->searchSql = $wpdb->prepare('`' . $column . '` LIKE %s', "%" . $this->arr_search['word']['deco_id'] . "%");
				break;
			case 'date':
				$column = 'date';
				$this->searchSql = $wpdb->prepare('`' . $column . '` LIKE %s', "%" . $this->arr_search['word']['date'] . "%");
				break;
			case 'mem_id':
				$column = 'mem_id';
				$this->searchSql = $wpdb->prepare('`' . $column . '` = %d', $this->arr_search['word']['mem_id']);
				break;
			case 'name':
				$column = 'name';
				$this->searchSql = $wpdb->prepare('`' . $column . '` LIKE %s', "%" . $this->arr_search['word']['name'] . "%");
				break;
			case 'order_modified':
				$column = 'order_modified';
				$this->searchSql = $wpdb->prepare('`' . $column . '` LIKE %s', "%" . $this->arr_search['word']['order_modified'] . "%");
				break;
			case 'pref':
				$column = 'pref';
				$this->searchSql = $wpdb->prepare('`' . $column . "` = %s", $this->arr_search['word']['pref']);
				break;
			case 'delivery_method':
				$column = 'delivery_method';
				$this->searchSql = $wpdb->prepare('`' . $column . "` = %s", $this->arr_search['word']['delivery_method']);
				break;
			case 'payment_name':
				$column = 'payment_name';
				$this->searchSql = $wpdb->prepare('`' . $column . "` = %s", $this->arr_search['word']['payment_name']);
				break;
			case 'receipt_status':
				$column = 'receipt_status';
				$this->searchSql = $wpdb->prepare('`' . $column . "` = %s", $this->arr_search['word']['receipt_status']);
				break;
			case 'order_status':
				$column = 'order_status';
				$this->searchSql = $wpdb->prepare('`' . $column . "` = %s", $this->arr_search['word']['order_status']);
				break;
		}
		switch ($this->arr_search['sku']) {
			case 'item_code':
				$column = 'item_code';
				$this->searchSkuSql = $wpdb->prepare('`' . $column . '` LIKE %s', "%" . $this->arr_search['skuword']['item_code'] . "%");
				break;
			case 'item_name':
				$column = 'item_name';
				$this->searchSkuSql = $wpdb->prepare('`' . $column . '` LIKE %s', "%" . $this->arr_search['skuword']['item_name'] . "%");
				break;
		}
	}

	function SearchOut()
	{
		$this->searchSql = '';
		$this->searchSkuSql = '';
	}

	function SetNavi()
	{
		$this->lastPage = ceil($this->selectedRow / $this->maxRow);
		$this->previousPage = ($this->currentPage - 1 == 0) ? 1 : $this->currentPage - 1;
		$this->nextPage = ($this->currentPage + 1 > $this->lastPage) ? $this->lastPage : $this->currentPage + 1;
		$box = array();

		for($i=0; $i<$this->naviMaxButton; $i++){
			if($i > $this->lastPage-1) break;
			if($this->lastPage <= $this->naviMaxButton) {
				$box[] = $i+1;
			}else{
				if($this->currentPage <= 6) {
					$label = $i + 1;
					$box[] = $label;
				}else{
					$label = $i + 1 + $this->currentPage - 6;
					$box[] = $label;
					if($label == $this->lastPage) break;
				}
			}
		}

		$html = '';
		$html .= '<ul class="clearfix">'."\n";
		$html .= '<li class="rowsnum">' . $this->selectedRow . ' / ' . $this->totalRow . ' ' . __('cases', 'usces') . '</li>' . "\n";
		if(($this->currentPage == 1) || ($this->selectedRow == 0)){
			$html .= '<li class="navigationStr">first&lt;&lt;</li>' . "\n";
			$html .= '<li class="navigationStr">prev&lt;</li>'."\n";
		}else{
			$html .= '<li class="navigationStr"><a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&changePage=1">first&lt;&lt;</a></li>' . "\n";
			$html .= '<li class="navigationStr"><a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&changePage=' . $this->previousPage . '">prev&lt;</a></li>'."\n";
		}
		if($this->selectedRow > 0) {
			$box_count = count( $box );
			for($i=0; $i<$box_count; $i++){
				if($box[$i] == $this->currentPage){
					$html .= '<li class="navigationButtonSelected">' . $box[$i] . '</li>'."\n";
				}else{
					$html .= '<li class="navigationButton"><a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&changePage=' . $box[$i] . '">' . $box[$i] . '</a></li>'."\n";
				}
			}
		}
		if(($this->currentPage == $this->lastPage) || ($this->selectedRow == 0)){
			$html .= '<li class="navigationStr">&gt;next</li>'."\n";
			$html .= '<li class="navigationStr">&gt;&gt;last</li>'."\n";
		}else{
			$html .= '<li class="navigationStr"><a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&changePage=' . $this->nextPage . '">&gt;next</a></li>'."\n";
			$html .= '<li class="navigationStr"><a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&changePage=' . $this->lastPage . '">&gt;&gt;last</a></li>'."\n";
		}
		if($this->searchSwitchStatus == 'OFF'){
			$html .= '<li class="rowsnum"><a style="cursor:pointer;" id="searchVisiLink">' . __('Show the Operation field', 'usces') . '</a>'."\n";
		}else{
			$html .= '<li class="rowsnum"><a style="cursor:pointer;" id="searchVisiLink">' . __('Hide the Operation field', 'usces') . '</a>'."\n";
		}

		$html .= '<li class="refresh"><a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&refresh">' . __('updates it to latest information', 'usces') . '</a></li>' . "\n";
		$html .= '</ul>'."\n";

		$this->dataTableNavigation = $html;
	}


    function getCookie(){
        $this->data_cookie = (isset($_COOKIE[$this->table])) ? json_decode(str_replace("\'","'",str_replace('\"','"', $_COOKIE[$this->table])),true) : [];
    }

	function SetHeaders()
	{
		foreach ($this->columns as $key => $value){
			if($value == $this->sortColumn){
				if($this->sortSwitchs[$value] == 'ASC'){
					$str = __('[ASC]', 'usces');
					$switch = 'DESC';
				}else{
					$str = __('[DESC]', 'usces');
					$switch = 'ASC';
				}
				$this->headers[$value] = '<a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&changeSort=' . $value . '&switch=' . $switch . '"><span class="sortcolumn">' . $key . ' ' . $str . '</span></a>';
			}else{
				$switch = $this->sortSwitchs[$value];
				$this->headers[$value] = '<a href="' . site_url() . '/wp-admin/admin.php?page=usces_orderlist&changeSort=' . $value . '&switch=' . $switch . '"><span>' . $key . '</span></a>';
			}
		}
	}

	function GetSearchs()
	{
		return $this->arr_search;
	}

	function GetListheaders()
	{
		return $this->headers;
	}

	function GetDataTableNavigation()
	{
		return $this->dataTableNavigation;
	}

	function set_action_status($status, $message)
	{
		$this->action_status = $status;
		$this->action_message = $message;
	}

	function get_action_status()
	{
		return $this->action_status;
	}

	function get_action_message()
	{
		return $this->action_message;
	}

	function get_period_specified_index()
	{
		return $this->period_specified_index;
	}
}