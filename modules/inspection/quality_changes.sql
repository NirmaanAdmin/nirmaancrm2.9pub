INSERT INTO `tblmodules` (`module_name`, `installed_version`, `active`) VALUES ('inspection', '1.0', '1');

DROP TABLE IF EXISTS `tblinspection_types`;
CREATE TABLE IF NOT EXISTS `tblinspection_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` text NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `tblinspection_types` (`id`, `label`, `name`) VALUES
(1, 'setting_out', 'Setting out'),
(2, 'excavation', 'Excavation'),
(3, 'anti_termite', 'Anti-Termite'),
(4, 'reinforcement', 'Reinforcement'),
(5, '', 'Plain Cement Concrete (PCC)'),
(6, '', 'Footing'),
(7, '', 'Shuttering'),
(8, '', 'Reinforced Cement Concrete (RCC)'),
(9, '', 'Concrete for Column Casting'),
(10, '', 'Beam and Slab Casting'),
(11, '', 'Brickwork/Blockwork'),
(12, '', 'Filling and Compaction'),
(13, '', 'Structural Steel Work'),
(14, '', 'Ceiling Plaster'),
(15, '', 'External Plaster'),
(16, '', 'Internal Plaster'),
(17, '', 'Floor Tile'),
(18, '', 'Wall Tile'),
(19, '', 'Door Fixing'),
(20, '', 'Flush Door Shutter'),
(21, '', 'Metal (MS) work'),
(22, '', 'Painting (External)'),
(23, '', 'Painting (Internal)'),
(24, '', 'Water Proofing'),
(25, '', 'Plumbing Work'),
(26, '', 'False Ceiling'),
(27, '', 'Safety and Housekeeping');

DROP TABLE IF EXISTS `tblinspections`;
CREATE TABLE IF NOT EXISTS `tblinspections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL DEFAULT '0',
  `inspection_type_id` int NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `done_by` text,
  `reviewers` text,
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int DEFAULT NULL,
  `recurring` int NOT NULL DEFAULT '0',
  `custom_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `cycles` int NOT NULL DEFAULT '0',
  `total_cycles` int NOT NULL DEFAULT '0',
  `last_recurring_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblsetting_out`;
CREATE TABLE IF NOT EXISTS `tblsetting_out` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `location` text NOT NULL,
  `surveyed_by` text,
  `checked_by` text,
  `calibration_equipment` text,
  `reference_drawing` text,
  `boundary_line` varchar(255) DEFAULT NULL,
  `remark_1` text,
  `back_distances_available` varchar(255) DEFAULT NULL,
  `remark_2` text,
  `benchmark_available` varchar(255) DEFAULT NULL,
  `remark_3` text,
  `remark_4` text,
  `extra_notes` longtext,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblsetting_out_files`;
CREATE TABLE IF NOT EXISTS `tblsetting_out_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `attachment_name` varchar(255) NOT NULL,
  `file_name` text NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblexcavation`;
CREATE TABLE IF NOT EXISTS `tblexcavation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `location` text NOT NULL,
  `question1` varchar(255) DEFAULT NULL,
  `remark1` text,
  `question2` varchar(255) DEFAULT NULL,
  `remark2` text,
  `question3` varchar(255) DEFAULT NULL,
  `remark3` text,
  `question4` varchar(255) DEFAULT NULL,
  `remark4` text,
  `question5` varchar(255) DEFAULT NULL,
  `remark5` text,
  `question6` varchar(255) DEFAULT NULL,
  `remark6` text,
  `question7` varchar(255) DEFAULT NULL,
  `remark7` text,
  `remark8` text,
  `extra_notes` longtext,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblexcavation_files`;
CREATE TABLE IF NOT EXISTS `tblexcavation_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `attachment_name` varchar(255) NOT NULL,
  `file_name` text NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblanti_termite`;
CREATE TABLE IF NOT EXISTS `tblanti_termite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `location` text NOT NULL,
  `question1` varchar(255) DEFAULT NULL,
  `remark1` text,
  `question2` varchar(255) DEFAULT NULL,
  `remark2` text,
  `question3` varchar(255) DEFAULT NULL,
  `remark3` text,
  `question4` varchar(255) DEFAULT NULL,
  `remark4` text,
  `question5` varchar(255) DEFAULT NULL,
  `remark5` text,
  `question6` varchar(255) DEFAULT NULL,
  `remark6` text,
  `question7` varchar(255) DEFAULT NULL,
  `remark7` text,
  `question8` varchar(255) DEFAULT NULL,
  `remark8` text,
  `question9` varchar(255) DEFAULT NULL,
  `remark9` text,
  `extra_notes` longtext,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblanti_termite_files`;
CREATE TABLE IF NOT EXISTS `tblanti_termite_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `attachment_name` varchar(255) NOT NULL,
  `file_name` text NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblreinforcement`;
CREATE TABLE IF NOT EXISTS `tblreinforcement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `dwg_no` text NOT NULL,
  `revision_no` text,
  `question1` varchar(255) DEFAULT NULL,
  `remark1` text,
  `remark2` text,
  `question3` varchar(255) DEFAULT NULL,
  `remark3` text,
  `remark4` text,
  `question5` varchar(255) DEFAULT NULL,
  `remark5` text,
  `remark6` text,
  `remark7` text,
  `remark8` text,
  `remark9` text,
  `remark10` text,
  `extra_notes` longtext,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tblreinforcement_files`;
CREATE TABLE IF NOT EXISTS `tblreinforcement_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int NOT NULL,
  `attachment_name` varchar(255) NOT NULL,
  `file_name` text NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
);
