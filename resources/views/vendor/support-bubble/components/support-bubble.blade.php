<div id="support-bubble-system">
    <button id="bubbleTriggerNode">
        <i class="fas fa-comments"></i>
        <span class="pulse-ring"></span>
    </button>

    <div id="bubbleFormModal">
        <div class="modal-form-header">
            <div>
                <h4>Support Center</h4>
                <p>We typically respond within minutes</p>
            </div>
        </div>
        <form id="bubbleAsyncForm" enctype="multipart/form-data">
            @csrf
            <div class="form-item-group">
                <input type="text" name="name" placeholder="Your full name" required>
            </div>
            <div class="form-item-group">
                <input type="email" name="email" placeholder="Your email address" required>
            </div>
            <div class="form-item-group">
                <select name="category" required>
                    <option value="Inquiry">General Inquiry</option>
                    <option value="Bug">Report a Bug</option>
                    <option value="Billing">Billing Issue</option>
                </select>
            </div>
            <div class="form-item-group">
                <input type="text" name="subject" placeholder="Ticket subject" required>
            </div>
            <div class="form-item-group">
                <textarea name="message" placeholder="How can our desk assist you today?" rows="3" required></textarea>
            </div>
            <div class="form-item-group">
                <label class="attachment-upload-label">
                    <i class="fas fa-paperclip"></i> Attach Screenshot (Optional)
                    <input type="file" name="attachment" accept="image/*" style="display: none;" id="attachmentFileField">
                </label>
                <div id="fileSelectedFeedback" class="small text-muted mt-1" style="font-size: 11px;"></div>
            </div>
            <button type="submit" id="bubbleSubmitTrigger">Submit Ticket</button>
        </form>
        <p id="bubbleOperationFeedback"></p>
    </div>
</div>

<style>
    #support-bubble-system { position: fixed; bottom: 25px; right: 25px; z-index: 99999; font-family: 'Inter', sans-serif; }
    #bubbleTriggerNode { width: 60px; height: 60px; border-radius: 50%; border: none; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; font-size: 24px; cursor: pointer; box-shadow: 0 4px 15px rgba(79,70,229,0.4); position: relative; display: flex; align-items: center; justify-content: center; outline: none; }
    .pulse-ring { position: absolute; width: 100%; height: 100%; background: rgba(79,70,229,0.4); border-radius: 50%; animation: bubblePulse 2s infinite; z-index: -1; }
    @keyframes bubblePulse { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(1.4); opacity: 0; } }
    #bubbleFormModal { position: absolute; bottom: 75px; right: 0; width: 350px; background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); display: none; overflow: hidden; border: 1px solid #e5e7eb; }
    .modal-form-header { background: linear-gradient(135deg, #4f46e5, #7c3aed); padding: 20px; color: white; }
    .modal-form-header h4 { margin: 0 0 4px 0; font-size: 16px; font-weight: 600; }
    .modal-form-header p { margin: 0; font-size: 12px; opacity: 0.9; }
    #bubbleAsyncForm { padding: 18px; }
    .form-item-group { margin-bottom: 12px; }
    #bubbleAsyncForm input, #bubbleAsyncForm select, #bubbleAsyncForm textarea { width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; outline: none; background: #fafafa; }
    #bubbleAsyncForm input:focus, #bubbleAsyncForm select:focus, #bubbleAsyncForm textarea:focus { border-color: #4f46e5; background: white; }
    .attachment-upload-label { display: block; text-align: center; padding: 8px; background: #f3f4f6; border: 1px dashed #d1d5db; border-radius: 8px; font-size: 12px; font-weight: 500; color: #4b5563; cursor: pointer; }
    #bubbleSubmitTrigger { width: 100%; padding: 11px; border: none; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
    #bubbleOperationFeedback { text-align: center; font-size: 13px; padding: 0 18px 15px 18px; margin: 0; font-weight: 500; }
    .text-success-custom { color: #10b981; }
    .text-danger-custom { color: #ef4444; }
</style>

<script>
    document.getElementById('bubbleTriggerNode').onclick = function() {
        const modal = document.getElementById('bubbleFormModal');
        modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
    };

    document.getElementById('attachmentFileField').onchange = function() {
        if(this.files.length > 0) {
            document.getElementById('fileSelectedFeedback').innerText = 'Selected: ' + this.files[0].name;
        }
    };

    document.getElementById('bubbleAsyncForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('bubbleSubmitTrigger');
        const feedback = document.getElementById('bubbleOperationFeedback');
        
        submitBtn.disabled = true;
        submitBtn.innerText = 'Submitting ticket...';
        feedback.innerText = '';

        const formData = new FormData(this);
        const tokenInput = this.querySelector('input[name="_token"]');
        const tokenValue = tokenInput ? tokenInput.value : '';

        try {
            const response = await fetch('{{ route("supportBubble.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': tokenValue,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            if (response.ok && data.success) {
                feedback.className = 'text-success-custom';
                feedback.innerText = data.message;
                this.reset();
                document.getElementById('fileSelectedFeedback').innerText = '';
                setTimeout(() => {
                    document.getElementById('bubbleFormModal').style.display = 'none';
                    feedback.innerText = '';
                }, 2500);
            } else {
                feedback.className = 'text-danger-custom';
                feedback.innerText = data.message || 'Transmission failure.';
            }
        } catch (error) {
            feedback.className = 'text-danger-custom';
            feedback.innerText = 'Network error. Please try again';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Submit Ticket';
        }
    });
</script>