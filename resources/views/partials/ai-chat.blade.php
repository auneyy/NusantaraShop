<!-- AI Chat Button (Floating) -->
<button id="aiChatButton" class="ai-chat-button" aria-label="Chat dengan AI">
  <i class="bi bi-robot"></i>
</button>

<!-- AI Chat Modal -->
<div class="modal fade" id="aiChatModal" tabindex="-1" aria-labelledby="aiChatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content ai-chat-modal">
      <!-- Header -->
      <div class="modal-header ai-chat-header">
        <div class="d-flex align-items-center">
          <div class="ai-avatar">
            <i class="bi bi-robot"></i>
          </div>
          <div class="ms-3">
            <h5 class="modal-title mb-0" id="aiChatModalLabel">Asisten Virtual NusantaraShop</h5>
            <small class="text-white-50">Powered by Gemini 2.5 Flash</small>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-sm btn-light" id="clearChatBtn" title="Hapus Percakapan">
            <i class="bi bi-trash"></i>
          </button>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>

      <!-- Chat Body -->
      <div class="modal-body ai-chat-body" id="chatMessages">
        <!-- Welcome Message -->
        <div class="chat-message ai-message">
          <div class="message-avatar">
            <i class="bi bi-robot"></i>
          </div>
          <div class="message-content">
            <div class="message-bubble">
              <p class="mb-1">Halo! 👋 Selamat datang di NusantaraShop!</p>
              <p class="mb-0">Saya adalah asisten virtual yang siap membantu Anda. Anda bisa menanyakan:</p>
              <ul class="mb-0 mt-2">
                <li>Informasi produk batik kami</li>
                <li>Harga dan ketersediaan stok</li>
                <li>Cara pemesanan dan pengiriman</li>
                <li>Rekomendasi produk</li>
              </ul>
              <p class="mt-2 mb-0">Silakan tanyakan apa saja! 😊</p>
            </div>
            <small class="message-time">Baru saja</small>
          </div>
        </div>
      </div>

      <!-- Chat Footer -->
      <div class="modal-footer ai-chat-footer">
        <form id="chatForm" class="w-100">
          <div class="input-group">
            <input 
              type="text" 
              class="form-control chat-input" 
              id="chatInput" 
              placeholder="Ketik pesan Anda..."
              autocomplete="off"
              maxlength="1000"
            >
            <button class="btn btn-primary chat-send-btn" type="submit" id="sendBtn">
              <i class="bi bi-send-fill"></i>
            </button>
          </div>
          <small class="text-muted d-block mt-1">Tekan Enter untuk mengirim</small>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Loading Indicator -->
<div class="typing-indicator" id="typingIndicator" style="display: none;">
  <div class="chat-message ai-message">
    <div class="message-avatar">
      <i class="bi bi-robot"></i>
    </div>
    <div class="message-content">
      <div class="message-bubble">
        <div class="typing-dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Floating Chat Button */
.ai-chat-button {
  position: fixed;
  bottom: 30px;
  left: 30px;
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #8B4513, #422D1C);
  color: white;
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
  cursor: pointer;
  box-shadow: 0 4px 20px rgba(66, 45, 28, 0.4);
  z-index: 998;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  animation: pulse 2s infinite;
}

.ai-chat-button:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 30px rgba(66, 45, 28, 0.6);
}

@keyframes pulse {
  0%, 100% {
    box-shadow: 0 4px 20px rgba(66, 45, 28, 0.4);
  }
  50% {
    box-shadow: 0 4px 30px rgba(139, 69, 19, 0.6);
  }
}

/* Modal Styling */
.ai-chat-modal {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
}

