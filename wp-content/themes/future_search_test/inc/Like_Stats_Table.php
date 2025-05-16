<?php
namespace FS;
/*include Wp_list_Class*/
if ( ! class_exists( '\WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/* Address_List_Table class that will display our custom table*/

class Like_Stats_Table extends \WP_List_Table {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( [
			'singular' => 'fslike',
			'plural'   => 'fslikes',
			'ajax'     => false
		] );
	}

	/* [Required] this is a default column renderer */
	protected function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'post_title':
                return $item->post_title;
			case 'likes':
                return likes()->get_likes($item->ID);
			case 'dislikes':
                return likes()->get_dislikes($item->ID);
                break;
		}
	}
    
	/* [REQUIRED] This method return columns to display in table */
	public function get_columns() {
		$columns = [
			'post_title'                => __( 'Post', 'fs' ),
			'likes'                  => __( 'Количество лайков', 'fs' ),
			'dislikes'            => __( 'Количество дизлайков', 'fs' ),
		];

		return $columns;
	}

	/* [OPTIONAL] Return array of bult actions if has any */
	public function get_bulk_actions() {
		$actions = [
		];

		return $actions;
	}
    

    /* this is very important function that prepare display for wp list table calling step by step function */
	public function prepare_items() {
		global $wpdb;
        $per_page = 10;
        $columns  = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();
        // here we configure table headers, defined in our methods
        $this->_column_headers = [ $columns, $hidden, $sortable ];
        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $this->get_pagenum(),
        ];
        $query = new \WP_Query($args);
        

        $this->items = $query->posts;
        $this->set_pagination_args([
            'total_items' => $query->found_posts,
            'per_page'    => $per_page,
            'total_pages' => $query->max_num_pages,
        ]);
	}
}
