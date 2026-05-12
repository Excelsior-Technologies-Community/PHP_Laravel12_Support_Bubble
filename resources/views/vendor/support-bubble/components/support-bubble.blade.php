<div id="support-bubble">

    <!-- BUBBLE BUTTON -->

    <button id="bubble-btn">

        💬

        <span class="notify-dot"></span>

    </button>

    <!-- SUPPORT FORM -->

    <div id="bubble-form">

        <div class="header">

            <h3>Support Center</h3>

            <p>We typically reply within minutes 🚀</p>

        </div>

        <form id="supportForm">

            <input type="text"
                   name="name"
                   placeholder="Enter your name"
                   required>

            <input type="email"
                   name="email"
                   placeholder="Enter your email"
                   required>

            <input type="text"
                   name="subject"
                   placeholder="Subject"
                   required>

            <textarea name="message"
                      placeholder="Write your message..."
                      required></textarea>

            <button type="submit" id="submitBtn">

                Send Message

            </button>

        </form>

        <p id="successMsg"></p>

    </div>

</div>

<style>

    *{
        box-sizing:border-box;
    }

    #bubble-btn{

        position:fixed;

        bottom:25px;

        right:25px;

        width:70px;

        height:70px;

        border:none;

        border-radius:50%;

        background:linear-gradient(135deg,#2563eb,#7c3aed);

        color:white;

        font-size:30px;

        cursor:pointer;

        box-shadow:0 10px 25px rgba(0,0,0,0.4);

        z-index:999;

        transition:0.3s;

        animation:bounce 2s infinite;
    }

    #bubble-btn:hover{

        transform:scale(1.1);
    }

    .notify-dot{

        position:absolute;

        top:10px;

        right:10px;

        width:12px;

        height:12px;

        background:red;

        border-radius:50%;

        border:2px solid white;
    }

    @keyframes bounce{

        0%,100%{
            transform:translateY(0);
        }

        50%{
            transform:translateY(-5px);
        }
    }

    #bubble-form{

        position:fixed;

        bottom:110px;

        right:25px;

        width:370px;

        background:#111827;

        border-radius:20px;

        overflow:hidden;

        display:none;

        z-index:999;

        box-shadow:0 20px 40px rgba(0,0,0,0.5);
    }

    .header{

        background:linear-gradient(135deg,#2563eb,#7c3aed);

        padding:25px;

        color:white;
    }

    .header h3{

        margin-bottom:5px;

        font-size:24px;
    }

    .header p{

        font-size:13px;

        opacity:0.9;
    }

    #supportForm{

        padding:20px;
    }

    #supportForm input,
    #supportForm textarea{

        width:100%;

        margin-bottom:15px;

        padding:14px;

        border:none;

        border-radius:10px;

        background:#1f2937;

        color:white;

        font-size:14px;
    }

    #supportForm textarea{

        height:120px;

        resize:none;
    }

    #supportForm input:focus,
    #supportForm textarea:focus{

        outline:none;

        border:1px solid #2563eb;
    }

    #submitBtn{

        width:100%;

        padding:14px;

        border:none;

        border-radius:10px;

        background:linear-gradient(135deg,#2563eb,#7c3aed);

        color:white;

        font-size:15px;

        cursor:pointer;

        transition:0.3s;
    }

    #submitBtn:hover{

        transform:translateY(-2px);
    }

    #successMsg{

        color:#4ade80;

        text-align:center;

        padding-bottom:15px;

        font-size:14px;
    }

    @media(max-width:500px){

        #bubble-form{

            width:92%;

            right:4%;
        }

    }

</style>

<script>

    const bubbleBtn = document.getElementById('bubble-btn');

    const bubbleForm = document.getElementById('bubble-form');

    const supportForm = document.getElementById('supportForm');

    const successMsg = document.getElementById('successMsg');

    const submitBtn = document.getElementById('submitBtn');

    bubbleBtn.onclick = () => {

        bubbleForm.style.display =
            bubbleForm.style.display === 'block'
            ? 'none'
            : 'block';
    };

    supportForm.addEventListener('submit', function(e){

        e.preventDefault();

        submitBtn.innerText = "Sending...";

        let formData = new FormData(this);

        fetch('/support-bubble',{

            method:'POST',

            headers:{
                'X-CSRF-TOKEN':
                document.querySelector('meta[name="csrf-token"]').content
            },

            body:formData

        })

        .then(response => response.json())

        .then(data => {

            successMsg.innerText = "✅ Message sent successfully!";

            supportForm.reset();

            submitBtn.innerText = "Send Message";

        })

        .catch(error => {

            successMsg.innerText = "❌ Something went wrong!";

            submitBtn.innerText = "Send Message";

        });

    });

</script>