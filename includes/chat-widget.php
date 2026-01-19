<?php

class Alfies_Chat_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'alfies_chat';
    }
    
    public function get_title() {
        return 'Alfie\'s Chat';
    }
    
    protected function render() {
        echo '<div id="alfies-chat-container">
            <div id="chat-messages"></div>
            <input id="chat-input" type="text">
            <button id="chat-send">Send</button>
        </div>';
    }
}