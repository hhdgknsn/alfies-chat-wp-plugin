<?php
class Api_Handler {
    
    private $api_key;
    private $api_url = 'https://api.anthropic.com/v1/messages';
    
    public function __construct() {
        $this->api_key = $_ENV['ANTHROPIC_API_KEY'] ?? '';
    }
    
    public function send_message($user_message, $conversation_history = []) {

        $messages = $conversation_history;
        $messages[] = [
            'role' => 'user',
            'content' => $user_message
        ];
        
        $body = [
            'model' => 'claude-sonnet-4-20250514',
            'max_tokens' => 1024,
            'system' => $this->get_master_prompt(),
            'messages' => $messages
        ];
        
        $response = wp_remote_post($this->api_url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-api-key' => $this->api_key,
                'anthropic-version' => '2023-06-01'
            ],
            'body' => json_encode($body),
            'timeout' => 30
        ]);
        
        if (is_wp_error($response)) {
            return ['error' => $response->get_error_message()];
        }
        
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (!isset($body['content'][0]['text'])) {
            $error_msg = $body['error']['message'] ?? json_encode($body);
            error_log('CHAT API ERROR: ' . $error_msg);
            return ['error' => $error_msg];
        }
        
        if (isset($body['content'][0]['text'])) {
            return [
                'success' => true,
                'message' => $body['content'][0]['text'],
                'usage' => $body['usage'] ?? []
            ];
        }
        
        return ['error' => $body['error']['message'] ?? 'Unknown error'];
    }
    
    private function get_master_prompt() {
        return file_get_contents(plugin_dir_path(__FILE__) . 'prompt-config.php');
    }
}