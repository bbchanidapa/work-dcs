<?
    session_start();
    include('connect.php'); 
    include('navbar.php');   
    $user = $_SESSION['username'];
    
      $update = "UPDATE borrow SET pay = 'yes' WHERE username = '".$user."' ";
      $query = mysql_query($update);

    if (!$query) {
        $message = "ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง";
        echo "<script type='text/javascript'>alert('$message');</script>";
                
    }//if
    else{
    	$_SESSION['total'] = 0;
    	$_SESSION['count_movie'] = 0;
        $message = "ชำระเงินเรียบร้อย";
        echo "<script type='text/javascript'>alert('$message');</script>";  
        echo "<SCRIPT LANGUAGE='JavaScript'>
         window.location.href='member.php';
          </SCRIPT>";
      }   
      
    
?>
  