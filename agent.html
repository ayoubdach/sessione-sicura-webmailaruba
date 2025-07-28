<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <title>Aruba - Pannello Operatore</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .agent-container {
      background: #fff;
      width: 100%;
      max-width: 500px;
      height: 90vh;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .agent-header {
      background: #0071ce;
      color: white;
      padding: 16px;
      font-weight: bold;
      text-align: center;
    }

    .session-select {
      padding: 10px;
      background: #f0f0f0;
      border-bottom: 1px solid #ddd;
    }

    .chat-messages {
      flex: 1;
      padding: 16px;
      overflow-y: auto;
      background: #fefefe;
      display: flex;
      flex-direction: column;
    }

    .message {
      margin: 10px 0;
      padding: 10px 14px;
      border-radius: 8px;
      max-width: 80%;
      font-size: 15px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      white-space: pre-line;
    }

    .user {
      align-self: flex-start;
      background: #eee;
    }

    .agent {
      align-self: flex-end;
      background: #0071ce;
      color: white;
    }

    .system {
      align-self: center;
      background: #fff7e6;
      color: #333;
      border: 1px solid #ffd699;
    }

    .chat-input {
      display: flex;
      border-top: 1px solid #ddd;
    }

    .chat-input input {
      flex: 1;
      padding: 14px;
      border: none;
      font-size: 16px;
    }

    .chat-input button {
      background: #f36f21;
      color: white;
      border: none;
      padding: 0 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="agent-container">
    <div class="agent-header">Pannello Operatore Aruba</div>

    <div class="session-select">
      🧑‍💻 Seleziona sessione cliente:
      <select id="sessionSelect" onchange="loadMessages()">
        <option>— Nessuna sessione selezionata —</option>
      </select>
    </div>

    <div class="chat-messages" id="chatMessages"></div>

    <div class="chat-input">
      <input type="text" id="messageInput" placeholder="Scrivi un messaggio..." />
      <button onclick="sendMessage()">Invia</button>
    </div>
  </div>

  <!-- Firebase SDKs -->
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>

  <script>
    const firebaseConfig = {
      apiKey: "AIzaSyCkR1YE5NHChrEtP_5SPNjPEoh6qfMuXJQ",
      authDomain: "aruba-live.firebaseapp.com",
      projectId: "aruba-live",
      storageBucket: "aruba-live.firebasestorage.app",
      messagingSenderId: "780484186354",
      appId: "1:780484186354:web:715d9afd3862d66e31806b"
    };

    firebase.initializeApp(firebaseConfig);
    const db = firebase.firestore();

    const agentName = "Agente Antonio";

    const sessionSelect = document.getElementById("sessionSelect");
    const chatMessages = document.getElementById("chatMessages");
    const messageInput = document.getElementById("messageInput");

    let currentSessionId = null;
    let unsubscribe = null;

    function loadSessionList() {
      db.collection("sessions").orderBy("createdAt", "desc").get().then(snapshot => {
        const previous = sessionSelect.value;
        sessionSelect.innerHTML = '<option>— Nessuna sessione selezionata —</option>';
        snapshot.forEach(doc => {
          const id = doc.id;
          const opt = document.createElement("option");
          opt.value = id;
          opt.textContent = id;
          sessionSelect.appendChild(opt);
        });
        if ([...sessionSelect.options].some(o => o.value === previous)) {
          sessionSelect.value = previous;
        }
      });
    }

    loadSessionList();
    setInterval(loadSessionList, 10000);

    function loadMessages() {
      if (unsubscribe) unsubscribe();

      const selected = sessionSelect.value;
      if (!selected || selected === "— Nessuna sessione selezionata —") {
        chatMessages.innerHTML = "";
        currentSessionId = null;
        return;
      }

      currentSessionId = selected;

      // 🔍 Show session info (IP, country, etc.)
      db.collection("sessions").doc(currentSessionId).get().then(doc => {
        const data = doc.data();
        const infoBox = document.createElement("div");
        infoBox.className = "message system";
        infoBox.innerHTML = `
          🌍 <b>IP:</b> ${data.ip || "N/A"}<br>
          📍 <b>Nazione:</b> ${data.country || "N/A"}<br>
          💻 <b>User-Agent:</b> <small>${(data.userAgent || "").slice(0, 80)}...</small>
        `;
        chatMessages.innerHTML = "";
        chatMessages.appendChild(infoBox);
      });

      const chatRef = db.collection("sessions").doc(currentSessionId).collection("messages").orderBy("timestamp");

      unsubscribe = chatRef.onSnapshot(snapshot => {
        chatMessages.innerHTML = chatMessages.innerHTML; // preserve infoBox
        snapshot.forEach(doc => {
          const msg = doc.data();
          const div = document.createElement("div");
          div.className = "message " + (msg.sender || "user");
          div.textContent = msg.message;
          chatMessages.appendChild(div);
        });
        chatMessages.scrollTop = chatMessages.scrollHeight;
      });
    }

    function sendMessage() {
      const text = messageInput.value.trim();
      if (!text || !currentSessionId) return;

      db.collection("sessions").doc(currentSessionId).collection("messages").add({
        sender: "agent",
        message: `👨‍💼 ${agentName}: ${text}`,
        timestamp: firebase.firestore.FieldValue.serverTimestamp()
      });

      messageInput.value = '';
    }
  </script>
</body>
</html>
