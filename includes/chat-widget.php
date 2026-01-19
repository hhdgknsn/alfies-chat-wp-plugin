<?php

class Alfies_Chat_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'alfies_chat';
    }
    
    public function get_title() {
        return 'Alfie\'s Chat';
    }

    public function get_style_depends() {
        return ['alfies-chat-widget'];
    }
    
    protected function render() {
        ?>
        <button class="alfies-chat-toggle" id="chat-toggle">💬</button>
        <div class="alfies-chat-widget" id="chat-widget">
            <div class="chat-header">
                <h3>Chat with Alfie's Deli</h3>
                <button class="chat-close" id="chat-close">×</button>
            </div>
            <div id="chat-messages" class="chat-messages"></div>
            <div class="chat-input-area">
                <input id="chat-input" type="text" placeholder="Type your message...">
                <button id="chat-send" class="send-btn">Send</button>
            </div>
        </div>
        <?php
    }
}