-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- โฮสต์: localhost
-- เวลาในการสร้าง: 
-- รุ่นของเซิร์ฟเวอร์: 5.0.51
-- รุ่นของ PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- ฐานข้อมูล: `database`
-- 

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `borrow`
-- 

CREATE TABLE `borrow` (
  `id_bor` int(4) NOT NULL auto_increment,
  `date_bor` varchar(50) NOT NULL,
  `date_return` varchar(50) NOT NULL,
  `price` int(5) NOT NULL,
  `id_movie` int(4) default NULL,
  `username` varchar(255) default NULL,
  PRIMARY KEY  (`id_bor`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

-- 
-- dump ตาราง `borrow`
-- 

INSERT INTO `borrow` VALUES (71, '08-May-2016 04:35:24: am', 'null', 50, 81, 'ambb');
INSERT INTO `borrow` VALUES (70, '08-May-2016 02:38:28: am', '08-May-2016 03:57:43: am', 50, 71, 'ambb');
INSERT INTO `borrow` VALUES (69, '08-May-2016 02:15:07: am', '08-May-2016 03:58:28: am', 50, 68, 'ambb');
INSERT INTO `borrow` VALUES (68, '08-May-2016 02:15:04: am', '08-May-2016 04:00:18: am', 50, 73, 'ambb');
INSERT INTO `borrow` VALUES (67, '08-May-2016 02:15:01: am', '08-May-2016 04:01:34: am', 50, 71, 'ambb');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `customer`
-- 

CREATE TABLE `customer` (
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- dump ตาราง `customer`
-- 

INSERT INTO `customer` VALUES ('2', '2', '2', '2', '2', '2');
INSERT INTO `customer` VALUES ('mark', 'mark', 'bb', '3132', 'mark', '1');
INSERT INTO `customer` VALUES ('b', 'b', 'b', 'b', 'b', 'b');
INSERT INTO `customer` VALUES ('ชนิดาภา', 'วันทนียกุล', 'ambb@hotmail.com', '0982742866', 'borbee', '1234');
INSERT INTO `customer` VALUES ('sirawith', 'sirawith', 'sirawith_mark@hotamil.com', '0828465987', 'mark1212', '1212');
INSERT INTO `customer` VALUES ('chanidapa', 'vantaneyakul', 'ambb_bb@hotmail.com', '0982742866', 'ambb', '1234');

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `movie`
-- 

CREATE TABLE `movie` (
  `id_movie` int(4) NOT NULL auto_increment,
  `name_movie` varchar(255) NOT NULL,
  `time_movie` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_movie`)
) ENGINE=MyISAM  DEFAULT CHARSET=tis620 AUTO_INCREMENT=85 ;

-- 
-- dump ตาราง `movie`
-- 

INSERT INTO `movie` VALUES (71, ' The Jungle Book', '1:56', 'The Jungle Book.jpg', 'The Jungle Book ในรูปแบบ Live Action เล่าเรื่องราวของเมาคลี ทารกที่ถูกสัตว์ป่าเก็บไปเลี้ยง จนเติบโตขึ้น ท่ามกลางการต่อสู้ของสิงสาราสัตว์และแชร์คาน พญาเสือโคร่ง โดยได้ นีล เศรษฐี (Neel Sethi) นักแสดงเด็กหน้าใหม่ของอินเดีย มาเล่นเป็นเมาคลี ตามแบบฉบับบทประ');
INSERT INTO `movie` VALUES (81, 'The Wave ', '1:55', 'The-Wave.jpg', 'สรุปย่อเรื่องราว นอร์เวย์มีภูเขาที่ยังคงเคลื่อนตัวอยู่กว่า 300 แห่ง จนส่งผลให้มีดินถล่มลงไปในฟอร์ดอ่าวแคบๆที่อยู่ระหว่างหน้าผาชัน และเคยเกิดสึนามิที่สร้างความเสียหายร้ายแรงมาแล้วหลายครั้งในอดีตที่ผ่านมา และมันกำลังจะเกิดขึ้นในอีกไม่ช้านี้');
INSERT INTO `movie` VALUES (73, '13 HOURS : THE SECRET SOLDIERS OF BENGHAZI ', '1:58', 'The Secret Soldiers of Benghazi.jpg', 'ผลงานแอ็คชั่นทริลเลอร์เรื่องล่าสุด ซึ่งดัดแปลงจากหนังสือ 13 Hours โดย มิทเชล ซัคคอฟ และเขียนบทโดย ชัค โฮแกน ซึ่งเป็นเรื่องราวของเจ้าหน้าที่ 6 นาย ซึ่งพยายามต่อสู้เพื่อปกป้องรักษาชีวิตของเจ้าหน้าที่ประจำสถานทูตอเมริกัน ในเบนกาซี ประเทศลิเบีย ในปี 2012 ครบร');
INSERT INTO `movie` VALUES (68, 'Bad Neighbors 2', '1:35', 'Bad Neighbors 2.jpg', 'แมค (โรเกน) และ เคลลี่ แรดเนอร์ (เบิร์น) กำลังจะมีลูกคนที่ 2 จึงตัดสินใจขายบ้านและเตรียมจะย้ายไปอยู่ชานเมือง พวกเขาเกือบจะขายบ้านได้แล้ว แต่ความซวยมาเยือนซะก่อน เมื่อบ้านข้าง ๆ กลายเป็นสโมสรนักศึกษาหญิงที่เต็มไปด้วยสาว ๆ สุดแสบ หลุดโลกยิ่งกว่าเท็ดดี้ (เอฟ');
INSERT INTO `movie` VALUES (69, 'Criminal', '1:36', 'Criminal.jpg', 'นักโทษประหารชีวิตกำลังได้รับโอกาสต่อชีวิ?ตของเขาโดยมีข้อแม้ว่าเขาต้องทำการปลูกถ่า?ยสมองของเจ้าหน้าที่ซีไอเอที่เสียชีวิตไปแ?ล้วให้กลายมาเป็นสมองของเขา โดยมีเป้าหมายเพื่อทำภารกิจหยุดผู้ก่อการร?้าย!');
INSERT INTO `movie` VALUES (67, 'Captain America: Civil War กัปตัน อเมริกา : ศึกฮีโร่ระห่ำโลก', '1:44', 'Captain America.jpg', 'เมื่อ สตีฟ โรเจอร์ส ได้นำทีมอเวนเจอร์สทีมใหม่ในการเดินหน้าเพื่อปกป้องมนุษยชาติ หลังจากเหตุการณ์ที่เกิดขึ้นทั่วโลกโดยมีอเวนเจอร์สเข้าไปเกี่ยวข้องได้ส่งผลกระทบต่อเนื่อง ความกดดันทางการเมืองทำให้เกิดระบบตรวจสอบและพิจารณาการทำงานของทีมอเวนเจอร์ส ซึ่งสถานภาพที');
INSERT INTO `movie` VALUES (74, 'HARDCORE HENRY เฮนรี่โคตรฮาร์ดคอร์ (2016)', '1:59', 'Hardcore Henry.jpg', 'ดูหนัง Hardcore Henry เฮนรี่โคตรฮาร์ดคอร์สรุปย่อเรื่องราว สมมุติว่าคุณ (ผู้ชม) คือชายคนหนึ่งที่ตื่นมาโดยจำอะไรไม่ได้ โดยที่เมียของเขา (เฮลีย์ เบ็นเน็ตต์) เล่าระหว่างต่อแขนและขาให้ว่า เพิ่งนำเขากลับมาจากความตาย เธอบอกว่าเขาชื่อ เฮนรี่ แต่ 5 นาทีต่อมา เฮนรี');
INSERT INTO `movie` VALUES (75, 'life เพื่อนผมชื่อเจมส์ ดีน', '1:57', 'life.jpg', 'ภาพยนตร์ที่สร้างจากเรื่องจริงของ เดนนิส สต็อค (รับบทโดย โรเบิร์ต แพททินสัน) ช่างภาพชื่อดังของนิตยสาร LIFE ที่เดินทางไปบ้านเกิดของ เจมส์ ดีน เพื่อทำสัมภาษณ์และถ่ายรูปเพื่อโปรโมตภาพยนตร์ East of Eden ก่อนที่นักแสดงและภาพยนตร์จะกลายเป็นหน้าประวัติศาสตร์ที่สำ');
INSERT INTO `movie` VALUES (76, ' Burnt ', '1:21', 'Burnt.jpg', 'เรื่องย่อ Burnt รสชาติความเป็นเชฟ เชฟ อดัม โจนส์ (แบรดลีย์ คูเปอร์)  เป็นคนที่มีแทบทุกอย่างและสูญสิ้นทุกๆ อย่างมาแล้ว  ในร้านอาหารกลางกรุงปารีส ระดับสองดาวมิชลิน โจนส์มุ่งความสนใจเพียงแค่รสชาติใหม่ๆ ที่เขาปรุงเท่านั้น อาณาจักรของเขาคือห้องครัว และ เป้าหมา');
INSERT INTO `movie` VALUES (77, 'Concussion คนเปลี่ยนเกม', '1:55', 'Concussion.jpg', 'อ่านเรื่องย่อก่อนดูหนัง Concussion (2015) สรุปย่อเรื่องราว วิล สมิธ รับบทเป็นนักวิเคราะห์กีฬา อเมริกา ฟุตบอล ดร.เบนเน็ต อูมาลู ซึ่งเขาเป็นคนแรกที่ค้นพบการทำงานระหว่างสมอง และ ร่างกาย ภายใต้เทคนิคการวางแผนชนิดๆต่าง ซึ่งเขาต้องพิสูจน์มันและพาเอานักกีฬาทุกคน');
INSERT INTO `movie` VALUES (78, 'Batman v Superman: Dawn of Justice แบทแมน ปะทะ ซูเปอร์แมน แสงอรุณแห่งยุติธรรม', '1:52', 'Batman v Superman.jpg', 'ศึกการต่อสู้ระหว่างสองซูเปอร์ฮีโร่ที่ทุกคนรู้จัก ใน Batman v Superman: Dawn of Justice หรือชื่อภาษาไทยว่า แบทแมน ปะทะ ซูเปอร์แมน : แสงอรุณแห่งยุติธรรม\r\n ');
INSERT INTO `movie` VALUES (82, 'wild card ', '1:59', 'wild_card_ver4.jpg', '  การกลับมาครั้งระห่ำสุดของแอ็คชั่นสตาร์แถวหน้าแห่งวงการฮอลลีวูด เจสัน สเตแธม กับโปรเจคภาพยนตร์ที่เขาทุ่มเทเวลาเตรียมการถึง 5 ปี ผลงานการเขียนบทภาพยนตร์ของสุดยอดนักเขียนบทชั้นเซียน เจ้าของ 2 รางวัลออสการ์วิลเลียม โกล์ดแมน !');
INSERT INTO `movie` VALUES (83, 'Deadpool', '1:45', 'deadpool.jpg', 'Deadpool ก็เป็นคอมมิคอีกหนึ่งเรื่องจากฝั่ง Marvel ที่ถูกนำมาดัดแปลงเป็นภาพยนตร์ซูเปอร์ฮี่โร่สายเกรียน (ภาคขยายต่อของ X-Men) ซึ่งมีคิวเข้าฉายอย่างเป็นทางการแล้วในวันที่ 12 กุมภาพันธ์ 2016 ที่จะถึงนี้ โดยการจับมือร่วมกันระหว่าง Marvel Entertainment และ 20th');
INSERT INTO `movie` VALUES (84, 'Deadpool', '1:55', 'img-3.jpg', 'นับจากนี้ถึงช่วงปี 2020 เราคงได้มีโอกาสพบเจอเหล่าซูเปอร์ฮีโร่ทั้งจากฝั่ง Marvel และ DC มาประชันโฉมหน้ากันอย่างไม่ขาดหน้าขาดตา ซึ่งจะเห็นได้ว่าเอาแค่ปัจจุบัน ก็มีข่าวคราวจากหลากหลายคอมมิคเรื่องดังที่ถูกนำมาสร้างเป็นฉบับภาพยนตร์และซีรีย์คนแสดงกันให้คึกครื้น');
