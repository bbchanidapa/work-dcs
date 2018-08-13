

/*<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
 <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
      var sizeChair = 50,
        widthFoorplan = '',
        heightFoorplan = '',
        bool = '';
    $(document).ready(function(){
      $('#upload').on('click', function() {
        $('.chair').remove();
      });

      $( "#slider-range-min" ).slider({
          range: "min",
          value: 1,
          min: 50,
          max: 100,
          slide: function( event, ui ) {
            $( "#amount" ).val( ui.value+'px.' );
            var count = $( "#slider-range-min" ).slider( "value" ) ;
            sizeChair = ui.value;
            $('.chair').css({'height': sizeChair });
            console.log('size',ui.value);
          }
        });
      $( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ));
      $('#create').on('click', function() {
          bool = 'create';
          console.log(bool);
          checkButton();
      });//on click
      $('#delete').on('click', function() {
        bool = 'delete';
        console.log(bool);
        checkButton();
      });//on click
    });
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
              data = jQuery.parseJSON(data);
              var div = $('#demo');
              widthFoorplan = data.width;
              heightFoorplan = data.height;
        calCoordinate(widthFoorplan,heightFoorplan,data.pathFile);
                $('#storage').html('Save in : '+data.pathFile);
            div.css({'background': 'url('+data.pathFile+') top left no-repeat'});
            div.css({'width': widthFoorplan });
            div.css({'background-size': 'auto 600px ' });

            }).done(function(){

            });//done click
            return false;
        }//Func Submit
        function createChair(){
          $('#demo').on('click', function() {
        var x        = event.clientX - (sizeChair/2),
          y      = event.clientY- (sizeChair/2),
          point    = $('#demo').position(),
          parent = $("#demo"),
          chair    = $('<img class="chair">'),
          fileName = "img/img1.png";

        if ( y > point.top && (x+30) > point.left ){
          if ((x+30)< widthFoorplan && y< heightFoorplan ){
            chair.attr('src',fileName);
            chair.css({'height': sizeChair });
            console.log('X',x,point.left,'Y',y,point.top);
            chair.attr('id','chair-'+x+y);
            chair.css({'position':'absolute'});
            chair.offset({ top: (y-parent.offset().top),left:(x-parent.offset().left) });
            $("#demo").append(chair);

            $( function() {
              var $start = $( "#event-start" ),
                  child  = $("#chair-"+x+y);

              child.draggable({
                containment:"#demo",
                scroll: false,
                drag: function() {
                  var top  = chair.offset().top-parent.offset().top,
                                    left = chair.offset().left-parent.offset().left;
                                    console.log(top,left);
                                    updateCounterStatus( $start, top, left );
                                }
              });

              function updateCounterStatus( $event,updateY,updateX) {
                if ( !$event.hasClass( "ui-state-hover" ) ) {
                  $event.addClass( "ui-state-hover" )
                  .siblings().removeClass("ui-state-hover");
                  chair.attr('data-top',updateY);
                        chair.attr('data-left',updateX);
                }
              }//function
            });

          }//last
        }//if first
      });
        }
        function calCoordinate(widthFoor,heightFoor,pathh){
          var summary = '',
            img = $('<img></img>');
        img.attr('src',pathh);
        img.css({'border':'2px solid #ccc'});
        img.css({'margin-left':'20px'});
        img.css({'margin-right': '20px'});

          if ( heightFoor <= 600 ) {
            summary = 600 / heightFoor;
            img.css({'height':summary*heightFoor});
            img.css({'width':summary*widthFoor});

        heightFoorplan = summary*heightFoor;
        widthFoorplan  = summary*widthFoor;
            $('#test').html(img);
          }else{
            summary = heightFoor / 600;
            img.css({'height':summary*heightFoor});
            img.css({'width':summary*widthFoor});
        heightFoorplan = summary*heightFoor;
        widthFoorplan  = summary*widthFoor;
            $('#test').html(img);
          }
          console.log('cal',summary,heightFoorplan,widthFoorplan);
        }
  </script>
</head>
<body>

  <form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
    <p>
    <label for="amount">Size Chair:</label>
    <input type="text" id="amount" readonly >
    </p>

    <div id="slider-range-min"></div>
    <label id="storage"></label><br>
    <input type="file" name="file" required />
    <input type="submit" value="Upload" id="upload" />
  </form>
  <input type="submit" value="Delete" id="delete" />
  <input type="submit" value="Create" id="create" />
  <div id="border">
      <div id="demo">
      <p class="count"></p>
    </div>
  </div>
  <div id="test">
  </div>

</body>
</html>*/