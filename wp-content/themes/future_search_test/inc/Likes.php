<?php


namespace FS;


use WP_Query;

class Likes
{

    private static $_instance;

    public function __construct()
    {

        add_action('wp_ajax_nopriv_post_like', [$this, 'handle_post_like']);
        add_action('wp_ajax_post_like', [$this, 'handle_post_like']);


        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    public function admin_menu() {
        add_menu_page(  __( 'Статистика Лайков', 'fs' ), __( 'Статистика Лайков', 'fs' ), 'edit_posts', 'like-stats', [
            $this,
            'like_stats_page_handler'
        ] );
    }
    
    public function like_stats_page_handler() {
        include( get_template_directory() . '/templates/like-stats-template.php' );
    }
    
    public function get_likes($post_id) {
        global $wpdb;
        $post_and = " AND post_id = " . esc_sql($post_id);
        $table_name = $wpdb->prefix . "fs_likes";
        $likes = +$wpdb->get_var( "SELECT COUNT(*) FROM " . $table_name .  " WHERE is_like = 1 " . $post_and );
        if ($likes === NULL) {
            return 0;
        }
        return $likes;
    }
    
    public function get_dislikes($post_id) {
        global $wpdb;
        $post_and = " AND post_id = " . esc_sql($post_id);
        $table_name = $wpdb->prefix . "fs_likes";
        $dislikes = +$wpdb->get_var( "SELECT COUNT(*) FROM " . $table_name . " WHERE is_like = 0 " . $post_and );
        if ($dislikes === NULL) {
            return 0;
        }
        return $dislikes;
    }
    
    public function get_rating($post_id) {
        return $this->get_likes($post_id) - $this->get_dislikes($post_id);
    }
    public function is_user_liked($post_id, $ip = null)
    {
        global $wpdb;
        if ($ip === null) {
            $ip = get_ip_address();
        }
        $post_and = " AND post_id = " . esc_sql($post_id);
        $ip_and = " AND ip = \"" . esc_sql($ip) . "\"";
        $table_name = $wpdb->prefix . "fs_likes";
        $likes = $wpdb->get_var( "SELECT COUNT(*) FROM " . $table_name .  " WHERE is_like = 1 " . $post_and . $ip_and );
        if ($likes > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function is_user_disliked($post_id, $ip = null)
    {
        global $wpdb;
        if ($ip === null) {
            $ip = get_ip_address();
        }
        $post_and = " AND post_id = " . esc_sql($post_id);
        $ip_and = " AND ip = \"" . esc_sql($ip)."\"";
        $table_name = $wpdb->prefix . "fs_likes";
        $dislikes = $wpdb->get_var( "SELECT COUNT(*) FROM " . $table_name .  " WHERE is_like = 0 " . $post_and . $ip_and );
        if ($dislikes > 0) {
            return true;
        }else{
            return false;
        }
    }
    
    public function delete_user_vote($post_id, $ip) {
        global $wpdb;
        $table_name = $wpdb->prefix . "fs_likes";
        $result = $wpdb->delete(  $table_name, [
            'ip' => $ip,
            'post_id' => $post_id,
        ] );
        return $result;
    }
    
    public function like_post($post_id, $ip, $url) {
        
        global $wpdb;
        if ($this->is_user_disliked($post_id, $ip)) {
            $this->delete_user_vote($post_id, $ip);
        }
        if (!$this->is_user_liked($post_id, $ip)) {
            $table_name  = $wpdb->prefix . 'fs_likes';
            $wpdb->insert( $table_name, [
                'post_id' => $post_id,
                'is_like' => 1,
                'ip'      => $ip,
                'url'     => $url,
                'date' => date("Y-m-d H:i:s"),
            ]);
        }
        
    } 
    
    public function dislike_post($post_id, $ip, $url) {
        global $wpdb;

        if ($this->is_user_liked($post_id, $ip)) {
            $this->delete_user_vote($post_id, $ip);
        }
        if (!$this->is_user_disliked($post_id, $ip)) {
            $table_name = $wpdb->prefix . 'fs_likes';
            $wpdb->insert($table_name, [
                'post_id' => $post_id,
                'is_like' => 0,
                'ip'      => $ip,
                'url'     => $url,
                'date'    => date("Y-m-d H:i:s"),
            ]);
        }
    } 
    
    public function handle_post_like()
    {
        $post_id = $_POST['post_id'];
        $event_type = $_POST['event_type'];
        $url = wp_get_referer();

        $ip_address = get_ip_address();
        
        switch ($event_type) {
            case 'like':
                $this->like_post($post_id, $ip_address, $url);
                break;
            case 'delete_vote':
                $this->delete_user_vote($post_id, $ip_address);
                break;
            case 'dislike':
                $this->dislike_post($post_id, $ip_address, $url);
                break;
        }

        
        wp_send_json([
            'items' => '',
        ]);
    }


    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
