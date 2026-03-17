<div id="support-bubble">

    <!-- Toggle Button -->
    <button id="bubble-btn">💬</button>

    <!-- Popup Form -->
    <div id="bubble-form">
        <h3>Contact Support</h3>

        <form id="supportForm">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="How can we help?" required></textarea>

            <button type="submit">Submit</button>
        </form>

        <p id="successMsg"></p>
    </div>

</div>

<style>
    #bubble-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #4f46e5;
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
    }

    #bubble-form {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 300px;
        background: #1f2937;
        padding: 15px;
        border-radius: 10px;
        display: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    #bubble-form h3 {
        margin-bottom: 10px;
        color: #fff;
    }

    #bubble-form input,
    #bubble-form textarea {
        width: 100%;
        margin-bottom: 10px;
        padding: 8px;
        border: none;
        border-radius: 5px;
    }

    #bubble-form button {
        width: 100%;
        padding: 10px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #successMsg {
        color: lightgreen;
        margin-top: 5px;
    }
</style>

<script>
    document.getElementById('bubble-btn').onclick = function () {
        let form = document.getElementById('bubble-form');
        form.style.display = form.style.display === 'block' ? 'none' : 'block';
    };

    document.getElementById('supportForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch('/support-bubble', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById('successMsg').innerText = "Message sent!";
                document.getElementById('supportForm').reset();
            })
            .catch(err => {
                document.getElementById('successMsg').innerText = "Error!";
            });
    });
</script>