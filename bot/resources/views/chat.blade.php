<!doctype html>
<html>
<head>
    <title>BotMan Widget</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/glider.css') }}">
</head>
<body>
<div class="lds-ripple"><div></div><div></div></div>

<script src="{{ asset('js/chat.js') }}"></script>
<script src="{{ asset('js/glider.js') }}"></script>

<script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
    <script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
  <script src="{{ asset('js/arrive.js') }}"></script>

<script>


 function setGlider(){
    new Glider(document.querySelector('.glider'), {
        slidesToShow: 1,
  dots: '#dots',
  arrows: {
    prev: '.glider-prev',
    next: '.glider-next'
  }
  })
 }



  $('.btn').click(function() {
 
    alert('x');
    data = "<li class='visitor' ><div class='msg'>" +
  "<div><p>Site web vitrine</p></div><div class='time'>03:28</div></div></li>";
  $('.chat').append(data);
  });



$(document).arrive('.glider', function(){
    setGlider();
});
$(document).arrive('.btn', function(){
  setTimeout(() => {
    document.getElementById("userText").disabled = true;
  }, 100); 
   $(".btn").parents().eq(2).css('background', 'transparent');
   $(".btn").parents().eq(2).css('text-align', 'right');
   $(".btn").parents().eq(2).children('.time').css('display', 'none');
   $('.btn').parent().css('margin-left', '30px');
});
$(document).arrive('.chatbot', function(){
  document.getElementById("userText").disabled = false;
  avatar = "<div class='chat_avatar del'>"+
               "<img src='/bot/public/chatbot.PNG'>"+
            "</div>";
            if ($(this).find('.btn').length == 0)
              $(this).append(avatar);         
});


// setTimeout(function () {
// $( "ol.chat" ).append('<li class="indicator"><div class="loading-dots"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></li>');
// }, 500);
// setTimeout(function () {
         
//                 $("ol.chat li .loading-dots").parent().remove();
// }, 2000);

setInterval(function () {
        // check if last message is by visitor. If yes, show indicator
        if($( "ol.chat li:last-child" ).attr('class') ==='visitor')
        {
            $( "ol.chat" ).append('<li class="indicator"><div class="loading-dots"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></li>');
        }
        else
        {
            // if last message is by bot and indicator is shown, then remove indicator from conversation
            if($( "ol.chat li:last-child" ).attr('class') ==='indicator' && $("ol.chat li:nth-last-child(2)").attr('class') ==='chatbot')
                $("ol.chat li .loading-dots").parent().remove();
        }
    }, 10);

    function appendBtn(text){
   
    // data = "<li data-message-id='"+text.id+ "' class='visitor' style='position:relative;'><div class='msg'>" +
    // "<div><p>start</p></div><div class='time'>03:28</div></div></li>";
    // d1 = document.querySelectorAll("li:nth-last-of-type(1)");
    //d1[0].insertAdjacentHTML('afterend', data);
    // div = "<div class='notif'></div>";
    // $('.banner').after(div);
    } 




</script> 

<style>

</style>

</body>
</html>
