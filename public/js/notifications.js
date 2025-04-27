let userId = YOUR_LOGGED_IN_USER_ID; // Get this from session

let socket = new WebSocket("ws://localhost:8080/?userId=" + userId);

socket.onmessage = function(event) {
    let data = event.data;
    alert("🔔 New Notification: " + data);
};

socket.onopen = () => console.log("Connected to notification server");
socket.onerror = e => console.error("WebSocket error", e);
