<?php
/**
 * Plugin Name: Alfie's Chat Widget
 * Description: AI-powered chat widget for Alfie's Deli
 * Version: 1.0
 * Author: Holly
 */

// Security check
if (!defined('ABSPATH')) exit;

// Load required files
require_once plugin_dir_path(__FILE__) . 'includes/api-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/chat-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/chat-widget.php';

class Alfies_Chat_Plugin {
    
    // Register hooks on plugin initialization
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/widgets/register', [$this, 'register_widget']);
    }
    
    // Enqueue CSS and JS files
    public function enqueue_scripts() {
        // Enqueue CSS
        wp_enqueue_style(
            'alfies-chat-widget',
            plugin_dir_url(__FILE__) . 'assets/css/chat-widget.css',
            [],
            '1.0'
        );
        
        // Enqueue JS
        wp_enqueue_script(
            'alfies-chat-toggle',
            plugin_dir_url(__FILE__) . 'assets/js/chat-toggle.js',
            ['jquery'],
            '1.0',
            true
        );
        
        // Localize script with AJAX URL and nonce
        wp_localize_script('alfies-chat-toggle', 'alfiesChat', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('alfies_chat_nonce')
        ]);
    }
    
    // Register Elementor widget
    public function register_widget($widgets_manager) {
        $widgets_manager->register(new Alfies_Chat_Widget());
    }
}

// Initialize plugin 
new Alfies_Chat_Plugin();