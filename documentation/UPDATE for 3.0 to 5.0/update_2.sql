ALTER TABLE `schools` ADD `language` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `final_result_type`;

ALTER TABLE `sms_settings` ADD `bulk_pk_username` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `betasms_status`, ADD `bulk_pk_password` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `bulk_pk_username`, ADD `bulk_pk_sender_id` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `bulk_pk_password`, ADD `bulk_pk_status` TINYINT(1) NULL AFTER `bulk_pk_sender_id`;
ALTER TABLE `sms_settings` ADD `cluster_auth_key` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `bulk_pk_status`, ADD `cluster_sender_id` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `cluster_auth_key`, ADD `cluster_router` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `cluster_sender_id`, ADD `cluster_status` TINYINT(1) NULL AFTER `cluster_router`;
ALTER TABLE `sms_settings` ADD `alpha_username` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `cluster_status`, ADD `alpha_hash` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `alpha_username`, ADD `alpha_status` TINYINT(1) NULL AFTER `alpha_hash`;
ALTER TABLE `sms_settings` ADD `alpha_type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `alpha_hash`;
ALTER TABLE `sms_settings` ADD `bdbulk_hash` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `alpha_status`, ADD `bdbulk_type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `bdbulk_hash`, ADD `bdbulk_status` TINYINT(1) NULL AFTER `bdbulk_type`;
ALTER TABLE `sms_settings` ADD `mim_api_key` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `bdbulk_status`, ADD `mim_type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `mim_api_key`, ADD `mim_status` TINYINT(1) NULL AFTER `mim_type`;
ALTER TABLE `sms_settings` ADD `mim_sender_id` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `mim_type`;
-- COMMON SQL ALTER--

ALTER TABLE `students` ADD `status_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'regular' AFTER `status`;
ALTER TABLE `students` CHANGE `status_type` `status_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'regular' COMMENT 'regular, drop, transfer,passed';
ALTER TABLE `teachers` ADD `display_order` INT(11) NULL AFTER `other_info`;
ALTER TABLE `employees` ADD `display_order` INT(11) NULL AFTER `other_info`;
ALTER TABLE `admissions` ADD `is_guardian` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `permanent_address`;
ALTER TABLE `admissions` ADD `gud_other_info` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `gud_religion`;

ALTER TABLE `global_setting` ADD `currency` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `google_analytics`, ADD `currency_symbol` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `currency`;
ALTER TABLE `global_setting` ADD `splash_image` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `currency_symbol`;

ALTER TABLE `invoices` DROP `income_head_id`;

ALTER TABLE `discounts` ADD `discount_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `title`;

ALTER TABLE `invoices` CHANGE `invoice_type` `invoice_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'income,invoice';

ALTER TABLE `transactions` ADD `bank_receipt` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `stack_reference`;
ALTER TABLE `transactions` ADD `stack_email` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `stripe_card_number`;
ALTER TABLE `transactions` ADD `card_cvv` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `bank_receipt`, ADD `expire_month` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `card_cvv`, ADD `expire_year` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `expire_month`;

ALTER TABLE `languages` CHANGE `label` `label` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `schools` ADD `zoom_api_key` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `map_api_key`, ADD `zoom_secret` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `zoom_api_key`;



--
-- Table structure for table `live_classes`
--

CREATE TABLE `live_classes` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `meeting_id` varchar(100) NOT NULL,
  `meeting_password` varchar(120) NOT NULL,
  `class_date` date NOT NULL,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL,
  `send_notification` tinyint(1) DEFAULT '0',
  `note` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--
-- Indexes for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `academic_year_id` (`academic_year_id`);

--
-- AUTO_INCREMENT for table `live_classes`
--
ALTER TABLE `live_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `submission` varchar(150) NOT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `note` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `income_head_id` int(11) NOT NULL,
  `invoice_type` varchar(20) DEFAULT NULL COMMENT 'income, fee, hostel, transport',
  `gross_amount` float NOT NULL,
  `discount` float NOT NULL,
  `net_amount` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



--
-- Table structure for table `video_lectures`
--

CREATE TABLE `video_lectures` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `lecture_type` varchar(50) NOT NULL,
  `lecture_title` varchar(255) NOT NULL,
  `video_id` varchar(50) DEFAULT NULL,
  `lecture_ppt` varchar(150) DEFAULT NULL,
  `note` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- AUTO_INCREMENT for table `video_lectures`
