-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de table preinscription_tempsamenage. actualites
CREATE TABLE IF NOT EXISTS `actualites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `published_at` date DEFAULT NULL,
  `finished_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.actualites : ~0 rows (environ)
INSERT INTO `actualites` (`id`, `image`, `titre`, `description`, `user_id`, `published_at`, `finished_at`, `created_at`, `updated_at`) VALUES
	(1, 'files/actualites/1754750421.1734431924.blog1.png', 'Back to School: Parents\' Guide to Mitigating the Effects of Education\'s Long COVID on Their Children', '<p style=\'margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40); font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 17px;\'>Tips from Study.com Tutoring Expert and Director, Rachel Mead, for Parents in light of recent data revealing lingering impact on student learning outcomes<div class="wikiContent" style=\'color: rgb(85, 85, 85); font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 17px; padding-bottom: 30px; margin-bottom: 30px; border-bottom: 1px solid rgb(238, 238, 238);\'><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">In the post-COVID world, education\'s landscape has been forever changed. Recent data from&nbsp;<a class="external" href="https://www.nwea.org/uploads/Educations-long-covid-2022-23-achievement-data-reveal-stalled-progress-toward-pandemic-recovery_NWEA_Research-brief.pdf" style="color: rgb(23, 151, 177); transition-property: all; cursor: pointer;">NWEA</a>, a K-12 assessment provider, reports that pandemic recovery has stalled for most students, particularly among upper elementary and middle school students who suffered setbacks in reading and math.</p><ul style="margin-bottom: 10px;"><li>On average, students need four more months of schooling to reach pre-pandemic levels, while this year\'s ninth graders face the prospect of an extra school year.</li><li>First through third graders showed some improvement, but it only brought them back to an already unequal state.</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">The data, gathered from 6.7 million students who took MAP Growth tests, emphasizes the pandemic\'s lasting impact on learning outcomes. The urgency is compounded by the recent decline in reading and math proficiency among 13-year-olds nationwide. To aid the most affected students, parents, educators and stakeholders must provide support for students during this critical time in education.</p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"></p><table border="0" class="imageplugin isEven" style="border-spacing: 0px; background-color: transparent; width: 350px; margin: 10px 0px 10px 10px; max-width: 50%; float: right;"><tbody><tr><td style="padding: 0px;"><img src="https://study.com/cimages/multimages/16/microsoftteams-image_250.png" alt="graphic" style="border: 0px; height: auto; max-width: 100%; margin: 0px; display: block; position: relative; width: 350px;"></td></tr></tbody></table><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"></p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"><span style="font-weight: 700;">Parents can make small changes at home to bolster their child\'s academic progress.</span></p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Rachel Mead, Director of&nbsp;<a class="external" href="https://study.com/tutoring.html" style="color: rgb(23, 151, 177); transition-property: all; cursor: pointer;">Tutoring</a>&nbsp;at Study.com, provides a range of simple tips for parents to prepare their children for success during the upcoming 2023/2024 school year and beyond.</p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"><span style="font-weight: 700;">Cater to your child\'s preferred learning modality.</span></p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Parents can support their child\'s academic progress and make learning an enjoyable experience by tailoring their at-home educational approach to their child\'s strengths:</p><ul style="margin-bottom: 10px;"><li>For auditory learners, consider using audiobooks and encouraging active listening methods like notetaking, drawing visual representations, character mapping or Venn diagrams.</li><li>Alternatively, if your child is a kinesthetic learner, you can provide them with a yoga ball-style desk chair or a standing desk and encourage movement during reading or listening sessions. Using colored highlighters is another easy way to practice active reading.</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"><span style="font-weight: 700;">Practice cycling review to help information transition from your child\'s short-term to long term-memory.</span></p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Cycling review involves revisiting and relearning information at specific intervals, enhancing long-term retention and retrieval. Cycling review optimizes memory consolidation, strengthens neural connections, and promotes better knowledge retention, leading to more effective learning outcomes. To help optimize your child\'s learning outcomes, parents can easily implement cycling review into their family routine.</p><ul style="margin-bottom: 10px;"><li>Take notes throughout the week of what your child is working on. This process doesn\'t need to be intense; a voice or text note on your phone or a couple of sticky notes is sufficient.</li><li>Once a week, come back and discuss concepts or information from earlier in the week and see how your child is processing the information. Repeat this cycle again at the end of the month.</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"><span style="font-weight: 700;">Tips for parents of K-6th graders</span></p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Math tips:</p><ul style="margin-bottom: 10px;"><li>Get your child in the kitchen cooking or baking, using measuring spoons and cups</li><li>Work with your child to use a tape measure and work on finding area and volume</li><li>Identify and discuss patterns in your child\'s home environment</li><li>Play Monopoly Jr.</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Reading tips:</p><ul style="margin-bottom: 10px;"><li>Consistency is key. Block 10-15 minutes every other day of dedicated reading time for kindergarten through second graders, and 20-30 minutes every other day for third through fifth graders.</li><li>Provide younger children with a journal with their favorite character on it to encourage free-form writing</li><li>For middle-grade students, read with them and have the child and parent switch off reading aloud different chapters of the book</li><li>With fiction, discuss with your child what they predict may happen next</li><li>Encourage children to draw pictures related to images generated in their head from the reading</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Writing tips:</p><ul style="margin-bottom: 10px;"><li>Get a journal with your child\'s favorite characters, sports team or musicians</li><li>Assign a theme for creative writing - a letter of the alphabet, a color, an animal, an emotion</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"><span style="font-weight: 700;">Tips for parents of 6-12th graders</span></p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Math tips:</p><ul style="margin-bottom: 10px;"><li>Ask your child to estimate sales tax for a purchase, tip at a restaurant, or interest on a credit card or savings account</li><li>Play Monopoly!</li><li>Calculate change if something were to be paid in cash</li><li>Find the new sales price based on a dollar amount or percentage discount</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Reading tips:</p><ul style="margin-bottom: 10px;"><li>Read the same book with your child and then once a week at dinner, discuss the book as a family (similar to a book club)</li><li>If struggling to find any books your child is interested in, try biographies of people they follow or idolize</li><li>Find books that have been turned into movies to compare &amp; contrast. If it\'s not already a book, who would you cast in the movie and why?</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">Writing tips:</p><ul style="margin-bottom: 10px;"><li>Ask your child to map out a dream vacation or write a parody of a song they love</li><li>Create the back story for a character of a TV show you watch</li><li>Create a comic strip</li></ul><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);"><span style="font-weight: 700;">Practice the Pomodoro technique</span></p><p style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; line-height: 1.6; color: rgb(40, 40, 40);">The Pomodoro technique helps improve focus, productivity and time management skills, allowing students to maintain better concentration and avoid burnout during learning.</p><ul style="margin-bottom: 10px;"><li>Work with your child to identify a learning or studying task</li><li>Set a 25-minute timer and instruct your child to work on the task until the time is complete</li><li>After the 25 minutes are complete, your child can take a 5-minute break. Every four pomodoros, take a longer break (15 to 30 minutes) to help your child stay mentally fresh</li></ul></div></p>\n', 1, '2025-08-09', '2026-12-09', '2025-08-09 13:40:24', '2025-08-09 13:40:24');

