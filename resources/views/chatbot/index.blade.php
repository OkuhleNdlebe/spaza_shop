@extends('layouts.app')

@section('title', 'AI Chatbot Assistant')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-robot" style="font-size: 1.5rem;"></i>
                            <strong class="ms-2">AI Customer Assistant</strong>
                        </div>
                        <form action="{{ route('chatbot.clear') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light">
                                <i class="bi bi-trash"></i> Clear Chat
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="card-body" style="height: 500px; overflow-y: auto;" id="chatMessages">
                    <div class="text-center text-muted" id="welcomeMessage">
                        <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                        <p class="mt-2">Hello! I'm your AI assistant. Ask me about:</p>
                        <ul class="list-unstyled">
                            <li>📦 Products and stock</li>
                            <li>🏪 Store locations</li>
                            <li>💰 Pricing information</li>
                            <li>📊 Sales inquiries</li>
                        </ul>
                    </div>
                </div>
                
                <div class="card-footer">
                    <form id="chatForm" class="d-flex gap-2">
                        @csrf
                        <input type="text" 
                               id="messageInput" 
                               class="form-control" 
                               placeholder="Type your message here..." 
                               autocomplete="off"
                               required>
                        <button type="submit" class="btn btn-primary" id="sendBtn">
                            <i class="bi bi-send"></i> Send
                        </button>
                    </form>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> 
                            Powered by AI - I can answer questions about products, stores, and services
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .message {
        margin-bottom: 15px;
        display: flex;
        animation: fadeIn 0.3s ease-in;
    }
    
    .user-message {
        justify-content: flex-end;
    }
    
    .bot-message {
        justify-content: flex-start;
    }
    
    .message-bubble {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 18px;
        word-wrap: break-word;
    }
    
    .user-message .message-bubble {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .bot-message .message-bubble {
        background: #f1f3f5;
        color: #333;
        border-bottom-left-radius: 4px;
    }
    
    .message-time {
        font-size: 0.7rem;
        margin-top: 5px;
        color: #6c757d;
    }
    
    .typing-indicator {
        display: flex;
        padding: 10px;
        background: #f1f3f5;
        border-radius: 18px;
        width: fit-content;
    }
    
    .typing-indicator span {
        height: 8px;
        width: 8px;
        background: #6c757d;
        border-radius: 50%;
        display: inline-block;
        margin: 0 2px;
        animation: typing 1.4s infinite ease-in-out;
    }
    
    .typing-indicator span:nth-child(1) { animation-delay: 0s; }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
        30% { transform: translateY(-10px); opacity: 1; }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@section('scripts')
<script>
let isTyping = false;

document.getElementById('chatForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message || isTyping) return;
    
    // Clear welcome message if exists
    const welcomeMsg = document.getElementById('welcomeMessage');
    if (welcomeMsg) welcomeMsg.remove();
    
    // Display user message
    displayMessage(message, 'user');
    
    // Clear input
    input.value = '';
    
    // Show typing indicator
    showTypingIndicator();
    isTyping = true;
    
    try {
        const response = await fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });
        
        const data = await response.json();
        
        // Remove typing indicator
        removeTypingIndicator();
        
        if (data.success) {
            displayMessage(data.reply, 'bot');
        } else {
            displayMessage('Sorry, I encountered an error. Please try again.', 'bot');
        }
    } catch (error) {
        console.error('Error:', error);
        removeTypingIndicator();
        displayMessage('Network error. Please check your connection.', 'bot');
    } finally {
        isTyping = false;
    }
});

function displayMessage(text, sender) {
    const messagesDiv = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    
    messageDiv.innerHTML = `
        <div class="message-bubble">
            ${escapeHtml(text)}
            <div class="message-time">${time}</div>
        </div>
    `;
    
    messagesDiv.appendChild(messageDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function showTypingIndicator() {
    const messagesDiv = document.getElementById('chatMessages');
    const typingDiv = document.createElement('div');
    typingDiv.id = 'typingIndicator';
    typingDiv.className = 'message bot-message';
    typingDiv.innerHTML = `
        <div class="typing-indicator">
            <span></span>
            <span></span>
            <span></span>
        </div>
    `;
    messagesDiv.appendChild(typingDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function removeTypingIndicator() {
    const typingDiv = document.getElementById('typingIndicator');
    if (typingDiv) typingDiv.remove();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Allow Enter key to submit
document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('chatForm').dispatchEvent(new Event('submit'));
    }
});
</script>
@endsection
@endsection