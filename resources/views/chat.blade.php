<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="{{ asset('css/chatStyle.css') }}">

</head>

<body>
    <!-- partial:index.partial.html -->

    <head>
        <meta charset="UTF-8">
        <title>Chat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body>

        <div class="fabs">
            <div class="chat">
                <div class="chat_header">
                    <div class="chat_option">
                        <div class="header_img">
                            <img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg" />
                        </div>
                        <span id="chat_head">Jane Doe</span>
                        <br> <span class="agent">Agent</span> <span class="online">(Online)</span>
                        <span id="chat_fullscreen_loader" class="chat_fullscreen_loader"><i class="fullscreen zmdi zmdi-window-maximize"></i></span>

                    </div>

                </div>
                <!-- <div class="chat_body chat_login">
        <a id="chat_first_screen" class="fab"><i class="zmdi zmdi-arrow-right"></i></a>
        <p>We make it simple and seamless for businesses and people to talk to each other. Ask us anything</p>
    </div> -->
                <div id="chat_converse" class="chat_conversion chat_converse">
                    <a id="chat_second_screen" class="fab"><i class="zmdi zmdi-arrow-right"></i></a>
                </div>

                <div class="fab_field">
                    <a id="fab_camera" class="fab"><i class="zmdi zmdi-camera"></i></a>
                    <a id="fab_send" class="fab"><i class="zmdi zmdi-mail-send"></i></a>
                    <textarea id="chatSend" name="chat_message" placeholder="Send a message" class="chat_field chat_message"></textarea>
                </div>
            </div>
            <a id="prime" class="fab"><i class="prime zmdi zmdi-comment-outline"></i></a>
        </div>
        <!-- <script src='http://code.jquery.com/jquery-1.11.3.min.js'></script> -->
        <!-- <script src="js/index.js"></script> -->

    </body>
    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="{{ asset('js/chatScript.js') }}"></script>

</body>

</html>