-- Listage de la structure de table preinscription_tempsamenage. diplom_bac2s
CREATE TABLE IF NOT EXISTS `diplom_bac2s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.diplom_bac2s : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. etablissements
CREATE TABLE IF NOT EXISTS `etablissements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom_abrev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsable_id` bigint unsigned DEFAULT NULL,
  `master_ouvert` tinyint(1) NOT NULL DEFAULT '0',
  `passerelle_ouvert` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_choix_filiere_master` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_choix_filiere_passerelle` tinyint(1) NOT NULL DEFAULT '0',
  `show_cin_input_master` tinyint(1) NOT NULL DEFAULT '0',
  `show_photo_input_master` tinyint(1) NOT NULL DEFAULT '0',
  `show_cv_input_master` tinyint(1) NOT NULL DEFAULT '0',
  `show_bac_input_master` tinyint(1) NOT NULL DEFAULT '0',
  `show_licence_input_master` tinyint(1) NOT NULL DEFAULT '0',
  `show_attestation_no_emploi_input_master` tinyint(1) NOT NULL DEFAULT '0',
  `show_bac_input_passerelle` tinyint(1) NOT NULL DEFAULT '0',
  `show_cin_input_passerelle` tinyint(1) NOT NULL DEFAULT '0',
  `show_photo_input_passerelle` tinyint(1) NOT NULL DEFAULT '0',
  `show_cv_input_passerelle` tinyint(1) NOT NULL DEFAULT '0',
  `show_diplome_deug_input_passerelle` tinyint(1) NOT NULL DEFAULT '0',
  `show_attestation_no_emploi_input_passerelle` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.etablissements : ~9 rows (environ)
INSERT INTO `etablissements` (`id`, `nom_abrev`, `nom`, `description`, `logo`, `responsable_id`, `master_ouvert`, `passerelle_ouvert`, `multiple_choix_filiere_master`, `multiple_choix_filiere_passerelle`, `show_cin_input_master`, `show_photo_input_master`, `show_cv_input_master`, `show_bac_input_master`, `show_licence_input_master`, `show_attestation_no_emploi_input_master`, `show_bac_input_passerelle`, `show_cin_input_passerelle`, `show_photo_input_passerelle`, `show_cv_input_passerelle`, `show_diplome_deug_input_passerelle`, `show_attestation_no_emploi_input_passerelle`, `created_at`, `updated_at`) VALUES
	(1, 'FSJP', 'Faculté des Sciences Juridiques et Politiques', 'Description', 'files/logo_etablissement/1758704446.logo-fsjp.webp', 73, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:00:52', '2025-09-24 08:39:51'),
	(2, 'ENCG', 'Ecole Nationale de Commerce et de Gestion', 'Description', 'files/logo_etablissement/1758704481.logo-encg.png', 71, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:01:25', '2025-09-24 08:01:25'),
	(3, 'FST', 'Faculté des Sciences et Techniques', 'Description', 'files/logo_etablissement/1758704508.logo-fst.png', 71, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:01:51', '2025-09-24 08:01:51'),
	(4, 'ENSA', 'Ecole Nationale des Sciences Appliquées', 'Description', 'files/logo_etablissement/1758704535.logo-ensa.png', 71, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:02:17', '2025-09-24 08:02:17'),
	(5, 'I3S', 'Institut des Sciences et Technologies', 'Description', 'files/logo_etablissement/1758704597.logo-i3s.png', 76, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:03:20', '2025-10-06 12:33:17'),
	(6, 'I2S', 'Institut des Sciences de la Santé', 'Description', 'files/logo_etablissement/1758704625.logo-i2s.png', 71, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:03:47', '2025-09-24 08:03:47'),
	(7, 'ESEF', 'Ecole Supérieure de l\'Education et de la Formation', 'Description', 'files/logo_etablissement/1758704652.logo-esef.jpg', 78, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:04:15', '2025-10-06 12:40:11'),
	(8, 'FLASH', 'Faculté des Lettres, des Arts et des Sciences Humaines', 'Description', 'files/logo_etablissement/1758704675.Logo-FLASH.jpg', 71, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:04:37', '2025-09-24 08:04:37'),
	(9, 'FEG', 'Faculté des Sciences Economiques et de Gestion', 'Description', 'files/logo_etablissement/1758704706.logo-feg.png', 74, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-09-24 08:05:08', '2025-09-24 08:40:42');

-- Listage de la structure de table preinscription_tempsamenage. etablissements_series_bacs
CREATE TABLE IF NOT EXISTS `etablissements_series_bacs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `etablissement_id` bigint unsigned NOT NULL,
  `serie_bac_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.etablissements_series_bacs : ~55 rows (environ)
INSERT INTO `etablissements_series_bacs` (`id`, `etablissement_id`, `serie_bac_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, NULL),
	(2, 1, 2, NULL, NULL),
	(3, 1, 3, NULL, NULL),
	(4, 1, 4, NULL, NULL),
	(5, 1, 5, NULL, NULL),
	(6, 1, 6, NULL, NULL),
	(7, 1, 7, NULL, NULL),
	(8, 1, 8, NULL, NULL),
	(9, 1, 9, NULL, NULL),
	(10, 2, 1, NULL, NULL),
	(11, 2, 2, NULL, NULL),
	(12, 2, 3, NULL, NULL),
	(13, 2, 4, NULL, NULL),
	(14, 2, 5, NULL, NULL),
	(15, 2, 6, NULL, NULL),
	(16, 2, 7, NULL, NULL),
	(17, 2, 8, NULL, NULL),
	(18, 2, 9, NULL, NULL),
	(19, 3, 1, NULL, NULL),
	(20, 3, 2, NULL, NULL),
	(21, 3, 3, NULL, NULL),
	(22, 3, 4, NULL, NULL),
	(23, 3, 5, NULL, NULL),
	(24, 3, 6, NULL, NULL),
	(25, 3, 7, NULL, NULL),
	(26, 3, 8, NULL, NULL),
	(27, 3, 9, NULL, NULL),
	(28, 6, 1, NULL, NULL),
	(29, 6, 2, NULL, NULL),
	(30, 6, 3, NULL, NULL),
	(31, 6, 4, NULL, NULL),
	(32, 6, 5, NULL, NULL),
	(33, 6, 6, NULL, NULL),
	(34, 6, 7, NULL, NULL),
	(35, 6, 8, NULL, NULL),
	(36, 6, 9, NULL, NULL),
	(37, 6, 10, NULL, NULL),
	(38, 5, 1, NULL, NULL),
	(39, 5, 2, NULL, NULL),
	(40, 5, 3, NULL, NULL),
	(41, 5, 4, NULL, NULL),
	(42, 5, 5, NULL, NULL),
	(43, 5, 6, NULL, NULL),
	(44, 5, 7, NULL, NULL),
	(45, 5, 8, NULL, NULL),
	(46, 5, 9, NULL, NULL),
	(47, 4, 1, NULL, NULL),
	(48, 4, 2, NULL, NULL),
	(49, 4, 3, NULL, NULL),
	(50, 4, 4, NULL, NULL),
	(51, 4, 5, NULL, NULL),
	(52, 4, 6, NULL, NULL),
	(53, 4, 7, NULL, NULL),
	(54, 4, 8, NULL, NULL),
	(55, 4, 9, NULL, NULL);

