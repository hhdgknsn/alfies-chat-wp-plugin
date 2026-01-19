document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('chat-toggle');
    const widget = document.getElementById('chat-widget');
    const close = document.getElementById('chat-close');
    
    toggle?.addEventListener('click', () => widget.classList.add('active'));
    close?.addEventListener('click', () => widget.classList.remove('active'));
});