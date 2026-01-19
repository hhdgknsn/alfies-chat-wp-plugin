<?php
/**
 * Plugin Name: Alfie's Deli Chat
 * Version: 1.0.0
 */

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/includes/api-handler.php';
require_once __DIR__ . '/includes/elementor-widget.php';

add_action('elementor/widgets/register', 'register_alfies_widget');

function register_alfies_widget() {
    require_once(__DIR__ . '/includes/elementor-widget.php');
    \Elementor\Plugin::instance()->widgets_manager->register(new Alfies_Chat_Widget());
}