-- Listage de la structure de table preinscription_tempsamenage. etablissement_bac2s
CREATE TABLE IF NOT EXISTS `etablissement_bac2s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.etablissement_bac2s : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. etablissement_dibplome_bac_plus2s
CREATE TABLE IF NOT EXISTS `etablissement_dibplome_bac_plus2s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `etablissement_id` bigint unsigned NOT NULL,
  `diplome_bac_2_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.etablissement_dibplome_bac_plus2s : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.failed_jobs : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. filieres
CREATE TABLE IF NOT EXISTS `filieres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom_abrv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_complet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etablissement_id` bigint unsigned DEFAULT NULL,
  `responsable_id` bigint unsigned DEFAULT NULL,
  `type` int NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.filieres : ~29 rows (environ)
INSERT INTO `filieres` (`id`, `nom_abrv`, `nom_complet`, `description`, `document`, `etablissement_id`, `responsable_id`, `type`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'DMC', 'قانون الإعلام و الإتصال', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:15:20', '2025-09-24 08:15:20'),
	(2, 'DCTDN', 'ماستر القانون المدني و تقنيات التوثيق و الرقمنة', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:16:48', '2025-10-06 12:11:32'),
	(3, 'GAFCP', 'التدبير الإداري و المالي للطلبيات العمومية', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:19:03', '2025-09-24 08:19:03'),
	(4, 'MDC', 'ماستر القانون و المنازعات', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:19:54', '2025-09-24 08:19:54'),
	(5, 'MED', 'المقاولة و القانون', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:23:00', '2025-09-24 08:23:00'),
	(6, 'MAC', 'الإدارة و التعمير', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:25:52', '2025-09-24 08:25:52'),
	(7, 'SFCPI', 'العلوم الجنائية و التعاون الجنائي الدولي', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:27:15', '2025-09-24 08:27:15'),
	(8, 'MPII', 'التهيئة و العقار و الاستثمار', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:28:49', '2025-09-24 08:28:49'),
	(9, 'SCS', 'العلوم الجنائية و الأمنية', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:29:41', '2025-09-24 08:29:41'),
	(10, 'DPJ', 'Droit et pratiques judiciaires', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:30:43', '2025-09-24 08:30:43'),
	(11, 'GSIC', 'Gouvernance sécuritaire et ingénierie cybernétique', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:31:31', '2025-09-24 08:31:31'),
	(12, 'EDDA', 'Etudes diplomatiques et Développement en Afrique', 'Description', NULL, 1, 72, 1, 0, '2025-09-24 08:32:28', '2025-10-06 12:12:18'),
	(13, 'DSN', 'Droit et Sécurité Numérique', 'Description', NULL, 1, 72, 1, 1, '2025-09-24 08:33:09', '2025-09-24 08:33:09'),
	(14, 'AAF', 'Actuariat Assurance et Finance', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:44:07', '2025-10-06 12:28:51'),
	(15, 'DSA', 'Data Science et Actuariat', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:44:36', '2025-10-06 12:29:42'),
	(16, 'ACG', 'Audit et Contrôle de Gestion', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:45:07', '2025-09-24 08:45:07'),
	(17, 'CCA', 'Comptabilité, Contrôle et Audit', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:45:27', '2025-09-24 08:45:27'),
	(18, 'GCF', 'Gestion Comptable et Financière', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:45:50', '2025-09-24 08:45:50'),
	(19, 'MOCD', 'Management Opérationnel de Commerce et de Distribution', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:46:15', '2025-09-24 08:46:15'),
	(20, 'MLD', 'Marketing et logistique de distribution', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:46:37', '2025-09-24 08:46:37'),
	(21, 'IFF', 'Ingénierie Financière et Fiscale', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:47:19', '2025-09-24 08:47:19'),
	(22, 'MDAC', 'Marketing Digital Et Actions Commerciales', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:47:45', '2025-09-24 08:47:45'),
	(23, 'MSEL', 'Management, Stratégie d\'entreprise et Leadership', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:48:13', '2025-09-24 08:48:13'),
	(24, 'MDRH', 'Management Et Digitalisation Des Ressources Humaines', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:48:55', '2025-09-24 08:48:55'),
	(25, 'SCCI', 'Supply Chain & Commerce International', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:49:20', '2025-09-24 08:49:20'),
	(26, 'PPDE', 'Politique Publique et Développement Économique', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:49:40', '2025-09-24 08:49:40'),
	(27, 'ID', 'Ingénierie de la Décision', 'Description', NULL, 9, 75, 1, 1, '2025-09-24 08:49:58', '2025-09-24 08:49:58'),
	(28, 'CFF', 'Comptabilité, Finance et Fiscalité', 'Description', NULL, 9, 75, 2, 1, '2025-09-24 08:50:32', '2025-09-24 08:50:32'),
	(29, 'CM', 'Commerce et Marketing', 'Description', NULL, 9, 75, 2, 1, '2025-09-24 08:50:52', '2025-09-24 08:50:52'),
	(30, 'LE', 'Econométrie', 'Description', NULL, 9, 75, 2, 1, '2025-09-24 08:51:19', '2025-09-24 08:51:19'),
	(31, 'EI', 'Economie Intenationale', 'Description', NULL, 9, 75, 2, 1, '2025-09-24 08:51:47', '2025-09-24 08:51:47'),
	(32, 'EAF', 'Etudes administratives et financières', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:13:45', '2025-10-06 12:13:45'),
	(33, 'EPI', 'Etudes politiques et internationales', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:14:09', '2025-10-06 12:14:09'),
	(34, 'MDJ', 'Métiers de droit et de la justice', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:14:34', '2025-10-06 12:14:34'),
	(35, 'DFA', 'Droit financier et des affaires', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:15:09', '2025-10-06 12:15:09'),
	(36, 'EPI', 'الدراسات السياسية و الدولية', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:16:35', '2025-10-06 12:16:35'),
	(37, 'EAF', 'الدراسات الإدارية و المالية', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:18:10', '2025-10-06 12:18:10'),
	(38, 'GIS', 'تدبير المؤسسات الإجتماعية', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:20:11', '2025-10-06 12:20:11'),
	(39, 'DFA', 'قانون المال و الأعمال', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:21:14', '2025-10-06 12:21:14'),
	(40, 'PJJ', 'المهن القانونية و القضائية', 'Description', NULL, 1, 72, 2, 1, '2025-10-06 12:22:16', '2025-10-06 12:22:16'),
	(41, 'CCA', 'Comptabilité, Contrôle et Audit', 'Description', NULL, 9, 75, 2, 1, '2025-10-06 12:27:01', '2025-10-06 12:27:01'),
	(42, 'MOCD', 'Management Opérationnel de Commerce et de Distribution (Par Alternance)', 'Description', NULL, 9, 75, 2, 1, '2025-10-06 12:27:28', '2025-10-06 12:27:28'),
	(43, 'AIA', 'Actuariat et Intelligence Artificielle', 'Description', NULL, 9, 75, 2, 1, '2025-10-06 12:27:54', '2025-10-06 12:27:54'),
	(44, 'SSF', 'Sciences de la Sage-femme', 'Description', NULL, 5, 77, 2, 1, '2025-10-06 12:34:34', '2025-10-06 12:34:34'),
	(45, 'SI', 'Sciences Infirmières (option infirmier polyvalent)', 'Description', NULL, 5, 77, 2, 1, '2025-10-06 12:35:07', '2025-10-06 12:35:07'),
	(46, 'SSTSE', 'Sciences de la santé : Technologue de santé et environnement', 'Description', NULL, 5, 77, 2, 1, '2025-10-06 12:35:36', '2025-10-06 12:35:36'),
	(47, 'ISFSC', 'Infirmier en santé de famille et santé communautaire', 'Description', NULL, 5, 77, 2, 1, '2025-10-06 12:36:00', '2025-10-06 12:36:00'),
	(48, 'IMB', 'Instrumentation et maintenance biomédicale', 'Description', NULL, 5, 77, 2, 1, '2025-10-06 12:36:27', '2025-10-06 12:36:27'),
	(49, 'PM', 'Physique Médicale', 'Description', NULL, 5, 77, 1, 1, '2025-10-06 12:36:53', '2025-10-06 12:36:53'),
	(50, 'PAS', 'Pratiques Avancés en Santé', 'Description', NULL, 5, 77, 1, 1, '2025-10-06 12:37:17', '2025-10-06 12:37:17'),
	(51, 'RP', 'Radioprotection', 'Description', NULL, 5, 77, 1, 1, '2025-10-06 12:37:40', '2025-10-06 12:37:40'),
	(52, 'IFDL', 'Ingénierie de Formation et Digital Learning', 'Description', NULL, 7, 79, 1, 1, '2025-10-06 12:41:36', '2025-10-06 12:41:36'),
	(53, 'DSCP', 'Didactique en sciences  chimiques  et physiques', 'Description', NULL, 7, 79, 1, 1, '2025-10-06 12:42:03', '2025-10-06 12:42:03');

-- Listage de la structure de table preinscription_tempsamenage. historique_ouvertures
CREATE TABLE IF NOT EXISTS `historique_ouvertures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etablissement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.historique_ouvertures : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.migrations : ~16 rows (environ)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2018_10_01_115212_create_roles_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2024_10_01_115324_create_etablissements_table', 1),
	(7, '2024_11_20_155405_create_filieres_table', 1),
	(8, '2024_11_22_115627_create_student_passerelles_table', 1),
	(9, '2024_11_22_115634_create_student_masters_table', 1),
	(10, '2024_11_22_120928_create_serie_bacs_table', 1),
	(11, '2024_11_22_121354_create_diplom_bac2s_table', 1),
	(12, '2024_11_22_161952_create_etablissement_bac2s_table', 1),
	(13, '2024_12_09_104317_create_historique_ouvertures_table', 1),
	(14, '2024_12_13_150151_create_actualites_table', 1),
	(15, '2025_01_23_134713_create_etablissements_series_bacs_table', 1),
	(16, '2025_01_27_102149_create_etablissement_dibplome_bac_plus2s_table', 1);

