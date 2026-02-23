/* ======================================================
   NexusAI — Main JavaScript
   ====================================================== */

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initFadeAnimations();
    initChatWidget();
    initDemoChat();
    initContactForm();
    initOcrPage();
});

/**
 * Show a toast notification instead of browser alert().
 * @param {string} message - The message to display.
 * @param {'error'|'warning'|'success'|'info'} type - Toast type for styling.
 * @param {number} duration - Auto-dismiss time in ms.
 */
function showToast(message, type = 'error', duration = 4000) {
    // Ensure container exists
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const icons = {
        error: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        warning: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        success: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
        info: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
    };

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span class="toast-icon">${icons[type] || icons.info}</span>
        <span class="toast-message">${message}</span>
        <button class="toast-close" aria-label="Dismiss">&times;</button>
    `;

    // Dismiss on close click
    toast.querySelector('.toast-close').addEventListener('click', () => dismissToast(toast));

    container.appendChild(toast);

    // Trigger entrance animation
    requestAnimationFrame(() => toast.classList.add('toast-visible'));

    // Auto-dismiss
    setTimeout(() => dismissToast(toast), duration);
}

function dismissToast(toast) {
    if (toast.classList.contains('toast-leaving')) return;
    toast.classList.add('toast-leaving');
    toast.addEventListener('animationend', () => toast.remove());
}

/* --- Navigation --- */
function initNavigation() {
    const toggle = document.getElementById('navToggle');
    const menu = document.getElementById('navMenu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        toggle.classList.toggle('active');
        menu.classList.toggle('active');
    });

    menu.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            toggle.classList.remove('active');
            menu.classList.remove('active');
        });
    });

    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.style.background = window.scrollY > 50
            ? 'rgba(10, 14, 26, 0.95)'
            : 'rgba(10, 14, 26, 0.8)';
    });
}

/* --- Fade-Up Animations (Intersection Observer) --- */
function initFadeAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), index * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
}

/* --- Chat Widget (Floating) --- */
function initChatWidget() {
    const trigger = document.getElementById('chatTrigger');
    const panel = document.getElementById('chatPanel');
    const closeBtn = document.getElementById('chatClose');
    const form = document.getElementById('widgetForm');
    const input = document.getElementById('widgetInput');
    const messagesContainer = document.getElementById('widgetMessages');

    if (!trigger || !panel) return;

    trigger.addEventListener('click', () => {
        panel.classList.toggle('active');
        if (panel.classList.contains('active')) input?.focus();
    });

    closeBtn?.addEventListener('click', () => panel.classList.remove('active'));

    form?.addEventListener('submit', (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        appendMessage(messagesContainer, message, 'user');
        input.value = '';
        streamBotResponse(messagesContainer, message, null);
    });
}

/* ===================================================
   DEMO CHAT — Full Page with Streaming + Image Upload
   =================================================== */
function initDemoChat() {
    const form = document.getElementById('demoForm');
    const input = document.getElementById('demoInput');
    const messagesContainer = document.getElementById('demoMessages');
    const scrollContainer = messagesContainer?.closest('.demo-chat-scroll') || messagesContainer;
    const welcome = document.getElementById('demoWelcome');
    const fileInput = document.getElementById('demoFileInput');
    const uploadBtn = document.getElementById('demoUploadBtn');
    const previewEl = document.getElementById('demoImagePreview');
    const previewThumb = document.getElementById('previewThumb');
    const previewRemove = document.getElementById('previewRemove');
    const dropOverlay = document.getElementById('demoDropOverlay');

    if (!form || !input || !messagesContainer) return;

    let pendingImage = null; // base64 string
    let dragCounter = 0;

    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // --- Welcome screen hide ---
    function hideWelcome() {
        if (welcome && !welcome.classList.contains('hidden')) {
            welcome.classList.add('hidden');
        }
    }

    // --- Image handling ---
    function handleFile(file) {
        if (!file) return;
        if (!ALLOWED_TYPES.includes(file.type)) {
            showToast('Only image files are allowed (JPEG, PNG, GIF, WebP).', 'warning');
            return;
        }
        if (file.size > MAX_FILE_SIZE) {
            showToast('Image must be under 5MB.', 'warning');
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            pendingImage = e.target.result; // data:image/...;base64,...
            previewThumb.src = pendingImage;
            previewEl.style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }

    function clearImage() {
        pendingImage = null;
        previewThumb.src = '';
        previewEl.style.display = 'none';
        fileInput.value = '';
    }

    // Upload button click
    uploadBtn?.addEventListener('click', () => fileInput.click());

    // File input change
    fileInput?.addEventListener('change', () => {
        if (fileInput.files.length > 0) handleFile(fileInput.files[0]);
    });

    // Remove preview
    previewRemove?.addEventListener('click', clearImage);

    // Clipboard paste
    document.addEventListener('paste', (e) => {
        if (!messagesContainer) return;
        const items = e.clipboardData?.items;
        if (!items) return;
        for (const item of items) {
            if (item.type.startsWith('image/')) {
                e.preventDefault();
                handleFile(item.getAsFile());
                return;
            }
        }
    });

    // Drag-and-drop on the full page
    const demoFullpage = messagesContainer.closest('.demo-fullpage');

    demoFullpage?.addEventListener('dragenter', (e) => {
        if (!e.dataTransfer?.types?.includes('Files')) return;
        e.preventDefault();
        dragCounter++;
        if (dragCounter === 1) dropOverlay?.classList.add('active');
    });

    demoFullpage?.addEventListener('dragleave', (e) => {
        if (!e.dataTransfer?.types?.includes('Files')) return;
        e.preventDefault();
        dragCounter--;
        if (dragCounter <= 0) {
            dragCounter = 0;
            dropOverlay?.classList.remove('active');
        }
    });

    demoFullpage?.addEventListener('dragover', (e) => {
        if (!e.dataTransfer?.types?.includes('Files')) return;
        e.preventDefault();
    });

    demoFullpage?.addEventListener('drop', (e) => {
        if (!e.dataTransfer?.types?.includes('Files')) return;
        e.preventDefault();
        dragCounter = 0;
        dropOverlay?.classList.remove('active');
        const file = e.dataTransfer?.files?.[0];
        if (file) handleFile(file);
    });

    // --- Suggestion cards ---
    document.querySelectorAll('.suggestion-card').forEach(card => {
        card.addEventListener('click', () => {
            const message = card.dataset.message;
            if (!message) return;
            input.value = message;
            form.dispatchEvent(new Event('submit'));
        });
    });

    // --- Form submit ---
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message && !pendingImage) return;

        hideWelcome();

        // Show user message (with image thumbnail if present)
        appendMessage(messagesContainer, message || 'Analyze this image', 'user', pendingImage);
        input.value = '';
        input.focus();

        // Stream the bot response
        const imageToSend = pendingImage;
        clearImage();
        streamBotResponse(messagesContainer, message || 'What is in this image?', imageToSend);
    });
}

/* --- Contact Form --- */
function initContactForm() {
    const form = document.getElementById('contactForm');
    const success = document.getElementById('formSuccess');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const btn = document.getElementById('contactSubmit');
        btn.textContent = 'Sending...';
        btn.disabled = true;
        setTimeout(() => {
            form.style.display = 'none';
            success.style.display = 'block';
        }, 1200);
    });
}

/* --- OCR Product Scan Page --- */
function initOcrPage() {
    const dropZone = document.getElementById('ocrDropZone');
    const fileInput = document.getElementById('ocrFileInput');
    const browseBtn = document.getElementById('ocrBrowseBtn');
    const preview = document.getElementById('ocrPreview');
    const previewImg = document.getElementById('ocrPreviewImg');
    const confirmBtn = document.getElementById('ocrConfirmBtn');
    const removeBtn = document.getElementById('ocrRemoveBtn');
    const scanAnotherBtn = document.getElementById('ocrScanAnother');
    const copyJsonBtn = document.getElementById('ocrCopyJson');

    if (!dropZone || !fileInput) return; // not on OCR page

    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    const MAX_SIZE = 10 * 1024 * 1024; // 10MB
    let pendingImage = null;

    // --- Steps ---
    function showStep(stepId) {
        document.querySelectorAll('.ocr-step').forEach(s => s.classList.remove('active'));
        document.getElementById(stepId).classList.add('active');
    }

    // --- File Handling ---
    function handleOcrFile(file) {
        if (!file) return;
        if (!ALLOWED_TYPES.includes(file.type)) {
            showToast('Only image files are allowed (JPEG, PNG, WebP).', 'warning');
            return;
        }
        if (file.size > MAX_SIZE) {
            showToast('Image must be under 10MB.', 'warning');
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            pendingImage = e.target.result;
            previewImg.src = pendingImage;
            dropZone.style.display = 'none';
            preview.style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }

    // Browse button
    browseBtn.addEventListener('click', (e) => { e.stopPropagation(); fileInput.click(); });
    dropZone.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', () => {
        if (fileInput.files[0]) handleOcrFile(fileInput.files[0]);
    });

    // Remove preview
    removeBtn.addEventListener('click', () => {
        pendingImage = null;
        previewImg.src = '';
        fileInput.value = '';
        preview.style.display = 'none';
        dropZone.style.display = 'flex';
    });

    // Drag-and-drop
    dropZone.addEventListener('dragenter', (e) => {
        e.preventDefault();
        if (e.dataTransfer?.types?.includes('Files')) dropZone.classList.add('drag-over');
    });
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        if (e.dataTransfer?.types?.includes('Files')) dropZone.classList.add('drag-over');
    });
    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
    });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        if (e.dataTransfer?.files?.length) handleOcrFile(e.dataTransfer.files[0]);
    });

    // --- Confirm & Analyze ---
    confirmBtn.addEventListener('click', async () => {
        if (!pendingImage) return;
        showStep('ocrStepProcessing');

        const processingText = document.getElementById('ocrProcessingText');
        const messages = [
            'Identifying product with AI vision...',
            'Searching the web for product info...',
            'Gathering specifications and details...',
            'Generating enriched product data...',
        ];
        let msgIdx = 0;
        const msgInterval = setInterval(() => {
            msgIdx = (msgIdx + 1) % messages.length;
            if (processingText) processingText.textContent = messages[msgIdx];
        }, 2500);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const res = await fetch('/api/ocr', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ image: pendingImage }),
            });

            clearInterval(msgInterval);

            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                throw new Error(err.error || 'Analysis failed');
            }

            const data = await res.json();

            // Populate form
            document.getElementById('ocrResultImg').src = pendingImage;
            document.getElementById('ocrProductName').value = data.product_name || '';
            document.getElementById('ocrDescription').value = data.description || '';
            document.getElementById('ocrCategory').value = data.category || '';
            document.getElementById('ocrBrand').value = data.brand || '';

            // Show web-enhanced badge if applicable
            const subheading = document.querySelector('.ocr-result-subheading');
            if (subheading) {
                const existingBadge = subheading.querySelector('.ocr-web-badge');
                if (existingBadge) existingBadge.remove();
                if (data.web_enhanced) {
                    const badge = document.createElement('span');
                    badge.className = 'ocr-web-badge';
                    badge.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg> Web-enhanced';
                    subheading.appendChild(badge);
                }
            }

            // Set condition dropdown
            const condSelect = document.getElementById('ocrCondition');
            const condVal = data.condition || 'Used';
            for (let i = 0; i < condSelect.options.length; i++) {
                if (condSelect.options[i].value === condVal) {
                    condSelect.selectedIndex = i;
                    break;
                }
            }

            // Reset price/unit
            document.getElementById('ocrPrice').value = '0.00';
            document.getElementById('ocrUnit').value = '1';

            showStep('ocrStepResult');
            showToast('Product analyzed successfully!', 'success');

        } catch (err) {
            clearInterval(msgInterval);
            showStep('ocrStepUpload');
            showToast(err.message || 'Failed to analyze image. Please try again.', 'error');
        }
    });

    // --- Scan Another ---
    scanAnotherBtn.addEventListener('click', () => {
        pendingImage = null;
        previewImg.src = '';
        fileInput.value = '';
        preview.style.display = 'none';
        dropZone.style.display = 'flex';
        showStep('ocrStepUpload');
    });

    // --- Copy JSON ---
    copyJsonBtn.addEventListener('click', () => {
        const jsonData = {
            product_name: document.getElementById('ocrProductName').value,
            description: document.getElementById('ocrDescription').value,
            category: document.getElementById('ocrCategory').value,
            brand: document.getElementById('ocrBrand').value,
            condition: document.getElementById('ocrCondition').value,
            price_rm: parseFloat(document.getElementById('ocrPrice').value) || 0,
            quantity: parseInt(document.getElementById('ocrUnit').value) || 1,
        };
        navigator.clipboard.writeText(JSON.stringify(jsonData, null, 2))
            .then(() => showToast('JSON copied to clipboard!', 'success'))
            .catch(() => showToast('Failed to copy to clipboard.', 'error'));
    });
}

/* ===================================================
   SHARED CHAT FUNCTIONS
   =================================================== */

/**
 * Append a chat message bubble (user or bot).
 * If imgSrc is provided, shows a thumbnail in the message.
 */
function appendMessage(container, text, sender, imgSrc = null) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `chat-message ${sender}`;

    if (imgSrc && sender === 'user') {
        const img = document.createElement('img');
        img.className = 'chat-image-thumb';
        img.src = imgSrc;
        img.alt = 'Uploaded image';
        messageDiv.appendChild(img);
    }

    if (text) {
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = text;
        messageDiv.appendChild(bubble);
    }

    const time = document.createElement('span');
    time.className = 'chat-time';
    time.textContent = new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
    messageDiv.appendChild(time);

    container.appendChild(messageDiv);
    const sc = container.closest('.demo-chat-scroll') || container;
    sc.scrollTop = sc.scrollHeight;
}

/**
 * Show typing indicator.
 */
function showTypingIndicator(container) {
    const typing = document.createElement('div');
    typing.className = 'chat-message bot';
    typing.id = 'typingIndicator';

    const indicator = document.createElement('div');
    indicator.className = 'typing-indicator';
    indicator.innerHTML = '<span></span><span></span><span></span>';

    typing.appendChild(indicator);
    container.appendChild(typing);
    const sc = container.closest('.demo-chat-scroll') || container;
    sc.scrollTop = sc.scrollHeight;
}

function removeTypingIndicator() {
    document.getElementById('typingIndicator')?.remove();
}

/**
 * Stream the bot response from the server via SSE.
 */
async function streamBotResponse(container, message, imageBase64) {
    showTypingIndicator(container);

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        const body = { message };
        if (imageBase64) {
            body.image = imageBase64;
        }

        const response = await fetch('/api/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'text/event-stream',
            },
            body: JSON.stringify(body),
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        removeTypingIndicator();

        // Create bot message bubble for streaming tokens
        const messageDiv = document.createElement('div');
        messageDiv.className = 'chat-message bot';

        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = '';

        const time = document.createElement('span');
        time.className = 'chat-time';
        time.textContent = new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });

        messageDiv.appendChild(bubble);
        messageDiv.appendChild(time);
        container.appendChild(messageDiv);

        // Read the SSE stream
        const reader = response.body.getReader();
        const decoder = new TextDecoder();
        let buffer = '';
        let fullText = '';

        while (true) {
            const { done, value } = await reader.read();
            if (done) break;

            buffer += decoder.decode(value, { stream: true });

            // Parse SSE lines
            const lines = buffer.split('\n');
            buffer = lines.pop();

            for (const line of lines) {
                const trimmed = line.trim();
                if (!trimmed.startsWith('data: ')) continue;

                const jsonStr = trimmed.slice(6);
                try {
                    const data = JSON.parse(jsonStr);

                    if (data.error) {
                        bubble.textContent += '\n[Error: ' + data.error + ']';
                        continue;
                    }

                    if (data.token) {
                        fullText += data.token;
                        bubble.innerHTML = renderMarkdown(fullText);
                        (container.closest('.demo-chat-scroll') || container).scrollTop = (container.closest('.demo-chat-scroll') || container).scrollHeight;
                    }

                    if (data.sources && data.sources.length > 0) {
                        // Render source references footer
                        const sourcesDiv = document.createElement('div');
                        sourcesDiv.className = 'chat-sources';
                        sourcesDiv.innerHTML = '<span class="chat-sources-label">Sources</span>' +
                            data.sources.map(s =>
                                `<a href="${s.url}" target="_blank" rel="noopener noreferrer" class="chat-source-link" title="${s.title}">${s.index}. ${truncateText(s.title, 40)}</a>`
                            ).join('');
                        messageDiv.appendChild(sourcesDiv);
                        (container.closest('.demo-chat-scroll') || container).scrollTop = (container.closest('.demo-chat-scroll') || container).scrollHeight;
                    }

                    if (data.done) {
                        // Streaming complete
                    }
                } catch (parseErr) {
                    // Skip malformed JSON
                }
            }
        }

    } catch (error) {
        removeTypingIndicator();
        appendBotErrorMessage(container, "Sorry, I'm having trouble connecting right now. Please try again in a moment.");
    }
}

/**
 * Markdown renderer for bot messages.
 * Handles headings, bold, italic, code, lists, and line breaks.
 */
function renderMarkdown(text) {
    // Escape HTML first
    let html = text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');

    // Handle fenced code blocks (```...```) before line processing
    html = html.replace(/```(\w*)\n([\s\S]*?)```/g, (match, lang, code) => {
        return `<pre class="chat-code-block"><code>${code.trim()}</code></pre>`;
    });
    // Also handle ``` on same line or without language
    html = html.replace(/```([\s\S]*?)```/g, (match, code) => {
        return `<pre class="chat-code-block"><code>${code.trim()}</code></pre>`;
    });

    // Process line by line for block-level elements
    const lines = html.split('\n');
    const processed = lines.map(line => {
        // Headings (#### before ### before ## before #)
        if (line.startsWith('#### ')) return `<h4 class="chat-h4">${line.slice(5)}</h4>`;
        if (line.startsWith('### ')) return `<h3 class="chat-h3">${line.slice(4)}</h3>`;
        if (line.startsWith('## ')) return `<h2 class="chat-h2">${line.slice(3)}</h2>`;
        if (line.startsWith('# ')) return `<h1 class="chat-h1">${line.slice(2)}</h1>`;

        // Horizontal rules
        if (/^---+$/.test(line.trim())) return '<hr class="chat-hr">';

        // Unordered list items
        if (/^[\-\*]\s/.test(line.trim())) {
            const content = line.trim().slice(2);
            return `<div class="chat-li">${content}</div>`;
        }

        return line;
    });

    html = processed.join('\n');

    // Inline formatting
    html = html
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/`([^`]+)`/g, '<code class="chat-inline-code">$1</code>')
        .replace(/\n/g, '<br>');

    return html;
}

/**
 * Append an error message from the bot.
 */
function appendBotErrorMessage(container, text) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chat-message bot';

    const bubble = document.createElement('div');
    bubble.className = 'chat-bubble';
    bubble.textContent = text;

    const time = document.createElement('span');
    time.className = 'chat-time';
    time.textContent = new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });

    messageDiv.appendChild(bubble);
    messageDiv.appendChild(time);
    container.appendChild(messageDiv);
    const sc = container.closest('.demo-chat-scroll') || container;
    sc.scrollTop = sc.scrollHeight;
}

/**
 * Truncate text to a max length with ellipsis.
 */
function truncateText(text, maxLen) {
    if (!text) return '';
    return text.length > maxLen ? text.slice(0, maxLen) + '...' : text;
}
