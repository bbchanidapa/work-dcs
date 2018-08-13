<!doctype html>
<html lang="en">
<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	  <link rel="stylesheet" href="/resources/demos/style.css">
	  <link rel="stylesheet" type="text/css" href="style.css">
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
	   function submitForm() {
            console.log("submit event");
            var formData = new FormData(document.getElementById("fileinfo"));
            formData.append("label", "WEBUPLOAD");
            $.ajax({
				url: "moveFile.php",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false
            }).done(function( data ) {
                console.log( data );
                $('label').html('Path File : '+data);
            	var img = $('<img></img>');
	        	img.attr('src', data);
	        	img.attr('id', 'img-floor-plan');
	        	$('#containment-wrapper').html(img);

            }).done(function(){
            	var sizeImage  = document.querySelector('img');

				$("#img-floor-plan").on('click', function() {
					var widthImage = sizeImage.clientWidth;
					var heightImage= sizeImage.clientHeight;
					var point 	  =$('#img-floor-plan').position();
					var x   	  = event.clientX - 25;
					var y   	  = event.clientY - 25;
					var icon 	  = $("<img></img>");
					var fileImage = "img/img1.png";

					console.log( 'xWeb: ',x,'width: ',widthImage ,'|| yWeb: ',y,'heigh: ',heightImage );

					if ( y > point.top && x > point.left ){
						if ((x +30)< widthImage && (y)< heightImage ){
							icon.attr('src',fileImage);
							icon.css({'height': '50px'});
							icon.attr('id',x+y);
							icon.css({'position':'absolute'});
							icon.offset({ top: y, left: x });
							$("#containment-wrapper").append(icon);
							$( function() {
								$( "#"+(x+y) ).draggable({
								containment:"#img-floor-plan",
								scroll: false
								});
							});
						}
					}
				});
            });//done click
            return false;
        }//Func Submit
  </script>
</head>
<body>
  <form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
        <label>Select a file:</label><br>
        <input type="file" name="file" required />
        <input type="submit" value="Upload" />
    </form>
    <div id="containment-wrapper">
	  <div id="draggable3" class="draggable ui-widget-content">
	    <p>I'm contained within the box</p>
	  </div>
	</div>


</body>
</html>