-- Listage de la structure de table preinscription_tempsamenage. password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.password_reset_tokens : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.personal_access_tokens : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.roles : ~5 rows (environ)
INSERT INTO `roles` (`id`, `nom`, `created_at`, `updated_at`) VALUES
	(1, 'sup-admin', '2025-08-09 14:32:07', '2025-08-09 14:32:09'),
	(2, 'Responsable Etablissement', '2025-08-09 14:32:07', '2025-08-09 14:32:09'),
	(3, 'Responsable Filiére', '2025-08-09 14:32:07', '2025-08-09 14:32:09'),
	(4, 'Etudiant', '2025-08-09 14:32:07', '2025-08-09 14:32:09'),
	(5, 'Visiteur', '2025-08-09 14:32:07', '2025-08-09 14:32:09');

-- Listage de la structure de table preinscription_tempsamenage. serie_bacs
CREATE TABLE IF NOT EXISTS `serie_bacs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.serie_bacs : ~10 rows (environ)
INSERT INTO `serie_bacs` (`id`, `nom`, `created_at`, `updated_at`) VALUES
	(1, 'SVT', '2025-08-09 13:41:01', '2025-08-09 13:41:01'),
	(2, 'STM', '2025-08-09 13:41:10', '2025-08-09 13:41:10'),
	(3, 'STE', '2025-08-09 13:41:22', '2025-08-09 13:41:22'),
	(4, 'Sciences Économiques', '2025-08-09 13:41:35', '2025-08-09 13:41:35'),
	(5, 'SCIENCES EXPERIMENTALE', '2025-08-09 13:41:44', '2025-08-09 13:41:44'),
	(6, 'Sc.Math(B)', '2025-08-09 13:41:58', '2025-08-09 13:41:58'),
	(7, 'Sc.Math(A)', '2025-08-09 13:42:04', '2025-08-09 13:42:04'),
	(8, 'SC.AGRONOMIQUES', '2025-08-09 13:42:14', '2025-08-09 13:42:14'),
	(9, 'PC', '2025-08-09 13:42:29', '2025-08-09 13:42:29'),
	(10, 'Lettres et Sciences Humaines', '2025-08-09 13:42:36', '2025-08-09 13:42:36');

-- Listage de la structure de table preinscription_tempsamenage. student_masters
CREATE TABLE IF NOT EXISTS `student_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `CNE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CIN` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenomar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datenais` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villenais` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payschamp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villechamp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filiere` bigint unsigned DEFAULT NULL,
  `filiere_choix_1` bigint unsigned DEFAULT NULL,
  `filiere_choix_2` bigint unsigned DEFAULT NULL,
  `filiere_choix_3` bigint unsigned DEFAULT NULL,
  `serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Anneebac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fonctionnaire` tinyint(1) DEFAULT NULL,
  `secteur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieutravail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villetravail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombreannee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poste` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dernier_diplome_obtenu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_diplome_obtenu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialitediplome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville_etablissement_diplome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_optention_diplome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_cin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_bac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_licence` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_cv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_attestation_non_emploi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etablissement_id` bigint unsigned DEFAULT NULL,
  `confirmation_student` tinyint(1) NOT NULL,
  `verif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motif` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.student_masters : ~0 rows (environ)
INSERT INTO `student_masters` (`id`, `CNE`, `CIN`, `nom`, `prenom`, `nomar`, `prenomar`, `datenais`, `villenais`, `payschamp`, `villechamp`, `email`, `phone`, `sexe`, `adresse`, `filiere`, `filiere_choix_1`, `filiere_choix_2`, `filiere_choix_3`, `serie`, `Anneebac`, `fonctionnaire`, `secteur`, `lieutravail`, `villetravail`, `nombreannee`, `poste`, `dernier_diplome_obtenu`, `type_diplome_obtenu`, `specialitediplome`, `ville_etablissement_diplome`, `date_optention_diplome`, `path_photo`, `path_cin`, `path_bac`, `path_licence`, `path_cv`, `path_attestation_non_emploi`, `etablissement_id`, `confirmation_student`, `verif`, `motif`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'D85569', 'HHHH', 'HHHH', NULL, NULL, NULL, NULL, NULL, NULL, 'hhhgg@gmail.com', '0647859987', NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BAC+4', 'PUBLIC', 'specialite', 'etab diplome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'EN COURS', NULL, 80, NULL, '2025-10-07 12:44:47', '2025-10-07 12:44:47');

-- Listage de la structure de table preinscription_tempsamenage. student_passerelles
CREATE TABLE IF NOT EXISTS `student_passerelles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `CNE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CIN` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenomar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datenais` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villenais` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payschamp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villechamp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filiere` bigint unsigned DEFAULT NULL,
  `filiere_choix_1` bigint unsigned DEFAULT NULL,
  `filiere_choix_2` bigint unsigned DEFAULT NULL,
  `filiere_choix_3` bigint unsigned DEFAULT NULL,
  `serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Anneebac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notebac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mention_bac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fonctionnaire` tinyint(1) DEFAULT NULL,
  `secteur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieutravail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villetravail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombreannee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poste` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dernier_diplome_obtenu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_diplome_obtenu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialitediplome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville_etablissement_diplome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_optention_diplome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_cin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_bac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_diplomedeug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_cv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path_attestation_non_emploi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etablissement_id` bigint unsigned DEFAULT NULL,
  `confirmation_student` tinyint(1) NOT NULL,
  `verif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motif` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.student_passerelles : ~0 rows (environ)

