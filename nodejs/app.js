
const { Server } = require("socket.io");
const http = require("http");
const express = require("express");
const path = require("path");
const { exec } = require("child_process");
const app = express();
const server = http.createServer(app);
const io = new Server(server);

app.get("/", (req, res) => {
    const phpFile = path.join(__dirname, "landing-page.php")

    exec(`php ${phpFile}`, (err, stdout, stderr) => {
        res.send(stdout)
    })
})


io.on("connection", (socket) => {
    console.log("A user connected")

    socket.on("chat message", (msg) => {
        io.emit("chat message", "from backend")
    })
})


server.listen(3000, () => {
    console.log("server running on http://localhost:3000")
})