<style type="text/css">
    *{
        margin: 0;
        padding: 0;
    }
    #message{
        height: 300px;
        overflow-y: scroll;
        padding: 10px;
        padding: 10px;
    }
    .left{
        width:20%;
        float: left;
        background: #5b345e;
        padding: 10px;
        box-sizing: border-box;
    }
    .right{
        width:80%;
        float: right;
        padding: 10px;
        box-sizing: border-box;
    }
    .user{
        padding: 5px;
        cursor: pointer;
        color: #fff;
        font-weight: bold;
    }
    .user:hover{
        background: #410546;
    }
    .msg{
        margin-bottom: 10px;
    }
    .uname{
        font-size: 20px;
    }
</style>
<div class="left">
@foreach($Users as $User)
    <div class="user" data-uname="{{ $User->name }}">{{ $User->name }}</div>
@endforeach
</div>
<div class="right">
    <div id='message'>
        @foreach($Messages as $Message)
            <div class="msg"><div><strong class="uname">{{ $Message->user_name }} </strong></div><span>{{ $Message->message }}</span></div>
        @endforeach
    </div>
    <form id="chat-form">
        @csrf
        <textarea id="textMsg" placeholder="Type a message" rows="5"></textarea>
        <br>
        <input type="button" id="send" value="Send">
    </form>

</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>

<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script>
    $(function () {
        $('#message').scrollTop($('#message')[0].scrollHeight);
        var socket = io("http://localhost:7000");


        $("#textMsg").keypress(function (e) {
            if(e.which == 13) {
                e.preventDefault();
                socket.emit('client-send-message', {message: $('#textMsg').val(), user_name: '{{ Auth::user()->name }}'});

                $.ajax({
                    url: '{{ route('chat') }}',
                    type: 'post',
                    data: {_token: $('input[name="_token"]').val(), message: $('#textMsg').val(), user_name: '{{ Auth::user()->name }}'},
                })
                .done(function(res) {
                    // console.log(res);
                });

                $('#textMsg').val('');
            }
        });

        $('.user').click(function(){
            socket.emit('private-client-join-group', $(this).data('uname'));
        });

        socket.on('server-send-message', function(data){
            $('#message').append('<div class="msg"><div><strong class="uname">' + data.user_name + '</strong></div>' + '<span>' + data.message + '</span></div>');
            $('#message').scrollTop($('#message')[0].scrollHeight);
        });

        socket.on('private-server-join-group', function(data) {
            console.log(data);
        })
    });
</script>