-- Listage de la structure de table preinscription_tempsamenage. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table preinscription_tempsamenage.users : ~6 rows (environ)
INSERT INTO `users` (`id`, `name`, `telephone`, `email`, `email_verified_at`, `password`, `role_id`, `active`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Ayoub Hassnioui', '0649775779', 'ayoub.hassnioui@uhp.ac.ma', '2025-08-09 12:11:26', '$2y$12$whK2lgIGqEFwiITQbRAnRuEjfsXgPVqUbrSg4zaz1lkLsEo95RrfG', 1, 1, NULL, 'MqHkEpvsIDMWNauaT7QBSCGryD3naE1l6LyXZskDEM6DY53mcBMdknuo4u4S', '2025-08-09 12:11:26', '2025-08-09 13:46:48'),
	(71, 'Ayoub Etab', '0700000000', 'ayoub_fsjp@uhp.ac.ma', NULL, '$2y$12$st6hHy29oz0tx2UrDyPVwuq2R69vq/bCc0zoRJQRBqJN1ijfLf3.S', 2, 1, NULL, NULL, '2025-09-23 10:35:22', '2025-09-24 08:11:48'),
	(72, 'Hassnioui Responsable', '0700000000', 'ayoub_RS_responsable@uhp.ac.ma', NULL, '$2y$12$3DcMiNpzHzZVNdvaWp3C6u0EIU/5PTLyxgDsqrP3sAQvSl71oBhmG', 3, 1, 71, NULL, '2025-09-24 08:15:00', '2025-09-24 08:34:23'),
	(73, 'Marouane Okri', '0700000000', 'marouaneokri@gmail.com', NULL, '$2y$12$8lGydPSojXSngC6t9a8Zeutm0lGGpwSC5OWROn4SK16gWQnZ3/z7i', 2, 1, NULL, NULL, '2025-09-24 08:39:47', '2025-09-24 08:39:47'),
	(74, 'Rachid Zirari', '0700000000', 'rachid.zirari@uhp.ac.ma', NULL, '$2y$12$x1SxhIKG5wezNlY5/vBnG.rgUWxOa2av3GRsFiYwgI9BQM5BKHKBm', 2, 1, NULL, NULL, '2025-09-24 08:40:34', '2025-09-24 08:40:34'),
	(75, 'Hassnioui Resp FEG', '0700000000', 'hassnioui_resFeg@uhp.ac.ma', NULL, '$2y$12$d1/NGPdgYTytUVEDivs1d.yZir8uzA.6mjoyAc2uJZgn7scLlSsra', 3, 0, 74, NULL, '2025-09-24 08:43:16', '2025-09-24 08:43:16'),
	(76, 'Mohamed Warimezgane', '0700000000', 'mohamed.warimezgane@uhp.ac.ma', NULL, '$2y$12$O8ZVwQ6yRIKTpgJKftkoh.WHEsAgGSv085qro/02pqN5WgziynK3m', 2, 1, NULL, NULL, '2025-10-06 12:33:06', '2025-10-06 12:33:06'),
	(77, 'Responsable ISSS', '0700000000', 'responsable_isss@uhp.ac.ma', NULL, '$2y$12$JrirgEYOXMKx.d1szi/0zeCAps1YEkcCi3oGQimmhLwdDXk6yh4EW', 3, 0, 76, NULL, '2025-10-06 12:34:23', '2025-10-06 12:34:23'),
	(78, 'Mohamed Zaabouli', '0700000000', 'mohamed.zaabouli@uhp.ac.ma', NULL, '$2y$12$V7IuW1iqg/SEQvvp3Bu27OyFSs4fz7OaZjFwMoxZuwDH8MDj9p8S.', 2, 1, NULL, NULL, '2025-10-06 12:40:08', '2025-10-06 12:40:08'),
	(79, 'Responsable ESEF', '0700000000', 'responsable_esef@uhp.ac.ma', NULL, '$2y$12$3bex/Ektws5b1h30c6EEM.Hhi0TKCrRMptcro6pJS44lJWxfCHM2W', 3, 0, 78, NULL, '2025-10-06 12:41:31', '2025-10-06 12:41:31'),
	(80, 'HHHH HHHH', '0647859987', 'hhhgg@gmail.com', NULL, '$2y$12$dZVKhLMIwaYSFAwtyUWm7uOEvr1GwZYzgfjZ3n1XyNG7tJTSeSLZ6', 4, 1, NULL, NULL, '2025-10-07 12:44:47', '2025-10-07 12:44:47');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
