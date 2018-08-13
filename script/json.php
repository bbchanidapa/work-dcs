<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
 
 $.ajax({ 
   //$config['base_url'] = 'http://10.9.57.2:81/xml/';
      url: 'http://10.9.57.2:81/xml/jjj.php',
      type : 'GET',
      dataType: 'json',
      success :function(data){
        var text="" , txt2="";
        for (i = 0; i < data.length; i++) {
         text += data[i].id ;           
            for (j = 0; j < i ; j++) {  
            
             txt2 += data[j].name+data[j].nameth ;
        } 
        
        $('#i').html(text);
        }$('#j').html(txt2);
        
      },
      error :function(data){
        alert(data);
      }

  });

  /* XMLHttpRequest.open("GET","http://10.9.57.2:81/xml/jjj.php",true);*/

</script>
</head>
<body>

<p id="i"></p>
<p id="j"></p>


</body>
</html>
<!--  $.getJSON( url, [data], [callback] )
   }); 
   url: "http://localhost/script/query.json"-->
<!--  $.getJSON( url, [data], [callback] )
   }); 
 <script id="mysrc" type="text/javascript" src="mysrc.js?id=1000"> 
   url: "http://localhost/script/query.json"
   //img = path + data[i].img ;
        /* $('#img'+i).children('img').attr("src",path+data[i].img ;);*/

   -->


   <!-- <p id="id0"></p>
<p id="name0"></p>
<p id="img0"></p>
<p id="plot0"></p>

<p id="id1"></p>
<p id="name1"></p>
<p id="img1"></p>
<p id="plot1"></p>

<p id="id2"></p>
<p id="name2"></p>
<p id="img2"></p>
<p id="plot2"></p>

<p id="id3"></p>
<p id="name3"></p>
<p id="img3"></p>
<p id="plot3"></p>

<p id="id4"></p>
<p id="name4"></p>
<p id="img4"></p>
<p id="plot4"></p>


<p id="id5"></p>
<p id="name5"></p>
<p id="img5"></p>
<p id="plot5"></p>

<p id="id6"></p>
<p id="name6"></p>
<p id="img6"></p>
<p id="plot6"></p>

<p id="id7"></p>
<p id="name7"></p>
<p id="img7"></p>
<p id="plot7"></p>

<p id="id8"></p>
<p id="name8"></p>
<p id="img8"></p>
<p id="plot8"></p>

<p id="id9"></p>
<p id="name9"></p>
<p id="img9"></p>
<p id="plot9"></p>
 -->
<!-- 
  $('#'+i).html(data[i].name+"("+data[i].nameth+")"),
        $('#id'+i).html(data[i].id),
        $('#name'+i).html(data[i].name+"("+data[i].nameth+")"),
        $('#img'+i).html( path+data[i].img),
        $('#plot'+i).html(data[i].plot);
        }       -->