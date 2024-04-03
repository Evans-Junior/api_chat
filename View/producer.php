<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producer Sender</title>
    <link rel="stylesheet" href="../css/fp.css">
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="title">
<h2>Let's Chat</h2>
    <h1 style="text-align: center;">Producer</h1>
    <a class="find" href="farmer.php">Find Farmers' Chats</a>
    </div>  
      <div class="container">
        <h4 style="text-align: center;">Messages</h4>
        <div id="sent-messages" class="message-container">
            
            <ul id="sent-message-list" class="message-list">
                <!-- Sent messages will be displayed here -->
            </ul>
        </div>
        <form id="message-form" onsubmit="submitForm(event)">
            <!-- <label for="message">Message:</label><br> -->
            <input type="text" id="message" name="message" placeholder="Type your message here" required autofocus><br><br>
            <input type="hidden" id='sender' name="sender" value="Producer">
            <input type="hidden" id='receiver' name="receiver" value="Farmer">
            <input type="hidden" id='sentby' name="sentby" value="Producer">
            <button type="submit">Send</button>
        </form>
    </div>
    <script>

    function submitForm(e) {
        e.preventDefault();
                // e.preventDefault();
                // Serialize form data
                var formData = $('#message-form').serialize();
                console.log(formData);

                // Send AJAX POST request
                $.ajax({
                    url: '../action/send_message.php',
                    type: 'POST',
                    data: formData,
                    // dataType: 'json',
                    success: function(response) {
                        // Handle success response
                        
                                // Check the response text
                    if (response.includes("Message sent successfully")) {
                        getData();
                        $('#message').val('');
                        // Display success message
                        alert("Message sent successfully");
                    } else {
                        // Display error message
                        alert("Error: " + response);
                    }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(xhr.responseText);
                        // Display error message
                        alert('Error sending message. Please try again later.');
                    }
                });
            }


        function getData(){
            // e.preventDefault();
            // AJAX request to get messages from get_Message_fxn.php
            $.ajax({
                url: '../functions/get_Message_fxn.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Clear existing message list
                    $('#sent-message-list').empty();
                    // Populate message list with retrieved messages
                    $.each(response, function(index, message) {
                        // Determine the CSS class based on the sender
                        var messageClass = (message.sender_name === 'Producer') ? 'receiver-message' : 'sender-message';
                        // Append message to message list
                        $('#sent-message-list').append(
                            '<li class="message-item ' + messageClass + '">' +
                                '<span>' + message.message + '</span>' +
                                '<span class="timestamp">' + message.created_at + '</span>' +
                            '</li>'
                        );
                    });
                // Scroll to the bottom of the message container after a short delay
                setTimeout(function() {
                                var messageContainer = document.getElementById('sent-messages');
                                messageContainer.scrollTop = messageContainer.scrollHeight;
                            }, 100);
                },
                error: function(xhr, status, error) {
                    // Display error message if AJAX request fails
                    console.error(xhr.responseText);
                }
            });
        }
        
       
            // Call the getData function when the page loads
            onload = getData();
        
    </script>
</body>
</html>
