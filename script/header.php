<html>
<head>
	<meta charset="UTF-8">
	 <!-- script ของ jquery -->
	  <script src="//code.jquery.com/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
	 <!-- Compiled and minified CSS -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">

	  <!-- Compiled and minified JavaScript -->
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
     <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

	<script type="text/javascript">
	 $(document).ready(function(){
	    $('ul.tabs').tabs();
	  });
	  $(document).ready(function(){
	    $('ul.tabs').tabs('select_tab', 'tab_id');
	  });	
	</script>
</head>



<!--  for (i = 0; i < data.length; i++) { 
      text+= "<div class='col s6 m4 l2'><div class='card'><div class='card-image waves-effect waves-block waves-light'>";
      text+= "<img class='activator' src='"+path+data[i].img+"' height='30%'></div>";
      text+= "<div class='card-content'><span class='card-title activator grey-text text-darken-4'> ";
      text+= data[i].name+"<i class='material-icons right'>more_vert</i></span></div>";
       +"("+data[i].nameth+")"+"</p>";
       text+=" <div class='card-reveal'><span class='card-title grey-text text-darken-4'>"+data[i].name+"<br>("data[i].nameth+")<i class='material-icons right'>close</i></span>";
       text+= "<p>"+data[i].plot+"</p> </div></div></div>";
        $('div'+'.main').html( text);

       }  -->



     