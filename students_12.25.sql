-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: students
-- ------------------------------------------------------
-- Server version	5.7.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `e8_absentees`
--

DROP TABLE IF EXISTS `e8_absentees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_absentees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `meeting_id` int(10) unsigned NOT NULL,
  `assess_id` int(10) unsigned NOT NULL,
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_absentees`
--

LOCK TABLES `e8_absentees` WRITE;
/*!40000 ALTER TABLE `e8_absentees` DISABLE KEYS */;
/*!40000 ALTER TABLE `e8_absentees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_assess`
--

DROP TABLE IF EXISTS `e8_assess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_assess` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '考核等级',
  `score` int(11) NOT NULL COMMENT '评分',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'examine',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_assess`
--

LOCK TABLES `e8_assess` WRITE;
/*!40000 ALTER TABLE `e8_assess` DISABLE KEYS */;
INSERT INTO `e8_assess` VALUES (1,'优秀',88,'examines','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(2,'良好',78,'examines','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(3,'中等',68,'examines','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(4,'不及格',58,'examines','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(5,'外出',-8,'lates','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(6,'出差',0,'lates','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(7,'病假',-2,'lates','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(8,'事假',-6,'lates','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(9,'其他',-4,'lates','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL);
/*!40000 ALTER TABLE `e8_assess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_colleges`
--

DROP TABLE IF EXISTS `e8_colleges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_colleges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '学院名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_colleges`
--

LOCK TABLES `e8_colleges` WRITE;
/*!40000 ALTER TABLE `e8_colleges` DISABLE KEYS */;
INSERT INTO `e8_colleges` VALUES (1,'化学与材料工程学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(2,'文学与传播学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(3,'生物工程学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(4,'教育学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(5,'电子工程学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(6,'法学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(7,'机械与电气工程学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(8,'马克思主义学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(9,'计算机学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(10,'外国语学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(11,'经济与管理学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(12,'体育学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(13,'金融学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(14,'音乐与舞蹈学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(15,'美术与设计学院','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL);
/*!40000 ALTER TABLE `e8_colleges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_departments`
--

DROP TABLE IF EXISTS `e8_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '对口科室：学生管理、思想教育、学生资助、心理健康、领导交办',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_departments`
--

LOCK TABLES `e8_departments` WRITE;
/*!40000 ALTER TABLE `e8_departments` DISABLE KEYS */;
INSERT INTO `e8_departments` VALUES (1,'学生管理','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(2,'思想教育','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(3,'学生资助','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(4,'心理健康','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(5,'领导交办','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL);
/*!40000 ALTER TABLE `e8_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_meetings`
--

DROP TABLE IF EXISTS `e8_meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_meetings`
--

LOCK TABLES `e8_meetings` WRITE;
/*!40000 ALTER TABLE `e8_meetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `e8_meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_menu_role`
--

DROP TABLE IF EXISTS `e8_menu_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_menu_role` (
  `menu_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`menu_id`,`role_id`),
  KEY `menu_role_role_id_foreign` (`role_id`),
  CONSTRAINT `menu_role_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `e8_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `menu_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `e8_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_menu_role`
--

LOCK TABLES `e8_menu_role` WRITE;
/*!40000 ALTER TABLE `e8_menu_role` DISABLE KEYS */;
INSERT INTO `e8_menu_role` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(1,2),(4,2),(7,2),(8,2),(9,2),(15,2),(17,2),(18,2),(1,3),(4,3),(7,3),(8,3),(9,3),(16,3),(17,3),(18,3);
/*!40000 ALTER TABLE `e8_menu_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_menus`
--

DROP TABLE IF EXISTS `e8_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_nav` tinyint(1) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序字段',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_order_index` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_menus`
--

LOCK TABLES `e8_menus` WRITE;
/*!40000 ALTER TABLE `e8_menus` DISABLE KEYS */;
INSERT INTO `e8_menus` VALUES (1,'任务管理',0,'dashboard','','任务管理',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(2,'任务管理',1,'','task_manage','任务管理',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(3,'创建任务',1,'','add_task','创建任务',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(4,'用户管理',0,'account_box','','用户管理',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(5,'用户列表',4,'','user_lists','用户列表',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(6,'创建用户',4,'','add_user','创建用户',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(7,'更新用户',4,'','user_update','更新用户',0,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(8,'工作通知',0,'message','','工作通知',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(9,'任务通知',8,'','notify','任务通知',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(10,'预置数据',0,'multiline_chart','','预置数据',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(11,'学院名称设置',10,'','colleges','学院名称设置',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(12,'工作类型设置',10,'','work_type','工作类型设置',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(13,'对口科室设置',10,'','department','对口科室设置',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(14,'考核等级设置',10,'','access','考核等级设置',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(15,'任务列表',1,'','tasks_of_college','学院显示的任务列表',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(16,'任务列表',1,'','tasks_of_teacher','老师显示的任务列表',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(17,'会议管理',0,'card_membership','','会议管理',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(18,'会议查询',17,'','cahier_lists','会议查询',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(19,'会议记录',17,'','cahier_create','会议记录',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(20,'任务汇总',0,'bubble_chart','','任务汇总',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(21,'任务汇总',20,'','task_summary','任务汇总',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(22,'图表显示',20,'','echart','图表显示',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(23,'缺勤原因设置',10,'','absence','缺勤原因',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(24,'学期学年设置',10,'','semester','学期学年设置',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(25,'会议考勤',17,'','task_attendance','会议考勤',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47');
/*!40000 ALTER TABLE `e8_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_migrations`
--

DROP TABLE IF EXISTS `e8_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_migrations`
--

LOCK TABLES `e8_migrations` WRITE;
/*!40000 ALTER TABLE `e8_migrations` DISABLE KEYS */;
INSERT INTO `e8_migrations` VALUES (81,'2014_10_12_000000_create_users_table',1),(82,'2014_10_12_100000_create_password_resets_table',1),(83,'2017_07_24_052624_create_departments_table',1),(84,'2017_07_24_053516_create_work_types_table',1),(85,'2017_07_24_054433_create_colleges_table',1),(86,'2017_07_24_054901_create_assess_table',1),(87,'2017_07_24_063626_create_tasks_table',1),(88,'2017_07_24_081654_create_task_progresses_table',1),(89,'2017_07_24_111250_entrust_setup_tables',1),(90,'2017_08_16_161417_create_notifications_table',1),(91,'2017_08_19_183854_create_menus_table',1),(92,'2017_08_20_143727_create_menu_role_table',1),(93,'2017_08_27_201342_create_reminds_table',1),(94,'2017_09_24_092428_create_meetings_table',1),(95,'2017_10_12_111313_create_semesters_table',1),(96,'2017_10_14_171430_create_absentees_table',1);
/*!40000 ALTER TABLE `e8_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_notifications`
--

DROP TABLE IF EXISTS `e8_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` int(10) unsigned NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_notifications`
--

LOCK TABLES `e8_notifications` WRITE;
/*!40000 ALTER TABLE `e8_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `e8_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_password_resets`
--

DROP TABLE IF EXISTS `e8_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_password_resets`
--

LOCK TABLES `e8_password_resets` WRITE;
/*!40000 ALTER TABLE `e8_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `e8_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_permission_role`
--

DROP TABLE IF EXISTS `e8_permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `e8_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `e8_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_permission_role`
--

LOCK TABLES `e8_permission_role` WRITE;
/*!40000 ALTER TABLE `e8_permission_role` DISABLE KEYS */;
INSERT INTO `e8_permission_role` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(5,2);
/*!40000 ALTER TABLE `e8_permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_permissions`
--

DROP TABLE IF EXISTS `e8_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_permissions`
--

LOCK TABLES `e8_permissions` WRITE;
/*!40000 ALTER TABLE `e8_permissions` DISABLE KEYS */;
INSERT INTO `e8_permissions` VALUES (1,'admin.create_task','创建任务','创建任务','2017-12-25 16:40:47','2017-12-25 16:40:47'),(2,'admin.edit_task','修改任务','修改任务','2017-12-25 16:40:47','2017-12-25 16:40:47'),(3,'admin.delete_task','删除任务','删除任务','2017-12-25 16:40:47','2017-12-25 16:40:47'),(4,'admin.forever_delete_task','永久删除任务','永久删除任务','2017-12-25 16:40:47','2017-12-25 16:40:47'),(5,'admin.add_person_liable','分配任务给具体的人','分配任务给具体的人（添加责任人）','2017-12-25 16:40:47','2017-12-25 16:40:47'),(6,'admin.submit_task','提交任务','提交任务','2017-12-25 16:40:47','2017-12-25 16:40:47'),(7,'admin.quality_assessment','质量评价','质量评价（QA）','2017-12-25 16:40:47','2017-12-25 16:40:47'),(8,'admin.audit_task','审核任务','审核任务','2017-12-25 16:40:47','2017-12-25 16:40:47');
/*!40000 ALTER TABLE `e8_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_reminds`
--

DROP TABLE IF EXISTS `e8_reminds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_reminds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `college_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '学院id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reminds_task_id_index` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_reminds`
--

LOCK TABLES `e8_reminds` WRITE;
/*!40000 ALTER TABLE `e8_reminds` DISABLE KEYS */;
/*!40000 ALTER TABLE `e8_reminds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_role_user`
--

DROP TABLE IF EXISTS `e8_role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `e8_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `e8_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_role_user`
--

LOCK TABLES `e8_role_user` WRITE;
/*!40000 ALTER TABLE `e8_role_user` DISABLE KEYS */;
INSERT INTO `e8_role_user` VALUES (1,1),(34,1),(35,1),(36,1),(187,1),(188,1),(189,1),(190,1),(191,1),(192,1),(42,2),(46,2),(49,2),(55,2),(56,2),(65,2),(69,2),(75,2),(77,2),(83,2),(95,2),(96,2),(108,2),(112,2),(120,2),(126,2),(127,2),(134,2),(136,2),(139,2),(153,2),(154,2),(155,2),(158,2),(160,2),(172,2),(179,2),(182,2),(194,2),(197,2),(204,2),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3),(24,3),(25,3),(26,3),(27,3),(28,3),(29,3),(30,3),(31,3),(32,3),(33,3),(37,3),(38,3),(39,3),(40,3),(41,3),(43,3),(44,3),(45,3),(47,3),(48,3),(50,3),(51,3),(52,3),(53,3),(54,3),(57,3),(58,3),(59,3),(60,3),(61,3),(62,3),(63,3),(64,3),(66,3),(67,3),(68,3),(70,3),(71,3),(72,3),(73,3),(74,3),(76,3),(78,3),(79,3),(80,3),(81,3),(82,3),(84,3),(85,3),(86,3),(87,3),(88,3),(89,3),(90,3),(91,3),(92,3),(93,3),(94,3),(97,3),(98,3),(99,3),(100,3),(101,3),(102,3),(103,3),(104,3),(105,3),(106,3),(107,3),(109,3),(110,3),(111,3),(113,3),(114,3),(115,3),(116,3),(117,3),(118,3),(119,3),(121,3),(122,3),(123,3),(124,3),(125,3),(128,3),(129,3),(130,3),(131,3),(132,3),(133,3),(135,3),(137,3),(138,3),(140,3),(141,3),(142,3),(143,3),(144,3),(145,3),(146,3),(147,3),(148,3),(149,3),(150,3),(151,3),(152,3),(156,3),(157,3),(159,3),(161,3),(162,3),(163,3),(164,3),(165,3),(166,3),(167,3),(168,3),(169,3),(170,3),(171,3),(173,3),(174,3),(175,3),(176,3),(177,3),(178,3),(180,3),(181,3),(183,3),(184,3),(185,3),(186,3),(193,3),(195,3),(196,3),(198,3),(199,3),(200,3),(201,3),(202,3),(203,3),(205,3),(206,3);
/*!40000 ALTER TABLE `e8_role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_roles`
--

DROP TABLE IF EXISTS `e8_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_roles`
--

LOCK TABLES `e8_roles` WRITE;
/*!40000 ALTER TABLE `e8_roles` DISABLE KEYS */;
INSERT INTO `e8_roles` VALUES (1,'super_admin','管理员','管理员','2017-12-25 16:40:47','2017-12-25 16:40:47'),(2,'college','学院','学院','2017-12-25 16:40:47','2017-12-25 16:40:47'),(3,'teacher','老师','老师','2017-12-25 16:40:47','2017-12-25 16:40:47');
/*!40000 ALTER TABLE `e8_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_semesters`
--

DROP TABLE IF EXISTS `e8_semesters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_semesters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_semesters`
--

LOCK TABLES `e8_semesters` WRITE;
/*!40000 ALTER TABLE `e8_semesters` DISABLE KEYS */;
INSERT INTO `e8_semesters` VALUES (1,'2016/2017','2016-09-01 00:00:00','2017-07-01 00:00:00',0,0,'2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(2,'第一学期','2016-09-01 00:00:00','2017-02-15 00:00:00',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(3,'第二学期','2017-02-16 00:00:00','2017-07-01 00:00:00',1,0,'2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(4,'2017/2018','2017-09-01 00:00:00','2018-07-01 00:00:00',0,0,'2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(5,'第一学期','2017-09-01 00:00:00','2018-02-15 00:00:00',4,1,'2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(6,'第二学期','2018-02-16 00:00:00','2018-07-01 00:00:00',4,0,'2017-12-25 16:40:47','2017-12-25 16:40:47',NULL);
/*!40000 ALTER TABLE `e8_semesters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_task_progresses`
--

DROP TABLE IF EXISTS `e8_task_progresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_task_progresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL COMMENT '任务id',
  `college_id` int(11) NOT NULL COMMENT '学院id',
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '责任人',
  `assess_id` int(11) DEFAULT NULL COMMENT '考核等级',
  `status` datetime DEFAULT NULL COMMENT '完成状态(完成时间)',
  `quality` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '完成质量',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `delay` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '推迟理由',
  `remind` datetime DEFAULT NULL COMMENT '提醒记录',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_task_progresses`
--

LOCK TABLES `e8_task_progresses` WRITE;
/*!40000 ALTER TABLE `e8_task_progresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `e8_task_progresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_tasks`
--

DROP TABLE IF EXISTS `e8_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '任务标题',
  `detail` text COLLATE utf8mb4_unicode_ci COMMENT '任务详情',
  `work_type_id` int(11) NOT NULL COMMENT '工作类型',
  `department_id` int(11) NOT NULL COMMENT '对口科室',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `status` char(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft' COMMENT '任务状态：publish发布 draft草稿',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_tasks`
--

LOCK TABLES `e8_tasks` WRITE;
/*!40000 ALTER TABLE `e8_tasks` DISABLE KEYS */;
INSERT INTO `e8_tasks` VALUES (1,'会议通知','会议名称：新时代加强大学生党史教育论坛\n\n时        间：2017年12月26日（周二）上午9:00\n\n地        点：知明湖学术报告厅\n\n参会人员：\n\n        1．机关党委部门正、副处级干部，其他部门主要负责人；\n\n        2．二级学院分党委（党总支、直属党支部）书记、副书记。\n\n注意事项：\n\n        1．请准时参会，不得缺席，因故不能到会的请履行书面请假手续；\n\n        2．请参会人员提前五分钟到达会场签到并按席卡入席。',2,2,'2017-12-25 16:48:17','2017-12-25 16:56:40','2017-12-27 00:00:00','draft',NULL);
/*!40000 ALTER TABLE `e8_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_users`
--

DROP TABLE IF EXISTS `e8_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `college_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '学院id',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码',
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) NOT NULL COMMENT '性别 false-男 true-女',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_users`
--

LOCK TABLES `e8_users` WRITE;
/*!40000 ALTER TABLE `e8_users` DISABLE KEYS */;
INSERT INTO `e8_users` VALUES (1,'admin','admin','bshanahan@yahoo.com',NULL,NULL,'images/picture.jpg',0,'$2y$10$m43p2WFd.9zaYGqlxu05yuhfYWFjlNNgBdaSSs7kbWIq51s2yrbxG',NULL,'2017-12-25 16:40:47','2017-12-25 16:40:47'),(2,'102054','张科','test@admin.com','5','13516437001','images/picture.jpg',0,'$2y$10$Kacr/YAdEsnetcX7/TVj.ey7P9sMcPcGnBiY3.JDi/Cl.LUH.By7G',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(3,'113024','张宝','test@admin.com','5',NULL,'images/picture.jpg',1,'$2y$10$P4ezWQquwJB.mY8uxo4GN.eANySQVZOO0ZM.jmhn9mfkfDfvVLcKK',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(4,'302003','岳德良','test@admin.com','5','13956450931','images/picture.jpg',1,'$2y$10$PILpQI1TgRMp13x/xh/LYe4mjsR9iLLBlZ/8/LVJKnDMBJQsqaUjy',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(5,'113021','袁炜','test@admin.com','5',NULL,'images/picture.jpg',1,'$2y$10$4QsId7Rhrd4IREdB.aD0dOzZ24Jf.uVrLQdKHgLcQ/4qyhUuALVsa',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(6,'113015','王守亚','test@admin.com','5','18365203017','images/picture.jpg',0,'$2y$10$dbJ8O7DM9vDexhP6ezshK.sRSRdzW4p.Lg3EKVEAr0Tq4ChpKyT0W',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(7,'102052','刘芳芳','test@admin.com','5','18725541259','images/picture.jpg',0,'$2y$10$bL8jFxUXPLH7IrEU1dJ.b.1jKV9RIzxGI0qOVPdd3Ji.niHZI3x/6',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(8,'113014','李梅艳','test@admin.com','5','18130171721','images/picture.jpg',0,'$2y$10$CoMV0jt7TANveMsN.Y5yKeBxkkB4fcU4AJj/UPdMyPITa//NyG5Uy',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(9,'112021','解萍','test@admin.com','5','13956452262','images/picture.jpg',1,'$2y$10$Dl7hQM8Zr3jELNWix2i2euvzgXI3ZdBJFkqKuGyBGxPTJUpmTQhCy',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(10,'113031','贾文晶','test@admin.com','5',NULL,'images/picture.jpg',0,'$2y$10$zoQdN/hKbAfY8vgigdkKNOlfRnNcF2Vk8nMfMkQy032BlVarbaYPy',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(11,'113002','胡艳丽','test@admin.com','5',NULL,'images/picture.jpg',1,'$2y$10$sBcFK2k3F/LP71kyj7cH2ue.uupHNqCeCJTNBYHqUISe.sIr1mbNe',NULL,'2017-12-25 16:40:56','2017-12-25 16:40:56'),(12,'113006','何明霞','test@admin.com','5','18055425488','images/picture.jpg',0,'$2y$10$CdoWIgbNL.UhQPS3XPrir.tTtB0z0vS7q20uOKFWwzfhTJ5MdO9xu',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(13,'113010','韩业腾','test@admin.com','5','18955492116','images/picture.jpg',1,'$2y$10$4eyx8eYCJ/uSZBCv3lKHqepRa6F3H8E0k2XyGodjcXGuDp9ezupdO',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(14,'113028','伏玉明','test@admin.com','5',NULL,'images/picture.jpg',0,'$2y$10$qKVKMCDFKynGHCW86yR48ex/4GgFX9eHLH/B3kXwDVjzShaCu5GvS',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(15,'104057','张戌','test@admin.com','6','18855456919','images/picture.jpg',0,'$2y$10$V60mR34SYltwqXducNO8Aegf7/EEQbsbkQxJw/AD3/UtSLiQgE8FK',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(16,'104062','姚政宏','test@admin.com','6',NULL,'images/picture.jpg',0,'$2y$10$fMtojF2LsPWHBhk/TFfAuOgKkBjdiqg1o1YJfpWuGxbW6YxjAf2/K',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(17,'104025','夏维奇','test@admin.com','6',NULL,'images/picture.jpg',1,'$2y$10$KZDkfWp49vuuIkAsFDCXWOI508B5Xvor4qMMdLdTdzI1SrVN3QsJu',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(18,'104059','孙秋峰','test@admin.com','6','18705549534','images/picture.jpg',1,'$2y$10$edRZ.9WajOUYD3eSMihzwerJZYtHLQbt5Zr9NSsIle8fHnZDDBEde',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(19,'104043','李锦兰','test@admin.com','6','13637117924','images/picture.jpg',0,'$2y$10$a1I0AnGHoV6xRVB/oAtJK.5ZIGf13yGwAxfzUTIkdenZfpJkW2x4C',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(20,'312004','李家胜','test@admin.com','6',NULL,'images/picture.jpg',1,'$2y$10$xI/wBGNjNzzvZ.70OP4GM..DdzPPUgaDk1zn/Y4G36w6gyNsRT6ty',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(21,'104068','程书松','test@admin.com','6',NULL,'images/picture.jpg',1,'$2y$10$brVWH3eGHVvHGqCTaHLiGeMr3rMd/NEefy9kraap1.e.5SFdBkIQi',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(22,'104064','曹梅','test@admin.com','6',NULL,'images/picture.jpg',0,'$2y$10$aVjX3CAWZcjQP1jq8rDCEOnF1zRvWCKBxBr3BOhJYckupNeOpn4Zm',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(23,'308003','柏瑞平','test@admin.com','6',NULL,'images/picture.jpg',0,'$2y$10$ivFipRSsFCNR/gKJgXi2NOMLXWA4p0AMXMoj9NMCq1CXEiC7h72bS',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(24,'103120','张晓艳','test@admin.com','1','13675542568','images/picture.jpg',0,'$2y$10$y4.6rtruwPERMNFj4yl2kOwnkad7Vwo42djlkBLQCjGz5kH8.Z2Cq',NULL,'2017-12-25 16:40:57','2017-12-25 16:40:57'),(25,'103132','张连凤','test@admin.com','1',NULL,'images/picture.jpg',1,'$2y$10$A/wMisGzfrG96UETVQ844ujp1jZxev4H96Vmd8V3mz/ywxBTMOWiC',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(26,'401037','武刚','test@admin.com','1',NULL,'images/picture.jpg',0,'$2y$10$l1tEDhBmaVsfCJ68FZgH0etrTgZ5tsQpwnNhqlSJrVZvpUJTSRSUm',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(27,'103126','王怀景','test@admin.com','1',NULL,'images/picture.jpg',1,'$2y$10$7MC.pJlyGQ6ZaA2jXrKcq.Mxf3fiP4Blf3wU4mgedExZdm6r2tpPS',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(28,'301008','孙绪凯','test@admin.com','1',NULL,'images/picture.jpg',0,'$2y$10$/kfiOLkYC53k209utpGW8OG6IiIPN.u5/lJX3a69rERUJYR4G9GzO',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(29,'103131','沈婷婷','test@admin.com','1','13805546003','images/picture.jpg',0,'$2y$10$MyPIQQGhpiEPyVHzHSP4Fuk/NhBbFofeW9Wq3AIkOhgWf19d59I22',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(30,'101065','荣介伟','test@admin.com','1',NULL,'images/picture.jpg',1,'$2y$10$/HWvYI95AMKznf3FsdzmP.o2LffQoqsjcPPmmGzxGuIjoGKQmD0fy',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(31,'103041','潘路','test@admin.com','1',NULL,'images/picture.jpg',0,'$2y$10$NeEbw0w6rAvI9HPxSIvyIeR2EXwTfAWvC.fPm0/Es29u0rTgOm99y',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(32,'103112','黄月琴','test@admin.com','1','15855469238','images/picture.jpg',1,'$2y$10$hJVRcXa/0hrYOqmI6qhHpuzyPKhJfPCkg2lWRSfkZhtXuwMKqP0de',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(33,'103133','储玉婷','test@admin.com','1',NULL,'images/picture.jpg',0,'$2y$10$HsIkMlAJOrq5dXHddE8UKuYBFpoFa.aDkj42afyIfyzCLNz7NWn26',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(34,'301030','杨正清','test@admin.com',NULL,NULL,'images/picture.jpg',1,'$2y$10$6ynrC5Hk4bnUuuFb5gXzRutf4TcKr0lhnm7jgvaojU8.q3ciBQta2',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(35,'301036','陈年红','test@admin.com',NULL,NULL,'images/picture.jpg',1,'$2y$10$wO2n4GdEv5/51wAMHe3b7uPcv.cCXZdgMZQQnXdWSfubAKse/DiBK',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(36,'301002','曹杰旺','test@admin.com',NULL,NULL,'images/picture.jpg',1,'$2y$10$Jn8etPjmNTk.fOuR.Djac.I5HQ1hL00zJ/wz3yeb9JYWypHegci4.',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(37,'113033','周全','test@admin.com','7',NULL,'images/picture.jpg',1,'$2y$10$Pm3Qj4gFYclR.L/..q6yXOfEpyhE8FF.8WvojrUaKx9I4dSYeQnDm',NULL,'2017-12-25 16:40:58','2017-12-25 16:40:58'),(38,'113023','张星','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$mYW/TZsIWhNqo4rsAFl1zuMbpiTbrPJ7bjXCXLr7bnqzIxCirdjUO',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(39,'113017','张龙','test@admin.com','7',NULL,'images/picture.jpg',1,'$2y$10$iGhdoESAUEt/uvFT1bSqguB7wz5L/fLJjrOIIBq6Ifs/Y9lyWQ5Gm',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(40,'113020','余亮','test@admin.com','7',NULL,'images/picture.jpg',1,'$2y$10$qDE5En87.IrqWaiUyKimGO7p0zTocGSo9gNWWcXM4JW3zbH39yjSW',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(41,'113022','叶宏','test@admin.com','7',NULL,'images/picture.jpg',1,'$2y$10$Lx7DhevbCq2reBagfuCZOufUVFflc1oo5TRGo5jNOvCX.L5PuYsYG',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(42,'307001','王战修','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$pQnp.9PUM/PVrag87N3tiuuve6PQIJcIYKN4f8ZzgbksI.g3vDjSW',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(43,'113030','王新菊','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$xtCr7/dRMONjZYrR6oR2oeje9TzmSHcv6k2c7bDerswox4mR7eFWG',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(44,'104042','王鹏','test@admin.com','7',NULL,'images/picture.jpg',1,'$2y$10$XcmeHRE2YcLTzFLyhA74v.X55Oc/CSE/BZcCy4uOVB.r1UC/C4.Im',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(45,'113032','王晋','test@admin.com','7',NULL,'images/picture.jpg',1,'$2y$10$pvIokwer1uhgGlNisoo6euUWvK8E.RS/M8Of9GU12pO6gN6oVKfHa',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(46,'308004','唐亮','test@admin.com','7',NULL,'images/picture.jpg',1,'$2y$10$ULe25uELyyCF6tfPbXoB8.6LpiyrXMwW77ZlHhbyLaJu81ZVeLB6e',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(47,'113001','刘团结','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$/u606B/QKwDQOSnvLaKf.uWGzKabv06SuyXY8HHg7oWUjDha6aLA.',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(48,'113005','李振','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$5JTxKKTkl3sVsPsqkzAsd.zOjfSIFjhybn500B2epj3ur.7OBej32',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(49,'112073','李媛','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$jsr9fnkatBTOPot/RN4tsun1RgxEliXlwrCVkZZEcWGQTtts9ZJOy',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(50,'113019','李淑娟','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$vN6M9TziwuUHE/CqeP/GjeuRpKmphmmu/oNKBXhyUrq4enxndLtfG',NULL,'2017-12-25 16:40:59','2017-12-25 16:40:59'),(51,'113034','封居强','test@admin.com','7',NULL,'images/picture.jpg',0,'$2y$10$qo2SLd5eTGMfJbaMHbUKFe/y/TinR84Q/lkLWAKLQuhzho2lpHgia',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(52,'112069','陈洪洪','test@admin.com','7','15395489528','images/picture.jpg',0,'$2y$10$C86EYOk3dZP4GxXCa9rmnOWVb7ekU0HIC0DQqvjwMCNfx7xgq8dPy',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(53,'112035','赵小曼','test@admin.com','9','18005540608','images/picture.jpg',0,'$2y$10$RTFL9UQ9qlYeYEeuzuOMTOwnB0jRIt9DIM6o7KE6fIJymAvxUbrse',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(54,'311009','杨敏','test@admin.com','9',NULL,'images/picture.jpg',1,'$2y$10$47u7caR2o7GHbco9cdGZaergyKtNNi45TasdvjE3poP9HZFUXdx2m',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(55,'110003','许江荣','test@admin.com','9',NULL,'images/picture.jpg',1,'$2y$10$VAvEwE3r5DSZDDYYZ6e.9.XWS54E.3aTwhH5jXE3LFbqZn3DIRExi',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(56,'202049','吴兆文','test@admin.com','9',NULL,'images/picture.jpg',0,'$2y$10$dHULjaxbqPinfuYL37YzoeIoYTRlnoXFM84GYPwvd2ukcZIB7ZBZS',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(57,'112037','闻国才','test@admin.com','9',NULL,'images/picture.jpg',1,'$2y$10$I2wTag3KSFK66DJ6iHz1wuag.uplYis4eskshNIaaHv.jG/f6wRLi',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(58,'112076','史学梅','test@admin.com','9',NULL,'images/picture.jpg',1,'$2y$10$HZhTzPNSAYu6ksQTwOjcd.Zg58lhp4Ya35E.dhPOXR2YUz7dzAP8q',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(59,'112080','刘庆俞','test@admin.com','9',NULL,'images/picture.jpg',1,'$2y$10$cYVm6A6Uir6431RdhU19muhnPlMKd0nZzfwOhBZadBvN.UVh/0MFu',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(60,'112074','李晓燕','test@admin.com','9','13035473177','images/picture.jpg',0,'$2y$10$nrPiGgntehEqFLslxlWNyuRG2RdMBH0tu6tl9jkO1/Jj6mHgAjfza',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(61,'112075','冯笑伟','test@admin.com','9','13035477771','images/picture.jpg',0,'$2y$10$DTJPT0pKBcYiaZnFWfWGKeDjDkVietP2C6zclHzn42b.4hcuK/lim',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(62,'112084','冯辉','test@admin.com','9',NULL,'images/picture.jpg',1,'$2y$10$rOYTDXKwmOxM3tmQzv24XOjhFfURCU.f7V6EvXKh8GbhSbhLWHQOW',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(63,'112078','陈琪','test@admin.com','9',NULL,'images/picture.jpg',0,'$2y$10$EW0YIZmOEXTrQz7VeamIT.z4h4RTJu3ukZPuQ8dgKEe5awDgzmNpS',NULL,'2017-12-25 16:41:00','2017-12-25 16:41:00'),(64,'112079','陈国凯','test@admin.com','9',NULL,'images/picture.jpg',1,'$2y$10$2a/BKR3TCXPR5Lxnv05a7eljUaQMT1mw5qYmsLMusv.Cs3Je2gzlu',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(65,'110023','张丽莉','test@admin.com','4','18130197807','images/picture.jpg',1,'$2y$10$2ZsGkRQWGWywAYCaI0A8SuLzqsHG2TON7SpvOL67k9tf6mHEdHBA2',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(66,'110060','徐湧','test@admin.com','4',NULL,'images/picture.jpg',0,'$2y$10$p1xSm/bai/zSTBIoVxaeauQR25NnXbRfm7dkF/WGsTcfv3E9/eNFS',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(67,'110045','谢小曼','test@admin.com','4','13905540533','images/picture.jpg',0,'$2y$10$GQ8AntjREN92178g1NWWdOmSRILsGB8ORx4QMOw6nN6Hv9PlYShQS',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(68,'110058','王向伟','test@admin.com','4','15856691557','images/picture.jpg',1,'$2y$10$RBGvTkEmKsR6UbHdIuPHuey56iusg.YVDYxxXTQhpOc4f8TCmyuRm',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(69,'106004','孙  振','test@admin.com','4',NULL,'images/picture.jpg',0,'$2y$10$UFGA0fBJiayh.o.NAbQjFuLDavjCS2.HfaxDcjnDY.o9.JEwUcgZS',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(70,'110055','刘庆生','test@admin.com','4','15956686536','images/picture.jpg',0,'$2y$10$dKWTTS9Yb6BzhThs4WhU9.Qp4JYk7LzJeNJ45ClHqDhb38mjgh4lq',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(71,'110020','李志勇','test@admin.com','4',NULL,'images/picture.jpg',1,'$2y$10$BdpdHjcIXA1dX9UzgCsyX.hPYhtuA90LIkuDqsC2vJN7ps0.jM2gG',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(72,'110014','贺尔兴','test@admin.com','4',NULL,'images/picture.jpg',1,'$2y$10$Zdcwf2eqJE6hKsvDUeYgPOEM7Ywbo5gRJDb9oxP4IwhBwFPCL1hpm',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(73,'106097','杜文玲','test@admin.com','4','15955465296','images/picture.jpg',1,'$2y$10$DX2ZGTeDJzZXOwc0CLITS.2.HbZvt1ks2UJcrYMmOoye6Hj59gsmS',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(74,'101042','邹成明','test@admin.com','13',NULL,'images/picture.jpg',0,'$2y$10$ka2StCG0KsOi.DExdWn4CugYUn4QEcDpTQowdkFOkJdDlgp/soojC',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(75,'101040','周洁','test@admin.com','13','13855470240','images/picture.jpg',0,'$2y$10$alvKwvX8IqsyjWgNvD2c8uKyc92HsusUp79Z.HS20uhkTUgOtsnsi',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(76,'101070','占迎竹','test@admin.com','13','13554620795','images/picture.jpg',1,'$2y$10$.GWRFy.sYsZaxzCLJmwnhej4g9/oY1ag3KIL2BlNAl6qPdx32PqV2',NULL,'2017-12-25 16:41:01','2017-12-25 16:41:01'),(77,'112011','吴海波','test@admin.com','13',NULL,'images/picture.jpg',0,'$2y$10$AIME6VJQSOux8467rynzze4.tA49jrVwAVkTmIppB.E9N0Y7a5eNy',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(78,'101073','王如生','test@admin.com','13',NULL,'images/picture.jpg',1,'$2y$10$8HZTAVEorQjsOIVButbE5eewtqV2M0Vjlxq.wQ.X1cN.lFSgD00m.',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(79,'101074','谭东洋','test@admin.com','13',NULL,'images/picture.jpg',0,'$2y$10$sAexkbopRBBxwnHvlIvKKOiwn69lwrBpozScbGxcFslVLLTj/HvbK',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(80,'800030','阙烨','test@admin.com','13','15156620330','images/picture.jpg',1,'$2y$10$Hqfhfw0FuNwUSSc6qRIwEes2QJVcoTZmymf8M/PawpWzIraTXpNjm',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(81,'101030','马小霞','test@admin.com','13',NULL,'images/picture.jpg',1,'$2y$10$mr6z6cGPfK7JY22.5xSY1u9YuVqcdKR3Mefkmmj8tLkjp2JWf7NRi',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(82,'101063','贾媛媛','test@admin.com','13',NULL,'images/picture.jpg',0,'$2y$10$F.NVW/ZrKfJh0uAN.x3aPOePiz9M6dLOcUW7QqQc7H/O.hRcPuice',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(83,'103065','方守志','test@admin.com','13',NULL,'images/picture.jpg',1,'$2y$10$UAyAqmrCECIrCl3tZueeO.I9w3gzDp5bTmbwrYqjNrPayUwaWWrjO',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(84,'101026','杜炜','test@admin.com','13',NULL,'images/picture.jpg',1,'$2y$10$OXlYMMEzXONTtKsHE6Pd2.EqYizwWPo4y6876VUm8SAh1OSjrXOiC',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(85,'101069','蔡佳钰','test@admin.com','13','18355412270','images/picture.jpg',1,'$2y$10$9mZj72ZNH6o8.K0evJ/XtOJ9zXwu.Y1wpfwQNPMxbncsZZJy.xpGW',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(86,'111053','郁晓蓓','test@admin.com','11','18725540751','images/picture.jpg',1,'$2y$10$qYLPB7QwZLN6QBkjOjTqLOQdVUMiGp3OmzYrt8brYWqNza03bio0G',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(87,'111067','杨霞','test@admin.com','11','13956428505','images/picture.jpg',0,'$2y$10$ABN.1KduSN54O66/kc7sfuDp7KFrBANACaInhpwP6GDK/uQKa8yKG',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(88,'101007','吴正飞','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$bkmYwbZAg2khyQoRq6sZdOi186CrtfrGEYDGqisfg79EeDMUAP7zK',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(89,'800017','吴雪晴','test@admin.com','11',NULL,'images/picture.jpg',1,'$2y$10$WPFAfLR4MxCRJgfZysuO1uT6m/knyvorC9HW49BY3mTIWMwAwEo/O',NULL,'2017-12-25 16:41:02','2017-12-25 16:41:02'),(90,'111068','吴传良','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$10iyTxtVj7ZusCyUXAFMSusA53PTaX.SzH1R.J1SA7YOUbDEuvQe6',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(91,'111014','王艳秋','test@admin.com','11',NULL,'images/picture.jpg',1,'$2y$10$ENZzWnwvbKlZMIU/ZbmvkeU4CFdEVfBE69Nqky0N6zQy7HgPck2Eq',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(92,'111077','王晓宇','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$EsxT4Fg.6T6rkMjQI3f/WOKwIVVAYP4eaBi49VLOkgagzM//oPWMW',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(93,'111061','王来娣','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$ILrhsvOkCIHzkyWNIGoShua0oflCcxEXNRn1vaLh/Ei/aZw0RoydS',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(94,'111062','田晓静','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$hSxYVC87XPkScikuvzO9le/kqR0j/kZxTsODIFG.U9bmkpIOraQKe',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(95,'111029','孙德军','test@admin.com','11','13615542285','images/picture.jpg',0,'$2y$10$rIIFrUuJWYTsrKRFT5KL5uPk3.0xmbrv2CEuESL3kA7Pbx.53OZey',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(96,'301009','孙大军','test@admin.com','11','13955463101','images/picture.jpg',1,'$2y$10$hcCElfF99Xx6Jezy8IclPeaRGXq3dPOxxDHo635jaddiU2A4odfyW',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(97,'111072','宋龙飞','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$MUco/riczVIoRMMU4.D9rOw8nQVwXnK1cwepJ24wkdgs5a3anaqxm',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(98,'104045','沈晓霞','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$i/KBlIi6soFcADHK.YQPZu5D/AFgn7BTXAqTGL7ZPC/V7PjKYYKna',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(99,'101072','沈磊','test@admin.com','11',NULL,'images/picture.jpg',1,'$2y$10$adVCsSPmytI6K2GKtSO7TOLOehzWF1icX8qU.XJNhBrxFcuMElCo2',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(100,'111086','裴磊磊','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$oZyKsYekmhiCE/6a.DT7MeROwhSlbwYbBUXpCY/uYQTqopbeLJAe6',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(101,'111085','马铮','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$7PbQjwIymHcXzYpiJXqzROcWd2MHDHFJksU/V8q.f4QgGr2F4KxjO',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(102,'111015','陆雷','test@admin.com','11',NULL,'images/picture.jpg',1,'$2y$10$AgB0FwyVgMaHuLEh/ue15.3zhaHZVVnfXvvXm9f4pzNV05NvV8ZnC',NULL,'2017-12-25 16:41:03','2017-12-25 16:41:03'),(103,'111025','柳明','test@admin.com','11',NULL,'images/picture.jpg',1,'$2y$10$O2g26EehsSfQ0QMz4ee9k.TJE/AP5t5NoZetfLBn4UY7HbVE/Wqou',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(104,'111073','刘庆','test@admin.com','11',NULL,'images/picture.jpg',1,'$2y$10$dVEtcchNeG5Xa2KcknJzie3/1RULoAyrycBZvAgQMt0rHXEYYqcSG',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(105,'111076','李方虎','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$7iZRhIdgCPnoaxFNAxP0He/XwgCPVynJADDVIHg4VSV6Ej5ErFo.q',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(106,'111063','李迪','test@admin.com','11','18255450683','images/picture.jpg',0,'$2y$10$bhMT8uFp8YKrXkgEs/Z1/umwdbhkpUALIclJ8sjt7keA6n2qzaBDq',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(107,'111084','焦振玲','test@admin.com','11',NULL,'images/picture.jpg',1,'$2y$10$8CyL1WQbnb5CkquBrUB33.43YAmD1CMXM0rnVPAYekbko2c5qQwZC',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(108,'111043','霍圣年','test@admin.com','11','13695612778','images/picture.jpg',1,'$2y$10$xwHNJCMQ0dIsEhZZevzbueaxsLQrWa4MySttZRJlbf/MDJ8QauUCC',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(109,'111039','侯东坡','test@admin.com','11','13855492766','images/picture.jpg',0,'$2y$10$HwqbtJ7SFHmJbsrPT7ii1uWTx0bmUrtf.llSyDN2qBdiV59ib6/JW',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(110,'111030','丁三姐','test@admin.com','11','18755474646','images/picture.jpg',0,'$2y$10$QmzqNgbnEmPygZbFl7.V0e2D.jfQQJezZOFtpea5JSNwytUF4OhB2',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(111,'101075','陈婉雪','test@admin.com','11',NULL,'images/picture.jpg',0,'$2y$10$8IJxDtz0zRpcK0vaICMkb..DnJmtOYSu.cSwD6IObUV6ceWZ3oBx6',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(112,'104005','朱冠艾','test@admin.com','8','18955401990','images/picture.jpg',1,'$2y$10$DvOyAW5xQrMCrliXXmWvE.uwVekIJZ1l.cbVAbpGqf7fyGDzxbWsK',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(113,'108040','朱苗苗','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$Wy4hOfYRJPtLD1wmv1YhKOWGL4enKGvSADzrJlxkF88wt.Y.aAWQW',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(114,'108070','朱峻熹','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$XXh9brWNWTX/58x9S0.UO.DLRiK9E.rDKlJs3no/EHij/ICrwMRQu',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(115,'108026','赵金海','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$E8sKvPRMnG2fXgOFkHBSXOd5wGG.A3uWqtYPRqvdIXrKLmGmilWYK',NULL,'2017-12-25 16:41:04','2017-12-25 16:41:04'),(116,'108056','张婕','test@admin.com','15','15956676826','images/picture.jpg',0,'$2y$10$/YPupTvRJj8SlxIR2RxQeug0WxNKTW0ldPFu0Zkkbdcgb5Fi0NCgq',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(117,'108051','徐世超','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$WxBfOZrck/QuUKak5t.MI.79yw/JOT2Fhtx1IGr1HX/vxoGPoz02W',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(118,'108064','温鑫','test@admin.com','15',NULL,'images/picture.jpg',0,'$2y$10$PhUNf0Wp5MfPWcAHZGrwmO2BTdCu/curcfTZG9/ONnnVJ/tYfavXW',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(119,'108029','王利娟','test@admin.com','15',NULL,'images/picture.jpg',0,'$2y$10$o0E/dkp1aubynZG1m2XT7e6eIcsUffrwUEWpTcY5vNdtX8m4j2kvO',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(120,'108005','倪龙娇','test@admin.com','15','13956436854','images/picture.jpg',0,'$2y$10$40TVaIUACwXJcRH4ZfXkT.CrujOX8l5XIf.4VEwgGsMtlKAIY0JDG',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(121,'108038','马广一','test@admin.com','15','13625622998','images/picture.jpg',1,'$2y$10$50FrCZmM/X0..VpYsOK76evM26.KnhNF9NQ9ahrPVkdddsvEmFMby',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(122,'108077','刘蕙质','test@admin.com','15',NULL,'images/picture.jpg',0,'$2y$10$qDI0uZHNr7B/mQWkkVBZG.ItXKTNgQ5oJ2L0ui3GW.d513ZzFkxRW',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(123,'108075','李迎辉','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$jBdP7cqZTZTFL6fPVPJC7u/jyvLiB1ZsgRkwY7Md4kGtd3kVMl2J2',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(124,'108071','李清','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$SU9A2IO1i.Xki.YDPCc/VuYYIte.UqRn9Qpl3HEZzJdwGGM7DBt.a',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(125,'108037','李丽丽','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$.0J82tZe1Bl7FL08lBrXIOX0TI3IXmgOYfX5vjzP4rlBgYFo3/C4K',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(126,'303006','匡熠','test@admin.com','15','13955462782','images/picture.jpg',1,'$2y$10$6gon0JqHY8EHp3.M.MQP1O8LaUO2Q5YmbSoGhcwB38lq6liu9xRrW',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(127,'108034','金灿灿','test@admin.com','15','15357995025','images/picture.jpg',0,'$2y$10$BO.IbQolTdEnUyyrmj8TLemvM8gCWi9FjlUM0rUsQgERGss8s7s8G',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(128,'108032','黄欣凤','test@admin.com','15',NULL,'images/picture.jpg',0,'$2y$10$YDDHeK6dXkM3lnkUS1ynSezTl1HzIOnBWeinxNsrJR/AkFxsFMG.K',NULL,'2017-12-25 16:41:05','2017-12-25 16:41:05'),(129,'108066','胡然然','test@admin.com','15','13696726186','images/picture.jpg',1,'$2y$10$aUg25NwFIrjNqi/NTNPm8ezx1RXRFpE1MMIzXAHFoFeWzYJBkFlGS',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(130,'108072','高异','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$CPOFRQmpsOPnqbr2/HC11OKAEr8.BCe9iSGXOofYt0FBEFHGdbLAO',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(131,'108042','刁秀航','test@admin.com','15',NULL,'images/picture.jpg',1,'$2y$10$c1BKa9aRI2ZNka0F1k3KJ.bfKPkeejjROvhhQ.QrrBpEWQF1qb8nG',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(132,'103049','张际峰','test@admin.com','3',NULL,'images/picture.jpg',0,'$2y$10$9JBsii8n.6Emxxg5idy3ZOk.46zxIxyqeDC3Mm13wpuxLVw4NZFou',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(133,'103085','叶韬','test@admin.com','3',NULL,'images/picture.jpg',1,'$2y$10$MEEmKj2sWVF43H/ZxEl8DuUgppUZncVgR27Fcyi/n49RRZB2BYoP2',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(134,'401021','武以海','test@admin.com','3','13956451051','images/picture.jpg',1,'$2y$10$SupAhzsG8CpMqtGRvYnwXuTOGT5d9e9nkfvaIu7PJJkxHXtqwPFK2',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(135,'103025','王四川','test@admin.com','3',NULL,'images/picture.jpg',0,'$2y$10$dJXOrZqRVzhhzcYpRS90/u3lSyufNXyyCfz.IaMZXQk8ERbMHfTAO',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(136,'103072','邵警清','test@admin.com','3','15956691434','images/picture.jpg',0,'$2y$10$igDI8Cih4lTSu8feBjIBd.//rU/GYGIYVBbb1XsUNnQwVrbdgt5qa',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(137,'103086','缪国鹏','test@admin.com','3',NULL,'images/picture.jpg',1,'$2y$10$pXv8PJzV.VIx5X1ow67fQOMOO28NEexgLIhZ/HQuS.GacblHkz8fG',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(138,'103056','刘玲','test@admin.com','3',NULL,'images/picture.jpg',1,'$2y$10$nAGsVMmV8sBc10x3j4MZpuHCp2xSzo/fGmbG74zkhTJtEB2M6WNbm',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(139,'103098','李钊','test@admin.com','3','13705542329','images/picture.jpg',0,'$2y$10$SATKS4FMMSYK/cRrMZYrR.qxSTq2akIo6XTjUeun9.IA.vyvcbT/K',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(140,'103087','韩娟','test@admin.com','3','18755446799','images/picture.jpg',0,'$2y$10$innuTwEE7A3M6GaE8sFWKeEC7t5bK3bwlJTyAVR4eVRFphc7KoDcO',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(141,'103076','韩会平','test@admin.com','3','18855431728','images/picture.jpg',1,'$2y$10$tMEq0IQk25nNcXMM5TGGH.g2odfnlmlkg1L4Oyeav2/GXpLraPxCK',NULL,'2017-12-25 16:41:06','2017-12-25 16:41:06'),(142,'103053','郭春凤','test@admin.com','3','13866641906','images/picture.jpg',1,'$2y$10$GHEuqIDyNI.xxfUwIbZUceaaLNyKj9tgbrBb81BOXt1ICZTXdvGLy',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(143,'103089','陈志娜','test@admin.com','3',NULL,'images/picture.jpg',0,'$2y$10$Jbu/WqtGWb1JfcksbnHzee.0XSuFQAEryTAE9PRH9hFN7cvJcKW5e',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(144,'103037','陈锦云','test@admin.com','3',NULL,'images/picture.jpg',0,'$2y$10$z04PxwBeN777RPPFhEt6qunSHBiC4O5Ard5qx8DCahCXV8DLmFX/6',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(145,'107071','周利','test@admin.com','12','13345540513','images/picture.jpg',0,'$2y$10$EljDyjn3tHgh/bNZ4dfAGe2y3658XJp3aiypUbxBt0MwzAODqPbOS',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(146,'107060','赵霞','test@admin.com','12',NULL,'images/picture.jpg',0,'$2y$10$NCsEOIJz91Xh/yPSUSlZaeNOhpbiZsN1BAV4pjtHqv3nxcLS37PR6',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(147,'107064','杨大鹏','test@admin.com','12',NULL,'images/picture.jpg',1,'$2y$10$YBCbgBh8g21q8zd39JhyrOaN0WA/EdkJswSXR.9RHoFddUCMeJf8K',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(148,'107066','温爱玲','test@admin.com','12',NULL,'images/picture.jpg',1,'$2y$10$rvGj5FCzvgFhlWiTgzyry.OM9E7nuITUey7UlBb7Zw3f.HjLBOS6i',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(149,'107067','王亮','test@admin.com','12','18963777771','images/picture.jpg',0,'$2y$10$NJPoQnYV2eCBWz7E.vVwa.69myOoEG4k2vJNKqUYyLZLMIg.k3ss6',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(150,'107069','李圆圆','test@admin.com','12',NULL,'images/picture.jpg',1,'$2y$10$5n4IMwdEwWq8acGS1/zaqecY2Ff7w3lBR0qgSXWseuWBDTa97Zo1W',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(151,'107062','李芹','test@admin.com','12','18963777680','images/picture.jpg',0,'$2y$10$AIpr6ROn.SZZ9IHakQjUh.Y9JFTjnU26l6CHD8FGCmJhd/7BOMC/S',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(152,'107033','李兰芳','test@admin.com','12',NULL,'images/picture.jpg',1,'$2y$10$fB7aIXsSVNFyWlptpvF7IOaOSIanJfi7izL.x3elHUEAzUnQe6Yee',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(153,'107005','李 涛','test@admin.com','12','13905546475','images/picture.jpg',0,'$2y$10$F0vZfof5jjB.C2KVN5PdvOJ/kgtzTu0Nenp8V/ibXvAefx23dZpBy',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(154,'104011','黄也亮','test@admin.com','12','13956430210','images/picture.jpg',1,'$2y$10$xAMrzjifVzl9Q8P.WKnwS.e3Ed1XbF7cll96dUBp1dmssepQaOPli',NULL,'2017-12-25 16:41:07','2017-12-25 16:41:07'),(155,'107035','崔健','test@admin.com','12','18963772898','images/picture.jpg',0,'$2y$10$2f0xfpLdy5WNFc0iiY7vf.GceCNq1YB5b94Sdo22lG7fETldG9AMi',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(156,'107053','程园园','test@admin.com','12',NULL,'images/picture.jpg',0,'$2y$10$/02HrMAxVbjD10FMnOaQv.djl/9DYC4vifX42EzoD/rZOCVrV33gS',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(157,'107038','程松','test@admin.com','12',NULL,'images/picture.jpg',0,'$2y$10$A710wv5vOIjS9K9Dsy0ctOFHuD8WIcDVsg9c5wuzNC.3fYtqMRzYy',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(158,'309018','朱国民','test@admin.com','10','13966467387','images/picture.jpg',0,'$2y$10$glWUL3ltI2LPxNLIjHBDK.xPF6s03SggpIi03KUIEADj91TmphtxC',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(159,'106090','赵悦悦','test@admin.com','10','15805542992','images/picture.jpg',1,'$2y$10$MJasRNSHqgPlJ7/iJMwkqedgF6OOLCO/RvSbACBxO6EPV1AQ5AcCi',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(160,'203010','张成要','test@admin.com','10','13955453139','images/picture.jpg',0,'$2y$10$k7voTSFuC9ZT3O.LcRNASe..7whhFuOAAJ6nWRB/6uqEmT./RuXSa',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(161,'106087','杨梅','test@admin.com','10',NULL,'images/picture.jpg',0,'$2y$10$Hx/6zV/tMLl4LHD/g8MQjuJmNehwnAV2yIwB2PnchuStHXeN/Np6K',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(162,'106099','杨灿灿','test@admin.com','10',NULL,'images/picture.jpg',0,'$2y$10$1zQTQnAZIxmypJECIqWfD.v7isKQURCqXrwPgrWi1DyC/je3G3NWy',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(163,'106089','许敏','test@admin.com','10',NULL,'images/picture.jpg',0,'$2y$10$/fKH8M3odauhFsP1v8N1cuZoET94ucdNx7Adsfwqqort1P3lsspJS',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(164,'106076','王婷婷','test@admin.com','10',NULL,'images/picture.jpg',1,'$2y$10$5ZDJ3vw5TJjdk14CPMGcyOI3YsSLR7xCDJck2J.2D5bnWDppSMNHG',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(165,'106096','孙晓梅','test@admin.com','10',NULL,'images/picture.jpg',1,'$2y$10$LpP7ndXbwhX444XX1VMGqeInnfFDV3n29tis.ar8Jyf4K/rRDBwq2',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(166,'106057','孟焱','test@admin.com','10',NULL,'images/picture.jpg',1,'$2y$10$bH8pJS5x6e3ivy0CZMsYzOp5nGBog8es0CKNCShmmzBXAa/oqsno6',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(167,'106094','刘文静','test@admin.com','10',NULL,'images/picture.jpg',0,'$2y$10$Le7xmc/xraIEipGqfLVesOdyFg8Y.xSiw/WxS.O1IsCpu9W3An1wy',NULL,'2017-12-25 16:41:08','2017-12-25 16:41:08'),(168,'106100','凌霄','test@admin.com','10',NULL,'images/picture.jpg',1,'$2y$10$IApjQJYuPD/8YPcq.9I2POX.B6IpTHZVpePMJfjR3fWYgxzQUXFdW',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(169,'106083','李利','test@admin.com','10',NULL,'images/picture.jpg',1,'$2y$10$TYj5nDdckazE6N9xsnlKSeNaU3Ep0Fiiq3XSF.ZpHpI.enkaEtirS',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(170,'106029','侯越玥','test@admin.com','10',NULL,'images/picture.jpg',0,'$2y$10$a4YedqOQNXsc5MEbK5vYwOXplcdMxOYpMVwPGnBs9ZnowDhNcNbPG',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(171,'106101','韩睿可','test@admin.com','10','18225549026','images/picture.jpg',0,'$2y$10$Wj5DEo7TjA96BoL5wmLdhuYDFbNF1dct.YjTeOQ0mY8qUxQY2d1By',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(172,'106079','郭允兵','test@admin.com','10','15105542916','images/picture.jpg',0,'$2y$10$piwNYwgTtWQwWjUzIx7xVegG..RC9.lpiXjnmDeVIYOi5FiNjGgCm',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(173,'106093','柴茂','test@admin.com','10',NULL,'images/picture.jpg',1,'$2y$10$2DcpvZ4mCbC8W4gjRVxmQOCupXtX7bMv9aDaIbw2.TUW2OopPSzAW',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(174,'106080','安娜','test@admin.com','10',NULL,'images/picture.jpg',0,'$2y$10$XRgEPCx.ReMIjFBOsgFelOk2dx8Msln2WLXkEOsif8gdofcLJW8RK',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(175,'105067','周丽川','test@admin.com','2',NULL,'images/picture.jpg',0,'$2y$10$TZMFN6.G4cAUr1tqLID8cels3.2J.KVdgpJ4zn7.v6gAveM.WcvMa',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(176,'105068','张贤','test@admin.com','2','18255416282','images/picture.jpg',0,'$2y$10$2rpw41/15DAqk6p3LXJ6Y.IFYHNRgg9zXgk.xBugHPREVnzH4y53y',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(177,'105064','张任','test@admin.com','2',NULL,'images/picture.jpg',1,'$2y$10$WyF1s2VoSqHTNc/njRxJI.BWHVwurA/xgqvV2LWkBO2YekjXBqZ7a',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(178,'108036','徐红','test@admin.com','2',NULL,'images/picture.jpg',1,'$2y$10$.Qu3f9h4NFAJp1dTRhiZC..7J8G8kRXX34L/kjRpfEf6sbOkWvXJy',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(179,'111038','徐峰','test@admin.com','2','13955466508','images/picture.jpg',1,'$2y$10$/N/dCp/nfrIlurUU37x0Hugq34L76fZJiR5obLzmEEqPk4WXouH5y',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(180,'108069','孙世波','test@admin.com','2',NULL,'images/picture.jpg',0,'$2y$10$OgeffINqNZSzWoYtvYzp..aTdTQ.3DzX2YKhrW9xbsxL.GhZX8hKK',NULL,'2017-12-25 16:41:09','2017-12-25 16:41:09'),(181,'105052','卢伟','test@admin.com','2',NULL,'images/picture.jpg',1,'$2y$10$0o.mFjbERwfCXSND90pvvecTC4XIDriHBZSXkkEo/tnPC2DVHl9Nm',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(182,'105058','李海燕','test@admin.com','2','13855407967','images/picture.jpg',0,'$2y$10$hiVJtQhfdTRWRoY8mCQGjezwhYs7wGD6x6nZ7J8.6PKcf48uaUPRK',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(183,'108052','洪亮','test@admin.com','2','15212662517','images/picture.jpg',1,'$2y$10$xwZepO2sPItAW3DTh7gU..KspwC/t4jpVvXygQw4W5NgYvee3PcJ6',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(184,'105062','付婕','test@admin.com','2','13855429115','images/picture.jpg',1,'$2y$10$o61JnAnlU09T14Pj0pSFbeowW39wbgVL3NCfk4feqQI8LlvobuVJa',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(185,'108041','邓玉娟','test@admin.com','2',NULL,'images/picture.jpg',0,'$2y$10$wN/kKkKLjhZeTPwNCzhRnOvFU1.Ptc9OzsoMrH1CAHVzgGnj8ZtAq',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(186,'105070','毕倩茹','test@admin.com','2',NULL,'images/picture.jpg',0,'$2y$10$riFjudXj9tNYFgPLLyPylOBjkMhlIf6zFjkk739TDriS0RpDim0V2',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(187,'103113','郑东辉','test@admin.com',NULL,'13516435223','images/picture.jpg',1,'$2y$10$zUZSDK2O27Dr4b3qqxLvF.6LjYDlxgvFIAbqKBs05XOORGQsYt9Nu',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(188,'110044','王刚','test@admin.com',NULL,'15055918675','images/picture.jpg',1,'$2y$10$4DLlqbI4N.8HdR/rwBm3ie75iGsC8T0gINTKTNPV.m7dOLVRV5OqW',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(189,'110004','欧阳儒阳','test@admin.com',NULL,'13956421252','images/picture.jpg',1,'$2y$10$BODRD2LzbMKwST5I1T/.QewpjTvMvWR89SW9UfmqOkuTSjVNH/Oou',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(190,'316002','单杰','test@admin.com',NULL,'13955437755','images/picture.jpg',1,'$2y$10$2vS5WZBRY4FXLmMGUMaRVu1H1VFJsbvQqisZME9qLm34SsPmasQDa',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(191,'311004','程业红','test@admin.com',NULL,'13033073019','images/picture.jpg',1,'$2y$10$hJM2SCCK5oVknFG2oaVuJu2dRJiX1oGpRjz5P56LrmVEITyfkjSEO',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(192,'311011','包寒','test@admin.com',NULL,NULL,'images/picture.jpg',1,'$2y$10$eorkSee4lHo4VmFFmo5/nOdBHFbiqj05doC4taYFlSmArlosrCy0O',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(193,'109024','朱绍庚','test@admin.com','14',NULL,'images/picture.jpg',1,'$2y$10$61lz8PO8TiG9yGnqkx2RPONRLCIGX4TVUxNRr.OPbUGUUL0yJ8iRC',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(194,'109026','周雪晴','test@admin.com','14','18655480006','images/picture.jpg',1,'$2y$10$buPuUPqABE9Cf/XD1FZb8Ok0HUxZqAf1F9l5EwMQfx2gdctUuVvf.',NULL,'2017-12-25 16:41:10','2017-12-25 16:41:10'),(195,'109029','钟帅','test@admin.com','14',NULL,'images/picture.jpg',1,'$2y$10$wGNu32csGSzh.647MhAui.20bxH7GlQp01P3h9heqVdgOj1r.5Yi.',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(196,'109020','张延','test@admin.com','14',NULL,'images/picture.jpg',1,'$2y$10$YUWqrrdNo1hWxBuWtmlYle9QwjpC/m8MXIh3OIXiMPE7Oopj6UVkq',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(197,'303007','王怀顺','test@admin.com','14','13605549830','images/picture.jpg',0,'$2y$10$U/lEZaoYCCASHKMUgIPtqOZ/7mRvA/9COWb5fhuMI7FC1FG9ys/bS',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(198,'109018','帖玲','test@admin.com','14',NULL,'images/picture.jpg',0,'$2y$10$.B8J0EinkU2hRpXKqXgXSOd0wdkpsVDkTtdPe85hxrxc46S//A32.',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(199,'109051','孙涛','test@admin.com','14',NULL,'images/picture.jpg',0,'$2y$10$YmHDIyjZAY.I8dUgE0qCweC77qZbqkltTcc0eJPfmCShAbyJXFslq',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(200,'800008','侍炜程','test@admin.com','14',NULL,'images/picture.jpg',0,'$2y$10$6Rqlnt/agNKoshaePeKTGueByBQBBpdBvfTRrHEqhfT8l9/SXLJbK',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(201,'109045','冉才','test@admin.com','14',NULL,'images/picture.jpg',0,'$2y$10$ya2vIKpQLwj2i2jq/71dKOXGPXjI9sE6zg5ezIk82FvM1C3mTGJ6i',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(202,'109050','卢浩然','test@admin.com','14','18725542690','images/picture.jpg',0,'$2y$10$TODT4V3F8lZAnPDbZleJS.bdDffG5cGemi3retB.omN3C04qwv2a6',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(203,'109048','林均辰','test@admin.com','14',NULL,'images/picture.jpg',1,'$2y$10$u1vvDH4rsN9lAYqcVAVlL.h7.Ev6FhTENXAhwmX2dNS1p3QXCb.Qi',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(204,'201028','梁仁臣','test@admin.com','14','18055444071','images/picture.jpg',0,'$2y$10$YiAuANCrpS/fHbo1GZG61.t1V53iL2e5QjJsKayHIf3d6KgVBppaa',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(205,'109019','李晓丽','test@admin.com','14',NULL,'images/picture.jpg',1,'$2y$10$JBfOaCYzEHTXe3ap3/Y48u8e8GQ0PtCratHI8zUTQUjv1zhr72o/G',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11'),(206,'109022','李姗姗','test@admin.com','14',NULL,'images/picture.jpg',1,'$2y$10$s1zFd12KrShpM.vAY2mCh.Gwtnei7ssr0Uw3XJSrua1OnclHHqrKi',NULL,'2017-12-25 16:41:11','2017-12-25 16:41:11');
/*!40000 ALTER TABLE `e8_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `e8_work_types`
--

DROP TABLE IF EXISTS `e8_work_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e8_work_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工作类型：重点工作、常规工作、突发工作、其他工作',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `e8_work_types`
--

LOCK TABLES `e8_work_types` WRITE;
/*!40000 ALTER TABLE `e8_work_types` DISABLE KEYS */;
INSERT INTO `e8_work_types` VALUES (1,'重点工作','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(2,'常规工作','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(3,'突发工作','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL),(4,'其他工作','2017-12-25 16:40:47','2017-12-25 16:40:47',NULL);
/*!40000 ALTER TABLE `e8_work_types` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-26  0:57:21
