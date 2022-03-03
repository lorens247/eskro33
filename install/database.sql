-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2022 at 05:19 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tsk_jetescrow`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'UP Up Up', 'admin@site.com', 'admin', NULL, '61780110310f01635254544.jpeg', '$2y$10$Ro3qfZZIFoyhs4ETl4lhAusJE3/xMwtnqVrsXPs4a4oeBcCUbMxE2', 'dOHfJMGbwN5IfWVjSEn1RboEhvapdL0PAUAfnWPeFxxY848jjVoWqZ4UI67o', NULL, '2021-11-03 12:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0,
  `click_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `escrow_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `buyer_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `seller_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>running, 0=>closed',
  `is_group` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>only 2 person, 1=> also admin will be added',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `milestone_id` int(10) NOT NULL DEFAULT 0,
  `method_code` int(10) UNSIGNED NOT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `method_currency` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amo` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `try` int(10) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT 0,
  `admin_feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `escrows`
--

CREATE TABLE `escrows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `buyer_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `creator_id` int(10) NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `paid_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge_payer` tinyint(1) NOT NULL DEFAULT 0,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `buyer_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `seller_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => not accepted\r\n1 => dispatched and completed\r\n2 => accepted and running\r\n8 => disputed\r\n9 => cancelled',
  `invitation_mail` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disputer_id` int(10) NOT NULL DEFAULT 0,
  `dispute_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `escrow_charges`
--

CREATE TABLE `escrow_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `minimum` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `maximum` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `escrow_types`
--

