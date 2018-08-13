<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Main</title>
</head>

<body><p>&nbsp;</p>
<p>ลงทะเบียนสมัครสมาชิก</p>
<form name="form1" method="post" action="add.php">
  <p>ชื่อ-นามสกุล&nbsp;&nbsp;
    <label for="name"></label>
    <input type="text" name="name" id="name">
  </p><p>ที่อยู่&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label for="address"></label>
    <textarea name="address" id="address" cols="45" rows="5"></textarea>
  </p>  <p>เบอร์โทรศัพท์&nbsp;
    <label for="tel"></label>
    <input type="text" name="tel" id="tel">
  </p>
  <p>Username&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
    <label for="userN"></label>
    <input type="text" name="userN" id="userN">
  (ใส่ไม่เกิน 15 ตัวอักษร)</p>
  <p>Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
    <label for="pass"></label>
    <input type="password" name="pass" id="pass">
  (ใส่ไม่เกิน 15 ตัวอักษร)  </p>
  <p>
    <input type="submit" name="nsub" id="nsub" value="Submit">
  </p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>