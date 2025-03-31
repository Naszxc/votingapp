<!-- landing-page.php -->
<div>
    Hello, this is the landing page served by PHP!

    <input id="message" placeholder="Type a message..." />
    <button onclick="sendMessage()">Send</button>
</div>

<script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
<script>
    const socket = io("http://localhost:3000");  // Connect to the Socket.IO server

    socket.on("connect", () => {
        console.log("Connected to the server11!");
    });

    socket.on("chat message", (msg) => {
        console.log("Received message:", msg);
    });

    function sendMessage() {
        const message = document.getElementById("message").value;
        if (message) {
            socket.emit("chat message", message);
            document.getElementById("message").value = "";
        }
    }

    socket.on("disconnect", () => {
        console.log("Disconnected from the server");
    });
</script>
