<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sohbet Alanı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <link rel="stylesheet" href="/public/themes/hackathon/home/assets/css/styles.css">
</head>

<body>
    <div class="loading-animation" id="loading-animation" style="display: none;">
        <div class="spinner"></div> Yanıt Bekleniyor...
    </div>

    <?php include 'templates/navbar.php'; ?>

    <div class="container bg-header rounded">
        <div class="header_card text-white p-5 text-center h-100">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo suscipit delectus esse in. Eveniet adipisci atque aperiam laboriosam architecto unde quaerat facere, libero temporibus corporis voluptate quod? Error, eius quod.
        </div>
    </div>
    <?php include 'templates/sidebar.php'; ?>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        hljs.highlightAll();

        $(document).ready(() => {
            $('#send-button').on('click', sendMessage);
            $('#chat-input').on('keypress', (e) => {
                if (e.which === 13) sendMessage();
            });
        });

        function sendMessage() {
            const message = $('#chat-input').val().trim();
            if (!message) return;
            displayMessage("Sen", message, 'user');
            $('#chat-input').val('');
            getAIResponse(message);
        }

        function getAIResponse(userMessage) {
            $('#loading-animation').show();
            $.post('src/Ajax/hackathon/home/AiAjax.php', {
                    message: userMessage
                })
                .done((data) => {
                    const aiMessage = (typeof data === 'object' && data.message) ? data.message : data;
                    displayMessage("Cafer", aiMessage, 'ai');
                })
                .fail((error) => console.error("Hata:", error))
                .always(() => $('#loading-animation').hide());
        }

        function displayMessage(sender, message, messageType) {
            $('#chat-messages').append(`<div class="chat-message ${messageType}"><strong>${sender}:</strong> ${convertMarkdown(message)}</div>`);
            $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
            hljs.highlightAll();
        }

        function convertMarkdown(text) {
            return text
                .replace(/###### (.*?)\n/g, '<h6>$1</h6>')
                .replace(/##### (.*?)\n/g, '<h5>$1</h5>')
                .replace(/#### (.*?)\n/g, '<h4>$1</h4>')
                .replace(/### (.*?)\n/g, '<h3>$1</h3>')
                .replace(/## (.*?)\n/g, '<h2>$1</h2>')
                .replace(/# (.*?)\n/g, '<h1>$1</h1>')
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/```(.*?)```/gs, '<pre><code>$1</code></pre>');
        }
    </script>
</body>

</html>