CREATE TABLE `escrow_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\r\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\r\n<div class=\"g-recaptcha\" data-sitekey=\"{{sitekey}}\" data-callback=\"verifyCaptcha\"></div>\r\n<div id=\"g-recaptcha-error\"></div>', '{\"sitekey\":{\"title\":\"Site Key\",\"value\":\"6LfoxjceAAAAADo300OSj4zJ7uUexGM_9_d0nDwb\"},\"secretkey\":{\"title\":\"Secret Key\",\"value\":\"6LfoxjceAAAAALaCqn_Tdv9FVVSVYbFKFZW56Lno\"}}', 'recaptcha.png', 0, NULL, '2019-10-18 23:16:05', '2022-02-08 08:08:36'),
(3, 'custom-captcha', 'Custom Captcha', 'Just Put Any Random String', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, NULL, '2019-10-18 23:16:05', '2022-02-08 08:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_values` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `template`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"escrow\",\"buy\",\"sell\",\"online buy sell\",\"payment\",\"online payment\"],\"description\":\"JetEscrow is a complete escrow management system. You may buy and sell anything with JetEscrow without worrying about chargebacks.\",\"social_title\":\"JetEscrow - Escrow Payment Platform\",\"social_description\":\"JetEscrow is a complete escrow management system. You may buy and sell anything with JetEscrow without worrying about chargebacks.\",\"image\":\"6203df271fa121644420903.png\"}', 'default', '2020-07-04 23:42:52', '2022-02-09 09:36:31'),
(41, 'cookie.data', '{\"short_desc\":\"This website or its third-party tools process personal data (e.g. browsing data or IP addresses) and use cookies or any other tracking technologies to improve your experience and may use this to show you advertisement on the various ad networks. \\r\\n\\r\\nBy using our website you consent to all cookies in accordance with our Cookie.\",\"description\":\"<h2 class=\\\"mb-5\\\">Cookies<\\/h2>\\r\\n<p class=\\\"my-3\\\">This website or its third-party tools process personal data (e.g. browsing data or IP addresses) and use cookies or any other tracking technologies to improve your experience and may use this to show you advertisement on the various ad networks. <\\/p>\\r\\n\\r\\n\\r\\n\\t<h2 class=\\\"mb-5\\\">What is a cookie?<\\/h2>\\r\\n\\r\\n\\t<p class=\\\"my-3\\\">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minima tenetur nobis sunt numquam quam? Nulla, laboriosam! Harum voluptatibus, eius hic tenetur porro id vero enim sint repudiandae, optio accusamus dolores doloribus voluptatum quae repellendus consequuntur cupiditate. Quos, dolore? Obcaecati quaerat pariatur ad facilis sequi totam explicabo a laborum illo laboriosam corrupti tempore, incidunt, eveniet minima expedita at placeat! Ipsa deserunt quaerat voluptatem repellendus veritatis earum vero, sint perspiciatis quisquam excepturi eligendi quasi repudiandae nam eaque architecto nostrum porro expedita. Voluptas deleniti maiores facilis maxime deserunt veniam soluta eligendi, suscipit ratione, ad voluptates iure blanditiis dolor atque eaque voluptate est! Quia excepturi, voluptatibus veritatis nam quos error temporibus distinctio. Fugit possimus a, consequuntur impedit veniam culpa esse voluptate facere facilis. Beatae ex ullam, recusandae esse dolores error aliquid ut! Recusandae iste rem magni sapiente blanditiis? Accusamus, blanditiis adipisci, sed recusandae ea distinctio sapiente, corrupti in accusantium ut vel eum enim consequuntur?<\\/p>\\r\\n\\r\\n\\r\\n\\r\\n\\t<h2 class=\\\"mb-5\\\">Managing cookies<\\/h2>\\r\\n\\r\\n\\t<p class=\\\"my-3\\\">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit nulla, consequatur obcaecati quos itaque qui nihil nostrum sit porro voluptatem, blanditiis dignissimos laboriosam, fugiat aspernatur! Neque quisquam voluptatem doloremque voluptates, atque maiores voluptatum veritatis culpa numquam excepturi, quas sed a nihil eos voluptas! Repellat error nulla non deserunt incidunt vel laboriosam, minima assumenda quae sed suscipit est quas, voluptas architecto accusantium similique harum doloribus quos itaque dolore? Voluptate quis nostrum obcaecati similique excepturi id nobis officia, nemo. Ipsa, cum, veniam.<\\/p>\\r\\n\\t<p class=\\\"my-3 lead\\\">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, provident? Sequi dolores id amet laudantium ipsam voluptate quibusdam ex, reiciendis, pariatur quisquam nesciunt? Nostrum, molestias. Beatae, veritatis molestias numquam? Deserunt enim perspiciatis vero fugiat harum illum hic optio exercitationem labore quod voluptatum laborum officia, corrupti iste quos, aliquid ut cum expedita esse nesciunt accusamus. Unde ab architecto alias necessitatibus iure illum harum recusandae, numquam, nesciunt perspiciatis, praesentium dignissimos eos repudiandae?<\\/p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\t<h2 class=\\\"mb-5\\\">How we use cookies<\\/h2>\\r\\n\\r\\n\\t<p class=\\\"my-3\\\">Lorem, ipsum dolor sit, amet consectetur adipisicing elit. Sint id impedit qui est laboriosam vitae nemo tempora, quasi quod deleniti. Vel a maiores vero assumenda cum saepe at quo? Excepturi harum autem animi illo, nesciunt laboriosam amet reiciendis quidem similique aliquam molestiae distinctio nostrum dignissimos vero maiores accusantium officia quam sunt tempore a ut molestias eveniet enim fuga. Nulla, odio?<\\/p>\\r\\n\\r\\n\\t<p class=\\\"my-3 lead\\\">Lorem, ipsum dolor sit, amet consectetur adipisicing elit. Sint id<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>adipisicing elit. Explicabo perferendis quo voluptatibus officia, neque enim?<\\/li>\\r\\n\\t<li>Lorem  elit. Ea nobis magnam error dolore qui velit!<\\/li>\\r\\n\\t<li>Lorem  consectetur adipisicing elit. Provident accusantium recusandae, eius in iusto reprehenderit.<\\/li>\\r\\n\\t<li>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae temporibus hic, dolorum commodi officiis repellat.<\\/li>\\r\\n\\t<li>Lorem ipsum dolor Officia a perspiciatis porro cum laboriosam, saepe.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n\\t<p class=\\\"my-3 lead\\\">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Iure, officia amet, deleniti rem suscipit dicta quae obcaecati natus magni! Molestias animi ducimus voluptas ea, veritatis nihil nesciunt vel in officia dolorum ipsa quae necessitatibus officiis praesentium commodi incidunt velit quaerat hic. Non consectetur autem reprehenderit rerum id, incidunt, ab minus, deleniti numquam ipsa fugiat amet in fuga, ut mollitia odit corporis. Nulla perferendis eos aliquam in unde sed possimus repudiandae iste non, magni reiciendis voluptatibus, labore qui exercitationem voluptatum dolor, eius deleniti odio tenetur blanditiis voluptates. Odio repellat minus vero corrupti culpa. Ex optio blanditiis temporibus? Voluptas repellendus soluta adipisci nobis pariatur. Atque doloremque molestiae rerum perspiciatis, soluta quam rem aliquam! Modi suscipit sed excepturi in aliquam, labore dolore vero.<\\/p>\",\"status\":1}', 'default', '2020-07-04 23:42:52', '2021-11-01 11:21:51'),
(44, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Buy or Sell Something Online? Use JetEscrow\",\"sub_heading\":\"You may buy and sell anything with JetEscrow without worrying about chargebacks.\",\"form_heading\":\"Buy or Sell\",\"form_title\":\"Domains and websites securely\",\"button_name\":\"Open an Account\",\"button_url\":\"user\\/register\",\"image\":\"61fe6fdc151791644064732.jpg\"}', 'default', '2022-01-02 10:30:56', '2022-02-09 09:28:08'),
(45, 'how_it_work.content', '{\"heading\":\"Easy And Fast Way To Escrow\"}', 'default', '2022-01-02 10:43:01', '2022-01-02 10:43:01'),
(46, 'how_it_work.element', '{\"title\":\"Agree To Terms\",\"icon\":\"<i class=\\\"far fa-check-circle\\\"><\\/i>\"}', 'default', '2022-01-02 10:44:58', '2022-01-02 13:47:47'),
(47, 'how_it_work.element', '{\"title\":\"Submit payment\",\"icon\":\"<i class=\\\"lab la-cc-paypal\\\"><\\/i>\"}', 'default', '2022-01-02 10:45:08', '2022-02-09 06:11:27'),
(48, 'how_it_work.element', '{\"title\":\"Approve Services\",\"icon\":\"<i class=\\\"las la-server\\\"><\\/i>\"}', 'default', '2022-01-02 10:45:17', '2022-02-09 06:11:36'),
(49, 'how_it_work.element', '{\"title\":\"Release payment\",\"icon\":\"<i class=\\\"lar la-money-bill-alt\\\"><\\/i>\"}', 'default', '2022-01-02 10:45:26', '2022-02-09 06:11:41'),
(50, 'overview.content', '{\"has_image\":\"1\",\"heading\":\"Secure Payments In One Line Of Code\",\"content\":\"Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam itaque repellat ratione. Nisi delectus aspernatur quidem adipisci illo consectetur aliquid reiciendis sunt optio, dicta, architecto dolores voluptatum voluptate. Facilis neque optio necessitatibus dolore minima tempore laborum quibusdam soluta cupiditate provident\",\"button_name\":\"Contact Us\",\"button_url\":\"contact\",\"image\":\"61d5f7ee6b2121641412590.png\"}', 'default', '2022-01-02 10:49:35', '2022-01-05 13:56:30'),
(51, 'service.content', '{\"heading\":\"Buy And Sell Services\"}', 'default', '2022-01-02 10:54:42', '2022-01-02 10:54:42'),
(52, 'service.element', '{\"title\":\"Domain Names\",\"icon\":\"<i class=\\\"fas fa-globe\\\"><\\/i>\",\"content\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque et qui, nam voluptate expedita exercita Architecto voluptate expedita exercita Architecto facere eaque impedit mollitia.\"}', 'default', '2022-01-02 10:55:15', '2022-01-02 10:55:15'),
(53, 'service.element', '{\"title\":\"Motor Vehicles\",\"icon\":\"<i class=\\\"las la-truck\\\"><\\/i>\",\"content\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque et qui, nam voluptate expedita exercita Architecto voluptate expedita exercita Architecto facere eaque impedit mollitia.\"}', 'default', '2022-01-02 10:55:34', '2022-01-02 10:55:34'),
(54, 'service.element', '{\"title\":\"Electronics\",\"icon\":\"<i class=\\\"las la-camera\\\"><\\/i>\",\"content\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque et qui, nam voluptate expedita exercita Architecto voluptate expedita exercita Architecto facere eaque impedit mollitia.\"}', 'default', '2022-01-02 10:55:47', '2022-01-02 10:55:47'),
(55, 'service.element', '{\"title\":\"General Merchandise\",\"icon\":\"<i class=\\\"las la-cart-plus\\\"><\\/i>\",\"content\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque et qui, nam voluptate expedita exercita Architecto voluptate expedita exercita Architecto facere eaque impedit mollitia.\"}', 'default', '2022-01-02 10:55:58', '2022-01-02 10:55:58'),
(56, 'service.element', '{\"title\":\"Milestone Transactions\",\"icon\":\"<i class=\\\"fas fa-chart-line\\\"><\\/i>\",\"content\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque et qui, nam voluptate expedita exercita Architecto voluptate expedita exercita Architecto facere eaque impedit mollitia.\"}', 'default', '2022-01-02 10:56:14', '2022-01-02 10:56:14'),
(57, 'service.element', '{\"title\":\"Jewelry and Fashion\",\"icon\":\"<i class=\\\"las la-gem\\\"><\\/i>\",\"content\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque et qui, nam voluptate expedita exercita Architecto voluptate expedita exercita Architecto facere eaque impedit mollitia.\"}', 'default', '2022-01-02 10:56:29', '2022-01-02 10:56:29'),
(58, 'counter.content', '{\"has_image\":\"1\",\"heading\":\"Escrolab Real Time Statistics\",\"image\":\"61d1dabca3f151641142972.jpg\"}', 'default', '2022-01-02 11:02:52', '2022-01-02 11:02:52'),
(59, 'counter.element', '{\"title\":\"Satisfied Users\",\"icon\":\"<i class=\\\"las la-users\\\"><\\/i>\",\"number\":\"24\"}', 'default', '2022-01-02 11:03:13', '2022-01-02 11:03:13'),
(60, 'counter.element', '{\"title\":\"Latest Blogs\",\"icon\":\"<i class=\\\"las la-rss-square\\\"><\\/i>\",\"number\":\"13\"}', 'default', '2022-01-02 11:03:37', '2022-01-02 11:03:37'),
(61, 'counter.element', '{\"title\":\"Total Subscribers\",\"icon\":\"<i class=\\\"las la-calculator\\\"><\\/i>\",\"number\":\"15\"}', 'default', '2022-01-02 11:03:53', '2022-01-02 11:03:53'),
(62, 'counter.element', '{\"title\":\"Running Days\",\"icon\":\"<i class=\\\"far fa-calendar-alt\\\"><\\/i>\",\"number\":\"47\"}', 'default', '2022-01-02 11:04:45', '2022-01-02 11:04:45'),
(63, 'testimonial.content', '{\"heading\":\"What People Say About Us\"}', 'default', '2022-01-02 11:11:54', '2022-01-02 11:11:54'),
(64, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Julian Poole\",\"designation\":\"Co-founder\",\"comment\":\"Odio expedita neque illo deserunt quasi consequatur tenetur fugiat deleniti nisi ad dolores accusamus cumque sapiente sequi hic nam dolorum culpa laborum excepturi libero minima. Voluptas quas expedita quae quidem itaque facere non commodi ratione ea.\",\"image\":\"61d1dd0baa5921641143563.jpg\"}', 'default', '2022-01-02 11:12:43', '2022-01-02 11:13:03'),
(65, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Giacomo Norman\",\"designation\":\"Co-founder\",\"comment\":\"Odio expedita neque illo deserunt quasi consequatur tenetur fugiat deleniti nisi ad dolores accusamus cumque sapiente sequi hic nam dolorum culpa laborum excepturi libero minima. Voluptas quas expedita quae quidem itaque facere non commodi ratione ea.\",\"image\":\"61d1dd148fc361641143572.jpg\"}', 'default', '2022-01-02 11:12:52', '2022-01-02 11:13:19'),
(66, 'faq.content', '{\"has_image\":\"1\",\"heading\":\"Most Trusted Service In The World\",\"image\":\"61d1df1ac0be71641144090.png\"}', 'default', '2022-01-02 11:19:08', '2022-01-02 11:21:30'),
(67, 'faq.element', '{\"question\":\"Why We Better For Your Hyip Investment?\",\"answer\":\"Maecenas tempus tellus eget condimentu oncussam mperngsu libero sit amet adipiscing ue sed ipsum. Nam quam nunc, blandit veluctus pulvinar. Maecenas tempus tellus eget condimentu oncussam mperngsu libero sit amet adipiscing ue sed ipsum. Nam quam nunc, blandit veluctus pulvinar.\"}', 'default', '2022-01-02 11:19:37', '2022-01-02 11:19:37'),
(68, 'faq.element', '{\"question\":\"Why We Better For Your Hyip Investment?\",\"answer\":\"Maecenas tempus tellus eget condimentu oncussam mperngsu libero sit amet adipiscing ue sed ipsum. Nam quam nunc, blandit veluctus pulvinar. Maecenas tempus tellus eget condimentu oncussam mperngsu libero sit amet adipiscing ue sed ipsum. Nam quam nunc, blandit veluctus pulvinar.\"}', 'default', '2022-01-02 11:19:45', '2022-01-02 11:19:45'),
(69, 'faq.element', '{\"question\":\"Why We Better For Your Hyip Investment?\",\"answer\":\"Maecenas tempus tellus eget condimentu oncussam mperngsu libero sit amet adipiscing ue sed ipsum. Nam quam nunc, blandit veluctus pulvinar. Maecenas tempus tellus eget condimentu oncussam mperngsu libero sit amet adipiscing ue sed ipsum. Nam quam nunc, blandit veluctus pulvinar.\"}', 'default', '2022-01-02 11:19:54', '2022-01-02 11:19:54'),
(70, 'why_choose_us.content', '{\"has_image\":\"1\",\"heading\":\"Why Choose JetEscrow?\",\"image\":\"61d1df45c58081641144133.png\"}', 'default', '2022-01-02 11:22:13', '2022-02-09 06:36:28'),
(71, 'why_choose_us.element', '{\"title\":\"Certified\",\"icon\":\"<i class=\\\"las la-certificate\\\"><\\/i>\",\"content\":\"Illum voluptas quo doloremque praesentium obcaecati id. Illum voluptas quo doloremque praesentium obcaecati id\"}', 'default', '2022-01-02 11:22:37', '2022-01-02 11:29:25'),
(73, 'why_choose_us.element', '{\"title\":\"Sequrity\",\"icon\":\"<i class=\\\"las la-shield-alt\\\"><\\/i>\",\"content\":\"Illum voluptas quo doloremque praesentium obcaecati id.\"}', 'default', '2022-01-02 11:23:01', '2022-01-02 11:29:31'),
(74, 'why_choose_us.element', '{\"title\":\"Privacy\",\"icon\":\"<i class=\\\"las la-lock\\\"><\\/i>\",\"content\":\"Illum voluptas quo doloremque praesentium obcaecati id. Illum voluptas quo doloremque praesentium obcaecati id\"}', 'default', '2022-01-02 11:23:41', '2022-01-02 11:29:36'),
(75, 'blog.content', '{\"heading\":\"Our Latest Posts\"}', 'default', '2022-01-02 11:41:25', '2022-01-02 11:41:25'),
(76, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, dicta.\",\"description\":\"<p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e225068861644421669.jpg\"}', 'default', '2022-01-02 11:41:58', '2022-02-09 09:47:49'),
(77, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, dicta.\",\"description\":\"<p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e242d836e1644421698.jpg\"}', 'default', '2022-01-02 11:42:22', '2022-02-09 09:48:19'),
(78, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Hyip investment for more profit by bitcoin\",\"description\":\"<p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e256a09991644421718.jpg\"}', 'default', '2022-01-02 11:42:33', '2022-02-09 09:48:39'),
(79, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Hyip investment for more profit by bitcoin\",\"description\":\"<p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e26e4c6481644421742.jpg\"}', 'default', '2022-01-02 11:42:45', '2022-02-09 09:49:03'),
(81, 'contact.element', '{\"title\":\"Contact Email\",\"icon\":\"<i class=\\\"far fa-envelope-open\\\"><\\/i>\",\"content\":\"admin@test.com\"}', 'default', '2022-01-02 12:03:08', '2022-01-02 12:03:08'),
(82, 'contact.element', '{\"title\":\"Contact Number\",\"icon\":\"<i class=\\\"las la-phone\\\"><\\/i>\",\"content\":\"+88 0123 8888 0000\"}', 'default', '2022-01-02 12:03:21', '2022-01-02 12:03:21'),
(83, 'contact.element', '{\"title\":\"Office Location\",\"icon\":\"<i class=\\\"far fa-map\\\"><\\/i>\",\"content\":\"25 Loveridge Road, London\"}', 'default', '2022-01-02 12:03:48', '2022-01-02 12:03:48'),
(84, 'brand.element', '{\"has_image\":\"1\",\"image\":\"61d1fec1365da1641152193.png\"}', 'default', '2022-01-02 12:09:24', '2022-01-02 13:36:33'),
(85, 'brand.element', '{\"has_image\":\"1\",\"image\":\"61d1fef8a411d1641152248.png\"}', 'default', '2022-01-02 12:09:29', '2022-01-02 13:37:28'),
(86, 'brand.element', '{\"has_image\":\"1\",\"image\":\"61d1ff20894d51641152288.png\"}', 'default', '2022-01-02 12:09:34', '2022-01-02 13:38:08'),
(87, 'brand.element', '{\"has_image\":\"1\",\"image\":\"61d1ff47c17301641152327.png\"}', 'default', '2022-01-02 12:09:38', '2022-01-02 13:38:47'),
(88, 'brand.element', '{\"has_image\":\"1\",\"image\":\"61d1ff756a78f1641152373.png\"}', 'default', '2022-01-02 12:09:42', '2022-01-02 13:39:33'),
(89, 'brand.element', '{\"has_image\":\"1\",\"image\":\"61d1ff9504fb11641152405.png\"}', 'default', '2022-01-02 12:09:46', '2022-01-02 13:40:05'),
(90, 'brand.element', '{\"has_image\":\"1\",\"image\":\"61d1ffc75b4111641152455.png\"}', 'default', '2022-01-02 12:09:52', '2022-01-02 13:40:55'),
(91, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"6203d276d8a401644417654.jpg\"}', 'default', '2022-01-02 14:17:40', '2022-02-09 08:40:55'),
(92, 'contact.content', '{\"map_iframe\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d3070.1899657893728!2d90.42380431666383!3d23.779746865573756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7499f257eab%3A0xe6b4b9eacea70f4a!2sManama+Tower!5e0!3m2!1sen!2sbd!4v1561542597668!5m2!1sen!2sbd\"}', 'default', '2022-01-02 14:40:50', '2022-01-02 14:41:08'),
(93, 'policy_pages.element', '{\"title\":\"Terms and Condition\",\"details\":\"<p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\"}', 'default', '2022-01-02 14:46:57', '2022-01-02 14:46:57'),
(94, 'policy_pages.element', '{\"title\":\"Privacy and Policy\",\"details\":\"<p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;font-size:16px;color:rgb(83,80,75);\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\"}', 'default', '2022-01-02 14:47:08', '2022-01-02 14:47:08'),
(95, 'login.content', '{\"has_image\":\"1\",\"image\":\"61fe74f3a37f71644066035.jpg\"}', 'default', '2022-01-02 15:26:55', '2022-02-05 07:00:35'),
(96, 'register.content', '{\"has_image\":\"1\",\"image\":\"61fe7944b412c1644067140.jpg\"}', 'default', '2022-01-02 15:45:19', '2022-02-05 07:19:01'),
(97, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/facebook.com\\/\"}', 'default', '2022-01-03 00:21:58', '2022-01-03 00:21:58'),
(98, 'social_icon.element', '{\"title\":\"Twitter\",\"social_icon\":\"<i class=\\\"lab la-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/twitter.com\\/\"}', 'default', '2022-01-03 00:22:09', '2022-01-03 00:22:10'),
(99, 'social_icon.element', '{\"title\":\"Instagram\",\"social_icon\":\"<i class=\\\"lab la-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', 'default', '2022-01-03 00:22:51', '2022-01-03 00:22:51'),
(100, 'social_icon.element', '{\"title\":\"Linkedin\",\"social_icon\":\"<i class=\\\"lab la-linkedin-in\\\"><\\/i>\",\"url\":\"https:\\/\\/linkedin.com\\/\"}', 'default', '2022-01-03 00:23:11', '2022-01-03 00:23:11');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `template`, `created_at`, `updated_at`) VALUES
(101, 'footer.content', '{\"title\":\"The most trusted, licensed online escrow service in the world\",\"button_name\":\"Get Started Now\",\"button_url\":\"user\\/register\",\"content\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Ae veritatis accusantium repellat dicta fugiat amet, voluptas placeat sunt maxime magni temporibus, libero soluta, mollitia nam repellendus. Hajuk year.\"}', 'default', '2022-02-08 05:28:21', '2022-02-08 05:28:21'),
(102, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, dicta.\",\"description\":\"<p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e2d18d15d1644421841.jpg\"}', 'default', '2022-02-09 09:50:41', '2022-02-09 09:50:41'),
(103, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, dicta.\",\"description\":\"<p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e4ad346af1644422317.jpg\"}', 'default', '2022-02-09 09:58:37', '2022-02-09 09:58:37'),
(104, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, dicta.\",\"description\":\"<p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e50e349831644422414.jpg\"}', 'default', '2022-02-09 10:00:14', '2022-02-09 10:00:14'),
(105, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, dicta.\",\"description\":\"<p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><blockquote style=\\\"margin-bottom:1.3em;background-color:rgba(30,214,165,0.11);padding:20px;color:rgb(83,80,75);font-style:italic;font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"quote-area d-flex flex-wrap\\\"><div class=\\\"quote-icon\\\" style=\\\"font-size:120px;\\\"><span class=\\\"las la-quote-left\\\" style=\\\"font-size:14px;\\\"><\\/span><\\/div><div class=\\\"quote-content-area\\\"><p class=\\\"quote-content\\\" style=\\\"margin-bottom:15px;line-height:1.8em;\\\">Aliquet ac fringilla luctus tellus.ndrerit posuere penatibus elit placerat, ut ut turpis aenean class, labore elementum at diam libero ipsum, aenean sed dapibus, in sed fusce. Alicitudin tincidunt in, erat nonummy neque scelerisque, amet rutrum magnanullam. Vra eos elit<\\/p><span style=\\\"font-size:14px;\\\">- Danial Pink<\\/span><\\/div><\\/div><\\/blockquote><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Nullam id dolor id nibh ultricies vehicula ut id elit. Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.<\\/p><p style=\\\"margin-bottom:15px;color:rgb(83,80,75);font-size:16px;line-height:1.8em;font-family:\'Josefin Sans\', sans-serif;\\\">Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.<\\/p>\",\"image\":\"6203e526ae8121644422438.jpg\"}', 'default', '2022-02-09 10:00:38', '2022-02-09 10:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(10) DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_form` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `input_form`, `created_at`, `updated_at`) VALUES
(1, 101, 'Paypal', 'Paypal', '5f6f1bd8678601601117144.jpg', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:04:38'),
(2, 102, 'Perfect Money', 'PerfectMoney', '5f6f1d2a742211601117482.jpg', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:35:33'),
(3, 103, 'Stripe Hosted', 'Stripe', '5f6f1d4bc69e71601117515.jpg', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_aat3tzBCCXXBkS4sxY3M8A1B\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_AU3G7doZ1sbdpJLj0NaozPBu\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2022-01-03 07:19:23'),
(4, 104, 'Skrill', 'Skrill', '5f6f1d41257181601117505.jpg', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:30:16'),
(5, 105, 'PayTM', 'Paytm', '5f6f1d1d3ec731601117469.jpg', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 03:00:44'),
(6, 106, 'Payeer', 'Payeer', '5f6f1bc61518b1601117126.jpg', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\",\"link\":\"payeer\"}}', NULL, NULL, '2019-09-14 13:14:22', '2021-10-26 10:31:21'),
(7, 107, 'PayStack', 'Paystack', '5f7096563dfb71601214038.jpg', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\",\"link\":\"paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\",\"link\":\"paystack\"}}', NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:49:51'),
(8, 108, 'VoguePay', 'Voguepay', '5f6f1d5951a111601117529.jpg', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:22:38'),
(9, 109, 'Flutterwave', 'Flutterwave', '5f6f1b9e4bb961601117086.jpg', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-06-05 11:37:45'),
(10, 110, 'RazorPay', 'Razorpay', '5f6f1d3672dd61601117494.jpg', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:51:32'),
(11, 111, 'Stripe Storefront', 'StripeJs', '5f7096a31ed9a1601214115.jpg', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-10-26 06:10:19'),
(12, 112, 'Instamojo', 'Instamojo', '5f6f1babbdbb31601117099.jpg', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:56:20'),
(13, 501, 'Blockchain', 'Blockchain', '5f6f1b2b20c6f1601116971.jpg', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-10-26 06:08:33'),
(14, 502, 'Block.io', 'Blockio', '5f6f19432bedf1601116483.jpg', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":false,\"value\":\"1658-8015-2e5e-9afb\"},\"api_pin\":{\"title\":\"API PIN\",\"global\":true,\"value\":\"75757575\"}}', '{\"BTC\":\"BTC\",\"LTC\":\"LTC\"}', 1, '{\"cron\":{\"title\": \"Cron URL\",\"value\":\"ipn.Blockio\",\"link\":\"blockio\"}}', NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:31:09'),
(15, 503, 'CoinPayments', 'Coinpayments', '5f6f1b6c02ecd1601117036.jpg', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:14'),
(16, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', '5f6f1b94e9b2b1601117076.jpg', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:44'),
(17, 505, 'Coingate', 'Coingate', '5f6f1b5fe18ee1601117023.jpg', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:49:30'),
(18, 506, 'Coinbase Commerce', 'CoinbaseCommerce', '5f6f1b4c774af1601117004.jpg', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\",\"link\":\"coinbase-commerce\"}}', NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:02:47'),
(24, 113, 'Paypal Express', 'PaypalSdk', '5f6f1bec255c61601117164.jpg', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-05-20 23:01:08'),
(25, 114, 'Stripe Checkout', 'StripeV3', '5f709684736321601214084.jpg', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\",\"link\":\"stripe-v3\"}}', NULL, NULL, '2019-09-14 13:14:22', '2021-10-26 06:10:35'),
(27, 115, 'Mollie', 'Mollie', '5f6f1bb765ab11601117111.jpg', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"my@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-10-26 06:08:47'),
(30, 116, 'Cashmaal', 'Cashmaal', '60d1a0b7c98311624350903.png', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\",\"link\":\"cashmaal\"}}', NULL, NULL, NULL, '2021-06-22 08:05:04'),
(36, 119, 'Mercado Pago', 'MercadoPago', '60f2ad85a82951626516869.png', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"3Vee5S2F\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, NULL, '2021-07-17 09:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int(10) DEFAULT NULL,
  `gateway_alias` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_parameter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sitename` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram_body` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email configuration',
  `sms_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram_config` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `tn` tinyint(1) NOT NULL DEFAULT 0,
  `force_ssl` tinyint(1) NOT NULL DEFAULT 0,
  `secure_password` tinyint(1) NOT NULL DEFAULT 0,
  `agree` tinyint(1) NOT NULL DEFAULT 0,
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_version` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_cap` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `sitename`, `cur_text`, `cur_sym`, `email_from`, `email_template`, `sms_from`, `sms_body`, `telegram_body`, `base_color`, `secondary_color`, `mail_config`, `sms_config`, `telegram_config`, `ev`, `en`, `sv`, `sn`, `tn`, `force_ssl`, `secure_password`, `agree`, `registration`, `active_template`, `sys_version`, `charge_cap`, `fixed_charge`, `percent_charge`, `created_at`, `updated_at`) VALUES
(1, 'JetEscrow', 'USD', '$', 'support@thesoftking.com', '<br style=\"font-family: Lato, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif;\"><br style=\"font-family: Lato, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif;\"><div class=\"contents\" style=\"font-family: Lato, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; max-width: 600px; margin: 0px auto; border: 2px solid rgb(0, 0, 54);\"><div class=\"header\" style=\"background-color: rgb(0, 0, 54); padding: 15px; text-align: center;\"><div class=\"logo\" style=\"width: 260px; margin: 0px auto;\"><img src=\"https://i.imgur.com/4NN55uD.png\" alt=\"THESOFTKING\" style=\"width: 260px;\">&nbsp;</div></div><div class=\"mailtext\" style=\"padding: 30px 15px; background-color: rgb(240, 248, 255); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; line-height: 26px;\">Hi {{fullname}} ({{username}}),&nbsp;<br><br>{{message}}&nbsp;<br><br><br></div><div class=\"footer\" style=\"background-color: rgb(0, 0, 54); padding: 15px; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.2);\"><span style=\"font-weight: bolder; color: rgb(255, 255, 255);\">© THESOFTKING Limited. All Rights Reserved.</span><p style=\"color: rgb(221, 221, 221);\">This is a system-generated email and only for demonstration purposes.</p><p style=\"color: rgb(221, 221, 221);\">Please change this from admin panel.<br></p><div><br></div></div></div><table class=\"layout layout--no-gutter\" style=\"border-spacing: 0px; color: rgb(52, 73, 94); table-layout: fixed; margin-left: auto; margin-right: auto; overflow-wrap: break-word; word-break: break-word;\" align=\"center\"><tbody><tr></tr></tbody></table>', 'SMS From TSK Admin', 'hi {{fullname}} ({{username}}), \r\n\r\n{{message}}', 'hi {{fullname}} ({{username}}),\r\n\r\n {{message}}', '10D078', '11241A', '{\"name\":\"php\"}', '{\"name\":\"custom\",\"clickatell\":{\"api_key\":\"----------------------------\"},\"infobip\":{\"username\":\"--------------\",\"password\":\"----------------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"AC67afdacf2dacff5f163134883db92c24ggg\",\"auth_token\":\"77726b242830fb28f52fb08c648dd7a6gggg\",\"from\":\"+17739011523ggg\"},\"text_magic\":{\"username\":\"-----------------------as\",\"apiv2_key\":\"-------------------------------asd\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/kbzaman.devs\\/admin\\/laraking-1.0\\/admin\\/notification\\/sms\\/setting\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api\"]},\"body\":{\"name\":[\"sms_from\",\"message\",\"toSSID\"],\"value\":[\"THESOFTKING\",\"{{message}}\",\"{{number}}\"]}}}', '{\"name\":\"tsk_super_bot\",\"bot_token\":\"2054446169:AAHvs9xLlEL9-LXNrcKkcDIFuLB91mDz33E\"}', 0, 1, 0, 1, 1, 0, 0, 1, 1, 'default', '{\"type\":\"success\",\"message\":null,\"body\":{\"notice\":[],\"version\":{\"number\":\"1.0\",\"url\":\"https:\\/\\/thesoftking.com\\/user\\/download\",\"details\":null}},\"execute\":null}', '100.00000000', '10.00000000', '2.00', NULL, '2022-02-09 09:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '2020-07-06 03:47:55', '2021-10-27 07:10:23'),
(5, 'Hindi', 'hn', 0, '2020-12-29 02:20:07', '2020-12-29 02:20:16'),
(9, 'Bangla', 'bn', 0, '2021-03-14 04:37:41', '2021-05-12 05:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` int(11) NOT NULL DEFAULT 0,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `conversation_id` int(10) NOT NULL DEFAULT 0,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `escrow_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `payment_status` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `sender` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcodes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 1,
  `sms_status` tinyint(1) NOT NULL DEFAULT 1,
  `telegram_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `telegram_body`, `shortcodes`, `email_status`, `sms_status`, `telegram_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account Balance Has Been Credited', '<div>This is to notify you that <b>{{amount}} {{currency}}</b> has been added to your account and your current balance is <b>{{post_balance}} {{currency}}.</b></div>\r\n\r\n<div><br></div>\r\n\r\n<div>Remark: {{remark}}</div>\r\n<div>Transaction Number: #{{trx}}</div>', 'Your account is credited by {{amount}} {{currency}} and your current balance is {{post_balance}}{{currency}} \r\n\r\nTransaction: #{{trx}}', 'This is to notify you that {{amount}} {{currency}} has been added to your account and your current balance is {{post_balance}} {{currency}}.\r\n\r\nRemark: {{remark}}\r\nTransaction Number: #{{trx}}', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"currency\":\"Base currency of the system\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account Balance Has Been Debited', '<div>This is to notify you that <b>{{amount}} {{currency}}</b> has been Subtracted from your account and your current balance is <b>{{post_balance}} {{currency}}.</b></div>\r\n\r\n<div><br></div>\r\n\r\n<div>Remark: {{remark}}</div>\r\n<div>Transaction Number: #{{trx}}</div>', 'Your account is debited by {{amount}} {{currency}} and your current balance is {{post_balance}}{{currency}} \r\n\r\nTransaction: #{{trx}}', 'This is to notify you that {{amount}} {{currency}} has been Subtracted from your account and your current balance is {{post_balance}} {{currency}}.\r\n\r\nRemark: {{remark}}\r\nTransaction Number: #{{trx}}', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"currency\":\"Base currency of the system\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', '[Payment Confirmation] Deposit Completed Successfully', '<div>This is a payment receipt for your deposit of <b>{{amount}} {{currency}}</b> via <i>{{method_name}}</i>.</div>\r\n<div><br></div>\r\n<div>The payment has been completed Successfully and your current balance is <b>{{post_balance}} {{currency}}</b></div>\r\n\r\n<div><br></div>\r\n\r\n<div>Amount: {{amount}} {{currency}}</div>\r\n<div>Charge: {{charge}} {{currency}}</div>\r\n<div>Conversion Rate: 1 {{currency}} = {{rate}} {{method_currency}}</div>\r\n<div>Payable: {{method_amount}} {{method_currency}}</div>\r\n<div>Paid via: {{method_name}}</div>\r\n<div>Transaction Number: #{{trx}}</div>\r\n\r\n<div><br></div>\r\n<div>Note: This email will serve as an official receipt for this payment.</div>', '{{amount}} {{currrency}} Deposit successfully by {{gateway_name}}\r\nTransaction Number: #{{trx}}\r\nyour current balance is {{post_balance}} {{currency}}', 'This is a payment receipt for your deposit of {{amount}} {{currency}} via {{method_name}}.\r\n\r\nThe payment has been completed Successfully and your current balance is {{post_balance}} {{currency}}\r\n\r\nAmount: {{amount}} {{currency}}\r\nCharge: {{charge}} {{currency}}\r\nConversion Rate: 1 {{currency}} = {{rate}} {{method_currency}}\r\nPayable: {{method_amount}} {{method_currency}}\r\nPaid via: {{method_name}}\r\nTransaction Number: #{{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"currency\":\"Base currency of the system\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', '[Payment Confirmation] Deposit Processed Successfully', '<div>This is a payment receipt for your deposit of <b>{{amount}} {{currency}}</b> via <i>{{method_name}}</i>.</div>\r\n<div><br></div>\r\n<div>The payment has been completed Successfully and your current balance is <b>{{post_balance}} {{currency}}</b></div>\r\n\r\n<div><br></div>\r\n\r\n<div>Amount: {{amount}} {{currency}}</div>\r\n<div>Charge: {{charge}} {{currency}}</div>\r\n<div>Conversion Rate: 1 {{currency}} = {{rate}} {{method_currency}}</div>\r\n<div>Payable: {{method_amount}} {{method_currency}}</div>\r\n<div>Paid via: {{method_name}}</div>\r\n<div>Transaction Number: #{{trx}}</div>\r\n\r\n<div><br></div>\r\n<div>Note: This email will serve as an official receipt for this payment.</div>', '{{amount}} {{currrency}} Deposit successfully by {{gateway_name}}\r\nTransaction Number: #{{trx}}\r\nyour current balance is {{post_balance}} {{currency}}', 'This is a payment receipt for your deposit of {{amount}} {{currency}} via {{method_name}}.\r\n\r\nThe payment has been completed Successfully and your current balance is {{post_balance}} {{currency}}\r\n\r\nAmount: {{amount}} {{currency}}\r\nCharge: {{charge}} {{currency}}\r\nConversion Rate: 1 {{currency}} = {{rate}} {{method_currency}}\r\nPayable: {{method_amount}} {{method_currency}}\r\nPaid via: {{method_name}}\r\nTransaction Number: #{{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"currency\":\"Base currency of the system\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Deposit Request Rejected', '<div>This is to notify you that your deposit request of <b>{{amount}} {{currency}}</b> via <i>{{method_name}}</i> (Transaction Number: #{{trx}}) has been rejected.</div>\r\n\r\n<div><br></div><div><br></div>\r\n<div>Reason of rejection: {{rejection_message}}</div>', 'your deposit request of {{amount}} {{currency}} via {{method_name}} (Transaction Number: #{{trx}}) has been rejected.', 'This is to notify you that your deposit request of {{amount}} {{currency}} via {{method_name}} (Transaction Number: #{{trx}}) has been rejected.\r\n\r\nReason of rejection: {{rejection_message}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"currency\":\"Base currency of the system\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', '<div>This is to notify you that your deposit request of <b>{{amount}} {{currency}}</b> via <i>{{method_name}}</i> has been submitted successfully</div>\r\n<div><br></div>\r\n\r\n<div>Amount: {{amount}} {{currency}}</div>\r\n<div>Charge: {{charge}} {{currency}}</div>\r\n<div>Conversion Rate: 1 {{currency}} = {{rate}} {{method_currency}}</div>\r\n<div>Payable: {{method_amount}} {{method_currency}}</div>\r\n<div>Paid via: {{method_name}}</div>\r\n<div>Transaction Number: #{{trx}}</div>\r\n<div><br></div>\r\n<div><br></div>\r\n\r\n\r\n<div>Note: This is not the final confirmation for the deposit. Our team will cross-check your information and you will receive another confirmation once we review and take an action.</div>', 'Deposit request of {{amount}} {{currrency}} by {{method_name}} submitted successfully.\r\nTransaction Number: #{{trx}}', 'This is to notify you that your deposit request of {{amount}} {{currency}} via {{method_name}} has been submitted successfully\r\n\r\n\r\nAmount: {{amount}} {{currency}}\r\nCharge: {{charge}} {{currency}}\r\nConversion Rate: 1 {{currency}} = {{rate}} {{method_currency}}\r\nPayable: {{method_amount}} {{method_currency}}\r\nPaid via: {{method_name}}\r\nTransaction Number: #{{trx}}\r\n\r\n\r\nThis is not the final confirmation for the deposit. Our team will cross-check your information and you will receive another confirmation once we review and take an action.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"currency\":\"Base currency of the system\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset Verification', '<div>Recently a request was submitted to reset your password for our system. If you did not request this, please ignore this email. It will expire and become useless automatically.</div>\r\n	<br><br>\r\n	<div>To reset your password, please use the code below:</div>\r\n	<div><br></div>\r\n	<div><font color=\"#2ecc71\"><b><font size=\"4\">{{code}}</font></b></font></div>\r\n	<div><br></div>\r\n	<div><br></div>\r\n\r\n\r\n\r\n<div>\r\n	<b>Requested From: </b> {{ip}} - {{browser}} on {{operating_system}} <br>\r\n	<div><br></div>\r\n	<b>Requested at: </b> {{time}} \r\n</div>', '---', '---', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 0, 0, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'Your Password Reset Successfully', '<div>As you requested, your password for our system has now been reset.</div>\r\n<div>If it was not at your request, then please contact support immediately.</div>\r\n\r\n	<div><br></div>\r\n\r\n\r\n\r\n<div>\r\n	<b>Reset From: </b> {{ip}} - {{browser}} on {{operating_system}} <br>\r\n	<div><br></div>\r\n	<b>Reset at: </b> {{time}} \r\n</div>', 'As you requested, your password for our system has now been reset. If it was not at your request, then please contact support immediately.', 'As you requested, your password for our system has now been reset.\r\nIf it was not at your request, then please contact support immediately.\r\n\r\nReset From: {{ip}} - {{browser}} on {{operating_system}}\r\n\r\nReset at: {{time}}', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Support Ticket Response', '<div>A member from our support team has replied to the following ticket:</div>\r\n\r\n	<div><br></div>\r\n\r\n<div>\r\n<b>[Ticket#{{ticket_id}}]: </b> {{ticket_subject}}\r\n</div>\r\n\r\n\r\n	<div><br></div>\r\n	<div><br></div>\r\n<div>----------------------------------------------</div>\r\n	<div><br></div>\r\n<div>{{reply}}</div>\r\n	<div><br></div>\r\n<div>----------------------------------------------</div>\r\n\r\n	<div><br></div>\r\n	<div><br></div>\r\n\r\n<div>\r\n<div><b>Ticket ID:</b> #{{ticket_id}}</div>\r\n<div><b>Subject:</b>  {{ticket_subject}}</div>\r\n<div><b>Ticket URL:</b> {{link}}</div>\r\n</div>\r\n\r\n	<div><br></div>\r\n\r\n\r\n<div>Please visit the URL mentioned above to view the response and post an update.</div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', 'A member from our support team has replied to the following ticket:\r\n\r\n[Ticket#{{ticket_id}}]: {{ticket_subject}}\r\n\r\n\r\n----------------------------------------------\r\n\r\n{{reply}}\r\n\r\n----------------------------------------------\r\n\r\n\r\nTicket ID: #{{ticket_id}}\r\nSubject: {{ticket_subject}}\r\nTicket URL: {{link}}\r\n\r\nPlease visit the URL mentioned above to view the response and post an update.', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(10, 'EVER_CODE', 'Verification - Email', 'Verify Your Email Address', '<div>Thank you for creating an account with us.</div>\r\n	<div><br></div>\r\n<div>Please use the code below to verify your email address and complete your registration.</div>\r\n	<div><br></div>\r\n\r\n<div><font color=\"#2ecc71\"><b><font size=\"4\">{{code}}</font></b></font></div>\r\n\r\n	<div><br></div>\r\n\r\n\r\n\r\n<div>You are receiving this email because you recently created an account with us. If you did not do this, please contact us.</div>', '---', '---', '{\"code\":\"Email verification code\"}', 1, 0, 0, '2021-11-03 18:00:00', '2021-11-04 15:22:00'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', '---', 'Your verification code is {{code}}', '---', '{\"code\":\"SMS Verification Code\"}', 0, 1, 0, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdraw Processed Successfully', '<div>This is to notify you that your withdraw request of <b>{{amount}} {{currency}}</b> via <i>{{method_name}}</i> has been Processed Successfully.</div>\r\n	<div><br></div>\r\n\r\n<div>Amount : {{amount}} {{currency}}</div>\r\n<div>Charge: {{charge}} {{currency}}</div>\r\n<div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div>\r\n<div>Receivable: {{method_amount}} {{method_currency}}</div>\r\n<div>Withdrawn Via: {{method_name}}</div>\r\n<div>Transaction Number: #{{trx}}</div>\r\n<div>Details: {{admin_details}}</div>\r\n\r\n	<div><br></div>\r\n\r\n<div>Note: This email will serve as an official receipt for this payment.</div>', 'withdraw request of {{amount}} {{currrency}} via {{gateway_name}} has been processed.', 'This is to notify you that your withdraw request of {{amount}} {{currency}} via {{method_name}} has been Processed Successfully.\r\n\r\nAmount : {{amount}} {{currency}}\r\nCharge: {{charge}} {{currency}}\r\nConversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}\r\nReceivable: {{method_amount}} {{method_currency}}\r\nWithdrawn Via: {{method_name}}\r\nTransaction Number: #{{trx}}\r\nDetails: {{admin_details}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"currency\":\"Base currency of the system\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdraw Request Rejected', '<div>This is to notify you that your withdraw request of <b>{{amount}} {{currency}}</b> via <i>{{method_name}}</i> (Transaction Number: #{{trx}})  has been Rejected. Your withdrawn amount ({{amount}} {{currency}}) has been <b>refunded</b> to your account and your current balance is <b>{{post_balance}}  {{currency}}</b> </div>\r\n\r\n	<div><br></div>\r\n\r\nReason of rejection: {{rejection_message}}<div></div>', 'your WITHDRAW request of {{amount}} {{currency}} via {{method_name}} (Transaction Number: #{{trx}}) has been rejected.  Your withdrawn amount ({{amount}} {{currency}}) has been refunded and your current balance is {{post_balance}}{{currency}} .', 'This is to notify you that your withdraw request of {{amount}} {{currency}} via {{method_name}} (Transaction Number: #{{trx}}) has been Rejected. Your withdrawn amount ({{amount}} {{currency}}) has been refunded to your account and your current balance is {{post_balance}} {{currency}}\r\n\r\nReason of rejection: {{rejection_message}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"currency\":\"Base currency of the system\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"rejection_message\":\"Rejection message by the admin\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdraw Request Submitted Successfully', '<div>This is to notify you that your withdraw request of <b>{{amount}} {{currency}}</b> via <i>{{method_name}}</i> has been submitted successfully and your current balance is <b>{{post_balance}} {{currency}}.</b></div>\r\n\r\n<div><br></div>\r\n\r\n\r\n<div>Amount : {{amount}} {{currency}}</div>\r\n<div>Charge: {{charge}} {{currency}}</div>\r\n<div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div>\r\n<div>Receivable: {{method_amount}} {{method_currency}}</div>\r\n<div>Withdrawn Via: {{method_name}}</div>\r\n<div>Transaction Number: #{{trx}}</div>\r\n\r\n<div><br></div>\r\n<div><br></div>\r\n\r\n\r\n<div>Note: This is not the final confirmation for the withdraw. Our team will process your request and you will receive another confirmation \r\nonce we take an action.</div>', 'Withdraw request of {{amount}} {{currrency}} by {{method_name}} submitted successfully.\r\nTransaction Number: #{{trx}}', 'This is to notify you that your withdraw request of {{amount}} {{currency}} via {{method_name}} has been submitted successfully and your current balance is {{post_balance}} {{currency}}.\r\n\r\nAmount : {{amount}} {{currency}}\r\nCharge: {{charge}} {{currency}}\r\nConversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}\r\nReceivable: {{method_amount}} {{method_currency}}\r\nWithdrawn Via: {{method_name}}\r\nTransaction Number: #{{trx}}\r\n\r\n\r\nNote: This is not the final confirmation for the withdraw. Our team will process your request and you will receive another confirmation once we take an action.', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"currency\":\"Base currency of the system\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, 1, '2021-11-03 18:00:00', '2021-11-04 15:02:58'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, 1, 1, '2019-09-14 19:14:22', '2021-11-04 15:38:55'),
(16, 'ESCROW_CANCELLED', 'Escrow Cancelled', 'Escrow Cancelled', 'Your escrow \"<b><i>{{title}}&nbsp;</i></b><span style=\"color: rgb(33, 37, 41);\">\" has been cancelled by the {{canceller}}. The escrow amount was {{amount}} {{currency}} and the funded amount was {{total_fund}} {{currency}}</span>', 'Your escrow \"{{title}} \" has been cancelled by the {{canceller}}. The escrow amount was {{amount}} {{currency}} and the funded amount was {{total_fund}} {{currency}}', 'Your escrow \"{{title}} \" has been cancelled by {{canceller}}. The escrow amount was {{amount}} {{currency}} and the funded amount was {{total_fund}} {{currency}}', '{\"title\":\"Title of the escrow\",\"amount\":\"Amount of the escrow\",\"canceller\":\"Who cancelled the escrow\",\"total_fund\":\"How many amount was funded to the escrow\",\"currency\":\"Site currency\"}', 1, 1, 1, NULL, '2022-01-05 12:43:22'),
(17, 'ESCROW_ACCEPTED', 'Escrow Accepted', 'Escrow Accepted', 'Your escrow \"<b><i>{{title}}&nbsp;</i></b><span style=\"color: rgb(33, 37, 41);\">\" has been accepted by the {{accepter}}. The escrow amount was {{amount}} {{currency}} and the funded amount was {{total_fund}} {{currency}}.</span>', 'Your escrow \"{{title}} \" has been accepted by the {{accepter}}. The escrow amount was {{amount}} {{currency}} and the funded amount was {{total_fund}} {{currency}}.', 'Your escrow \"{{title}} \" has been accepted by the {{accepter}}. The escrow amount was {{amount}} {{currency}} and the funded amount was {{total_fund}} {{currency}}.', '{\"title\":\"Title of the escrow\",\"amount\":\"Amount of the escrow\",\"accepter\":\"Who accpet the escrow\",\"total_fund\":\"How many amount was funded to the escrow\",\"currency\":\"Site currency\"}', 1, 1, 1, NULL, '2022-01-05 12:43:30'),
(18, 'ESCROW_PAYMENT_DISPATCHED', 'Escrow Payment Dispatched', 'Escrow Payment Dispatched', 'Your escrow \"<b><i>{{title}}</i></b>\" payment has been dispatched by the buyer. The escrow amount was {{amount}} {{currency}} and the charge was {{charge}} {{currency}}. We have cut {{seller_charge}} {{currency}} from your account after got paid. The transaction number is {{trx}} and your current balance is {{post_balance}} {{currency}}', 'Your escrow \"{{title}}\" payment has been dispatched by the buyer. The escrow amount was {{amount}} {{currency}} and the charge was {{charge}} {{currency}}. We have cut {{seller_charge}} {{currency}} from your account after got paid. The transaction number is {{trx}} and your current balance is {{post_balance}} {{currency}}', 'Your escrow \"{{title}}\" payment has been dispatched by the buyer. The escrow amount was {{amount}} {{currency}} and the charge was {{charge}} {{currency}}. We have cut {{seller_charge}} {{currency}} from your account after got paid. The transaction number is {{trx}} and your current balance is {{post_balance}} {{currency}}', '{\"title\":\"Title of the escrow\",\"amount\":\"Amount of the escrow\",\"charge\":\"Total charge of the escrow\",\"seller_charge\":\"Amount of the seller charge\",\"trx\":\"Transaction number\",\"post_balance\":\"Seller balance after transaction\",\"currency\":\"Site currency\"}', 1, 1, 1, NULL, '2022-01-05 12:52:22'),
(19, 'ESCROW_DISPUTED', 'Escrow Disputed', 'Escrow Disputed', 'Your escrow \"<b><i>{{title}}</i></b>\" has been disputed by the {{disputer}}. The amount of the escrow was {{amount}} {{currency}}. {{total_fund}} {{currency}} was funded to the escrow. The dispute note is : \"<i>{{dispute_note}}</i>\". Our staff will join with your chat. Please wait for admin action.', 'Your escrow \"{{title}}\" has been disputed by the {{disputer}}. The amount of the escrow was {{amount}} {{currency}}. {{total_fund}} {{currency}} was funded to the escrow. The dispute note is : \"{{dispute_note}}\". Our staff will join with your chat. Please wait for admin action.', 'Your escrow \"{{title}}\" has been disputed by the {{disputer}}. The amount of the escrow was {{amount}} {{currency}}. {{total_fund}} {{currency}} was funded to the escrow. The dispute note is : \"{{dispute_note}}\". Our staff will join with your chat. Please wait for admin action.', '{\"title\":\"Title of the escrow\",\"amount\":\"Amount of the escrow\",\"disputer\":\"Who dispute the escrow\",\"total_fund\":\"How many amount funded to the escrow\",\"dispute_note\":\"Dispute note\",\"currency\":\"Site currency\"}', 1, 1, 1, NULL, '2022-01-05 13:03:04'),
(20, 'ESCROW_ADMIN_ACTION', 'Escrow Admin Action', 'Escrow Admin Action', 'Your escrow \"<b><i>{{title}}</i></b>\" was disputed and the admin has taken an action. Admin decided to give {{buyer_amount}} {{currency}} to buyer and&nbsp;<span style=\"color: rgb(33, 37, 41);\">{{seller_amount}} {{currency}} to seller. System has cut the {{charge}} {{currency}} as charge. Your current balance is {{post_balance}} {{currency}}. The transaction number is #{{trx}}</span>', 'Your escrow \"{{title}}\" was disputed and the admin has taken an action. Admin decided to give {{buyer_amount}} {{currency}} to buyer and {{seller_amount}} {{currency}} to seller. System has cut the {{charge}} {{currency}} as charge. Your current balance is {{post_balance}} {{currency}}. The transaction number is #{{trx}}', 'Your escrow \"{{title}}\" was disputed and the admin has taken an action. Admin decided to give {{buyer_amount}} {{currency}} to buyer and {{seller_amount}} {{currency}} to seller. System has cut the {{charge}} {{currency}} as charge. Your current balance is {{post_balance}} {{currency}}. The transaction number is #{{trx}}', '{\"title\":\"Title of the escrow\",\"amount\":\"Amount of the escrow\",\"total_fund\":\"How many amount funded to the escrow\",\"seller_amount\":\"How many amount seller will get\",\"buyer_amount\":\"How many amount buyer will get\",\"charge\":\"How many charge will cut by admin\",\"trx\":\"Transaction number\",\"post_balance\":\"Balance after transaction\",\"currency\":\"Site currency\"}', 1, 1, 1, NULL, '2022-01-05 13:14:49'),
(21, 'INVITATION_LINK', 'Invitation Link', 'You are invited to join with escrow', 'You are invited to this escrow site. please <a href=\"{{link}}\" title=\"\" target=\"_blank\">register now</a>', 'You are invited to this escrow site. please register now', 'You are invited to this escrow site. please register now', '{\"link\":\"Registration link\"}', 1, 1, 1, NULL, '2022-01-05 15:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', 'home', 'templates.default.', '[\"how_it_work\",\"overview\",\"service\",\"counter\",\"testimonial\",\"faq\",\"blog\"]', 1, '2020-07-11 06:23:58', '2022-01-02 11:53:56'),
(2, 'About', 'about-us', 'templates.default.', '[\"how_it_work\",\"overview\",\"service\"]', 0, '2020-07-11 06:35:35', '2022-01-05 14:11:34'),
(4, 'Blog', 'blog', 'templates.default.', NULL, 1, '2020-10-22 01:14:43', '2020-10-22 01:14:43'),
(5, 'Contact', 'contact', 'templates.default.', NULL, 1, '2020-10-22 01:14:53', '2020-10-22 01:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(10) UNSIGNED NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) DEFAULT 0,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploader_logs`
--

CREATE TABLE `uploader_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `directory` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: sms unverified, 1: sms verified',
  `ver_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) DEFAULT 0.00000000,
  `rate` decimal(28,8) DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `escrows`
--
ALTER TABLE `escrows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `escrow_charges`
--
ALTER TABLE `escrow_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `escrow_types`
--
ALTER TABLE `escrow_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploader_logs`
--
ALTER TABLE `uploader_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `escrows`
--
ALTER TABLE `escrows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `escrow_charges`
--
ALTER TABLE `escrow_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `escrow_types`
--
ALTER TABLE `escrow_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploader_logs`
--
ALTER TABLE `uploader_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
