<!DOCTYPE html>
<html>
<head>
    <title>Echo Test</title>
    @vite(['resources/js/app.js'])
</head>
<body>

<h2>Echo Realtime Test</h2>

<p>Open console. Waiting for messages...</p>

<script>
    // 🔹 Put a valid JWT token here (from login)
    localStorage.setItem('token', 'PASTE_RECEIVER_JWT_TOKEN_HERE');

    document.addEventListener('DOMContentLoaded', function () {

        // Wait a bit to ensure Echo is ready
        setTimeout(() => {
            window.Echo.private('chat.2') // <-- change 2 to the receiver user id
                .listen('MessageSent', (e) => {
                    console.log('Message received:', e);
                    alert('New message: ' + e.message);
                });

            console.log('Listening on chat.2');
        }, 1000);

    });
</script>

</body>
</html>