.ai-chat-header {
  background: linear-gradient(135deg, #8B4513, #422D1C);
  color: white;
  border: none;
  padding: 1.5rem;
}

.ai-avatar {
  width: 50px;
  height: 50px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  backdrop-filter: blur(10px);
}

.ai-chat-body {
  background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
  min-height: 400px;
  max-height: 500px;
  padding: 1.5rem;
  overflow-y: auto;
}

/* Custom Scrollbar */
.ai-chat-body::-webkit-scrollbar {
  width: 6px;
}

.ai-chat-body::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.ai-chat-body::-webkit-scrollbar-thumb {
  background: #8B4513;
  border-radius: 10px;
}

.ai-chat-body::-webkit-scrollbar-thumb:hover {
  background: #422D1C;
}

/* Chat Messages */
.chat-message {
  display: flex;
  margin-bottom: 1.5rem;
  animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.chat-message.user-message {
  flex-direction: row-reverse;
}

.message-avatar {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #8B4513, #422D1C);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  font-size: 1.2rem;
}

.user-message .message-avatar {
  background: linear-gradient(135deg, #6c757d, #495057);
}

.message-content {
  max-width: 75%;
  margin: 0 12px;
}

.user-message .message-content {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.message-bubble {
  background: white;
  padding: 1rem 1.25rem;
  border-radius: 18px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  word-wrap: break-word;
}

.user-message .message-bubble {
  background: linear-gradient(135deg, #8B4513, #422D1C);
  color: white;
}

.message-bubble p:last-child {
  margin-bottom: 0;
}

.message-bubble ul {
  padding-left: 1.5rem;
  margin: 0.5rem 0;
}

.message-time {
  display: block;
  color: #6c757d;
  font-size: 0.75rem;
  margin-top: 0.25rem;
  padding: 0 0.5rem;
}

/* Product Cards in Chat */
.product-card-chat {
  background: white;
  border-radius: 12px;
  padding: 1rem;
  margin-top: 0.5rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.product-card-chat:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.product-card-chat img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 8px;
}

/* Typing Indicator */
.typing-indicator {
  animation: fadeInUp 0.3s ease;
}

.typing-dots {
  display: flex;
  gap: 4px;
  padding: 8px;
}

.typing-dots span {
  width: 8px;
  height: 8px;
  background: #8B4513;
  border-radius: 50%;
  animation: typing 1.4s infinite;
}

.typing-dots span:nth-child(2) {
  animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes typing {
  0%, 60%, 100% {
    transform: translateY(0);
    opacity: 0.7;
  }
  30% {
    transform: translateY(-10px);
    opacity: 1;
  }
}

/* Chat Footer */
.ai-chat-footer {
  background: white;
  border-top: 1px solid #e9ecef;
  padding: 1rem 1.5rem;
}

.chat-input {
  border: 2px solid #e9ecef;
  border-radius: 25px;
  padding: 0.75rem 1.25rem;
  font-size: 0.95rem;
  transition: all 0.3s ease;
}

.chat-input:focus {
  border-color: #8B4513;
  box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.15);
}

.chat-send-btn {
  background: linear-gradient(135deg, #8B4513, #422D1C);
  border: none;
  border-radius: 25px;
  padding: 0.75rem 1.5rem;
  transition: all 0.3s ease;
}

.chat-send-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
}

.chat-send-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

/* Responsive */
@media (max-width: 768px) {
  .ai-chat-button {
    bottom: 20px;
    left: 20px;
    width: 55px;
    height: 55px;
    font-size: 1.6rem;
  }

  .modal-lg {
    max-width: 95%;
  }

  .ai-chat-body {
    max-height: 350px;
  }

  .message-content {
    max-width: 85%;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('aiChatButton');
    const chatModal = new bootstrap.Modal(document.getElementById('aiChatModal'));
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const chatMessages = document.getElementById('chatMessages');
    const sendBtn = document.getElementById('sendBtn');
    const clearChatBtn = document.getElementById('clearChatBtn');
    const typingIndicator = document.getElementById('typingIndicator');
    
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Open chat modal
    chatButton.addEventListener('click', function() {
        chatModal.show();
        chatInput.focus();
    });

    // Clear chat
    clearChatBtn.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menghapus semua percakapan?')) {
            // Clear visual
            const welcomeMessage = chatMessages.querySelector('.chat-message.ai-message');
            chatMessages.innerHTML = '';
            chatMessages.appendChild(welcomeMessage);
            
            // Clear session
            fetch('/api/ai-chat/clear', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        }
    });

    // Send message
    // Send message
chatForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const message = chatInput.value.trim();
    if (!message) return;

    // Add user message
    addMessage(message, 'user');
    chatInput.value = '';
    sendBtn.disabled = true;

    // Show typing indicator
    showTypingIndicator();

    try {
        const response = await fetch('/api/ai-chat/send', {
            method: 'POST',  // ← Pastikan POST
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'  // ← Tambahkan ini
            },
            body: JSON.stringify({ message: message })
        });

        // Hide typing indicator
        hideTypingIndicator();

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            console.error('Response bukan JSON:', await response.text());
            addMessage('Maaf, terjadi kesalahan format response. Silakan coba lagi.', 'ai');
            return;
        }

        const data = await response.json();
        
        if (response.ok && data.success) {
            // Add AI response
            addMessage(data.message, 'ai');
            
            // Add product cards if any
            if (data.products && data.products.length > 0) {
                addProductCards(data.products);
            }
        } else {
            addMessage(data.message || 'Maaf, terjadi kesalahan. Silakan coba lagi.', 'ai');
        }
        
    } catch (error) {
        hideTypingIndicator();
        console.error('Chat error:', error);
        addMessage('Maaf, koneksi bermasalah. Silakan coba lagi.', 'ai');
    } finally {
        sendBtn.disabled = false;
        chatInput.focus();
    }
});

    // Add message to chat
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}-message`;
        
        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'message-avatar';
        avatarDiv.innerHTML = sender === 'user' 
            ? '<i class="bi bi-person-fill"></i>' 
            : '<i class="bi bi-robot"></i>';
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        
        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = 'message-bubble';
        
        // Format text dengan line breaks dan links
        const formattedText = formatMessage(text);
        bubbleDiv.innerHTML = formattedText;
        
        const timeSpan = document.createElement('small');
        timeSpan.className = 'message-time';
        timeSpan.textContent = new Date().toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        contentDiv.appendChild(bubbleDiv);
        contentDiv.appendChild(timeSpan);
        messageDiv.appendChild(avatarDiv);
        messageDiv.appendChild(contentDiv);
        
        chatMessages.appendChild(messageDiv);
        scrollToBottom();
    }

    // Format message text
    function formatMessage(text) {
        // Convert line breaks
        text = text.replace(/\n/g, '<br>');
        
        // Convert URLs to links
        const urlRegex = /(https?:\/\/[^\s]+)/g;
        text = text.replace(urlRegex, '<a href="$1" target="_blank">$1</a>');
        
        // Convert bold markdown **text**
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        
        // Convert italic markdown *text*
        text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
        
        return text;
    }

    // Add product cards
    function addProductCards(products) {
        const productContainer = document.createElement('div');
        productContainer.className = 'chat-message ai-message';
        
        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'message-avatar';
        avatarDiv.innerHTML = '<i class="bi bi-robot"></i>';
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        
        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card-chat d-flex align-items-center gap-3';
            productCard.innerHTML = `
                <img src="/storage/${product.image}" alt="${product.name}" onerror="this.src='/storage/product_images/default.jpg'">
                <div class="flex-grow-1">
                    <h6 class="mb-1">${product.name}</h6>
                    <p class="mb-1 text-muted small">${product.category}</p>
                    <strong class="text-primary">${product.harga}</strong>
                </div>
                <a href="/products/${product.slug}" class="btn btn-sm btn-outline-primary">
                    Lihat
                </a>
            `;
            contentDiv.appendChild(productCard);
        });
        
        productContainer.appendChild(avatarDiv);
        productContainer.appendChild(contentDiv);
        chatMessages.appendChild(productContainer);
        scrollToBottom();
    }

    // Show typing indicator
    function showTypingIndicator() {
        const clone = typingIndicator.cloneNode(true);
        clone.style.display = 'block';
        clone.id = 'activeTypingIndicator';
        chatMessages.appendChild(clone);
        scrollToBottom();
    }

    // Hide typing indicator
    function hideTypingIndicator() {
        const indicator = document.getElementById('activeTypingIndicator');
        if (indicator) {
            indicator.remove();
        }
    }

    // Scroll to bottom
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Enter key to send
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });
});
</script>