USE u331865616_shum;

DROP TABLE IF EXISTS `checks`;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `checks` (
  `Check_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Student_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Course_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date_of_start` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date_of_end` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date_of_check` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Price` float DEFAULT NULL,
  `Passed` int(1) NOT NULL,
  PRIMARY KEY (`Check_ID`),
  UNIQUE KEY `Car_ID_UNIQUE` (`Check_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


LOCK TABLES `checks` WRITE;

INSERT INTO `checks` VALUES (1,'Клементов Василий Григорьевич','Основы спрея','2021-12-21 12:12','2021-12-21 17:12','2019-06-19',4000.5,1),(2,'Клементов Василий Григорьевич','Основы спрея','2012-12-12 12:12','2012-12-12 17:12','2019-06-19',4000.5,1),(3,'Клементов Василий Григорьевич','Топовый мидер','2012-12-12 12:12','2012-12-12 13:12','2019-06-19',6500.5,0),(4,'Клементов Василий Григорьевич','Топовый мидер','2010-02-12 12:12','2010-02-12 13:12','2019-06-19',6500.5,1),(5,'Клементов Василий Григорьевич','Основы спрея','0000-00-00 00:00','0000-00-00 00:00','2019-06-19',4000.5,3);

UNLOCK TABLES;



DROP TABLE IF EXISTS `courses`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `courses` (
  `Course_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name_of_course` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Type` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cost_of_course` float DEFAULT NULL,
  `Teacher_ID` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Duration` int(10) NOT NULL,
  PRIMARY KEY (`Course_ID`),
  UNIQUE KEY `Course_ID_UNIQUE` (`Course_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



LOCK TABLES `courses` WRITE;

INSERT INTO `courses` VALUES (2,'Топовый мидер ','Персональный',6500.5,'Шварц Владимир Дмитриевич',1),(3,'Вардинг от NSa','Командный',4000.53,'Красинец Зуфар Эдуардович',5),(15,'Основы спрея','Персональный',4000.5,'Красинец Зуфар Эдуардович',5);

UNLOCK TABLES;



DROP TABLE IF EXISTS `schedule`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_type` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `schedule_course_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `schedule_teacher_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `schedule_student_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `schedule_date_of_start` datetime DEFAULT NULL,
  `schedule_date_of_end` datetime DEFAULT NULL,
  `schedule_passed` int(1) DEFAULT NULL,
  PRIMARY KEY (`schedule_id`),
  UNIQUE KEY `schedule_шв_UNIQUE` (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



LOCK TABLES `schedule` WRITE;

INSERT INTO `schedule` VALUES (1,'Персональный','Основы спрея','Красинец Зуфар Эдуардович','Клементов Василий Григорьевич','2021-12-21 12:12:00','2021-12-21 17:12:00',2),(2,'Персональный','Основы спрея','Красинец Зуфар Эдуардович','Клементов Василий Григорьевич','2012-12-12 12:12:00','2012-12-12 17:12:00',2),(3,'Персональный','Топовый мидер','Шварц Владимир Дмитриевич','Клементов Василий Григорьевич','2012-12-12 12:12:00','2012-12-12 13:12:00',2),(4,'Персональный','Топовый мидер','Шварц Владимир Дмитриевич','Клементов Василий Григорьевич','2010-02-12 12:12:00','2010-02-12 13:12:00',2),(5,'Персональный','Основы спрея','Красинец Зуфар Эдуардович','Клементов Василий Григорьевич','0000-00-00 00:00:00','0000-00-00 00:00:00',0);

UNLOCK TABLES;



DROP TABLE IF EXISTS `student`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `student` (
  `Student_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Nickname` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone_Number` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Student_ID`),
  UNIQUE KEY `Email_UNIQUE` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



LOCK TABLES `student` WRITE;

INSERT INTO `student` VALUES (1,'Шумков Владимир Дмитриевич','MiX','Кукуево 15','+7(952) 136-47-25','student@gmail.com'),(2,'Акакий Иван Румынович','Puppey','Столичная 77','+7(892) 431-23-78','student2@gmail.com'),(3,'Даниил Ишутин Акрадьевич','Dendi','Раново 89','+7(893) 121-23-35','student3@gmail.com'),(4,'Трупов Аслам Владимирович','Kuroky','Розы Люксембурга 3','+7(831) 456-32-31','student4@gmail.com'),(5,'Клементов Василий Григорьевич','Funn1k','Столичная 11','+7(831) 251-27-13','student5@gmail.com'),(6,'Алексеев Владислав Афанасьевич','XBOCT','Смирнова 12','+7(967) 452-94-33','student6@gmail.com'),(7,'Белоусов Филипп Романович','Faker','Шварца 22','+7(472) 839-75-68','student7@gmail.com'),(10,'Игнатьев Сава Анатолиевич','SoNNeiKO','Столичная 77','+7(892) 431-23-78','student10@gmail.com'),(14,'Игнатьев Сава Анатолиевич','SoNNeiKO','Столичная 77','+7(892) 431-23-78','student15@gmail.com');

UNLOCK TABLES;



DROP TABLE IF EXISTS `teacher`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `teacher` (
  `Teacher_ID` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Full_Name` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Spec` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone_Number` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Teacher_Email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Full_Name`),
  UNIQUE KEY `Full_Name_UNIQUE` (`Full_Name`),
  UNIQUE KEY `Teacher_Email_UNIQUE` (`Teacher_Email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




LOCK TABLES `teacher` WRITE;

INSERT INTO `teacher` VALUES ('Шварц Владимир Дмитриевич',1,'Dota 2','Родонитовая 26','+7(952) 136-47-53','teacher@gmail.com'),('Красинец Зуфар Эдуардович',2,'Heroes Of The Storm','Крестинского 156','+7(395) 213-64-74','teacher1@gmail.com'),('Цушко Гордей Валерьевич',4,'Counter Strike:GO','Инженерная 27','+7(912) 345-67-87','teacher3@gmail.com'),('Колобов Ждан Аиевич',5,'Dota 2','Инженерная 27','+7(912) 345-67-87','teacher4@gmail.com');

UNLOCK TABLES;



DROP TABLE IF EXISTS `teams`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_spec` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `team_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `team_teacher` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `first_player` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `second_player` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `third_player` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `fourth_player` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `fifth_player` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `team_win` int(11) DEFAULT NULL,
  `team_lose` int(11) DEFAULT NULL,
  `winrate` float DEFAULT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_id_UNIQUE` (`team_id`),
  UNIQUE KEY `team_name_UNIQUE` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


LOCK TABLES `teams` WRITE;

INSERT INTO `teams` VALUES (1,'Dota 2','GambitEsport','Шварц Владимир Дмитриевич','Puppey','XBOCT','Puppey','Kuroky','Faker',300,0,100),(2,'Counter Strike:GO','NaVi','Цушко Гордей Валерьевич','MiX','Funn1k','Puppey','Kuroky','XBOCT',200,100,66.7),(4,'Heroes Of The Storm','VirtusPro','Красинец Зуфар Эдуардович','XBOCT','MiX','Puppey','Kuroky','Dendi',20,1,95.2);

UNLOCK TABLES;



DROP TABLE IF EXISTS `users`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_role` int(1) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `user_login` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_email` varchar(45) NOT NULL,
  `user_disabled` int(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login_UNIQUE` (`user_login`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;




LOCK TABLES `users` WRITE;

INSERT INTO `users` VALUES (1,1,'Повелитель Шварц','admin','admin','admin@gmail.com',0),(2,2,'Шварц Владимир Дмитриевич','teacher','teacher','teacher@gmail.com',0),(3,3,'Клементов Василий Григорьевич','student','student','student@gmail.com',0),(5,3,'Акакий Иван Румынович','student1','student1','student1@gmail.com',0),(6,3,'Даниил Ишутин Акрадьевич','student2','student2','student2@gmail.com',0),(7,3,'Трупов Аслам Владимирович','student3','student3','student3@gmail.com',0),(8,3,'Шумков Владимир Дмитриевич','student4','student4','student4@gmail.com',0),(9,3,'Алексеев Владислав Афанасьевич','student5','student5','student5@gmail.com',0),(11,3,'Белоусов Филипп Романович','student6','student6','student6@gmail.com',0),(15,2,'Колобов Ждан Аиевич','kolobovjdananatolievich','HIuRLBtT','teacher4@gmail.com',0),(18,3,'Игнатьев Сава Анатолиевич','ignatevsavaanatolievich','Eh6xVLMK','student15@gmail.com',0),(19,2,'Цушко Гордей Валерьевич','cushkogordeyvalerevich','QsrrOjEP','teacher5@gmail.com',0);

UNLOCK TABLES;

