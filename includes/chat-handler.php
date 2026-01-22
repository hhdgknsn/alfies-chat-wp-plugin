<?php
/**
 * AJAX handler for chat messages
 */

class Chat_Handler {
    
    private $api;
    
    public function __construct() {
        $this->api = new Api_Handler();
        add_action('wp_ajax_chat_send', [$this, 'handle_message']);
        add_action('wp_ajax_nopriv_chat_send', [$this, 'handle_message']);
    }
    
    public function handle_message() {
        if (!check_ajax_referer('chat_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => 'Security check failed']);
            return;
        }
        
        $message = sanitize_text_field($_POST['message'] ?? '');
        $history_json = $_POST['history'] ?? '[]';
        $history = json_decode(stripslashes($history_json), true);
        
        if (empty($message)) {
            wp_send_json_error(['message' => 'Message cannot be empty']);
            return;
        }
        
        // Limit history to last 10 exchanges (20 messages)
        if (count($history) > 20) {
            $history = array_slice($history, -20);
        }
        
        // Call Claude API
        $result = $this->api->send_message($message, $history);
        
        if (isset($result['error'])) {
            wp_send_json_error(['message' => $result['error']]);
            return;
        }
        
        // Update conversation history
        $history[] = ['role' => 'user', 'content' => $message];
        $history[] = ['role' => 'assistant', 'content' => $result['message']];
        
        wp_send_json_success([
            'message' => $result['message'],
            'history' => $history,
            'usage' => $result['usage'] ?? []
        ]);
    }
}

new Chat_Handler();