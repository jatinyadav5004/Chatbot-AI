<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat Bot</title>
<meta charset="utf-8"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    var ws = new WebSocket("ws://localhost:8000");
    // Close socket when window closes
    $(window).on('beforeunload', function(){
       ws.close();
    });
    ws.onerror = function(event) {
        location.reload();
    }
    ws.onmessage = function(event)  { 
        var message_received = event.data;
        chat_add_message(message_received, false);
    };
    // Add a message to the chat history
    function chat_add_message(message, isUser) {
        var class_suffix = isUser ? '_user' : '';
        var html = '\
        <div class="chat_line">\
            <div class="chat_bubble'+class_suffix+'">\
              <div class="chat_triangle'+class_suffix+'"></div>\
                '+message+'\
            </div>\
        </div>\
        ';
        chat_add_html(html);
    }
    // Add HTML to the chat history
    function chat_add_html(html) {
        $("#chat_log").append(html);
        chat_scrolldown();
    }
    // Scrolls the chat history to the bottom
    function chat_scrolldown() {
        $("#chat_log").animate({ scrollTop: $("#chat_log")[0].scrollHeight }, 500);
    }
    // If press ENTER, talk to chat and send message to server
    $(function() {
       $('#chat_input').on('keypress', function(event) {
          if (event.which === 13 && $(this).val() != ""){
             var message = $(this).val();
             $(this).val("");
             chat_add_message(message, true);
             ws.send(message);
          }
       });
    });
</script>
<style>
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }
    body {
		overflow:hidden;
		background-image:linear-gradient(to right,#43e97b,#38f9d7);
		font-family: Helvetica;
		background-size: 1920px 1080px;
    }
    #chat_container {
	
        overflow: hidden;
        border-radius: 15px;
        border: 1px solid black;
        margin: 40px 0px 700px 1000px;
    }
    #chat_log {
        background-color: #F3F76F;
        padding: 10px;
        border-bottom: 1px solid black;
        overflow-y: scroll;
        height: 300px;
        font-size: 26px;
		height: 550px;
    }
    #chat_input_container {
        padding: 10px
		
    }
    #chat_input {
        padding: 2px;
        font-size: 15px;
        width: 100%;
    }
    .chat_line {
        overflow: hidden;
        width: 100%;
        margin: 2px 0 12px 0;
    }
    .chat_triangle, .chat_triangle_user {
        position: absolute;
        top: 0;
        width: 0;
        height: 0;
        border-style: solid;
        left: -18px;
        border-width: 0 18px 13px 0;
        border-color: transparent #ffffff transparent transparent;
    }
    .chat_triangle_user {
        left: auto;
        right: -18px;
        border-width: 13px 18px 0 0;
        border-color: #234b9b transparent transparent transparent;
    }
    .chat_bubble, .chat_bubble_user {
        position: relative;
        float: left;
        background-color: #FFF;
        margin-top: 10px;
        line-height: 35px;
        padding: 10px 25px 10px 25px;
        margin-left: 20px;
        font-size: 15px;
    }
    .chat_bubble_user {
        float: right;
        margin-left: 0px;
        margin-right: 20px;
        background-color: #234b9b;
        color: #FFF;
    }
	



</style>
</head>
<body>




<div id="chat_container">
    <div id="chat_log">
    </div>
    <div id="chat_input_container">
        <div><input id="chat_input" /></div>
    </div>
</div>


</body>
</html>