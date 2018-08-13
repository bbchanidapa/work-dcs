meta charset="UTF-8">
<?php  
// ฟังก์ชันสำหรับหา IP Address   
function getIP(){  
    // ตรวจสอบ IP กรณีการใช้งาน share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){  
      $ip=$_SERVER['HTTP_CLIENT_IP'];  
    }else{  
      $ip=$_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  
   
// การเรียกใช้ IP  
$visitorIP = getIP();  
  
// กำหนดรายการ IP ที่ถูกบล็อก กรณีมีจำนวนไม่มาก  
$blockIP=array(  
                    "203.456.54.1",  
                    "127.0.0.1",  
                    "67.65.200.75"  
                );  
                  
// กำหนดรายการ IP ที่ถูกบล็อก กรณีเก็บในไฟล์ blockIP.txt              
// โดยบันทีก IP บรรทัดละ 1 IP     
// การใช้งาน  
// $blockIP=file("blockIP.txt");      
  
// กำหนดรายการ IP ที่ถูกบล็อก กรณีดึงจากฐานข้อมูล  
// การใช้งาน  
//  $q="SELECT blockIP_Address,blockIP_ID FROM  blockIP ORDER BY blockIP_ID ";    
//  $qr=mysql_query($q);  
//  while($rs=mysql_fetch_array($qr)){  
//      $blockIP[$rs['blockIP_Address']]=$rs['blockIP_Address'];  
//  }  
  
// ค้นหา IP ว่าอยู่ในรายการ ที่ถูกบล็อกหรือไม่  
$blockStat = array_search($visitorIP,$blockIP);  
   
// ตรวจสอบว่า IP ถูกบล็อกหรือไม่  
if($blockStat !== false)  
    {  
        echo "IP ของคุณถูกบล็อก"; /// แจ้งการ บล็อก หรือ ข้อความอื่น  
        exit;  
    }  
?>  