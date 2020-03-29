<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OptiBot</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=poppins" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        body {
            font-family: "poppins", sans-serif;
            margin: 0;
            padding: 0;
            background: white
        }

        .container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .content {
            text-align: center;
        }
        @keyframes slide-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }


    </style>
</head>
<body>
<div class="container">
    <div class="content" id="app">
        <h1>جسر</h1>
    </div>
</div>

<script>
    var botmanWidget = {
        chatServer: '/bot/public/optibot',
        frameEndpoint: '/bot/public/chat',
        mainColor: '#48dbfb',
        sendWidgetOpenedEvent: true,
        headerTextColor: 'white',
        placeholderText: '...اكتب الرد',
        title: 'جسر بوت'
    };
</script>
<script id="botmanWidget" src="/bot/public/js/widget.js"></script>

<script>
// setTimeout(function(){console.log(botmanChatWidget.widget)},2050)
// function appendBtn(text){
//     // console.log(text);
//     // data = "<li data-message-id='"+text.id+ "' class='visitor' ><div class='msg'>" +
//     // "<div><p>Site web vitrine</p></div><div class='time'>03:28</div></div></li>";
//     // d1 = document.getElementsByTagName('ol')[0]
//     // d1.insertAdjacentHTML('beforeend', data);
//     window.botmanChatWidget.say('Hi');
// }
</script>

<script src="/js/app.js"></script>




</body>


 <script>
setTimeout(function(){
     document.getElementById("botmanWidgetRoot").firstChild.style.transition = "all 0.1s ease";  
 }, 500);
</script>
</html>