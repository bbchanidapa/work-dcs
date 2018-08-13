<?php
require_once 'config.php';
include_once 'header.php';


if ($_GET['page']=="login"){


include_once 'login.php';


}
if ($_GET['page']=="register"){

include_once 'register.php';


}
if ($_GET['page']=="member"){


include_once 'member.php';

}





 ?>
