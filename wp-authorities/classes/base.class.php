<?php
if( !class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Base_Table extends WP_List_Table{

	var $data = array();
	
	function __construct(){
		global $status, $page;
		parent::__construct(
			array(
				'singular'  => __( 'WP Authority', 'supt' ),		//singular name of the listed records
				'plural'    => __( 'WP Authorities', 'supt' ),		//plural name of the listed records
				'ajax'      => false								//does this table support ajax?
			)
		);
	}
	
	function set_data($data){
		$this->data = $data;
	}
	
	function column_cb( $item ){
		?><label class="screen-reader-text" for="cb-select-32">Select <?php echo $item['name']; ?></label>
		<input id="cb-select-<?php echo $item['name']; ?>" type="checkbox" name="cpt[]" value="<?php echo $item['name']; ?>">
		<div class="locked-indicator"></div><?php
	}
	
	function column_default( $item, $column_name ) {
		switch( $column_name ){
			case 'name':
				return __('name with link');
			
			case 'rating':
				return __($item[1]);
			
			default:
				return print_r( $item, true ) ; // Show the whole array for troubleshooting purposes
		}
	}
	
	function get_columns(){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'name' => __( 'Name', 'supt' ),
			'rating' => __( 'Rating', 'supt' )
		);
		return $columns;
	}
	
	function get_sortable_columns() {
		$sortable_columns = array(
			'name' => array('name',false),
			'rating' => array('rating',false)
		);
		return $sortable_columns;
	}
	
	function usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'name';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
	}
	
	function column_name( $item ) {
		$name = sprintf('<strong><a href="http://'. $item[0] .'" target="_blank">'. $item[0] .'</a></strong>');
		$actions = array(
			'edit'		=> sprintf(''),
			'delete'	=> sprintf(''),
			'inline-code hide-if-no-js' => sprintf('')
		);
		$inline = sprintf('');
		return sprintf('%1$s %2$s %3$s', $name, $this->row_actions($actions), $inline );
	}
	
	function get_bulk_actions(){
		$actions = array(
			'delete'    => 'Delete'
		);
		return $actions;
	}
	
	function no_items() {
		_e( 'No Item found, dude.' );
	}
	
	function prepare_items() {
		// Columns
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		// $this->_column_headers = array( $columns, $hidden, $sortable );
		$this->_column_headers = $this->get_column_info();
		
		// Sort Items
		$items = $this->data;
		
		if( !empty( $items ) ){
			usort( $items, array( &$this, 'usort_reorder' ) );
		} else {
			$items = array();
		}
		
		// Pagination
		$per_page = $this->get_items_per_page('site_per_page', 10);;
		$current_page = $this->get_pagenum();
		$total_items = count($items);
		
		// only ncessary because we have sample data
		$this->found_data = array_slice($items,(($current_page-1)*$per_page),$per_page);
		
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,	//WE have to calculate the total number of items
				'per_page'    => $per_page		//WE have to determine how many items to show on a page
			)
		);
		
		$this->items = $this->found_data;
	}
}