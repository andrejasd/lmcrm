-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Час створення: Чрв 08 2016 р., 17:37
-- Версія сервера: 5.5.49-0ubuntu0.14.04.1
-- Версія PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База даних: `lmcrm`
--

-- --------------------------------------------------------

--
-- Структура таблиці `activations`
--

DROP TABLE IF EXISTS `activations`;
CREATE TABLE IF NOT EXISTS `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Дамп даних таблиці `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'abSnMAHdKKwg4YxlwAhf5o8uPAV8u6vG', 1, '2016-05-12 05:36:26', '2016-05-12 05:36:26', '2016-05-12 05:36:26'),
(2, 2, 'doaushLtDYqy7Mu5Fk7FXoXi6vfrGdJb', 1, '2016-05-12 05:36:26', '2016-05-12 05:36:26', '2016-05-12 05:36:26'),
(4, 3, 'yr07lkfcTA1RaohWkoiMxrS3ZB8ZyblN', 1, '2016-05-16 07:09:33', '2016-05-16 07:09:33', '2016-05-16 07:09:33'),
(5, 11, 'yr07lkfcTA1RaohWkoiMxrS3ZB8ZyblN', 1, '2016-05-16 07:09:33', '2016-05-16 07:09:33', '2016-05-16 07:09:33'),
(6, 14, 'FYJ7OfZ55XOibXDt6ry4qqwtXolvUBhd', 1, '2016-05-29 10:25:24', '2016-05-29 10:25:24', '2016-05-29 10:25:24'),
(7, 17, 'rca35cySyZuYyyU9vLMNq1SMRxvadzsa', 1, '2016-05-29 10:26:54', '2016-05-29 10:26:54', '2016-05-29 10:26:54'),
(8, 18, '3saArMVjbGNlSoawWIxcSoWtW3XOrgb3', 1, '2016-05-29 10:27:43', '2016-05-29 10:27:43', '2016-05-29 10:27:43'),
(9, 19, '06nZbofB8P69BJsVHUN7Qb04XMfXQ7Tl', 1, '2016-05-29 10:28:19', '2016-05-29 10:28:19', '2016-05-29 10:28:19'),
(10, 20, 'k0CRUqhnhVoeqA3SmBahg090lNsM3tyo', 1, '2016-05-29 10:29:28', '2016-05-29 10:29:28', '2016-05-29 10:29:28'),
(11, 21, 'Qmhveb0p9QOE94af2VIpbYTD2DMNZuni', 1, '2016-05-29 10:29:51', '2016-05-29 10:29:51', '2016-05-29 10:29:51'),
(12, 22, 'yukvlFQYfHmmAbO4Aib7rA8qINGtBkdf', 1, '2016-05-29 10:31:15', '2016-05-29 10:31:15', '2016-05-29 10:31:15'),
(13, 23, '1ncWK0caaeFaozWa5mBdyfdGfo6atjU2', 1, '2016-05-30 10:37:52', '2016-05-30 10:37:52', '2016-05-30 10:37:52'),
(14, 24, '8EIRfZerDo1YBtA0hu73WthBzGZijVre', 1, '2016-05-30 10:39:15', '2016-05-30 10:39:15', '2016-05-30 10:39:15');

-- --------------------------------------------------------

--
-- Структура таблиці `agent_info`
--

DROP TABLE IF EXISTS `agent_info`;
CREATE TABLE IF NOT EXISTS `agent_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `lead_revenue` double(8,2) NOT NULL,
  `payment_revenue` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп даних таблиці `agent_info`
--

INSERT INTO `agent_info` (`id`, `agent_id`, `lead_revenue`, `payment_revenue`, `created_at`, `updated_at`) VALUES
(1, 14, 12.50, 10.00, NULL, '2016-05-31 03:34:11');

-- --------------------------------------------------------

--
-- Структура таблиці `agent_sphere`
--

DROP TABLE IF EXISTS `agent_sphere`;
CREATE TABLE IF NOT EXISTS `agent_sphere` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `sphere_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп даних таблиці `agent_sphere`
--

