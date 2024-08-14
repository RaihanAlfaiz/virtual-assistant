<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Assistant</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            max-width: 800px; /* Menambah lebar kontainer agar tidak terlalu sempit */
            margin: 0 auto;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 15px 15px 0 0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        #chat-box {
            height: 400px;
            overflow-y: scroll;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 15px;
        }
        #chat-box p {
            border-radius: 20px;
            padding: 10px 15px;
            display: inline-block;
            max-width: 70%;
            margin-bottom: 10px;
        }
        .text-right p {
            background-color: #007bff;
            color: white;
            float: right;
            clear: both;
        }
        .text-left p {
            background-color: #f1f1f1;
            color: #333;
            float: left;
            clear: both;
        }
        #message {
            border-radius: 20px;
            padding: 10px;
            border: 2px solid #007bff;
        }
        .btn-primary {
            border-radius: 10px 20px 20px 10px;
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 1rem;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 10px rgba(0, 91, 187, 0.5);
        }
        .input-group-text {
            background-color: #007bff;
            color: white;
            border-radius: 20px 0 0 20px;
            border: none;
        }
        .note {
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">Virtual Assistant</div>
            <div class="card-body" id="chat-box">
                @foreach($chats as $chat)
                    <div class="{{ $chat->sender == 'user' ? 'text-right' : 'text-left' }}">
                        <p><strong>{{ ucfirst($chat->sender) }}:</strong> {{ $chat->message }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <form id="chat-form" class="mt-3">
            @csrf
            <div class="input-group">
                <input type="text" id="message" name="message" class="form-control me-2" placeholder="Type your message here..." required>
                <button class="btn btn-primary" type="submit">Send</button>
            </div>
        </form>

        <div class="note mt-3">
            <strong>Note:</strong> You can ask the assistant about various topics such as:
            <ul>
                <li>General inquiries like greetings and introductions (e.g., "Hello", "Who are you")</li>
                <li>Time and date information (e.g., "What is the time?", "What is the date?")</li>
                <li>Weather updates (e.g., "What's the weather like?")</li>
                <li>Programming-related questions (e.g., "How does Laravel work?", "Can you help with JavaScript?")</li>
                <li>Entertainment (e.g., "Tell me a joke", "What's a good movie to watch?")</li>
                <li>Calculations and mathematical queries (e.g., "What’s 5 + 7?")</li>
                <li>Project help (e.g., "I need help with my project")</li>
                <li>Technical topics (e.g., "How does version control work?", "What is Bootstrap?")</li>
                <li>General advice and tips (e.g., "Can you give me some fitness tips?", "What are some good travel destinations?")</li>
                <li>Specific tools and technologies (e.g., "What is SQL?", "How can I use Git?")</li>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#chat-form').on('submit', function(event) {
                event.preventDefault();

                let message = $('#message').val();
                let token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('chats.store') }}",
                    method: "POST",
                    data: {
                        _token: token,
                        message: message
                    },
                    success: function(response) {
                        // Tampilkan pesan pengguna
                        $('#chat-box').append(`<div class="text-right"><p><strong>User:</strong> ${response.user_message}</p></div>`);

                        // Tampilkan balasan asisten
                        $('#chat-box').append(`<div class="text-left"><p><strong>Assistant:</strong> ${response.assistant_message}</p></div>`);

                        // Clear input field
                        $('#message').val('');

                        // Scroll ke bawah
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                    }
                });
            });
        });
    </script>
</body>
</html>
