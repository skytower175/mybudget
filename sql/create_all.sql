
drop database if exists `mbb_test`;
CREATE DATABASE `mbb_test` /*!40100 DEFAULT CHARACTER SET utf8 */;

use mbb_test;


CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(45) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `colour` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `content` varchar(2000) DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `username_modified` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(45) DEFAULT NULL,
  `id_disp` varchar(45) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `descr` varchar(300) DEFAULT NULL,
  `unit` varchar(45) DEFAULT NULL,
  `quote` tinyint(1) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `cluster` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `sponsored` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5652 DEFAULT CHARSET=utf8;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_date` datetime DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `descr` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3732 DEFAULT CHARSET=utf8;

CREATE TABLE `wizard_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wizard_question` int(11) DEFAULT NULL,
  `item_id_str` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

CREATE TABLE `wizard_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step_num` int(11) DEFAULT NULL,
  `question` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `step_num_UNIQUE` (`step_num`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


INSERT INTO `category`
(`id`,
`name`,
`image`,
`colour`)
VALUES ('1', 'Assistance with daily life at home in the community, education and at work', 'img/icons/assistance1.png', '67623a'),
('2', 'Transport to access daily activities', 'img/icons/transport2.png', '778484'),
('3', 'Supported independent living', 'img/icons/independent3.png', 'b22430'),
('4', 'Improved daily living skills', 'img/icons/living4.png', 'af1eb6'),
('5', 'Assistive technology', 'img/icons/techAssistance5.png', '455678'),
('6', 'Vehicle modifications', 'img/icons/carMods6.png', 'ae9d5f'),
('7', 'Home modifications', 'img/icons/homeMods7.png', '7ba549'),
('8', 'Improved living arrangements', 'img/icons/living8.png', '4c6aa5'),
('9', 'Increased social and community participation', 'img/icons/social9.png', 'be5358'),
('10', 'Finding and keeping a job', 'img/icons/job10.png', '6f7932'),
('11', 'Improved relationships', 'img/icons/relationships11.png', '881934'),
('12', 'Improved health and wellbeing', 'img/icons/health12.png', '828572'),
('13', 'Improved learning', 'img/icons/learning13.png', '2543b6'),
('14', 'Improved life choices', 'img/icons/lifeChoice14.png', '568ea6');


-- Create a dummy user with username/pass of 'test'
INSERT INTO `account`
(`id`,
`username`,
`password`,
`salt`,
`admin`,
`active`)
VALUES ('2', 'test', 'dc118466a72393651e9012fea81a3e6dc3ad3d794455b489e428b8ea504c7732', 'asdf', '1', '1');



INSERT INTO `content`
(`id`,
`name`,
`description`,
`content`,
`date_modified`,
`username_modified`)
VALUES
('2', 'NDIS Information', 'NDIS information on the instructions page.', '<p>The National Disability Insurance Scheme is government provided income for Australians with a disability. An amount is given to those in need to aid them with their daily needs. For more information&nbsp;<a id=\"linktondis\" href=\"https://www.ndis.gov.au/about-us/what-ndis\">CLICK HERE.</a></p>', NULL, NULL),
('3', 'BP Icon', NULL, '<p>This budget planner is designed for people who have recieved an NDIS budget. It allows users to go through each service provided by the NDIS and select how much of that service is needed. There is also a help wizard that will pre-fill the planner based on a few questions.</p>', NULL, NULL),
('4', 'Instruction Icon', NULL, '<p>This section contains a video displaying all the aspects of this website including how to use the budget planner. There is also a video that has information about the NDIS scheme, and also a Frequently Asked Questions section that contains important information.</p>', NULL, NULL),
('5', 'Contact Icon', NULL, '<p>Visit our contact us section to view our HQ location. We also have provided a contact form that you may fill out with any questions you may have in relation to My Budget Buddy. Please do not hesitate to contact us via phone, displayed in this section.</p>', NULL, NULL),
('6', 'Budget Planner Intro', NULL, '<p>Hello and welcome to our budget planner tool! This tool will provide you with a detailed overview of the services you will be spending your NDIS budget on. To begin, enter the NDIS budget you have been given. You can then go through each catagory and enter the amount of time needed for each service that is essential in your day-to-day life.</p>', NULL, NULL),
('7', 'Contact Information', NULL, '<h4>Head Office</h4>\r\n<p>33 Corporate Drive&nbsp;<br />Cannon Hill, Qld 4170&nbsp;<br />PO Box 3555, Tingalpa, DC Qld 4173</p>\r\n<p>Phone: 1800 112 112</p>', NULL, NULL),
('8', 'Account Page', NULL, NULL, NULL, NULL),
('9', 'Admin Page', NULL, '<p>Welcome to the administrator tools.</p>', NULL, NULL);