INSERT INTO `agent_sphere` (`id`, `agent_id`, `sphere_id`, `created_at`, `updated_at`) VALUES
(5, 14, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `credits`
--

DROP TABLE IF EXISTS `credits`;
CREATE TABLE IF NOT EXISTS `credits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `buyed` double(8,2) NOT NULL,
  `earned` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп даних таблиці `credits`
--

INSERT INTO `credits` (`id`, `agent_id`, `buyed`, `earned`, `created_at`, `updated_at`) VALUES
(1, 14, 0.00, 495.00, NULL, '2016-05-30 06:18:35');

-- --------------------------------------------------------

--
-- Структура таблиці `credit_history`
--

DROP TABLE IF EXISTS `credit_history`;
CREATE TABLE IF NOT EXISTS `credit_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `deposit` double(8,2) NOT NULL,
  `source` int(11) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблиці `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп даних таблиці `customers`
--

INSERT INTO `customers` (`id`, `phone`, `created_at`, `updated_at`) VALUES
(1, '0501234567', '2016-05-15 06:27:53', '2016-05-15 06:27:53'),
(2, '0501234568', '2016-05-15 08:11:09', '2016-05-15 08:11:09');

-- --------------------------------------------------------

--
-- Структура таблиці `leads`
--

DROP TABLE IF EXISTS `leads`;
CREATE TABLE IF NOT EXISTS `leads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `sphere_id` int(11) NOT NULL,
  `opened` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `bad` tinyint(1) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=125 ;

--
-- Дамп даних таблиці `leads`
--

INSERT INTO `leads` (`id`, `agent_id`, `sphere_id`, `opened`, `email`, `customer_id`, `name`, `comment`, `bad`, `date`, `created_at`, `updated_at`) VALUES
(7, 14, 4, 2, '1_lead@mail.com', 1, 'lead', '', 0, '2016-05-16', '2016-05-16 10:21:44', '2016-05-24 10:46:48'),
(8, 10, 4, 1, '2_lead@mail.com', 1, '2_lead', '', 0, '2016-05-16', '2016-05-16 10:21:56', '2016-05-30 06:18:35'),
(9, 9, 4, 0, '3lead@mail.com', 1, 'lead 3', NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `lead_info`
--

DROP TABLE IF EXISTS `lead_info`;
CREATE TABLE IF NOT EXISTS `lead_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `lead_attr_id` int(11) NOT NULL,
  `value` varchar(2083) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп даних таблиці `lead_info`
--

INSERT INTO `lead_info` (`id`, `lead_id`, `lead_attr_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 123, 1, '05/01/2016', '2016-05-24 10:46:33', '2016-05-24 10:46:33'),
(2, 7, 1, '05/16/2016', '2016-05-24 10:46:48', '2016-05-24 10:46:48');

-- --------------------------------------------------------

--
-- Структура таблиці `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_07_02_230147_migration_cartalyst_sentinel', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_04_04_114657_create_spheres', 1),
('2016_04_05_071411_create_sphere_attributes', 1),
('2016_04_05_075446_create_sphere_attribute_options', 1),
('2016_04_17_083258_create_sphere_leads', 1),
('2016_04_19_144506_create_sphere_status', 1),
('2016_04_26_070901_alter_users', 1),
('2016_05_05_135424_create_leads', 1),
('2016_05_10_140406_create_leadEAV', 1),
('2016_05_11_163132_create_lead_phones', 1),
('2016_05_15_064255_create_agent_sphere', 2),
('2016_05_19_110334_create_lead_agent', 3),
('2016_05_19_131256_create_credits', 4),
('2016_05_25_081325_create_agent_info', 5),
('2016_05_26_062258_create_lead_statuses_history', 6),
('2016_05_26_130102_create_salesman', 6);

-- --------------------------------------------------------

--
-- Структура таблиці `open_leads`
--

DROP TABLE IF EXISTS `open_leads`;
CREATE TABLE IF NOT EXISTS `open_leads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп даних таблиці `open_leads`
--

INSERT INTO `open_leads` (`id`, `lead_id`, `agent_id`, `created_at`, `updated_at`) VALUES
(1, 7, 14, NULL, NULL),
(2, 8, 14, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `persistences`
--

DROP TABLE IF EXISTS `persistences`;
CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=63 ;

--
-- Дамп даних таблиці `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, 'cQShTftU2PSLfV0zes7laCXETX49UHP4', '2016-05-12 05:36:37', '2016-05-12 05:36:37'),
(5, 1, 'j3xZ7GGgleCB3v3tsh2vxkFQ8dyhMFS8', '2016-05-15 04:04:31', '2016-05-15 04:04:31'),
(6, 1, 'K48vPLUIvuJ00H8emmhvRzdzoGbmKOzO', '2016-05-15 14:21:00', '2016-05-15 14:21:00'),
(13, 14, '3xtclyEJUaPWcX0KTl6qfqmpKafLEy5m', '2016-05-16 09:00:30', '2016-05-16 09:00:30'),
(17, 14, 'vnFR5nJIBhwItQ2krdTKCERw2rFDihHi', '2016-05-17 03:58:09', '2016-05-17 03:58:09'),
(25, 11, 'Y61S5GuFdgHkIJu6QWO4C5pkrUN4NdGi', '2016-05-17 09:50:47', '2016-05-17 09:50:47'),
(27, 14, '0g898VGpNVDSPjhuqRunNMSVOI7iVr3u', '2016-05-18 08:33:24', '2016-05-18 08:33:24'),
(28, 14, '5wzTEZ9Um5uTtr04DBlMBYDXpKUT2ps6', '2016-05-19 03:19:20', '2016-05-19 03:19:20'),
(29, 14, 'eDHtktT9YOo3ppgYTTaDGDeXSMtxSU2m', '2016-05-19 04:35:03', '2016-05-19 04:35:03'),
(30, 14, '1yeSRtD64MntAVdxngAjUljS9jwhk9gU', '2016-05-19 11:28:37', '2016-05-19 11:28:37'),
(35, 14, 'RIVUXkYKZxViK4ILup41BOi84RrqmU7H', '2016-05-22 11:46:18', '2016-05-22 11:46:18'),
(36, 14, 'N4htrvKVTZVt3dcmFQmLJFvwjK6zbklb', '2016-05-23 03:31:20', '2016-05-23 03:31:20'),
(37, 14, 'rMp163KSbF7guAna8YVjMxajJDKxgdg7', '2016-05-23 06:32:49', '2016-05-23 06:32:49'),
(38, 14, 'ZaRPthoPlgPv8SFdoxLUSSBaextIYoDD', '2016-05-23 08:52:35', '2016-05-23 08:52:35'),
(39, 14, 'hoDi9tb2gwbPIsgxSTZoqmy1YHTP7MJR', '2016-05-24 03:45:14', '2016-05-24 03:45:14'),
(42, 14, 'en4Fy6h3aTac6MhHggFSqjS1NTVzzc06', '2016-05-24 10:46:58', '2016-05-24 10:46:58'),
(45, 14, 'QdX5Sh7BlIkNdjpbptQlT1CvAIefArJ0', '2016-05-25 10:26:55', '2016-05-25 10:26:55'),
(46, 14, 'Xf2qj80S4nwEyxHeJj0DVbHWwOy8NrJM', '2016-05-26 02:56:18', '2016-05-26 02:56:18'),
(47, 14, 'pMjb6tjvfRgs38L3le9Zk60GU97faFRj', '2016-05-26 06:03:50', '2016-05-26 06:03:50'),
(48, 14, 'eNKzPPytf9KCU4q9w5tpq4VjYuC2I2PT', '2016-05-26 07:36:12', '2016-05-26 07:36:12'),
(49, 14, 'VGyzHvzGZaXxrsaLYloguk58jOFTlBYF', '2016-05-26 11:04:10', '2016-05-26 11:04:10'),
(50, 14, '6sHesenVyKNhQzfF40Q3BQzxKwxFTcSN', '2016-05-29 03:48:46', '2016-05-29 03:48:46'),
(54, 14, 'Guv1ZwxCnLKG0yrC84mSS5qkVw7u0DfO', '2016-05-30 06:16:33', '2016-05-30 06:16:33'),
(58, 24, 'iyaVQbgTUkWStahtzGHIEIRkALv8Supg', '2016-05-30 10:42:05', '2016-05-30 10:42:05'),
(61, 14, 'bMTvim3My58IPOGZNUVaGZFOovCEBUWv', '2016-05-31 09:43:54', '2016-05-31 09:43:54');

-- --------------------------------------------------------

--
-- Структура таблиці `reminders`
--

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблиці `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп даних таблиці `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'Administrator', '{"users.create":true,"users.update":true,"users.view":true,"users.destroy":true,"roles.create":true,"roles.update":true,"roles.view":true,"roles.delete":true}', '2016-05-12 05:36:26', '2016-05-12 05:36:26'),
(2, 'agent', 'Agent', '', '2016-05-12 05:36:26', '2016-05-12 05:36:26'),
(3, 'salesman', 'Salesman', '', '2016-05-12 05:36:26', '2016-05-12 05:36:26'),
(4, 'operator', 'Operator', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `role_users`
--

DROP TABLE IF EXISTS `role_users`;
CREATE TABLE IF NOT EXISTS `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2016-05-12 05:36:26', '2016-05-12 05:36:26'),
(2, 3, '2016-05-12 05:36:26', '2016-05-12 05:36:26'),
(11, 4, '2016-05-15 06:22:45', '2016-05-15 06:22:45'),
(14, 2, '2016-05-16 07:09:33', '2016-05-16 07:09:33'),
(22, 3, '2016-05-29 10:31:15', '2016-05-29 10:31:15');

-- --------------------------------------------------------

--
-- Структура таблиці `salesman_info`
--

DROP TABLE IF EXISTS `salesman_info`;
CREATE TABLE IF NOT EXISTS `salesman_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salesman_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `sphere_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп даних таблиці `salesman_info`
--

INSERT INTO `salesman_info` (`id`, `salesman_id`, `agent_id`, `sphere_id`, `bill_id`, `created_at`, `updated_at`) VALUES
(1, 22, 14, 1, 4, '2016-05-29 10:31:15', '2016-05-29 10:31:15');

-- --------------------------------------------------------

--
-- Структура таблиці `spheres`
--

DROP TABLE IF EXISTS `spheres`;
CREATE TABLE IF NOT EXISTS `spheres` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `openLead` int(11) NOT NULL DEFAULT '3',
  `minLead` int(11) NOT NULL,
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп даних таблиці `spheres`
--

INSERT INTO `spheres` (`id`, `status`, `name`, `openLead`, `minLead`, `table_name`, `created_at`, `updated_at`) VALUES
(4, 1, '[Test] active sphere', 1, 1, 'sphere_bitmask_4', '2016-05-15 10:15:10', '2016-06-07 05:18:24'),
(5, 0, '[Test] inactive', 1, 1, 'sphere_bitmask_5', '2016-05-16 08:02:18', '2016-06-07 05:19:23');

-- --------------------------------------------------------

--
-- Структура таблиці `sphere_attributes`
--

DROP TABLE IF EXISTS `sphere_attributes`;
CREATE TABLE IF NOT EXISTS `sphere_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sphere_id` int(11) NOT NULL,
  `_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(2083) COLLATE utf8_unicode_ci NOT NULL,
  `required` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Дамп даних таблиці `sphere_attributes`
--

INSERT INTO `sphere_attributes` (`id`, `sphere_id`, `_type`, `label`, `icon`, `required`, `default_value`, `position`, `created_at`, `updated_at`) VALUES
(34, 4, 'radio', 'Radio', '', '', '111', 1, '2016-05-15 10:29:45', '2016-05-15 10:29:46'),
(35, 4, 'checkbox', 'CheckBox', '', '', '111', 2, '2016-06-07 05:18:24', '2016-06-07 05:18:26');

-- --------------------------------------------------------

--
-- Структура таблиці `sphere_attribute_options`
--

DROP TABLE IF EXISTS `sphere_attribute_options`;
CREATE TABLE IF NOT EXISTS `sphere_attribute_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sphere_attr_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ctype` enum('agent','lead') COLLATE utf8_unicode_ci NOT NULL,
  `_type` enum('option','validate') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Дамп даних таблиці `sphere_attribute_options`
--

INSERT INTO `sphere_attribute_options` (`id`, `sphere_attr_id`, `ctype`, `_type`, `name`, `value`, `position`, `created_at`, `updated_at`) VALUES
(3, '34', 'agent', 'option', 'r1', 'r1', '', '2016-05-15 10:29:45', '2016-06-07 05:18:24'),
(4, '34', 'agent', 'option', 'r2', 'r2', '', '2016-05-15 10:29:46', '2016-06-07 05:18:24'),
(5, '34', 'agent', 'option', 'r3', 'r3', '', '2016-05-15 10:29:46', '2016-06-07 05:18:24'),
(6, '35', 'agent', 'option', 'c1', 'c1', '', '2016-06-07 05:18:24', '2016-06-07 05:18:24'),
(7, '35', 'agent', 'option', 'c2', 'c2', '', '2016-06-07 05:18:25', '2016-06-07 05:18:25'),
(8, '35', 'agent', 'option', 'c3', 'c3', '', '2016-06-07 05:18:25', '2016-06-07 05:18:25');

-- --------------------------------------------------------

--
-- Структура таблиці `sphere_bitmask_4`
--

DROP TABLE IF EXISTS `sphere_bitmask_4`;
CREATE TABLE IF NOT EXISTS `sphere_bitmask_4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` enum('agent','lead') NOT NULL DEFAULT 'agent',
  `status` tinyint(1) DEFAULT '0',
  `lead_price` float DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fb_34_3` tinyint(1) DEFAULT NULL,
  `fb_34_4` tinyint(1) DEFAULT NULL,
  `fb_34_5` tinyint(1) DEFAULT NULL,
  `fb_35_6` tinyint(1) DEFAULT NULL,
  `fb_35_7` tinyint(1) DEFAULT NULL,
  `fb_35_8` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп даних таблиці `sphere_bitmask_4`
--

INSERT INTO `sphere_bitmask_4` (`id`, `user_id`, `type`, `status`, `lead_price`, `updated_at`, `fb_34_3`, `fb_34_4`, `fb_34_5`, `fb_35_6`, `fb_35_7`, `fb_35_8`) VALUES
(1, 1, 'agent', 1, 37, '2016-05-15 13:30:24', 1, 0, 1, NULL, NULL, NULL),
(2, 14, 'agent', 1, 35, '2016-05-16 12:08:12', 1, 1, 0, NULL, NULL, NULL),
(3, 7, 'lead', 0, NULL, '2016-05-17 11:49:09', 1, 0, 0, NULL, NULL, NULL),
(14, 8, 'lead', 0, NULL, '2016-05-18 13:10:44', 1, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `sphere_bitmask_5`
--

DROP TABLE IF EXISTS `sphere_bitmask_5`;
CREATE TABLE IF NOT EXISTS `sphere_bitmask_5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` bigint(20) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `lead_price` float DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agent_id` (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблиці `sphere_lead_attributes`
--

DROP TABLE IF EXISTS `sphere_lead_attributes`;
CREATE TABLE IF NOT EXISTS `sphere_lead_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sphere_id` int(11) NOT NULL,
  `_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(2083) COLLATE utf8_unicode_ci NOT NULL,
  `required` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп даних таблиці `sphere_lead_attributes`
--

INSERT INTO `sphere_lead_attributes` (`id`, `sphere_id`, `_type`, `label`, `icon`, `required`, `position`, `created_at`, `updated_at`) VALUES
(1, 4, 'calendar', 'Date', '', '', 1, '2016-05-22 11:46:03', '2016-05-22 11:46:03');

-- --------------------------------------------------------

--
-- Структура таблиці `sphere_statuses`
--

DROP TABLE IF EXISTS `sphere_statuses`;
CREATE TABLE IF NOT EXISTS `sphere_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sphere_id` int(11) NOT NULL,
  `stepname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `minmax` tinyint(1) NOT NULL,
  `percent` double(8,2) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп даних таблиці `sphere_statuses`
--

INSERT INTO `sphere_statuses` (`id`, `sphere_id`, `stepname`, `minmax`, `percent`, `position`, `created_at`, `updated_at`) VALUES
(1, 4, 'goog', 0, 15.00, 1, '2016-06-07 05:18:24', '2016-06-07 05:18:24'),
(2, 5, 'bad deal', 1, 15.00, 1, '2016-06-07 05:19:23', '2016-06-07 05:19:23');

-- --------------------------------------------------------

--
-- Структура таблиці `throttle`
--

DROP TABLE IF EXISTS `throttle`;
CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Дамп даних таблиці `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2016-05-16 04:49:32', '2016-05-16 04:49:32'),
(2, NULL, 'ip', '127.0.0.1', '2016-05-16 04:49:32', '2016-05-16 04:49:32'),
(3, NULL, 'global', NULL, '2016-05-16 07:03:55', '2016-05-16 07:03:55'),
(4, NULL, 'ip', '127.0.0.1', '2016-05-16 07:03:55', '2016-05-16 07:03:55'),
(5, NULL, 'global', NULL, '2016-05-17 06:10:55', '2016-05-17 06:10:55'),
(6, NULL, 'ip', '127.0.0.1', '2016-05-17 06:10:55', '2016-05-17 06:10:55'),
(7, 11, 'user', NULL, '2016-05-17 06:10:55', '2016-05-17 06:10:55'),
(8, NULL, 'global', NULL, '2016-05-17 06:11:36', '2016-05-17 06:11:36'),
(9, NULL, 'ip', '127.0.0.1', '2016-05-17 06:11:36', '2016-05-17 06:11:36'),
(10, 11, 'user', NULL, '2016-05-17 06:11:36', '2016-05-17 06:11:36'),
(11, NULL, 'global', NULL, '2016-05-17 07:48:59', '2016-05-17 07:48:59'),
(12, NULL, 'ip', '127.0.0.1', '2016-05-17 07:48:59', '2016-05-17 07:48:59'),
(13, 11, 'user', NULL, '2016-05-17 07:48:59', '2016-05-17 07:48:59');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `confirmation_code`, `permissions`, `last_login`, `first_name`, `last_name`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin@admin.com', '$2y$10$evY2.QXOEHi0oeTjqpqpfOjbOfFsugh58T942MM3zZa32eVGTCZaG', NULL, NULL, '2016-06-07 05:17:01', NULL, NULL, 'Admin', '2016-05-12 05:36:26', '2016-06-07 05:17:01'),
(2, 'user@user.com', '$2y$10$GLeqGv8FxK4mhY5UKdvRAuEjXBgT19l4hBgdcOb.k2j6ibMyNvtZK', NULL, NULL, '2016-05-16 06:23:29', NULL, NULL, NULL, '2016-05-12 05:36:26', '2016-05-16 06:23:29'),
(11, 'operator@operator.com', '$2y$10$p7ksmK.AfC0jYlde0s6z/OnHldVSt6JSAcJ.kLj6Ke//yFh4Y5kMC', NULL, NULL, '2016-05-31 08:51:10', '1', '2', '3', '2016-05-15 06:22:45', '2016-05-31 08:51:10'),
(14, 'agent@agent.com', '$2y$10$1eyKxuSepUZrApaLm8G/7OXrKUrV3GIrQ9PK7Xc84emaGdDDBrvuK', NULL, NULL, '2016-06-08 11:33:10', 'Aname', 'Asurname', 'Agent name', '2016-05-16 07:09:33', '2016-06-08 11:33:10'),
(22, 'salesman@salesman.com', '$2y$10$sa0ER9eFLvFqCChwk78t9eMhTwszkAP0Wtjp1TLhZGqoB0E.8bO8S', NULL, NULL, '2016-05-30 05:44:07', 'Fsalesman', 'Lsalesman', '1', '2016-05-29 10:31:15', '2016-05-30 05:44:07');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
