<?php
/**
 * Plugin Name: Alfie's Deli Chat
 * Version: 1.0.0
 */

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/includes/api-handler.php';

function alfies_enqueue_assets() {
    wp_enqueue_style('alfies-chat-widget', plugin_dir_url(__FILE__) . 'assets/css/chat-widget.css');
    wp_enqueue_script('alfies-chat-toggle', plugin_dir_url(__FILE__) . 'assets/js/chat-toggle.js', [], '1.0', true);
}
add_action('wp_enqueue_scripts', 'alfies_enqueue_assets');

function register_alfies_widget() {
    require_once __DIR__ . '/includes/chat-widget.php';
    \Elementor\Plugin::instance()->widgets_manager->register(new Alfies_Chat_Widget());
}
add_action('elementor/widgets/register', 'register_alfies_widget');