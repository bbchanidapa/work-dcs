<?include('header.php');?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
 
 $.ajax({ 
      url: 'http://10.9.57.4:81/xml/jjj.php',
      type : 'GET',
      dataType: 'json',
      success :function(data){  
      	var text = "";
        var path =  "http://10.9.57.4:81/xml/";
      /*for (i = 0; i < data.length; i++) { */
        for (i = 0; i < 3; i++) { 
       text+= "<div class='col s6 m4 l2'>";
       text+= "<div class='card'>";
       text+= "<div class='card-image waves-effect waves-block waves-light'>";
       text+= "<img class='activator' src='"+path+data[i].img+"' onclick='put()' /></div>";
       text+= "<div class='card-content'>";
       text+= "<span class='card-title activator grey-text text-darken-4'> ";
       text+= data[i].name+"<i class='material-icons right'>more_vert</i></span></div>";
       text+=" <div class='card-reveal'>";
       text+="<span class='card-title grey-text text-darken-4'>";
       text+= data[i].name+"<br>("+data[i].nameth+")<i class='material-icons right'>close</i></span>";
       text+= "<p>"+data[i].plot+"</p> </div></div></div>";
      	 $('div'+'.main').html( text);
        }      
      },
      error :function(data){
        alert(data);
      }
  });
function put() {
    var click, txt;
    click = document.getElementById("img").value;  
    txt = "Input pic";
    document.getElementById("show").innerHTML = txt;
}
</script>
</head>
<body>
<nav>
    <div class="nav-wrapper blue-grey darken-1">
          <a href="#!" class="brand-logo center">XML eiei</a>
          <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          <ul class="left hide-on-med-and-down"></ul>    
    </div>

 </nav> 
<div class="section white">
    <div class="row container">
    <p id="show"></p>
		<div class="main"></div>
</div>
</div>
</body>
</html>
