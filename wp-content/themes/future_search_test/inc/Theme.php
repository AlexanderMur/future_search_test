<?php

namespace FS;

class Theme
{
    private static $_instance;

    /**
     * @var Likes
     */
    public $likes;
    
    /**
     * @var Installer
     */
    public $installer;

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action( 'init', [$this, 'menus'] );
        add_theme_support( 'post-thumbnails' );

        $this->likes = Likes::instance();
        $this->installer = Installer::instance();
    }
    
    function menus() {

        $locations = array(
            'primary'  => __( 'Primary Menu', 'fs' ),
        );

        register_nav_menus( $locations );
    }

    public function enqueue_scripts() {
        wp_enqueue_style('main', get_theme_file_uri('/assets/css/main.css'), array(), '1');
        wp_enqueue_style('style', get_theme_file_uri('/assets/css/style.css'), array(), '1');

        wp_enqueue_script('jquery');
        wp_enqueue_script('custom', get_theme_file_uri('/assets/js/custom.js'), 'jquery', '1', true);

        wp_localize_script('custom', 'settings', [
           'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    /**
     * @return \FS\Theme
     */
    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getAjax() {
        get_posts();
    }
}
