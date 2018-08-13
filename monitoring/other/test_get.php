<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<script>
 var url ="https://sheetsu.com/apis/v1.0/a13e035ddef0";
 var count = 0;
$(document).ready(function () {
	var d = ''
    $.ajax({ 
        type: 'GET', 
        url: url,
        data:{data:"get"},
		success:function(data){
			//data = jQuery.parseJSON(data[0]['interface']);
			console.log(data.length)
			//show(data)
		}
    });
	/*function show(data){
		for(var obj = 0; obj<data.length; obj++){
			console.log(data[obj])
			for(var keys in data[obj]){
				//console.log(data[obj])
				console.log(data[obj][keys])
			}
		}
	}*/
});//doc

</script>
<span>b</span>