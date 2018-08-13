<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "indek.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body><center> 
<table width="661" height="84" border="1">
  <tr>
    <th scope="col"><blockquote><a href="bbmain.php">หน้าหลัก</a></blockquote></th>
    <th scope="col"><blockquote><a href="product.php">รายการสินค้า</a></blockquote></th>
    <th scope="col"><blockquote>ตรวจสอบสินค้า</blockquote></th>
  </tr></table></center>
</table>
<p>&nbsp;<a href="<?php echo $logoutAction ?>">Log out</a></p>
<p>*** สินค้าแนะนำ ***</p>
<p>&nbsp;</p>
<form name="form1" method="post" action="buy.php">
 <center> 
   <p>&nbsp;
     &nbsp;
     &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;
     &nbsp;
    &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
   <table width="569" height="492" border="1">
     <tr>
       <th height="346" scope="col"><p><img src="../shop/m43h11b5m03-1.1-white.png" width="258" height="323">
         <label for="se1"></label>
           <select name="se1" >
             <option value="100">1</option>
             <option value="200">2</option>
             <option>3</option>
             <option>4</option>
             <option>5</option>
             <option>6</option>
             <option>7</option>
             <option>8</option>
             <option>9</option>
             <option>10</option>
             <option>11</option>
             <option>12</option>
             <option>13</option>
             <option>14</option>
             <option>15</option>
             <option>16</option>
             <option>17</option>
             <option>18</option>
             <option>19</option>
             <option>20</option>
           </select>
         <p>
            <a href="buy.php?id=1">Buy</a>
        </th>
        </form>
        <form>
       <th scope="col"><p><img src="../shop/O145051.jpg" width="244" height="323">
       <label for="se1"></label>
          <select name="se1" id="se1">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
            <option>13</option>
            <option>14</option>
            <option>15</option>
            <option>16</option>
            <option>17</option>
            <option>18</option>
            <option>19</option>
            <option>20</option>
          </select>
         <p>
           <input type="submit" name="sele1" id="sele1" value="เลือกใส่ตะกร้า">
        </th>
     </tr>
     <tr>
       <th scope="row"><p><img src="../shop/กางเกงยีนส์ปั้มน้ำมันแก๊สโซลีน.jpg" width="194" height="323">       
         <center>
          <label for="se1"></label>
           <select name="se1" id="se1">
             <option>1</option>
             <option>2</option>
             <option>3</option>
             <option>4</option>
             <option>5</option>
             <option>6</option>
             <option>7</option>
             <option>8</option>
             <option>9</option>
             <option>10</option>
             <option>11</option>
             <option>12</option>
             <option>13</option>
             <option>14</option>
             <option>15</option>
             <option>16</option>
             <option>17</option>
             <option>18</option>
             <option>19</option>
             <option>20</option>
           </select>
         <p>
        <input type="submit" name="sele1" id="sele1" value="เลือกใส่ตะกร้า"></p></th>
       <td><p><img src="../shop/Cotton-Twill-Skinnyfit-Chino.jpg" width="223" height="323">         </p>
         <p>
           <center>
           <label for="se2"></label>
           <select name="se2" id="se2">
             <option>1</option>
             <option>2</option>
             <option>3</option>
             <option>4</option>
             <option>5</option>
             <option>6</option>
             <option>7</option>
             <option>8</option>
             <option>9</option>
             <option>10</option>
             <option>11</option>
             <option>12</option>
             <option>13</option>
             <option>14</option>
             <option>15</option>
             <option>16</option>
             <option>17</option>
             <option>18</option>
             <option>19</option>
             <option>20</option>
           </select>
         </p>
         <p>
           <input type="submit" name="sele2" id="sele2" value="เลือกใส่ตะกร้า">
         </p>

   </table>
   <p>
    </p>
   </p>
 </center></form>
</body>
</html>