/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `author_id` int unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hero_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  `view_count` bigint DEFAULT NULL,
  `tweet_id` bigint unsigned DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `shared_at` datetime DEFAULT NULL,
  `declined_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  UNIQUE KEY `articles_uuid_unique` (`uuid`),
  KEY `articles_author_id_foreign` (`author_id`),
  CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `blocked_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blocked_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `blocked_user_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blocked_users_user_id_foreign` (`user_id`),
  KEY `blocked_users_blocked_user_id_foreign` (`blocked_user_id`),
  CONSTRAINT `blocked_users_blocked_user_id_foreign` FOREIGN KEY (`blocked_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blocked_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `likeable_id` int unsigned NOT NULL,
  `likeable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `monitored_scheduled_task_log_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitored_scheduled_task_log_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `monitored_scheduled_task_id` bigint unsigned NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_scheduled_task_id` (`monitored_scheduled_task_id`),
  CONSTRAINT `fk_scheduled_task_id` FOREIGN KEY (`monitored_scheduled_task_id`) REFERENCES `monitored_scheduled_tasks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `monitored_scheduled_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitored_scheduled_tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_expression` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ping_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_started_at` datetime DEFAULT NULL,
  `last_finished_at` datetime DEFAULT NULL,
  `last_failed_at` datetime DEFAULT NULL,
  `last_skipped_at` datetime DEFAULT NULL,
  `registered_on_oh_dear_at` datetime DEFAULT NULL,
  `last_pinged_at` datetime DEFAULT NULL,
  `grace_time_in_minutes` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
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
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `replies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int unsigned NOT NULL,
  `replyable_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `replyable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int unsigned DEFAULT NULL,
  `deleted_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `replies_uuid_unique` (`uuid`),
  KEY `replies_author_id_index` (`author_id`),
  KEY `replies_replyable_id_index` (`replyable_id`),
  KEY `replies_replyable_type_index` (`replyable_type`),
  KEY `replies_deleted_by_foreign` (`deleted_by`),
  CONSTRAINT `replies_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `replies_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `spam_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spam_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reporter_id` int unsigned NOT NULL,
  `spam_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spam_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spam_reports_reporter_id_spam_id_spam_type_unique` (`reporter_id`,`spam_id`,`spam_type`),
  KEY `spam_reports_spam_type_spam_id_index` (`spam_type`,`spam_id`),
  CONSTRAINT `spam_reports_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `subscriptionable_id` int NOT NULL,
  `subscriptionable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `subscriptions_uuid_unique` (`uuid`),
  UNIQUE KEY `subscriptions_are_unique` (`user_id`,`subscriptionable_id`,`subscriptionable_type`),
  KEY `subscriptions_uuid_index` (`uuid`),
  KEY `subscriptions_user_id_index` (`user_id`),
  CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taggables` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `taggable_id` int NOT NULL,
  `tag_id` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `taggable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `taggables_taggable_id_index` (`taggable_id`),
  KEY `taggables_tag_id_index` (`tag_id`),
  CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name_unique` (`name`),
  UNIQUE KEY `tags_slug_unique` (`slug`),
  KEY `tags_slug_index` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `threads` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `author_id` int unsigned NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `solution_reply_id` int unsigned DEFAULT NULL,
  `resolved_by` int unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `locked_at` timestamp NULL DEFAULT NULL,
  `locked_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `threads_slug_unique` (`slug`),
  UNIQUE KEY `threads_uuid_unique` (`uuid`),
  KEY `threads_author_id_index` (`author_id`),
  KEY `threads_slug_index` (`slug`),
  KEY `threads_solution_reply_id_index` (`solution_reply_id`),
  KEY `threads_resolved_by_foreign` (`resolved_by`),
  KEY `threads_last_activity_at_index` (`last_activity_at`),
  KEY `threads_locked_by_foreign` (`locked_by`),
  CONSTRAINT `threads_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `threads_locked_by_foreign` FOREIGN KEY (`locked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `threads_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `threads_solution_reply_id_foreign` FOREIGN KEY (`solution_reply_id`) REFERENCES `replies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `github_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `github_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` smallint unsigned NOT NULL DEFAULT '1',
  `bio` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `banned_at` datetime DEFAULT NULL,
  `banned_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `allowed_notifications` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_github_id_unique` (`github_id`),
  KEY `users_email_index` (`email`),
  KEY `users_username_index` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2013_09_17_113019_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2013_09_17_121043_create_session_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2013_09_17_160916_create_roles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2013_09_17_164244_create_role_user_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2013_09_17_170055_add_is_banned_field_to_users',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2013_09_18_115103_create_pastes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2013_09_19_101701_create_comments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2013_09_19_104855_create_activity_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2013_09_22_130010_add_image_url_field_to_users',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2013_09_22_130711_add_type_field_to_comments',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2013_09_22_163103_create_articles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2013_09_22_163347_create_tags_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2013_09_22_163816_create_article_tag_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2013_09_23_111349_add_description_field_to_tags',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2013_09_23_121454_add_published_at_field_to_articles',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2013_09_23_160937_add_comment_counter_cache_to_articles',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2013_09_24_145833_create_contributors_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2013_09_27_014229_add_soft_delete_to_articles',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2013_09_27_015000_add_soft_delete_to_users',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2013_09_27_015109_add_soft_delete_to_comments',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2013_09_27_021650_add_soft_delete_to_pastes',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2013_10_24_131412_create_comment_tag_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2013_10_30_104107_add_tag_section_fields',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2013_12_08_161643_comments_add_laravel_version',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2013_12_14_151829_articles_add_laravel_verion_field',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2014_01_27_135001_forum_threads_create_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2014_01_27_141317_forum_replies_create_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2014_01_31_140118_tagged_items_create_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2014_02_01_022633_pastes_add_hash_field',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2014_02_07_125035_forum_threads_add_question_fields',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2014_02_07_144708_forum_threads_add_solution_reply_id',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2014_02_07_155103_forum_thread_visitation_timestamps_create_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2014_05_30_115728_users_add_remember_me_token',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2014_09_10_112330_add_ip_to_pastes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2014_11_09_185116_pinned_threads',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2014_12_07_143131_add_user_confirmation_columns',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2014_12_13_164931_create_ip_columns',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2014_12_13_210738_add_spam_counter_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2014_12_21_212154_remove_contributors_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2015_04_12_171949_add_indexes',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2015_04_12_172949_add_indexes_to_tagged_items',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2015_07_26_160128_l5_cleanup',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2015_08_26_191523_drop_unused_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2017_04_08_104959_next_version',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2017_07_08_202506_add_user_bio_column',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2017_08_29_123258_add_banned_at_column',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2017_10_18_193001_create_subscriptions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2017_12_03_111900_create_likes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2018_01_27_111437_fix_subscription_indexes',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2018_02_20_215439_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2018_05_22_191538_cleanup_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2020_01_09_193921_create_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2020_04_07_181731_create_series_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2020_04_07_185543_create_community_articles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2020_07_16_185353_add_twitter_columns',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2020_10_01_093001_add_email_verified_at_column_to_users',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2020_11_03_205735_add_uuid_to_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2020_11_22_194212_create_schedule_monitor_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2021_03_10_161050_add_index_to_replyable_type',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2021_07_05_205125_remove_series',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2021_07_23_110409_update_articles_table_add_hero_image_field',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2021_07_31_183222_unique_github_ids',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2021_09_12_220452_add_resolved_by_to_threads_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2021_10_31_143501_add_declined_at_column_to_articles_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2021_11_15_213258_add_updated_by_to_threads_and_replies_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2021_11_22_093555_migrate_thread_feed_to_timestamp',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2021_10_12_170118_add_locked_by_column_to_threads_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2019_12_14_000001_create_personal_access_tokens_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (69,'2022_04_06_152416_add_uuids_to_tables',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (70,'2022_05_10_180922_make_uuids_non_nullable',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2022_06_14_072001_create_blocked_users_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (72,'2022_07_09_191433_update_articles_table_add_view_count',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (73,'2022_07_29_135113_add__website_to_users_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (74,'2022_08_21_215918_add_soft_delete_columns_to_replies_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (75,'2022_07_08_145847_create_spam_reports_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (76,'2022_10_15_150405_add_banned_reason_to_users_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (77,'2022_12_11_145605_add_expires_at_column_sanctum',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (78,'2023_01_31_190506_add_allowed_notifications_column_to_users_table',13);
