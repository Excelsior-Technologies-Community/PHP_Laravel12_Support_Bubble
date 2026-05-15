{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Support Bubble | Customer Support System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .hero {
            text-align: center;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.95);
            padding: 50px 40px;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
        }

        h1 {
            font-size: 48px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .badge {
            display: inline-block;
            background: #e0e7ff;
            color: #4f46e5;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        p {
            color: #4b5563;
            line-height: 1.7;
            margin-bottom: 32px;
            font-size: 18px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 40px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 14px 0 rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px 0 rgba(0, 0, 0, 0.25);
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .feature {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }

        .feature span {
            display: block;
            font-size: 24px;
            margin-bottom: 8px;
        }

        @media (max-width: 600px) {
            .hero {
                padding: 30px 20px;
            }
            h1 {
                font-size: 32px;
            }
            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="hero">
    
        <h1>Support Bubble</h1>
        <p>Modern customer support system with floating chat bubble,<br>admin dashboard, and real-time ticket management.</p>
        <a href="/admin/support-messages" class="btn">
             Open Admin Dashboard
            <span>→</span>
        </a>
       
    </div>

    {{-- Support Bubble Component --}}
    <div id="support-bubble"></div>

    <script>
        // Load support bubble dynamically
        (function() {
            const bubbleHtml = `
                <div id="bubble-container">
                    <button id="bubble-btn" class="bubble-button">
                        <span class="bubble-icon">💬</span>
                        <span class="notification-dot" style="display: none;"></span>
                    </button>
                    <div id="bubble-form" class="bubble-form">
                        <div class="form-header">
                            <div>
                                <h3>Support Center</h3>
                                <p>We typically reply within minutes</p>
                            </div>
                            <button id="close-form" class="close-btn">×</button>
                        </div>
                        <form id="supportForm">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Your name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Your email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="form-group">
                                <textarea name="message" placeholder="How can we help?" rows="4" required></textarea>
                            </div>
                            <button type="submit" id="submitBtn" class="submit-btn">
                                <span>Send Message</span>
                            </button>
                        </form>
                        <div id="form-message" class="form-message"></div>
                    </div>
                </div>
                <style>
                    #bubble-container {
                        position: fixed;
                        bottom: 24px;
                        right: 24px;
                        z-index: 1000;
                        font-family: 'Inter', sans-serif;
                    }
                    .bubble-button {
                        width: 60px;
                        height: 60px;
                        border-radius: 30px;
                        background: linear-gradient(135deg, #667eea, #764ba2);
                        border: none;
                        cursor: pointer;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                        transition: transform 0.2s, box-shadow 0.2s;
                        position: relative;
                    }
                    .bubble-button:hover {
                        transform: scale(1.05);
                        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
                    }
                    .bubble-icon {
                        font-size: 26px;
                    }
                    .notification-dot {
                        position: absolute;
                        top: 8px;
                        right: 8px;
                        width: 12px;
                        height: 12px;
                        background: #ef4444;
                        border-radius: 6px;
                        border: 2px solid white;
                    }
                    .bubble-form {
                        position: absolute;
                        bottom: 80px;
                        right: 0;
                        width: 380px;
                        background: white;
                        border-radius: 20px;
                        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
                        display: none;
                        overflow: hidden;
                    }
                    .form-header {
                        background: linear-gradient(135deg, #667eea, #764ba2);
                        padding: 20px;
                        color: white;
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                    }
                    .form-header h3 {
                        font-size: 20px;
                        margin-bottom: 4px;
                    }
                    .form-header p {
                        font-size: 12px;
                        opacity: 0.9;
                        margin: 0;
                    }
                    .close-btn {
                        background: rgba(255,255,255,0.2);
                        border: none;
                        color: white;
                        font-size: 24px;
                        cursor: pointer;
                        width: 32px;
                        height: 32px;
                        border-radius: 16px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: background 0.2s;
                    }
                    .close-btn:hover {
                        background: rgba(255,255,255,0.3);
                    }
                    #supportForm {
                        padding: 20px;
                    }
                    .form-group {
                        margin-bottom: 15px;
                    }
                    .form-group input,
                    .form-group textarea {
                        width: 100%;
                        padding: 12px 14px;
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        font-size: 14px;
                        font-family: 'Inter', sans-serif;
                        transition: border-color 0.2s;
                    }
                    .form-group input:focus,
                    .form-group textarea:focus {
                        outline: none;
                        border-color: #667eea;
                        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
                    }
                    .submit-btn {
                        width: 100%;
                        padding: 12px;
                        background: linear-gradient(135deg, #667eea, #764ba2);
                        border: none;
                        border-radius: 12px;
                        color: white;
                        font-weight: 600;
                        cursor: pointer;
                        transition: opacity 0.2s;
                    }
                    .submit-btn:hover {
                        opacity: 0.9;
                    }
                    .submit-btn:disabled {
                        opacity: 0.6;
                        cursor: not-allowed;
                    }
                    .form-message {
                        padding: 0 20px 20px 20px;
                        font-size: 14px;
                        text-align: center;
                    }
                    .form-message.success {
                        color: #10b981;
                    }
                    .form-message.error {
                        color: #ef4444;
                    }
                    @media (max-width: 480px) {
                        .bubble-form {
                            width: calc(100vw - 40px);
                            right: -10px;
                        }
                    }
                </style>
            `;

            document.body.insertAdjacentHTML('beforeend', bubbleHtml);

            const bubbleBtn = document.getElementById('bubble-btn');
            const bubbleForm = document.getElementById('bubble-form');
            const closeForm = document.getElementById('close-form');
            const supportForm = document.getElementById('supportForm');
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('form-message');

            function toggleForm() {
                bubbleForm.style.display = bubbleForm.style.display === 'block' ? 'none' : 'block';
                if (bubbleForm.style.display === 'block') {
                    formMessage.innerHTML = '';
                }
            }

            bubbleBtn.onclick = toggleForm;
            if (closeForm) closeForm.onclick = toggleForm;

            supportForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Sending...</span>';
                formMessage.innerHTML = '';
                formMessage.className = 'form-message';

                const formData = new FormData(this);

                try {
                    const response = await fetch('/support-bubble', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        formMessage.innerHTML = '✅ ' + data.message;
                        formMessage.className = 'form-message success';
                        supportForm.reset();
                        setTimeout(() => {
                            bubbleForm.style.display = 'none';
                            formMessage.innerHTML = '';
                        }, 2000);
                    } else {
                        formMessage.innerHTML = '❌ ' + (data.message || 'Something went wrong');
                        formMessage.className = 'form-message error';
                    }
                } catch (error) {
                    formMessage.innerHTML = '❌ Network error. Please try again.';
                    formMessage.className = 'form-message error';
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>Send Message</span>';
                }
            });
        })();
    </script>
</body>
</html>