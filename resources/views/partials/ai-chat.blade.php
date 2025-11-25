<!-- AI Chat Button (Floating) -->
<button id="aiChatButton" class="ai-chat-button" aria-label="Chat dengan AI">
  <i class="bi bi-robot"></i>
  <span class="chat-badge" id="chatBadge" style="display: none;">1</span>
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
            <h5 class="modal-title mb-0" id="aiChatModalLabel">Asisten Virtual</h5>
            <small class="text-white-50 d-flex align-items-center">
              <span class="status-dot"></span> Online
            </small>
          </div>
        </div>
        <div class="d-flex gap-1 close-btn">
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="d-flex gap-5 clear-btn">
        <button type="button" class="btn btn-sm" id="clearChatBtn" title="Hapus Percakapan">
            <i class="bi bi-trash"></i></button>
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
              <p class="mb-2">👋 Halo! Selamat datang di <strong>NusantaraShop</strong>!</p>
              <p class="mb-2">Saya siap membantu Anda menemukan batik yang tepat. Anda bisa bertanya:</p>
              <div class="quick-questions">
                <button class="quick-question-btn" data-question="Ada kemeja batik pria formal?">
                  <i class="bi bi-search"></i> Kemeja batik pria
                </button>
                <button class="quick-question-btn" data-question="Rekomendasi batik wanita untuk kondangan">
                  <i class="bi bi-stars"></i> Batik wanita
                </button>
                <button class="quick-question-btn" data-question="Produk apa yang lagi diskon?">
                  <i class="bi bi-tag"></i> Produk diskon
                </button>
              </div>
              <p class="mt-2 mb-0 small text-muted">Atau tanyakan apa saja sesuai kebutuhan Anda 😊</p>
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
          <small class="text-muted d-block mt-1">
            <i class="bi bi-lightbulb"></i> Tekan Enter untuk mengirim
          </small>
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

.clear-btn {
  margin-bottom: 18px;
  margin-right: 30px;
}

.clear-btn i {
  font-size: 20px;
  color: white;
}

.close-btn {
  margin-bottom: 18px;
}

.modal-content {
  max-width: 800px;
}

.modal-title {
  color: white;
}

.ai-chat-button:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 30px rgba(66, 45, 28, 0.6);
}

.chat-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #dc3545;
  color: white;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: bold;
  border: 2px solid white;
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
  max-height: 90vh;
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

.status-dot {
  width: 8px;
  height: 8px;
  background: #28a745;
  border-radius: 50%;
  display: inline-block;
  margin-right: 5px;
  animation: blink 2s infinite;
}

@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
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
  line-height: 1.6;
}

.user-message .message-bubble {
  background: linear-gradient(135deg, #8B4513, #422D1C);
  color: white;
}

.message-bubble p:last-child {
  margin-bottom: 0;
}

.message-time {
  display: block;
  color: #6c757d;
  font-size: 0.75rem;
  margin-top: 0.25rem;
  padding: 0 0.5rem;
}

/* Quick Questions */
.quick-questions {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  margin: 0.75rem 0;
}

.quick-question-btn {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 10px;
  padding: 0.6rem 1rem;
  text-align: left;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 0.9rem;
  color: #495057;
}

.quick-question-btn:hover {
  background: #e9ecef;
  border-color: #8B4513;
  color: #8B4513;
  transform: translateX(5px);
}

.quick-question-btn i {
  margin-right: 0.5rem;
  color: #8B4513;
}

/* Product Cards in Chat */
.product-card-chat {
  background: white;
  border-radius: 12px;
  padding: 1rem;
  margin-top: 0.5rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  border: 1px solid #e9ecef;
}

.product-card-chat:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  border-color: #8B4513;
}

.product-card-chat img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 10px;
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

.chat-send-btn:hover:not(:disabled) {
  transform: scale(1.05);
  box-shadow: 0 4px 15px rgba(66, 45, 28, 0.3);
}

.chat-send-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Error Message */
.error-message {
  background: #f8d7da;
  color: #721c24;
  padding: 0.75rem 1rem;
  border-radius: 10px;
  border: 1px solid #f5c6cb;
  margin-top: 0.5rem;
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
    max-height: 400px;
    min-height: 300px;
  }

  .message-content {
    max-width: 85%;
  }

  .product-card-chat {
    flex-direction: column;
    text-align: center;
  }

  .product-card-chat img {
    width: 100%;
    height: 150px;
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
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Open chat modal
    chatButton.addEventListener('click', function() {
        chatModal.show();
        chatInput.focus();
    });

    // Quick question buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.quick-question-btn')) {
            const question = e.target.closest('.quick-question-btn').dataset.question;
            chatInput.value = question;
            chatForm.dispatchEvent(new Event('submit'));
        }
    });

    // Clear chat
    clearChatBtn.addEventListener('click', function() {
        if (confirm('Hapus semua percakapan?')) {
            const welcomeMessage = chatMessages.querySelector('.chat-message.ai-message');
            chatMessages.innerHTML = '';
            chatMessages.appendChild(welcomeMessage.cloneNode(true));
            
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
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = chatInput.value.trim();
        if (!message) return;

        addMessage(message, 'user');
        chatInput.value = '';
        sendBtn.disabled = true;
        showTypingIndicator();

        // Debug: Log request
        console.log('📤 Sending message:', message);

        try {
            const startTime = Date.now();
            
            const response = await fetch('/api/ai-chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });

            const responseTime = Date.now() - startTime;
            console.log(`⏱️ Response time: ${responseTime}ms`);

            hideTypingIndicator();

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                console.error('❌ Invalid content type:', contentType);
                throw new Error('Invalid response format');
            }

            const data = await response.json();
            console.log('📥 Response data:', data);
            
            if (response.ok && data.success) {
                addMessage(data.message, 'ai');
                
                if (data.products && data.products.length > 0) {
                    console.log('🛍️ Products found:', data.products.length);
                    addProductCards(data.products);
                } else {
                    console.log('ℹ️ No products in response');
                }
            } else {
                console.error('❌ Request failed:', data);
                addMessage(data.message || 'Terjadi kesalahan. Silakan coba lagi.', 'ai');
            }
            
        } catch (error) {
            hideTypingIndicator();
            console.error('💥 Chat error:', error);
            addMessage('Maaf, koneksi bermasalah. Pastikan Anda terhubung dengan internet.', 'ai');
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
        bubbleDiv.innerHTML = formatMessage(text);
        
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
        text = text.replace(/\n/g, '<br>');
        
        const urlRegex = /(https?:\/\/[^\s]+)/g;
        text = text.replace(urlRegex, '<a href="$1" target="_blank" class="text-primary">$1</a>');
        
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
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
        contentDiv.style.maxWidth = '85%';
        
        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card-chat d-flex align-items-center gap-3';
            productCard.innerHTML = `
                <img src="${product.image}" alt="${product.name}" onerror="this.src='/storage/product_images/default.jpg'">
                <div class="flex-grow-1">
                    <h6 class="mb-1">${product.name}</h6>
                    <p class="mb-1 text-muted small">${product.category}</p>
                    <strong class="text-primary">${product.harga}</strong>
                </div>
                <a href="/products/${product.slug}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> Lihat
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
        setTimeout(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 100);
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