<?php


namespace FS;


use WP_Query;

class Installer
{

    private static $_instance;

    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'create_table']);
    }
    
    public function create_table() {
        $theme = wp_get_theme();

        if ( $theme->name == 'Future Search' ) {

            global $wpdb;

            $table_name = $wpdb->prefix . 'fs_likes';
            
            $row = $wpdb->get_results( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_name = '" . $table_name . "'" );

            if ( empty( $row ) ) {
                $sql = "CREATE TABLE " . $table_name . " (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  post_id int(11) NOT NULL,
                  is_like BOOL NOT NULL,
                  url LONGTEXT NOT NULL,
                  ip VARCHAR(100) NOT NULL,
                  date TIMESTAMP NOT NULL,
                  PRIMARY KEY (id)
                );";
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            }

        }
    }
    
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
