document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('chat-toggle');
    const widget = document.getElementById('chat-widget');
    const close = document.getElementById('chat-close');
    const sendBtn = document.getElementById('chat-send');
    const input = document.getElementById('chat-input');
    const messagesContainer = document.getElementById('chat-messages');
    
    let conversationHistory = [];
    
    toggle?.addEventListener('click', () => widget.classList.add('active'));
    close?.addEventListener('click', () => widget.classList.remove('active'));
    
    sendBtn?.addEventListener('click', sendMessage);
    
    input?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
    
    function sendMessage() {
        const message = input.value.trim();
        if (!message) return;
        
        addMessage(message, 'user');
        input.value = '';
        
        const typingId = showTyping();
        
        fetch(chat.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'chat_send',
                nonce: chat.nonce,
                message: message,
                history: JSON.stringify(conversationHistory)
            })
        })
        .then(response => response.json())
        .then(data => {
            removeTyping(typingId);
            
            if (data.success) {
                addMessage(data.data.message, 'assistant');
                conversationHistory = data.data.history || [];
            } else {
                addMessage('Sorry, something went wrong. Please try again.', 'error');
            }
        })
        .catch(error => {
            removeTyping(typingId);
            addMessage('Connection error. Please check your internet.', 'error');
            console.error('Chat error:', error);
        });
    }
    
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message chat-message-${sender}`;
        messageDiv.textContent = text;
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    function showTyping() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'chat-typing';
        typingDiv.innerHTML = '<span></span><span></span><span></span>';
        const id = 'typing-' + Date.now();
        typingDiv.id = id;
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        return id;
    }
    
    function removeTyping(id) {
        document.getElementById(id)?.remove();
    }
});