-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 13, 2024 at 12:58 PM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u442681501_playpoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `site_name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `profile_image` text DEFAULT NULL,
  `profile_logo` text DEFAULT NULL,
  `package_name` text DEFAULT NULL,
  `license` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `site_name`, `email`, `email_verified_at`, `password`, `remember_token`, `profile_image`, `profile_logo`, `package_name`, `license`, `created_at`, `updated_at`) VALUES
(1, 'Play Point Admin', 'Play Point Admin', 'admin@admin.com', NULL, '$2y$10$tWGEKfqjzj.Ny8Up/dwGquciayc7hQ6OTd2ctwApwIqDj6P6A/2XK', '0xzuFuXKYBfkVJH9J6wulhBKxIni8cADXjnNExiKGweMBahOZ6elNC876lGs', '/images/avatar/1696660180.png', '/images/csm/codesellmarket-noti-1696518154.png', 'rg', '18fafa66-f286-4592-b707-ffc80a65fc71', NULL, '2024-08-03 15:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `ad_settings`
--

CREATE TABLE `ad_settings` (
  `id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ids` text DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '0=video\r\n1=offer',
  `net_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0=enabled\r\n1=disabled',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ad_settings`
--

INSERT INTO `ad_settings` (`id`, `image`, `name`, `ids`, `type`, `net_id`, `status`, `updated_at`, `created_at`) VALUES
(1, '/images/csm/codesellmarket-1700418637.png', 'Unity Ad', '{\"video_coins\":\"100\",\"video_limit\":\"10\",\"game_id\":\"5281956\",\"reward_ad_id\":\"Rewarded_Android\",\"interstitial_ad_id\":\"Interstitial_Android\"}', 0, 'unity', 0, '2023-11-21 23:20:24', NULL),
(3, '/images/csm/codesellmarket-1696306406.png', 'Facebook', '{\"video_coins\":\"100\",\"video_limit\":\"10\",\"reward_ad_id\":\"VID_HD_9_16_39S_APP_INSTALL#407103646956948_407112116956101\",\"interstitial_ad_id\":\"VID_HD_9_16_39S_APP_INSTALL#1433749050527341_1433767690525477\"}', 0, 'fb', 0, '2023-11-21 23:19:53', NULL),
(4, '/images/csm/codesellmarket-1696262771.png', 'AdGateMedia', '{\"AdGateMedia_Wallcode\":\"n6aVrg\",\"api_key\":\"59cdf54f3476a9592d9e729fd834a6e3\",\"aff_id\":\"70372\",\"api_status\":\"0\"}', 1, 'adget', 0, '2023-10-02 21:36:11', NULL),
(5, '/images/csm/codesellmarket-1696262853.png', 'Offertoro', '{\"offertoro_app_id\":\"14611\",\"offertoro_secret_key\":\"85fc9461c7f2b33f038ac385ff9ae27a\"}', 1, 'offertoro', 0, '2023-10-02 21:37:33', NULL),
(6, '/images/csm/codesellmarket-1696306147.png', 'Ironsource', '{\"ironsource_appkey\":\"16a43b36d\"}', 1, 'is', 0, '2023-10-03 09:39:07', NULL),
(7, '/images/csm/codesellmarket-1696305905.png', 'Tapjoy', '{\"tapjoy_sdk_key\":\"eRR6SzSoSySDadMgufeFHgEC6LXq18kWpIDX0VmqvEEtP3ZORyQK045WGJyr\",\"tapjoy_offerwall_name\":\"ugame\"}', 1, 'tj', 0, '2023-10-03 09:35:05', NULL),
(8, '/images/csm/codesellmarket-1696306468.png', 'AdMob', '{\"video_coins\":\"100\",\"video_limit\":\"10\",\"reward_ad_id\":\"ca-app-pub-3940256099942544\\/5224354917\",\"Interstitial_Ad_Unit\":\"ca-app-pub-3940256099942544\\/1033173712\"}', 0, 'admob', 0, '2024-05-18 16:30:50', NULL),
(9, '/images/csm/codesellmarket-1696306480.png', 'AdColony', '{\"video_coins\":\"150\",\"video_limit\":\"10\",\"app_id\":\"appfc913cfa221443d4bb\",\"Interstitial_Ad_Id\":\"vzb0602e9e17db4a7fba\",\"reward_ad_id\":\"vzb0602e9e17db4a7fba\"}', 0, 'adColony', 0, '2023-11-21 23:17:38', NULL),
(10, '/images/csm/codesellmarket-1696305726.png', 'adGem', '{\"adgem_app_id\":\"27926\"}', 1, 'adgem', 0, '2023-10-03 09:32:06', NULL),
(11, '/images/csm/codesellmarket-1696305735.png', 'CPALead', '{\"cpa_lead_offerwall_url\":\"https:\\/\\/fastsvr.com\\/list\\/503397\"}', 1, 'cpalead', 0, '2023-10-03 09:32:15', NULL),
(12, '/images/csm/codesellmarket-1700668624.png', 'AppLovinMax', '{\"video_coins\":\"100\",\"video_limit\":\"10\",\"Interstitial_Ad_Unit\":\"d74fac8932b0cee4\",\"Reward_Ad_Unit\":\"123\"}', 0, 'max', 0, '2023-11-22 21:27:04', NULL),
(13, '/images/csm/codesellmarket-1700669539.png', 'Start.io', '{\"video_coins\":\"100\",\"video_limit\":\"15\",\"app_id\":\"207501555\"}', 0, 'startapp', 0, '2023-11-22 21:42:19', NULL),
(14, '/images/csm/codesellmarket-1700669529.png', 'Vungle', '{\"video_coins\":\"100\",\"video_limit\":\"10\",\"app_id\":\"632ae923acd0c696a7c1f1a5\",\"InterstitialPlacementId\":\"INTERSTITIALAD-3855328\",\"RewardPlacementId\":\"REWARD_AD-8546119\"}', 0, 'vungle', 0, '2023-11-22 21:42:09', NULL),
(15, '/images/csm/codesellmarket-1700669453.png', 'Chartboost', '{\"video_coins\":\"100\",\"video_limit\":\"10\",\"app_id\":\"655da2859949a1ea36c156ba\",\"appSignature\":\"c330978ce7e24ee378cf785d3caaf4e23408ffc5\",\"interstitial_location_name\":\"fullscreen_ad\",\"reward_location_name\":\"fullscreen_ad_rewarded\"}', 0, 'chartboost', 0, '2023-11-22 21:40:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announces`
--

CREATE TABLE `announces` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub` text NOT NULL,
  `image` text DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sub` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0=active\r\n1=disabled',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `sub`, `image`, `url`, `status`, `updated_at`, `created_at`) VALUES
(11, 'Join Telegram', 'https://csmdevelopers.com/devs/play_point_codecanyon/admin/banners', '/images/csm/codesellmarket-noti-1712279829.webp', 'https://csmdevelopers.com/devs/play_point_codecanyon', 0, '2024-04-05 06:47:10', '2024-04-05 06:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `daily_tasks`
--

CREATE TABLE `daily_tasks` (
  `id` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `coins` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_tasks`
--

INSERT INTO `daily_tasks` (`id`, `days`, `coins`) VALUES
(1, 3, 500),
(2, 15, 2000),
(3, 30, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `game` varchar(255) NOT NULL,
  `screen` int(11) DEFAULT NULL COMMENT '0=portrait\r\n1=landscape',
  `time` int(11) DEFAULT NULL,
  `coins` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `plays` bigint(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `image`, `game`, `screen`, `time`, `coins`, `category`, `plays`, `created_at`, `updated_at`) VALUES
(6, 'Truck Racing', '/images/csm/codesellmarket-1696322287.jpg', 'https://play.famobi.com/endless-truck', 1, 1, 10, 'racing', 21, NULL, '2024-09-20 01:43:30'),
(8, 'Doomsday Town', '/images/csm/codesellmarket-1696315785.jpg', 'https://html5.gamemonetize.co/9k4cm8mbtz1a765zuc6yqkluu8s9f3gb/', 0, 1, 100, 'action', 67, NULL, '2024-08-19 09:11:02'),
(13, 'Drift Dudes', '/images/csm/codesellmarket-1696314223.jpg', 'https://play.famobi.com/drift-dudes', 0, 1, 20, 'racing', 19, '2023-10-03 11:50:42', '2024-08-16 15:48:49'),
(15, 'Temple Run', '/images/csm/codesellmarket-1696316100.jpg', 'https://html5.gamemonetize.com/pkyyuilfrqkcdnmrxsg60j22ypk0peje/', 0, 2, 50, 'action', 2567, '2023-10-03 12:25:00', '2024-08-19 08:55:44'),
(16, 'Worms Zone', '/images/csm/codesellmarket-1696316918.png', 'https://html5.gamemonetize.co/vz6qfngm0al4ggz8f3lrvrfrqrm1q19m/', 0, 1, 20, 'action', 1371, '2023-10-03 12:32:19', '2024-09-25 19:29:51'),
(17, 'Shortcut Pro', '/images/csm/codesellmarket-1696317366.jpg', 'https://html5.gamemonetize.co/8n1dyc1cai3o1r62f6xzgb7axr88gb7w/', 0, 1, 20, 'action', 3, '2023-10-03 12:41:31', '2024-04-27 21:03:54'),
(18, 'Bus parking 3d', '/images/csm/codesellmarket-1696317517.jpg', 'https://play.famobi.com/bus-parking-3d', 1, 1, 10, 'action', 16, '2023-10-03 12:48:37', '2024-09-26 14:22:40'),
(19, 'Mad Day Special', '/images/csm/codesellmarket-1696317961.jpg', 'https://html5.gamemonetize.co/x1pcf3eqnaqhacegno3gkgidfsbz7us4/', 1, 1, 20, 'action', 8, '2023-10-03 12:56:01', '2024-05-27 16:48:40'),
(20, 'Casstle Fight', '/images/csm/codesellmarket-1696318484.jpg', 'https://html5.gamemonetize.co/0gtg17gekbuugpnss5fpullp2famfaqr/', 0, 1, 20, 'puzzle', 3, '2023-10-03 13:04:44', '2024-05-27 20:04:21'),
(21, 'Pure Sky Rolling Ball', '/images/csm/codesellmarket-1712192100.jpg', 'https://html5.gamemonetize.co/iy345bo9rotjucwtgcjleebbu48pa1t8/', 0, 1, 100, 'action', 0, '2024-04-04 06:25:00', '2024-04-04 06:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `leaders`
--

CREATE TABLE `leaders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `live_t_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `score` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_09_11_101603_create_admins_table', 1),
(6, '2021_09_28_150557_create_roles_table', 1),
(7, '2021_09_28_150603_create_permissions_table', 1),
(8, '2021_09_28_150804_create_users_permission_table', 1),
(9, '2021_09_28_150837_create_users_roles_table', 1),
(10, '2021_09_28_151026_create_roles_permissions_table', 1),
(11, '2021_10_12_151812_create_posts_table', 1),
(12, '2023_04_09_092134_offers', 2),
(13, '2023_04_09_110103_offer_lists', 3),
(14, '2023_05_02_163040_refer_data', 4),
(15, '2023_05_02_171615_trackers', 5),
(16, '2023_05_03_115213_redeems', 6),
(17, '2023_05_04_084307_offer_status', 7),
(18, '2023_05_04_092500_offer_statuses', 8),
(19, '2023_06_11_105158_games', 9),
(20, '2023_06_11_110230_tournaments', 10),
(21, '2023_06_11_123409_live_tournaments', 11),
(22, '2023_06_11_130558_leaders', 12),
(23, '2023_06_16_080632_rewards', 13),
(24, '2023_06_16_080833_reward_amounts', 14),
(25, '2023_06_16_080854_reward_list', 14);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `desc`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Terms & Conditions', 'terms', '<p><strong>Terms &amp; Conditions</strong></p>\r\n\r\n<p>By downloading or using the app, these terms will automatically apply to you &ndash; you should make sure therefore that you read them carefully before using the app. You&rsquo;re not allowed to copy or modify the app, any part of the app, or our trademarks in any way. You&rsquo;re not allowed to attempt to extract the source code of the app, and you also shouldn&rsquo;t try to translate the app into other languages or make derivative versions. The app itself, and all the trademarks, copyright, database rights, and other intellectual property rights related to it, still belong to CSM Developers.</p>\r\n\r\n<p>CSM Developers is committed to ensuring that the app is as useful and efficient as possible. For that reason, we reserve the right to make changes to the app or to charge for its services, at any time and for any reason. We will never charge you for the app or its services without making it very clear to you exactly what you&rsquo;re paying for.</p>\r\n\r\n<p>The SuperPaisa app stores and processes personal data that you have provided to us, to provide my Service. It&rsquo;s your responsibility to keep your phone and access to the app secure. We therefore recommend that you do not jailbreak or root your phone, which is the process of removing software restrictions and limitations imposed by the official operating system of your device. It could make your phone vulnerable to malware/viruses/malicious programs, compromise your phone&rsquo;s security features and it could mean that the SuperPaisa app won&rsquo;t work properly or at all.</p>\r\n\r\n<div>\r\n<p>The app does use third-party services that declare their Terms and Conditions.</p>\r\n\r\n<p>Link to Terms and Conditions of third-party service providers used by the app</p>\r\n\r\n<ul>\r\n	<li><a href=\"https://policies.google.com/terms\" rel=\"noopener noreferrer\" target=\"_blank\">Google Play Services</a></li>\r\n	<li><a href=\"https://www.google.com/analytics/terms/\" rel=\"noopener noreferrer\" target=\"_blank\">Google Analytics for Firebase</a></li>\r\n	<li><a href=\"https://www.facebook.com/legal/terms/plain_text_terms\" rel=\"noopener noreferrer\" target=\"_blank\">Facebook</a></li>\r\n	<li><a href=\"https://unity3d.com/legal/terms-of-service\" rel=\"noopener noreferrer\" target=\"_blank\">Unity</a></li>\r\n	<li><a href=\"https://onesignal.com/tos\" rel=\"noopener noreferrer\" target=\"_blank\">One Signal</a></li>\r\n	<li><a href=\"https://www.applovin.com/terms/\" rel=\"noopener noreferrer\" target=\"_blank\">AppLovin</a></li>\r\n</ul>\r\n</div>\r\n\r\n<p>You should be aware that there are certain things that CSM Developers will not take responsibility for. Certain functions of the app will require the app to have an active internet connection. The connection can be Wi-Fi or provided by your mobile network provider, but CSM Developers cannot take responsibility for the app not working at full functionality if you don&rsquo;t have access to Wi-Fi, and you don&rsquo;t have any of your data allowance left.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>If you&rsquo;re using the app outside of an area with Wi-Fi, you should remember that the terms of the agreement with your mobile network provider will still apply. As a result, you may be charged by your mobile provider for the cost of data for the duration of the connection while accessing the app, or other third-party charges. In using the app, you&rsquo;re accepting responsibility for any such charges, including roaming data charges if you use the app outside of your home territory (i.e. region or country) without turning off data roaming. If you are not the bill payer for the device on which you&rsquo;re using the app, please be aware that we assume that you have received permission from the bill payer for using the app.</p>\r\n\r\n<p>Along the same lines, CSM Developers cannot always take responsibility for the way you use the app i.e. You need to make sure that your device stays charged &ndash; if it runs out of battery and you can&rsquo;t turn it on to avail the Service, CSM Developers cannot accept responsibility.</p>\r\n\r\n<p>With respect to CSM Developers&rsquo;s responsibility for your use of the app, when you&rsquo;re using the app, it&rsquo;s important to bear in mind that although we endeavor to ensure that it is updated and correct at all times, we do rely on third parties to provide information to us so that we can make it available to you. CSM Developers accepts no liability for any loss, direct or indirect, you experience as a result of relying wholly on this functionality of the app.</p>\r\n\r\n<p>At some point, we may wish to update the app. The app is currently available on Android &ndash; the requirements for the system(and for any additional systems we decide to extend the availability of the app to) may change, and you&rsquo;ll need to download the updates if you want to keep using the app. CSM Developers does not promise that it will always update the app so that it is relevant to you and/or works with the Android version that you have installed on your device. However, you promise to always accept updates to the application when offered to you, We may also wish to stop providing the app, and may terminate use of it at any time without giving notice of termination to you. Unless we tell you otherwise, upon any termination, (a) the rights and licenses granted to you in these terms will end; (b) you must stop using the app, and (if needed) delete it from your device.</p>\r\n\r\n<p><strong>Changes to This Terms and Conditions</strong></p>\r\n\r\n<p>I may update our Terms and Conditions from time to time. Thus, you are advised to review this page periodically for any changes. I will notify you of any changes by posting the new Terms and Conditions on this page.</p>\r\n\r\n<p>These terms and conditions are effective as of 2023-10-07</p>\r\n\r\n<p><strong>Contact Us</strong></p>\r\n\r\n<p>If you have any questions or suggestions about my Terms and Conditions, do not hesitate to contact me at ugameleague@gmail.com.</p>', 1, '2023-10-07 16:03:36', NULL),
(2, 'Privacy Policy', 'privacy', '<p><strong>Privacy Policy</strong></p>\r\n\r\n<p>CSM Developers built the SuperPaisa app as a Free app. This SERVICE is provided by CSM Developers at no cost and is intended for use as is.</p>\r\n\r\n<p>This page is used to inform visitors regarding my policies with the collection, use, and disclosure of Personal Information if anyone decided to use my Service.</p>\r\n\r\n<p>If you choose to use my Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that I collect is used for providing and improving the Service. I will not use or share your information with anyone except as described in this Privacy Policy.</p>\r\n\r\n<p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which are accessible at SuperPaisa unless otherwise defined in this Privacy Policy.</p>\r\n\r\n<p><strong>Information Collection and Use</strong></p>\r\n\r\n<p>For a better experience, while using our Service, I may require you to provide us with certain personally identifiable information. The information that I request will be retained on your device and is not collected by me in any way.</p>\r\n\r\n<div>\r\n<p>The app does use third-party services that may collect information used to identify you.</p>\r\n\r\n<p>Link to the privacy policy of third-party service providers used by the app</p>\r\n\r\n<ul>\r\n	<li><a href=\"https://www.google.com/policies/privacy/\" rel=\"noopener noreferrer\" target=\"_blank\">Google Play Services</a></li>\r\n	<li><a href=\"https://firebase.google.com/support/privacy\" rel=\"noopener noreferrer\" target=\"_blank\">Google Analytics for Firebase</a></li>\r\n	<li><a href=\"https://www.facebook.com/about/privacy/update/printable\" rel=\"noopener noreferrer\" target=\"_blank\">Facebook</a></li>\r\n	<li><a href=\"https://unity3d.com/legal/privacy-policy\" rel=\"noopener noreferrer\" target=\"_blank\">Unity</a></li>\r\n	<li><a href=\"https://onesignal.com/privacy_policy\" rel=\"noopener noreferrer\" target=\"_blank\">One Signal</a></li>\r\n	<li><a href=\"https://www.applovin.com/privacy/\" rel=\"noopener noreferrer\" target=\"_blank\">AppLovin</a></li>\r\n	<li><a href=\"https://vungle.com/privacy/\" rel=\"noopener noreferrer\" target=\"_blank\">Vungle</a></li>\r\n	<li><a href=\"https://www.adcolony.com/privacy-policy/\" rel=\"noopener noreferrer\" target=\"_blank\">AdColony</a></li>\r\n</ul>\r\n</div>\r\n\r\n<p><strong>Log Data</strong></p>\r\n\r\n<p>I want to inform you that whenever you use my Service, in a case of an error in the app I collect data and information (through third-party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol (&ldquo;IP&rdquo;) address, device name, operating system version, the configuration of the app when utilizing my Service, the time and date of your use of the Service, and other statistics.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These are sent to your browser from the websites that you visit and are stored on your device&#39;s internal memory.</p>\r\n\r\n<p>This Service does not use these &ldquo;cookies&rdquo; explicitly. However, the app may use third-party code and libraries that use &ldquo;cookies&rdquo; to collect information and improve their services. You have the option to either accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to refuse our cookies, you may not be able to use some portions of this Service.</p>\r\n\r\n<p><strong>Service Providers</strong></p>\r\n\r\n<p>I may employ third-party companies and individuals due to the following reasons:</p>\r\n\r\n<ul>\r\n	<li>To facilitate our Service;</li>\r\n	<li>To provide the Service on our behalf;</li>\r\n	<li>To perform Service-related services; or</li>\r\n	<li>To assist us in analyzing how our Service is used.</li>\r\n</ul>\r\n\r\n<p>I want to inform users of this Service that these third parties have access to their Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>\r\n\r\n<p><strong>Security</strong></p>\r\n\r\n<p>I value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and I cannot guarantee its absolute security.</p>\r\n\r\n<p><strong>Links to Other Sites</strong></p>\r\n\r\n<p>This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by me. Therefore, I strongly advise you to review the Privacy Policy of these websites. I have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>\r\n\r\n<p><strong>Children&rsquo;s Privacy</strong></p>\r\n\r\n<div>\r\n<p>These Services do not address anyone under the age of 13. I do not knowingly collect personally identifiable information from children under 13 years of age. In the case I discover that a child under 13 has provided me with personal information, I immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact me so that I will be able to do the necessary actions.</p>\r\n</div>\r\n\r\n<p><strong>Changes to This Privacy Policy</strong></p>\r\n\r\n<p>I may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. I will notify you of any changes by posting the new Privacy Policy on this page.</p>\r\n\r\n<p>This policy is effective as of 2023-10-07</p>\r\n\r\n<p><strong>Contact Us</strong></p>\r\n\r\n<p>If you have any questions or suggestions about my Privacy Policy, do not hesitate to contact me at ugameleague@gmail.com.</p>', 1, '2023-10-07 16:02:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Add Post', 'add-post', NULL, NULL),
(2, 'Delete Post', 'delete-post', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `admin_id`, `created_at`, `updated_at`) VALUES
(3, 'Quidem aut id nisi enim', 'Voluptas et eligendi necessitatibus dolorem. Odit dolorem blanditiis iure omnis corporis. Vitae vel rem animi exercitationem necessitatibus quia.\n\nEt atque accusantium quos qui. Accusamus aspernatur ex suscipit quo dolorem qui libero. Dignissimos quia minus inventore harum dicta ipsam sed.\n\nConsequuntur sequi aut quis quo aut adipisci beatae. Id accusantium dolor similique est asperiores inventore. Velit praesentium veniam consequatur atque eos ut praesentium. Pariatur dolore nihil voluptatem optio voluptatem eum rem.\n\nEt est enim excepturi quia. Aut iusto dolores ab tenetur et impedit voluptatem et. Voluptatem nobis sit corrupti quia vitae architecto cumque. Consequatur aliquam aut architecto quam ut est.\n\nDeleniti ut asperiores dolores sequi aliquam porro voluptates. Magni aliquid culpa inventore impedit. In in sapiente minus tempore consequuntur.\n\nError eum cupiditate in ut. Suscipit saepe ut voluptatem repudiandae molestiae quis. Error quaerat fugiat repellat nobis. Non porro quibusdam explicabo consequatur dolorem quisquam id officia.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(6, 'Nihil aut aut quae', 'Recusandae ipsa aliquid illum cupiditate id alias nobis. Cumque molestiae esse eos. Et sapiente voluptas corporis enim.\n\nIusto reiciendis maxime est ullam earum. Et et quisquam eum in. Sunt alias quisquam ea et.\n\nQui culpa aperiam eos occaecati consequatur voluptas voluptates accusantium. Expedita sint sed maxime rerum accusantium doloribus iure. Unde vel sunt autem ut et. Rerum sunt minima vel fugit ex qui. Voluptatibus omnis quidem voluptatibus quos iure fuga.\n\nRerum maxime rerum quisquam. Omnis suscipit aut natus quia dolores voluptates. Unde ut similique modi quas illum quo. Esse et est nulla nihil blanditiis ut.\n\nQuaerat expedita eaque quo quis voluptas quas. Enim omnis quas impedit officiis non et similique ut. Esse voluptas enim occaecati.\n\nEx harum est porro iure earum ut odio. Saepe esse magnam eum officiis deleniti velit. Omnis consequatur dolores voluptas non rerum.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(7, 'Animi dicta at voluptatem', 'Voluptatibus necessitatibus hic error ut officia culpa omnis voluptatum. Veritatis ipsam sed quia doloribus quis. Totam culpa odio voluptatum. Molestiae voluptates nostrum aliquam assumenda alias.\n\nQuia necessitatibus eaque consequatur possimus omnis velit ducimus saepe. Aliquid sint et aperiam voluptatem quia assumenda ea. Voluptatum laudantium nihil voluptas.\n\nDoloremque rerum maxime unde voluptatem est perspiciatis velit impedit. Et quibusdam nulla et tempora. Ipsa corporis nisi ut nam maxime labore voluptas illum. At vel incidunt ab quibusdam eos. Placeat ipsa neque qui expedita et consequuntur.\n\nVoluptate amet quia magni et error sapiente. Et et expedita nesciunt. Neque nostrum ducimus accusantium deleniti natus occaecati quia.\n\nOmnis ut aliquam eum cumque. Doloribus doloremque officiis rerum cumque ut. Porro est et tempora non.\n\nEt qui ut iure quasi suscipit aliquid voluptatem. Perspiciatis blanditiis repellat incidunt dolor est quis. Repellendus necessitatibus maiores esse provident. Fugit ut nemo recusandae asperiores iure.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(9, 'A vel enim at et quia', 'Animi laboriosam cum corrupti quis quidem error aut. Commodi omnis omnis quaerat sed autem ipsa. Fugiat labore molestiae tempora quia est in cumque. Voluptates aliquid et et quia vitae.\n\nDeserunt blanditiis aliquid quam amet. Quis provident facere atque repellat illum. Repellendus distinctio voluptatem rerum et quia ab.\n\nIpsum dolore aut ea amet quidem. Eum et numquam qui dolorum rerum reiciendis. Dolores et deleniti in expedita ab eligendi nam. Quo ipsam architecto et soluta minima ut.\n\nAperiam consequatur neque consectetur. Quis eveniet et beatae aliquam debitis tempore sit. Non qui eos voluptatem voluptatem voluptatum inventore. Laboriosam est magni odio eveniet quia.\n\nCupiditate facilis beatae consequatur omnis dolorem voluptatem vero illo. Natus repellendus ipsa voluptatem nostrum dolorem quidem nesciunt. Quae id eaque suscipit necessitatibus cum. Numquam excepturi sit eius omnis quaerat.\n\nDignissimos itaque est sequi eum. Vitae quis nam deleniti mollitia illo aut qui. Eos officia perspiciatis laborum eveniet vel vel eos. Facere dolores totam nihil quibusdam dolor ab quis.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(10, 'Rerum aut cumque impedit', 'Vel cum assumenda ad est. Reprehenderit quae veniam molestiae sint velit dicta ea qui. Eius nihil saepe officia repellendus. Aut id architecto explicabo ipsa amet vel.\n\nUt pariatur placeat dicta cupiditate molestiae. Sunt explicabo ipsum ex. Iure occaecati autem suscipit sequi qui beatae accusamus ad. Voluptatem doloremque voluptas dolor qui iste odit.\n\nVoluptatibus ut qui molestias. Accusamus molestiae omnis voluptatibus aut officia pariatur. Accusantium numquam libero reiciendis vero. Quis molestias veritatis et aperiam tenetur.\n\nVel et eveniet labore minima quis. Laboriosam in consequatur sed corrupti id omnis. Nihil fuga dignissimos ut rerum aut.\n\nOccaecati sed mollitia molestiae. Odio laudantium explicabo qui et aperiam molestias dolorum. Dicta vero voluptatum aut delectus fugiat eaque veniam quia.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(15, 'Ea aut aut hic', 'Nam dolores porro cumque praesentium voluptatem omnis laudantium. Voluptatem voluptatem occaecati unde expedita repellendus in autem. Sed nemo et nihil eum quaerat asperiores nesciunt.\n\nEst ipsam aut consequuntur quia velit nesciunt veniam. In non non quos ipsa et fugiat incidunt.\n\nFugit dicta quam ut ullam. Hic optio facere molestias sit et odio ut et. Consectetur cupiditate praesentium libero omnis temporibus quos.\n\nAsperiores pariatur dignissimos non sit nulla. Dolore dolorem ut facilis eveniet. Totam amet nihil veniam dolores.\n\nRerum accusantium voluptatem eos. Quibusdam eligendi dicta nisi consectetur sed. Quasi maiores commodi laborum et aut sunt.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(18, 'Ad et assumenda quia', 'Odio officia aut mollitia aut quas incidunt laboriosam. Amet rerum quidem id blanditiis eos nihil. Neque sed perspiciatis facere ut voluptate dolorum. Sequi nihil occaecati sit dolore voluptate nihil labore.\n\nConsectetur illo quia hic vel cupiditate ab voluptas. Numquam omnis ipsa nobis provident nihil est nesciunt. Aut voluptatem sunt blanditiis non odio optio. Nihil a dignissimos ratione quae architecto dolores.\n\nEum cupiditate sed commodi est voluptas cum error consectetur. Eligendi voluptatem doloribus autem qui et. Sapiente minima unde ratione consequatur.\n\nNihil quis id cumque voluptatem aut. Dolor aut voluptatibus mollitia dicta voluptatem. Quia fugiat minus voluptate nihil.\n\nSit soluta odit dolores cum consectetur quo. Omnis enim voluptas id voluptas velit nulla ab et. Placeat non ut ea explicabo quod error.\n\nRem adipisci quia totam quis sunt blanditiis aliquam porro. Ea et quia eum rerum non nulla earum. Molestias explicabo deserunt et laboriosam molestiae. Dolores fugiat ut fuga fugiat eos.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(21, 'Quo quis iure rerum ratione', 'Labore quo beatae non nemo explicabo quia consequatur ipsam. Aspernatur non cum eaque vel qui sit voluptas quis. Architecto nemo laborum quae repudiandae autem. Esse ut explicabo libero voluptatem illum. Itaque quis velit qui consectetur tempora.\n\nEst mollitia aspernatur aperiam quod deleniti facere rem. In quas saepe nobis et est consequatur. Dolores vel reiciendis rerum autem ducimus perferendis.\n\nHarum illo quia qui nihil. Quisquam beatae non ut voluptas repellendus. Eveniet et reiciendis dolores vitae aut. Eos voluptas maiores velit enim eaque ullam aut dolores.\n\nEst nihil sed ut quos fuga ipsum suscipit. Libero quisquam velit voluptatem ratione cum. Quam modi aut facilis necessitatibus laudantium.\n\nVoluptatem quos iure voluptatem consequatur et nostrum deserunt soluta. Dolorem corporis corporis vel qui asperiores saepe. Et porro iste nobis alias qui.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(22, 'Sunt quo neque eius voluptas', 'Odit ut iste debitis error voluptate sed voluptates. Veniam praesentium tempora cum qui dolore fugiat. Esse nostrum corrupti et assumenda quas voluptatem dolorem. Voluptas quae dolore occaecati sapiente aliquam.\n\nQuam distinctio animi occaecati quam nihil. Rerum quia pariatur rerum ea fugit optio. Natus eos incidunt ullam rerum rerum iusto voluptas. Quod reprehenderit quis nihil natus eligendi.\n\nEveniet a ipsam eius alias nostrum ab. Aut omnis maiores assumenda et iure maxime. Nemo maiores non excepturi et.\n\nAt ut natus sapiente asperiores. Totam dolores est iure tempora distinctio id dolor cumque. Adipisci et consequatur nihil repellat.\n\nBlanditiis voluptas et officiis ut. Sunt dolores autem fugit commodi sed totam quasi.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(23, 'Recusandae iste ut minima', 'Reiciendis rem dolor debitis iste tempora doloremque. Tenetur eaque neque sint voluptatem consequuntur velit. Dicta est placeat ratione delectus. Eveniet porro rerum sed eius laborum.\n\nDolor similique quo qui omnis. Eligendi ipsum dolorem inventore optio neque aut dolores. Possimus architecto doloremque qui quidem et minima. Alias qui nulla et nostrum est. Nihil eum cupiditate error quibusdam optio rerum animi et.\n\nVoluptatum vero molestiae sint quibusdam. Qui aliquam tenetur occaecati iure quas sequi. Sit ullam quia mollitia quas minus.\n\nConsectetur sit architecto eos commodi. Amet animi veritatis molestias debitis illum libero sint. Eos vel vel ab nisi molestiae fuga consequatur. Vitae optio ut magni ad.\n\nEst sit quidem beatae quo aut. Nulla et ut ullam asperiores et. Excepturi perspiciatis quia alias officia eum et. Rem cumque laboriosam sunt velit quia rerum illo tenetur.\n\nMinima voluptatibus velit quia voluptas. Esse suscipit dolore ullam voluptas adipisci ut. Dolorum quis dolor ut in ab doloribus dolores. Minus repellat qui velit eos aut maxime.\n\nMinus dolorem assumenda facere eum. Sunt eos delectus id sed qui. Laborum soluta ipsum nostrum et quod reprehenderit. Sit ullam ipsum animi reprehenderit officia rerum inventore.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(27, 'Autem ut qui veritatis', 'Culpa et tempora magnam harum placeat. Minima tempore sit hic iste voluptatem exercitationem. Consequuntur quis quibusdam ab in. Doloribus reprehenderit ab exercitationem minima ipsam.\n\nTempore velit sint officiis tempora error minus. Earum eum qui esse magnam. Pariatur et in unde molestiae ab quo dolor et. Temporibus minus velit et dicta qui eius molestiae. Quos magnam laborum excepturi.\n\nAut voluptates dolor totam quo inventore. Id dolores non non iure ipsum ullam.\n\nAccusamus aut explicabo velit itaque. Ullam ea incidunt unde sed.\n\nCorrupti aspernatur inventore consectetur maxime. Voluptas doloremque quaerat labore nihil. Sit qui veniam modi aut.\n\nQuia officia est eos cupiditate assumenda enim corporis. Aut non nihil et. Alias rerum ipsam sit corporis vitae quam.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(28, 'Dolores a minus sint non', 'Officia consequatur dolore aspernatur aut. Nihil nobis corporis aliquam corrupti. Fugiat eius et alias fugiat sed quisquam. Harum autem et a libero magni error. Est voluptas eos et autem consequatur ipsam.\n\nIure est eum culpa accusantium natus voluptatem totam. Voluptas suscipit eveniet provident reiciendis. Voluptatum mollitia ut error.\n\nDolorem eligendi sit aut. Distinctio rerum occaecati reiciendis error. Culpa quam itaque ex explicabo labore deleniti neque.\n\nUnde soluta iure et velit. Maiores repellat odit itaque at. Inventore et impedit temporibus veniam repellat ex modi. Non eveniet et et sint eius repudiandae officia.\n\nVoluptatem ipsa placeat nihil exercitationem tenetur tempora. Maxime enim voluptatum praesentium et velit rerum. Dolores deleniti voluptatem est beatae sed omnis molestias. Impedit nostrum aut est cupiditate asperiores omnis. Aut rerum beatae ad delectus tempora placeat ut.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(29, 'Aliquam ut rem sed nesciunt', 'Eligendi laudantium quidem quae. Commodi dolor libero possimus nam facilis rerum deleniti. Ut dicta ea eum sunt enim aut velit.\n\nSed veritatis illum laudantium ut beatae. Quidem voluptatibus suscipit nemo nam quo soluta earum iusto. Iusto voluptate odit dignissimos enim sed eligendi.\n\nProvident minima quis eum numquam. Vitae sunt fugiat odio iusto fugiat eaque cum. Sit ut aut non aut itaque.\n\nConsequatur aut autem praesentium qui nihil eum consequuntur veniam. Molestiae nisi dolores vero neque similique consequatur sit.\n\nDoloremque reprehenderit earum corrupti quia architecto voluptas. Sequi libero amet excepturi sit consequuntur reprehenderit. Iure sed amet veniam illum cum. Vero ea voluptatem nulla dolorem odio veniam.\n\nQuam alias unde sint labore. Vel consequuntur quis minus vel molestiae unde. Magnam ut ea cumque et. Voluptatem adipisci excepturi autem incidunt vel fugiat rerum.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(33, 'Debitis ut et molestiae', 'Autem reiciendis sit sint velit et est. Officiis ratione magnam ratione quia asperiores et aliquid. Sit veniam quo non est.\n\nUllam iusto est dolor. Sit sit quia cum aut earum. Amet tempore facere ex in reiciendis dicta. Voluptatem repellendus eos maiores exercitationem ut expedita.\n\nQui aliquam aut natus vitae voluptate. Nulla quam nulla sed quo. Vel expedita omnis tenetur ipsam ex. Ut dolorem cumque quo nulla consectetur.\n\nDicta voluptatem quia adipisci dolorem iusto. Suscipit vel nam molestiae iure officia. Totam eaque quaerat nihil.\n\nAut sunt tempora reiciendis id et expedita optio. Possimus aut facilis suscipit eum. Dolor illo omnis tempore ut dolorem aut. Adipisci voluptatum nam aut dolorem eos omnis.\n\nQuaerat asperiores natus dolores perferendis. Maiores explicabo sapiente quia laborum qui. Et repudiandae nesciunt animi et nihil quos.\n\nRecusandae officiis omnis sunt reprehenderit. Dolore dolorum quo ipsa ut est. Nulla facilis voluptatem magnam dolores unde ipsum dolor aut. Occaecati animi occaecati qui nemo repellat.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(36, 'Magni vitae odit dolore', 'Molestiae beatae possimus eaque quia sunt. Cumque quia et commodi et iusto veniam dolores sequi. Quo iste deserunt consequatur molestias dolor aut sed. Ex officia sit praesentium saepe.\n\nVoluptas et doloribus mollitia ut qui ducimus perferendis. Aperiam ullam perferendis accusantium. Et quo voluptatum cumque et quod commodi.\n\nHarum dolorem quae velit pariatur ab id vel. Aut nam ut praesentium aut voluptatem omnis.\n\nDoloribus tempora itaque laudantium repellendus voluptate dignissimos sit quis. Dolores commodi natus quia perferendis quos praesentium maiores. Impedit est nobis reiciendis consectetur impedit. Eos non modi et eveniet ipsa voluptatem officiis.\n\nRerum similique eius amet. Et provident sint tempore. Quis nostrum nemo quisquam sapiente unde veritatis veritatis.\n\nCupiditate vitae quisquam eos ut ipsa. Minima inventore atque et. Sint molestiae a qui sit. Voluptatem voluptatem a nihil minus harum voluptatum quidem.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(44, 'Illum quis dolor iure sed', 'Quo autem ab omnis sapiente. Voluptatem sequi velit quod perferendis sit ex ipsam corporis. Beatae totam tempore non ut officiis et voluptatibus.\n\nFuga voluptatem iure assumenda deserunt repellendus autem temporibus. Eum aliquam ipsa maxime debitis. Ea rerum quia nesciunt dignissimos suscipit dolores omnis quis.\n\nEum ut sint ipsum placeat dolore qui voluptatem. Itaque recusandae reprehenderit perspiciatis eveniet laborum cum. Illum error id temporibus veniam minus. Quas quisquam doloremque quia in ratione. Qui suscipit facere iure placeat ab ipsam.\n\nCulpa sequi tempore quis quas dicta. Qui nihil velit eius expedita nam voluptate sunt ipsum. In nemo qui cupiditate eius pariatur.\n\nOmnis enim non voluptatem adipisci. Nostrum quas quidem itaque quaerat quo perferendis asperiores. Consequatur repudiandae et illum ut repudiandae. Ut aliquid in eveniet in incidunt at non cupiditate.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04'),
(47, 'Sed quaerat sint quibusdam', 'Eos ea quia tempore temporibus recusandae. Voluptas maxime hic doloremque eum ut consectetur. Voluptas tempore et suscipit ut occaecati soluta. Officiis nihil est quo repudiandae.\n\nProvident aut ut labore. Necessitatibus itaque eligendi distinctio molestiae neque mollitia. Aut et ea architecto ullam.\n\nIllo molestias quas ratione non. Sed aut ut aperiam ut ut. Eligendi sed et est nihil voluptas omnis. Aspernatur iure in officiis consequatur modi quod corporis.\n\nAutem error aspernatur laboriosam ut id molestiae. Porro dolor et atque aut omnis sint quas et. Aut sed reiciendis odio et expedita.\n\nVoluptatum sed explicabo debitis eos. Dolorum voluptatem quod animi. Hic tempore distinctio omnis id consequatur laborum ipsam repellendus.\n\nVoluptatum voluptatibus ab aperiam dicta eligendi natus. Eligendi dolore laudantium molestiae repellendus voluptates expedita et. Deserunt animi ut nobis quasi impedit. Et quas natus quasi quam.', 1, '2022-11-20 03:54:04', '2022-11-20 03:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `refer_datas`
--

CREATE TABLE `refer_datas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `refer_id` varchar(255) NOT NULL,
  `time` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refer_tasks`
--

CREATE TABLE `refer_tasks` (
  `id` int(11) NOT NULL,
  `coins` int(11) DEFAULT NULL,
  `refers` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refer_tasks`
--

INSERT INTO `refer_tasks` (`id`, `coins`, `refers`, `updated_at`, `created_at`) VALUES
(2, 2000, 20, NULL, NULL),
(3, 5000, 50, NULL, NULL),
(4, 10000, 100, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `hint` varchar(255) NOT NULL,
  `input_type` varchar(11) NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=enable\r\n1=dissable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `name`, `image`, `symbol`, `hint`, `input_type`, `details`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Paypal', '/images/csm/codesellmarket-1696307045.png', '$', 'Enter paypal email', 'text', 'PayPal Cash Redeem', 0, '2023-06-22 11:39:37', '2023-10-03 09:54:05'),
(2, 'GooglePlay Code', '/images/csm/codesellmarket-1696307558.png', '$', 'Enter your email', 'email', 'Google Play Redeem Code', 0, '2023-06-22 11:39:37', '2023-10-03 10:02:38'),
(9, 'PayTm', '/images/csm/codesellmarket-1696306999.png', '₹', 'Enter your paytm number', 'text', 'PayTm Cash Redeem', 0, '2023-07-31 20:23:47', '2023-10-03 09:53:19'),
(13, 'Amazon Gift', '/images/csm/codesellmarket-1696306870.png', '$', 'Enter your email', 'text', 'Amazon Gift Card', 0, '2023-07-31 20:23:47', '2023-10-03 09:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `reward_amounts`
--

CREATE TABLE `reward_amounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `r_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_amounts`
--

INSERT INTO `reward_amounts` (`id`, `r_id`, `amount`, `coins`, `created_at`, `updated_at`) VALUES
(13, 4, 2, 4, '2023-07-26 02:58:38', '2023-07-26 02:58:38'),
(17, 2, 5, 5000, '2023-07-31 20:08:59', '2023-07-31 20:08:59'),
(18, 2, 10, 10000, '2023-07-31 20:09:06', '2023-07-31 20:09:06'),
(19, 2, 50, 50000, '2023-07-31 20:09:13', '2023-07-31 20:09:13'),
(20, 2, 100, 100000, '2023-07-31 20:09:24', '2023-07-31 20:09:24'),
(21, 9, 10, 1000, '2023-07-31 20:24:36', '2023-07-31 20:24:36'),
(22, 9, 200, 2000, '2023-07-31 20:24:44', '2023-07-31 20:24:44'),
(24, 9, 50, 5000, '2023-07-31 20:25:11', '2023-07-31 20:25:11'),
(25, 9, 100, 10000, '2023-07-31 20:25:21', '2023-07-31 20:25:21'),
(26, 13, 5, 5000, '2023-07-31 20:34:07', '2023-07-31 20:34:07'),
(27, 13, 10, 10000, '2023-07-31 20:34:15', '2023-07-31 20:34:15'),
(28, 13, 50, 50000, '2023-07-31 20:34:22', '2023-07-31 20:34:22'),
(30, 1, 5, 5000, '2023-07-31 20:35:00', '2023-07-31 20:35:00'),
(31, 1, 10, 10000, '2023-07-31 20:35:08', '2023-07-31 20:35:08'),
(32, 1, 50, 50000, '2023-07-31 20:35:23', '2023-07-31 20:35:23'),
(33, 1, 100, 100000, '2023-07-31 20:35:49', '2023-07-31 20:35:49'),
(35, 1, 20, 50, '2024-05-27 19:16:28', '2024-05-27 19:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `reward_lists`
--

CREATE TABLE `reward_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `u_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `p_details` varchar(255) NOT NULL,
  `coins_used` int(11) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` bigint(20) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=pending\r\n1=approved\r\n2=rejected\r\n3=completed',
  `package_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', NULL, NULL),
(2, 'Editor', 'editor', NULL, NULL),
(3, 'Author', 'author', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `refer_points` int(11) NOT NULL DEFAULT 0,
  `refer_bonus` int(11) NOT NULL DEFAULT 0,
  `daily_spin` int(11) DEFAULT NULL,
  `daily_scratch` int(11) DEFAULT NULL,
  `days` text DEFAULT NULL,
  `scratch_coins` varchar(255) DEFAULT NULL,
  `vpn` int(11) DEFAULT NULL,
  `vpn_ban` int(11) DEFAULT NULL,
  `one_device` int(11) DEFAULT NULL,
  `spin_ad` varchar(255) DEFAULT NULL,
  `scratch_ad` varchar(255) DEFAULT NULL,
  `back_ad` varchar(255) DEFAULT NULL,
  `game_ad` varchar(255) DEFAULT NULL,
  `x2_ad` varchar(255) DEFAULT NULL,
  `spin_ad_int` int(11) DEFAULT NULL,
  `scratch_ad_int` int(11) DEFAULT NULL,
  `game_ad_int` int(11) DEFAULT NULL,
  `back_ad_int` int(11) DEFAULT NULL,
  `devOption` int(11) DEFAULT NULL COMMENT '0=enabled\r\n1-disabled',
  `referMessage` text DEFAULT NULL,
  `refer_type` int(11) NOT NULL DEFAULT 0,
  `updated_at` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `package_name`, `refer_points`, `refer_bonus`, `daily_spin`, `daily_scratch`, `days`, `scratch_coins`, `vpn`, `vpn_ban`, `one_device`, `spin_ad`, `scratch_ad`, `back_ad`, `game_ad`, `x2_ad`, `spin_ad_int`, `scratch_ad_int`, `game_ad_int`, `back_ad_int`, `devOption`, `referMessage`, `refer_type`, `updated_at`) VALUES
(1, 'com.play.point', 100, 1000, 15, 15, '{\"day_1\":\"100\",\"day_2\":\"200\",\"day_3\":\"300\",\"day_4\":\"400\",\"day_5\":\"500\",\"day_6\":\"600\",\"day_7\":\"700\"}', '50-200', 1, 1, 1, 'admob', 'admob', 'admob', 'unity', 'admob', 1, 2, 5, 2, 0, '🎁 Earn Paypal Rewards, Paytm Cash, Freefire Diamonds and Lots of rewards. Invite your friend & family, Download From PlayStore and Get Huge Rewards 🏆 - {app link}', 0, '2024-10-13 18:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `trackers`
--

CREATE TABLE `trackers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `trans_from` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0=added\r\n1=deducted',
  `amount` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `uid` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `refer_id` varchar(255) NOT NULL,
  `t_ref` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `device` text DEFAULT NULL,
  `points` float NOT NULL DEFAULT 0,
  `diamond` int(11) NOT NULL DEFAULT 0,
  `played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `email` varchar(255) DEFAULT NULL,
  `xp` bigint(20) DEFAULT 500,
  `join_time` bigint(20) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `login_type` int(11) DEFAULT 0 COMMENT '0=google\r\n1=facebook\r\n2=email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`admin_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `coins` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `title`, `link`, `coins`, `time`, `updated_at`, `created_at`) VALUES
(2, 'Visit 2', 'https://codesellmarket.com', 100, 1, NULL, NULL),
(3, 'Visit 3', 'https://codesellmarket.com', 100, 1, NULL, NULL),
(9, 'website', 'https://kampalani.org', 500, 1, '2024-04-04 06:29:47', '2024-04-04 06:29:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `ad_settings`
--
ALTER TABLE `ad_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announces`
--
ALTER TABLE `announces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_tasks`
--
ALTER TABLE `daily_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaders`
--
ALTER TABLE `leaders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `refer_datas`
--
ALTER TABLE `refer_datas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refer_tasks`
--
ALTER TABLE `refer_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_amounts`
--
ALTER TABLE `reward_amounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_lists`
--
ALTER TABLE `reward_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trackers`
--
ALTER TABLE `trackers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`admin_id`,`permission_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`admin_id`,`role_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ad_settings`
--
ALTER TABLE `ad_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announces`
--
ALTER TABLE `announces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `daily_tasks`
--
ALTER TABLE `daily_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `leaders`
--
ALTER TABLE `leaders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `refer_datas`
--
ALTER TABLE `refer_datas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refer_tasks`
--
ALTER TABLE `refer_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reward_amounts`
--
ALTER TABLE `reward_amounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `reward_lists`
--
ALTER TABLE `reward_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trackers`
--
ALTER TABLE `trackers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
