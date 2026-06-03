-- Melodiyam Database Schema
SET FOREIGN_KEY_CHECKS=0;


-- Table structure for `activities`
DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `subject_type` varchar(255) NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_user_id_foreign` (`user_id`),
  KEY `activities_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  KEY `activities_type_index` (`type`),
  CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `activity_logs`
DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  KEY `activity_logs_user_id_action_index` (`user_id`,`action`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `ad_impressions`
DROP TABLE IF EXISTS `ad_impressions`;
CREATE TABLE `ad_impressions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `advertisement_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `event` enum('impression','click','complete') NOT NULL DEFAULT 'impression',
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_impressions_user_id_foreign` (`user_id`),
  KEY `ad_impressions_advertisement_id_event_index` (`advertisement_id`,`event`),
  CONSTRAINT `ad_impressions_advertisement_id_foreign` FOREIGN KEY (`advertisement_id`) REFERENCES `advertisements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ad_impressions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=1750 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `advertisements`
DROP TABLE IF EXISTS `advertisements`;
CREATE TABLE `advertisements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('audio','banner','video','sponsored_track','sponsored_playlist') NOT NULL DEFAULT 'banner',
  `media_path` varchar(255) DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `click_url` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `duration` int(10) unsigned DEFAULT NULL,
  `interval_seconds` int(10) unsigned NOT NULL DEFAULT 300 COMMENT 'هر چند ثانیه یک تبلیغ پخش شود',
  `tracks_between` int(10) unsigned NOT NULL DEFAULT 3 COMMENT 'هر چند آهنگ یک تبلیغ پخش شود',
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','active','paused','expired') NOT NULL DEFAULT 'draft',
  `impressions` bigint(20) unsigned NOT NULL DEFAULT 0,
  `clicks` bigint(20) unsigned NOT NULL DEFAULT 0,
  `max_impressions` bigint(20) unsigned DEFAULT NULL,
  `budget` decimal(12,0) DEFAULT NULL,
  `spent` decimal(12,0) NOT NULL DEFAULT 0,
  `targeting` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`targeting`)),
  `target_plans` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'پلن‌هایی که این آگهی نمایش داده می‌شود' CHECK (json_valid(`target_plans`)),
  `priority` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `advertisements_status_starts_at_ends_at_index` (`status`,`starts_at`,`ends_at`),
  KEY `advertisements_type_index` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `albums`
DROP TABLE IF EXISTS `albums`;
CREATE TABLE `albums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `type` enum('album','ep','single') NOT NULL DEFAULT 'album',
  `genre_id` bigint(20) unsigned DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_explicit` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `play_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `like_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `repost_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `share_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `upc` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `price` decimal(12,0) DEFAULT NULL COMMENT 'قیمت (null = رایگان)',
  `discount_price` decimal(12,0) DEFAULT NULL COMMENT 'قیمت با تخفیف (null = بدون تخفیف)',
  `preview_seconds` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_for_sale` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `albums_slug_unique` (`slug`),
  KEY `albums_artist_id_foreign` (`artist_id`),
  KEY `albums_genre_id_foreign` (`genre_id`),
  KEY `albums_status_index` (`status`),
  KEY `albums_release_date_index` (`release_date`),
  KEY `albums_is_featured_index` (`is_featured`),
  KEY `albums_play_count_index` (`play_count`),
  CONSTRAINT `albums_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `albums_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `artist_application_fields`
DROP TABLE IF EXISTS `artist_application_fields`;
CREATE TABLE `artist_application_fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `required` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `placeholder` varchar(255) DEFAULT NULL,
  `help_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artist_application_fields_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `artist_application_fields`
INSERT INTO `artist_application_fields` (`id`, `key`, `label`, `type`, `options`, `required`, `is_active`, `sort_order`, `placeholder`, `help_text`, `created_at`, `updated_at`) VALUES ('1', 'name', 'نام هنری', 'text', NULL, '1', '1', '0', 'نام خود را وارد کنید', 'لطفا نام کامل را وارد کنید', '2026-05-29 19:15:37', '2026-05-29 19:15:37');
INSERT INTO `artist_application_fields` (`id`, `key`, `label`, `type`, `options`, `required`, `is_active`, `sort_order`, `placeholder`, `help_text`, `created_at`, `updated_at`) VALUES ('2', 'idcart', 'کارت ملی', 'file', NULL, '1', '1', '0', 'لطفا تصویر کارت ملی را وارد کنید', 'تصویر باید واضح باشد', '2026-05-29 19:15:37', '2026-05-29 19:15:37');


-- Table structure for `artist_applications`
DROP TABLE IF EXISTS `artist_applications`;
CREATE TABLE `artist_applications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `status` enum('pending','reviewing','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artist_applications_user_id_unique` (`user_id`),
  KEY `artist_applications_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `artist_applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `artist_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `artist_earnings`
DROP TABLE IF EXISTS `artist_earnings`;
CREATE TABLE `artist_earnings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` bigint(20) unsigned NOT NULL,
  `playable_type` varchar(255) NOT NULL,
  `playable_id` bigint(20) unsigned NOT NULL,
  `play_count` int(11) NOT NULL DEFAULT 0,
  `earning_amount_toman` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artist_earnings_artist_id_foreign` (`artist_id`),
  KEY `artist_earnings_playable_type_playable_id_index` (`playable_type`,`playable_id`),
  CONSTRAINT `artist_earnings_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `artist_plans`
DROP TABLE IF EXISTS `artist_plans`;
CREATE TABLE `artist_plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(10) unsigned NOT NULL DEFAULT 0,
  `duration_days` int(10) unsigned NOT NULL DEFAULT 30,
  `max_tracks` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '0 = unlimited',
  `max_albums` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '0 = unlimited',
  `max_storage_mb` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '0 = unlimited',
  `includes_downloads` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Plan includes download capability',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artist_plans_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `artist_plans`
INSERT INTO `artist_plans` (`id`, `name`, `slug`, `description`, `price`, `duration_days`, `max_tracks`, `max_albums`, `max_storage_mb`, `includes_downloads`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES ('1', 'هنرمند تازه کار', 'hnrmnd-tazh-kar', 'این پلن مخصوص هنرمندان تازه کار هست', '100000', '30', '5', '2', '1000', '0', '1', '0', '2026-05-29 19:18:11', '2026-05-29 19:18:11');
INSERT INTO `artist_plans` (`id`, `name`, `slug`, `description`, `price`, `duration_days`, `max_tracks`, `max_albums`, `max_storage_mb`, `includes_downloads`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES ('2', 'هنرمند حرفه ای', 'hnrmnd-hrfh-ay', 'این پلن مناسب هنرمندن حرفه ای می باشد.', '400000', '30', '50', '20', '20000', '0', '1', '0', '2026-06-02 14:17:59', '2026-06-02 14:17:59');


-- Table structure for `artist_subscriptions`
DROP TABLE IF EXISTS `artist_subscriptions`;
CREATE TABLE `artist_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` bigint(20) unsigned NOT NULL,
  `plan_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `starts_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `tracks_used` int(10) unsigned NOT NULL DEFAULT 0,
  `albums_used` int(10) unsigned NOT NULL DEFAULT 0,
  `storage_used_mb` bigint(20) unsigned NOT NULL DEFAULT 0,
  `payment_ref` varchar(255) DEFAULT NULL,
  `granted_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artist_subscriptions_artist_id_foreign` (`artist_id`),
  KEY `artist_subscriptions_plan_id_foreign` (`plan_id`),
  KEY `artist_subscriptions_granted_by_foreign` (`granted_by`),
  CONSTRAINT `artist_subscriptions_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `artist_subscriptions_granted_by_foreign` FOREIGN KEY (`granted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `artist_subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `artist_plans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `artist_track`
DROP TABLE IF EXISTS `artist_track`;
CREATE TABLE `artist_track` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` bigint(20) unsigned NOT NULL,
  `track_id` bigint(20) unsigned NOT NULL,
  `role` enum('primary','featuring','producer','composer','lyricist') NOT NULL DEFAULT 'featuring',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artist_track_artist_id_track_id_role_unique` (`artist_id`,`track_id`,`role`),
  KEY `artist_track_track_id_foreign` (`track_id`),
  CONSTRAINT `artist_track_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `artist_track_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `artists`
DROP TABLE IF EXISTS `artists`;
CREATE TABLE `artists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `verification_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `verified_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `monthly_listeners` bigint(20) unsigned NOT NULL DEFAULT 0,
  `total_streams` bigint(20) unsigned NOT NULL DEFAULT 0,
  `followers_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `balance` decimal(12,0) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artists_slug_unique` (`slug`),
  KEY `artists_user_id_foreign` (`user_id`),
  KEY `artists_verification_status_index` (`verification_status`),
  KEY `artists_is_featured_index` (`is_featured`),
  KEY `artists_monthly_listeners_index` (`monthly_listeners`),
  CONSTRAINT `artists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `cache`
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `cache_locks`
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `comments`
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `commentable_type` varchar(255) NOT NULL,
  `commentable_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `body` text NOT NULL,
  `timestamp_at` int(10) unsigned DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  KEY `comments_is_approved_index` (`is_approved`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `commission_rules`
DROP TABLE IF EXISTS `commission_rules`;
CREATE TABLE `commission_rules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'نام قانون',
  `type` enum('global','genre','artist') NOT NULL DEFAULT 'global',
  `reference_id` bigint(20) unsigned DEFAULT NULL COMMENT 'genre_id یا artist_id',
  `commission_type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `commission_value` decimal(8,2) NOT NULL DEFAULT 20.00 COMMENT 'درصد یا مبلغ ثابت',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commission_rules_type_reference_id_index` (`type`,`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `coupon_user`
DROP TABLE IF EXISTS `coupon_user`;
CREATE TABLE `coupon_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `coupon_user_coupon_id_foreign` (`coupon_id`),
  KEY `coupon_user_user_id_foreign` (`user_id`),
  CONSTRAINT `coupon_user_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `coupons`
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `max_discount` decimal(15,2) DEFAULT NULL,
  `min_purchase` decimal(15,2) NOT NULL DEFAULT 0.00,
  `limit_per_user` int(11) DEFAULT NULL,
  `total_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `applicable_to` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applicable_to`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `downloads`
DROP TABLE IF EXISTS `downloads`;
CREATE TABLE `downloads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `downloadable_type` varchar(255) NOT NULL,
  `downloadable_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `downloads_user_id_downloadable_type_downloadable_id_unique` (`user_id`,`downloadable_type`,`downloadable_id`),
  KEY `downloads_downloadable_type_downloadable_id_index` (`downloadable_type`,`downloadable_id`),
  CONSTRAINT `downloads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `earnings_settings`
DROP TABLE IF EXISTS `earnings_settings`;
CREATE TABLE `earnings_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `plays_threshold` int(11) NOT NULL DEFAULT 100,
  `earning_amount_toman` int(11) NOT NULL DEFAULT 500,
  `min_payout_toman` int(11) NOT NULL DEFAULT 50000,
  `payout_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `failed_jobs`
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `follows`
DROP TABLE IF EXISTS `follows`;
CREATE TABLE `follows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `followable_type` varchar(255) NOT NULL,
  `followable_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `follows_user_id_followable_type_followable_id_unique` (`user_id`,`followable_type`,`followable_id`),
  KEY `follows_followable_type_followable_id_index` (`followable_type`,`followable_id`),
  CONSTRAINT `follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `genre_track`
DROP TABLE IF EXISTS `genre_track`;
CREATE TABLE `genre_track` (
  `genre_id` bigint(20) unsigned NOT NULL,
  `track_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`genre_id`,`track_id`),
  KEY `genre_track_track_id_foreign` (`track_id`),
  CONSTRAINT `genre_track_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `genre_track_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `genres`
DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_fa` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `genres_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `genres`
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Pop', 'پاپ', 'pop', 'music', '#ec4899', 'genres/01KSTNW5MDS5GKH4QR89D3777A.png', '1', '1', '2026-05-29 14:06:34', '2026-05-29 20:12:40');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Traditional', 'سنتی', 'traditional', 'guitar', '#f59e0b', NULL, '2', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Rock', 'راک', 'rock', 'bolt', '#ef4444', NULL, '3', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'Rap', 'رپ', 'rap', 'microphone', '#8b5cf6', NULL, '4', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('5', 'Electronic', 'الکترونیک', 'electronic', 'cpu', '#06b6d4', NULL, '5', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'Classical', 'کلاسیک', 'classical', 'music-note', '#14b8a6', NULL, '6', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('7', 'Jazz', 'جاز', 'jazz', 'sparkles', '#6366f1', NULL, '7', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('8', 'Folk', 'محلی', 'folk', 'globe', '#84cc16', NULL, '8', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('9', 'R&B', 'آر اند بی', 'rb', 'heart', '#d946ef', NULL, '9', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('10', 'Chill', 'آرام', 'chill', 'cloud', '#22d3ee', NULL, '10', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('11', 'Workout', 'ورزشی', 'workout', 'fire', '#f97316', NULL, '11', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `genres` (`id`, `name`, `name_fa`, `slug`, `icon`, `color`, `cover_image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('12', 'Romantic', 'عاشقانه', 'romantic', 'heart', '#f43f5e', NULL, '12', '1', '2026-05-29 14:06:34', '2026-05-29 14:06:34');


-- Table structure for `homepage_sections`
DROP TABLE IF EXISTS `homepage_sections`;
CREATE TABLE `homepage_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_fa` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `type` enum('hero','slider','featured_playlists','featured_artists','new_releases','trending','genres','podcasts','recommended','custom','banner','recently_played','top_charts','artist_spotlight','latest_albums','custom_tracks','featured_track','track_shelf') NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homepage_sections_slug_unique` (`slug`),
  KEY `homepage_sections_sort_order_index` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `homepage_sections`
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'بنر-اصلی', 'بنر اصلی', 'bnr-asly', 'hero', '{\"hero_title\":\"\\u0645\\u0648\\u0633\\u06cc\\u0642\\u06cc \\u0628\\u06cc\\u200c\\u067e\\u0627\\u06cc\\u0627\\u0646 \\u0628\\u0627 \\u0645\\u0644\\u0648\\u062f\\u06cc\\u0627\\u0645\",\"hero_subtitle\":\"\\u0645\\u06cc\\u0644\\u06cc\\u0648\\u0646\\u200c\\u0647\\u0627 \\u0622\\u0647\\u0646\\u06af\\u060c \\u067e\\u0627\\u062f\\u06a9\\u0633\\u062a \\u0648 \\u067e\\u0644\\u06cc\\u200c\\u0644\\u06cc\\u0633\\u062a. \\u0647\\u0631 \\u0644\\u062d\\u0638\\u0647\\u060c \\u0647\\u0631 \\u062c\\u0627\\u060c \\u0647\\u0631 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647.\",\"hero_btn1_label\":\"\\u0634\\u0631\\u0648\\u0639 \\u0631\\u0627\\u06cc\\u06af\\u0627\\u0646\",\"hero_btn1_url\":\"\\/premium\",\"hero_btn2_label\":\"\\u0628\\u06cc\\u0630\\u0628\\u06cc\\u0630\\u0628\\u06cc\",\"hero_btn2_url\":\"\\u0630\\u0628\\u06cc\\u0630\\u0628\\u06cc\\u0630\",\"hero_color_from\":\"#c20c0c\",\"hero_color_to\":\"#260000\",\"hero_image\":null}', '6', '1', '2026-05-29 15:53:41', '2026-05-29 15:53:41');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('7', '2', '2', '2', 'track_shelf', '{\"limit\":8,\"layout\":\"grid\",\"columns\":6,\"sort_by\":\"like_count\",\"genre_filter\":[\"traditional\",\"rock\",\"pop\"],\"show_see_all\":true,\"see_all_url\":null,\"see_all_label\":\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647 \\u0647\\u0645\\u0647\"}', '7', '1', '2026-05-29 15:55:15', '2026-05-29 17:31:49');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('9', '3', '3', '3', 'featured_artists', '{\"limit\":6,\"columns\":6,\"featured_only\":true}', '8', '1', '2026-05-29 17:32:26', '2026-05-29 17:32:26');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('10', '4', '4', '4', 'featured_artists', '{\"limit\":6,\"columns\":6,\"featured_only\":false}', '9', '1', '2026-05-29 17:32:49', '2026-05-29 17:32:49');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('11', '5', '5', '5', 'featured_playlists', '{\"limit\":6,\"columns\":6,\"featured_only\":false}', '10', '1', '2026-05-29 17:35:08', '2026-05-29 17:35:08');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('12', '6', '6', '6', 'latest_albums', '{\"limit\":4,\"layout\":\"grid\",\"columns\":6,\"sort_by\":\"play_count\",\"genre_filter\":[\"traditional\",\"electronic\",\"classical\",\"rap\",\"rock\",\"folk\",\"jazz\",\"rb\",\"chill\",\"pop\",\"workout\",\"romantic\"],\"show_see_all\":true,\"see_all_url\":null,\"see_all_label\":\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647 \\u0647\\u0645\\u0647\"}', '11', '1', '2026-05-29 17:35:38', '2026-05-29 17:57:44');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('13', '7', '7', '7', 'top_charts', '{\"limit\":12,\"columns\":6,\"period\":365,\"show_see_all\":true,\"see_all_url\":null}', '12', '1', '2026-05-29 17:37:44', '2026-05-29 17:52:57');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('14', '8', '8', '8', 'artist_spotlight', '{\"artist_id\":6,\"spotlight_text\":\"\\u0644\\u062b\\u0635\\u0644\\u062b\\u0635\\u0644\\u062b\\u0635\\u0644\\u062b\\u0635\\u0644\\u062b\\u0635\\u0644\\u062b\\u0635\\u0644\"}', '13', '1', '2026-05-29 18:15:45', '2026-05-29 18:15:45');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('15', '9', '9', '9', 'banner', '{\"banner_title\":\"\\u06cc\\u0633\\u0631\\u06cc\\u0633\\u0631\",\"banner_url\":\"\\u06cc\\u0633\\u0631\\u0631\\u06cc\\u0633\\u0631\",\"banner_image\":\"homepage\\/01KSTF8A41P985J9GRFADENWN4.jpeg\",\"banner_bg\":\"#d10808\",\"banner_btn_label\":\"\\u06cc\\u0633\\u0631\\u06cc\\u0633\\u0631\\u06cc\\u0631\\u06cc\\u0633\\u0631\"}', '14', '1', '2026-05-29 18:16:58', '2026-05-29 18:16:58');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('16', '9', '9', '9-1', 'custom_tracks', '{\"layout\":\"grid\",\"columns\":6,\"show_see_all\":true,\"track_ids\":[{\"id\":2},{\"id\":3}],\"album_ids\":[{\"id\":2}],\"playlist_ids\":[{\"id\":2}]}', '15', '1', '2026-05-29 18:18:03', '2026-05-29 18:18:03');
INSERT INTO `homepage_sections` (`id`, `title`, `title_fa`, `slug`, `type`, `config`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('17', '11', '11', '11', 'featured_track', '{\"sort_by\":\"play_count\",\"limit\":6,\"genre_filter\":[],\"autoplay\":true,\"autoplay_interval\":7,\"show_play_btn\":true}', '16', '1', '2026-05-29 18:18:42', '2026-05-29 18:18:42');


-- Table structure for `job_batches`
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `jobs`
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `likes`
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `likeable_type` varchar(255) NOT NULL,
  `likeable_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `likes_user_id_likeable_type_likeable_id_unique` (`user_id`,`likeable_type`,`likeable_id`),
  KEY `likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `migrations`
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `model_has_permissions`
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `model_has_roles`
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `notification_logs`
DROP TABLE IF EXISTS `notification_logs`;
CREATE TABLE `notification_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `notification_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `notification_settings`
DROP TABLE IF EXISTS `notification_settings`;
CREATE TABLE `notification_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_key` varchar(255) NOT NULL,
  `event_label` varchar(255) NOT NULL,
  `recipient_type` varchar(255) NOT NULL,
  `database_template` text DEFAULT NULL,
  `via_database` tinyint(1) NOT NULL DEFAULT 1,
  `via_sms` tinyint(1) NOT NULL DEFAULT 0,
  `via_email` tinyint(1) NOT NULL DEFAULT 0,
  `sms_pattern_id` varchar(255) DEFAULT NULL,
  `sms_var_names` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sms_var_names`)),
  `sms_template` text DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_body` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notification_settings_event_key_unique` (`event_key`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `notification_settings`
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('1', 'track_liked', 'لایک شدن آهنگ (صاحب اثر)', 'artist', 'هنرمند گرامی، آهنگ {track_title} توسط {user_name} لایک شد.', '1', '1', '0', '387751', NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 20:12:54');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('2', 'track_reposted', 'بازنشر آهنگ (صاحب اثر)', 'artist', 'هنرمند گرامی، آهنگ {track_title} توسط {user_name} بازنشر شد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('3', 'user_followed', 'دنبال شدن (کاربر)', 'user', 'کاربر گرامی، {follower_name} شما را دنبال کرد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('4', 'new_content_follower', 'محتوای جدید از دنبال‌شوندگان (دنبال‌کننده)', 'user', 'محتوای جدید: {artist_name} آهنگ جدید \"{content_title}\" را منتشر کرد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('5', 'track_purchased_artist', 'فروش آهنگ (هنرمند)', 'artist', 'هنرمند گرامی، آهنگ {track_title} به مبلغ {amount} فروخته شد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('6', 'new_artist_application', 'درخواست هنرمند جدید (ادمین)', 'admin', 'ادمین گرامی، درخواست جدید هنرمندی از طرف {user_name} ثبت شد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('7', 'new_report', 'گزارش جدید (ادمین)', 'admin', 'گزارش جدیدی با موضوع {type} ثبت شد.', '1', '1', '0', '387751', NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 20:12:54');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('8', 'otp_code', 'ارسال کد تایید (OTP)', 'user', 'کد تایید شما: {code}', '0', '1', '0', '387751', NULL, NULL, NULL, NULL, '2026-05-30 21:10:23', '2026-05-30 21:20:02');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('9', 'password_recovery', 'بازیابی رمز عبور', 'user', 'کد بازیابی رمز عبور شما: {code}', '0', '1', '1', '387751', NULL, NULL, 'بازیابی رمز عبور', NULL, '2026-05-30 21:10:23', '2026-05-30 21:20:02');


-- Table structure for `notifications`
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `notifications_log`
DROP TABLE IF EXISTS `notifications_log`;
CREATE TABLE `notifications_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_log_user_id_is_read_index` (`user_id`,`is_read`),
  CONSTRAINT `notifications_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `otp_codes`
DROP TABLE IF EXISTS `otp_codes`;
CREATE TABLE `otp_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(15) NOT NULL,
  `code` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otp_codes_phone_code_index` (`phone`,`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `pages`
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `password_reset_tokens`
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `payments`
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `subscription_id` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(12,0) NOT NULL,
  `tax_amount` decimal(12,0) NOT NULL DEFAULT 0,
  `fee_amount` decimal(12,0) NOT NULL DEFAULT 0,
  `gateway` varchar(255) NOT NULL DEFAULT 'zarinpal',
  `payment_type` varchar(255) NOT NULL DEFAULT 'subscription',
  `authority` varchar(255) DEFAULT NULL,
  `ref_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `description` varchar(255) DEFAULT NULL,
  `callback_url` text DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `gateway_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateway_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payable_type` varchar(255) DEFAULT NULL,
  `payable_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_subscription_id_foreign` (`subscription_id`),
  KEY `payments_user_id_status_index` (`user_id`,`status`),
  KEY `payments_authority_index` (`authority`),
  KEY `payments_payable_type_payable_id_index` (`payable_type`,`payable_id`),
  CONSTRAINT `payments_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `permissions`
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `plans`
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_fa` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `description_fa` text DEFAULT NULL,
  `type` enum('free','premium','family','student') NOT NULL DEFAULT 'premium',
  `price` decimal(12,0) NOT NULL DEFAULT 0,
  `duration_days` int(10) unsigned NOT NULL DEFAULT 30,
  `trial_days` smallint(5) unsigned NOT NULL DEFAULT 0,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `max_devices` smallint(5) unsigned NOT NULL DEFAULT 1,
  `audio_quality` enum('normal','high','lossless') NOT NULL DEFAULT 'high',
  `ad_free` tinyint(1) NOT NULL DEFAULT 1,
  `offline_mode` tinyint(1) NOT NULL DEFAULT 1,
  `unlimited_skips` tinyint(1) NOT NULL DEFAULT 1,
  `includes_paid_content` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'دسترسی به تمام محتوای پولی',
  `includes_downloads` tinyint(1) NOT NULL DEFAULT 0,
  `can_upload_music` tinyint(1) NOT NULL DEFAULT 0,
  `max_music_uploads` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plans_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `plans`
INSERT INTO `plans` (`id`, `name`, `name_fa`, `slug`, `description`, `description_fa`, `type`, `price`, `duration_days`, `trial_days`, `features`, `is_active`, `is_popular`, `sort_order`, `max_devices`, `audio_quality`, `ad_free`, `offline_mode`, `unlimited_skips`, `includes_paid_content`, `includes_downloads`, `can_upload_music`, `max_music_uploads`, `created_at`, `updated_at`) VALUES ('1', 'Free', 'رایگان', 'free', 'Basic access', 'دسترسی پایه', 'free', '0', '0', '0', '[\"\\u06af\\u0648\\u0634 \\u062f\\u0627\\u062f\\u0646 \\u0628\\u0627 \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\",\"\\u06a9\\u06cc\\u0641\\u06cc\\u062a \\u0645\\u0639\\u0645\\u0648\\u0644\\u06cc\"]', '1', '0', '1', '1', 'normal', '0', '0', '0', '0', '0', '0', '0', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `plans` (`id`, `name`, `name_fa`, `slug`, `description`, `description_fa`, `type`, `price`, `duration_days`, `trial_days`, `features`, `is_active`, `is_popular`, `sort_order`, `max_devices`, `audio_quality`, `ad_free`, `offline_mode`, `unlimited_skips`, `includes_paid_content`, `includes_downloads`, `can_upload_music`, `max_music_uploads`, `created_at`, `updated_at`) VALUES ('2', 'Premium Monthly', 'پریمیوم ماهانه', 'premium-monthly', 'Full access monthly', 'دسترسی کامل ماهانه', 'premium', '79000', '30', '1', '[\"\\u0628\\u062f\\u0648\\u0646 \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\",\"\\u06a9\\u06cc\\u0641\\u06cc\\u062a \\u06f3\\u06f2\\u06f0kbps\",\"\\u062f\\u0627\\u0646\\u0644\\u0648\\u062f \\u0622\\u0641\\u0644\\u0627\\u06cc\\u0646\",\"\\u0631\\u062f \\u0646\\u0627\\u0645\\u062d\\u062f\\u0648\\u062f\"]', '1', '1', '2', '3', 'high', '1', '1', '1', '1', '1', '1', '20', '2026-05-29 14:06:34', '2026-05-30 05:55:25');
INSERT INTO `plans` (`id`, `name`, `name_fa`, `slug`, `description`, `description_fa`, `type`, `price`, `duration_days`, `trial_days`, `features`, `is_active`, `is_popular`, `sort_order`, `max_devices`, `audio_quality`, `ad_free`, `offline_mode`, `unlimited_skips`, `includes_paid_content`, `includes_downloads`, `can_upload_music`, `max_music_uploads`, `created_at`, `updated_at`) VALUES ('3', 'Premium Yearly', 'پریمیوم سالانه', 'premium-yearly', 'Full access yearly', 'دسترسی کامل سالانه', 'premium', '699000', '365', '0', '[\"\\u0628\\u062f\\u0648\\u0646 \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\",\"\\u06a9\\u06cc\\u0641\\u06cc\\u062a \\u06f3\\u06f2\\u06f0kbps\",\"\\u062f\\u0627\\u0646\\u0644\\u0648\\u062f \\u0622\\u0641\\u0644\\u0627\\u06cc\\u0646\",\"\\u0631\\u062f \\u0646\\u0627\\u0645\\u062d\\u062f\\u0648\\u062f\",\"\\u06f2\\u06f6\\u066a \\u062a\\u062e\\u0641\\u06cc\\u0641\"]', '1', '0', '3', '5', 'lossless', '1', '1', '1', '0', '0', '0', '0', '2026-05-29 14:06:34', '2026-05-29 14:06:34');


-- Table structure for `playlist_followers`
DROP TABLE IF EXISTS `playlist_followers`;
CREATE TABLE `playlist_followers` (
  `user_id` bigint(20) unsigned NOT NULL,
  `playlist_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`playlist_id`),
  KEY `playlist_followers_playlist_id_foreign` (`playlist_id`),
  CONSTRAINT `playlist_followers_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `playlist_followers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `playlist_track`
DROP TABLE IF EXISTS `playlist_track`;
CREATE TABLE `playlist_track` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `playlist_id` bigint(20) unsigned NOT NULL,
  `track_id` bigint(20) unsigned NOT NULL,
  `added_by` bigint(20) unsigned DEFAULT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `playlist_track_playlist_id_track_id_unique` (`playlist_id`,`track_id`),
  KEY `playlist_track_track_id_foreign` (`track_id`),
  KEY `playlist_track_added_by_foreign` (`added_by`),
  KEY `playlist_track_position_index` (`position`),
  CONSTRAINT `playlist_track_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `playlist_track_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `playlist_track_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `playlists`
DROP TABLE IF EXISTS `playlists`;
CREATE TABLE `playlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `visibility` enum('public','private','collaborative') NOT NULL DEFAULT 'private',
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_sponsored` tinyint(1) NOT NULL DEFAULT 0,
  `followers_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `tracks_count` int(10) unsigned NOT NULL DEFAULT 0,
  `total_duration` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `playlists_slug_unique` (`slug`),
  KEY `playlists_user_id_foreign` (`user_id`),
  KEY `playlists_visibility_index` (`visibility`),
  KEY `playlists_is_featured_index` (`is_featured`),
  CONSTRAINT `playlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `podcast_episodes`
DROP TABLE IF EXISTS `podcast_episodes`;
CREATE TABLE `podcast_episodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `podcast_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `show_notes` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `duration` int(10) unsigned NOT NULL DEFAULT 0,
  `season_number` smallint(5) unsigned DEFAULT NULL,
  `episode_number` smallint(5) unsigned DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_explicit` tinyint(1) NOT NULL DEFAULT 0,
  `is_premium_only` tinyint(1) NOT NULL DEFAULT 0,
  `is_downloadable` tinyint(1) NOT NULL DEFAULT 0,
  `play_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `like_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `repost_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `podcast_episodes_podcast_id_slug_unique` (`podcast_id`,`slug`),
  KEY `podcast_episodes_status_index` (`status`),
  CONSTRAINT `podcast_episodes_podcast_id_foreign` FOREIGN KEY (`podcast_id`) REFERENCES `podcasts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `podcast_subscriptions`
DROP TABLE IF EXISTS `podcast_subscriptions`;
CREATE TABLE `podcast_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `podcast_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `podcast_subscriptions_user_id_podcast_id_unique` (`user_id`,`podcast_id`),
  KEY `podcast_subscriptions_podcast_id_foreign` (`podcast_id`),
  CONSTRAINT `podcast_subscriptions_podcast_id_foreign` FOREIGN KEY (`podcast_id`) REFERENCES `podcasts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `podcast_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `podcasts`
DROP TABLE IF EXISTS `podcasts`;
CREATE TABLE `podcasts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `artist_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `language` varchar(5) NOT NULL DEFAULT 'fa',
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `is_explicit` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_premium_only` tinyint(1) NOT NULL DEFAULT 0,
  `subscribers_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `repost_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `share_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `like_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `podcasts_slug_unique` (`slug`),
  KEY `podcasts_user_id_foreign` (`user_id`),
  KEY `podcasts_status_index` (`status`),
  KEY `podcasts_is_featured_index` (`is_featured`),
  KEY `podcasts_artist_id_foreign` (`artist_id`),
  CONSTRAINT `podcasts_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE SET NULL,
  CONSTRAINT `podcasts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `recently_played`
DROP TABLE IF EXISTS `recently_played`;
CREATE TABLE `recently_played` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `playable_type` varchar(255) NOT NULL,
  `playable_id` bigint(20) unsigned NOT NULL,
  `progress` int(10) unsigned NOT NULL DEFAULT 0,
  `played_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `recently_played_playable_type_playable_id_index` (`playable_type`,`playable_id`),
  KEY `recently_played_user_id_played_at_index` (`user_id`,`played_at`),
  CONSTRAINT `recently_played_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `reports`
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `reportable_type` varchar(255) NOT NULL,
  `reportable_id` bigint(20) unsigned NOT NULL,
  `reason` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','reviewed','resolved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_pending_report` (`user_id`,`reportable_type`,`reportable_id`,`status`),
  KEY `reports_reportable_type_reportable_id_index` (`reportable_type`,`reportable_id`),
  KEY `reports_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `reports_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `reposts`
DROP TABLE IF EXISTS `reposts`;
CREATE TABLE `reposts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `repostable_type` varchar(255) NOT NULL,
  `repostable_id` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reposts_user_id_repostable_type_repostable_id_unique` (`user_id`,`repostable_type`,`repostable_id`),
  KEY `reposts_repostable_type_repostable_id_index` (`repostable_type`,`repostable_id`),
  CONSTRAINT `reposts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `role_has_permissions`
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `roles`
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `sales`
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `saleable_type` varchar(255) NOT NULL,
  `saleable_id` bigint(20) unsigned NOT NULL,
  `gross_amount` decimal(12,0) NOT NULL COMMENT 'مبلغ کل پرداختی خریدار',
  `commission_amount` decimal(12,0) NOT NULL DEFAULT 0 COMMENT 'کمیسیون پلتفرم',
  `net_amount` decimal(12,0) NOT NULL COMMENT 'درآمد خالص هنرمند',
  `commission_rule_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('pending','completed','refunded') NOT NULL DEFAULT 'completed',
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_saleable_type_saleable_id_index` (`saleable_type`,`saleable_id`),
  KEY `sales_commission_rule_id_foreign` (`commission_rule_id`),
  KEY `sales_seller_id_status_index` (`seller_id`,`status`),
  KEY `sales_buyer_id_status_index` (`buyer_id`,`status`),
  CONSTRAINT `sales_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_commission_rule_id_foreign` FOREIGN KEY (`commission_rule_id`) REFERENCES `commission_rules` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `sessions`
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `settings`
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `settings`
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('1', 'site_name', 'ملودیاما', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 20:31:36');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('2', 'site_name_en', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('3', 'site_description', 'توضیحات کامل سایت', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('4', 'site_email', 'farnad25@gmail.com', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('5', 'site_phone', '09356963201', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('6', 'site_address', 'ادرس', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('7', 'site_logo', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('8', 'site_favicon', 'settings/01KST2NC6BNFA0X95W573NQE32.png', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('9', 'show_site_name_in_sidebar', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('10', 'logo_height_px', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('11', 'premium_faqs', '[{\"question\":\"پرمیوم میشه؟\",\"answer\":\"اره\"}]', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('12', 'maintenance_mode', '0', 'general', 'text', '2026-05-29 14:36:55', '2026-05-30 08:08:27');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('13', 'maintenance_message', 'درحال تعمیر هستیم', 'general', 'text', '2026-05-29 14:36:55', '2026-05-30 08:07:58');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('14', 'auth_type', 'both', 'general', 'text', '2026-05-29 14:36:55', '2026-05-30 21:01:26');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('15', 'allow_registration', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:37:26');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('16', 'email_verification', '0', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('17', 'phone_verification', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-30 20:29:41');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('18', 'allow_artist_register', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:37:26');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('19', 'auto_approve_artist', '0', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('20', 'artist_subscription_required', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:37:26');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('21', 'free_stream_limit', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('22', 'allow_download_free', '0', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('23', 'allow_download_premium', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('24', 'premium_preview_seconds', '30', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('25', 'auto_approve_content', '0', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('26', 'max_upload_size_mb', '50', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 18:46:29');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('27', 'featured_tracks_count', '5', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('28', 'home_new_releases', '10', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('29', 'premium_enabled', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('30', 'currency', 'تومان', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('31', 'payment_gateway', 'zibal', 'general', 'text', '2026-05-29 14:36:55', '2026-06-02 10:56:38');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('32', 'deposit_min_amount', '5000', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('33', 'deposit_max_amount', '50000000', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('34', 'withdraw_min_amount', '100000', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('35', 'withdraw_max_amount', '5000000', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('36', 'transaction_tax_percent', '10', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('37', 'withdraw_fee_amount', '1000', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('38', 'wallet_enabled', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('39', 'card2card_enabled', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('40', 'bank_card_number', '2727228872872', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('41', 'bank_card_owner', 'bfbfb', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('42', 'bank_name', 'fdbfdbfdb', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('43', 'social_instagram', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('44', 'social_telegram', 'regreg', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('45', 'social_twitter', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('46', 'social_youtube', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('47', 'social_aparat', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('48', 'meta_title', 'ملودیام سایت اهنگ', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('49', 'meta_description', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('50', 'meta_keywords', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('51', 'google_analytics', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('52', 'notify_new_track', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('53', 'notify_new_user', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('54', 'admin_email_notify', '1', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:39:48');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('55', 'smtp_host', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('56', 'smtp_port', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('57', 'smtp_username', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('58', 'smtp_password', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('59', 'mail_from_name', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('60', 'mail_from_address', NULL, 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:36:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('61', 'theme_primary', '#0e6ae8', 'general', 'text', '2026-05-29 14:36:55', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('62', 'theme_secondary', '#8b5cf6', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('63', 'theme_accent', '#d946ef', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('64', 'theme_danger', '#ef4444', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('65', 'theme_success', '#7e9905', 'general', 'text', '2026-05-29 14:36:55', '2026-06-02 14:59:24');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('66', 'theme_bg_light', '#f8fafc', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('67', 'theme_bg_dark', '#020617', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('68', 'theme_surface_light', '#ffffff', 'general', 'text', '2026-05-29 14:36:55', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('69', 'theme_surface_dark', '#0f172a', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('70', 'theme_gradient_from', '#0ea5e9', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('71', 'theme_gradient_to', '#d946ef', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('72', 'theme_player_bg', '#1a1a2e', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('73', 'theme_font_fa', 'Vazirmatn', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('74', 'theme_font_en', 'Inter', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('75', 'theme_radius', 'md', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:46:51');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('76', 'premium_banner_enabled', '1', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('77', 'premium_banner_title', 'ملودیام پرمیوم', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('78', 'premium_banner_subtitle', 'بدون تبلیغات / کیفیت بالا', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('79', 'premium_banner_btn_text', 'ارتقا حساب', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('80', 'premium_banner_btn_url', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('81', 'premium_banner_bg_from', '#7408a6', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('82', 'premium_banner_bg_to', '#022a57', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('83', 'premium_banner_text_color', '#f5eaea', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('84', 'premium_banner_image', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('85', 'artist_banner_enabled', '1', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('86', 'artist_banner_title', 'هنرمند شوید!', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:32');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('87', 'artist_banner_subtitle', 'اهنگ های خود را بفروشید.', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:33');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('88', 'artist_banner_btn_text', 'شروع کنید', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:33');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('89', 'artist_banner_btn_url', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('90', 'artist_banner_bg_from', '#174024', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:33');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('91', 'artist_banner_bg_to', '#6ca10d', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:33');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('92', 'artist_banner_text_color', '#ffffff', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:33');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('93', 'artist_banner_image', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('94', 'storage_driver', 'local', 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:41:55');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('95', 's3_key', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('96', 's3_secret', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('97', 's3_region', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('98', 's3_bucket', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('99', 'earnings_payout_description', NULL, 'general', 'text', '2026-05-29 14:36:56', '2026-05-29 14:36:56');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('100', 'zarinpal_merchant', '4b833a56-79a4-11ea-a189-000c295eb8fc', 'general', 'text', '2026-05-29 14:39:47', '2026-06-02 11:31:37');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('101', 'zarinpal_sandbox', '1', 'general', 'text', '2026-05-29 14:39:47', '2026-05-29 14:39:47');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('102', 'sidebar_footer_enabled', '1', 'general', 'text', '2026-05-29 15:02:40', '2026-05-29 15:02:40');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('103', 'sidebar_footer_description', 'تمام حقوق محفوط هست', 'general', 'text', '2026-05-29 15:02:40', '2026-05-29 15:02:40');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('104', 'sidebar_footer_links', '[{\"label\":\"تماس باما\",\"url\":\"http:\\/\\/localhost:8000\\/admin\\/pages\\/create\"}]', 'general', 'text', '2026-05-29 15:02:40', '2026-05-29 15:02:40');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('105', 'smtp_encryption', 'tls', 'general', 'text', '2026-05-29 20:31:36', '2026-05-29 20:31:36');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('106', 'user_upload_enabled', '1', 'general', 'text', '2026-05-30 06:12:50', '2026-05-30 06:12:50');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('107', 'auto_approve_user_content', '0', 'general', 'text', '2026-05-30 08:07:46', '2026-05-30 08:07:46');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('108', 'auth_otp_enabled', '1', 'general', 'text', '2026-05-30 10:58:56', '2026-05-30 20:13:49');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('109', 'auth_password_recovery_otp', '1', 'general', 'text', '2026-05-30 10:58:56', '2026-05-30 20:13:49');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('110', 'admin_notification_mobile', '09356963201', 'general', 'text', '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('111', 'admin_notification_email', 'farnad24@gmail.com', 'general', 'text', '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('112', 'zibal_merchant', 'zibal', 'general', 'text', '2026-06-02 10:56:38', '2026-06-02 10:56:38');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('113', 'email_header_color', '#6366f1', 'general', 'text', '2026-06-02 10:56:38', '2026-06-02 10:56:38');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('114', 'email_footer_text', 'تمام حقوق برای ملودیام محفوط است', 'general', 'text', '2026-06-02 10:56:38', '2026-06-02 14:23:24');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('115', 'payping_token', '', 'general', 'text', '2026-06-02 11:31:37', '2026-06-02 11:31:37');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('116', 'active_gateways', '[\"zarinpal\",\"zibal\"]', 'general', 'text', '2026-06-02 11:31:37', '2026-06-02 11:31:37');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('117', 'theme_warning', '#f59e0b', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('118', 'theme_sidebar_bg_light', '#ffffff', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('119', 'theme_sidebar_bg_dark', '#0f172a', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('120', 'theme_sidebar_text', '#64748b', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('121', 'theme_sidebar_active_bg', '#0ea5e9', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('122', 'theme_sidebar_active_text', '#ffffff', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('123', 'theme_sidebar_border', '#e2e8f0', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('124', 'theme_header_bg_light', '#ffffff', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('125', 'theme_header_bg_dark', '#0f172a', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('126', 'theme_header_border', '#e2e8f0', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('127', 'theme_player_text', '#ffffff', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('128', 'theme_player_control', '#0ea5e9', 'general', 'text', '2026-06-02 14:39:01', '2026-06-02 14:39:01');


-- Table structure for `shares`
DROP TABLE IF EXISTS `shares`;
CREATE TABLE `shares` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `shareable_type` varchar(255) NOT NULL,
  `shareable_id` bigint(20) unsigned NOT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shares_user_id_foreign` (`user_id`),
  KEY `shares_shareable_type_shareable_id_index` (`shareable_type`,`shareable_id`),
  CONSTRAINT `shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `sms_providers`
DROP TABLE IF EXISTS `sms_providers`;
CREATE TABLE `sms_providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `driver` varchar(255) NOT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`credentials`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `streams`
DROP TABLE IF EXISTS `streams`;
CREATE TABLE `streams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `track_id` bigint(20) unsigned NOT NULL,
  `duration_listened` int(10) unsigned NOT NULL DEFAULT 0,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `country` varchar(2) DEFAULT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `streams_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `streams_track_id_created_at_index` (`track_id`,`created_at`),
  CONSTRAINT `streams_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `streams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `subscriptions`
DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `plan_id` bigint(20) unsigned NOT NULL,
  `status` enum('active','expired','cancelled','pending') NOT NULL DEFAULT 'pending',
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `auto_renew` tinyint(1) NOT NULL DEFAULT 1,
  `is_trial` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_plan_id_foreign` (`plan_id`),
  KEY `subscriptions_user_id_status_index` (`user_id`,`status`),
  KEY `subscriptions_expires_at_index` (`expires_at`),
  CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `theme_settings`
DROP TABLE IF EXISTS `theme_settings`;
CREATE TABLE `theme_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `label` varchar(255) DEFAULT NULL,
  `label_fa` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `theme_settings_key_unique` (`key`),
  KEY `theme_settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `tracks`
DROP TABLE IF EXISTS `tracks`;
CREATE TABLE `tracks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` bigint(20) unsigned DEFAULT NULL,
  `artist_name` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `album_id` bigint(20) unsigned DEFAULT NULL,
  `genre_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `duration` int(10) unsigned NOT NULL DEFAULT 0,
  `track_number` smallint(5) unsigned DEFAULT NULL,
  `disc_number` smallint(5) unsigned NOT NULL DEFAULT 1,
  `file_path` varchar(255) DEFAULT NULL,
  `file_path_128` varchar(255) DEFAULT NULL,
  `file_path_320` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `lyrics` text DEFAULT NULL,
  `synced_lyrics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`synced_lyrics`)),
  `language` varchar(5) NOT NULL DEFAULT 'fa',
  `is_explicit` tinyint(1) NOT NULL DEFAULT 0,
  `is_downloadable` tinyint(1) NOT NULL DEFAULT 0,
  `is_premium_only` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `play_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `like_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `download_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `share_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `repost_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `comment_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  `mood` varchar(255) DEFAULT NULL,
  `bpm` varchar(255) DEFAULT NULL,
  `key_signature` varchar(255) DEFAULT NULL,
  `isrc` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `price` decimal(12,0) DEFAULT NULL COMMENT 'قیمت (null = رایگان)',
  `discount_price` decimal(12,0) DEFAULT NULL COMMENT 'قیمت با تخفیف (null = بدون تخفیف)',
  `preview_seconds` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_for_sale` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tracks_slug_unique` (`slug`),
  KEY `tracks_artist_id_foreign` (`artist_id`),
  KEY `tracks_album_id_foreign` (`album_id`),
  KEY `tracks_genre_id_foreign` (`genre_id`),
  KEY `tracks_status_index` (`status`),
  KEY `tracks_release_date_index` (`release_date`),
  KEY `tracks_is_featured_index` (`is_featured`),
  KEY `tracks_play_count_index` (`play_count`),
  KEY `tracks_like_count_index` (`like_count`),
  KEY `tracks_language_index` (`language`),
  KEY `tracks_user_id_foreign` (`user_id`),
  FULLTEXT KEY `tracks_title_title_en_fulltext` (`title`,`title_en`),
  CONSTRAINT `tracks_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tracks_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tracks_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tracks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `country` varchar(2) NOT NULL DEFAULT 'IR',
  `city` varchar(255) DEFAULT NULL,
  `type` enum('listener','artist','admin','moderator') NOT NULL DEFAULT 'listener',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_premium` tinyint(1) NOT NULL DEFAULT 0,
  `premium_expires_at` timestamp NULL DEFAULT NULL,
  `preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferences`)),
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_type_is_active_index` (`type`,`is_active`),
  KEY `users_is_premium_index` (`is_premium`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `wallet_transactions`
DROP TABLE IF EXISTS `wallet_transactions`;
CREATE TABLE `wallet_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint(20) unsigned NOT NULL,
  `type` enum('deposit','withdrawal','purchase','sale_income','refund') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'approved',
  `amount` decimal(12,0) NOT NULL,
  `balance_after` decimal(12,0) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `receipt_image` varchar(255) DEFAULT NULL,
  `admin_note` varchar(255) DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `transactionable_type` varchar(255) DEFAULT NULL,
  `transactionable_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`),
  KEY `wt_transactionable_index` (`transactionable_type`,`transactionable_id`),
  CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Table structure for `wallets`
DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `balance` decimal(12,0) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallets_user_id_unique` (`user_id`),
  CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
