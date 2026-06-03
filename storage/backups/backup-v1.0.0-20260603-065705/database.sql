

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

INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('1', '2', 'track_published', 'App\\Models\\Track', '1', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('2', '2', 'track_published', 'App\\Models\\Track', '2', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('3', '2', 'album_published', 'App\\Models\\Album', '1', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('4', '3', 'track_published', 'App\\Models\\Track', '7', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('5', '3', 'track_published', 'App\\Models\\Track', '8', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('6', '3', 'album_published', 'App\\Models\\Album', '2', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('7', '4', 'track_published', 'App\\Models\\Track', '15', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('8', '4', 'track_published', 'App\\Models\\Track', '16', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('9', '4', 'album_published', 'App\\Models\\Album', '3', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('10', '5', 'track_published', 'App\\Models\\Track', '22', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('11', '5', 'track_published', 'App\\Models\\Track', '23', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('12', '5', 'album_published', 'App\\Models\\Album', '4', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('13', '6', 'track_published', 'App\\Models\\Track', '27', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('14', '6', 'track_published', 'App\\Models\\Track', '28', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('15', '6', 'album_published', 'App\\Models\\Album', '5', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('16', '7', 'track_published', 'App\\Models\\Track', '34', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('17', '7', 'track_published', 'App\\Models\\Track', '35', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('18', '7', 'album_published', 'App\\Models\\Album', '6', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('19', '2', 'reposted', 'App\\Models\\Repost', '1', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('20', '2', 'reposted', 'App\\Models\\Repost', '1', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('21', '3', 'reposted', 'App\\Models\\Repost', '2', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('22', '3', 'reposted', 'App\\Models\\Repost', '2', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('23', '4', 'reposted', 'App\\Models\\Repost', '3', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('24', '4', 'reposted', 'App\\Models\\Repost', '3', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('25', '5', 'reposted', 'App\\Models\\Repost', '4', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('26', '5', 'reposted', 'App\\Models\\Repost', '4', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('27', '6', 'reposted', 'App\\Models\\Repost', '5', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('28', '6', 'reposted', 'App\\Models\\Repost', '5', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('29', '8', 'reposted', 'App\\Models\\Repost', '6', NULL, '2026-05-30 06:30:35', '2026-05-30 06:30:35');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('32', '7', 'reposted', 'App\\Models\\Repost', '9', NULL, '2026-05-30 07:08:50', '2026-05-30 07:08:50');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('33', '8', 'reposted', 'App\\Models\\Repost', '10', NULL, '2026-05-30 07:09:08', '2026-05-30 07:09:08');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('34', '6', 'podcastepisode_published', 'App\\Models\\PodcastEpisode', '2', NULL, '2026-05-30 07:13:33', '2026-05-30 07:13:33');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('40', '7', 'reposted', 'App\\Models\\Repost', '16', NULL, '2026-05-30 07:16:23', '2026-05-30 07:16:23');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('42', '7', 'reposted', 'App\\Models\\Repost', '18', '127.0.0.1', '2026-05-30 07:41:06', '2026-05-30 07:41:06');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('44', '7', 'reposted', 'App\\Models\\Repost', '20', '127.0.0.1', '2026-05-30 07:53:12', '2026-05-30 07:53:12');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('45', '8', 'track_published', 'App\\Models\\Track', '43', '127.0.0.1', '2026-05-30 08:30:08', '2026-05-30 08:30:08');
INSERT INTO `activities` (`id`, `user_id`, `type`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('46', '7', 'reposted', 'App\\Models\\Repost', '21', '127.0.0.1', '2026-05-30 09:47:48', '2026-05-30 09:47:48');


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
) ENGINE=InnoDB AUTO_INCREMENT=1769 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:30:40', '2026-05-29 15:30:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('2', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:30:42', '2026-05-29 15:30:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('3', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:33:51', '2026-05-29 15:33:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('4', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:33:53', '2026-05-29 15:33:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('5', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 15:33:56', '2026-05-29 15:33:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('6', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:34:02', '2026-05-29 15:34:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('7', '2', '7', 'impression', '127.0.0.1', '2026-05-29 15:34:05', '2026-05-29 15:34:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('8', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:09', '2026-05-29 15:34:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('9', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:11', '2026-05-29 15:34:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('10', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 15:34:15', '2026-05-29 15:34:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('11', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:21', '2026-05-29 15:34:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('12', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:23', '2026-05-29 15:34:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('13', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:33', '2026-05-29 15:34:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('14', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:36', '2026-05-29 15:34:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('15', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:37', '2026-05-29 15:34:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('16', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:34:38', '2026-05-29 15:34:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('17', '1', '7', 'impression', '127.0.0.1', '2026-05-29 15:34:40', '2026-05-29 15:34:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('18', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 15:34:42', '2026-05-29 15:34:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('19', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:49', '2026-05-29 15:34:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('20', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:51', '2026-05-29 15:34:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('21', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:58', '2026-05-29 15:34:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('22', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:34:59', '2026-05-29 15:34:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('23', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:35:04', '2026-05-29 15:35:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('24', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:35:07', '2026-05-29 15:35:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('25', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:37:54', '2026-05-29 15:37:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('26', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:37:56', '2026-05-29 15:37:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('27', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 15:38:04', '2026-05-29 15:38:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('28', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:38:07', '2026-05-29 15:38:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('29', '2', '7', 'impression', '127.0.0.1', '2026-05-29 15:38:09', '2026-05-29 15:38:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('30', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:38:11', '2026-05-29 15:38:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('31', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:38:14', '2026-05-29 15:38:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('32', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 15:38:28', '2026-05-29 15:38:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('33', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:38:29', '2026-05-29 15:38:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('34', '1', '7', 'impression', '127.0.0.1', '2026-05-29 15:38:31', '2026-05-29 15:38:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('35', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:38:33', '2026-05-29 15:38:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('36', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:38:35', '2026-05-29 15:38:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('37', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:38:48', '2026-05-29 15:38:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('38', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:38:50', '2026-05-29 15:38:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('39', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:38:57', '2026-05-29 15:38:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('40', '2', '7', 'impression', '127.0.0.1', '2026-05-29 15:38:59', '2026-05-29 15:38:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('41', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 15:39:00', '2026-05-29 15:39:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('42', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:39:01', '2026-05-29 15:39:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('43', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:39:03', '2026-05-29 15:39:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('44', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:39:10', '2026-05-29 15:39:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('45', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:39:12', '2026-05-29 15:39:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('46', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:39:15', '2026-05-29 15:39:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('47', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:39:17', '2026-05-29 15:39:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('48', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:40:56', '2026-05-29 15:40:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('49', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:40:58', '2026-05-29 15:40:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('50', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:41:09', '2026-05-29 15:41:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('51', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:41:12', '2026-05-29 15:41:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('52', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:16', '2026-05-29 15:42:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('53', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:19', '2026-05-29 15:42:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('54', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 15:42:22', '2026-05-29 15:42:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('55', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:42:28', '2026-05-29 15:42:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('56', '1', '7', 'impression', '127.0.0.1', '2026-05-29 15:42:30', '2026-05-29 15:42:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('57', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:34', '2026-05-29 15:42:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('58', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:36', '2026-05-29 15:42:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('59', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 15:42:40', '2026-05-29 15:42:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('60', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:45', '2026-05-29 15:42:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('61', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:47', '2026-05-29 15:42:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('62', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:51', '2026-05-29 15:42:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('63', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:53', '2026-05-29 15:42:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('64', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:56', '2026-05-29 15:42:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('65', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:42:58', '2026-05-29 15:42:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('66', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:03', '2026-05-29 15:47:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('67', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:06', '2026-05-29 15:47:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('68', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:47:07', '2026-05-29 15:47:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('69', '2', '7', 'impression', '127.0.0.1', '2026-05-29 15:47:09', '2026-05-29 15:47:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('70', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 15:47:11', '2026-05-29 15:47:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('71', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:16', '2026-05-29 15:47:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('72', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:18', '2026-05-29 15:47:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('73', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:28', '2026-05-29 15:47:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('74', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 15:47:30', '2026-05-29 15:47:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('75', '3', '7', 'impression', '127.0.0.1', '2026-05-29 15:47:32', '2026-05-29 15:47:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('76', '2', '7', 'impression', '127.0.0.1', '2026-05-29 15:47:34', '2026-05-29 15:47:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('77', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:35', '2026-05-29 15:47:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('78', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:42', '2026-05-29 15:47:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('79', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:44', '2026-05-29 15:47:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('80', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:50', '2026-05-29 15:47:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('81', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:52', '2026-05-29 15:47:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('82', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:56', '2026-05-29 15:47:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('83', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:47:58', '2026-05-29 15:47:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('84', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:53:49', '2026-05-29 15:53:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('85', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:53:52', '2026-05-29 15:53:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('86', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:53:56', '2026-05-29 15:53:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('87', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:53:58', '2026-05-29 15:53:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('88', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:54:25', '2026-05-29 15:54:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('89', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:54:28', '2026-05-29 15:54:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('90', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:55:20', '2026-05-29 15:55:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('91', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:55:22', '2026-05-29 15:55:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('92', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:55:55', '2026-05-29 15:55:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('93', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:55:57', '2026-05-29 15:55:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('94', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:56:14', '2026-05-29 15:56:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('95', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:56:16', '2026-05-29 15:56:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('96', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:56:54', '2026-05-29 15:56:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('97', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:56:57', '2026-05-29 15:56:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('98', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:57:00', '2026-05-29 15:57:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('99', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:57:22', '2026-05-29 15:57:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('100', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:57:25', '2026-05-29 15:57:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('101', '3', '1', 'impression', '127.0.0.1', '2026-05-29 15:57:30', '2026-05-29 15:57:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('102', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:59:06', '2026-05-29 15:59:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('103', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:59:14', '2026-05-29 15:59:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('104', '2', '1', 'impression', '127.0.0.1', '2026-05-29 15:59:19', '2026-05-29 15:59:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('105', '1', '1', 'impression', '127.0.0.1', '2026-05-29 15:59:40', '2026-05-29 15:59:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('106', '2', '7', 'impression', '127.0.0.1', '2026-05-29 16:02:30', '2026-05-29 16:02:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('107', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 16:02:31', '2026-05-29 16:02:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('108', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:02:35', '2026-05-29 16:02:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('109', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 16:02:53', '2026-05-29 16:02:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('110', '2', '7', 'impression', '127.0.0.1', '2026-05-29 16:02:56', '2026-05-29 16:02:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('111', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:02:58', '2026-05-29 16:02:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('112', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 16:03:18', '2026-05-29 16:03:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('113', '1', '7', 'impression', '127.0.0.1', '2026-05-29 16:03:21', '2026-05-29 16:03:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('114', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:03:32', '2026-05-29 16:03:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('115', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 16:03:40', '2026-05-29 16:03:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('116', '2', '7', 'impression', '127.0.0.1', '2026-05-29 16:03:47', '2026-05-29 16:03:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('117', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:03:56', '2026-05-29 16:03:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('118', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:03:59', '2026-05-29 16:03:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('119', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:04:02', '2026-05-29 16:04:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('120', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:04:11', '2026-05-29 16:04:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('121', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:04:17', '2026-05-29 16:04:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('122', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:04:34', '2026-05-29 16:04:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('123', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:04:40', '2026-05-29 16:04:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('124', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:04:48', '2026-05-29 16:04:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('125', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:05:11', '2026-05-29 16:05:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('126', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:05:21', '2026-05-29 16:05:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('127', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:05:29', '2026-05-29 16:05:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('128', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:06:14', '2026-05-29 16:06:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('129', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:07:50', '2026-05-29 16:07:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('130', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 16:07:52', '2026-05-29 16:07:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('131', '2', '7', 'impression', '127.0.0.1', '2026-05-29 16:07:54', '2026-05-29 16:07:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('132', '2', '7', 'impression', '127.0.0.1', '2026-05-29 16:08:12', '2026-05-29 16:08:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('133', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 16:08:20', '2026-05-29 16:08:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('134', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:08:33', '2026-05-29 16:08:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('135', '1', '7', 'impression', '127.0.0.1', '2026-05-29 16:08:47', '2026-05-29 16:08:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('136', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 16:08:48', '2026-05-29 16:08:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('137', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:09:01', '2026-05-29 16:09:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('138', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:09:04', '2026-05-29 16:09:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('139', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:09:14', '2026-05-29 16:09:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('140', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:09:20', '2026-05-29 16:09:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('141', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:09:23', '2026-05-29 16:09:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('142', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:09:24', '2026-05-29 16:09:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('143', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:10:14', '2026-05-29 16:10:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('144', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 16:12:05', '2026-05-29 16:12:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('145', '1', '7', 'impression', '127.0.0.1', '2026-05-29 16:12:08', '2026-05-29 16:12:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('146', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:12:11', '2026-05-29 16:12:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('147', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:12:20', '2026-05-29 16:12:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('148', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:12:26', '2026-05-29 16:12:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('149', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 16:12:51', '2026-05-29 16:12:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('150', '2', '7', 'impression', '127.0.0.1', '2026-05-29 16:12:54', '2026-05-29 16:12:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('151', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:12:58', '2026-05-29 16:12:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('152', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:13:06', '2026-05-29 16:13:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('153', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:13:23', '2026-05-29 16:13:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('154', '1', '7', 'impression', '127.0.0.1', '2026-05-29 16:13:26', '2026-05-29 16:13:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('155', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 16:13:27', '2026-05-29 16:13:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('156', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:13:32', '2026-05-29 16:13:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('157', '1', '1', 'impression', '127.0.0.1', '2026-05-29 16:13:41', '2026-05-29 16:13:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('158', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:13:42', '2026-05-29 16:13:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('159', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 16:15:01', '2026-05-29 16:15:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('160', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:15:07', '2026-05-29 16:15:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('161', '2', '7', 'impression', '127.0.0.1', '2026-05-29 16:15:10', '2026-05-29 16:15:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('162', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:15:17', '2026-05-29 16:15:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('163', '2', '1', 'impression', '127.0.0.1', '2026-05-29 16:15:22', '2026-05-29 16:15:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('164', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:28:24', '2026-05-29 17:28:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('165', '1', '1', 'impression', '127.0.0.1', '2026-05-29 17:30:37', '2026-05-29 17:30:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('166', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:30:38', '2026-05-29 17:30:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('167', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:30:41', '2026-05-29 17:30:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('168', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:30:49', '2026-05-29 17:30:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('169', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:30:51', '2026-05-29 17:30:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('170', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:30:54', '2026-05-29 17:30:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('171', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:31:59', '2026-05-29 17:31:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('172', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:32:56', '2026-05-29 17:32:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('173', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:35:17', '2026-05-29 17:35:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('174', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:35:48', '2026-05-29 17:35:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('175', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:36:25', '2026-05-29 17:36:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('176', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:39:09', '2026-05-29 17:39:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('177', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:39:34', '2026-05-29 17:39:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('178', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:43:42', '2026-05-29 17:43:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('179', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:43:46', '2026-05-29 17:43:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('180', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:43:48', '2026-05-29 17:43:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('181', '1', '1', 'impression', '127.0.0.1', '2026-05-29 17:44:02', '2026-05-29 17:44:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('182', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:44:04', '2026-05-29 17:44:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('183', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:44:05', '2026-05-29 17:44:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('184', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:44:37', '2026-05-29 17:44:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('185', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:44:42', '2026-05-29 17:44:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('186', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:44:43', '2026-05-29 17:44:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('187', '1', '1', 'impression', '127.0.0.1', '2026-05-29 17:45:03', '2026-05-29 17:45:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('188', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:45:04', '2026-05-29 17:45:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('189', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:45:07', '2026-05-29 17:45:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('190', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:46:18', '2026-05-29 17:46:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('191', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:46:22', '2026-05-29 17:46:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('192', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:46:25', '2026-05-29 17:46:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('193', '1', '1', 'impression', '127.0.0.1', '2026-05-29 17:46:32', '2026-05-29 17:46:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('194', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:46:37', '2026-05-29 17:46:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('195', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:46:38', '2026-05-29 17:46:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('196', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:48:59', '2026-05-29 17:48:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('197', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:49:02', '2026-05-29 17:49:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('198', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:49:05', '2026-05-29 17:49:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('199', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:49:17', '2026-05-29 17:49:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('200', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:49:20', '2026-05-29 17:49:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('201', '1', '1', 'impression', '127.0.0.1', '2026-05-29 17:49:24', '2026-05-29 17:49:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('202', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:49:36', '2026-05-29 17:49:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('203', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:49:36', '2026-05-29 17:49:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('204', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:49:44', '2026-05-29 17:49:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('205', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:49:45', '2026-05-29 17:49:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('206', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:49:51', '2026-05-29 17:49:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('207', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:50:12', '2026-05-29 17:50:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('208', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:50:16', '2026-05-29 17:50:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('209', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:50:21', '2026-05-29 17:50:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('210', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:50:27', '2026-05-29 17:50:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('211', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:50:31', '2026-05-29 17:50:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('212', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:50:36', '2026-05-29 17:50:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('213', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:51:36', '2026-05-29 17:51:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('214', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:51:40', '2026-05-29 17:51:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('215', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:51:43', '2026-05-29 17:51:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('216', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:51:51', '2026-05-29 17:51:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('217', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:51:56', '2026-05-29 17:51:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('218', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:52:01', '2026-05-29 17:52:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('219', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:53:49', '2026-05-29 17:53:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('220', '1', '1', 'impression', '127.0.0.1', '2026-05-29 17:56:04', '2026-05-29 17:56:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('221', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:56:05', '2026-05-29 17:56:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('222', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:56:09', '2026-05-29 17:56:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('223', '1', '7', 'impression', '127.0.0.1', '2026-05-29 17:56:24', '2026-05-29 17:56:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('224', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 17:56:26', '2026-05-29 17:56:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('225', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:56:38', '2026-05-29 17:56:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('226', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:56:42', '2026-05-29 17:56:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('227', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:56:45', '2026-05-29 17:56:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('228', '2', '7', 'impression', '127.0.0.1', '2026-05-29 17:56:54', '2026-05-29 17:56:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('229', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 17:56:55', '2026-05-29 17:56:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('230', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:56:57', '2026-05-29 17:56:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('231', '2', '1', 'impression', '127.0.0.1', '2026-05-29 17:57:59', '2026-05-29 17:57:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('232', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:01:49', '2026-05-29 18:01:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('233', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:01:56', '2026-05-29 18:01:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('234', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:01:57', '2026-05-29 18:01:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('235', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:02:05', '2026-05-29 18:02:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('236', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:02:09', '2026-05-29 18:02:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('237', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:02:12', '2026-05-29 18:02:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('238', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:02:15', '2026-05-29 18:02:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('239', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:04:13', '2026-05-29 18:04:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('240', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:04:16', '2026-05-29 18:04:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('241', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:04:19', '2026-05-29 18:04:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('242', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:04:24', '2026-05-29 18:04:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('243', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:10:30', '2026-05-29 18:10:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('244', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:10:34', '2026-05-29 18:10:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('245', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:10:38', '2026-05-29 18:10:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('246', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:10:45', '2026-05-29 18:10:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('247', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:11:21', '2026-05-29 18:11:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('248', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:11:22', '2026-05-29 18:11:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('249', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:11:30', '2026-05-29 18:11:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('250', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:11:51', '2026-05-29 18:11:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('251', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:11:52', '2026-05-29 18:11:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('252', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:11:53', '2026-05-29 18:11:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('253', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:12:14', '2026-05-29 18:12:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('254', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:12:21', '2026-05-29 18:12:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('255', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:12:24', '2026-05-29 18:12:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('256', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:12:43', '2026-05-29 18:12:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('257', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:12:46', '2026-05-29 18:12:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('258', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:12:52', '2026-05-29 18:12:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('259', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:13:02', '2026-05-29 18:13:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('260', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:14:05', '2026-05-29 18:14:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('261', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:14:54', '2026-05-29 18:14:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('262', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:14:59', '2026-05-29 18:14:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('263', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:15:55', '2026-05-29 18:15:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('264', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:17:08', '2026-05-29 18:17:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('265', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:18:13', '2026-05-29 18:18:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('266', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:18:49', '2026-05-29 18:18:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('267', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:25:58', '2026-05-29 18:25:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('268', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:26:02', '2026-05-29 18:26:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('269', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:26:27', '2026-05-29 18:26:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('270', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:26:28', '2026-05-29 18:26:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('271', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 18:26:42', '2026-05-29 18:26:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('272', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:26:45', '2026-05-29 18:26:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('273', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:26:48', '2026-05-29 18:26:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('274', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:29:14', '2026-05-29 18:29:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('275', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:29:21', '2026-05-29 18:29:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('276', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:29:42', '2026-05-29 18:29:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('277', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 18:29:49', '2026-05-29 18:29:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('278', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:30:02', '2026-05-29 18:30:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('279', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 18:30:03', '2026-05-29 18:30:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('280', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:30:22', '2026-05-29 18:30:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('281', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:30:23', '2026-05-29 18:30:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('282', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:30:42', '2026-05-29 18:30:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('283', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:30:45', '2026-05-29 18:30:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('284', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:30:47', '2026-05-29 18:30:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('285', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:34:15', '2026-05-29 18:34:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('286', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:34:18', '2026-05-29 18:34:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('287', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:34:21', '2026-05-29 18:34:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('288', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:35:30', '2026-05-29 18:35:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('289', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:37:11', '2026-05-29 18:37:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('290', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:37:12', '2026-05-29 18:37:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('291', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:37:16', '2026-05-29 18:37:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('292', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:37:39', '2026-05-29 18:37:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('293', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:37:40', '2026-05-29 18:37:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('294', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:37:58', '2026-05-29 18:37:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('295', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:38:04', '2026-05-29 18:38:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('296', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:38:14', '2026-05-29 18:38:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('297', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:43:14', '2026-05-29 18:43:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('298', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:43:15', '2026-05-29 18:43:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('299', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:43:19', '2026-05-29 18:43:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('300', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:43:55', '2026-05-29 18:43:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('301', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:43:57', '2026-05-29 18:43:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('302', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:44:04', '2026-05-29 18:44:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('303', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:44:12', '2026-05-29 18:44:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('304', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 18:44:14', '2026-05-29 18:44:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('305', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:44:25', '2026-05-29 18:44:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('306', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:44:32', '2026-05-29 18:44:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('307', '1', '7', 'impression', '127.0.0.1', '2026-05-29 18:44:35', '2026-05-29 18:44:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('308', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:44:38', '2026-05-29 18:44:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('309', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:48:51', '2026-05-29 18:48:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('310', '1', '1', 'impression', '127.0.0.1', '2026-05-29 18:50:48', '2026-05-29 18:50:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('311', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:50:52', '2026-05-29 18:50:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('312', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 18:50:53', '2026-05-29 18:50:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('313', '2', '1', 'impression', '127.0.0.1', '2026-05-29 18:51:10', '2026-05-29 18:51:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('314', '2', '7', 'impression', '127.0.0.1', '2026-05-29 18:51:13', '2026-05-29 18:51:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('315', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 18:51:14', '2026-05-29 18:51:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('316', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:02:17', '2026-05-29 19:02:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('317', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:02:25', '2026-05-29 19:02:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('318', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:02:29', '2026-05-29 19:02:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('319', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:03:18', '2026-05-29 19:03:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('320', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:03:24', '2026-05-29 19:03:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('321', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:03:25', '2026-05-29 19:03:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('322', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:06:12', '2026-05-29 19:06:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('323', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:06:15', '2026-05-29 19:06:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('324', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:06:18', '2026-05-29 19:06:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('325', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:06:24', '2026-05-29 19:06:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('326', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 19:09:33', '2026-05-29 19:09:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('327', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:09:36', '2026-05-29 19:09:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('328', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:09:42', '2026-05-29 19:09:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('329', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:10:00', '2026-05-29 19:10:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('330', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:10:01', '2026-05-29 19:10:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('331', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:10:19', '2026-05-29 19:10:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('332', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:10:22', '2026-05-29 19:10:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('333', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:10:29', '2026-05-29 19:10:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('334', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:10:44', '2026-05-29 19:10:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('335', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:10:47', '2026-05-29 19:10:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('336', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 19:10:48', '2026-05-29 19:10:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('337', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:15:49', '2026-05-29 19:15:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('338', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:17:08', '2026-05-29 19:17:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('339', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:17:10', '2026-05-29 19:17:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('340', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:17:13', '2026-05-29 19:17:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('341', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:19:08', '2026-05-29 19:19:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('342', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:21:35', '2026-05-29 19:21:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('343', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:21:36', '2026-05-29 19:21:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('344', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:21:39', '2026-05-29 19:21:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('345', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:21:53', '2026-05-29 19:21:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('346', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:21:57', '2026-05-29 19:21:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('347', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:22:03', '2026-05-29 19:22:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('348', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:22:18', '2026-05-29 19:22:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('349', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:22:20', '2026-05-29 19:22:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('350', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:22:23', '2026-05-29 19:22:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('351', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:22:42', '2026-05-29 19:22:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('352', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:24:43', '2026-05-29 19:24:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('353', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:25:18', '2026-05-29 19:25:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('354', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:25:21', '2026-05-29 19:25:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('355', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:25:22', '2026-05-29 19:25:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('356', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:25:40', '2026-05-29 19:25:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('357', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:25:41', '2026-05-29 19:25:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('358', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:25:44', '2026-05-29 19:25:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('359', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:25:58', '2026-05-29 19:25:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('360', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:26:14', '2026-05-29 19:26:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('361', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:26:43', '2026-05-29 19:26:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('362', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:27:00', '2026-05-29 19:27:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('363', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:29:14', '2026-05-29 19:29:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('364', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:29:24', '2026-05-29 19:29:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('365', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:29:27', '2026-05-29 19:29:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('366', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:29:41', '2026-05-29 19:29:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('367', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 19:53:26', '2026-05-29 19:53:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('368', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:53:29', '2026-05-29 19:53:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('369', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:53:35', '2026-05-29 19:53:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('370', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:53:56', '2026-05-29 19:53:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('371', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:53:57', '2026-05-29 19:53:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('372', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:54:16', '2026-05-29 19:54:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('373', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:54:21', '2026-05-29 19:54:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('374', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:54:22', '2026-05-29 19:54:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('375', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:54:38', '2026-05-29 19:54:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('376', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:54:39', '2026-05-29 19:54:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('377', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:54:53', '2026-05-29 19:54:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('378', '1', '7', 'impression', '127.0.0.1', '2026-05-29 19:55:04', '2026-05-29 19:55:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('379', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:55:05', '2026-05-29 19:55:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('380', '1', '1', 'impression', '127.0.0.1', '2026-05-29 19:55:21', '2026-05-29 19:55:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('381', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 19:55:29', '2026-05-29 19:55:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('382', '2', '7', 'impression', '127.0.0.1', '2026-05-29 19:55:34', '2026-05-29 19:55:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('383', '2', '1', 'impression', '127.0.0.1', '2026-05-29 19:55:44', '2026-05-29 19:55:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('384', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:01:23', '2026-05-29 20:01:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('385', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:01:26', '2026-05-29 20:01:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('386', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:01:29', '2026-05-29 20:01:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('387', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:01:44', '2026-05-29 20:01:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('388', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:01:45', '2026-05-29 20:01:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('389', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:02:00', '2026-05-29 20:02:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('390', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:02:09', '2026-05-29 20:02:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('391', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:02:11', '2026-05-29 20:02:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('392', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:02:33', '2026-05-29 20:02:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('393', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:02:34', '2026-05-29 20:02:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('394', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:02:39', '2026-05-29 20:02:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('395', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 20:03:00', '2026-05-29 20:03:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('396', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:03:03', '2026-05-29 20:03:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('397', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:03:12', '2026-05-29 20:03:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('398', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:03:33', '2026-05-29 20:03:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('399', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:03:35', '2026-05-29 20:03:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('400', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:03:51', '2026-05-29 20:03:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('401', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:03:56', '2026-05-29 20:03:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('402', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:03:59', '2026-05-29 20:03:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('403', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 20:08:03', '2026-05-29 20:08:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('404', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:08:06', '2026-05-29 20:08:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('405', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:08:16', '2026-05-29 20:08:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('406', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 20:08:32', '2026-05-29 20:08:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('407', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:08:37', '2026-05-29 20:08:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('408', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 20:08:46', '2026-05-29 20:08:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('409', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:08:55', '2026-05-29 20:08:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('410', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:14:59', '2026-05-29 20:14:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('411', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:15:03', '2026-05-29 20:15:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('412', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:15:06', '2026-05-29 20:15:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('413', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:15:13', '2026-05-29 20:15:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('414', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:17:10', '2026-05-29 20:17:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('415', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:20:26', '2026-05-29 20:20:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('416', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:20:27', '2026-05-29 20:20:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('417', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:20:44', '2026-05-29 20:20:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('418', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:20:55', '2026-05-29 20:20:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('419', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:20:58', '2026-05-29 20:20:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('420', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:21:29', '2026-05-29 20:21:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('421', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:21:33', '2026-05-29 20:21:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('422', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:21:39', '2026-05-29 20:21:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('423', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:21:47', '2026-05-29 20:21:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('424', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:21:53', '2026-05-29 20:21:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('425', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:24:55', '2026-05-29 20:24:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('426', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:25:02', '2026-05-29 20:25:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('427', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:25:05', '2026-05-29 20:25:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('428', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:25:12', '2026-05-29 20:25:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('429', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:25:23', '2026-05-29 20:25:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('430', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:27:42', '2026-05-29 20:27:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('431', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 20:27:46', '2026-05-29 20:27:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('432', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:27:50', '2026-05-29 20:27:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('433', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:28:11', '2026-05-29 20:28:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('434', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:28:12', '2026-05-29 20:28:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('435', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:28:34', '2026-05-29 20:28:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('436', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:28:37', '2026-05-29 20:28:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('437', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:28:38', '2026-05-29 20:28:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('438', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:28:58', '2026-05-29 20:28:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('439', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:29:57', '2026-05-29 20:29:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('440', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:29:59', '2026-05-29 20:29:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('441', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:30:15', '2026-05-29 20:30:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('442', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:30:24', '2026-05-29 20:30:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('443', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:31:57', '2026-05-29 20:31:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('444', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:32:36', '2026-05-29 20:32:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('445', '1', NULL, 'impression', '127.0.0.1', '2026-05-29 20:32:37', '2026-05-29 20:32:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('446', '1', '7', 'impression', '127.0.0.1', '2026-05-29 20:32:40', '2026-05-29 20:32:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('447', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:32:46', '2026-05-29 20:32:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('448', '1', '1', 'impression', '127.0.0.1', '2026-05-29 20:34:12', '2026-05-29 20:34:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('449', '2', NULL, 'impression', '127.0.0.1', '2026-05-29 20:34:19', '2026-05-29 20:34:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('450', '2', '7', 'impression', '127.0.0.1', '2026-05-29 20:34:22', '2026-05-29 20:34:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('451', '2', '1', 'impression', '127.0.0.1', '2026-05-29 20:34:31', '2026-05-29 20:34:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('452', '2', '8', 'impression', '127.0.0.1', '2026-05-30 04:53:09', '2026-05-30 04:53:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('453', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:01:01', '2026-05-30 05:01:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('454', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:28:27', '2026-05-30 05:28:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('455', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:28:33', '2026-05-30 05:28:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('456', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:28:58', '2026-05-30 05:28:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('457', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:29:20', '2026-05-30 05:29:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('458', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:29:55', '2026-05-30 05:29:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('459', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:30:05', '2026-05-30 05:30:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('460', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:30:13', '2026-05-30 05:30:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('461', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:30:23', '2026-05-30 05:30:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('462', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:30:31', '2026-05-30 05:30:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('463', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:34:14', '2026-05-30 05:34:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('464', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:34:23', '2026-05-30 05:34:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('465', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:34:47', '2026-05-30 05:34:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('466', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:35:06', '2026-05-30 05:35:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('467', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:35:14', '2026-05-30 05:35:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('468', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:35:24', '2026-05-30 05:35:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('469', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:35:31', '2026-05-30 05:35:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('470', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:35:40', '2026-05-30 05:35:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('471', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:36:03', '2026-05-30 05:36:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('472', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:36:11', '2026-05-30 05:36:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('473', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:36:58', '2026-05-30 05:36:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('474', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:37:07', '2026-05-30 05:37:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('475', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:37:24', '2026-05-30 05:37:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('476', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:37:42', '2026-05-30 05:37:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('477', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:38:04', '2026-05-30 05:38:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('478', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:38:20', '2026-05-30 05:38:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('479', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:38:27', '2026-05-30 05:38:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('480', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:38:38', '2026-05-30 05:38:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('481', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:38:48', '2026-05-30 05:38:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('482', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:39:03', '2026-05-30 05:39:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('483', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:39:33', '2026-05-30 05:39:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('484', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:39:40', '2026-05-30 05:39:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('485', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:39:47', '2026-05-30 05:39:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('486', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 05:39:55', '2026-05-30 05:39:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('487', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:42:01', '2026-05-30 05:42:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('488', '1', '1', 'impression', '127.0.0.1', '2026-05-30 05:42:57', '2026-05-30 05:42:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('489', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:48:20', '2026-05-30 05:48:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('490', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:48:22', '2026-05-30 05:48:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('491', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 05:49:05', '2026-05-30 05:49:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('492', '1', '8', 'impression', '127.0.0.1', '2026-05-30 05:49:28', '2026-05-30 05:49:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('493', '1', '8', 'impression', '127.0.0.1', '2026-05-30 05:51:45', '2026-05-30 05:51:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('494', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:51:49', '2026-05-30 05:51:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('495', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:51:52', '2026-05-30 05:51:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('496', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:54:07', '2026-05-30 05:54:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('497', '1', '8', 'impression', '127.0.0.1', '2026-05-30 05:54:09', '2026-05-30 05:54:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('498', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:54:22', '2026-05-30 05:54:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('499', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:54:24', '2026-05-30 05:54:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('500', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:54:29', '2026-05-30 05:54:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('501', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:54:31', '2026-05-30 05:54:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('502', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:55:48', '2026-05-30 05:55:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('503', '1', '8', 'impression', '127.0.0.1', '2026-05-30 05:55:52', '2026-05-30 05:55:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('504', '1', '8', 'impression', '127.0.0.1', '2026-05-30 05:56:02', '2026-05-30 05:56:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('505', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:58:32', '2026-05-30 05:58:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('506', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:58:34', '2026-05-30 05:58:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('507', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:58:50', '2026-05-30 05:58:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('508', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:58:51', '2026-05-30 05:58:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('509', '1', '8', 'impression', '127.0.0.1', '2026-05-30 05:59:17', '2026-05-30 05:59:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('510', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:59:19', '2026-05-30 05:59:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('511', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:59:30', '2026-05-30 05:59:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('512', '1', '1', 'impression', '127.0.0.1', '2026-05-30 05:59:31', '2026-05-30 05:59:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('513', '1', '8', 'impression', '127.0.0.1', '2026-05-30 05:59:40', '2026-05-30 05:59:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('514', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:59:41', '2026-05-30 05:59:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('515', '2', '8', 'impression', '127.0.0.1', '2026-05-30 05:59:51', '2026-05-30 05:59:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('516', '2', '1', 'impression', '127.0.0.1', '2026-05-30 05:59:53', '2026-05-30 05:59:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('517', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:00:06', '2026-05-30 06:00:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('518', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:00:08', '2026-05-30 06:00:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('519', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:00:19', '2026-05-30 06:00:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('520', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:00:20', '2026-05-30 06:00:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('521', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:01:22', '2026-05-30 06:01:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('522', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:01:24', '2026-05-30 06:01:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('523', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:02:26', '2026-05-30 06:02:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('524', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:02:32', '2026-05-30 06:02:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('525', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:04:21', '2026-05-30 06:04:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('526', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:04:23', '2026-05-30 06:04:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('527', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:04:34', '2026-05-30 06:04:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('528', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:04:36', '2026-05-30 06:04:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('529', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:04:57', '2026-05-30 06:04:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('530', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:04:59', '2026-05-30 06:04:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('531', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:05:53', '2026-05-30 06:05:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('532', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:09:44', '2026-05-30 06:09:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('533', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:09:47', '2026-05-30 06:09:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('534', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:09:56', '2026-05-30 06:09:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('535', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:09:58', '2026-05-30 06:09:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('536', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:10:27', '2026-05-30 06:10:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('537', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:10:30', '2026-05-30 06:10:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('538', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:10:38', '2026-05-30 06:10:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('539', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:10:40', '2026-05-30 06:10:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('540', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:10:47', '2026-05-30 06:10:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('541', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:10:49', '2026-05-30 06:10:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('542', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:10:54', '2026-05-30 06:10:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('543', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:10:56', '2026-05-30 06:10:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('544', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:11:04', '2026-05-30 06:11:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('545', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:11:06', '2026-05-30 06:11:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('546', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:11:12', '2026-05-30 06:11:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('547', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:11:14', '2026-05-30 06:11:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('548', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:13:04', '2026-05-30 06:13:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('549', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:14:36', '2026-05-30 06:14:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('550', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:14:43', '2026-05-30 06:14:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('551', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:14:51', '2026-05-30 06:14:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('552', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:15:01', '2026-05-30 06:15:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('553', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:15:30', '2026-05-30 06:15:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('554', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:15:38', '2026-05-30 06:15:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('555', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:15:52', '2026-05-30 06:15:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('556', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:18:01', '2026-05-30 06:18:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('557', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:18:04', '2026-05-30 06:18:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('558', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:18:32', '2026-05-30 06:18:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('559', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:18:34', '2026-05-30 06:18:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('560', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:20:31', '2026-05-30 06:20:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('561', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:20:35', '2026-05-30 06:20:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('562', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:20:37', '2026-05-30 06:20:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('563', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:20:57', '2026-05-30 06:20:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('564', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:20:59', '2026-05-30 06:20:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('565', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:21:02', '2026-05-30 06:21:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('566', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:23:04', '2026-05-30 06:23:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('567', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:23:07', '2026-05-30 06:23:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('568', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:23:09', '2026-05-30 06:23:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('569', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:23:15', '2026-05-30 06:23:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('570', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:23:17', '2026-05-30 06:23:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('571', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:23:19', '2026-05-30 06:23:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('572', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:30:45', '2026-05-30 06:30:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('573', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:30:56', '2026-05-30 06:30:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('574', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:32:42', '2026-05-30 06:32:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('575', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:32:44', '2026-05-30 06:32:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('576', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:32:46', '2026-05-30 06:32:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('577', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:33:02', '2026-05-30 06:33:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('578', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:04', '2026-05-30 06:33:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('579', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:07', '2026-05-30 06:33:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('580', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:15', '2026-05-30 06:33:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('581', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:33:17', '2026-05-30 06:33:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('582', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:20', '2026-05-30 06:33:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('583', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:36', '2026-05-30 06:33:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('584', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:33:39', '2026-05-30 06:33:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('585', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:42', '2026-05-30 06:33:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('586', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:50', '2026-05-30 06:33:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('587', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:33:52', '2026-05-30 06:33:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('588', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:33:55', '2026-05-30 06:33:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('589', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:34:02', '2026-05-30 06:34:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('590', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:34:05', '2026-05-30 06:34:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('591', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:34:07', '2026-05-30 06:34:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('592', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:39:31', '2026-05-30 06:39:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('593', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:39:43', '2026-05-30 06:39:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('594', '1', '7', 'impression', '127.0.0.1', '2026-05-30 06:40:35', '2026-05-30 06:40:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('595', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 06:40:46', '2026-05-30 06:40:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('596', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 06:40:55', '2026-05-30 06:40:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('597', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:41:17', '2026-05-30 06:41:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('598', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:41:51', '2026-05-30 06:41:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('599', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:42:08', '2026-05-30 06:42:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('600', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:45:24', '2026-05-30 06:45:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('601', '1', '7', 'impression', '127.0.0.1', '2026-05-30 06:45:28', '2026-05-30 06:45:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('602', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:45:31', '2026-05-30 06:45:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('603', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:45:33', '2026-05-30 06:45:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('604', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:45:39', '2026-05-30 06:45:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('605', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:45:43', '2026-05-30 06:45:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('606', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:45:45', '2026-05-30 06:45:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('607', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:45:47', '2026-05-30 06:45:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('608', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:47:19', '2026-05-30 06:47:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('609', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:47:21', '2026-05-30 06:47:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('610', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:47:30', '2026-05-30 06:47:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('611', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:47:32', '2026-05-30 06:47:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('612', '1', '7', 'impression', '127.0.0.1', '2026-05-30 06:47:34', '2026-05-30 06:47:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('613', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:47:35', '2026-05-30 06:47:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('614', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:47:38', '2026-05-30 06:47:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('615', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:48:28', '2026-05-30 06:48:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('616', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:48:32', '2026-05-30 06:48:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('617', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:48:34', '2026-05-30 06:48:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('618', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:48:36', '2026-05-30 06:48:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('619', '1', '7', 'impression', '127.0.0.1', '2026-05-30 06:48:42', '2026-05-30 06:48:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('620', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:48:44', '2026-05-30 06:48:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('621', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:48:47', '2026-05-30 06:48:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('622', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:48:50', '2026-05-30 06:48:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('623', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:49:12', '2026-05-30 06:49:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('624', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:49:15', '2026-05-30 06:49:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('625', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:49:19', '2026-05-30 06:49:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('626', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:49:21', '2026-05-30 06:49:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('627', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:49:55', '2026-05-30 06:49:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('628', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:49:58', '2026-05-30 06:49:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('629', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:50:01', '2026-05-30 06:50:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('630', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:50:04', '2026-05-30 06:50:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('631', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:50:51', '2026-05-30 06:50:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('632', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:51:36', '2026-05-30 06:51:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('633', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:58:54', '2026-05-30 06:58:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('634', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:58:56', '2026-05-30 06:58:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('635', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:58:59', '2026-05-30 06:58:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('636', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:59:01', '2026-05-30 06:59:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('637', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:59:07', '2026-05-30 06:59:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('638', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:59:09', '2026-05-30 06:59:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('639', '2', '7', 'impression', '127.0.0.1', '2026-05-30 06:59:11', '2026-05-30 06:59:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('640', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:59:13', '2026-05-30 06:59:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('641', '1', '7', 'impression', '127.0.0.1', '2026-05-30 06:59:41', '2026-05-30 06:59:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('642', '1', '8', 'impression', '127.0.0.1', '2026-05-30 06:59:43', '2026-05-30 06:59:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('643', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:59:47', '2026-05-30 06:59:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('644', '2', '8', 'impression', '127.0.0.1', '2026-05-30 06:59:52', '2026-05-30 06:59:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('645', '1', '1', 'impression', '127.0.0.1', '2026-05-30 06:59:55', '2026-05-30 06:59:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('646', '2', '1', 'impression', '127.0.0.1', '2026-05-30 06:59:57', '2026-05-30 06:59:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('647', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:00:00', '2026-05-30 07:00:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('648', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:00:03', '2026-05-30 07:00:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('649', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:00:06', '2026-05-30 07:00:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('650', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:00:11', '2026-05-30 07:00:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('651', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:00:13', '2026-05-30 07:00:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('652', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:00:15', '2026-05-30 07:00:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('653', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:00:17', '2026-05-30 07:00:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('654', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:00:42', '2026-05-30 07:00:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('655', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:00:45', '2026-05-30 07:00:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('656', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:00:47', '2026-05-30 07:00:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('657', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:00:51', '2026-05-30 07:00:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('658', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:00:56', '2026-05-30 07:00:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('659', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:00:58', '2026-05-30 07:00:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('660', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:01', '2026-05-30 07:01:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('661', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:08', '2026-05-30 07:01:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('662', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:01:10', '2026-05-30 07:01:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('663', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:12', '2026-05-30 07:01:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('664', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:01:15', '2026-05-30 07:01:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('665', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:18', '2026-05-30 07:01:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('666', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:01:27', '2026-05-30 07:01:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('667', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:29', '2026-05-30 07:01:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('668', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:31', '2026-05-30 07:01:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('669', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:01:45', '2026-05-30 07:01:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('670', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:48', '2026-05-30 07:01:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('671', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:01:52', '2026-05-30 07:01:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('672', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:01:59', '2026-05-30 07:01:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('673', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:02:03', '2026-05-30 07:02:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('674', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:02:12', '2026-05-30 07:02:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('675', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:02:15', '2026-05-30 07:02:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('676', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:02:18', '2026-05-30 07:02:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('677', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:02:27', '2026-05-30 07:02:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('678', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:02:29', '2026-05-30 07:02:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('679', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:02:31', '2026-05-30 07:02:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('680', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:02:34', '2026-05-30 07:02:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('681', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:02:53', '2026-05-30 07:02:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('682', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:02:56', '2026-05-30 07:02:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('683', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:03:05', '2026-05-30 07:03:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('684', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:03:08', '2026-05-30 07:03:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('685', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:03:11', '2026-05-30 07:03:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('686', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:03:13', '2026-05-30 07:03:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('687', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:06:04', '2026-05-30 07:06:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('688', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:06:06', '2026-05-30 07:06:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('689', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:06:09', '2026-05-30 07:06:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('690', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:06:12', '2026-05-30 07:06:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('691', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:06:14', '2026-05-30 07:06:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('692', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:06:54', '2026-05-30 07:06:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('693', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:06:55', '2026-05-30 07:06:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('694', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:06:57', '2026-05-30 07:06:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('695', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:07:02', '2026-05-30 07:07:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('696', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:07:03', '2026-05-30 07:07:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('697', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:07:09', '2026-05-30 07:07:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('698', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:07:12', '2026-05-30 07:07:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('699', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:07:14', '2026-05-30 07:07:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('700', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:07:17', '2026-05-30 07:07:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('701', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:07:20', '2026-05-30 07:07:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('702', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:07:53', '2026-05-30 07:07:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('703', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:08:29', '2026-05-30 07:08:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('704', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:08:46', '2026-05-30 07:08:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('705', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:08:59', '2026-05-30 07:08:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('706', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:09:24', '2026-05-30 07:09:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('707', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:09:26', '2026-05-30 07:09:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('708', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:10:08', '2026-05-30 07:10:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('709', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:10:34', '2026-05-30 07:10:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('710', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:10:42', '2026-05-30 07:10:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('711', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:13:51', '2026-05-30 07:13:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('712', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:14:17', '2026-05-30 07:14:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('713', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:15:06', '2026-05-30 07:15:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('714', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:15:11', '2026-05-30 07:15:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('715', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:18:19', '2026-05-30 07:18:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('716', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:18:22', '2026-05-30 07:18:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('717', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:18:24', '2026-05-30 07:18:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('718', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:18:27', '2026-05-30 07:18:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('719', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:18:35', '2026-05-30 07:18:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('720', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:18:42', '2026-05-30 07:18:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('721', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:18:45', '2026-05-30 07:18:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('722', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:18:47', '2026-05-30 07:18:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('723', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:18:51', '2026-05-30 07:18:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('724', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:18:54', '2026-05-30 07:18:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('725', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:18:57', '2026-05-30 07:18:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('726', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:18:59', '2026-05-30 07:18:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('727', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:19:01', '2026-05-30 07:19:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('728', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:19:05', '2026-05-30 07:19:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('729', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:19:50', '2026-05-30 07:19:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('730', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:19:52', '2026-05-30 07:19:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('731', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:19:54', '2026-05-30 07:19:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('732', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:19:58', '2026-05-30 07:19:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('733', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:20:01', '2026-05-30 07:20:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('734', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:20:03', '2026-05-30 07:20:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('735', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:20:06', '2026-05-30 07:20:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('736', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:20:08', '2026-05-30 07:20:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('737', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:21:23', '2026-05-30 07:21:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('738', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:21:24', '2026-05-30 07:21:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('739', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:21:28', '2026-05-30 07:21:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('740', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:21:31', '2026-05-30 07:21:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('741', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:21:38', '2026-05-30 07:21:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('742', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:21:39', '2026-05-30 07:21:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('743', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:21:40', '2026-05-30 07:21:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('744', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:21:46', '2026-05-30 07:21:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('745', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:25:02', '2026-05-30 07:25:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('746', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:25:05', '2026-05-30 07:25:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('747', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:25:07', '2026-05-30 07:25:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('748', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:25:13', '2026-05-30 07:25:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('749', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:25:16', '2026-05-30 07:25:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('750', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:25:27', '2026-05-30 07:25:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('751', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:25:28', '2026-05-30 07:25:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('752', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:25:31', '2026-05-30 07:25:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('753', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:25:39', '2026-05-30 07:25:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('754', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:25:46', '2026-05-30 07:25:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('755', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:25:51', '2026-05-30 07:25:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('756', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:25:57', '2026-05-30 07:25:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('757', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:26:02', '2026-05-30 07:26:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('758', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:26:04', '2026-05-30 07:26:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('759', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:26:07', '2026-05-30 07:26:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('760', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:26:07', '2026-05-30 07:26:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('761', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:26:13', '2026-05-30 07:26:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('762', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:26:14', '2026-05-30 07:26:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('763', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:26:16', '2026-05-30 07:26:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('764', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:26:29', '2026-05-30 07:26:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('765', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:26:31', '2026-05-30 07:26:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('766', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:26:34', '2026-05-30 07:26:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('767', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:26:37', '2026-05-30 07:26:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('768', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:26:39', '2026-05-30 07:26:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('769', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:26:55', '2026-05-30 07:26:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('770', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:26:58', '2026-05-30 07:26:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('771', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:27:03', '2026-05-30 07:27:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('772', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:27:18', '2026-05-30 07:27:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('773', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:27:21', '2026-05-30 07:27:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('774', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:27:22', '2026-05-30 07:27:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('775', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:27:26', '2026-05-30 07:27:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('776', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:27:28', '2026-05-30 07:27:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('777', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:27:48', '2026-05-30 07:27:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('778', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:28:03', '2026-05-30 07:28:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('779', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:28:06', '2026-05-30 07:28:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('780', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:28:08', '2026-05-30 07:28:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('781', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:28:11', '2026-05-30 07:28:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('782', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:28:14', '2026-05-30 07:28:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('783', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:28:17', '2026-05-30 07:28:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('784', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:29:07', '2026-05-30 07:29:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('785', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:29:09', '2026-05-30 07:29:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('786', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:29:14', '2026-05-30 07:29:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('787', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:29:20', '2026-05-30 07:29:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('788', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:29:22', '2026-05-30 07:29:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('789', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:29:29', '2026-05-30 07:29:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('790', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:34:29', '2026-05-30 07:34:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('791', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:34:35', '2026-05-30 07:34:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('792', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:34:37', '2026-05-30 07:34:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('793', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:34:43', '2026-05-30 07:34:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('794', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:34:44', '2026-05-30 07:34:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('795', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:34:45', '2026-05-30 07:34:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('796', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:34:50', '2026-05-30 07:34:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('797', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:34:51', '2026-05-30 07:34:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('798', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:36:12', '2026-05-30 07:36:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('799', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:36:12', '2026-05-30 07:36:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('800', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:36:15', '2026-05-30 07:36:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('801', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:36:18', '2026-05-30 07:36:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('802', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:36:20', '2026-05-30 07:36:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('803', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:36:22', '2026-05-30 07:36:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('804', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:36:37', '2026-05-30 07:36:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('805', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:36:39', '2026-05-30 07:36:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('806', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:36:45', '2026-05-30 07:36:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('807', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:36:48', '2026-05-30 07:36:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('808', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:36:54', '2026-05-30 07:36:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('809', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:36:58', '2026-05-30 07:36:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('810', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:37:00', '2026-05-30 07:37:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('811', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:37:02', '2026-05-30 07:37:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('812', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:37:06', '2026-05-30 07:37:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('813', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:37:13', '2026-05-30 07:37:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('814', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:37:16', '2026-05-30 07:37:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('815', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:37:18', '2026-05-30 07:37:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('816', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:37:21', '2026-05-30 07:37:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('817', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:37:23', '2026-05-30 07:37:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('818', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:37:25', '2026-05-30 07:37:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('819', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:37:36', '2026-05-30 07:37:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('820', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:37:38', '2026-05-30 07:37:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('821', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:37:41', '2026-05-30 07:37:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('822', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:37:43', '2026-05-30 07:37:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('823', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:37:47', '2026-05-30 07:37:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('824', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:37:50', '2026-05-30 07:37:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('825', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:37:51', '2026-05-30 07:37:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('826', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:37:54', '2026-05-30 07:37:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('827', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:39:11', '2026-05-30 07:39:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('828', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:40:21', '2026-05-30 07:40:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('829', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:40:32', '2026-05-30 07:40:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('830', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:48:51', '2026-05-30 07:48:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('831', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:48:53', '2026-05-30 07:48:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('832', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:48:58', '2026-05-30 07:48:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('833', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:49:03', '2026-05-30 07:49:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('834', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:49:08', '2026-05-30 07:49:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('835', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:49:10', '2026-05-30 07:49:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('836', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:49:11', '2026-05-30 07:49:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('837', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:49:16', '2026-05-30 07:49:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('838', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:49:19', '2026-05-30 07:49:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('839', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:49:20', '2026-05-30 07:49:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('840', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:49:22', '2026-05-30 07:49:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('841', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:51:34', '2026-05-30 07:51:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('842', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:51:36', '2026-05-30 07:51:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('843', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:51:39', '2026-05-30 07:51:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('844', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:51:42', '2026-05-30 07:51:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('845', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:51:45', '2026-05-30 07:51:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('846', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:51:46', '2026-05-30 07:51:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('847', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:51:48', '2026-05-30 07:51:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('848', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:51:51', '2026-05-30 07:51:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('849', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:52:02', '2026-05-30 07:52:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('850', '1', '1', 'impression', '127.0.0.1', '2026-05-30 07:52:05', '2026-05-30 07:52:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('851', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:52:07', '2026-05-30 07:52:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('852', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:52:13', '2026-05-30 07:52:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('853', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:52:20', '2026-05-30 07:52:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('854', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:52:26', '2026-05-30 07:52:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('855', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:52:31', '2026-05-30 07:52:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('856', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:52:36', '2026-05-30 07:52:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('857', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:52:36', '2026-05-30 07:52:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('858', '1', '7', 'impression', '127.0.0.1', '2026-05-30 07:52:39', '2026-05-30 07:52:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('859', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:52:42', '2026-05-30 07:52:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('860', '2', '1', 'impression', '127.0.0.1', '2026-05-30 07:52:47', '2026-05-30 07:52:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('861', '1', '8', 'impression', '127.0.0.1', '2026-05-30 07:52:50', '2026-05-30 07:52:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('862', '2', '7', 'impression', '127.0.0.1', '2026-05-30 07:53:18', '2026-05-30 07:53:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('863', '2', '8', 'impression', '127.0.0.1', '2026-05-30 07:58:42', '2026-05-30 07:58:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('864', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:01:51', '2026-05-30 08:01:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('865', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:01:53', '2026-05-30 08:01:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('866', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:01:55', '2026-05-30 08:01:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('867', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:02:00', '2026-05-30 08:02:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('868', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:02:08', '2026-05-30 08:02:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('869', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:02:11', '2026-05-30 08:02:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('870', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:02:18', '2026-05-30 08:02:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('871', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:02:26', '2026-05-30 08:02:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('872', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:02:33', '2026-05-30 08:02:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('873', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:02:35', '2026-05-30 08:02:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('874', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:02:37', '2026-05-30 08:02:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('875', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:02:41', '2026-05-30 08:02:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('876', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:02:43', '2026-05-30 08:02:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('877', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:02:45', '2026-05-30 08:02:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('878', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:02:46', '2026-05-30 08:02:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('879', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:03:33', '2026-05-30 08:03:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('880', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:03:35', '2026-05-30 08:03:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('881', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:03:38', '2026-05-30 08:03:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('882', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:03:41', '2026-05-30 08:03:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('883', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:03:44', '2026-05-30 08:03:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('884', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:03:44', '2026-05-30 08:03:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('885', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:03:48', '2026-05-30 08:03:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('886', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:03:52', '2026-05-30 08:03:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('887', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:04:16', '2026-05-30 08:04:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('888', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:04:16', '2026-05-30 08:04:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('889', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:04:27', '2026-05-30 08:04:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('890', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:04:30', '2026-05-30 08:04:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('891', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:04:31', '2026-05-30 08:04:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('892', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:04:34', '2026-05-30 08:04:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('893', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:04:37', '2026-05-30 08:04:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('894', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:04:41', '2026-05-30 08:04:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('895', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:04:42', '2026-05-30 08:04:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('896', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:04:45', '2026-05-30 08:04:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('897', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:04:47', '2026-05-30 08:04:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('898', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:04:49', '2026-05-30 08:04:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('899', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:08:11', '2026-05-30 08:08:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('900', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:09:03', '2026-05-30 08:09:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('901', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:11:19', '2026-05-30 08:11:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('902', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:11:29', '2026-05-30 08:11:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('903', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:18:00', '2026-05-30 08:18:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('904', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:18:02', '2026-05-30 08:18:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('905', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:18:18', '2026-05-30 08:18:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('906', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:18:19', '2026-05-30 08:18:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('907', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:18:20', '2026-05-30 08:18:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('908', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:18:23', '2026-05-30 08:18:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('909', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:18:29', '2026-05-30 08:18:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('910', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:18:31', '2026-05-30 08:18:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('911', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:19:29', '2026-05-30 08:19:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('912', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:19:39', '2026-05-30 08:19:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('913', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:19:42', '2026-05-30 08:19:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('914', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:19:44', '2026-05-30 08:19:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('915', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:19:45', '2026-05-30 08:19:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('916', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:19:47', '2026-05-30 08:19:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('917', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:19:49', '2026-05-30 08:19:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('918', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:19:51', '2026-05-30 08:19:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('919', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:19:55', '2026-05-30 08:19:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('920', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:20:08', '2026-05-30 08:20:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('921', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:20:10', '2026-05-30 08:20:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('922', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:20:12', '2026-05-30 08:20:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('923', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:21:49', '2026-05-30 08:21:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('924', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:21:50', '2026-05-30 08:21:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('925', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:22:00', '2026-05-30 08:22:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('926', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:22:01', '2026-05-30 08:22:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('927', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:22:02', '2026-05-30 08:22:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('928', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:22:05', '2026-05-30 08:22:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('929', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:22:09', '2026-05-30 08:22:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('930', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:22:11', '2026-05-30 08:22:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('931', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:22:13', '2026-05-30 08:22:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('932', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:22:34', '2026-05-30 08:22:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('933', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:22:59', '2026-05-30 08:22:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('934', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:23:20', '2026-05-30 08:23:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('935', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:23:24', '2026-05-30 08:23:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('936', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:23:29', '2026-05-30 08:23:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('937', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:23:32', '2026-05-30 08:23:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('938', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:23:47', '2026-05-30 08:23:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('939', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:23:48', '2026-05-30 08:23:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('940', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:23:51', '2026-05-30 08:23:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('941', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:23:55', '2026-05-30 08:23:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('942', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:23:59', '2026-05-30 08:23:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('943', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:24:00', '2026-05-30 08:24:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('944', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:24:03', '2026-05-30 08:24:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('945', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:24:06', '2026-05-30 08:24:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('946', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:24:08', '2026-05-30 08:24:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('947', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:24:10', '2026-05-30 08:24:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('948', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:24:43', '2026-05-30 08:24:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('949', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:24:46', '2026-05-30 08:24:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('950', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:24:48', '2026-05-30 08:24:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('951', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:24:50', '2026-05-30 08:24:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('952', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:24:51', '2026-05-30 08:24:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('953', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:24:55', '2026-05-30 08:24:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('954', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:24:58', '2026-05-30 08:24:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('955', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:24:59', '2026-05-30 08:24:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('956', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:25:02', '2026-05-30 08:25:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('957', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:26:08', '2026-05-30 08:26:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('958', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:26:11', '2026-05-30 08:26:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('959', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:26:21', '2026-05-30 08:26:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('960', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:26:22', '2026-05-30 08:26:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('961', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:26:24', '2026-05-30 08:26:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('962', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:26:26', '2026-05-30 08:26:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('963', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:26:28', '2026-05-30 08:26:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('964', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:26:30', '2026-05-30 08:26:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('965', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:26:33', '2026-05-30 08:26:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('966', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:26:36', '2026-05-30 08:26:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('967', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:26:39', '2026-05-30 08:26:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('968', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:26:43', '2026-05-30 08:26:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('969', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:27:46', '2026-05-30 08:27:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('970', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:29:32', '2026-05-30 08:29:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('971', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:30:18', '2026-05-30 08:30:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('972', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:30:29', '2026-05-30 08:30:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('973', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:30:40', '2026-05-30 08:30:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('974', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:31:37', '2026-05-30 08:31:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('975', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:31:55', '2026-05-30 08:31:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('976', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:40:17', '2026-05-30 08:40:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('977', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:40:19', '2026-05-30 08:40:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('978', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:40:29', '2026-05-30 08:40:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('979', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:40:31', '2026-05-30 08:40:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('980', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:40:32', '2026-05-30 08:40:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('981', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:40:34', '2026-05-30 08:40:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('982', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:40:46', '2026-05-30 08:40:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('983', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:40:48', '2026-05-30 08:40:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('984', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:40:57', '2026-05-30 08:40:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('985', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:41:21', '2026-05-30 08:41:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('986', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:41:26', '2026-05-30 08:41:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('987', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:41:28', '2026-05-30 08:41:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('988', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:41:34', '2026-05-30 08:41:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('989', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:41:39', '2026-05-30 08:41:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('990', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:41:40', '2026-05-30 08:41:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('991', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:41:43', '2026-05-30 08:41:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('992', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:48:18', '2026-05-30 08:48:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('993', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:48:19', '2026-05-30 08:48:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('994', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:48:29', '2026-05-30 08:48:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('995', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:48:32', '2026-05-30 08:48:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('996', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:48:34', '2026-05-30 08:48:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('997', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:48:40', '2026-05-30 08:48:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('998', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:48:55', '2026-05-30 08:48:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('999', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:49:21', '2026-05-30 08:49:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1000', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:49:38', '2026-05-30 08:49:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1001', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:49:43', '2026-05-30 08:49:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1002', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:49:50', '2026-05-30 08:49:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1003', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:49:51', '2026-05-30 08:49:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1004', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:49:57', '2026-05-30 08:49:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1005', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:50:02', '2026-05-30 08:50:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1006', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:50:06', '2026-05-30 08:50:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1007', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:50:38', '2026-05-30 08:50:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1008', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:50:45', '2026-05-30 08:50:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1009', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:50:46', '2026-05-30 08:50:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1010', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:50:51', '2026-05-30 08:50:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1011', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:50:56', '2026-05-30 08:50:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1012', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:50:58', '2026-05-30 08:50:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1013', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:51:04', '2026-05-30 08:51:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1014', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:51:06', '2026-05-30 08:51:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1015', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:51:11', '2026-05-30 08:51:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1016', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:51:14', '2026-05-30 08:51:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1017', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:52:04', '2026-05-30 08:52:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1018', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:53:26', '2026-05-30 08:53:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1019', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:53:30', '2026-05-30 08:53:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1020', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:53:39', '2026-05-30 08:53:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1021', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:53:41', '2026-05-30 08:53:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1022', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:53:43', '2026-05-30 08:53:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1023', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:53:45', '2026-05-30 08:53:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1024', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:53:45', '2026-05-30 08:53:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1025', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:53:51', '2026-05-30 08:53:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1026', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:53:52', '2026-05-30 08:53:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1027', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:53:53', '2026-05-30 08:53:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1028', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:53:56', '2026-05-30 08:53:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1029', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:54:07', '2026-05-30 08:54:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1030', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:54:14', '2026-05-30 08:54:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1031', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:54:17', '2026-05-30 08:54:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1032', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:54:23', '2026-05-30 08:54:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1033', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:54:30', '2026-05-30 08:54:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1034', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:54:33', '2026-05-30 08:54:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1035', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:54:38', '2026-05-30 08:54:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1036', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:54:42', '2026-05-30 08:54:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1037', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:54:44', '2026-05-30 08:54:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1038', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:54:45', '2026-05-30 08:54:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1039', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:54:47', '2026-05-30 08:54:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1040', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:54:49', '2026-05-30 08:54:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1041', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:54:53', '2026-05-30 08:54:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1042', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:54:56', '2026-05-30 08:54:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1043', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:54:58', '2026-05-30 08:54:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1044', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:55:15', '2026-05-30 08:55:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1045', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:55:18', '2026-05-30 08:55:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1046', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:55:21', '2026-05-30 08:55:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1047', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:55:23', '2026-05-30 08:55:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1048', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:55:24', '2026-05-30 08:55:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1049', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:55:26', '2026-05-30 08:55:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1050', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:55:29', '2026-05-30 08:55:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1051', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:55:31', '2026-05-30 08:55:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1052', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:55:49', '2026-05-30 08:55:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1053', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:56:00', '2026-05-30 08:56:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1054', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:56:09', '2026-05-30 08:56:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1055', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:56:17', '2026-05-30 08:56:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1056', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:56:19', '2026-05-30 08:56:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1057', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:56:24', '2026-05-30 08:56:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1058', '1', '1', 'impression', '127.0.0.1', '2026-05-30 08:56:26', '2026-05-30 08:56:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1059', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:56:30', '2026-05-30 08:56:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1060', '1', '7', 'impression', '127.0.0.1', '2026-05-30 08:56:31', '2026-05-30 08:56:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1061', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:56:33', '2026-05-30 08:56:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1062', '2', '1', 'impression', '127.0.0.1', '2026-05-30 08:56:34', '2026-05-30 08:56:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1063', '2', '7', 'impression', '127.0.0.1', '2026-05-30 08:56:41', '2026-05-30 08:56:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1064', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:56:43', '2026-05-30 08:56:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1065', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:56:44', '2026-05-30 08:56:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1066', '1', '8', 'impression', '127.0.0.1', '2026-05-30 08:56:47', '2026-05-30 08:56:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1067', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:56:51', '2026-05-30 08:56:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1068', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:57:01', '2026-05-30 08:57:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1069', '2', '8', 'impression', '127.0.0.1', '2026-05-30 08:58:50', '2026-05-30 08:58:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1070', '2', '1', 'impression', '127.0.0.1', '2026-05-30 09:00:03', '2026-05-30 09:00:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1071', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:00:07', '2026-05-30 09:00:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1072', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:00:08', '2026-05-30 09:00:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1073', '2', '1', 'impression', '127.0.0.1', '2026-05-30 09:00:12', '2026-05-30 09:00:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1074', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:00:14', '2026-05-30 09:00:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1075', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:00:16', '2026-05-30 09:00:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1076', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:00:19', '2026-05-30 09:00:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1077', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:00:47', '2026-05-30 09:00:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1078', '2', '1', 'impression', '127.0.0.1', '2026-05-30 09:01:03', '2026-05-30 09:01:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1079', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:01:09', '2026-05-30 09:01:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1080', '2', '1', 'impression', '127.0.0.1', '2026-05-30 09:01:19', '2026-05-30 09:01:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1081', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:01:21', '2026-05-30 09:01:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1082', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:01:23', '2026-05-30 09:01:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1083', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:01:27', '2026-05-30 09:01:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1084', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:01:51', '2026-05-30 09:01:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1085', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:02:19', '2026-05-30 09:02:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1086', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:02:21', '2026-05-30 09:02:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1087', '2', '1', 'impression', '127.0.0.1', '2026-05-30 09:02:23', '2026-05-30 09:02:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1088', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:02:31', '2026-05-30 09:02:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1089', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:03:02', '2026-05-30 09:03:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1090', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:06', '2026-05-30 09:03:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1091', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:07', '2026-05-30 09:03:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1092', '1', '1', 'impression', '127.0.0.1', '2026-05-30 09:03:15', '2026-05-30 09:03:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1093', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:20', '2026-05-30 09:03:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1094', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:03:25', '2026-05-30 09:03:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1095', '1', '1', 'impression', '127.0.0.1', '2026-05-30 09:03:26', '2026-05-30 09:03:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1096', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:03:29', '2026-05-30 09:03:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1097', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:32', '2026-05-30 09:03:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1098', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:03:35', '2026-05-30 09:03:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1099', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:40', '2026-05-30 09:03:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1100', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:41', '2026-05-30 09:03:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1101', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:03:47', '2026-05-30 09:03:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1102', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:49', '2026-05-30 09:03:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1103', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:03:57', '2026-05-30 09:03:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1104', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:04:02', '2026-05-30 09:04:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1105', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:04:51', '2026-05-30 09:04:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1106', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:39:29', '2026-05-30 09:39:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1107', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:39:31', '2026-05-30 09:39:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1108', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:39:41', '2026-05-30 09:39:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1109', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:39:43', '2026-05-30 09:39:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1110', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:39:45', '2026-05-30 09:39:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1111', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:40:27', '2026-05-30 09:40:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1112', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:40:30', '2026-05-30 09:40:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1113', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:40:32', '2026-05-30 09:40:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1114', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:40:50', '2026-05-30 09:40:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1115', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:40:53', '2026-05-30 09:40:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1116', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:40:54', '2026-05-30 09:40:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1117', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:41:35', '2026-05-30 09:41:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1118', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:41:39', '2026-05-30 09:41:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1119', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:41:41', '2026-05-30 09:41:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1120', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:42:34', '2026-05-30 09:42:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1121', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:42:48', '2026-05-30 09:42:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1122', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:43:28', '2026-05-30 09:43:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1123', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:43:34', '2026-05-30 09:43:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1124', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:07', '2026-05-30 09:46:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1125', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:09', '2026-05-30 09:46:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1126', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:12', '2026-05-30 09:46:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1127', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:22', '2026-05-30 09:46:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1128', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:23', '2026-05-30 09:46:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1129', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:24', '2026-05-30 09:46:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1130', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:30', '2026-05-30 09:46:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1131', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:33', '2026-05-30 09:46:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1132', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:35', '2026-05-30 09:46:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1133', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:47', '2026-05-30 09:46:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1134', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:51', '2026-05-30 09:46:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1135', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:46:56', '2026-05-30 09:46:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1136', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:47:01', '2026-05-30 09:47:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1137', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:47:09', '2026-05-30 09:47:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1138', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:47:13', '2026-05-30 09:47:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1139', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:47:36', '2026-05-30 09:47:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1140', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:47:58', '2026-05-30 09:47:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1141', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:48:11', '2026-05-30 09:48:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1142', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:48:37', '2026-05-30 09:48:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1143', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:49:05', '2026-05-30 09:49:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1144', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:49:32', '2026-05-30 09:49:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1145', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:51:20', '2026-05-30 09:51:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1146', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:52:40', '2026-05-30 09:52:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1147', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:52:55', '2026-05-30 09:52:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1148', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:53:01', '2026-05-30 09:53:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1149', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:53:08', '2026-05-30 09:53:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1150', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:58:27', '2026-05-30 09:58:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1151', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:58:29', '2026-05-30 09:58:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1152', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:58:32', '2026-05-30 09:58:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1153', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:58:34', '2026-05-30 09:58:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1154', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:59:13', '2026-05-30 09:59:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1155', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:59:16', '2026-05-30 09:59:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1156', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:59:20', '2026-05-30 09:59:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1157', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:59:34', '2026-05-30 09:59:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1158', '2', '8', 'impression', '127.0.0.1', '2026-05-30 09:59:36', '2026-05-30 09:59:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1159', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:59:43', '2026-05-30 09:59:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1160', '1', '8', 'impression', '127.0.0.1', '2026-05-30 09:59:50', '2026-05-30 09:59:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1161', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:59:53', '2026-05-30 09:59:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1162', '1', '7', 'impression', '127.0.0.1', '2026-05-30 09:59:56', '2026-05-30 09:59:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1163', '2', '7', 'impression', '127.0.0.1', '2026-05-30 09:59:58', '2026-05-30 09:59:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1164', '1', '8', 'impression', '127.0.0.1', '2026-05-30 10:00:07', '2026-05-30 10:00:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1165', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:00:10', '2026-05-30 10:00:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1166', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:00:12', '2026-05-30 10:00:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1167', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:00:15', '2026-05-30 10:00:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1168', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:00:24', '2026-05-30 10:00:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1169', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:00:27', '2026-05-30 10:00:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1170', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:00:30', '2026-05-30 10:00:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1171', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:01:10', '2026-05-30 10:01:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1172', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:01:15', '2026-05-30 10:01:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1173', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:01:16', '2026-05-30 10:01:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1174', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:01:22', '2026-05-30 10:01:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1175', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:01:27', '2026-05-30 10:01:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1176', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:01:31', '2026-05-30 10:01:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1177', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:13:43', '2026-05-30 10:13:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1178', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:13:46', '2026-05-30 10:13:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1179', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:13:51', '2026-05-30 10:13:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1180', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:14:38', '2026-05-30 10:14:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1181', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:14:42', '2026-05-30 10:14:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1182', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:14:49', '2026-05-30 10:14:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1183', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:14:59', '2026-05-30 10:14:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1184', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:15:01', '2026-05-30 10:15:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1185', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:15:04', '2026-05-30 10:15:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1186', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:15:30', '2026-05-30 10:15:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1187', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:15:35', '2026-05-30 10:15:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1188', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:15:38', '2026-05-30 10:15:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1189', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:17:29', '2026-05-30 10:17:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1190', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:17:31', '2026-05-30 10:17:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1191', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:17:34', '2026-05-30 10:17:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1192', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:06', '2026-05-30 10:18:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1193', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:08', '2026-05-30 10:18:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1194', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:17', '2026-05-30 10:18:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1195', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:20', '2026-05-30 10:18:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1196', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:30', '2026-05-30 10:18:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1197', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:36', '2026-05-30 10:18:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1198', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:42', '2026-05-30 10:18:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1199', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:18:43', '2026-05-30 10:18:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1200', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:22:39', '2026-05-30 10:22:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1201', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:22:41', '2026-05-30 10:22:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1202', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:22:44', '2026-05-30 10:22:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1203', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:22:52', '2026-05-30 10:22:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1204', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:22:57', '2026-05-30 10:22:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1205', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:03', '2026-05-30 10:23:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1206', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:07', '2026-05-30 10:23:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1207', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:08', '2026-05-30 10:23:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1208', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:21', '2026-05-30 10:23:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1209', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:24', '2026-05-30 10:23:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1210', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:33', '2026-05-30 10:23:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1211', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:40', '2026-05-30 10:23:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1212', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:23:45', '2026-05-30 10:23:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1213', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:24:21', '2026-05-30 10:24:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1214', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:24:25', '2026-05-30 10:24:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1215', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:24:28', '2026-05-30 10:24:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1216', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:24:36', '2026-05-30 10:24:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1217', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:24:43', '2026-05-30 10:24:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1218', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:24:44', '2026-05-30 10:24:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1219', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:33:58', '2026-05-30 10:33:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1220', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:34:03', '2026-05-30 10:34:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1221', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:34:06', '2026-05-30 10:34:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1222', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:35:26', '2026-05-30 10:35:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1223', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:35:36', '2026-05-30 10:35:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1224', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:35:45', '2026-05-30 10:35:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1225', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:35:48', '2026-05-30 10:35:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1226', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:35:51', '2026-05-30 10:35:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1227', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:36:02', '2026-05-30 10:36:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1228', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:36:05', '2026-05-30 10:36:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1229', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:36:08', '2026-05-30 10:36:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1230', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:23', '2026-05-30 10:37:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1231', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:27', '2026-05-30 10:37:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1232', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:31', '2026-05-30 10:37:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1233', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:38', '2026-05-30 10:37:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1234', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:42', '2026-05-30 10:37:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1235', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:49', '2026-05-30 10:37:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1236', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:52', '2026-05-30 10:37:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1237', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:37:58', '2026-05-30 10:37:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1238', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:48:50', '2026-05-30 10:48:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1239', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:48:52', '2026-05-30 10:48:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1240', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:48:54', '2026-05-30 10:48:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1241', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:49:05', '2026-05-30 10:49:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1242', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:49:09', '2026-05-30 10:49:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1243', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:49:13', '2026-05-30 10:49:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1244', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:49:21', '2026-05-30 10:49:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1245', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:49:26', '2026-05-30 10:49:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1246', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:49:29', '2026-05-30 10:49:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1247', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:56:33', '2026-05-30 10:56:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1248', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:56:39', '2026-05-30 10:56:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1249', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:56:47', '2026-05-30 10:56:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1250', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:56:52', '2026-05-30 10:56:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1251', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:56:56', '2026-05-30 10:56:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1252', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:57:04', '2026-05-30 10:57:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1253', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:57:07', '2026-05-30 10:57:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1254', '2', '7', 'impression', '127.0.0.1', '2026-05-30 10:57:17', '2026-05-30 10:57:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1255', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:57:24', '2026-05-30 10:57:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1256', '1', '7', 'impression', '127.0.0.1', '2026-05-30 10:57:26', '2026-05-30 10:57:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1257', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:01:46', '2026-05-30 11:01:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1258', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:09:20', '2026-05-30 11:09:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1259', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:09:22', '2026-05-30 11:09:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1260', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:09:25', '2026-05-30 11:09:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1261', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:09:32', '2026-05-30 11:09:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1262', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:09:40', '2026-05-30 11:09:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1263', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:09:52', '2026-05-30 11:09:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1264', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:09:55', '2026-05-30 11:09:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1265', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:09:58', '2026-05-30 11:09:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1266', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:10:04', '2026-05-30 11:10:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1267', '1', '1', 'impression', '127.0.0.1', '2026-05-30 11:14:44', '2026-05-30 11:14:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1268', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:14:46', '2026-05-30 11:14:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1269', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:14:52', '2026-05-30 11:14:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1270', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:14:53', '2026-05-30 11:14:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1271', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:15:01', '2026-05-30 11:15:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1272', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:15:07', '2026-05-30 11:15:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1273', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:15:15', '2026-05-30 11:15:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1274', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:15:17', '2026-05-30 11:15:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1275', '1', '1', 'impression', '127.0.0.1', '2026-05-30 11:15:44', '2026-05-30 11:15:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1276', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:15:52', '2026-05-30 11:15:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1277', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:15:57', '2026-05-30 11:15:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1278', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:16:03', '2026-05-30 11:16:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1279', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:16:05', '2026-05-30 11:16:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1280', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:16:09', '2026-05-30 11:16:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1281', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:16:18', '2026-05-30 11:16:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1282', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:16:20', '2026-05-30 11:16:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1283', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:16:31', '2026-05-30 11:16:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1284', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:16:32', '2026-05-30 11:16:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1285', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:16:35', '2026-05-30 11:16:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1286', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:16:41', '2026-05-30 11:16:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1287', '1', '1', 'impression', '127.0.0.1', '2026-05-30 11:20:04', '2026-05-30 11:20:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1288', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:20:11', '2026-05-30 11:20:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1289', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:20:14', '2026-05-30 11:20:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1290', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:20:17', '2026-05-30 11:20:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1291', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:21:40', '2026-05-30 11:21:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1292', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:21:43', '2026-05-30 11:21:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1293', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:21:47', '2026-05-30 11:21:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1294', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:21:50', '2026-05-30 11:21:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1295', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:23:01', '2026-05-30 11:23:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1296', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:23:06', '2026-05-30 11:23:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1297', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:23:09', '2026-05-30 11:23:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1298', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:23:12', '2026-05-30 11:23:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1299', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:23:25', '2026-05-30 11:23:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1300', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:23:29', '2026-05-30 11:23:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1301', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:23:33', '2026-05-30 11:23:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1302', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:23:36', '2026-05-30 11:23:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1303', '1', '1', 'impression', '127.0.0.1', '2026-05-30 11:24:44', '2026-05-30 11:24:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1304', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:24:47', '2026-05-30 11:24:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1305', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:24:49', '2026-05-30 11:24:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1306', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:24:55', '2026-05-30 11:24:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1307', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:24:58', '2026-05-30 11:24:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1308', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:25:02', '2026-05-30 11:25:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1309', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:25:08', '2026-05-30 11:25:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1310', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:25:11', '2026-05-30 11:25:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1311', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:25:15', '2026-05-30 11:25:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1312', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:25:28', '2026-05-30 11:25:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1313', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:25:34', '2026-05-30 11:25:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1314', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:25:38', '2026-05-30 11:25:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1315', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:25:41', '2026-05-30 11:25:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1316', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:25:47', '2026-05-30 11:25:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1317', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:25:53', '2026-05-30 11:25:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1318', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:25:56', '2026-05-30 11:25:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1319', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:26:03', '2026-05-30 11:26:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1320', '1', '1', 'impression', '127.0.0.1', '2026-05-30 11:26:10', '2026-05-30 11:26:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1321', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:26:16', '2026-05-30 11:26:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1322', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:26:18', '2026-05-30 11:26:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1323', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:26:21', '2026-05-30 11:26:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1324', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:27:37', '2026-05-30 11:27:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1325', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:27:41', '2026-05-30 11:27:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1326', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:27:44', '2026-05-30 11:27:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1327', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:27:48', '2026-05-30 11:27:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1328', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:27:54', '2026-05-30 11:27:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1329', '1', '7', 'impression', '127.0.0.1', '2026-05-30 11:27:58', '2026-05-30 11:27:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1330', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:28:05', '2026-05-30 11:28:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1331', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:28:08', '2026-05-30 11:28:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1332', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:29:24', '2026-05-30 11:29:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1333', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:29:28', '2026-05-30 11:29:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1334', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:29:33', '2026-05-30 11:29:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1335', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:29:36', '2026-05-30 11:29:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1336', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:30:27', '2026-05-30 11:30:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1337', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:32:06', '2026-05-30 11:32:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1338', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:32:08', '2026-05-30 11:32:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1339', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:32:14', '2026-05-30 11:32:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1340', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:32:15', '2026-05-30 11:32:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1341', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:32:19', '2026-05-30 11:32:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1342', '2', '1', 'impression', '127.0.0.1', '2026-05-30 11:32:27', '2026-05-30 11:32:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1343', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:32:29', '2026-05-30 11:32:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1344', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:32:32', '2026-05-30 11:32:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1345', '2', '7', 'impression', '127.0.0.1', '2026-05-30 11:32:35', '2026-05-30 11:32:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1346', '2', '8', 'impression', '127.0.0.1', '2026-05-30 19:36:34', '2026-05-30 19:36:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1347', '2', '8', 'impression', '127.0.0.1', '2026-05-30 19:41:32', '2026-05-30 19:41:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1348', '2', '1', 'impression', '127.0.0.1', '2026-05-30 19:41:37', '2026-05-30 19:41:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1349', '1', '7', 'impression', '127.0.0.1', '2026-05-30 19:41:41', '2026-05-30 19:41:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1350', '2', '7', 'impression', '127.0.0.1', '2026-05-30 19:41:44', '2026-05-30 19:41:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1351', '2', '7', 'impression', '127.0.0.1', '2026-05-30 19:41:46', '2026-05-30 19:41:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1352', '1', '1', 'impression', '127.0.0.1', '2026-05-30 19:43:13', '2026-05-30 19:43:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1353', '2', '7', 'impression', '127.0.0.1', '2026-05-30 19:52:24', '2026-05-30 19:52:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1354', '1', '1', 'impression', '127.0.0.1', '2026-05-30 19:52:27', '2026-05-30 19:52:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1355', '1', '8', 'impression', '127.0.0.1', '2026-05-30 19:52:28', '2026-05-30 19:52:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1356', '2', '7', 'impression', '127.0.0.1', '2026-05-30 19:52:31', '2026-05-30 19:52:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1357', '2', '7', 'impression', '127.0.0.1', '2026-05-30 19:52:32', '2026-05-30 19:52:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1358', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:02:11', '2026-05-30 20:02:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1359', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:02:12', '2026-05-30 20:02:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1360', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:02:14', '2026-05-30 20:02:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1361', '1', '8', 'impression', '127.0.0.1', '2026-05-30 20:02:17', '2026-05-30 20:02:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1362', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:02:20', '2026-05-30 20:02:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1363', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:02:26', '2026-05-30 20:02:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1364', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:02:33', '2026-05-30 20:02:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1365', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:02:40', '2026-05-30 20:02:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1366', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:02:43', '2026-05-30 20:02:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1367', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:02:45', '2026-05-30 20:02:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1368', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:02:45', '2026-05-30 20:02:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1369', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:02:49', '2026-05-30 20:02:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1370', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:06:10', '2026-05-30 20:06:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1371', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:06:16', '2026-05-30 20:06:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1372', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:06:17', '2026-05-30 20:06:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1373', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:06:19', '2026-05-30 20:06:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1374', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:06:22', '2026-05-30 20:06:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1375', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:10:31', '2026-05-30 20:10:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1376', '1', '8', 'impression', '127.0.0.1', '2026-05-30 20:10:35', '2026-05-30 20:10:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1377', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:10:39', '2026-05-30 20:10:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1378', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:10:42', '2026-05-30 20:10:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1379', '1', '1', 'impression', '127.0.0.1', '2026-05-30 20:10:53', '2026-05-30 20:10:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1380', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:10:54', '2026-05-30 20:10:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1381', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:11:00', '2026-05-30 20:11:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1382', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:11:01', '2026-05-30 20:11:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1383', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:11:06', '2026-05-30 20:11:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1384', '1', NULL, 'impression', '127.0.0.1', '2026-05-30 20:14:36', '2026-05-30 20:14:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1385', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 20:14:40', '2026-05-30 20:14:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1386', '1', '9', 'impression', '127.0.0.1', '2026-05-30 20:15:45', '2026-05-30 20:15:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1387', '1', '9', 'impression', '127.0.0.1', '2026-05-30 20:20:09', '2026-05-30 20:20:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1388', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:20:11', '2026-05-30 20:20:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1389', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:20:16', '2026-05-30 20:20:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1390', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:20:17', '2026-05-30 20:20:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1391', '2', '9', 'impression', '127.0.0.1', '2026-05-30 20:20:27', '2026-05-30 20:20:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1392', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:20:32', '2026-05-30 20:20:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1393', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:20:32', '2026-05-30 20:20:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1394', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:20:35', '2026-05-30 20:20:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1395', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:20:40', '2026-05-30 20:20:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1396', '2', '9', 'impression', '127.0.0.1', '2026-05-30 20:20:44', '2026-05-30 20:20:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1397', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:20:46', '2026-05-30 20:20:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1398', '1', '1', 'impression', '127.0.0.1', '2026-05-30 20:20:52', '2026-05-30 20:20:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1399', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:20:55', '2026-05-30 20:20:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1400', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:20:57', '2026-05-30 20:20:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1401', '2', '9', 'impression', '127.0.0.1', '2026-05-30 20:21:00', '2026-05-30 20:21:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1402', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:21:02', '2026-05-30 20:21:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1403', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:21:04', '2026-05-30 20:21:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1404', '1', '9', 'impression', '127.0.0.1', '2026-05-30 20:21:14', '2026-05-30 20:21:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1405', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:21:16', '2026-05-30 20:21:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1406', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:21:17', '2026-05-30 20:21:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1407', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:21:22', '2026-05-30 20:21:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1408', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:21:22', '2026-05-30 20:21:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1409', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:21:25', '2026-05-30 20:21:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1410', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:21:37', '2026-05-30 20:21:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1411', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:21:39', '2026-05-30 20:21:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1412', '2', '9', 'impression', '127.0.0.1', '2026-05-30 20:21:42', '2026-05-30 20:21:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1413', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:21:47', '2026-05-30 20:21:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1414', '2', '9', 'impression', '127.0.0.1', '2026-05-30 20:21:57', '2026-05-30 20:21:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1415', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:03', '2026-05-30 20:22:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1416', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:08', '2026-05-30 20:22:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1417', '2', '9', 'impression', '127.0.0.1', '2026-05-30 20:22:12', '2026-05-30 20:22:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1418', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:17', '2026-05-30 20:22:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1419', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:22:20', '2026-05-30 20:22:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1420', '2', '9', 'impression', '127.0.0.1', '2026-05-30 20:22:23', '2026-05-30 20:22:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1421', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:26', '2026-05-30 20:22:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1422', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:27', '2026-05-30 20:22:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1423', '1', '8', 'impression', '127.0.0.1', '2026-05-30 20:22:30', '2026-05-30 20:22:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1424', '1', '9', 'impression', '127.0.0.1', '2026-05-30 20:22:39', '2026-05-30 20:22:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1425', '1', '1', 'impression', '127.0.0.1', '2026-05-30 20:22:44', '2026-05-30 20:22:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1426', '1', '8', 'impression', '127.0.0.1', '2026-05-30 20:22:46', '2026-05-30 20:22:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1427', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:47', '2026-05-30 20:22:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1428', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:49', '2026-05-30 20:22:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1429', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:22:53', '2026-05-30 20:22:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1430', '2', NULL, 'impression', '127.0.0.1', '2026-05-30 20:29:53', '2026-05-30 20:29:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1431', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:32:59', '2026-05-30 20:32:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1432', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:33:12', '2026-05-30 20:33:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1433', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:33:25', '2026-05-30 20:33:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1434', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:33:34', '2026-05-30 20:33:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1435', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:33:37', '2026-05-30 20:33:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1436', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:33:41', '2026-05-30 20:33:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1437', '1', '1', 'impression', '127.0.0.1', '2026-05-30 20:33:42', '2026-05-30 20:33:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1438', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:33:47', '2026-05-30 20:33:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1439', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:33:54', '2026-05-30 20:33:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1440', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:33:56', '2026-05-30 20:33:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1441', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:34:00', '2026-05-30 20:34:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1442', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:34:03', '2026-05-30 20:34:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1443', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:34:07', '2026-05-30 20:34:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1444', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:35:29', '2026-05-30 20:35:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1445', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:35:32', '2026-05-30 20:35:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1446', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:35:34', '2026-05-30 20:35:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1447', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:35:37', '2026-05-30 20:35:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1448', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:35:40', '2026-05-30 20:35:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1449', '2', '7', 'impression', '127.0.0.1', '2026-05-30 20:38:02', '2026-05-30 20:38:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1450', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:38:12', '2026-05-30 20:38:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1451', '2', '1', 'impression', '127.0.0.1', '2026-05-30 20:38:15', '2026-05-30 20:38:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1452', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:38:20', '2026-05-30 20:38:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1453', '2', '8', 'impression', '127.0.0.1', '2026-05-30 20:38:23', '2026-05-30 20:38:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1454', '1', '7', 'impression', '127.0.0.1', '2026-05-30 20:38:24', '2026-05-30 20:38:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1455', '2', '1', 'impression', '127.0.0.1', '2026-05-30 21:00:50', '2026-05-30 21:00:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1456', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:00:53', '2026-05-30 21:00:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1457', '2', '8', 'impression', '127.0.0.1', '2026-05-30 21:00:55', '2026-05-30 21:00:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1458', '1', '7', 'impression', '127.0.0.1', '2026-05-30 21:00:58', '2026-05-30 21:00:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1459', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:01:01', '2026-05-30 21:01:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1460', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:08:35', '2026-05-30 21:08:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1461', '1', '1', 'impression', '127.0.0.1', '2026-05-30 21:08:39', '2026-05-30 21:08:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1462', '1', '8', 'impression', '127.0.0.1', '2026-05-30 21:08:49', '2026-05-30 21:08:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1463', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:08:54', '2026-05-30 21:08:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1464', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:09:13', '2026-05-30 21:09:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1465', '1', '7', 'impression', '127.0.0.1', '2026-05-30 21:09:25', '2026-05-30 21:09:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1466', '2', '1', 'impression', '127.0.0.1', '2026-05-30 21:09:29', '2026-05-30 21:09:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1467', '1', '8', 'impression', '127.0.0.1', '2026-05-30 21:09:32', '2026-05-30 21:09:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1468', '1', '7', 'impression', '127.0.0.1', '2026-05-30 21:09:34', '2026-05-30 21:09:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1469', '1', '7', 'impression', '127.0.0.1', '2026-05-30 21:09:35', '2026-05-30 21:09:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1470', '2', '8', 'impression', '127.0.0.1', '2026-05-30 21:12:25', '2026-05-30 21:12:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1471', '2', '1', 'impression', '127.0.0.1', '2026-05-30 21:12:29', '2026-05-30 21:12:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1472', '2', '1', 'impression', '127.0.0.1', '2026-05-30 21:12:50', '2026-05-30 21:12:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1473', '1', '8', 'impression', '127.0.0.1', '2026-05-30 21:13:02', '2026-05-30 21:13:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1474', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:13:04', '2026-05-30 21:13:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1475', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:13:09', '2026-05-30 21:13:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1476', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:13:16', '2026-05-30 21:13:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1477', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:16:46', '2026-05-30 21:16:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1478', '2', '1', 'impression', '127.0.0.1', '2026-05-30 21:16:52', '2026-05-30 21:16:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1479', '2', '8', 'impression', '127.0.0.1', '2026-05-30 21:16:53', '2026-05-30 21:16:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1480', '1', '7', 'impression', '127.0.0.1', '2026-05-30 21:16:57', '2026-05-30 21:16:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1481', '2', '7', 'impression', '127.0.0.1', '2026-05-30 21:17:00', '2026-05-30 21:17:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1482', '2', '8', 'impression', '127.0.0.1', '2026-05-31 05:03:12', '2026-05-31 05:03:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1483', '2', '1', 'impression', '127.0.0.1', '2026-06-02 08:12:34', '2026-06-02 08:12:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1484', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:03:12', '2026-06-02 09:03:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1485', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:07:14', '2026-06-02 09:07:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1486', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:07:40', '2026-06-02 09:07:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1487', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:34:34', '2026-06-02 09:34:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1488', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:36:54', '2026-06-02 09:36:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1489', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:37:29', '2026-06-02 09:37:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1490', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:37:51', '2026-06-02 09:37:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1491', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:38:18', '2026-06-02 09:38:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1492', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:38:40', '2026-06-02 09:38:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1493', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:38:58', '2026-06-02 09:38:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1494', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:39:27', '2026-06-02 09:39:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1495', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:50:56', '2026-06-02 09:50:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1496', '2', '1', 'impression', '127.0.0.1', '2026-06-02 09:53:58', '2026-06-02 09:53:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1497', '2', '7', 'impression', '127.0.0.1', '2026-06-02 10:57:12', '2026-06-02 10:57:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1498', '2', '7', 'impression', '127.0.0.1', '2026-06-02 10:58:25', '2026-06-02 10:58:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1499', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:06:57', '2026-06-02 11:06:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1500', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:09:36', '2026-06-02 11:09:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1501', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:10:02', '2026-06-02 11:10:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1502', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:10:59', '2026-06-02 11:10:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1503', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:12:07', '2026-06-02 11:12:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1504', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:12:38', '2026-06-02 11:12:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1505', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:13:39', '2026-06-02 11:13:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1506', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:14:39', '2026-06-02 11:14:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1507', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:15:29', '2026-06-02 11:15:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1508', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:18:53', '2026-06-02 11:18:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1509', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:22:14', '2026-06-02 11:22:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1510', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:22:58', '2026-06-02 11:22:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1511', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:23:27', '2026-06-02 11:23:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1512', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:24:43', '2026-06-02 11:24:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1513', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:25:17', '2026-06-02 11:25:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1514', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:25:59', '2026-06-02 11:25:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1515', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:26:40', '2026-06-02 11:26:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1516', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:27:38', '2026-06-02 11:27:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1517', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:31:57', '2026-06-02 11:31:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1518', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:32:25', '2026-06-02 11:32:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1519', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:32:51', '2026-06-02 11:32:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1520', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:33:13', '2026-06-02 11:33:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1521', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:33:48', '2026-06-02 11:33:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1522', '2', '7', 'impression', '127.0.0.1', '2026-06-02 11:34:09', '2026-06-02 11:34:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1523', '2', '7', 'impression', '127.0.0.1', '2026-06-02 12:49:54', '2026-06-02 12:49:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1524', '2', '7', 'impression', '127.0.0.1', '2026-06-02 12:49:57', '2026-06-02 12:49:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1525', '2', '7', 'impression', '127.0.0.1', '2026-06-02 12:49:58', '2026-06-02 12:49:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1526', '2', '7', 'impression', '127.0.0.1', '2026-06-02 12:54:24', '2026-06-02 12:54:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1527', '2', '8', 'impression', '127.0.0.1', '2026-06-02 12:57:21', '2026-06-02 12:57:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1528', '2', '7', 'impression', '127.0.0.1', '2026-06-02 12:59:22', '2026-06-02 12:59:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1529', '2', '7', 'impression', '127.0.0.1', '2026-06-02 12:59:43', '2026-06-02 12:59:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1530', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:03:16', '2026-06-02 13:03:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1531', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:03:20', '2026-06-02 13:03:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1532', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:03:23', '2026-06-02 13:03:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1533', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:03:25', '2026-06-02 13:03:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1534', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:03:28', '2026-06-02 13:03:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1535', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:04:25', '2026-06-02 13:04:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1536', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:04:28', '2026-06-02 13:04:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1537', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:04:32', '2026-06-02 13:04:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1538', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:04:34', '2026-06-02 13:04:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1539', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:04:37', '2026-06-02 13:04:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1540', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:05:05', '2026-06-02 13:05:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1541', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:08', '2026-06-02 13:05:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1542', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:13', '2026-06-02 13:05:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1543', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:15', '2026-06-02 13:05:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1544', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:18', '2026-06-02 13:05:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1545', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:05:32', '2026-06-02 13:05:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1546', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:35', '2026-06-02 13:05:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1547', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:39', '2026-06-02 13:05:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1548', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:41', '2026-06-02 13:05:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1549', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:05:44', '2026-06-02 13:05:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1550', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:07:59', '2026-06-02 13:07:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1551', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:08:02', '2026-06-02 13:08:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1552', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:08:06', '2026-06-02 13:08:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1553', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:08:08', '2026-06-02 13:08:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1554', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:08:12', '2026-06-02 13:08:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1555', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:10:33', '2026-06-02 13:10:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1556', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:10:36', '2026-06-02 13:10:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1557', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:10:41', '2026-06-02 13:10:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1558', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:10:42', '2026-06-02 13:10:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1559', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:10:47', '2026-06-02 13:10:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1560', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:11:28', '2026-06-02 13:11:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1561', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:11:32', '2026-06-02 13:11:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1562', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:11:34', '2026-06-02 13:11:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1563', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:11:37', '2026-06-02 13:11:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1564', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:11:40', '2026-06-02 13:11:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1565', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:14:29', '2026-06-02 13:14:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1566', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:14:30', '2026-06-02 13:14:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1567', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:14:36', '2026-06-02 13:14:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1568', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:14:45', '2026-06-02 13:14:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1569', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:14:49', '2026-06-02 13:14:49');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1570', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:14:52', '2026-06-02 13:14:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1571', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:14:56', '2026-06-02 13:14:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1572', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:15:01', '2026-06-02 13:15:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1573', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:15:44', '2026-06-02 13:15:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1574', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:15:51', '2026-06-02 13:15:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1575', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:15:54', '2026-06-02 13:15:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1576', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:15:57', '2026-06-02 13:15:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1577', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:15:59', '2026-06-02 13:15:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1578', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:11', '2026-06-02 13:17:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1579', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:17:14', '2026-06-02 13:17:14');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1580', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:20', '2026-06-02 13:17:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1581', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:21', '2026-06-02 13:17:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1582', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:24', '2026-06-02 13:17:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1583', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:17:42', '2026-06-02 13:17:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1584', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:48', '2026-06-02 13:17:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1585', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:52', '2026-06-02 13:17:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1586', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:53', '2026-06-02 13:17:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1587', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:17:57', '2026-06-02 13:17:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1588', '2', '8', 'impression', '127.0.0.1', '2026-06-02 13:18:06', '2026-06-02 13:18:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1589', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:18:13', '2026-06-02 13:18:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1590', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:18:16', '2026-06-02 13:18:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1591', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:18:17', '2026-06-02 13:18:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1592', '2', '7', 'impression', '127.0.0.1', '2026-06-02 13:18:20', '2026-06-02 13:18:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1593', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:06:06', '2026-06-02 14:06:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1594', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:06:26', '2026-06-02 14:06:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1595', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:12:57', '2026-06-02 14:12:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1596', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:14:45', '2026-06-02 14:14:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1597', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:14:46', '2026-06-02 14:14:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1598', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:14:48', '2026-06-02 14:14:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1599', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:14:50', '2026-06-02 14:14:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1600', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:14:53', '2026-06-02 14:14:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1601', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:15:33', '2026-06-02 14:15:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1602', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:16:03', '2026-06-02 14:16:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1603', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:16:24', '2026-06-02 14:16:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1604', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:18:28', '2026-06-02 14:18:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1605', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:20:01', '2026-06-02 14:20:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1606', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:20:27', '2026-06-02 14:20:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1607', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:29:34', '2026-06-02 14:29:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1608', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:29:36', '2026-06-02 14:29:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1609', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:29:38', '2026-06-02 14:29:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1610', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:29:40', '2026-06-02 14:29:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1611', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:29:43', '2026-06-02 14:29:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1612', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:00', '2026-06-02 14:30:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1613', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:30:03', '2026-06-02 14:30:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1614', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:05', '2026-06-02 14:30:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1615', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:07', '2026-06-02 14:30:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1616', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:08', '2026-06-02 14:30:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1617', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:30:21', '2026-06-02 14:30:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1618', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:23', '2026-06-02 14:30:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1619', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:25', '2026-06-02 14:30:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1620', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:27', '2026-06-02 14:30:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1621', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:30:30', '2026-06-02 14:30:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1622', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:31:36', '2026-06-02 14:31:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1623', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:31:39', '2026-06-02 14:31:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1624', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:31:42', '2026-06-02 14:31:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1625', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:31:44', '2026-06-02 14:31:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1626', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:31:47', '2026-06-02 14:31:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1627', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:34:30', '2026-06-02 14:34:30');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1628', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:34:33', '2026-06-02 14:34:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1629', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:34:38', '2026-06-02 14:34:38');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1630', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:34:40', '2026-06-02 14:34:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1631', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:34:43', '2026-06-02 14:34:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1632', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:39:13', '2026-06-02 14:39:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1633', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:52:07', '2026-06-02 14:52:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1634', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:52:18', '2026-06-02 14:52:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1635', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:52:28', '2026-06-02 14:52:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1636', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:52:32', '2026-06-02 14:52:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1637', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:52:35', '2026-06-02 14:52:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1638', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:52:55', '2026-06-02 14:52:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1639', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:52:58', '2026-06-02 14:52:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1640', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:52:59', '2026-06-02 14:52:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1641', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:53:04', '2026-06-02 14:53:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1642', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:53:05', '2026-06-02 14:53:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1643', '2', '8', 'impression', '127.0.0.1', '2026-06-02 14:53:20', '2026-06-02 14:53:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1644', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:53:24', '2026-06-02 14:53:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1645', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:53:25', '2026-06-02 14:53:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1646', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:53:28', '2026-06-02 14:53:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1647', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:53:31', '2026-06-02 14:53:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1648', '2', '7', 'impression', '127.0.0.1', '2026-06-02 14:58:47', '2026-06-02 14:58:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1649', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:01:20', '2026-06-02 15:01:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1650', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:01:27', '2026-06-02 15:01:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1651', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:01:31', '2026-06-02 15:01:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1652', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:01:32', '2026-06-02 15:01:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1653', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:01:36', '2026-06-02 15:01:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1654', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:04:16', '2026-06-02 15:04:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1655', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:04:19', '2026-06-02 15:04:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1656', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:04:22', '2026-06-02 15:04:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1657', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:04:25', '2026-06-02 15:04:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1658', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:04:29', '2026-06-02 15:04:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1659', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:04:48', '2026-06-02 15:04:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1660', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:04:52', '2026-06-02 15:04:52');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1661', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:04:58', '2026-06-02 15:04:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1662', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:05:04', '2026-06-02 15:05:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1663', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:05:09', '2026-06-02 15:05:09');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1664', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:05:35', '2026-06-02 15:05:35');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1665', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:05:40', '2026-06-02 15:05:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1666', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:05:42', '2026-06-02 15:05:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1667', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:05:45', '2026-06-02 15:05:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1668', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:05:47', '2026-06-02 15:05:47');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1669', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:06:16', '2026-06-02 15:06:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1670', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:06:20', '2026-06-02 15:06:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1671', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:06:23', '2026-06-02 15:06:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1672', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:06:26', '2026-06-02 15:06:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1673', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:06:28', '2026-06-02 15:06:28');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1674', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:06:48', '2026-06-02 15:06:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1675', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:06:51', '2026-06-02 15:06:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1676', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:06:54', '2026-06-02 15:06:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1677', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:06:58', '2026-06-02 15:06:58');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1678', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:07:00', '2026-06-02 15:07:00');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1679', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:18:41', '2026-06-02 15:18:41');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1680', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:18:44', '2026-06-02 15:18:44');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1681', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:28:15', '2026-06-02 15:28:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1682', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:28:50', '2026-06-02 15:28:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1683', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:35:20', '2026-06-02 15:35:20');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1684', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:35:22', '2026-06-02 15:35:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1685', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:36:22', '2026-06-02 15:36:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1686', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:36:25', '2026-06-02 15:36:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1687', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:37:05', '2026-06-02 15:37:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1688', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:37:08', '2026-06-02 15:37:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1689', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:37:59', '2026-06-02 15:37:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1690', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:38:02', '2026-06-02 15:38:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1691', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:39:11', '2026-06-02 15:39:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1692', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:39:15', '2026-06-02 15:39:15');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1693', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:45:22', '2026-06-02 15:45:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1694', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:45:25', '2026-06-02 15:45:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1695', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:45:33', '2026-06-02 15:45:33');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1696', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:45:37', '2026-06-02 15:45:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1697', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:45:43', '2026-06-02 15:45:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1698', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:45:46', '2026-06-02 15:45:46');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1699', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:45:53', '2026-06-02 15:45:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1700', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:45:57', '2026-06-02 15:45:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1701', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:46:04', '2026-06-02 15:46:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1702', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:46:07', '2026-06-02 15:46:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1703', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:46:16', '2026-06-02 15:46:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1704', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:46:17', '2026-06-02 15:46:17');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1705', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:46:24', '2026-06-02 15:46:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1706', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:46:27', '2026-06-02 15:46:27');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1707', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:46:37', '2026-06-02 15:46:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1708', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:46:40', '2026-06-02 15:46:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1709', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:48:13', '2026-06-02 15:48:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1710', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:48:16', '2026-06-02 15:48:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1711', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:49:08', '2026-06-02 15:49:08');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1712', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:49:11', '2026-06-02 15:49:11');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1713', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:49:19', '2026-06-02 15:49:19');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1714', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:49:21', '2026-06-02 15:49:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1715', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:49:31', '2026-06-02 15:49:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1716', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:49:32', '2026-06-02 15:49:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1717', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:49:40', '2026-06-02 15:49:40');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1718', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:49:42', '2026-06-02 15:49:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1719', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:49:51', '2026-06-02 15:49:51');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1720', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:49:53', '2026-06-02 15:49:53');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1721', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:50:02', '2026-06-02 15:50:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1722', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:50:04', '2026-06-02 15:50:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1723', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:50:13', '2026-06-02 15:50:13');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1724', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:50:16', '2026-06-02 15:50:16');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1725', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:50:23', '2026-06-02 15:50:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1726', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:50:25', '2026-06-02 15:50:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1727', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:50:37', '2026-06-02 15:50:37');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1728', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:50:39', '2026-06-02 15:50:39');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1729', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:50:48', '2026-06-02 15:50:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1730', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:50:50', '2026-06-02 15:50:50');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1731', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:50:59', '2026-06-02 15:50:59');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1732', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:51:01', '2026-06-02 15:51:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1733', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:51:10', '2026-06-02 15:51:10');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1734', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:51:12', '2026-06-02 15:51:12');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1735', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:51:21', '2026-06-02 15:51:21');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1736', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:51:23', '2026-06-02 15:51:23');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1737', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:51:32', '2026-06-02 15:51:32');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1738', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:51:34', '2026-06-02 15:51:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1739', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:51:43', '2026-06-02 15:51:43');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1740', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:51:45', '2026-06-02 15:51:45');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1741', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:51:54', '2026-06-02 15:51:54');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1742', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:51:56', '2026-06-02 15:51:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1743', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:56:04', '2026-06-02 15:56:04');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1744', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:56:07', '2026-06-02 15:56:07');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1745', '2', '8', 'impression', '127.0.0.1', '2026-06-02 15:58:22', '2026-06-02 15:58:22');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1746', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:58:25', '2026-06-02 15:58:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1747', '2', '7', 'impression', '127.0.0.1', '2026-06-02 15:59:57', '2026-06-02 15:59:57');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1748', '2', '8', 'impression', '127.0.0.1', '2026-06-02 16:00:01', '2026-06-02 16:00:01');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1749', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:25:02', '2026-06-03 06:25:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1750', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:32:31', '2026-06-03 06:32:31');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1751', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:35:06', '2026-06-03 06:35:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1752', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:37:02', '2026-06-03 06:37:02');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1753', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:37:06', '2026-06-03 06:37:06');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1754', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:37:36', '2026-06-03 06:37:36');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1755', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:40:34', '2026-06-03 06:40:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1756', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:42:26', '2026-06-03 06:42:26');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1757', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:45:55', '2026-06-03 06:45:55');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1758', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:46:03', '2026-06-03 06:46:03');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1759', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:48:05', '2026-06-03 06:48:05');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1760', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:48:25', '2026-06-03 06:48:25');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1761', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:49:18', '2026-06-03 06:49:18');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1762', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:50:56', '2026-06-03 06:50:56');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1763', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:51:34', '2026-06-03 06:51:34');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1764', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:53:29', '2026-06-03 06:53:29');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1765', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:53:42', '2026-06-03 06:53:42');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1766', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:55:24', '2026-06-03 06:55:24');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1767', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:55:48', '2026-06-03 06:55:48');
INSERT INTO `ad_impressions` (`id`, `advertisement_id`, `user_id`, `event`, `ip_address`, `created_at`, `updated_at`) VALUES ('1768', '2', '7', 'impression', '127.0.0.1', '2026-06-03 06:56:46', '2026-06-03 06:56:46');


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

INSERT INTO `advertisements` (`id`, `title`, `description`, `type`, `media_path`, `media_url`, `click_url`, `button_text`, `button_url`, `position`, `duration`, `interval_seconds`, `tracks_between`, `starts_at`, `ends_at`, `status`, `impressions`, `clicks`, `max_impressions`, `budget`, `spent`, `targeting`, `target_plans`, `priority`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', 'تبلیغ 1', 'توضیحات تبلیغ', 'audio', 'ads/audio/01KST5HE1B2JPV080D4XV6BATC.mp3', NULL, NULL, 'خرید', 'https://windsurf.com/profile', NULL, '15', '300', '1', '2026-05-29 00:00:00', '2026-06-01 00:00:00', 'active', '442', '0', NULL, NULL, '0', NULL, '[]', '1', '2026-05-29 15:27:11', '2026-05-30 21:16:57', NULL);
INSERT INTO `advertisements` (`id`, `title`, `description`, `type`, `media_path`, `media_url`, `click_url`, `button_text`, `button_url`, `position`, `duration`, `interval_seconds`, `tracks_between`, `starts_at`, `ends_at`, `status`, `impressions`, `clicks`, `max_impressions`, `budget`, `spent`, `targeting`, `target_plans`, `priority`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', 'تبلیغ 2', 'توضیحات', 'audio', 'ads/audio/01KST5JSYVR06XTJMVK7T3NBZS.mp3', NULL, NULL, NULL, NULL, NULL, '15', '300', '2', '2026-05-29 00:00:00', NULL, 'active', '1276', '0', NULL, NULL, '0', NULL, '[]', '2', '2026-05-29 15:27:56', '2026-06-03 06:56:46', NULL);
INSERT INTO `advertisements` (`id`, `title`, `description`, `type`, `media_path`, `media_url`, `click_url`, `button_text`, `button_url`, `position`, `duration`, `interval_seconds`, `tracks_between`, `starts_at`, `ends_at`, `status`, `impressions`, `clicks`, `max_impressions`, `budget`, `spent`, `targeting`, `target_plans`, `priority`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', 'بنر 1', 'توضیحات', 'banner', 'ads/banners/01KST5MHHBZ5MXYCX52G595475.jpg', NULL, NULL, 'خرید', 'https://windsurf.com/profile', NULL, NULL, '300', '3', '2026-05-29 00:00:00', NULL, 'active', '50', '0', '50', NULL, '0', NULL, '[\"all\"]', '0', '2026-05-29 15:28:53', '2026-05-29 15:57:30', NULL);


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

INSERT INTO `albums` (`id`, `artist_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `type`, `genre_id`, `release_date`, `status`, `published_at`, `is_explicit`, `is_featured`, `play_count`, `like_count`, `repost_count`, `comment_count`, `share_count`, `upc`, `copyright`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('1', '1', 'آلبوم محسن چاوشی', 'Album by محسن چاوشی', 'albom-mhsn-chaoshy', NULL, NULL, 'album', '1', '2026-02-09', 'published', '2026-04-29 14:06:34', '0', '0', '246546', '53343', '4', '0', '0', NULL, NULL, NULL, NULL, '2026-05-29 14:06:34', '2026-05-30 07:09:27', NULL, NULL, NULL, '0', '0');
INSERT INTO `albums` (`id`, `artist_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `type`, `genre_id`, `release_date`, `status`, `published_at`, `is_explicit`, `is_featured`, `play_count`, `like_count`, `repost_count`, `comment_count`, `share_count`, `upc`, `copyright`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('2', '2', 'آلبوم سیروان خسروی', 'Album by سیروان خسروی', 'albom-syroan-khsroy', NULL, NULL, 'album', '3', '2026-01-25', 'published', '2026-05-17 14:06:35', '0', '0', '469568', '39449', '0', '0', '0', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 07:08:39', NULL, NULL, NULL, '0', '0');
INSERT INTO `albums` (`id`, `artist_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `type`, `genre_id`, `release_date`, `status`, `published_at`, `is_explicit`, `is_featured`, `play_count`, `like_count`, `repost_count`, `comment_count`, `share_count`, `upc`, `copyright`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('3', '3', 'آلبوم رضا بهرام', 'Album by رضا بهرام', 'albom-rda-bhram', NULL, NULL, 'album', '11', '2026-02-04', 'published', '2026-05-01 14:06:35', '0', '0', '441568', '42504', '2', '0', '0', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 07:53:48', NULL, NULL, NULL, '0', '0');
INSERT INTO `albums` (`id`, `artist_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `type`, `genre_id`, `release_date`, `status`, `published_at`, `is_explicit`, `is_featured`, `play_count`, `like_count`, `repost_count`, `comment_count`, `share_count`, `upc`, `copyright`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('4', '4', 'آلبوم همایون شجریان', 'Album by همایون شجریان', 'albom-hmayon-shgryan', NULL, NULL, 'album', '2', '2025-11-02', 'published', '2026-05-05 14:06:35', '0', '0', '131574', '40564', '0', '0', '0', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `albums` (`id`, `artist_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `type`, `genre_id`, `release_date`, `status`, `published_at`, `is_explicit`, `is_featured`, `play_count`, `like_count`, `repost_count`, `comment_count`, `share_count`, `upc`, `copyright`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('5', '5', 'آلبوم حامد همایون', 'Album by حامد همایون', 'albom-hamd-hmayon', NULL, NULL, 'album', '3', '2025-08-18', 'published', '2026-04-29 14:06:35', '0', '0', '406564', '95288', '0', '0', '0', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 18:14:25', NULL, NULL, NULL, '0', '0');
INSERT INTO `albums` (`id`, `artist_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `type`, `genre_id`, `release_date`, `status`, `published_at`, `is_explicit`, `is_featured`, `play_count`, `like_count`, `repost_count`, `comment_count`, `share_count`, `upc`, `copyright`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('6', '6', 'آلبوم مهراد هیدن', NULL, 'albom-mhrad-hydn', NULL, 'covers/albums/BRpLxRChpxNDHzGbVJgCip7ReAlSyjPmPKU1uE6t.png', 'album', '8', '2026-05-26', 'published', '2026-05-18 14:06:35', '1', '1', '849304', '54525', '0', '0', '0', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 10:13:40', NULL, '50000', '20000', '15', '1');


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

INSERT INTO `artist_application_fields` (`id`, `key`, `label`, `type`, `options`, `required`, `is_active`, `sort_order`, `placeholder`, `help_text`, `created_at`, `updated_at`) VALUES ('1', 'name', 'نام هنری', 'text', NULL, '1', '1', '0', 'نام خود را وارد کنید', 'لطفا نام کامل را وارد کنید', '2026-05-29 19:15:37', '2026-05-29 19:15:37');
INSERT INTO `artist_application_fields` (`id`, `key`, `label`, `type`, `options`, `required`, `is_active`, `sort_order`, `placeholder`, `help_text`, `created_at`, `updated_at`) VALUES ('2', 'idcart', 'کارت ملی', 'file', NULL, '1', '1', '0', 'لطفا تصویر کارت ملی را وارد کنید', 'تصویر باید واضح باشد', '2026-05-29 19:15:37', '2026-05-29 19:15:37');


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

INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('1', '1', 'App\\Models\\Track', '1', '1776654', '8883000', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('2', '1', 'App\\Models\\Track', '2', '4301763', '21508500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('3', '1', 'App\\Models\\Track', '3', '1185877', '5929000', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('4', '1', 'App\\Models\\Track', '4', '1054246', '5271000', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('5', '1', 'App\\Models\\Track', '5', '3801846', '19009000', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('6', '1', 'App\\Models\\Track', '6', '3555017', '17775000', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('7', '2', 'App\\Models\\Track', '7', '667500', '3337500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('8', '2', 'App\\Models\\Track', '8', '3879778', '19398500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('9', '2', 'App\\Models\\Track', '9', '2588574', '12942500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('10', '2', 'App\\Models\\Track', '10', '3792991', '18964500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('11', '2', 'App\\Models\\Track', '11', '4909125', '24545500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('12', '2', 'App\\Models\\Track', '12', '2459194', '12295500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('13', '2', 'App\\Models\\Track', '13', '2711740', '13558500', 'paid', '2026-05-29 19:12:13', NULL, '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('14', '2', 'App\\Models\\Track', '14', '2720018', '13600000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('15', '3', 'App\\Models\\Track', '15', '2051825', '10259000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('16', '3', 'App\\Models\\Track', '16', '1524302', '7621500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('17', '3', 'App\\Models\\Track', '17', '4155436', '20777000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('18', '3', 'App\\Models\\Track', '18', '1376100', '6880500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('19', '3', 'App\\Models\\Track', '19', '4883259', '24416000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('20', '3', 'App\\Models\\Track', '20', '4515538', '22577500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('21', '3', 'App\\Models\\Track', '21', '2512991', '12564500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('22', '4', 'App\\Models\\Track', '22', '1295039', '6475000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('23', '4', 'App\\Models\\Track', '23', '3666119', '18330500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('24', '4', 'App\\Models\\Track', '24', '3877352', '19386500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('25', '4', 'App\\Models\\Track', '25', '1216688', '6083000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('26', '4', 'App\\Models\\Track', '26', '3931810', '19659000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('27', '5', 'App\\Models\\Track', '27', '3528252', '17641000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('28', '5', 'App\\Models\\Track', '28', '4014427', '20072000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('29', '5', 'App\\Models\\Track', '29', '4874940', '24374500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('30', '5', 'App\\Models\\Track', '30', '4048643', '20243000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('31', '5', 'App\\Models\\Track', '31', '1005379', '5026500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('32', '5', 'App\\Models\\Track', '32', '2183793', '10918500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('33', '5', 'App\\Models\\Track', '33', '3070873', '15354000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('34', '6', 'App\\Models\\Track', '34', '1278808', '6394000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('35', '6', 'App\\Models\\Track', '35', '2656452', '13282000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('36', '6', 'App\\Models\\Track', '36', '4220271', '21101000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('37', '6', 'App\\Models\\Track', '37', '4761469', '23807000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('38', '6', 'App\\Models\\Track', '38', '3378787', '16893500', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('39', '6', 'App\\Models\\Track', '39', '2979045', '14895000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('40', '6', 'App\\Models\\Track', '40', '3445815', '17229000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `artist_earnings` (`id`, `artist_id`, `playable_type`, `playable_id`, `play_count`, `earning_amount_toman`, `status`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES ('41', '6', 'App\\Models\\Track', '41', '1084217', '5421000', 'paid', '2026-05-29 19:12:14', NULL, '2026-05-29 19:12:14', '2026-05-29 19:12:14');


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

INSERT INTO `artist_plans` (`id`, `name`, `slug`, `description`, `price`, `duration_days`, `max_tracks`, `max_albums`, `max_storage_mb`, `includes_downloads`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES ('1', 'هنرمند تازه کار', 'hnrmnd-tazh-kar', 'این پلن مخصوص هنرمندان تازه کار هست', '100000', '30', '5', '2', '1000', '0', '1', '0', '2026-05-29 19:18:11', '2026-05-29 19:18:11');
INSERT INTO `artist_plans` (`id`, `name`, `slug`, `description`, `price`, `duration_days`, `max_tracks`, `max_albums`, `max_storage_mb`, `includes_downloads`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES ('2', 'هنرمند حرفه ای', 'hnrmnd-hrfh-ay', 'این پلن مناسب هنرمندن حرفه ای می باشد.', '400000', '30', '50', '20', '20000', '0', '1', '0', '2026-06-02 14:17:59', '2026-06-02 14:17:59');


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

INSERT INTO `artist_subscriptions` (`id`, `artist_id`, `plan_id`, `status`, `starts_at`, `expires_at`, `tracks_used`, `albums_used`, `storage_used_mb`, `payment_ref`, `granted_by`, `created_at`, `updated_at`) VALUES ('1', '6', '1', 'cancelled', '2026-06-02 17:50:22', '2026-06-28 19:26:56', '0', '0', '0', 'demo_6a19e88032896_cp_iran', NULL, '2026-05-29 19:26:56', '2026-06-02 14:20:22');
INSERT INTO `artist_subscriptions` (`id`, `artist_id`, `plan_id`, `status`, `starts_at`, `expires_at`, `tracks_used`, `albums_used`, `storage_used_mb`, `payment_ref`, `granted_by`, `created_at`, `updated_at`) VALUES ('2', '6', '2', 'active', '2026-06-02 17:50:22', '2026-07-02 14:20:15', '0', '0', '0', NULL, NULL, '2026-06-02 14:20:15', '2026-06-02 14:20:22');


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

INSERT INTO `artists` (`id`, `user_id`, `display_name`, `slug`, `bio`, `cover_image`, `website`, `instagram`, `twitter`, `telegram`, `verification_status`, `verified_at`, `is_featured`, `monthly_listeners`, `total_streams`, `followers_count`, `balance`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', '2', 'محسن چاوشی', 'mhsn-chaoshy', 'خواننده و آهنگساز ایرانی', NULL, NULL, NULL, NULL, NULL, 'approved', '2026-05-29 14:06:32', '1', '3598341', '91518949', '755839', '0', '2026-05-29 14:06:32', '2026-05-29 14:06:32', NULL);
INSERT INTO `artists` (`id`, `user_id`, `display_name`, `slug`, `bio`, `cover_image`, `website`, `instagram`, `twitter`, `telegram`, `verification_status`, `verified_at`, `is_featured`, `monthly_listeners`, `total_streams`, `followers_count`, `balance`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', '3', 'سیروان خسروی', 'syroan-khsroy', 'خواننده و آهنگساز ایرانی', NULL, NULL, NULL, NULL, NULL, 'approved', '2026-05-29 14:06:33', '1', '2549404', '36916075', '1361701', '0', '2026-05-29 14:06:33', '2026-05-29 14:06:33', NULL);
INSERT INTO `artists` (`id`, `user_id`, `display_name`, `slug`, `bio`, `cover_image`, `website`, `instagram`, `twitter`, `telegram`, `verification_status`, `verified_at`, `is_featured`, `monthly_listeners`, `total_streams`, `followers_count`, `balance`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', '4', 'رضا بهرام', 'rda-bhram', 'خواننده و آهنگساز ایرانی', NULL, NULL, NULL, NULL, NULL, 'approved', '2026-05-29 14:06:33', '1', '4481442', '31994202', '357716', '0', '2026-05-29 14:06:33', '2026-05-29 14:06:33', NULL);
INSERT INTO `artists` (`id`, `user_id`, `display_name`, `slug`, `bio`, `cover_image`, `website`, `instagram`, `twitter`, `telegram`, `verification_status`, `verified_at`, `is_featured`, `monthly_listeners`, `total_streams`, `followers_count`, `balance`, `created_at`, `updated_at`, `deleted_at`) VALUES ('4', '5', 'همایون شجریان', 'hmayon-shgryan', 'خواننده و آهنگساز ایرانی', NULL, NULL, NULL, NULL, NULL, 'approved', '2026-05-29 14:06:33', '1', '3251011', '88545922', '235281', '0', '2026-05-29 14:06:33', '2026-05-29 14:06:33', NULL);
INSERT INTO `artists` (`id`, `user_id`, `display_name`, `slug`, `bio`, `cover_image`, `website`, `instagram`, `twitter`, `telegram`, `verification_status`, `verified_at`, `is_featured`, `monthly_listeners`, `total_streams`, `followers_count`, `balance`, `created_at`, `updated_at`, `deleted_at`) VALUES ('5', '6', 'حامد همایون', 'hamd-hmayon', 'خواننده و آهنگساز ایرانی', NULL, NULL, NULL, NULL, NULL, 'approved', '2026-05-29 14:06:34', '1', '3296212', '80226236', '1180610', '0', '2026-05-29 14:06:34', '2026-05-29 14:06:34', NULL);
INSERT INTO `artists` (`id`, `user_id`, `display_name`, `slug`, `bio`, `cover_image`, `website`, `instagram`, `twitter`, `telegram`, `verification_status`, `verified_at`, `is_featured`, `monthly_listeners`, `total_streams`, `followers_count`, `balance`, `created_at`, `updated_at`, `deleted_at`) VALUES ('6', '7', 'مهراد هیدن', 'mhrad-hydn', 'خواننده و آهنگساز ایرانی', 'artists/KrlOTn6Whuf55ZQVlwv5GD2KYAVIjhH8WZ5lqBOO.png', NULL, NULL, NULL, NULL, 'approved', '2026-05-29 00:00:00', '1', '2453593', '35409831', '1745523', '0', '2026-05-29 14:06:34', '2026-05-30 10:13:40', NULL);


CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



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

INSERT INTO `commission_rules` (`id`, `name`, `type`, `reference_id`, `commission_type`, `commission_value`, `is_active`, `description`, `created_at`, `updated_at`) VALUES ('1', 'کمیسیون پیش فرض', 'global', NULL, 'percent', '10.00', '1', '10 درصد اعمال میشه', '2026-05-29 19:12:59', '2026-05-29 19:12:59');


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

INSERT INTO `coupon_user` (`id`, `coupon_id`, `user_id`, `used_at`) VALUES ('1', '1', '7', '2026-05-29 19:26:56');


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

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `max_discount`, `min_purchase`, `limit_per_user`, `total_limit`, `used_count`, `starts_at`, `expires_at`, `is_active`, `applicable_to`, `created_at`, `updated_at`) VALUES ('1', 'iran', 'percent', '50.00', '50000.00', '0.00', '1', NULL, '1', '2026-05-29 00:00:00', '2026-05-31 00:00:00', '1', '[\"tracks\",\"plans\",\"artist_plans\"]', '2026-05-29 15:07:18', '2026-05-29 19:26:56');


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

INSERT INTO `earnings_settings` (`id`, `is_enabled`, `plays_threshold`, `earning_amount_toman`, `min_payout_toman`, `payout_description`, `created_at`, `updated_at`) VALUES ('1', '1', '100', '500', '50000', 'توضیحات درامد پخش', '2026-05-29 14:23:21', '2026-05-29 14:41:55');


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

INSERT INTO `follows` (`id`, `user_id`, `followable_type`, `followable_id`, `created_at`) VALUES ('1', '8', 'App\\Models\\Artist', '6', '2026-05-30 06:05:37');
INSERT INTO `follows` (`id`, `user_id`, `followable_type`, `followable_id`, `created_at`) VALUES ('2', '7', 'App\\Models\\User', '8', '2026-05-30 09:43:21');


CREATE TABLE `genre_track` (
  `genre_id` bigint(20) unsigned NOT NULL,
  `track_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`genre_id`,`track_id`),
  KEY `genre_track_track_id_foreign` (`track_id`),
  CONSTRAINT `genre_track_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `genre_track_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



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

INSERT INTO `likes` (`id`, `user_id`, `likeable_type`, `likeable_id`, `created_at`) VALUES ('1', '1', 'App\\Models\\Album', '5', '2026-05-29 18:14:24');
INSERT INTO `likes` (`id`, `user_id`, `likeable_type`, `likeable_id`, `created_at`) VALUES ('4', '8', 'App\\Models\\Track', '34', '2026-05-30 06:40:08');
INSERT INTO `likes` (`id`, `user_id`, `likeable_type`, `likeable_id`, `created_at`) VALUES ('6', '7', 'App\\Models\\Album', '1', '2026-05-30 07:08:30');
INSERT INTO `likes` (`id`, `user_id`, `likeable_type`, `likeable_id`, `created_at`) VALUES ('9', '8', 'App\\Models\\Album', '3', '2026-05-30 07:53:48');
INSERT INTO `likes` (`id`, `user_id`, `likeable_type`, `likeable_id`, `created_at`) VALUES ('10', '8', 'App\\Models\\PodcastEpisode', '1', '2026-05-30 07:53:52');


CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_05_24_083535_create_permission_tables', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_05_24_100001_create_artists_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_05_24_100002_create_genres_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_05_24_100003_create_albums_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_05_24_100004_create_tracks_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_05_24_100005_create_playlists_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_05_24_100006_create_podcasts_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_05_24_100007_create_subscriptions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_05_24_100008_create_interactions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2026_05_24_100009_create_advertisements_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2026_05_24_100010_create_homepage_and_themes_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('15', '2026_05_25_000001_add_timestamp_at_to_comments_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('16', '2026_05_25_000001_create_settings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('17', '2026_05_25_063929_create_notifications_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('18', '2026_05_25_100001_add_trial_days_to_plans_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('19', '2026_05_25_200001_extend_homepage_sections_type_enum', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('20', '2026_05_25_200002_add_featured_track_to_homepage_sections_enum', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('21', '2026_05_26_200001_enhance_wallet_transactions', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('22', '2026_05_26_300001_create_commission_system', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('23', '2026_05_26_300002_enhance_advertisements', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('24', '2026_05_26_400001_add_purchase_fields', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('25', '2026_05_26_400002_extend_wallet_transaction_types', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('26', '2026_05_26_500001_add_preview_seconds', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('27', '2026_05_27_104544_add_button_fields_to_advertisements_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('28', '2026_05_27_600001_create_reports_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('29', '2026_05_27_700001_create_artist_applications_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('30', '2026_05_27_800001_create_artist_plans_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('31', '2026_05_28_000001_add_artist_id_to_podcasts_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('32', '2026_05_28_000002_create_earnings_settings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('33', '2026_05_28_000003_create_artist_earnings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('34', '2026_05_28_071934_add_pending_status_to_content_tables', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('35', '2026_05_28_074139_fix_podcast_episodes_status_column', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('36', '2026_05_28_080811_add_is_premium_only_to_podcasts_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('37', '2026_05_28_120000_create_podcast_subscriptions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('38', '2026_05_28_130000_add_includes_downloads_to_plans_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('39', '2026_05_28_140000_add_is_downloadable_to_podcast_episodes_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('40', '2026_05_29_000001_add_is_trial_to_subscriptions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('41', '2026_05_29_134618_create_downloads_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('42', '2026_05_29_140812_create_coupons_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('43', '2026_05_29_161339_add_track_shelf_to_homepage_sections_enum', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('44', '2026_05_30_052338_add_feed_and_repost_system_tables', '4');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('45', '2026_05_30_073504_add_ip_address_to_activities_and_reposts_tables', '5');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('46', '2026_05_30_074944_add_repost_count_to_podcast_episodes_table', '6');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('47', '2026_05_30_082205_add_artist_name_to_tracks_table', '7');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('48', '2026_05_30_100000_create_notification_system_tables', '8');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('49', '2026_05_30_110000_add_database_template_to_notification_settings', '9');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('50', '2026_06_02_083203_add_sms_var_names_to_notification_settings_table', '10');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('51', '2026_06_02_085340_add_email_template_to_settings_table', '11');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('52', '2026_06_02_093254_add_payable_and_type_to_payments_table', '11');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('53', '2026_06_02_110429_add_active_gateways_to_settings', '12');


CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('1', 'App\\Models\\User', '1');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('3', 'App\\Models\\User', '2');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('3', 'App\\Models\\User', '3');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('3', 'App\\Models\\User', '4');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('3', 'App\\Models\\User', '5');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('3', 'App\\Models\\User', '6');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('3', 'App\\Models\\User', '7');


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

INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('1', 'track_liked', 'لایک شدن آهنگ (صاحب اثر)', 'artist', 'هنرمند گرامی، آهنگ {track_title} توسط {user_name} لایک شد.', '1', '1', '0', '387751', NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 20:12:54');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('2', 'track_reposted', 'بازنشر آهنگ (صاحب اثر)', 'artist', 'هنرمند گرامی، آهنگ {track_title} توسط {user_name} بازنشر شد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('3', 'user_followed', 'دنبال شدن (کاربر)', 'user', 'کاربر گرامی، {follower_name} شما را دنبال کرد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('4', 'new_content_follower', 'محتوای جدید از دنبال‌شوندگان (دنبال‌کننده)', 'user', 'محتوای جدید: {artist_name} آهنگ جدید \"{content_title}\" را منتشر کرد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('5', 'track_purchased_artist', 'فروش آهنگ (هنرمند)', 'artist', 'هنرمند گرامی، آهنگ {track_title} به مبلغ {amount} فروخته شد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('6', 'new_artist_application', 'درخواست هنرمند جدید (ادمین)', 'admin', 'ادمین گرامی، درخواست جدید هنرمندی از طرف {user_name} ثبت شد.', '1', '0', '0', NULL, NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 11:29:53');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('7', 'new_report', 'گزارش جدید (ادمین)', 'admin', 'گزارش جدیدی با موضوع {type} ثبت شد.', '1', '1', '0', '387751', NULL, NULL, NULL, NULL, '2026-05-30 11:29:53', '2026-05-30 20:12:54');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('8', 'otp_code', 'ارسال کد تایید (OTP)', 'user', 'کد تایید شما: {code}', '0', '1', '0', '387751', NULL, NULL, NULL, NULL, '2026-05-30 21:10:23', '2026-05-30 21:20:02');
INSERT INTO `notification_settings` (`id`, `event_key`, `event_label`, `recipient_type`, `database_template`, `via_database`, `via_sms`, `via_email`, `sms_pattern_id`, `sms_var_names`, `sms_template`, `email_subject`, `email_body`, `created_at`, `updated_at`) VALUES ('9', 'password_recovery', 'بازیابی رمز عبور', 'user', 'کد بازیابی رمز عبور شما: {code}', '0', '1', '1', '387751', NULL, NULL, 'بازیابی رمز عبور', NULL, '2026-05-30 21:10:23', '2026-05-30 21:20:02');


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

INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('1', '7', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0647\\u0646\\u06af \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/track\\/roya-2\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 06:30:32', '2026-05-30 06:30:32');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('2', '7', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0647\\u0646\\u06af \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/track\\/roya-2\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 06:30:35', '2026-05-30 06:30:35');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('3', '7', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0647\\u0646\\u06af \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/track\\/roya-2\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 06:40:04', '2026-05-30 06:40:04');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('4', '7', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0647\\u0646\\u06af \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/track\\/roya-2\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 06:40:08', '2026-05-30 06:40:08');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('5', '3', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-syroan-khsroy\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 07:07:29', '2026-05-30 07:07:29');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('6', '3', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-syroan-khsroy\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 07:07:36', '2026-05-30 07:07:36');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('7', '2', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0645\\u0647\\u0631\\u0627\\u062f \\u0647\\u06cc\\u062f\\u0646 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-mhsn-chaoshy\",\"image\":null}', '0', NULL, '2026-05-30 07:08:22', '2026-05-30 07:08:22');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('8', '2', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0645\\u0647\\u0631\\u0627\\u062f \\u0647\\u06cc\\u062f\\u0646 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-mhsn-chaoshy\",\"image\":null}', '0', NULL, '2026-05-30 07:08:30', '2026-05-30 07:08:30');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('9', '2', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0645\\u0647\\u0631\\u0627\\u062f \\u0647\\u06cc\\u062f\\u0646 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-mhsn-chaoshy\",\"image\":null}', '0', NULL, '2026-05-30 07:08:50', '2026-05-30 07:08:50');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('10', '2', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-mhsn-chaoshy\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 07:09:08', '2026-05-30 07:09:08');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('11', '2', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-mhsn-chaoshy\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 07:09:11', '2026-05-30 07:09:11');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('12', '2', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-mhsn-chaoshy\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 07:09:16', '2026-05-30 07:09:16');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('13', '6', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0645\\u0647\\u0631\\u0627\\u062f \\u0647\\u06cc\\u062f\\u0646 \\u067e\\u0627\\u062f\\u06a9\\u0633\\u062a \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/podcast\\/moz\",\"image\":null}', '0', NULL, '2026-05-30 07:15:26', '2026-05-30 07:15:26');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('14', '6', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0645\\u0647\\u0631\\u0627\\u062f \\u0647\\u06cc\\u062f\\u0646 \\u0622\\u0647\\u0646\\u06af \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/track\\/asman-1\",\"image\":null}', '0', NULL, '2026-05-30 07:16:23', '2026-05-30 07:16:23');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('15', '4', 'App\\Notifications\\RepostNotification', NULL, NULL, NULL, '{\"type\":\"repost\",\"title\":\"\\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0645\\u0647\\u0631\\u0627\\u062f \\u0647\\u06cc\\u062f\\u0646 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0628\\u0627\\u0632\\u0646\\u0634\\u0631 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-rda-bhram\",\"image\":null}', '0', NULL, '2026-05-30 07:41:06', '2026-05-30 07:41:06');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('16', '4', 'App\\Notifications\\LikeNotification', NULL, NULL, NULL, '{\"type\":\"like\",\"title\":\"\\u0644\\u0627\\u06cc\\u06a9 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0641\\u0631\\u0646\\u0627\\u062f \\u0628\\u0627\\u0628\\u0627\\u067e\\u0648\\u0631 \\u0622\\u0644\\u0628\\u0648\\u0645 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u0644\\u0627\\u06cc\\u06a9 \\u06a9\\u0631\\u062f.\",\"url\":\"http:\\/\\/localhost:8000\\/album\\/albom-rda-bhram\",\"image\":\"avatars\\/01KSTJ41HV6NNYRBRK33ZKAFX6.png\"}', '0', NULL, '2026-05-30 07:53:48', '2026-05-30 07:53:48');
INSERT INTO `notifications_log` (`id`, `user_id`, `type`, `channel`, `title`, `body`, `data`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES ('17', '8', 'App\\Notifications\\FollowNotification', NULL, NULL, NULL, '{\"type\":\"follow\",\"title\":\"\\u062f\\u0646\\u0628\\u0627\\u0644\\u200c\\u06a9\\u0646\\u0646\\u062f\\u0647 \\u062c\\u062f\\u06cc\\u062f\",\"body\":\"\\u0645\\u0647\\u0631\\u0627\\u062f \\u0647\\u06cc\\u062f\\u0646 \\u0634\\u0645\\u0627 \\u0631\\u0627 \\u062f\\u0646\\u0628\\u0627\\u0644 \\u06a9\\u0631\\u062f.\",\"url\":\"#\",\"image\":null}', '0', NULL, '2026-05-30 09:43:22', '2026-05-30 09:43:22');


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

INSERT INTO `otp_codes` (`id`, `phone`, `code`, `expires_at`, `is_used`, `created_at`, `updated_at`) VALUES ('1', '09356963201', '873958', '2026-05-30 23:45:42', '1', '2026-05-30 20:15:24', '2026-05-30 20:15:42');
INSERT INTO `otp_codes` (`id`, `phone`, `code`, `expires_at`, `is_used`, `created_at`, `updated_at`) VALUES ('2', '09356963201', '376298', '2026-05-31 00:49:11', '1', '2026-05-30 21:18:26', '2026-05-30 21:19:11');
INSERT INTO `otp_codes` (`id`, `phone`, `code`, `expires_at`, `is_used`, `created_at`, `updated_at`) VALUES ('3', '09356963201', '809143', '2026-05-31 00:50:13', '1', '2026-05-30 21:19:11', '2026-05-30 21:20:13');
INSERT INTO `otp_codes` (`id`, `phone`, `code`, `expires_at`, `is_used`, `created_at`, `updated_at`) VALUES ('4', '09356963201', '515682', '2026-05-30 21:25:13', '0', '2026-05-30 21:20:13', '2026-05-30 21:20:13');


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

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `seo_title`, `seo_description`, `is_published`, `created_at`, `updated_at`) VALUES ('1', 'تماس باما', 'tamas', '<p>فقافقافقافقفقافقافقافقافقافق</p><p style=\"text-align: center;\">فقافقافقافاقفقاففافقفافقافقاففقا</p><p>فقافافقا<strong>فقافقافقا</strong>افقاف<s>ذبیبذبیذبیذی</s>ریسری</p>', NULL, NULL, '1', '2026-05-29 14:50:28', '2026-05-29 15:04:47');


CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



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

INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('1', '7', '2', '699000', '69900', '0', 'zibal', 'subscription', '4611954370', NULL, 'pending', 'خرید اشتراک پریمیوم سالانه', 'http://localhost:8000/payment/verify', '09121111116', '{\"message\":\"success\",\"result\":100,\"trackId\":4611954370}', '2026-06-02 10:58:06', '2026-06-02 10:58:08', 'App\\Models\\Subscription', '2');
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('2', '7', NULL, '100000', '0', '0', 'zibal', 'wallet_deposit', '4612000441', NULL, 'failed', 'شارژ کیف پول', 'http://localhost:8000/payment/verify', '09121111116', '{\"message\":\"success\",\"result\":100,\"trackId\":4612000441}', '2026-06-02 11:32:08', '2026-06-02 11:32:20', NULL, NULL);
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('3', '7', NULL, '100000', '0', '0', 'zarinpal', 'wallet_deposit', 'S0000000000000000000000000000006z2dx', NULL, 'failed', 'شارژ کیف پول', 'http://localhost:8000/payment/verify', '09121111116', '{\"data\":{\"authority\":\"S0000000000000000000000000000006z2dx\",\"fee\":30000,\"fee_type\":\"Merchant\",\"code\":100,\"message\":\"Success\"},\"errors\":[]}', '2026-06-02 11:32:39', '2026-06-02 11:32:47', NULL, NULL);
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('4', '7', NULL, '50000', '0', '0', 'zibal', 'wallet_deposit', '4612002025', '4612002025', 'refunded', 'شارژ کیف پول', 'http://localhost:8000/payment/verify', '09121111116', '{\"message\":\"success\",\"result\":100,\"refNumber\":null,\"paidAt\":\"2026-06-02T15:03:05.883000\",\"status\":1,\"amount\":500000,\"orderId\":\"4\",\"description\":\"\\u0634\\u0627\\u0631\\u0698 \\u06a9\\u06cc\\u0641 \\u067e\\u0648\\u0644\",\"multiplexingInfos\":[],\"cardNumber\":null}', '2026-06-02 11:33:02', '2026-06-02 12:54:08', NULL, NULL);
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('5', '7', '3', '699000', '69900', '0', 'zarinpal', 'subscription', 'S000000000000000000000000000000d6x37', NULL, 'pending', 'خرید اشتراک پریمیوم سالانه', 'http://localhost:8000/payment/verify', '09121111116', '{\"data\":{\"authority\":\"S000000000000000000000000000000d6x37\",\"fee\":150000,\"fee_type\":\"Merchant\",\"code\":100,\"message\":\"Success\"},\"errors\":[]}', '2026-06-02 11:33:39', '2026-06-02 11:33:40', 'App\\Models\\Subscription', '3');
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('6', '7', '4', '699000', '69900', '0', 'zibal', 'subscription', '4612003299', NULL, 'failed', 'خرید اشتراک پریمیوم سالانه', 'http://localhost:8000/payment/verify', '09121111116', '{\"message\":\"success\",\"result\":100,\"trackId\":4612003299}', '2026-06-02 11:33:59', '2026-06-02 11:34:05', 'App\\Models\\Subscription', '4');
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('7', '7', NULL, '699000', '69900', '0', 'zarinpal', 'subscription', NULL, NULL, 'failed', 'خرید اشتراک پریمیوم سالانه', 'http://localhost:8000/payment/verify', '09121111116', '{\"success\":false,\"message\":\"\\u062e\\u0637\\u0627 \\u062f\\u0631 \\u0627\\u062a\\u0635\\u0627\\u0644 \\u0628\\u0647 \\u0632\\u0631\\u06cc\\u0646\\u200c\\u067e\\u0627\\u0644: cURL error 28: Operation timed out after 15003 milliseconds with 0 bytes received (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/sandbox.zarinpal.com\\/pg\\/v4\\/payment\\/request.json\"}', '2026-06-02 12:59:23', '2026-06-02 12:59:38', 'App\\Models\\Subscription', '5');
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('8', '7', NULL, '699000', '69900', '0', 'zarinpal', 'subscription', NULL, NULL, 'failed', 'خرید اشتراک پریمیوم سالانه', 'http://localhost:8000/payment/verify', '09121111116', '{\"success\":false,\"message\":\"\\u062e\\u0637\\u0627 \\u062f\\u0631 \\u0627\\u062a\\u0635\\u0627\\u0644 \\u0628\\u0647 \\u0632\\u0631\\u06cc\\u0646\\u200c\\u067e\\u0627\\u0644: cURL error 28: Resolving timed out after 10015 milliseconds (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/sandbox.zarinpal.com\\/pg\\/v4\\/payment\\/request.json\"}', '2026-06-02 14:12:22', '2026-06-02 14:12:36', 'App\\Models\\Subscription', '6');
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('9', '7', NULL, '699000', '69900', '0', 'zibal', 'subscription', NULL, NULL, 'failed', 'خرید اشتراک پریمیوم سالانه', 'http://localhost:8000/payment/verify', '09121111116', '{\"success\":false,\"message\":\"cURL error 28: Operation timed out after 15007 milliseconds with 0 bytes received (see https:\\/\\/curl.haxx.se\\/libcurl\\/c\\/libcurl-errors.html) for https:\\/\\/gateway.zibal.ir\\/v1\\/request\"}', '2026-06-02 14:12:37', '2026-06-02 14:12:52', 'App\\Models\\Subscription', '7');
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('10', '7', '8', '699000', '69900', '0', 'zarinpal', 'subscription', 'S000000000000000000000000000000r1qj2', NULL, 'failed', 'خرید اشتراک پریمیوم سالانه', 'http://localhost:8000/payment/verify', '09121111116', '{\"data\":{\"authority\":\"S000000000000000000000000000000r1qj2\",\"fee\":150000,\"fee_type\":\"Merchant\",\"code\":100,\"message\":\"Success\"},\"errors\":[]}', '2026-06-02 14:15:34', '2026-06-02 14:15:59', 'App\\Models\\Subscription', '8');
INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `amount`, `tax_amount`, `fee_amount`, `gateway`, `payment_type`, `authority`, `ref_id`, `status`, `description`, `callback_url`, `mobile`, `gateway_response`, `created_at`, `updated_at`, `payable_type`, `payable_id`) VALUES ('11', '7', NULL, '400000', '40000', '0', 'zibal', 'artist_subscription', '4612211052', '4612211052', 'paid', 'خرید پلن هنرمند: هنرمند حرفه ای', 'http://localhost:8000/payment/verify', '09121111116', '{\"message\":\"success\",\"result\":100,\"refNumber\":null,\"paidAt\":\"2026-06-02T17:50:20.383000\",\"status\":1,\"amount\":4400000,\"orderId\":\"11\",\"description\":\"\\u062e\\u0631\\u06cc\\u062f \\u067e\\u0644\\u0646 \\u0647\\u0646\\u0631\\u0645\\u0646\\u062f: \\u0647\\u0646\\u0631\\u0645\\u0646\\u062f \\u062d\\u0631\\u0641\\u0647 \\u0627\\u06cc\",\"multiplexingInfos\":[],\"cardNumber\":null}', '2026-06-02 14:20:15', '2026-06-02 14:20:22', 'App\\Models\\ArtistSubscription', '2');


CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('1', 'manage_users', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('2', 'manage_tracks', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('3', 'manage_albums', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('4', 'manage_artists', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('5', 'manage_playlists', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('6', 'manage_podcasts', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('7', 'manage_subscriptions', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('8', 'manage_ads', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('9', 'manage_settings', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('10', 'manage_themes', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('11', 'manage_pages', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('12', 'upload_tracks', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('13', 'manage_own_tracks', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('14', 'view_analytics', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');


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

INSERT INTO `plans` (`id`, `name`, `name_fa`, `slug`, `description`, `description_fa`, `type`, `price`, `duration_days`, `trial_days`, `features`, `is_active`, `is_popular`, `sort_order`, `max_devices`, `audio_quality`, `ad_free`, `offline_mode`, `unlimited_skips`, `includes_paid_content`, `includes_downloads`, `can_upload_music`, `max_music_uploads`, `created_at`, `updated_at`) VALUES ('1', 'Free', 'رایگان', 'free', 'Basic access', 'دسترسی پایه', 'free', '0', '0', '0', '[\"\\u06af\\u0648\\u0634 \\u062f\\u0627\\u062f\\u0646 \\u0628\\u0627 \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\",\"\\u06a9\\u06cc\\u0641\\u06cc\\u062a \\u0645\\u0639\\u0645\\u0648\\u0644\\u06cc\"]', '1', '0', '1', '1', 'normal', '0', '0', '0', '0', '0', '0', '0', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `plans` (`id`, `name`, `name_fa`, `slug`, `description`, `description_fa`, `type`, `price`, `duration_days`, `trial_days`, `features`, `is_active`, `is_popular`, `sort_order`, `max_devices`, `audio_quality`, `ad_free`, `offline_mode`, `unlimited_skips`, `includes_paid_content`, `includes_downloads`, `can_upload_music`, `max_music_uploads`, `created_at`, `updated_at`) VALUES ('2', 'Premium Monthly', 'پریمیوم ماهانه', 'premium-monthly', 'Full access monthly', 'دسترسی کامل ماهانه', 'premium', '79000', '30', '1', '[\"\\u0628\\u062f\\u0648\\u0646 \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\",\"\\u06a9\\u06cc\\u0641\\u06cc\\u062a \\u06f3\\u06f2\\u06f0kbps\",\"\\u062f\\u0627\\u0646\\u0644\\u0648\\u062f \\u0622\\u0641\\u0644\\u0627\\u06cc\\u0646\",\"\\u0631\\u062f \\u0646\\u0627\\u0645\\u062d\\u062f\\u0648\\u062f\"]', '1', '1', '2', '3', 'high', '1', '1', '1', '1', '1', '1', '20', '2026-05-29 14:06:34', '2026-05-30 05:55:25');
INSERT INTO `plans` (`id`, `name`, `name_fa`, `slug`, `description`, `description_fa`, `type`, `price`, `duration_days`, `trial_days`, `features`, `is_active`, `is_popular`, `sort_order`, `max_devices`, `audio_quality`, `ad_free`, `offline_mode`, `unlimited_skips`, `includes_paid_content`, `includes_downloads`, `can_upload_music`, `max_music_uploads`, `created_at`, `updated_at`) VALUES ('3', 'Premium Yearly', 'پریمیوم سالانه', 'premium-yearly', 'Full access yearly', 'دسترسی کامل سالانه', 'premium', '699000', '365', '0', '[\"\\u0628\\u062f\\u0648\\u0646 \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\",\"\\u06a9\\u06cc\\u0641\\u06cc\\u062a \\u06f3\\u06f2\\u06f0kbps\",\"\\u062f\\u0627\\u0646\\u0644\\u0648\\u062f \\u0622\\u0641\\u0644\\u0627\\u06cc\\u0646\",\"\\u0631\\u062f \\u0646\\u0627\\u0645\\u062d\\u062f\\u0648\\u062f\",\"\\u06f2\\u06f6\\u066a \\u062a\\u062e\\u0641\\u06cc\\u0641\"]', '1', '0', '3', '5', 'lossless', '1', '1', '1', '0', '0', '0', '0', '2026-05-29 14:06:34', '2026-05-29 14:06:34');


CREATE TABLE `playlist_followers` (
  `user_id` bigint(20) unsigned NOT NULL,
  `playlist_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`playlist_id`),
  KEY `playlist_followers_playlist_id_foreign` (`playlist_id`),
  CONSTRAINT `playlist_followers_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `playlist_followers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



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

INSERT INTO `playlists` (`id`, `user_id`, `title`, `slug`, `description`, `cover_image`, `visibility`, `is_system`, `is_featured`, `is_sponsored`, `followers_count`, `tracks_count`, `total_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', '1', 'بهترین‌های ایران', 'bhtrynhay-ayran', NULL, NULL, 'public', '1', '1', '0', '0', '26', '0', '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL);
INSERT INTO `playlists` (`id`, `user_id`, `title`, `slug`, `description`, `cover_image`, `visibility`, `is_system`, `is_featured`, `is_sponsored`, `followers_count`, `tracks_count`, `total_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', '1', 'آهنگ‌های عاشقانه', 'ahnghay-aaashkanh', NULL, NULL, 'public', '1', '1', '0', '0', '19', '0', '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL);
INSERT INTO `playlists` (`id`, `user_id`, `title`, `slug`, `description`, `cover_image`, `visibility`, `is_system`, `is_featured`, `is_sponsored`, `followers_count`, `tracks_count`, `total_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', '1', 'انرژی‌بخش', 'anrzhybkhsh', NULL, NULL, 'public', '1', '1', '0', '0', '11', '0', '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL);
INSERT INTO `playlists` (`id`, `user_id`, `title`, `slug`, `description`, `cover_image`, `visibility`, `is_system`, `is_featured`, `is_sponsored`, `followers_count`, `tracks_count`, `total_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES ('4', '1', 'آرامش', 'aramsh', NULL, NULL, 'public', '1', '1', '0', '0', '14', '0', '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL);
INSERT INTO `playlists` (`id`, `user_id`, `title`, `slug`, `description`, `cover_image`, `visibility`, `is_system`, `is_featured`, `is_sponsored`, `followers_count`, `tracks_count`, `total_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES ('5', '1', 'رانندگی', 'ranndgy', NULL, NULL, 'public', '1', '1', '0', '0', '23', '0', '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL);
INSERT INTO `playlists` (`id`, `user_id`, `title`, `slug`, `description`, `cover_image`, `visibility`, `is_system`, `is_featured`, `is_sponsored`, `followers_count`, `tracks_count`, `total_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES ('6', '8', 'تو ماشین', 'to-mashyn', 'قثلقثلثق', 'playlists/BS65PhxfYt2xvjZaojsBLH92OtkytgysFcz0tl2R.png', 'public', '0', '0', '0', '0', '0', '0', '2026-05-29 20:06:03', '2026-05-29 20:06:03', NULL);


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

INSERT INTO `podcast_episodes` (`id`, `podcast_id`, `title`, `slug`, `description`, `show_notes`, `cover_image`, `file_path`, `file_url`, `duration`, `season_number`, `episode_number`, `status`, `published_at`, `is_explicit`, `is_premium_only`, `is_downloadable`, `play_count`, `like_count`, `repost_count`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', '1', 'قسمت اول', 'ksmt-aol', 'رقرق', 'یادداشت نمایشی', NULL, 'podcasts/episodes/audio/01KSTH22CV418J4H5C9CETE7JD.mp3', NULL, '1694', '1', '1', 'published', NULL, '1', '0', '1', '0', '1', '1', '2026-05-29 18:48:31', '2026-05-30 07:53:52', NULL);
INSERT INTO `podcast_episodes` (`id`, `podcast_id`, `title`, `slug`, `description`, `show_notes`, `cover_image`, `file_path`, `file_url`, `duration`, `season_number`, `episode_number`, `status`, `published_at`, `is_explicit`, `is_premium_only`, `is_downloadable`, `play_count`, `like_count`, `repost_count`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', '1', 'تانزانیا', 'tanzanya', 'ثقرثقر', NULL, NULL, 'podcasts/episodes/audio/01KSVVP8Y15RG5H39TMWZA0TV4.mp3', NULL, '1694', '2', '1', 'published', '2026-05-30 00:00:00', '0', '0', '1', '0', '0', '0', '2026-05-30 07:13:33', '2026-05-30 07:53:10', NULL);


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

INSERT INTO `podcast_subscriptions` (`id`, `user_id`, `podcast_id`, `created_at`, `updated_at`) VALUES ('1', '1', '1', '2026-05-29 18:39:09', '2026-05-29 18:39:09');
INSERT INTO `podcast_subscriptions` (`id`, `user_id`, `podcast_id`, `created_at`, `updated_at`) VALUES ('2', '8', '1', '2026-05-30 07:10:15', '2026-05-30 07:10:15');


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

INSERT INTO `podcasts` (`id`, `user_id`, `artist_id`, `title`, `slug`, `description`, `cover_image`, `category`, `language`, `status`, `is_explicit`, `is_featured`, `is_premium_only`, `subscribers_count`, `repost_count`, `comment_count`, `share_count`, `like_count`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', '6', '5', 'موز', 'moz', 'توضیحات پادکست', 'podcasts/covers/01KSTGFVXRWTP2EKWKFRT4R9EJ.png', 'پاپ', 'fa', 'published', '1', '1', '0', '2', '0', '0', '0', '0', '2026-05-29 18:38:34', '2026-05-30 07:15:28', NULL);


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

INSERT INTO `recently_played` (`id`, `user_id`, `playable_type`, `playable_id`, `progress`, `played_at`) VALUES ('1', '8', 'App\\Models\\Track', '43', '27', '2026-05-30 08:31:34');
INSERT INTO `recently_played` (`id`, `user_id`, `playable_type`, `playable_id`, `progress`, `played_at`) VALUES ('2', '8', 'App\\Models\\Track', '34', '258', '2026-05-30 10:13:40');


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

INSERT INTO `reports` (`id`, `user_id`, `reportable_type`, `reportable_id`, `reason`, `description`, `status`, `admin_note`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES ('1', '8', 'App\\Models\\Track', '40', 'violence', 'لددلدلبدلبدلب', 'resolved', '  رز رز رز ر', '1', '2026-05-29 20:11:06', '2026-05-29 19:31:07', '2026-05-29 20:11:06');


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

INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('1', '2', 'App\\Models\\Track', '1', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('2', '3', 'App\\Models\\Track', '16', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('3', '4', 'App\\Models\\Track', '14', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('4', '5', 'App\\Models\\Track', '25', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('5', '6', 'App\\Models\\Track', '25', NULL, '2026-05-30 06:12:00', '2026-05-30 06:12:00');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('6', '8', 'App\\Models\\Track', '34', NULL, '2026-05-30 06:30:35', '2026-05-30 06:30:35');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('9', '7', 'App\\Models\\Album', '1', NULL, '2026-05-30 07:08:50', '2026-05-30 07:08:50');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('10', '8', 'App\\Models\\Album', '1', NULL, '2026-05-30 07:09:08', '2026-05-30 07:09:08');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('16', '7', 'App\\Models\\Track', '30', NULL, '2026-05-30 07:16:23', '2026-05-30 07:16:23');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('18', '7', 'App\\Models\\Album', '3', '127.0.0.1', '2026-05-30 07:41:06', '2026-05-30 07:41:06');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('20', '7', 'App\\Models\\PodcastEpisode', '1', '127.0.0.1', '2026-05-30 07:53:12', '2026-05-30 07:53:12');
INSERT INTO `reposts` (`id`, `user_id`, `repostable_type`, `repostable_id`, `ip_address`, `created_at`, `updated_at`) VALUES ('21', '7', 'App\\Models\\Track', '34', '127.0.0.1', '2026-05-30 09:47:48', '2026-05-30 09:47:48');


CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('2', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('2', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('3', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('3', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('5', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('5', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('6', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('8', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('9', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('10', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('11', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('12', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('12', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('13', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('13', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('14', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('14', '3');


CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('2', 'moderator', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('3', 'artist', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('4', 'listener', 'web', '2026-05-29 14:06:31', '2026-05-29 14:06:31');


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

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('ebVmTXe2w4UFSQtyauCkqP2awQ3tkmB8JsZLJwbh', '7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:151.0) Gecko/20100101 Firefox/151.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkcxR2xIOENaSU5yd2I0U2tGNGtVeElKSmZaYUdOdktYVEN0R2RWZyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NztzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNDoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FwaS9hdWRpby1hZCI7czo1OiJyb3V0ZSI7czoxMjoiYXBpLmF1ZGlvLWFkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1780469806');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('UbyNmLo7IV9mVsFpSwqjgR8FAfdk6PlJiEBoSLAQ', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiclBScHZrN1lSeDVFYmRGanVJTThjam04TDRlUWVrVTlSalltaVRjWiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vc3lzdGVtLXVwZGF0ZSI7czo1OiJyb3V0ZSI7czozNDoiZmlsYW1lbnQuYWRtaW4ucGFnZXMuc3lzdGVtLXVwZGF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjNhNmVlMjU2OWI2MThlMjdiOGFmNjBlZjFhOTNmMzZiNTliNmRmMzZkZjRkOWMzZmMxZmU3YzY2Mjk1NjkzZWQiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', '1780469820');


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

INSERT INTO `sms_providers` (`id`, `name`, `driver`, `credentials`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'ملی پیامک', 'melipayamak', '{\"username\":\"09356963201\",\"password\":\"RTO$H\",\"from\":\"\",\"otp_pattern\":\"387751\"}', '1', '2026-05-30 10:39:16', '2026-06-02 14:59:24');
INSERT INTO `sms_providers` (`id`, `name`, `driver`, `credentials`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Sms.ir', 'smsir', '{\"api_key\":\"\",\"line_number\":\"\",\"otp_pattern\":\"\"}', '0', '2026-05-30 10:39:16', '2026-06-02 14:59:24');


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

INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('1', '8', '43', '27', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 08:31:34', '2026-05-30 08:31:34');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('2', '8', '34', '287', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 09:50:29', '2026-05-30 09:50:29');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('3', '8', '34', '287', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 09:51:00', '2026-05-30 09:51:00');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('4', '8', '34', '287', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 09:51:15', '2026-05-30 09:51:15');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('5', '8', '34', '87', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 09:51:32', '2026-05-30 09:51:32');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('6', '8', '34', '44', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 09:52:36', '2026-05-30 09:52:36');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('7', '8', '34', '13', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 09:53:04', '2026-05-30 09:53:04');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('8', '8', '34', '92', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 09:56:18', '2026-05-30 09:56:18');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('9', '8', '34', '182', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:02:44', '2026-05-30 10:02:44');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('10', '8', '34', '31', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:03:43', '2026-05-30 10:03:43');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('11', '8', '34', '61', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:04:14', '2026-05-30 10:04:14');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('12', '8', '34', '91', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:04:44', '2026-05-30 10:04:44');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('13', '8', '34', '121', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:05:14', '2026-05-30 10:05:14');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('14', '8', '34', '151', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:05:44', '2026-05-30 10:05:44');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('15', '8', '34', '181', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:06:13', '2026-05-30 10:06:13');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('16', '8', '34', '211', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:06:44', '2026-05-30 10:06:44');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('17', '8', '34', '241', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:07:13', '2026-05-30 10:07:13');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('18', '8', '34', '258', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:07:31', '2026-05-30 10:07:31');
INSERT INTO `streams` (`id`, `user_id`, `track_id`, `duration_listened`, `completed`, `ip_address`, `user_agent`, `country`, `device_type`, `created_at`, `updated_at`) VALUES ('19', '8', '34', '258', '0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'IR', 'web', '2026-05-30 10:13:40', '2026-05-30 10:13:40');


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

INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `status`, `starts_at`, `expires_at`, `cancelled_at`, `auto_renew`, `is_trial`, `created_at`, `updated_at`) VALUES ('1', '8', '2', 'active', '2026-05-29 15:19:35', '2026-05-30 15:19:35', NULL, '0', '0', '2026-05-29 15:19:35', '2026-05-29 15:19:35');
INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `status`, `starts_at`, `expires_at`, `cancelled_at`, `auto_renew`, `is_trial`, `created_at`, `updated_at`) VALUES ('2', '7', '3', 'pending', '2026-06-02 10:58:06', '2027-06-02 10:58:06', NULL, '0', '0', '2026-06-02 10:58:06', '2026-06-02 10:58:06');
INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `status`, `starts_at`, `expires_at`, `cancelled_at`, `auto_renew`, `is_trial`, `created_at`, `updated_at`) VALUES ('3', '7', '3', 'pending', '2026-06-02 11:33:39', '2027-06-02 11:33:39', NULL, '0', '0', '2026-06-02 11:33:39', '2026-06-02 11:33:39');
INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `status`, `starts_at`, `expires_at`, `cancelled_at`, `auto_renew`, `is_trial`, `created_at`, `updated_at`) VALUES ('4', '7', '3', 'pending', '2026-06-02 11:33:59', '2027-06-02 11:33:59', NULL, '0', '0', '2026-06-02 11:33:59', '2026-06-02 11:33:59');
INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `status`, `starts_at`, `expires_at`, `cancelled_at`, `auto_renew`, `is_trial`, `created_at`, `updated_at`) VALUES ('8', '7', '3', 'pending', '2026-06-02 14:15:34', '2027-06-02 14:15:34', NULL, '0', '0', '2026-06-02 14:15:34', '2026-06-02 14:15:34');


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

INSERT INTO `theme_settings` (`id`, `key`, `value`, `group`, `type`, `label`, `label_fa`, `created_at`, `updated_at`) VALUES ('1', 'primary_color', '#0ea5e9', 'colors', 'color', 'Primary Color', 'رنگ اصلی', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `theme_settings` (`id`, `key`, `value`, `group`, `type`, `label`, `label_fa`, `created_at`, `updated_at`) VALUES ('2', 'accent_color', '#d946ef', 'colors', 'color', 'Accent Color', 'رنگ ثانویه', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `theme_settings` (`id`, `key`, `value`, `group`, `type`, `label`, `label_fa`, `created_at`, `updated_at`) VALUES ('3', 'font_body', 'YekanBakh', 'typography', 'text', 'Body Font', 'فونت بدنه', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `theme_settings` (`id`, `key`, `value`, `group`, `type`, `label`, `label_fa`, `created_at`, `updated_at`) VALUES ('4', 'font_heading', 'Peyda', 'typography', 'text', 'Heading Font', 'فونت عنوان', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `theme_settings` (`id`, `key`, `value`, `group`, `type`, `label`, `label_fa`, `created_at`, `updated_at`) VALUES ('5', 'dark_mode_default', 'true', 'general', 'boolean', 'Dark Mode Default', 'حالت تاریک پیش‌فرض', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `theme_settings` (`id`, `key`, `value`, `group`, `type`, `label`, `label_fa`, `created_at`, `updated_at`) VALUES ('6', 'site_name', 'ملودیام', 'general', 'text', 'Site Name', 'نام سایت', '2026-05-29 14:06:34', '2026-05-29 14:06:34');
INSERT INTO `theme_settings` (`id`, `key`, `value`, `group`, `type`, `label`, `label_fa`, `created_at`, `updated_at`) VALUES ('7', 'site_description', 'پلتفرم استریم موسیقی فارسی', 'general', 'text', 'Site Description', 'توضیح سایت', '2026-05-29 14:06:34', '2026-05-29 14:06:34');


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

INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('1', '1', NULL, NULL, '1', '3', 'دلتنگی', 'Track 1', 'dltngy', NULL, NULL, '209', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-09 14:06:34', '2025-06-17', '0', '1776654', '51932', '0', '0', '1', '0', 'energetic', '60', NULL, NULL, NULL, NULL, '2026-05-29 14:06:34', '2026-05-30 06:12:00', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('2', '1', NULL, NULL, '1', '1', 'عشق', 'Track 2', 'aashk', NULL, NULL, '248', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-19 14:06:34', '2026-02-12', '1', '4301763', '399006', '0', '0', '0', '0', 'sad', '119', NULL, NULL, NULL, NULL, '2026-05-29 14:06:34', '2026-05-29 14:06:34', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('3', '1', NULL, NULL, '1', '1', 'آسمان', 'Track 3', 'asman', NULL, NULL, '223', '3', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-02 14:06:35', '2026-05-28', '0', '1185877', '248342', '0', '0', '0', '0', 'happy', '176', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('4', '1', NULL, NULL, '1', '12', 'شب', 'Track 4', 'shb', NULL, NULL, '187', '4', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-17 14:06:35', '2025-12-20', '1', '1054246', '239251', '0', '0', '0', '0', 'energetic', '73', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('5', '1', NULL, NULL, '1', '9', 'با تو', 'Track 5', 'ba-to', NULL, NULL, '309', '5', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-11 14:06:35', '2025-09-29', '0', '3801846', '221499', '0', '0', '0', '0', 'calm', '109', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('6', '1', NULL, NULL, '1', '1', 'بی تو', 'Track 6', 'by-to', NULL, NULL, '287', '6', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-19 14:06:35', '2025-06-25', '0', '3555017', '362267', '0', '0', '0', '0', 'sad', '141', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('7', '2', NULL, NULL, '2', '3', 'دلتنگی', 'Track 1', 'dltngy-1', NULL, NULL, '194', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-30 14:06:35', '2026-04-07', '1', '667500', '205082', '0', '0', '0', '0', 'romantic', '95', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('8', '2', NULL, NULL, '2', '10', 'ستاره', 'Track 2', 'starh', NULL, NULL, '300', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-15 14:06:35', '2025-12-29', '1', '3879778', '215617', '0', '0', '0', '0', 'energetic', '135', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('9', '2', NULL, NULL, '2', '12', 'رویا', 'Track 3', 'roya', NULL, NULL, '209', '3', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-18 14:06:35', '2025-10-08', '0', '2588574', '166303', '0', '0', '0', '0', 'sad', '149', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('10', '2', NULL, NULL, '2', '1', 'دریا', 'Track 4', 'drya', NULL, NULL, '269', '4', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-22 14:06:35', '2025-12-06', '0', '3792991', '315158', '0', '0', '0', '0', 'sad', '70', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('11', '2', NULL, NULL, '2', '12', 'سکوت', 'Track 5', 'skot', NULL, NULL, '320', '5', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-18 14:06:35', '2026-03-18', '1', '4909125', '351795', '0', '0', '0', '0', 'romantic', '88', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('12', '2', NULL, NULL, '2', '5', 'فریاد', 'Track 6', 'fryad', NULL, NULL, '263', '6', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-07 14:06:35', '2026-02-28', '0', '2459194', '378111', '0', '0', '0', '0', 'happy', '68', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('13', '2', NULL, NULL, '2', '4', 'با تو', 'Track 7', 'ba-to-1', NULL, NULL, '217', '7', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-23 14:06:35', '2025-11-15', '1', '2711740', '359449', '0', '0', '0', '0', 'energetic', '93', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('14', '2', NULL, NULL, '2', '11', 'بی تو', 'Track 8', 'by-to-1', NULL, NULL, '287', '8', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-02 14:06:35', '2025-08-03', '0', '2720018', '23909', '0', '0', '1', '0', 'energetic', '67', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 06:12:00', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('15', '3', NULL, NULL, '3', '9', 'دلتنگی', 'Track 1', 'dltngy-2', NULL, NULL, '210', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-21 14:06:35', '2025-11-12', '1', '2051825', '136055', '0', '0', '0', '0', 'happy', '156', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('16', '3', NULL, NULL, '3', '7', 'عشق', 'Track 2', 'aashk-1', NULL, NULL, '300', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-24 14:06:35', '2025-09-11', '1', '1524302', '319832', '0', '0', '1', '0', 'happy', '76', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 06:12:00', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('17', '3', NULL, NULL, '3', '6', 'خاطره', 'Track 3', 'khatrh', NULL, NULL, '287', '3', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-13 14:06:35', '2026-01-03', '1', '4155436', '111592', '0', '0', '0', '0', 'energetic', '121', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('18', '3', NULL, NULL, '3', '11', 'نگاه', 'Track 4', 'ngah', NULL, NULL, '225', '4', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-19 14:06:35', '2025-08-10', '0', '1376100', '151972', '0', '0', '0', '0', 'energetic', '74', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('19', '3', NULL, NULL, '3', '3', 'امید', 'Track 5', 'amyd', NULL, NULL, '282', '5', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-06 14:06:35', '2025-12-08', '1', '4883259', '91456', '0', '0', '0', '0', 'sad', '148', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('20', '3', NULL, NULL, '3', '4', 'سکوت', 'Track 6', 'skot-1', NULL, NULL, '286', '6', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-08 14:06:35', '2026-05-14', '0', '4515538', '409857', '0', '0', '0', '0', 'happy', '140', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('21', '3', NULL, NULL, '3', '12', 'فریاد', 'Track 7', 'fryad-1', NULL, NULL, '226', '7', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-27 14:06:35', '2026-05-18', '1', '2512991', '495332', '0', '0', '0', '0', 'sad', '71', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('22', '4', NULL, NULL, '4', '3', 'رویا', 'Track 1', 'roya-1', NULL, NULL, '307', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-16 14:06:35', '2026-03-05', '1', '1295039', '37384', '0', '0', '0', '0', 'calm', '117', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('23', '4', NULL, NULL, '4', '2', 'دریا', 'Track 2', 'drya-1', NULL, NULL, '352', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-12 14:06:35', '2025-07-05', '0', '3666119', '8323', '0', '0', '0', '0', 'romantic', '158', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('24', '4', NULL, NULL, '4', '4', 'ماه', 'Track 3', 'mah', NULL, NULL, '267', '3', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-29 14:06:35', '2026-01-16', '0', '3877352', '294464', '0', '0', '0', '0', 'sad', '180', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('25', '4', NULL, NULL, '4', '11', 'آرامش', 'Track 4', 'aramsh', NULL, NULL, '240', '4', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-29 14:06:35', '2026-02-06', '0', '1216688', '262819', '0', '0', '2', '0', 'sad', '69', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 06:12:00', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('26', '4', NULL, NULL, '4', '10', 'سکوت', 'Track 5', 'skot-2', NULL, NULL, '283', '5', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-10 14:06:35', '2026-02-02', '1', '3931810', '35390', '0', '0', '0', '0', 'sad', '139', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('27', '5', NULL, NULL, '5', '2', 'دلتنگی', 'Track 1', 'dltngy-3', NULL, NULL, '298', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-03 14:06:35', '2025-10-07', '0', '3528252', '158192', '0', '0', '0', '0', 'romantic', '126', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('28', '5', NULL, NULL, '5', '8', 'بهار', 'Track 2', 'bhar', NULL, NULL, '210', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-18 14:06:35', '2026-04-17', '0', '4014427', '359323', '0', '0', '0', '0', 'calm', '130', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('29', '5', NULL, NULL, '5', '12', 'ستاره', 'Track 3', 'starh-1', NULL, NULL, '242', '3', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-12 14:06:35', '2025-10-20', '0', '4874940', '378388', '0', '0', '0', '0', 'calm', '87', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('30', '5', NULL, NULL, '5', '12', 'آسمان', 'Track 4', 'asman-1', NULL, NULL, '200', '4', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-23 14:06:35', '2025-06-09', '1', '4048643', '452916', '0', '0', '2', '0', 'calm', '113', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 07:16:23', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('31', '5', NULL, NULL, '5', '4', 'باران', 'Track 5', 'baran', NULL, NULL, '346', '5', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-17 14:06:35', '2026-03-14', '1', '1005379', '362891', '0', '0', '0', '0', 'sad', '87', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('32', '5', NULL, NULL, '5', '3', 'فردا', 'Track 6', 'frda', NULL, NULL, '275', '6', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-17 14:06:35', '2025-07-25', '0', '2183793', '338484', '0', '0', '0', '0', 'romantic', '78', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('33', '5', NULL, NULL, '5', '5', 'نگاه', 'Track 7', 'ngah-1', NULL, NULL, '274', '7', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-23 14:06:35', '2025-09-09', '0', '3070873', '33728', '0', '0', '0', '0', 'happy', '60', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('34', '6', NULL, NULL, '6', '10', 'رویا', NULL, 'roya-2', NULL, NULL, '343', '1', '1', 'tracks/audio/01KSW4PMQA8QWBG4NMA3VXRKD4.mp3', NULL, NULL, NULL, 'dbbsdbds', NULL, 'fa', '0', '0', '0', 'published', '2026-03-30 14:06:35', '2025-12-13', '1', '1278812', '283987', '0', '0', '2', '0', 'romantic', '91', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-30 10:13:40', NULL, '200000', NULL, '10', '1');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('35', '6', NULL, NULL, '6', '10', 'دریا', 'Track 2', 'drya-2', NULL, NULL, '250', '2', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-13 14:06:35', '2025-12-10', '1', '2656452', '36090', '0', '0', '0', '0', 'calm', '166', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('36', '6', NULL, NULL, '6', '5', 'آسمان', 'Track 3', 'asman-2', NULL, NULL, '270', '3', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-20 14:06:35', '2025-06-12', '0', '4220271', '205687', '0', '0', '0', '0', 'energetic', '80', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('37', '6', NULL, NULL, '6', '7', 'شب', 'Track 4', 'shb-1', NULL, NULL, '228', '4', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-20 14:06:35', '2026-04-12', '1', '4761469', '135696', '0', '0', '0', '0', 'romantic', '128', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('38', '6', NULL, NULL, '6', '12', 'خاطره', 'Track 5', 'khatrh-1', NULL, NULL, '214', '5', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-28 14:06:35', '2025-06-05', '0', '3378787', '361604', '0', '0', '0', '0', 'energetic', '61', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('39', '6', NULL, NULL, '6', '3', 'نگاه', 'Track 6', 'ngah-2', NULL, NULL, '203', '6', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-05-18 14:06:35', '2026-04-23', '0', '2979045', '69074', '0', '0', '0', '0', 'calm', '123', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('40', '6', NULL, NULL, '6', '2', 'آرامش', 'Track 7', 'aramsh-1', NULL, NULL, '227', '7', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '0', '0', '0', 'published', '2026-04-16 14:06:35', '2025-07-03', '1', '3445815', '442815', '0', '0', '0', '0', 'romantic', '146', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 14:06:35', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('41', '6', NULL, NULL, '6', '12', 'سکوت', 'Track 8', 'skot-3', NULL, NULL, '331', '8', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fa', '1', '0', '0', 'published', '2026-05-26 14:06:35', '2026-02-27', '1', '1084217', '391122', '0', '0', '0', '0', 'happy', '87', NULL, NULL, NULL, NULL, '2026-05-29 14:06:35', '2026-05-29 18:31:52', NULL, NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('42', NULL, NULL, '8', NULL, '4', 'اهنگ باحال', NULL, 'ahng-bahal-4364', 'خیلی اهنگ باحالی هست', 'tracks/covers/SHfK6vf0agAU2rS3cgkHA6WcWVlOVOWq2Vtro0Ff.png', '0', NULL, '1', 'tracks/audio/UbpIpJQuOO0LJnYQYs7rxDhwNUBNgZt1Q1jFSKch.mp3', NULL, 'tracks/audio/UbpIpJQuOO0LJnYQYs7rxDhwNUBNgZt1Q1jFSKch.mp3', NULL, NULL, NULL, 'fa', '0', '0', '0', 'pending', NULL, NULL, '0', '0', '0', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-30 08:11:16', '2026-05-30 08:27:35', '2026-05-30 08:27:35', NULL, NULL, '0', '0');
INSERT INTO `tracks` (`id`, `artist_id`, `artist_name`, `user_id`, `album_id`, `genre_id`, `title`, `title_en`, `slug`, `description`, `cover_image`, `duration`, `track_number`, `disc_number`, `file_path`, `file_path_128`, `file_path_320`, `file_url`, `lyrics`, `synced_lyrics`, `language`, `is_explicit`, `is_downloadable`, `is_premium_only`, `status`, `published_at`, `release_date`, `is_featured`, `play_count`, `like_count`, `download_count`, `share_count`, `repost_count`, `comment_count`, `mood`, `bpm`, `key_signature`, `isrc`, `seo_title`, `seo_description`, `created_at`, `updated_at`, `deleted_at`, `price`, `discount_price`, `preview_seconds`, `is_for_sale`) VALUES ('43', NULL, 'پیشرو', '8', NULL, '4', 'اهنگ باحال', NULL, 'ahng-bahal', 'توضیحات اهنگ', 'tracks/covers/0RMylLDDUvXxT5iVTdm4R9eznKr0xkYI4UWl2iNe.png', '1545', NULL, '1', 'tracks/audio/Ng8NBVqzc5BmqwecS2nCeE3buFGqo3sxUGD0qCVJ.mp3', NULL, 'tracks/audio/Ng8NBVqzc5BmqwecS2nCeE3buFGqo3sxUGD0qCVJ.mp3', NULL, 'فقفافقا', NULL, 'fa', '0', '0', '0', 'published', '2026-05-30 08:30:08', NULL, '0', '0', '0', '0', '0', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-30 08:29:28', '2026-05-30 08:30:08', NULL, NULL, NULL, '0', '0');


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

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', 'مدیر سیستم', NULL, 'admin@melodiyam.ir', '09120000000', '2026-05-29 14:06:32', '2026-05-29 14:06:32', '$2y$12$IHpPAZxsl2DJMjLQ9a.wSeKZTQpE5rb4Hv/6S77KZPZiG/2ctrc6.', NULL, NULL, NULL, NULL, 'IR', NULL, 'admin', '1', '0', NULL, NULL, '0WYoz7Ek2qZuZMWPD3guclsJdZdZD5sJ86gyDqNrFuy6OfNv8C5NcDaqgiPw', '2026-05-29 14:06:32', '2026-05-29 14:06:32', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', 'محسن چاوشی', NULL, NULL, '09121111111', NULL, '2026-05-29 14:06:32', '$2y$12$o3DmwOta9UM.RU/jB/qnx.IZIViLB3uoXMhkyQDDAg74U8aDFWB4u', NULL, NULL, NULL, NULL, 'IR', NULL, 'artist', '1', '0', NULL, NULL, NULL, '2026-05-29 14:06:32', '2026-05-29 14:06:32', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', 'سیروان خسروی', NULL, NULL, '09121111112', NULL, '2026-05-29 14:06:32', '$2y$12$eIOweaG759aU2P33UVXGVO0MNdQTrNB6ZSlnQjNwpM20MnI1/LYum', NULL, NULL, NULL, NULL, 'IR', NULL, 'artist', '1', '0', NULL, NULL, NULL, '2026-05-29 14:06:32', '2026-05-29 14:06:32', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('4', 'رضا بهرام', NULL, NULL, '09121111113', NULL, '2026-05-29 14:06:33', '$2y$12$sAG4abCqKyL.XHoqTZ0RRODAlpojwUM210h1/7qM9RTfSy3qp7.ye', NULL, NULL, NULL, NULL, 'IR', NULL, 'artist', '1', '0', NULL, NULL, NULL, '2026-05-29 14:06:33', '2026-05-29 14:06:33', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('5', 'همایون شجریان', NULL, NULL, '09121111114', NULL, '2026-05-29 14:06:33', '$2y$12$hjV4OU95yBZktZ5Vy6gOYOdOtfMSEvhCkiwMVH3eExsDzJjKJrUBS', NULL, NULL, NULL, NULL, 'IR', NULL, 'artist', '1', '0', NULL, NULL, NULL, '2026-05-29 14:06:33', '2026-05-29 14:06:33', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('6', 'حامد همایون', NULL, NULL, '09121111115', NULL, '2026-05-29 14:06:34', '$2y$12$27G0SOOlbqHM3hfzCGz5puMXu9juUuABaLOW1omegKOdc9fJyACE.', NULL, NULL, NULL, NULL, 'IR', NULL, 'artist', '1', '0', NULL, NULL, NULL, '2026-05-29 14:06:34', '2026-05-29 14:06:34', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('7', 'مهراد هیدن', NULL, 'farnad25@gmail.com', '09121111116', NULL, '2026-05-29 14:06:34', '$2y$12$mFMvO0pnULF4lSwxEJtGleoEa3l1N7eqKtFQtC2CdMZ6Q9hNPasSK', NULL, NULL, NULL, NULL, 'IR', 'mashhad', 'artist', '1', '0', NULL, NULL, 'KMpzRGtuHwGgARzOiRconwJHXsvkevgMyud8HFAfJD6IOv1OkxHV9tkGVCMa', '2026-05-29 14:06:34', '2026-05-29 15:12:24', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('8', 'فرناد باباپور', NULL, 'farnad24@gmail.com', NULL, NULL, NULL, '$2y$12$dU93SUleNyNhAQoAUdPHieBlfawnv0c6Ls9Jut.yh0rNTHLSAbSt6', 'avatars/01KSTJ41HV6NNYRBRK33ZKAFX6.png', NULL, NULL, NULL, 'IR', NULL, 'listener', '1', '1', '2026-05-30 00:00:00', NULL, 'S9vtlq8RN4KWNYjlbLIQoM2mpN76E9mm4tYezZ3IDyYqnLizGgpAJgRpI2a5', '2026-05-29 14:48:18', '2026-05-29 19:07:04', NULL);
INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `avatar`, `bio`, `birth_date`, `gender`, `country`, `city`, `type`, `is_active`, `is_premium`, `premium_expires_at`, `preferences`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES ('9', 'ممد', NULL, NULL, '09356963201', NULL, '2026-05-30 20:15:42', NULL, NULL, NULL, NULL, NULL, 'IR', NULL, 'listener', '1', '0', NULL, NULL, 'q4aaeBETWIZYGuyEJfOuCcgF2PCJ2Z4AS0fwOw3ScCZja4MCXQZ9Io1HvU2B', '2026-05-30 20:15:42', '2026-05-30 20:15:42', NULL);


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

INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('1', '2', 'deposit', 'approved', '8883000', '8883000', 'درآمد پخش (بازگشتی): آهنگ «دلتنگی» | 1776654 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '1', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('2', '2', 'deposit', 'approved', '21508500', '30391500', 'درآمد پخش (بازگشتی): آهنگ «عشق» | 4301763 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '2', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('3', '2', 'deposit', 'approved', '5929000', '36320500', 'درآمد پخش (بازگشتی): آهنگ «آسمان» | 1185877 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '3', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('4', '2', 'deposit', 'approved', '5271000', '41591500', 'درآمد پخش (بازگشتی): آهنگ «شب» | 1054246 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '4', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('5', '2', 'deposit', 'approved', '19009000', '60600500', 'درآمد پخش (بازگشتی): آهنگ «با تو» | 3801846 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '5', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('6', '2', 'deposit', 'approved', '17775000', '78375500', 'درآمد پخش (بازگشتی): آهنگ «بی تو» | 3555017 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '6', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('7', '3', 'deposit', 'approved', '3337500', '3337500', 'درآمد پخش (بازگشتی): آهنگ «دلتنگی» | 667500 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '7', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('8', '3', 'deposit', 'approved', '19398500', '22736000', 'درآمد پخش (بازگشتی): آهنگ «ستاره» | 3879778 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '8', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('9', '3', 'deposit', 'approved', '12942500', '35678500', 'درآمد پخش (بازگشتی): آهنگ «رویا» | 2588574 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '9', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('10', '3', 'deposit', 'approved', '18964500', '54643000', 'درآمد پخش (بازگشتی): آهنگ «دریا» | 3792991 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '10', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('11', '3', 'deposit', 'approved', '24545500', '79188500', 'درآمد پخش (بازگشتی): آهنگ «سکوت» | 4909125 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '11', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('12', '3', 'deposit', 'approved', '12295500', '91484000', 'درآمد پخش (بازگشتی): آهنگ «فریاد» | 2459194 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '12', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('13', '3', 'deposit', 'approved', '13558500', '105042500', 'درآمد پخش (بازگشتی): آهنگ «با تو» | 2711740 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '13', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('14', '3', 'deposit', 'approved', '13600000', '118642500', 'درآمد پخش (بازگشتی): آهنگ «بی تو» | 2720018 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '14', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('15', '4', 'deposit', 'approved', '10259000', '10259000', 'درآمد پخش (بازگشتی): آهنگ «دلتنگی» | 2051825 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '15', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('16', '4', 'deposit', 'approved', '7621500', '17880500', 'درآمد پخش (بازگشتی): آهنگ «عشق» | 1524302 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '16', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('17', '4', 'deposit', 'approved', '20777000', '38657500', 'درآمد پخش (بازگشتی): آهنگ «خاطره» | 4155436 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '17', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('18', '4', 'deposit', 'approved', '6880500', '45538000', 'درآمد پخش (بازگشتی): آهنگ «نگاه» | 1376100 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '18', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('19', '4', 'deposit', 'approved', '24416000', '69954000', 'درآمد پخش (بازگشتی): آهنگ «امید» | 4883259 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '19', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('20', '4', 'deposit', 'approved', '22577500', '92531500', 'درآمد پخش (بازگشتی): آهنگ «سکوت» | 4515538 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '20', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('21', '4', 'deposit', 'approved', '12564500', '105096000', 'درآمد پخش (بازگشتی): آهنگ «فریاد» | 2512991 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '21', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('22', '5', 'deposit', 'approved', '6475000', '6475000', 'درآمد پخش (بازگشتی): آهنگ «رویا» | 1295039 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '22', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('23', '5', 'deposit', 'approved', '18330500', '24805500', 'درآمد پخش (بازگشتی): آهنگ «دریا» | 3666119 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '23', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('24', '5', 'deposit', 'approved', '19386500', '44192000', 'درآمد پخش (بازگشتی): آهنگ «ماه» | 3877352 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '24', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('25', '5', 'deposit', 'approved', '6083000', '50275000', 'درآمد پخش (بازگشتی): آهنگ «آرامش» | 1216688 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '25', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('26', '5', 'deposit', 'approved', '19659000', '69934000', 'درآمد پخش (بازگشتی): آهنگ «سکوت» | 3931810 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '26', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('27', '6', 'deposit', 'approved', '17641000', '17641000', 'درآمد پخش (بازگشتی): آهنگ «دلتنگی» | 3528252 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '27', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('28', '6', 'deposit', 'approved', '20072000', '37713000', 'درآمد پخش (بازگشتی): آهنگ «بهار» | 4014427 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '28', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('29', '6', 'deposit', 'approved', '24374500', '62087500', 'درآمد پخش (بازگشتی): آهنگ «ستاره» | 4874940 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '29', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('30', '6', 'deposit', 'approved', '20243000', '82330500', 'درآمد پخش (بازگشتی): آهنگ «آسمان» | 4048643 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '30', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('31', '6', 'deposit', 'approved', '5026500', '87357000', 'درآمد پخش (بازگشتی): آهنگ «باران» | 1005379 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '31', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('32', '6', 'deposit', 'approved', '10918500', '98275500', 'درآمد پخش (بازگشتی): آهنگ «فردا» | 2183793 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '32', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('33', '6', 'deposit', 'approved', '15354000', '113629500', 'درآمد پخش (بازگشتی): آهنگ «نگاه» | 3070873 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '33', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('34', '7', 'deposit', 'approved', '6394000', '6394000', 'درآمد پخش (بازگشتی): آهنگ «رویا» | 1278808 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '34', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('35', '7', 'deposit', 'approved', '13282000', '19676000', 'درآمد پخش (بازگشتی): آهنگ «دریا» | 2656452 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '35', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('36', '7', 'deposit', 'approved', '21101000', '40777000', 'درآمد پخش (بازگشتی): آهنگ «آسمان» | 4220271 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '36', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('37', '7', 'deposit', 'approved', '23807000', '64584000', 'درآمد پخش (بازگشتی): آهنگ «شب» | 4761469 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '37', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('38', '7', 'deposit', 'approved', '16893500', '81477500', 'درآمد پخش (بازگشتی): آهنگ «خاطره» | 3378787 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '38', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('39', '7', 'deposit', 'approved', '14895000', '96372500', 'درآمد پخش (بازگشتی): آهنگ «نگاه» | 2979045 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '39', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('40', '7', 'deposit', 'approved', '17229000', '113601500', 'درآمد پخش (بازگشتی): آهنگ «آرامش» | 3445815 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '40', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('41', '7', 'deposit', 'approved', '5421000', '119022500', 'درآمد پخش (بازگشتی): آهنگ «سکوت» | 1084217 پخش', NULL, NULL, NULL, NULL, NULL, NULL, 'App\\Models\\ArtistEarning', '41', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `type`, `status`, `amount`, `balance_after`, `description`, `reference_number`, `card_number`, `receipt_image`, `admin_note`, `reviewed_by`, `reviewed_at`, `transactionable_type`, `transactionable_id`, `created_at`, `updated_at`) VALUES ('42', '7', 'deposit', 'approved', '50000', '119072500', 'شارژ آنلاین کیف پول — درگاه: زیبال — کد پیگیری: 4612002025', '4612002025', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-02 11:33:09', '2026-06-02 11:33:09');


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

INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('1', '8', '0', '2026-05-29 15:16:12', '2026-05-29 15:16:12');
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('2', '2', '78375500', '2026-05-29 19:12:13', '2026-05-29 19:12:13');
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('3', '3', '118642500', '2026-05-29 19:12:13', '2026-05-29 19:12:14');
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('4', '4', '105096000', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('5', '5', '69934000', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('6', '6', '113629500', '2026-05-29 19:12:14', '2026-05-29 19:12:14');
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('7', '7', '119072500', '2026-05-29 19:12:14', '2026-06-02 11:33:09');
INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES ('8', '9', '0', '2026-06-02 14:40:29', '2026-06-02 14:40:29');
