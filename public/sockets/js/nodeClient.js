var socket = io.connect( 'http://localhost:8080' );

socket.on( 'message', function( data ) {
	var actualContent = $( "#bidprice" ).html();
	var newMsgContent = '<li>' + data.message + '</li>';
	var content = newMsgContent + actualContent;
	
	$( "#messages" ).html( content );
});