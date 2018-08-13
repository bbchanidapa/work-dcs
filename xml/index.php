<?
include('header.php');
      $url = "http://192.168.1.3/xml/dom.php";
      $path = "http://192.168.1.3/xml/";
      $parameter = "id=$id";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 );
      $result = curl_exec($ch);
      $str = simplexml_load_string($result);
      curl_close($ch);
?> 
<div class="section white">
    <div class="row container">
<? for ($i=0; $i < 6; $i++) { ?>
 <div class="col s6 m4 l2">
      <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
         <img class="activator" src="<?echo $path.$str->movie[$i]->img;?>" height="30%">
        </div>
        <div class="card-content">
        <span class="card-title activator grey-text text-darken-4"><?=$str->movie[$i]->name;
                ?><i class="material-icons right">more_vert</i></span>
        </div>
        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4"><?=$str->movie[$i]->name;
                ?><br>(
                <?=$str->movie[$i]->nameth;
                ?>)<i class="material-icons right">close</i></span>
           <p><?=$str->movie[$i]->plot;?></p>
        </div>
      </div>
    </div>
<?}?> 
    </div>
</div>