--
ALTER TABLE `video_lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



ALTER TABLE `live_classes` ADD `class_type` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `send_notification`;
ALTER TABLE `schools` ADD `enable_rtl` INT(1) NOT NULL DEFAULT '0' AFTER `about_image`;


--
-- Table structure for table `themes`
--
DROP TABLE `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `color_code` varchar(10) NOT NULL,
  `description` text,
  `is_active` tinyint(1) NOT NULL COMMENT '1 = Active, 0 = Inactive',
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `slug`, `color_code`, `description`, `is_active`, `status`, `created_at`, `modified_at`, `created_by`, `modified_by`) VALUES
(13, 'SlateGray ', 'slate-gray', '#2A3F54', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(2, 'Black ', 'black', '#23282d', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(14, 'LightSeaGreen ', 'light-sea-green', '#20B2AA', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(4, 'MediumPurple ', 'medium-purple', '#9370DB', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(15, 'Navy Blue', 'navy-blue', '#001f67', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(6, 'RebeccaPurple ', 'rebecca-purple', '#663399', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(16, 'Red', 'red', '#e80000', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(8, 'DodgerBlue', 'dodger-blue', '#1E90FF', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(9, 'Maroon', 'maroon', '#800000', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(10, 'DarkOrange', 'dark-orange', '#FF8C00', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(11, 'DeepPink', 'deep-pink', '#FF1493', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(5, 'LimeGreen', 'lime-green', '#32CD32', 'cbcvbced', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(1, 'Jazzberry Jam', 'jazzberry-jam', '#9F134E', 'Jazzberry Jam', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(3, 'Umber', 'umber', '#745D0B', 'Umber', 0, 1, '2017-08-18 12:59:25', '2017-08-18 13:03:43', 0, 0),
(12, 'Trinidad', 'trinidad', '#CC4F26', 'Trinidad', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(7, 'Radical Red', 'radical-red', '#FB2E50', 'Radical Red', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);



-- module operation -- previledges-- 
DROP TABLE `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `module_slug` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `module_slug`, `status`, `created_at`, `modified_at`, `created_by`, `modified_by`) VALUES
(1, 'Setting', 'setting', 1, '2017-11-13 22:55:19', '2017-11-13 22:57:10', 1, 1),
(2, 'Theme', 'theme', 1, '2017-12-12 13:34:52', '0000-00-00 00:00:00', 1, 0),
(3, 'Language', 'language', 1, '2017-12-12 13:36:11', '0000-00-00 00:00:00', 1, 0),
(4, 'Administrator', 'administrator', 1, '2017-12-12 13:36:35', '0000-00-00 00:00:00', 1, 0),
(5, 'Human Resource', 'hrm', 1, '2017-12-12 13:38:30', '0000-00-00 00:00:00', 1, 0),
(6, 'Teacher', 'teacher', 1, '2017-12-12 13:39:01', '0000-00-00 00:00:00', 1, 0),
(7, 'Academic Activity', 'academic', 1, '2017-12-12 13:42:24', '0000-00-00 00:00:00', 1, 0),
(8, 'Guardian', 'guardian', 1, '2017-12-12 13:43:01', '0000-00-00 00:00:00', 1, 0),
(9, 'Student', 'student', 1, '2017-12-12 13:43:28', '0000-00-00 00:00:00', 1, 0),
(10, 'Attendance', 'attendance', 1, '2017-12-12 13:45:03', '0000-00-00 00:00:00', 1, 0),
(11, 'Assignment', 'assignment', 1, '2017-12-12 13:45:45', '0000-00-00 00:00:00', 1, 0),
(12, 'Exam', 'exam', 1, '2017-12-12 13:46:13', '0000-00-00 00:00:00', 1, 0),
(14, 'Library', 'library', 1, '2017-12-12 13:46:33', '0000-00-00 00:00:00', 1, 0),
(15, 'Transport', 'transport', 1, '2017-12-12 13:46:52', '0000-00-00 00:00:00', 1, 0),
(16, 'Hostel', 'hostel', 1, '2017-12-12 13:47:15', '0000-00-00 00:00:00', 1, 0),
(17, 'Message, Email & SMS', 'message', 1, '2017-12-12 13:47:48', '2017-12-14 08:48:49', 1, 1),
(18, 'Announcement', 'announcement', 1, '2017-12-12 13:48:23', '0000-00-00 00:00:00', 1, 0),
(19, 'Event', 'event', 1, '2017-12-12 13:48:36', '0000-00-00 00:00:00', 1, 0),
(20, 'Front Office', 'frontoffice', 1, '2017-12-12 13:49:05', '2019-08-05 22:41:52', 1, 1),
(21, 'Accounting', 'accounting', 1, '2017-12-12 13:49:32', '0000-00-00 00:00:00', 1, 0),
(22, 'Report', 'report', 1, '2017-12-12 13:51:09', '0000-00-00 00:00:00', 1, 0),
(13, 'Exam Mark', 'exam', 1, '2017-12-14 00:00:00', '2017-12-14 09:07:46', 1, 1),
(23, 'Certificate', 'certificate', 1, '2018-03-17 16:27:14', '0000-00-00 00:00:00', 2, 0),
(24, 'Media Gallery', 'gallery', 1, '2018-03-22 06:46:46', '0000-00-00 00:00:00', 1, 0),
(25, 'Frontend', 'frontend', 1, '2018-03-23 03:40:22', '0000-00-00 00:00:00', 1, 0),
(26, 'Payroll', 'payroll', 1, '2018-03-25 02:07:46', '0000-00-00 00:00:00', 1, 0),
(27, 'Complain', 'complain', 1, '2019-04-10 00:00:00', '2019-04-10 00:00:00', 1, 1),
(28, 'User Complain', 'usercomplain', 1, '2019-07-20 19:39:44', '0000-00-00 00:00:00', 1, 0),
(29, 'User Leave', 'userleave', 1, '2019-07-24 21:53:30', '0000-00-00 00:00:00', 1, 0),
(30, 'Leave Management', 'leave', 1, '2019-07-24 21:53:59', '0000-00-00 00:00:00', 1, 0),
(31, 'ID Card & Admit Card', 'card', 1, '2019-07-28 23:36:16', '0000-00-00 00:00:00', 1, 0);


ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;



DROP TABLE `operations`;
CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `operation_name` varchar(50) NOT NULL,
  `operation_slug` varchar(50) NOT NULL,
  `is_view_vissible` tinyint(1) DEFAULT '0',
  `is_add_vissible` tinyint(1) DEFAULT '0',
  `is_edit_vissible` tinyint(1) DEFAULT '0',
  `is_delete_vissible` tinyint(1) DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operations`
--

INSERT INTO `operations` (`id`, `module_id`, `operation_name`, `operation_slug`, `is_view_vissible`, `is_add_vissible`, `is_edit_vissible`, `is_delete_vissible`, `status`, `created_at`, `modified_at`, `created_by`, `modified_by`) VALUES
(1, 1, 'General Setting (Only Admin)', 'setting', 1, 1, 1, NULL, 1, '2017-12-12 16:06:25', '2019-09-01 14:22:34', 1, 1),
(2, 1, 'Payment Setting (Only Admin)', 'payment', 1, 1, 1, NULL, 1, '2017-12-12 16:06:55', '2019-09-01 14:23:16', 1, 1),
(3, 1, 'SMS Setting (Only Admin)', 'sms', 1, 1, 1, NULL, 1, '2017-12-12 16:07:07', '2019-09-01 14:23:01', 1, 1),
(4, 2, 'Theme', 'theme', 1, 0, 1, 0, 1, '2017-12-12 16:08:39', '2018-01-03 07:02:51', 1, 1),
(5, 3, 'Language', 'language', 1, 1, 1, 1, 1, '2017-12-12 16:09:22', '2020-06-13 13:04:55', 1, 1),
(6, 4, 'Academic Year', 'year', 1, 1, 1, 1, 1, '2017-12-12 16:10:34', '2018-01-03 07:03:18', 1, 1),
(7, 4, 'User Role (Only Super Admin)', 'role', 1, 1, 1, 1, 1, '2017-12-12 16:10:55', '2019-09-01 15:07:08', 1, 1),
(8, 4, 'Role Permission (Only Super Admin)', 'permission', 1, NULL, 1, NULL, 1, '2017-12-12 16:12:10', '2019-09-01 14:24:55', 1, 1),
(64, 4, 'Reset User Password', 'password', 0, 0, 1, 0, 1, '2017-12-13 20:14:23', '2018-01-03 07:05:11', 1, 1),
(10, 5, 'Designation', 'designation', 1, 1, 1, 1, 1, '2017-12-12 16:15:38', '2018-01-03 07:07:38', 1, 1),
(11, 5, 'Employee', 'employee', 1, 1, 1, 1, 1, '2017-12-12 16:15:55', '2018-01-03 07:19:54', 1, 1),
(12, 6, 'Teacher', 'teacher', 1, 1, 1, 1, 1, '2017-12-12 16:17:22', '2018-01-03 07:25:07', 1, 1),
(14, 7, 'Classes', 'classes', 1, 1, 1, 1, 1, '2017-12-12 16:19:01', '2018-01-03 07:25:17', 1, 1),
(15, 7, 'Section', 'section', 1, 1, 1, 1, 1, '2017-12-12 16:19:24', '2018-01-03 07:25:24', 1, 1),
(16, 7, 'Subject', 'subject', 1, 1, 1, 1, 1, '2017-12-12 16:19:48', '2018-01-03 07:25:33', 1, 1),
(17, 7, 'Syllabus', 'syllabus', 1, 1, 1, 1, 1, '2017-12-12 16:20:32', '2018-01-03 07:25:54', 1, 1),
(18, 7, 'Class Routine', 'routine', 1, 1, 1, 1, 1, '2017-12-12 16:20:56', '2018-01-03 07:26:13', 1, 1),
(19, 7, 'Promotion', 'promotion', 1, 1, 0, 0, 1, '2017-12-12 16:21:17', '2018-02-09 01:42:57', 1, 1),
(20, 8, 'Guardian', 'guardian', 1, 1, 1, 1, 1, '2017-12-12 16:23:32', '2018-01-03 07:29:06', 1, 1),
(21, 9, 'Student', 'student', 1, 1, 1, 1, 1, '2017-12-12 17:58:56', '2018-01-03 07:29:15', 1, 1),
(65, 4, 'Backup Database (Only Super Admin)', 'backup', 1, NULL, NULL, NULL, 1, '2017-12-13 20:14:39', '2019-09-01 14:28:12', 1, 1),
(23, 10, 'Employee Attendance', 'employee', 1, 1, 1, 0, 1, '2017-12-12 18:00:10', '2018-01-03 07:30:19', 1, 1),
(24, 10, 'Teacher Attendance', 'teacher', 1, 1, 1, 0, 1, '2017-12-12 18:00:51', '2018-01-03 07:29:52', 1, 1),
(25, 10, 'Student Attendance', 'student', 1, 1, 1, 0, 1, '2017-12-12 18:01:17', '2018-01-03 07:30:01', 1, 1),
(26, 11, 'Assignment', 'assignment', 1, 1, 1, 1, 1, '2017-12-12 18:02:08', '2018-01-03 07:30:40', 1, 1),
(28, 12, 'Exam Term', 'exam', 1, 1, 1, 1, 1, '2017-12-12 18:03:30', '2018-02-09 01:49:25', 1, 1),
(29, 12, 'Exam Grade', 'grade', 1, 1, 1, 1, 1, '2017-12-12 18:03:56', '2018-01-03 07:31:56', 1, 1),
(30, 12, 'Exam Schedule', 'schedule', 1, 1, 1, 1, 1, '2017-12-12 18:04:58', '2018-01-03 07:32:14', 1, 1),
(31, 12, 'Exam Suggestion', 'suggestion', 1, 1, 1, 1, 1, '2017-12-12 18:05:18', '2018-01-03 07:32:30', 1, 1),
(32, 12, 'Exam Attendance', 'attendance', 1, 1, 1, 0, 1, '2017-12-12 18:05:43', '2018-01-03 07:32:58', 1, 1),
(33, 13, 'Exam Mark', 'mark', 1, 1, 1, 0, 1, '2017-12-12 18:06:04', '2018-01-03 07:33:16', 1, 1),
(34, 13, 'Mark Sheet', 'marksheet', 1, 1, 1, 0, 1, '2017-12-12 18:06:24', '2018-01-03 07:34:08', 1, 1),
(35, 13, 'Result', 'result', 1, 1, 1, NULL, 1, '2017-12-12 18:06:41', '2018-09-02 12:40:01', 1, 1),
(37, 14, 'Library Book', 'book', 1, 1, 1, 1, 1, '2017-12-12 18:09:17', '2018-01-03 07:36:02', 1, 1),
(38, 14, 'Library Member', 'member', 1, 1, 0, 1, 1, '2017-12-12 18:09:33', '2018-01-03 07:36:24', 1, 1),
(66, 14, 'Issue & Return', 'issue', 1, 1, 1, 0, 1, '2017-12-14 08:46:37', '2018-01-03 07:37:01', 1, 1),
(40, 15, 'Vehicle', 'vehicle', 1, 1, 1, 1, 1, '2017-12-12 18:10:49', '2018-01-03 07:37:11', 1, 1),
(41, 15, 'Transport Route', 'route', 1, 1, 1, 1, 1, '2017-12-12 18:11:17', '2018-01-03 07:41:27', 1, 1),
(42, 15, 'Transport Member', 'member', 1, 1, 0, 1, 1, '2017-12-12 18:11:39', '2018-01-03 07:41:46', 1, 1),
(43, 16, 'Hostel', 'hostel', 1, 1, 1, 1, 1, '2017-12-12 18:12:16', '2018-01-03 07:41:55', 1, 1),
(44, 16, 'Hostel Room', 'room', 1, 1, 1, 1, 1, '2017-12-12 18:12:37', '2018-01-03 07:42:02', 1, 1),
(45, 16, 'Hostel Member', 'member', 1, 1, 0, 1, 1, '2017-12-12 18:13:00', '2018-01-03 07:42:23', 1, 1),
(47, 17, 'Email', 'mail', 1, 1, 0, 1, 1, '2017-12-12 18:15:57', '2018-01-03 07:44:16', 1, 1),
(48, 17, 'Text SMS', 'text', 1, 1, 0, 1, 1, '2017-12-12 18:16:17', '2018-01-03 07:44:25', 1, 1),
(50, 18, 'Notice', 'notice', 1, 1, 1, 1, 1, '2017-12-12 18:20:38', '2018-01-03 07:47:39', 1, 1),
(51, 18, 'News', 'news', 1, 1, 1, 1, 1, '2017-12-12 18:20:54', '2018-01-03 07:47:46', 1, 1),
(52, 18, 'Holiday', 'holiday', 1, 1, 1, 1, 1, '2017-12-12 18:21:08', '2018-01-03 07:47:53', 1, 1),
(53, 19, 'Event', 'event', 1, 1, 1, 1, 1, '2017-12-12 18:21:35', '2018-01-03 07:48:00', 1, 1),
(54, 20, 'Visitor', 'visitor', 1, 1, 1, 1, 1, '2017-12-12 18:22:05', '2019-08-05 22:43:00', 1, 1),
(56, 21, 'Expenditure Head', 'exphead', 1, 1, 1, 1, 1, '2017-12-12 18:23:51', '2018-01-03 07:48:23', 1, 1),
(57, 21, 'Expenditure', 'expenditure', 1, 1, 1, 1, 1, '2017-12-12 18:24:14', '2018-01-03 07:48:32', 1, 1),
(58, 21, 'Income Head', 'incomehead', 1, 1, 1, 1, 1, '2017-12-12 18:24:42', '2018-01-03 07:48:39', 1, 1),
(59, 21, 'Income', 'income', 1, 1, 1, 1, 1, '2017-12-12 18:24:54', '2018-01-03 07:48:59', 1, 1),
(60, 21, 'Invoice', 'invoice', 1, 1, 1, 1, 1, '2017-12-12 18:25:16', '2018-01-03 07:49:12', 1, 1),
(61, 21, 'Payment', 'payment', 1, 1, 0, 0, 1, '2017-12-12 18:25:34', '2018-01-03 07:49:47', 1, 1),
(62, 22, 'Report', 'report', 1, 0, 0, 0, 1, '2017-12-12 18:26:16', '2018-01-03 07:50:00', 1, 1),
(63, 4, 'Manage User', 'user', 1, 0, 1, 0, 1, '2017-12-13 20:13:49', '2018-01-03 07:35:43', 1, 1),
(67, 13, 'Mark send by SMS', 'text', 1, 1, 0, 1, 1, '2017-12-14 09:09:58', '2018-01-03 07:34:45', 1, 1),
(68, 13, 'Mark send by Email', 'mail', 1, 1, 0, 1, 1, '2017-12-14 09:10:15', '2018-01-03 07:35:13', 1, 1),
(69, 17, 'message', 'message', 1, 1, 1, 1, 1, '2018-01-13 08:53:53', '2018-01-13 09:06:22', 2, 2),
(70, 23, 'CertificateType', 'type', 1, 1, 1, 1, 1, '2018-03-17 16:28:43', '0000-00-00 00:00:00', 2, 0),
(71, 23, 'Certificate', 'certificate', 1, NULL, NULL, NULL, 1, '2018-03-18 09:06:40', '0000-00-00 00:00:00', 1, 0),
(72, 24, 'Gallery', 'gallery', 1, 1, 1, 1, 1, '2018-03-22 06:47:27', '2018-03-22 06:48:03', 1, 1),
(73, 24, 'Image', 'image', 1, 1, 1, 1, 1, '2018-03-22 06:47:51', '0000-00-00 00:00:00', 1, 0),
(74, 25, 'Frontend', 'frontend', 1, 1, 1, 1, 1, '2018-03-23 05:06:49', '0000-00-00 00:00:00', 1, 0),
(75, 26, 'Salary Grade', 'grade', 1, 1, 1, 1, 1, '2018-03-25 02:08:21', '0000-00-00 00:00:00', 1, 0),
(76, 26, 'Payment', 'payment', 1, 1, 1, 1, 1, '2018-03-25 02:09:05', '0000-00-00 00:00:00', 1, 0),
(77, 25, 'Home Slider', 'slider', 1, 1, 1, 1, 1, '2018-03-27 18:04:48', '0000-00-00 00:00:00', 1, 0),
(78, 26, 'History', 'history', 1, NULL, NULL, NULL, 1, '2018-04-01 00:39:23', '0000-00-00 00:00:00', 1, 0),
(79, 4, 'School (Only Super Admin)', 'school', 1, 1, 1, 1, 1, '2018-05-08 18:57:28', '2019-09-01 14:26:34', 1, 1),
(81, 4, 'Payment (Only Super Admin)', 'payment', 1, 1, 1, 1, 1, '2018-08-15 00:43:44', '2019-09-01 14:27:09', 1, 1),
(82, 4, 'SMS (Only Super Admin)', 'sms', 1, 1, 1, 1, 1, '2018-08-15 00:43:58', '2019-09-01 14:27:35', 1, 1),
(83, 4, 'SMS Template', 'smstemplate', 1, 1, 1, 1, 1, '2018-08-24 18:36:20', '0000-00-00 00:00:00', 1, 0),
(84, 4, 'Email Template', 'emailtemplate', 1, 1, 1, 1, 1, '2018-08-24 18:36:46', '0000-00-00 00:00:00', 1, 0),
(85, 4, 'Activity Log', 'activitylog', 1, NULL, NULL, 1, 1, '2018-08-24 18:42:49', '0000-00-00 00:00:00', 1, 0),
(86, 9, 'Bulk Import', 'bulk', 1, 1, NULL, NULL, 1, '2018-08-28 21:13:45', '0000-00-00 00:00:00', 1, 0),
(87, 9, 'Student Activity', 'activity', 1, 1, 1, 1, 1, '2018-08-28 21:14:33', '0000-00-00 00:00:00', 1, 0),
(88, 10, 'Absent Email', 'absentemail', 1, 1, NULL, 1, 1, '2018-09-01 08:51:33', '0000-00-00 00:00:00', 1, 0),
(89, 10, 'Absent SMS', 'absentsms', 1, 1, NULL, 1, 1, '2018-09-01 08:51:50', '0000-00-00 00:00:00', 1, 0),
(90, 13, 'Exam Result', 'examresult', 1, 1, 1, NULL, 1, '2018-09-02 12:38:31', '0000-00-00 00:00:00', 1, 0),
(91, 13, 'Final Result', 'finalresult', 1, 1, 1, NULL, 1, '2018-09-02 12:41:39', '0000-00-00 00:00:00', 1, 0),
(92, 13, 'Merit List', 'meritlist', 1, NULL, NULL, NULL, 1, '2018-09-02 12:42:23', '0000-00-00 00:00:00', 1, 0),
(93, 13, 'Result Email', 'resultemail', 1, 1, NULL, 1, 1, '2018-09-02 12:43:23', '0000-00-00 00:00:00', 1, 0),
(94, 13, 'Result SMS', 'resultsms', 1, 1, NULL, 1, 1, '2018-09-02 12:43:44', '0000-00-00 00:00:00', 1, 0),
(95, 13, 'Result Card', 'resultcard', 1, NULL, NULL, NULL, 1, '2018-09-02 12:44:43', '0000-00-00 00:00:00', 1, 0),
(96, 21, 'Discount', 'discount', 1, 1, 1, 1, 1, '2018-09-10 12:33:45', '0000-00-00 00:00:00', 1, 0),
(97, 21, 'Fee Type', 'feetype', 1, 1, 1, 1, 1, '2018-09-10 12:37:06', '0000-00-00 00:00:00', 1, 0),
(98, 21, 'Due Fee Email', 'duefeeemail', 1, 1, NULL, 1, 1, '2018-09-10 12:37:40', '0000-00-00 00:00:00', 1, 0),
(99, 21, 'Due Fee SMS', 'duefeesms', 1, 1, NULL, 1, 1, '2018-09-10 12:38:04', '0000-00-00 00:00:00', 1, 0),
(100, 4, 'Super Admin (Only Super Admin)', 'superadmin', 1, 1, 1, 1, 1, '2018-09-14 17:50:59', '2019-09-01 14:23:46', 1, 1),
(101, 4, 'Guardian Feedback', 'feedback', 1, NULL, 1, 1, 1, '2018-09-14 17:55:09', '0000-00-00 00:00:00', 1, 0),
(102, 8, 'Feedback', 'feedback', 1, 1, 1, 1, 1, '2018-09-14 18:07:45', '0000-00-00 00:00:00', 1, 0),
(103, 4, 'General Setting (Only Super Admin)', 'setting', 1, 1, 1, NULL, 1, '2018-09-15 16:00:20', '2019-09-01 14:25:47', 1, 1),
(104, 25, 'About', 'about', 1, 1, 1, NULL, 1, '2018-10-10 18:16:05', '0000-00-00 00:00:00', 1, 0),
(105, 4, 'Email Setting (Only Super Admin)', 'emailsetting', 1, 1, 1, 1, 1, '2019-04-09 13:57:32', '2019-09-01 14:26:08', 1, 1),
(106, 1, 'Email Setting (Only Admin)', 'emailsetting', 1, 1, 1, NULL, 1, '2019-04-09 13:58:35', '2019-09-01 14:22:46', 1, 1),
(107, 27, 'Complain', 'complain', 1, 1, 1, 1, 1, '2019-04-10 16:22:48', '0000-00-00 00:00:00', 1, 0),
(108, 7, 'Material', 'material', 1, 1, 1, 1, 1, '2019-07-05 21:41:34', '0000-00-00 00:00:00', 1, 0),
(109, 14, 'e-book', 'ebook', 1, 1, 1, 1, 1, '2019-07-07 00:03:59', '0000-00-00 00:00:00', 1, 0),
(110, 9, 'Online Admission', 'admission', 1, NULL, 1, 1, 1, '2019-07-08 20:14:31', '2019-07-13 14:17:27', 1, 1),
(111, 27, 'Complain Type', 'type', 1, 1, 1, 1, 1, '2019-07-19 17:49:08', '0000-00-00 00:00:00', 1, 0),
(112, 28, 'User Complain (Except Super Admin)', 'usercomplain', 1, 1, 1, 1, 1, '2019-07-20 19:40:21', '2019-09-01 15:06:04', 1, 1),
(113, 29, 'User Leave (Except Super Admin)', 'userleave', 1, 1, 1, 1, 1, '2019-07-24 21:54:41', '2019-09-01 15:05:38', 1, 1),
(114, 30, 'Leave Management', 'leave', 1, 1, 1, 1, 1, '2019-07-24 21:55:23', '0000-00-00 00:00:00', 1, 0),
(115, 30, 'Leave Type', 'type', 1, 1, 1, 1, 1, '2019-07-24 21:55:51', '0000-00-00 00:00:00', 1, 0),
(116, 30, 'Leave Application', 'application', 1, 1, 1, 1, 1, '2019-07-25 16:59:43', '2019-07-25 18:21:20', 1, 1),
(117, 30, 'Waiting Leave', 'waiting', 1, NULL, 1, 1, 1, '2019-07-28 13:21:16', '0000-00-00 00:00:00', 1, 0),
(118, 30, 'Approve Leave', 'approve', 1, NULL, 1, 1, 1, '2019-07-28 13:21:46', '0000-00-00 00:00:00', 1, 0),
(119, 30, 'Decline Leave', 'decline', 1, NULL, 1, 1, 1, '2019-07-28 13:22:11', '0000-00-00 00:00:00', 1, 0),
(120, 31, 'ID & Admit card', 'card', 1, NULL, NULL, NULL, 1, '2019-07-28 23:44:54', '0000-00-00 00:00:00', 1, 0),
(121, 31, 'Teacher ID card', 'teacher', 1, NULL, NULL, NULL, 1, '2019-07-28 23:45:36', '0000-00-00 00:00:00', 1, 0),
(122, 31, 'Employee ID Card', 'employee', 1, NULL, NULL, NULL, 1, '2019-07-28 23:46:01', '0000-00-00 00:00:00', 1, 0),
(123, 31, 'Student ID card', 'student', 1, NULL, NULL, NULL, 1, '2019-07-28 23:46:40', '2019-08-03 15:23:48', 1, 1),
(124, 31, 'ID Card Setting (Only Super Admin)', 'idsetting', 1, 1, 1, 1, 1, '2019-07-30 17:27:20', '2019-09-01 15:02:05', 1, 1),
(125, 31, 'Admit Card Setting (Only Super Admin)', 'admitsetting', 1, 1, 1, 1, 1, '2019-08-03 15:25:20', '2019-09-01 15:01:35', 1, 1),
(126, 31, 'Admit card', 'admit', 1, NULL, NULL, NULL, 1, '2019-08-03 15:25:53', '0000-00-00 00:00:00', 1, 0),
(127, 31, 'School ID Setting (Only Admin)', 'schoolidsetting', 1, 1, 1, NULL, 1, '2019-08-04 13:14:03', '2019-09-01 14:21:14', 1, 1),
(128, 31, 'School Admit Setting (Only Admin)', 'schooladmitsetting', 1, 1, 1, NULL, 1, '2019-08-04 13:14:35', '2019-09-01 14:20:45', 1, 1),
(129, 20, 'Visitor Purpose', 'purpose', 1, 1, 1, 1, 1, '2019-08-05 22:43:33', '0000-00-00 00:00:00', 1, 0),
(130, 20, 'Call Logs', 'calllog', 1, 1, 1, 1, 1, '2019-08-05 22:44:06', '0000-00-00 00:00:00', 1, 0),
(131, 20, 'Postal Dispatch', 'dispatch', 1, 1, 1, 1, 1, '2019-08-05 22:44:49', '0000-00-00 00:00:00', 1, 0),
(132, 20, 'Postal Receive', 'receive', 1, 1, 1, 1, 1, '2019-08-05 22:45:19', '0000-00-00 00:00:00', 1, 0),
(133, 20, 'Front Office', 'frontoffice', 1, 1, 1, 1, 1, '2019-08-05 22:45:47', '0000-00-00 00:00:00', 1, 0),
(134, 9, 'Student Type', 'type', 1, 1, 1, 1, 1, '2019-08-17 23:11:18', '0000-00-00 00:00:00', 1, 0),
(135, 4, 'User Credential', 'usercredential', 1, NULL, NULL, NULL, 1, '2019-08-18 23:54:14', '2019-09-05 13:47:12', 1, 132),
(136, 21, 'Invoice Receipt', 'receipt', 1, NULL, NULL, NULL, 1, '2020-04-17 16:27:36', '0000-00-00 00:00:00', 1, 0),
(137, 11, 'Assignment Submission', 'submission', 1, 1, 1, 1, 1, '2020-05-03 02:02:10', '0000-00-00 00:00:00', 1, 0),
(138, 6, 'Teacher Lecture', 'lecture', 1, 1, 1, 1, 1, '2020-05-03 02:06:11', '0000-00-00 00:00:00', 1, 0),
(139, 4, 'Username', 'username', NULL, NULL, 1, NULL, 1, '2020-05-26 10:34:38', '0000-00-00 00:00:00', 1, 0),
(140, 1, 'Global Search', 'globalsearch', 1, NULL, NULL, NULL, 1, '2020-06-03 14:06:16', '0000-00-00 00:00:00', 1, 0),
(141, 1, 'Global Session Change', 'sessionchange', 1, NULL, NULL, NULL, 1, '2020-06-03 14:07:05', '0000-00-00 00:00:00', 1, 0),
(142, 7, 'Live Class', 'liveclass', 1, 1, 1, 1, 1, '2020-06-20 14:51:21', '0000-00-00 00:00:00', 1, 0);

ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;



DROP TABLE `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `is_add` tinyint(1) NOT NULL,
  `is_edit` tinyint(1) NOT NULL,
  `is_view` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privileges`
--


INSERT INTO `privileges` (`id`, `role_id`, `operation_id`, `is_add`, `is_edit`, `is_view`, `is_delete`, `status`, `created_at`, `modified_at`, `created_by`, `modified_by`) VALUES
(1, 1, 1, 0, 0, 0, 0, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(2, 1, 2, 0, 0, 0, 0, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(3, 1, 3, 0, 0, 0, 0, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(4, 1, 4, 0, 1, 1, 0, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(5, 1, 5, 1, 1, 1, 1, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(6, 1, 6, 1, 1, 1, 1, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(7, 1, 7, 1, 1, 1, 1, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(8, 1, 8, 0, 1, 1, 0, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(9, 1, 64, 0, 1, 0, 0, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(10, 1, 65, 0, 0, 1, 0, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(11, 1, 63, 0, 1, 1, 0, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(12, 1, 10, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(13, 1, 11, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(14, 1, 12, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(15, 1, 14, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(16, 1, 15, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(17, 1, 16, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(18, 1, 17, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(19, 1, 18, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(20, 1, 19, 1, 0, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(21, 1, 20, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(22, 1, 21, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(23, 1, 23, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(24, 1, 24, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(25, 1, 25, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(26, 1, 26, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(27, 1, 27, 1, 1, 1, 1, 1, '2018-01-13 09:07:29', '0000-00-00 00:00:00', 2, 0),
(28, 1, 28, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(29, 1, 29, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(30, 1, 30, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(31, 1, 31, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(32, 1, 32, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(33, 1, 33, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(34, 1, 34, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(35, 1, 35, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(36, 1, 67, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(37, 1, 68, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(38, 1, 37, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(39, 1, 38, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(40, 1, 66, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(41, 1, 40, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(42, 1, 41, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(43, 1, 42, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(44, 1, 43, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(45, 1, 44, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(46, 1, 45, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(47, 1, 46, 1, 1, 1, 1, 1, '2017-12-23 22:10:34', '0000-00-00 00:00:00', 1, 0),
(48, 1, 47, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(49, 1, 48, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(50, 1, 50, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(51, 1, 51, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(52, 1, 52, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(53, 1, 53, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(54, 1, 54, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(55, 1, 55, 1, 1, 1, 1, 1, '2017-12-23 22:10:34', '0000-00-00 00:00:00', 1, 0),
(56, 1, 56, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(57, 1, 57, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(58, 1, 58, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(59, 1, 59, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(60, 1, 60, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(61, 1, 61, 1, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(62, 1, 62, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(63, 3, 1, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(64, 3, 2, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(65, 3, 3, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(66, 3, 4, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(67, 3, 5, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(68, 3, 6, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(69, 3, 7, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(70, 3, 8, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(71, 3, 64, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(72, 3, 65, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(73, 3, 63, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(74, 3, 10, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(75, 3, 11, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(76, 3, 12, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(77, 3, 14, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(78, 3, 15, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(79, 3, 16, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(80, 3, 17, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(81, 3, 18, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(82, 3, 19, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(83, 3, 20, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(84, 3, 21, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(85, 3, 23, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(86, 3, 24, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(87, 3, 25, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(88, 3, 26, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(89, 3, 27, 1, 1, 0, 1, 1, '2018-01-03 07:12:55', '0000-00-00 00:00:00', 1, 0),
(90, 3, 28, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(91, 3, 29, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(92, 3, 30, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(93, 3, 31, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(94, 3, 32, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(95, 3, 33, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(96, 3, 34, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(97, 3, 35, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(98, 3, 67, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(99, 3, 68, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(100, 3, 37, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(101, 3, 38, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(102, 3, 66, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(103, 3, 40, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(104, 3, 41, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(105, 3, 42, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(106, 3, 43, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(107, 3, 44, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(108, 3, 45, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(109, 3, 46, 1, 1, 0, 1, 1, '2018-01-03 07:12:55', '0000-00-00 00:00:00', 1, 0),
(110, 3, 47, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(111, 3, 48, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(112, 3, 50, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(113, 3, 51, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(114, 3, 52, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(115, 3, 53, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(116, 3, 54, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(117, 3, 55, 1, 1, 0, 1, 1, '2018-01-03 07:12:55', '0000-00-00 00:00:00', 1, 0),
(118, 3, 56, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(119, 3, 57, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(120, 3, 58, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(121, 3, 59, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(122, 3, 60, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(123, 3, 61, 1, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(124, 3, 62, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(125, 1, 69, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(126, 5, 1, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(127, 5, 2, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(128, 5, 3, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(129, 5, 4, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(130, 5, 5, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(131, 5, 6, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(132, 5, 7, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(133, 5, 8, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(134, 5, 64, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(135, 5, 65, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(136, 5, 63, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(137, 5, 10, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(138, 5, 11, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(139, 5, 12, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(140, 5, 14, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(141, 5, 15, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(142, 5, 16, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(143, 5, 17, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(144, 5, 18, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(145, 5, 19, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(146, 5, 20, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(147, 5, 21, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(148, 5, 23, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(149, 5, 24, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(150, 5, 25, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(151, 5, 26, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(152, 5, 27, 1, 1, 1, 0, 1, '2018-01-13 09:46:35', '0000-00-00 00:00:00', 1, 0),
(153, 5, 28, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(154, 5, 29, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(155, 5, 30, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(156, 5, 31, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(157, 5, 32, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(158, 5, 33, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(159, 5, 34, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(160, 5, 35, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(161, 5, 67, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(162, 5, 68, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(163, 5, 37, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(164, 5, 38, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(165, 5, 66, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(166, 5, 40, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(167, 5, 41, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(168, 5, 42, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(169, 5, 43, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(170, 5, 44, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(171, 5, 45, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(172, 5, 47, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(173, 5, 48, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(174, 5, 69, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(175, 5, 50, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(176, 5, 51, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(177, 5, 52, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(178, 5, 53, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(179, 5, 54, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(180, 5, 56, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(181, 5, 57, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(182, 5, 58, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(183, 5, 59, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(184, 5, 60, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(185, 5, 61, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(186, 5, 62, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(187, 13, 1, 0, 0, 0, 0, 1, '2018-04-16 07:42:12', '0000-00-00 00:00:00', 1, 0),
(188, 13, 2, 0, 0, 0, 0, 1, '2018-04-16 07:42:12', '0000-00-00 00:00:00', 1, 0),
(189, 13, 3, 0, 0, 0, 0, 1, '2018-04-16 07:42:12', '0000-00-00 00:00:00', 1, 0),
(190, 13, 4, 0, 0, 0, 0, 1, '2018-04-16 07:42:12', '0000-00-00 00:00:00', 1, 0),
(191, 13, 5, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(192, 13, 6, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(193, 13, 7, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(194, 13, 8, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(195, 13, 64, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(196, 13, 65, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(197, 13, 63, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(198, 13, 10, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(199, 13, 11, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(200, 13, 12, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(201, 13, 14, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(202, 13, 15, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(203, 13, 16, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(204, 13, 17, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(205, 13, 18, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(206, 13, 19, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(207, 13, 20, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(208, 13, 21, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(209, 13, 23, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(210, 13, 24, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(211, 13, 25, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(212, 13, 26, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(213, 13, 27, 0, 0, 0, 0, 1, '2018-02-04 04:46:43', '0000-00-00 00:00:00', 1, 0),
(214, 13, 28, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(215, 13, 29, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(216, 13, 30, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(217, 13, 31, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(218, 13, 32, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(219, 13, 33, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(220, 13, 34, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(221, 13, 35, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(222, 13, 67, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(223, 13, 68, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(224, 13, 37, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(225, 13, 38, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(226, 13, 66, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(227, 13, 40, 0, 0, 1, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(228, 13, 41, 0, 0, 1, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(229, 13, 42, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(230, 13, 43, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(231, 13, 44, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(232, 13, 45, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(233, 13, 47, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(234, 13, 48, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(235, 13, 69, 0, 0, 1, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(236, 13, 50, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(237, 13, 51, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(238, 13, 52, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(239, 13, 53, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(240, 13, 54, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(241, 13, 56, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(242, 13, 57, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(243, 13, 58, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(244, 13, 59, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(245, 13, 60, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(246, 13, 61, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(247, 13, 62, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(248, 3, 69, 1, 1, 1, 1, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(249, 2, 1, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(250, 2, 2, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(251, 2, 3, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(252, 2, 4, 0, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(253, 2, 5, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(254, 2, 6, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(255, 2, 7, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(256, 2, 8, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(257, 2, 64, 0, 1, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(258, 2, 65, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(259, 2, 63, 0, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(260, 2, 10, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(261, 2, 11, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(262, 2, 12, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(263, 2, 14, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(264, 2, 15, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(265, 2, 16, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(266, 2, 17, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(267, 2, 18, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(268, 2, 19, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(269, 2, 20, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(270, 2, 21, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(271, 2, 23, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(272, 2, 24, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(273, 2, 25, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(274, 2, 26, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(275, 2, 28, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(276, 2, 29, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(277, 2, 30, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(278, 2, 31, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(279, 2, 32, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(280, 2, 33, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(281, 2, 34, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(282, 2, 35, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(283, 2, 67, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(284, 2, 68, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(285, 2, 37, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(286, 2, 38, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(287, 2, 66, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(288, 2, 40, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(289, 2, 41, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(290, 2, 42, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(291, 2, 43, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(292, 2, 44, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(293, 2, 45, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(294, 2, 47, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(295, 2, 48, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(296, 2, 69, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(297, 2, 50, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(298, 2, 51, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(299, 2, 52, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(300, 2, 53, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(301, 2, 54, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(302, 2, 56, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(303, 2, 57, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(304, 2, 58, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(305, 2, 59, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(306, 2, 60, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(307, 2, 61, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(308, 2, 62, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(309, 4, 1, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(310, 4, 2, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(311, 4, 3, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(312, 4, 4, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(313, 4, 5, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(314, 4, 6, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(315, 4, 7, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(316, 4, 8, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(317, 4, 64, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(318, 4, 65, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(319, 4, 63, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(320, 4, 10, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(321, 4, 11, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(322, 4, 12, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(323, 4, 14, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(324, 4, 15, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(325, 4, 16, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(326, 4, 17, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(327, 4, 18, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(328, 4, 19, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(329, 4, 20, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(330, 4, 21, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(331, 4, 23, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(332, 4, 24, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(333, 4, 25, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(334, 4, 26, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(335, 4, 28, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(336, 4, 29, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(337, 4, 30, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(338, 4, 31, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(339, 4, 32, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(340, 4, 33, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(341, 4, 34, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(342, 4, 35, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(343, 4, 67, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(344, 4, 68, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(345, 4, 37, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(346, 4, 38, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(347, 4, 66, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(348, 4, 40, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(349, 4, 41, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(350, 4, 42, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(351, 4, 43, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(352, 4, 44, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(353, 4, 45, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(354, 4, 47, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(355, 4, 48, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(356, 4, 69, 1, 1, 1, 1, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(357, 4, 50, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(358, 4, 51, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(359, 4, 52, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(360, 4, 53, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(361, 4, 54, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(362, 4, 56, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(363, 4, 57, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(364, 4, 58, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(365, 4, 59, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(366, 4, 60, 0, 0, 1, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(367, 4, 61, 1, 0, 1, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(368, 4, 62, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(369, 6, 1, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(370, 6, 2, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(371, 6, 3, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(372, 6, 4, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(373, 6, 5, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(374, 6, 6, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(375, 6, 7, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(376, 6, 8, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(377, 6, 64, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(378, 6, 65, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(379, 6, 63, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(380, 6, 10, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(381, 6, 11, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(382, 6, 12, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(383, 6, 14, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(384, 6, 15, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(385, 6, 16, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(386, 6, 17, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(387, 6, 18, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(388, 6, 19, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(389, 6, 20, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(390, 6, 21, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(391, 6, 23, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(392, 6, 24, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(393, 6, 25, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(394, 6, 26, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(395, 6, 28, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(396, 6, 29, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(397, 6, 30, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(398, 6, 31, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(399, 6, 32, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(400, 6, 33, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(401, 6, 34, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(402, 6, 35, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(403, 6, 67, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(404, 6, 68, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(405, 6, 37, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(406, 6, 38, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(407, 6, 66, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(408, 6, 40, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(409, 6, 41, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(410, 6, 42, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(411, 6, 43, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(412, 6, 44, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(413, 6, 45, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(414, 6, 47, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(415, 6, 48, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(416, 6, 69, 1, 1, 1, 1, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(417, 6, 50, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(418, 6, 51, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(419, 6, 52, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(420, 6, 53, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(421, 6, 54, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(422, 6, 56, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(423, 6, 57, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(424, 6, 58, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(425, 6, 59, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(426, 6, 60, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(427, 6, 61, 1, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(428, 6, 62, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(429, 7, 1, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(430, 7, 2, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(431, 7, 3, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(432, 7, 4, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(433, 7, 5, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(434, 7, 6, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(435, 7, 7, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(436, 7, 8, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(437, 7, 64, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(438, 7, 65, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(439, 7, 63, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(440, 7, 10, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(441, 7, 11, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(442, 7, 12, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(443, 7, 14, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(444, 7, 15, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(445, 7, 16, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(446, 7, 17, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(447, 7, 18, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(448, 7, 19, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(449, 7, 20, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(450, 7, 21, 0, 0, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(451, 7, 23, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(452, 7, 24, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(453, 7, 25, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(454, 7, 26, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(455, 7, 28, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(456, 7, 29, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(457, 7, 30, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(458, 7, 31, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(459, 7, 32, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(460, 7, 33, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(461, 7, 34, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(462, 7, 35, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(463, 7, 67, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(464, 7, 68, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(465, 7, 37, 1, 1, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(466, 7, 38, 1, 0, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(467, 7, 66, 1, 1, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(468, 7, 40, 0, 0, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(469, 7, 41, 0, 0, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(470, 7, 42, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(471, 7, 43, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(472, 7, 44, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(473, 7, 45, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(474, 7, 47, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(475, 7, 48, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(476, 7, 69, 1, 1, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(477, 7, 50, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(478, 7, 51, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(479, 7, 52, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(480, 7, 53, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(481, 7, 54, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(482, 7, 56, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(483, 7, 57, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(484, 7, 58, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(485, 7, 59, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(486, 7, 60, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(487, 7, 61, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(488, 7, 62, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(489, 8, 1, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(490, 8, 2, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(491, 8, 3, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(492, 8, 4, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(493, 8, 5, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(494, 8, 6, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(495, 8, 7, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(496, 8, 8, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(497, 8, 64, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(498, 8, 65, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(499, 8, 63, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(500, 8, 10, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(501, 8, 11, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(502, 8, 12, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(503, 8, 14, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(504, 8, 15, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(505, 8, 16, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(506, 8, 17, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(507, 8, 18, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(508, 8, 19, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(509, 8, 20, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(510, 8, 21, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(511, 8, 23, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(512, 8, 24, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(513, 8, 25, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(514, 8, 26, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(515, 8, 28, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(516, 8, 29, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(517, 8, 30, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(518, 8, 31, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(519, 8, 32, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(520, 8, 33, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(521, 8, 34, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(522, 8, 35, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(523, 8, 67, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(524, 8, 68, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(525, 8, 37, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(526, 8, 38, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(527, 8, 66, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(528, 8, 40, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(529, 8, 41, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(530, 8, 42, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(531, 8, 43, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(532, 8, 44, 0, 0, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(533, 8, 45, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(534, 8, 47, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(535, 8, 48, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(536, 8, 69, 1, 1, 1, 1, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(537, 8, 50, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(538, 8, 51, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(539, 8, 52, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(540, 8, 53, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(541, 8, 54, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(542, 8, 56, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(543, 8, 57, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(544, 8, 58, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(545, 8, 59, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(546, 8, 60, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(547, 8, 61, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(548, 8, 62, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(549, 9, 1, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(550, 9, 2, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(551, 9, 3, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(552, 9, 4, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(553, 9, 5, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(554, 9, 6, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(555, 9, 7, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(556, 9, 8, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(557, 9, 64, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(558, 9, 65, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(559, 9, 63, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(560, 9, 10, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(561, 9, 11, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(562, 9, 12, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(563, 9, 14, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(564, 9, 15, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(565, 9, 16, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(566, 9, 17, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(567, 9, 18, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(568, 9, 19, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(569, 9, 20, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(570, 9, 21, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(571, 9, 23, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(572, 9, 24, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(573, 9, 25, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(574, 9, 26, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(575, 9, 28, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(576, 9, 29, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(577, 9, 30, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(578, 9, 31, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(579, 9, 32, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(580, 9, 33, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(581, 9, 34, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(582, 9, 35, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(583, 9, 67, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(584, 9, 68, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(585, 9, 37, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(586, 9, 38, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(587, 9, 66, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(588, 9, 40, 0, 0, 1, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(589, 9, 41, 0, 0, 1, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(590, 9, 42, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(591, 9, 43, 0, 0, 1, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(592, 9, 44, 0, 0, 1, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(593, 9, 45, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(594, 9, 47, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(595, 9, 48, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(596, 9, 69, 1, 1, 1, 1, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(597, 9, 50, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(598, 9, 51, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(599, 9, 52, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(600, 9, 53, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(601, 9, 54, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(602, 9, 56, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(603, 9, 57, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(604, 9, 58, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(605, 9, 59, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(606, 9, 60, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(607, 9, 61, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(608, 9, 62, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(609, 1, 70, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(610, 1, 71, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(611, 1, 72, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(612, 1, 73, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(613, 1, 74, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(614, 1, 75, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(615, 1, 76, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(616, 1, 77, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(617, 1, 78, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(618, 4, 70, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(619, 4, 71, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(620, 4, 72, 0, 0, 1, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(621, 4, 73, 0, 0, 1, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(622, 4, 74, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(623, 4, 77, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(624, 4, 75, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(625, 4, 76, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(626, 4, 78, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(1224, 7, 101, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1223, 7, 100, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1222, 7, 85, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1221, 7, 84, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1220, 7, 83, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1219, 7, 82, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0);
INSERT INTO `privileges` (`id`, `role_id`, `operation_id`, `is_add`, `is_edit`, `is_view`, `is_delete`, `status`, `created_at`, `modified_at`, `created_by`, `modified_by`) VALUES
(1218, 7, 81, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1217, 7, 79, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1216, 7, 106, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1215, 6, 128, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1214, 6, 127, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1213, 6, 126, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1212, 6, 125, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1211, 6, 124, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1210, 6, 123, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1209, 6, 122, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1208, 6, 121, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1207, 6, 120, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1206, 6, 119, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1205, 6, 118, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1204, 6, 117, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1203, 6, 116, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1202, 6, 115, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1201, 6, 114, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1200, 6, 113, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1199, 6, 112, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1198, 6, 111, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1197, 6, 107, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1196, 6, 104, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1195, 6, 99, 1, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1194, 6, 98, 1, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1193, 6, 97, 1, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1192, 6, 96, 1, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1191, 6, 133, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1190, 6, 132, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1189, 6, 131, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1188, 6, 130, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1187, 6, 129, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1186, 6, 109, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1185, 6, 95, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1184, 6, 94, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1183, 6, 93, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1182, 6, 92, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1181, 6, 91, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1180, 6, 90, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1179, 6, 89, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1178, 6, 88, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1177, 6, 134, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1176, 6, 110, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1175, 6, 87, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1174, 6, 86, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1173, 6, 102, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1172, 6, 108, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1171, 6, 135, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1170, 6, 105, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1169, 6, 103, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1168, 6, 101, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1167, 6, 100, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1166, 6, 85, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1165, 6, 84, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1164, 6, 83, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1163, 6, 82, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1162, 6, 81, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1161, 6, 79, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1160, 6, 106, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1159, 5, 128, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1158, 5, 127, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1157, 5, 126, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1156, 5, 125, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(696, 3, 70, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(697, 3, 71, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(698, 3, 72, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(699, 3, 73, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(700, 3, 74, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(701, 3, 77, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(702, 3, 75, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(703, 3, 76, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(704, 3, 78, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(705, 9, 70, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(706, 9, 71, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(707, 9, 72, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(708, 9, 73, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(709, 9, 74, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(710, 9, 77, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(711, 9, 75, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(712, 9, 76, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(713, 9, 78, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(714, 8, 70, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(715, 8, 71, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(716, 8, 72, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(717, 8, 73, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(718, 8, 74, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(719, 8, 77, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(720, 8, 75, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(721, 8, 76, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(722, 8, 78, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(723, 7, 70, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(724, 7, 71, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(725, 7, 72, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(726, 7, 73, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(727, 7, 74, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(728, 7, 77, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(729, 7, 75, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(730, 7, 76, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(731, 7, 78, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(732, 6, 70, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(733, 6, 71, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(734, 6, 72, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(735, 6, 73, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(736, 6, 74, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(737, 6, 77, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(738, 6, 75, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(739, 6, 76, 1, 1, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(740, 6, 78, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(741, 2, 70, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(742, 2, 71, 0, 0, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(743, 2, 72, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(744, 2, 73, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(745, 2, 74, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(746, 2, 77, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(747, 2, 75, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(748, 2, 76, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(749, 2, 78, 0, 0, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(750, 13, 70, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(751, 13, 71, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(752, 13, 72, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(753, 13, 73, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(754, 13, 74, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(755, 13, 77, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(756, 13, 75, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(757, 13, 76, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(758, 13, 78, 0, 0, 0, 0, 1, '2018-04-16 07:42:13', '0000-00-00 00:00:00', 1, 0),
(759, 5, 70, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(760, 5, 71, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(761, 5, 72, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(762, 5, 73, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(763, 5, 74, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(764, 5, 77, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(765, 5, 75, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(766, 5, 76, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(767, 5, 78, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(768, 1, 79, 1, 1, 1, 1, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(769, 2, 79, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(770, 1, 80, 1, 1, 1, 1, 1, '2018-10-09 13:40:38', '0000-00-00 00:00:00', 1, 0),
(771, 1, 81, 1, 1, 1, 1, 1, '2020-06-20 14:51:50', '0000-00-00 00:00:00', 1, 0),
(772, 1, 82, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(773, 2, 80, 0, 0, 0, 0, 1, '2018-10-09 16:08:37', '0000-00-00 00:00:00', 1, 0),
(774, 2, 81, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(775, 2, 82, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(776, 1, 83, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(777, 1, 84, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(778, 1, 85, 0, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(779, 1, 100, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(780, 1, 101, 0, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(781, 1, 103, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(782, 1, 102, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(783, 1, 86, 1, 0, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(784, 1, 87, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(785, 1, 88, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(786, 1, 89, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(787, 1, 90, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(788, 1, 91, 1, 1, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(789, 1, 92, 0, 0, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(790, 1, 93, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(791, 1, 94, 1, 0, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(792, 1, 95, 0, 0, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(793, 1, 96, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(794, 1, 97, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(795, 1, 98, 1, 0, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(796, 1, 99, 1, 0, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(797, 1, 104, 1, 1, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(798, 3, 79, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(799, 3, 81, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(800, 3, 82, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(801, 3, 83, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(802, 3, 84, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(803, 3, 85, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(804, 3, 100, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(805, 3, 101, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(806, 3, 103, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(807, 3, 102, 1, 1, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(808, 3, 86, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(809, 3, 87, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(810, 3, 88, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(811, 3, 89, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(812, 3, 90, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(813, 3, 91, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(814, 3, 92, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(815, 3, 93, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(816, 3, 94, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(817, 3, 95, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(818, 3, 96, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(819, 3, 97, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(820, 3, 98, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(821, 3, 99, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(822, 3, 104, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(823, 2, 83, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(824, 2, 84, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(825, 2, 85, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(826, 2, 100, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(827, 2, 101, 0, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(828, 2, 103, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(829, 2, 102, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(830, 2, 86, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(831, 2, 87, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(832, 2, 88, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(833, 2, 89, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(834, 2, 90, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(835, 2, 91, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(836, 2, 92, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(837, 2, 93, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(838, 2, 94, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(839, 2, 95, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(840, 2, 96, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(841, 2, 97, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(842, 2, 98, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(843, 2, 99, 1, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(844, 2, 104, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(845, 1, 106, 0, 0, 0, 0, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(846, 1, 105, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(847, 2, 106, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(848, 2, 105, 0, 0, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(849, 2, 107, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(850, 1, 107, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(851, 1, 108, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(852, 1, 109, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(853, 1, 110, 0, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(854, 1, 111, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(855, 2, 108, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(856, 2, 110, 0, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(857, 2, 109, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(858, 2, 111, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(859, 2, 112, 1, 1, 1, 1, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(860, 1, 112, 0, 0, 0, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(861, 1, 113, 0, 0, 0, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(862, 1, 114, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(863, 1, 115, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(864, 2, 113, 1, 1, 1, 1, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(865, 2, 114, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(866, 2, 115, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(867, 1, 116, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(868, 1, 117, 0, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(869, 1, 118, 0, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(870, 1, 119, 0, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(871, 2, 116, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(872, 2, 117, 0, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(873, 2, 118, 0, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(874, 2, 119, 0, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(875, 1, 120, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(876, 1, 121, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(877, 1, 122, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(878, 1, 123, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(879, 1, 124, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(880, 1, 125, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(881, 1, 126, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(882, 2, 120, 0, 0, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(883, 2, 121, 0, 0, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(884, 2, 122, 0, 0, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(885, 2, 123, 0, 0, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(886, 2, 124, 0, 0, 0, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(887, 2, 125, 0, 0, 0, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(888, 2, 126, 0, 0, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(889, 2, 127, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(890, 2, 128, 1, 1, 1, 0, 1, '2020-06-20 14:52:19', '0000-00-00 00:00:00', 1, 0),
(891, 1, 129, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(892, 1, 130, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(893, 1, 131, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(894, 1, 132, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(895, 1, 133, 1, 1, 1, 1, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(896, 1, 127, 0, 0, 0, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(897, 1, 128, 0, 0, 0, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(898, 3, 106, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(899, 3, 105, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(900, 3, 108, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(901, 3, 110, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(902, 3, 109, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(903, 3, 129, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(904, 3, 130, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(905, 3, 131, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(906, 3, 132, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(907, 3, 133, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(908, 3, 107, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(909, 3, 111, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(910, 3, 112, 1, 1, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(911, 3, 113, 1, 1, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(912, 3, 114, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(913, 3, 115, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(914, 3, 116, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(915, 3, 117, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(916, 3, 118, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(917, 3, 119, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(918, 3, 120, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(919, 3, 121, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(920, 3, 122, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(921, 3, 123, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(922, 3, 124, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(923, 3, 125, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(924, 3, 126, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(925, 3, 127, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(926, 3, 128, 0, 0, 0, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(927, 4, 106, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(928, 4, 79, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(929, 4, 81, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(930, 4, 82, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(931, 4, 83, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(932, 4, 84, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(933, 4, 85, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(934, 4, 100, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(935, 4, 101, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(936, 4, 103, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(937, 4, 105, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(938, 4, 108, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(939, 4, 102, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(940, 4, 86, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(941, 4, 87, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(942, 4, 110, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(943, 4, 88, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(944, 4, 89, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(945, 4, 90, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(946, 4, 91, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(947, 4, 92, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(948, 4, 93, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(949, 4, 94, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(950, 4, 95, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(951, 4, 109, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(952, 4, 129, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(953, 4, 130, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(954, 4, 131, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(955, 4, 132, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(956, 4, 133, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(957, 4, 96, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(958, 4, 97, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(959, 4, 98, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(960, 4, 99, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(961, 4, 104, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(962, 4, 107, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(963, 4, 111, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(964, 4, 112, 1, 1, 1, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(965, 4, 113, 1, 1, 1, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(966, 4, 114, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(967, 4, 115, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(968, 4, 116, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(969, 4, 117, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(970, 4, 118, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(971, 4, 119, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(972, 4, 120, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(973, 4, 121, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(974, 4, 122, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(975, 4, 123, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(976, 4, 124, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(977, 4, 125, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(978, 4, 126, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(979, 4, 127, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(980, 4, 128, 0, 0, 0, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(981, 9, 106, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(982, 9, 79, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(983, 9, 81, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(984, 9, 82, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(985, 9, 83, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(986, 9, 84, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(987, 9, 85, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(988, 9, 100, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(989, 9, 101, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(990, 9, 103, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(991, 9, 105, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(992, 9, 108, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(993, 9, 102, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(994, 9, 86, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(995, 9, 87, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(996, 9, 110, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(997, 9, 88, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(998, 9, 89, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(999, 9, 90, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1000, 9, 91, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1001, 9, 92, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1002, 9, 93, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1003, 9, 94, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1004, 9, 95, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1005, 9, 109, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1006, 9, 129, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1007, 9, 130, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1008, 9, 131, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1009, 9, 132, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1010, 9, 133, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1011, 9, 96, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1012, 9, 97, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1013, 9, 98, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1014, 9, 99, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1015, 9, 104, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1016, 9, 107, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1017, 9, 111, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1018, 9, 112, 1, 1, 1, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1019, 9, 113, 1, 1, 1, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1020, 9, 114, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1021, 9, 115, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1022, 9, 116, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1023, 9, 117, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1024, 9, 118, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1025, 9, 119, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1026, 9, 120, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1027, 9, 121, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1028, 9, 122, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1029, 9, 123, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1030, 9, 124, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1031, 9, 125, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1032, 9, 126, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1033, 9, 127, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1034, 9, 128, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1035, 1, 134, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(1036, 2, 134, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1037, 2, 129, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1038, 2, 130, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1039, 2, 131, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1040, 2, 132, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1041, 2, 133, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1042, 1, 135, 0, 0, 1, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(1043, 2, 135, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1155, 5, 124, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1154, 5, 123, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1153, 5, 122, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1152, 5, 121, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1151, 5, 120, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1150, 5, 119, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1149, 5, 118, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1148, 5, 117, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1147, 5, 116, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1146, 5, 115, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1145, 5, 114, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1144, 5, 113, 1, 1, 1, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1143, 5, 112, 1, 1, 1, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1142, 5, 111, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1141, 5, 107, 0, 0, 0, 0, 1, '2020-06-20 14:53:27', '0000-00-00 00:00:00', 1, 0),
(1140, 5, 104, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1139, 5, 99, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1138, 5, 98, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1137, 5, 97, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1136, 5, 96, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1135, 5, 133, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1134, 5, 132, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1133, 5, 131, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1132, 5, 130, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1131, 5, 129, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1130, 5, 109, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1129, 5, 95, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1128, 5, 94, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1127, 5, 93, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1126, 5, 92, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1125, 5, 91, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1124, 5, 90, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1123, 5, 89, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1122, 5, 88, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1121, 5, 134, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1120, 5, 110, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1119, 5, 87, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1118, 5, 86, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1117, 5, 102, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1116, 5, 108, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1115, 5, 135, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1114, 5, 105, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1113, 5, 103, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1112, 5, 101, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1111, 5, 100, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1110, 5, 85, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1109, 5, 84, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1108, 5, 83, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1107, 5, 82, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1106, 5, 81, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1105, 5, 79, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1104, 5, 106, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1103, 4, 134, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1102, 4, 135, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1101, 3, 134, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(1100, 3, 135, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(1225, 7, 103, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1226, 7, 105, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1227, 7, 135, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1228, 7, 108, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1229, 7, 102, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1230, 7, 86, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1231, 7, 87, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1232, 7, 110, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1233, 7, 134, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1234, 7, 88, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1235, 7, 89, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1236, 7, 90, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1237, 7, 91, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1238, 7, 92, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1239, 7, 93, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1240, 7, 94, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1241, 7, 95, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1242, 7, 109, 1, 1, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1243, 7, 129, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1244, 7, 130, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1245, 7, 131, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1246, 7, 132, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1247, 7, 133, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1248, 7, 96, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1249, 7, 97, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1250, 7, 98, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1251, 7, 99, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1252, 7, 104, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1253, 7, 107, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1254, 7, 111, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1255, 7, 112, 1, 1, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1256, 7, 113, 1, 1, 1, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1257, 7, 114, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1258, 7, 115, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1259, 7, 116, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1260, 7, 117, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1261, 7, 118, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1262, 7, 119, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1263, 7, 120, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1264, 7, 121, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1265, 7, 122, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1266, 7, 123, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1267, 7, 124, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1268, 7, 125, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1269, 7, 126, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1270, 7, 127, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1271, 7, 128, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1272, 8, 106, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1273, 8, 79, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1274, 8, 81, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1275, 8, 82, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1276, 8, 83, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1277, 8, 84, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1278, 8, 85, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1279, 8, 100, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1280, 8, 101, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1281, 8, 103, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1282, 8, 105, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1283, 8, 135, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1284, 8, 108, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1285, 8, 102, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1286, 8, 86, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1287, 8, 87, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1288, 8, 110, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1289, 8, 134, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1290, 8, 88, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1291, 8, 89, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1292, 8, 90, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1293, 8, 91, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1294, 8, 92, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1295, 8, 93, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1296, 8, 94, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1297, 8, 95, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1298, 8, 109, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1299, 8, 129, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1300, 8, 130, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1301, 8, 131, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1302, 8, 132, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1303, 8, 133, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1304, 8, 96, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1305, 8, 97, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1306, 8, 98, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1307, 8, 99, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1308, 8, 104, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1309, 8, 107, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1310, 8, 111, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1311, 8, 112, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1312, 8, 113, 1, 1, 1, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1313, 8, 114, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1314, 8, 115, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1315, 8, 116, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1316, 8, 117, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1317, 8, 118, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1318, 8, 119, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1319, 8, 120, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1320, 8, 121, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1321, 8, 122, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1322, 8, 123, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1323, 8, 124, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1324, 8, 125, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1325, 8, 126, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1326, 8, 127, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1327, 8, 128, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1328, 9, 135, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1329, 9, 134, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1330, 14, 1, 0, 0, 1, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1331, 14, 2, 0, 0, 1, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1332, 14, 3, 0, 0, 1, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1333, 14, 106, 0, 0, 1, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1334, 14, 4, 0, 0, 1, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1335, 14, 5, 0, 0, 1, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1336, 14, 6, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1337, 14, 7, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1338, 14, 8, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1339, 14, 64, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1340, 14, 65, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1341, 14, 63, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1342, 14, 79, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1343, 14, 81, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1344, 14, 82, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1345, 14, 83, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1346, 14, 84, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1347, 14, 85, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1348, 14, 100, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1349, 14, 101, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1350, 14, 103, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1351, 14, 105, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1352, 14, 135, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1353, 14, 10, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1354, 14, 11, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1355, 14, 12, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1356, 14, 14, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1357, 14, 15, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1358, 14, 16, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1359, 14, 17, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1360, 14, 18, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1361, 14, 19, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1362, 14, 108, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1363, 14, 20, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1364, 14, 102, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1365, 14, 21, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1366, 14, 86, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1367, 14, 87, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1368, 14, 110, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1369, 14, 134, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1370, 14, 23, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1371, 14, 24, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1372, 14, 25, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1373, 14, 88, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1374, 14, 89, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1375, 14, 26, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1376, 14, 28, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1377, 14, 29, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1378, 14, 30, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0);
INSERT INTO `privileges` (`id`, `role_id`, `operation_id`, `is_add`, `is_edit`, `is_view`, `is_delete`, `status`, `created_at`, `modified_at`, `created_by`, `modified_by`) VALUES
(1379, 14, 31, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1380, 14, 32, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1381, 14, 33, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1382, 14, 34, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1383, 14, 35, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1384, 14, 67, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1385, 14, 68, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1386, 14, 90, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1387, 14, 91, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1388, 14, 92, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1389, 14, 93, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1390, 14, 94, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1391, 14, 95, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1392, 14, 37, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1393, 14, 38, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1394, 14, 66, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1395, 14, 109, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1396, 14, 40, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1397, 14, 41, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1398, 14, 42, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1399, 14, 43, 0, 0, 0, 0, 1, '2019-09-09 19:57:03', '0000-00-00 00:00:00', 1, 0),
(1400, 14, 44, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1401, 14, 45, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1402, 14, 47, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1403, 14, 48, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1404, 14, 69, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1405, 14, 50, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1406, 14, 51, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1407, 14, 52, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1408, 14, 53, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1409, 14, 54, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1410, 14, 129, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1411, 14, 130, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1412, 14, 131, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1413, 14, 132, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1414, 14, 133, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1415, 14, 56, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1416, 14, 57, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1417, 14, 58, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1418, 14, 59, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1419, 14, 60, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1420, 14, 61, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1421, 14, 96, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1422, 14, 97, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1423, 14, 98, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1424, 14, 99, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1425, 14, 62, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1426, 14, 70, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1427, 14, 71, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1428, 14, 72, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1429, 14, 73, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1430, 14, 74, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1431, 14, 77, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1432, 14, 104, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1433, 14, 75, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1434, 14, 76, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1435, 14, 78, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1436, 14, 107, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1437, 14, 111, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1438, 14, 112, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1439, 14, 113, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1440, 14, 114, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1441, 14, 115, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1442, 14, 116, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1443, 14, 117, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1444, 14, 118, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1445, 14, 119, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1446, 14, 120, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1447, 14, 121, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1448, 14, 122, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1449, 14, 123, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1450, 14, 124, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1451, 14, 125, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1452, 14, 126, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1453, 14, 127, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1454, 14, 128, 0, 0, 0, 0, 1, '2019-09-09 19:57:04', '0000-00-00 00:00:00', 1, 0),
(1455, 1, 136, 0, 0, 1, 0, 1, '2020-06-20 14:51:52', '0000-00-00 00:00:00', 1, 0),
(1456, 1, 138, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(1457, 1, 137, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(1458, 2, 138, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1459, 2, 137, 1, 1, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1460, 2, 136, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1461, 3, 138, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(1462, 3, 137, 1, 1, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(1463, 3, 136, 0, 0, 1, 0, 1, '2020-06-20 14:52:49', '0000-00-00 00:00:00', 1, 0),
(1464, 4, 138, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1465, 4, 137, 1, 1, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1466, 4, 136, 0, 0, 1, 0, 1, '2020-06-20 14:53:02', '0000-00-00 00:00:00', 1, 0),
(1467, 5, 138, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1468, 5, 137, 1, 1, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1469, 5, 136, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1470, 1, 139, 0, 1, 0, 0, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(1471, 1, 140, 0, 0, 1, 0, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(1472, 1, 141, 0, 0, 1, 0, 1, '2020-06-20 14:51:49', '0000-00-00 00:00:00', 1, 0),
(1473, 2, 140, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1474, 2, 141, 0, 0, 1, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1475, 2, 139, 0, 1, 0, 0, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1476, 5, 140, 0, 0, 1, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1477, 5, 141, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1478, 5, 139, 0, 0, 0, 0, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0),
(1479, 3, 140, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(1480, 3, 141, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(1481, 3, 139, 0, 0, 0, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(1482, 4, 140, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1483, 4, 141, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1484, 4, 139, 0, 0, 0, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1485, 6, 140, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1486, 6, 141, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1487, 6, 139, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1488, 6, 138, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1489, 6, 137, 0, 0, 0, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1490, 6, 136, 0, 0, 1, 0, 1, '2020-06-13 13:28:38', '0000-00-00 00:00:00', 1, 0),
(1491, 7, 140, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1492, 7, 141, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1493, 7, 139, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1494, 7, 138, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1495, 7, 137, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1496, 7, 136, 0, 0, 0, 0, 1, '2020-06-13 13:29:03', '0000-00-00 00:00:00', 1, 0),
(1497, 8, 140, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1498, 8, 141, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1499, 8, 139, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1500, 8, 138, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1501, 8, 137, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1502, 8, 136, 0, 0, 0, 0, 1, '2020-06-13 13:29:21', '0000-00-00 00:00:00', 1, 0),
(1503, 9, 140, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1504, 9, 141, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1505, 9, 139, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1506, 9, 138, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1507, 9, 137, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1508, 9, 136, 0, 0, 0, 0, 1, '2020-06-13 13:29:35', '0000-00-00 00:00:00', 1, 0),
(1509, 1, 142, 1, 1, 1, 1, 1, '2020-06-20 14:51:51', '0000-00-00 00:00:00', 1, 0),
(1510, 2, 142, 1, 1, 1, 1, 1, '2020-06-20 14:52:18', '0000-00-00 00:00:00', 1, 0),
(1511, 3, 142, 0, 0, 1, 0, 1, '2020-06-20 14:52:48', '0000-00-00 00:00:00', 1, 0),
(1512, 4, 142, 0, 0, 1, 0, 1, '2020-06-20 14:53:01', '0000-00-00 00:00:00', 1, 0),
(1513, 5, 142, 1, 1, 1, 1, 1, '2020-06-20 14:53:26', '0000-00-00 00:00:00', 1, 0);


ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1514;



-- INDEX IN THE TABLE --
ALTER TABLE `academic_years` ADD INDEX(`school_id`);
ALTER TABLE `activity_logs` ADD INDEX(`school_id`);
ALTER TABLE `activity_logs` ADD INDEX(`user_id`);
ALTER TABLE `activity_logs` ADD INDEX(`role_id`);
ALTER TABLE `admissions` ADD INDEX(`school_id`);
ALTER TABLE `admissions` ADD INDEX(`class_id`);
ALTER TABLE `admit_card_settings` ADD INDEX(`school_id`);
ALTER TABLE `assignments` ADD INDEX(`school_id`);
ALTER TABLE `assignments` ADD INDEX(`class_id`);
ALTER TABLE `assignments` ADD INDEX(`section_id`);
ALTER TABLE `assignments` ADD INDEX(`subject_id`);
ALTER TABLE `assignments` ADD INDEX(`academic_year_id`);
ALTER TABLE `assignment_submissions` ADD INDEX(`id`);
ALTER TABLE `assignment_submissions` ADD INDEX(`school_id`);
ALTER TABLE `assignment_submissions` ADD INDEX(`assignment_id`);
ALTER TABLE `assignment_submissions` ADD INDEX(`academic_year_id`);
ALTER TABLE `assignment_submissions` ADD INDEX(`class_id`);
ALTER TABLE `assignment_submissions` ADD INDEX(`section_id`);
ALTER TABLE `assignment_submissions` ADD INDEX(`student_id`);
ALTER TABLE `books` ADD INDEX(`school_id`);
ALTER TABLE `books` ADD INDEX(`custom_id`);
ALTER TABLE `book_issues` ADD INDEX(`school_id`);
ALTER TABLE `book_issues` ADD INDEX(`academic_year_id`);
ALTER TABLE `book_issues` ADD INDEX(`library_member_id`);
ALTER TABLE `book_issues` ADD INDEX(`book_id`);
ALTER TABLE `certificates` ADD INDEX(`school_id`);
ALTER TABLE `classes` ADD INDEX(`school_id`);
ALTER TABLE `classes` ADD INDEX(`teacher_id`);
ALTER TABLE `complains` ADD INDEX(`id`);
ALTER TABLE `complains` ADD INDEX(`school_id`);
ALTER TABLE `complains` ADD INDEX(`academic_year_id`);
ALTER TABLE `complains` ADD INDEX(`role_id`);
ALTER TABLE `complains` ADD INDEX(`user_id`);
ALTER TABLE `complains` ADD INDEX(`class_id`);
ALTER TABLE `complains` ADD INDEX(`type_id`);
ALTER TABLE `complain_types` ADD INDEX(`school_id`);
ALTER TABLE `designations` ADD INDEX(`school_id`);
ALTER TABLE `discounts` ADD INDEX(`school_id`);
ALTER TABLE `ebooks` ADD INDEX(`id`);
ALTER TABLE `ebooks` ADD INDEX(`school_id`);
ALTER TABLE `ebooks` ADD INDEX(`class_id`);
ALTER TABLE `ebooks` ADD INDEX(`subject_id`);
ALTER TABLE `emails` ADD INDEX(`school_id`);
ALTER TABLE `emails` ADD INDEX(`role_id`);
ALTER TABLE `emails` ADD INDEX(`sender_role_id`);
ALTER TABLE `emails` ADD INDEX(`academic_year_id`);
ALTER TABLE `email_settings` ADD INDEX(`id`);
ALTER TABLE `email_settings` ADD INDEX(`school_id`);
ALTER TABLE `email_templates` ADD INDEX(`school_id`);
ALTER TABLE `email_templates` ADD INDEX(`role_id`);
ALTER TABLE `employees` ADD INDEX(`user_id`);
ALTER TABLE `employees` ADD INDEX(`school_id`);
ALTER TABLE `employees` ADD INDEX(`designation_id`);
ALTER TABLE `employees` ADD INDEX(`salary_grade_id`);
ALTER TABLE `employee_attendances` ADD INDEX(`school_id`);
ALTER TABLE `employee_attendances` ADD INDEX(`employee_id`);
ALTER TABLE `employee_attendances` ADD INDEX(`academic_year_id`);
ALTER TABLE `enrollments` ADD INDEX(`school_id`);
ALTER TABLE `enrollments` ADD INDEX(`student_id`);
ALTER TABLE `enrollments` ADD INDEX(`class_id`);
ALTER TABLE `enrollments` ADD INDEX(`section_id`);
ALTER TABLE `enrollments` ADD INDEX(`academic_year_id`);
ALTER TABLE `events` ADD INDEX(`school_id`);
ALTER TABLE `events` ADD INDEX(`role_id`);
ALTER TABLE `exams` ADD INDEX(`school_id`);
ALTER TABLE `exams` ADD INDEX(`academic_year_id`);
ALTER TABLE `exam_attendances` ADD INDEX(`school_id`);
ALTER TABLE `exam_attendances` ADD INDEX(`exam_id`);
ALTER TABLE `exam_attendances` ADD INDEX(`class_id`);
ALTER TABLE `exam_attendances` ADD INDEX(`section_id`);
ALTER TABLE `exam_attendances` ADD INDEX(`subject_id`);
ALTER TABLE `exam_attendances` ADD INDEX(`academic_year_id`);
ALTER TABLE `exam_attendances` ADD INDEX(`student_id`);
ALTER TABLE `exam_results` ADD INDEX(`school_id`);
ALTER TABLE `exam_results` ADD INDEX(`exam_id`);
ALTER TABLE `exam_results` ADD INDEX(`class_id`);
ALTER TABLE `exam_results` ADD INDEX(`section_id`);
ALTER TABLE `exam_results` ADD INDEX(`academic_year_id`);
ALTER TABLE `exam_results` ADD INDEX(`student_id`);
ALTER TABLE `exam_schedules` ADD INDEX(`school_id`);
ALTER TABLE `exam_schedules` ADD INDEX(`exam_id`);
ALTER TABLE `exam_schedules` ADD INDEX(`class_id`);
ALTER TABLE `exam_schedules` ADD INDEX(`subject_id`);
ALTER TABLE `exam_schedules` ADD INDEX(`academic_year_id`);
ALTER TABLE `expenditures` ADD INDEX(`school_id`);
ALTER TABLE `expenditures` ADD INDEX(`academic_year_id`);
ALTER TABLE `expenditures` ADD INDEX(`expenditure_head_id`);
ALTER TABLE `expenditure_heads` ADD INDEX(`school_id`);
ALTER TABLE `fees_amount` ADD INDEX(`school_id`);
ALTER TABLE `fees_amount` ADD INDEX(`income_head_id`);
ALTER TABLE `fees_amount` ADD INDEX(`class_id`);
ALTER TABLE `final_results` ADD INDEX(`school_id`);
ALTER TABLE `final_results` ADD INDEX(`class_id`);
ALTER TABLE `final_results` ADD INDEX(`section_id`);
ALTER TABLE `final_results` ADD INDEX(`academic_year_id`);
ALTER TABLE `final_results` ADD INDEX(`student_id`);
ALTER TABLE `final_results` ADD INDEX(`grade_id`);
ALTER TABLE `galleries` ADD INDEX(`school_id`);
ALTER TABLE `gallery_images` ADD INDEX(`school_id`);
ALTER TABLE `gallery_images` ADD INDEX(`gallery_id`);
ALTER TABLE `global_setting` ADD INDEX(`id`);
ALTER TABLE `grades` ADD INDEX(`school_id`);
ALTER TABLE `guardians` ADD INDEX(`school_id`);
ALTER TABLE `guardians` ADD INDEX(`user_id`);
ALTER TABLE `guardian_feedbacks` ADD INDEX(`id`);
ALTER TABLE `guardian_feedbacks` ADD INDEX(`school_id`);
ALTER TABLE `guardian_feedbacks` ADD INDEX(`guardian_id`);
ALTER TABLE `holidays` ADD INDEX(`school_id`);
ALTER TABLE `hostels` ADD INDEX(`school_id`);
ALTER TABLE `hostel_members` ADD INDEX(`school_id`);
ALTER TABLE `hostel_members` ADD INDEX(`user_id`);
ALTER TABLE `hostel_members` ADD INDEX(`custom_member_id`);
ALTER TABLE `hostel_members` ADD INDEX(`hostel_id`);
ALTER TABLE `hostel_members` ADD INDEX(`room_id`);
ALTER TABLE `id_card_settings` ADD INDEX(`school_id`);
ALTER TABLE `income_heads` ADD INDEX(`school_id`);
ALTER TABLE `invoices` ADD INDEX(`school_id`);
ALTER TABLE `invoices` ADD INDEX(`custom_invoice_id`);
ALTER TABLE `invoices` ADD INDEX(`academic_year_id`);
ALTER TABLE `invoices` ADD INDEX(`class_id`);
ALTER TABLE `invoices` ADD INDEX(`student_id`);
ALTER TABLE `invoice_detail` ADD INDEX(`id`);
ALTER TABLE `invoice_detail` ADD INDEX(`school_id`);
ALTER TABLE `invoice_detail` ADD INDEX(`invoice_id`);
ALTER TABLE `invoice_detail` ADD INDEX(`income_head_id`);
ALTER TABLE `languages` ADD INDEX(`id`);
ALTER TABLE `languages` ADD INDEX(`label`);
ALTER TABLE `leave_applications` ADD INDEX(`id`);
ALTER TABLE `leave_applications` ADD INDEX(`school_id`);
ALTER TABLE `leave_applications` ADD INDEX(`academic_year_id`);
ALTER TABLE `leave_applications` ADD INDEX(`role_id`);
ALTER TABLE `leave_applications` ADD INDEX(`user_id`);
ALTER TABLE `leave_applications` ADD INDEX(`class_id`);
ALTER TABLE `leave_applications` ADD INDEX(`type_id`);
ALTER TABLE `leave_types` ADD INDEX(`school_id`);
ALTER TABLE `leave_types` ADD INDEX(`role_id`);
ALTER TABLE `library_members` ADD INDEX(`school_id`);
ALTER TABLE `library_members` ADD INDEX(`user_id`);
ALTER TABLE `library_members` ADD INDEX(`custom_member_id`);
ALTER TABLE `marks` ADD INDEX(`school_id`);
ALTER TABLE `marks` ADD INDEX(`exam_id`);
ALTER TABLE `marks` ADD INDEX(`class_id`);
ALTER TABLE `marks` ADD INDEX(`section_id`);
ALTER TABLE `marks` ADD INDEX(`subject_id`);
ALTER TABLE `marks` ADD INDEX(`academic_year_id`);
ALTER TABLE `marks` ADD INDEX(`student_id`);
ALTER TABLE `marks` ADD INDEX(`grade_id`);
ALTER TABLE `mark_emails` ADD INDEX(`school_id`);
ALTER TABLE `mark_emails` ADD INDEX(`exam_id`);
ALTER TABLE `mark_emails` ADD INDEX(`class_id`);
ALTER TABLE `mark_emails` ADD INDEX(`role_id`);
ALTER TABLE `mark_emails` ADD INDEX(`academic_year_id`);
ALTER TABLE `mark_emails` ADD INDEX(`sender_role_id`);
ALTER TABLE `mark_smses` ADD INDEX(`school_id`);
ALTER TABLE `mark_smses` ADD INDEX(`exam_id`);
ALTER TABLE `mark_smses` ADD INDEX(`class_id`);
ALTER TABLE `mark_smses` ADD INDEX(`role_id`);
ALTER TABLE `mark_smses` ADD INDEX(`academic_year_id`);
ALTER TABLE `mark_smses` ADD INDEX(`sender_role_id`);
ALTER TABLE `messages` ADD INDEX(`school_id`);
ALTER TABLE `messages` ADD INDEX(`academic_year_id`);
ALTER TABLE `message_relationships` ADD INDEX(`school_id`);
ALTER TABLE `message_relationships` ADD INDEX(`message_id`);
ALTER TABLE `message_relationships` ADD INDEX(`sender_id`);
ALTER TABLE `message_relationships` ADD INDEX(`receiver_id`);
ALTER TABLE `message_relationships` ADD INDEX(`owner_id`);
ALTER TABLE `message_relationships` ADD INDEX(`role_id`);
ALTER TABLE `news` ADD INDEX(`school_id`);
ALTER TABLE `notices` ADD INDEX(`school_id`);
ALTER TABLE `notices` ADD INDEX(`role_id`);
ALTER TABLE `operations` ADD INDEX(`module_id`);
ALTER TABLE `pages` ADD INDEX(`school_id`);
ALTER TABLE `payment_settings` ADD INDEX(`school_id`);
ALTER TABLE `phone_call_logs` ADD INDEX(`school_id`);
ALTER TABLE `postal_dispatches` ADD INDEX(`school_id`);
ALTER TABLE `postal_receives` ADD INDEX(`school_id`);
ALTER TABLE `privileges` ADD INDEX(`role_id`);
ALTER TABLE `privileges` ADD INDEX(`operation_id`);
ALTER TABLE `purchase` ADD PRIMARY KEY(`id`);
ALTER TABLE `purchase` ADD INDEX(`id`);
ALTER TABLE `replies` ADD INDEX(`message_id`);
ALTER TABLE `replies` ADD INDEX(`sender_id`);
ALTER TABLE `replies` ADD INDEX(`receiver_id`);
ALTER TABLE `results` ADD INDEX(`school_id`);
ALTER TABLE `results` ADD INDEX(`class_id`);
ALTER TABLE `results` ADD INDEX(`section_id`);
ALTER TABLE `results` ADD INDEX(`academic_year_id`);
ALTER TABLE `results` ADD INDEX(`student_id`);
ALTER TABLE `rooms` ADD INDEX(`school_id`);
ALTER TABLE `rooms` ADD INDEX(`hostel_id`);
ALTER TABLE `routes` ADD INDEX(`school_id`);
ALTER TABLE `route_stops` ADD INDEX(`school_id`);
ALTER TABLE `route_stops` ADD INDEX(`route_id`);
ALTER TABLE `routines` ADD INDEX(`school_id`);
ALTER TABLE `routines` ADD INDEX(`class_id`);
ALTER TABLE `routines` ADD INDEX(`section_id`);
ALTER TABLE `routines` ADD INDEX(`subject_id`);
ALTER TABLE `routines` ADD INDEX(`teacher_id`);
ALTER TABLE `routines` ADD INDEX(`academic_year_id`);
ALTER TABLE `salary_grades` ADD INDEX(`school_id`);
ALTER TABLE `salary_payments` ADD INDEX(`school_id`);
ALTER TABLE `salary_payments` ADD INDEX(`user_id`);
ALTER TABLE `salary_payments` ADD INDEX(`salary_grade_id`);
ALTER TABLE `salary_payments` ADD INDEX(`academic_year_id`);
ALTER TABLE `salary_payments` ADD INDEX(`expenditure_id`);
ALTER TABLE `sections` ADD INDEX(`school_id`);
ALTER TABLE `sections` ADD INDEX(`class_id`);
ALTER TABLE `sections` ADD INDEX(`teacher_id`);
ALTER TABLE `sliders` ADD INDEX(`school_id`);
ALTER TABLE `sms_settings` ADD INDEX(`id`);
ALTER TABLE `sms_settings` ADD INDEX(`school_id`);
ALTER TABLE `sms_templates` ADD INDEX(`school_id`);
ALTER TABLE `sms_templates` ADD INDEX(`role_id`);
ALTER TABLE `students` ADD INDEX(`school_id`);
ALTER TABLE `students` ADD INDEX(`user_id`);
ALTER TABLE `students` ADD INDEX(`type_id`);
ALTER TABLE `students` ADD INDEX(`guardian_id`);
ALTER TABLE `student_activities` ADD INDEX(`id`);
ALTER TABLE `student_activities` ADD INDEX(`school_id`);
ALTER TABLE `student_activities` ADD INDEX(`student_id`);
ALTER TABLE `student_activities` ADD INDEX(`class_id`);
ALTER TABLE `student_activities` ADD INDEX(`section_id`);
ALTER TABLE `student_activities` ADD INDEX(`academic_year_id`);
ALTER TABLE `student_attendances` ADD INDEX(`id`);
ALTER TABLE `student_attendances` ADD INDEX(`school_id`);
ALTER TABLE `student_attendances` ADD INDEX(`student_id`);
ALTER TABLE `student_attendances` ADD INDEX(`academic_year_id`);
ALTER TABLE `student_attendances` ADD INDEX(`class_id`);
ALTER TABLE `student_attendances` ADD INDEX(`section_id`);
ALTER TABLE `student_types` ADD INDEX(`school_id`);
ALTER TABLE `study_materials` ADD INDEX(`id`);
ALTER TABLE `study_materials` ADD INDEX(`school_id`);
ALTER TABLE `study_materials` ADD INDEX(`class_id`);
ALTER TABLE `study_materials` ADD INDEX(`subject_id`);
ALTER TABLE `subjects` ADD INDEX(`school_id`);
ALTER TABLE `subjects` ADD INDEX(`class_id`);
ALTER TABLE `subjects` ADD INDEX(`teacher_id`);
ALTER TABLE `suggestions` ADD INDEX(`school_id`);
ALTER TABLE `suggestions` ADD INDEX(`exam_id`);
ALTER TABLE `suggestions` ADD INDEX(`class_id`);
ALTER TABLE `suggestions` ADD INDEX(`subject_id`);
ALTER TABLE `suggestions` ADD INDEX(`academic_year_id`);
ALTER TABLE `syllabuses` ADD INDEX(`school_id`);
ALTER TABLE `syllabuses` ADD INDEX(`class_id`);
ALTER TABLE `syllabuses` ADD INDEX(`subject_id`);
ALTER TABLE `syllabuses` ADD INDEX(`academic_year_id`);
ALTER TABLE `system_admin` ADD INDEX(`user_id`);
ALTER TABLE `teachers` ADD INDEX(`school_id`);
ALTER TABLE `teachers` ADD INDEX(`salary_grade_id`);
ALTER TABLE `teacher_attendances` ADD INDEX(`school_id`);
ALTER TABLE `teacher_attendances` ADD INDEX(`teacher_id`);
ALTER TABLE `teacher_attendances` ADD INDEX(`academic_year_id`);
ALTER TABLE `text_messages` ADD INDEX(`school_id`);
ALTER TABLE `text_messages` ADD INDEX(`role_id`);
ALTER TABLE `text_messages` ADD INDEX(`sender_role_id`);
ALTER TABLE `text_messages` ADD INDEX(`academic_year_id`);
ALTER TABLE `transactions` ADD INDEX(`school_id`);
ALTER TABLE `transactions` ADD INDEX(`academic_year_id`);
ALTER TABLE `transactions` ADD INDEX(`invoice_id`);
ALTER TABLE `transport_members` ADD INDEX(`school_id`);
ALTER TABLE `transport_members` ADD INDEX(`user_id`);
ALTER TABLE `transport_members` ADD INDEX(`route_id`);
ALTER TABLE `transport_members` ADD INDEX(`route_stop_id`);
ALTER TABLE `users` ADD INDEX(`role_id`);
ALTER TABLE `users` ADD INDEX(`school_id`);
ALTER TABLE `vehicles` ADD INDEX(`school_id`);
ALTER TABLE `video_lectures` ADD INDEX(`id`);
ALTER TABLE `video_lectures` ADD INDEX(`school_id`);
ALTER TABLE `video_lectures` ADD INDEX(`academic_year_id`);
ALTER TABLE `video_lectures` ADD INDEX(`class_id`);
ALTER TABLE `video_lectures` ADD INDEX(`section_id`);
ALTER TABLE `video_lectures` ADD INDEX(`subject_id`);
ALTER TABLE `video_lectures` ADD INDEX(`teacher_id`);
ALTER TABLE `visitors` ADD INDEX(`school_id`);
ALTER TABLE `visitors` ADD INDEX(`academic_year_id`);
ALTER TABLE `visitors` ADD INDEX(`role_id`);
ALTER TABLE `visitors` ADD INDEX(`user_id`);
ALTER TABLE `visitors` ADD INDEX(`class_id`);
ALTER TABLE `visitors` ADD INDEX(`purpose_id`);
ALTER TABLE `visitor_purposes` ADD INDEX(`school_id`);