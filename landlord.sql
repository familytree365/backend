/*
 Navicat Premium Data Transfer

 Source Server         : family365
 Source Server Type    : MySQL
 Source Server Version : 100420
 Source Host           : localhost:3306
 Source Schema         : landlord

 Target Server Type    : MySQL
 Target Server Version : 100420
 File Encoding         : 65001

 Date: 18/07/2021 06:04:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for chat_members
-- ----------------------------
DROP TABLE IF EXISTS `chat_members`;
CREATE TABLE `chat_members`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `latest_read_msg` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `chat_members_chat_id_foreign`(`chat_id`) USING BTREE,
  CONSTRAINT `chat_members_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chat_members
-- ----------------------------

-- ----------------------------
-- Table structure for chat_messages
-- ----------------------------
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `reply_to` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `chat_messages_chat_id_foreign`(`chat_id`) USING BTREE,
  INDEX `chat_messages_reply_to_foreign`(`reply_to`) USING BTREE,
  CONSTRAINT `chat_messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `chat_messages_reply_to_foreign` FOREIGN KEY (`reply_to`) REFERENCES `chat_messages` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chat_messages
-- ----------------------------

-- ----------------------------
-- Table structure for chats
-- ----------------------------
DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `chat_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `chat_type` enum('private','group') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chats
-- ----------------------------

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_tenant` tinyint(4) NOT NULL,
  `reg_com_nr` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fiscal_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fax` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `website` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bank` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bank_account` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `pays_vat` tinyint(1) NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `companies_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `companies_reg_com_nr_unique`(`reg_com_nr`) USING BTREE,
  UNIQUE INDEX `companies_fiscal_code_unique`(`fiscal_code`) USING BTREE,
  INDEX `companies_created_by_index`(`created_by`) USING BTREE,
  INDEX `companies_updated_by_index`(`updated_by`) USING BTREE,
  CONSTRAINT `companies_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `companies_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES (1, 'companyS3kiZ', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `companies` VALUES (2, 'company1k2oq', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for geneanums
-- ----------------------------
DROP TABLE IF EXISTS `geneanums`;
CREATE TABLE `geneanums`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `remote_id` int(10) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `area` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `geneanums_remote_id_index`(`remote_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of geneanums
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED NULL DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2020_12_04_000001_create_landlord_tenants_table', 1);
INSERT INTO `migrations` VALUES (2, '2020_12_04_000002_create_users_table', 1);
INSERT INTO `migrations` VALUES (3, '2020_12_04_000003_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (4, '2020_12_04_000004_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2020_12_04_000005_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (6, '2020_12_04_000006_create_providers_table', 1);
INSERT INTO `migrations` VALUES (7, '2020_12_04_000007_create_companies_table', 1);
INSERT INTO `migrations` VALUES (8, '2020_12_04_000008_create_trees_table', 1);
INSERT INTO `migrations` VALUES (9, '2020_12_04_000009_create_user_company_table', 1);
INSERT INTO `migrations` VALUES (10, '2020_12_10_000010_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (11, '2020_12_11_064235_create_chats_table', 1);
INSERT INTO `migrations` VALUES (12, '2020_12_11_084150_create_chat_messages_table', 1);
INSERT INTO `migrations` VALUES (13, '2020_12_12_000011_create_subscriptions_table', 1);
INSERT INTO `migrations` VALUES (14, '2020_12_12_000012_create_subscription_items_table', 1);
INSERT INTO `migrations` VALUES (15, '2020_12_12_000013_create_customer_columns', 1);
INSERT INTO `migrations` VALUES (16, '2020_12_14_100837_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (17, '2021_05_14_095040_create_geneanums_table', 1);
INSERT INTO `migrations` VALUES (18, '2021_05_30_082351_create_chat_members_table', 1);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 2);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for paypal_subscriptions
-- ----------------------------
DROP TABLE IF EXISTS `paypal_subscriptions`;
CREATE TABLE `paypal_subscriptions`  (
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `paypal_plan_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `trial_ends_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ends_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of paypal_subscriptions
-- ----------------------------
INSERT INTO `paypal_subscriptions` VALUES ('I-8E4MTXLC6KDC', 'sb-gqsay6818823@personal.example.com', 'P-31Y92464Y7778851XMDZ5NWI', 'CANCELLED', NULL, '2021-07-18T12:55:05Z', NULL, '2021-07-18T12:59:49+00:00');
INSERT INTO `paypal_subscriptions` VALUES ('I-J5RXMVTMFMV9', 'sb-gqsay6818823@personal.example.com', 'P-6WD81784CB1285200MDZ5NVY', 'CANCELLED', NULL, '2021-07-18T13:00:47Z', NULL, '2021-07-18T13:02:06+00:00');
INSERT INTO `paypal_subscriptions` VALUES ('I-VG6UXS6NLFKF', 'sb-gqsay6818823@personal.example.com', 'P-75J58827YA5370404MDZ5NXI', 'ACTIVE', NULL, '2021-07-18T13:03:39Z', NULL, NULL);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 147 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'dashboard menu', 'web', '2021-07-14 07:31:53', '2021-07-14 07:31:53');
INSERT INTO `permissions` VALUES (2, 'calendar menu', 'web', '2021-07-14 07:31:53', '2021-07-14 07:31:53');
INSERT INTO `permissions` VALUES (3, 'files menu', 'web', '2021-07-14 07:31:53', '2021-07-14 07:31:53');
INSERT INTO `permissions` VALUES (4, 'company menu', 'web', '2021-07-14 07:31:53', '2021-07-14 07:31:53');
INSERT INTO `permissions` VALUES (5, 'company index', 'web', '2021-07-14 07:31:53', '2021-07-14 07:31:53');
INSERT INTO `permissions` VALUES (6, 'company create', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (7, 'company edit', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (8, 'company delete', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (9, 'information menu', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (10, 'objects index', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (11, 'objects create', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (12, 'objects edit', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (13, 'objects delete', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (14, 'addresses index', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (15, 'addresses create', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (16, 'addresses edit', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (17, 'addresses delete', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (18, 'chan index', 'web', '2021-07-14 07:31:54', '2021-07-14 07:31:54');
INSERT INTO `permissions` VALUES (19, 'chan create', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (20, 'chan edit', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (21, 'chan delete', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (22, 'refn index', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (23, 'refn create', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (24, 'refn edit', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (25, 'refn delete', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (26, 'subm index', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (27, 'subm create', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (28, 'subm edit', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (29, 'subm delete', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (30, 'subn index', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (31, 'subn create', 'web', '2021-07-14 07:31:55', '2021-07-14 07:31:55');
INSERT INTO `permissions` VALUES (32, 'subn edit', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (33, 'subn delete', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (34, 'sources menu', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (35, 'repositories index', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (36, 'repositories create', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (37, 'repositories edit', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (38, 'repositories delete', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (39, 'sources index', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (40, 'sources create', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (41, 'sources edit', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (42, 'sources delete', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (43, 'source data index', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (44, 'source data create', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (45, 'source data edit', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (46, 'source data delete', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (47, 'source data events index', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (48, 'source data events create', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (49, 'source data events edit', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (50, 'source data events delete', 'web', '2021-07-14 07:31:56', '2021-07-14 07:31:56');
INSERT INTO `permissions` VALUES (51, 'source ref events index', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (52, 'source ref events create', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (53, 'source ref events edit', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (54, 'source ref events delete', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (55, 'people menu', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (56, 'people index', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (57, 'people create', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (58, 'people edit', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (59, 'people delete', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (60, 'person aliases index', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (61, 'person aliases create', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (62, 'person aliases edit', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (63, 'person aliases delete', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (64, 'person anci index', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (65, 'person anci create', 'web', '2021-07-14 07:31:57', '2021-07-14 07:31:57');
INSERT INTO `permissions` VALUES (66, 'person anci edit', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (67, 'person anci delete', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (68, 'person association index', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (69, 'person association create', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (70, 'person association edit', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (71, 'person association delete', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (72, 'person events index', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (73, 'person events create', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (74, 'person events edit', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (75, 'person events delete', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (76, 'person lds index', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (77, 'person lds create', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (78, 'person lds edit', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (79, 'person lds delete', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (80, 'person subm index', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (81, 'person subm create', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (82, 'person subm edit', 'web', '2021-07-14 07:31:58', '2021-07-14 07:31:58');
INSERT INTO `permissions` VALUES (83, 'person subm delete', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (84, 'family menu', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (85, 'families index', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (86, 'families create', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (87, 'families edit', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (88, 'families delete', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (89, 'family events index', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (90, 'family events create', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (91, 'family events edit', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (92, 'family events delete', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (93, 'family slugs index', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (94, 'family slugs create', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (95, 'family slugs edit', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (96, 'family slugs delete', 'web', '2021-07-14 07:31:59', '2021-07-14 07:31:59');
INSERT INTO `permissions` VALUES (97, 'references menu', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (98, 'citations index', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (99, 'citations create', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (100, 'citations edit', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (101, 'citations delete', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (102, 'notes index', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (103, 'notes create', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (104, 'notes edit', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (105, 'notes delete', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (106, 'places index', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (107, 'places create', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (108, 'places edit', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (109, 'places delete', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (110, 'authors index', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (111, 'authors create', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (112, 'authors edit', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (113, 'authors delete', 'web', '2021-07-14 07:32:00', '2021-07-14 07:32:00');
INSERT INTO `permissions` VALUES (114, 'publications index', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (115, 'publications create', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (116, 'publications edit', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (117, 'publications delete', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (118, 'trees menu', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (119, 'trees index', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (120, 'trees create', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (121, 'trees edit', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (122, 'trees delete', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (123, 'trees show index', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (124, 'trees show create', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (125, 'trees show edit', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (126, 'trees show delete', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (127, 'pedigree index', 'web', '2021-07-14 07:32:01', '2021-07-14 07:32:01');
INSERT INTO `permissions` VALUES (128, 'pedigree create', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (129, 'pedigree edit', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (130, 'pedigree delete', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (131, 'forum menu', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (132, 'subjects index', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (133, 'subjects create', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (134, 'subjects edit', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (135, 'subjects delete', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (136, 'categories index', 'web', '2021-07-14 07:32:02', '2021-07-14 07:32:02');
INSERT INTO `permissions` VALUES (137, 'categories create', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (138, 'categories edit', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (139, 'categories delete', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (140, 'gedcom import menu', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (141, 'subscription menu', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (142, 'dna upload menu', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (143, 'dna matching menu', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (144, 'how to videos menu', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (145, 'roles menu', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');
INSERT INTO `permissions` VALUES (146, 'permissions menu', 'web', '2021-07-14 07:32:03', '2021-07-14 07:32:03');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for plans
-- ----------------------------
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans`  (
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `usage_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `create_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plans` VALUES ('P-031199954H539443FMDZ5NYA', 'OTM', 'ACTIVE', 'One tree monthly 1', 'LICENSED', '2021-07-18T07:23:12Z');
INSERT INTO `plans` VALUES ('P-0DC0251318201921YMDZ5NXA', 'TTY', 'ACTIVE', 'Ten trees yearly', 'LICENSED', '2021-07-18T07:23:08Z');
INSERT INTO `plans` VALUES ('P-31Y92464Y7778851XMDZ5NWI', 'UTM', 'ACTIVE', 'Unlimited trees monthly', 'LICENSED', '2021-07-18T07:23:05Z');
INSERT INTO `plans` VALUES ('P-6H243390X0396303KMDZ5NXQ', 'OTY', 'ACTIVE', 'One tree yearly', 'LICENSED', '2021-07-18T07:23:10Z');
INSERT INTO `plans` VALUES ('P-6WD81784CB1285200MDZ5NVY', 'UTY', 'ACTIVE', 'Unlimited trees yearly', 'LICENSED', '2021-07-18T07:23:03Z');
INSERT INTO `plans` VALUES ('P-75J58827YA5370404MDZ5NXI', 'TTM', 'ACTIVE', 'Ten trees monthly', 'LICENSED', '2021-07-18T07:23:09Z');

-- ----------------------------
-- Table structure for providers
-- ----------------------------
DROP TABLE IF EXISTS `providers`;
CREATE TABLE `providers`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `providers_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of providers
-- ----------------------------

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (1, 3);
INSERT INTO `role_has_permissions` VALUES (1, 4);
INSERT INTO `role_has_permissions` VALUES (1, 5);
INSERT INTO `role_has_permissions` VALUES (1, 6);
INSERT INTO `role_has_permissions` VALUES (1, 7);
INSERT INTO `role_has_permissions` VALUES (1, 8);
INSERT INTO `role_has_permissions` VALUES (1, 9);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (2, 3);
INSERT INTO `role_has_permissions` VALUES (2, 4);
INSERT INTO `role_has_permissions` VALUES (2, 5);
INSERT INTO `role_has_permissions` VALUES (2, 6);
INSERT INTO `role_has_permissions` VALUES (2, 7);
INSERT INTO `role_has_permissions` VALUES (2, 8);
INSERT INTO `role_has_permissions` VALUES (2, 9);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (3, 3);
INSERT INTO `role_has_permissions` VALUES (3, 4);
INSERT INTO `role_has_permissions` VALUES (3, 5);
INSERT INTO `role_has_permissions` VALUES (3, 6);
INSERT INTO `role_has_permissions` VALUES (3, 7);
INSERT INTO `role_has_permissions` VALUES (3, 8);
INSERT INTO `role_has_permissions` VALUES (3, 9);
INSERT INTO `role_has_permissions` VALUES (4, 1);
INSERT INTO `role_has_permissions` VALUES (4, 3);
INSERT INTO `role_has_permissions` VALUES (4, 4);
INSERT INTO `role_has_permissions` VALUES (4, 5);
INSERT INTO `role_has_permissions` VALUES (4, 6);
INSERT INTO `role_has_permissions` VALUES (4, 7);
INSERT INTO `role_has_permissions` VALUES (4, 8);
INSERT INTO `role_has_permissions` VALUES (4, 9);
INSERT INTO `role_has_permissions` VALUES (5, 1);
INSERT INTO `role_has_permissions` VALUES (5, 3);
INSERT INTO `role_has_permissions` VALUES (5, 4);
INSERT INTO `role_has_permissions` VALUES (5, 5);
INSERT INTO `role_has_permissions` VALUES (5, 6);
INSERT INTO `role_has_permissions` VALUES (5, 7);
INSERT INTO `role_has_permissions` VALUES (5, 8);
INSERT INTO `role_has_permissions` VALUES (5, 9);
INSERT INTO `role_has_permissions` VALUES (6, 1);
INSERT INTO `role_has_permissions` VALUES (6, 3);
INSERT INTO `role_has_permissions` VALUES (6, 4);
INSERT INTO `role_has_permissions` VALUES (6, 5);
INSERT INTO `role_has_permissions` VALUES (6, 6);
INSERT INTO `role_has_permissions` VALUES (6, 7);
INSERT INTO `role_has_permissions` VALUES (6, 8);
INSERT INTO `role_has_permissions` VALUES (6, 9);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (7, 3);
INSERT INTO `role_has_permissions` VALUES (7, 4);
INSERT INTO `role_has_permissions` VALUES (7, 5);
INSERT INTO `role_has_permissions` VALUES (7, 6);
INSERT INTO `role_has_permissions` VALUES (7, 7);
INSERT INTO `role_has_permissions` VALUES (7, 8);
INSERT INTO `role_has_permissions` VALUES (7, 9);
INSERT INTO `role_has_permissions` VALUES (8, 1);
INSERT INTO `role_has_permissions` VALUES (8, 3);
INSERT INTO `role_has_permissions` VALUES (8, 4);
INSERT INTO `role_has_permissions` VALUES (8, 5);
INSERT INTO `role_has_permissions` VALUES (8, 6);
INSERT INTO `role_has_permissions` VALUES (8, 7);
INSERT INTO `role_has_permissions` VALUES (8, 8);
INSERT INTO `role_has_permissions` VALUES (8, 9);
INSERT INTO `role_has_permissions` VALUES (9, 9);
INSERT INTO `role_has_permissions` VALUES (10, 1);
INSERT INTO `role_has_permissions` VALUES (10, 3);
INSERT INTO `role_has_permissions` VALUES (10, 4);
INSERT INTO `role_has_permissions` VALUES (10, 5);
INSERT INTO `role_has_permissions` VALUES (10, 6);
INSERT INTO `role_has_permissions` VALUES (10, 7);
INSERT INTO `role_has_permissions` VALUES (10, 8);
INSERT INTO `role_has_permissions` VALUES (10, 9);
INSERT INTO `role_has_permissions` VALUES (11, 1);
INSERT INTO `role_has_permissions` VALUES (11, 3);
INSERT INTO `role_has_permissions` VALUES (11, 4);
INSERT INTO `role_has_permissions` VALUES (11, 5);
INSERT INTO `role_has_permissions` VALUES (11, 6);
INSERT INTO `role_has_permissions` VALUES (11, 7);
INSERT INTO `role_has_permissions` VALUES (11, 8);
INSERT INTO `role_has_permissions` VALUES (11, 9);
INSERT INTO `role_has_permissions` VALUES (12, 1);
INSERT INTO `role_has_permissions` VALUES (12, 3);
INSERT INTO `role_has_permissions` VALUES (12, 4);
INSERT INTO `role_has_permissions` VALUES (12, 5);
INSERT INTO `role_has_permissions` VALUES (12, 6);
INSERT INTO `role_has_permissions` VALUES (12, 7);
INSERT INTO `role_has_permissions` VALUES (12, 8);
INSERT INTO `role_has_permissions` VALUES (12, 9);
INSERT INTO `role_has_permissions` VALUES (13, 1);
INSERT INTO `role_has_permissions` VALUES (13, 3);
INSERT INTO `role_has_permissions` VALUES (13, 4);
INSERT INTO `role_has_permissions` VALUES (13, 5);
INSERT INTO `role_has_permissions` VALUES (13, 6);
INSERT INTO `role_has_permissions` VALUES (13, 7);
INSERT INTO `role_has_permissions` VALUES (13, 8);
INSERT INTO `role_has_permissions` VALUES (13, 9);
INSERT INTO `role_has_permissions` VALUES (14, 1);
INSERT INTO `role_has_permissions` VALUES (14, 3);
INSERT INTO `role_has_permissions` VALUES (14, 4);
INSERT INTO `role_has_permissions` VALUES (14, 5);
INSERT INTO `role_has_permissions` VALUES (14, 6);
INSERT INTO `role_has_permissions` VALUES (14, 7);
INSERT INTO `role_has_permissions` VALUES (14, 8);
INSERT INTO `role_has_permissions` VALUES (14, 9);
INSERT INTO `role_has_permissions` VALUES (15, 1);
INSERT INTO `role_has_permissions` VALUES (15, 3);
INSERT INTO `role_has_permissions` VALUES (15, 4);
INSERT INTO `role_has_permissions` VALUES (15, 5);
INSERT INTO `role_has_permissions` VALUES (15, 6);
INSERT INTO `role_has_permissions` VALUES (15, 7);
INSERT INTO `role_has_permissions` VALUES (15, 8);
INSERT INTO `role_has_permissions` VALUES (15, 9);
INSERT INTO `role_has_permissions` VALUES (16, 1);
INSERT INTO `role_has_permissions` VALUES (16, 3);
INSERT INTO `role_has_permissions` VALUES (16, 4);
INSERT INTO `role_has_permissions` VALUES (16, 5);
INSERT INTO `role_has_permissions` VALUES (16, 6);
INSERT INTO `role_has_permissions` VALUES (16, 7);
INSERT INTO `role_has_permissions` VALUES (16, 8);
INSERT INTO `role_has_permissions` VALUES (16, 9);
INSERT INTO `role_has_permissions` VALUES (17, 1);
INSERT INTO `role_has_permissions` VALUES (17, 3);
INSERT INTO `role_has_permissions` VALUES (17, 4);
INSERT INTO `role_has_permissions` VALUES (17, 5);
INSERT INTO `role_has_permissions` VALUES (17, 6);
INSERT INTO `role_has_permissions` VALUES (17, 7);
INSERT INTO `role_has_permissions` VALUES (17, 8);
INSERT INTO `role_has_permissions` VALUES (17, 9);
INSERT INTO `role_has_permissions` VALUES (18, 1);
INSERT INTO `role_has_permissions` VALUES (18, 3);
INSERT INTO `role_has_permissions` VALUES (18, 4);
INSERT INTO `role_has_permissions` VALUES (18, 5);
INSERT INTO `role_has_permissions` VALUES (18, 6);
INSERT INTO `role_has_permissions` VALUES (18, 7);
INSERT INTO `role_has_permissions` VALUES (18, 8);
INSERT INTO `role_has_permissions` VALUES (18, 9);
INSERT INTO `role_has_permissions` VALUES (19, 1);
INSERT INTO `role_has_permissions` VALUES (19, 3);
INSERT INTO `role_has_permissions` VALUES (19, 4);
INSERT INTO `role_has_permissions` VALUES (19, 5);
INSERT INTO `role_has_permissions` VALUES (19, 6);
INSERT INTO `role_has_permissions` VALUES (19, 7);
INSERT INTO `role_has_permissions` VALUES (19, 8);
INSERT INTO `role_has_permissions` VALUES (19, 9);
INSERT INTO `role_has_permissions` VALUES (20, 1);
INSERT INTO `role_has_permissions` VALUES (20, 3);
INSERT INTO `role_has_permissions` VALUES (20, 4);
INSERT INTO `role_has_permissions` VALUES (20, 5);
INSERT INTO `role_has_permissions` VALUES (20, 6);
INSERT INTO `role_has_permissions` VALUES (20, 7);
INSERT INTO `role_has_permissions` VALUES (20, 8);
INSERT INTO `role_has_permissions` VALUES (20, 9);
INSERT INTO `role_has_permissions` VALUES (21, 1);
INSERT INTO `role_has_permissions` VALUES (21, 3);
INSERT INTO `role_has_permissions` VALUES (21, 4);
INSERT INTO `role_has_permissions` VALUES (21, 5);
INSERT INTO `role_has_permissions` VALUES (21, 6);
INSERT INTO `role_has_permissions` VALUES (21, 7);
INSERT INTO `role_has_permissions` VALUES (21, 8);
INSERT INTO `role_has_permissions` VALUES (21, 9);
INSERT INTO `role_has_permissions` VALUES (22, 1);
INSERT INTO `role_has_permissions` VALUES (22, 3);
INSERT INTO `role_has_permissions` VALUES (22, 4);
INSERT INTO `role_has_permissions` VALUES (22, 5);
INSERT INTO `role_has_permissions` VALUES (22, 6);
INSERT INTO `role_has_permissions` VALUES (22, 7);
INSERT INTO `role_has_permissions` VALUES (22, 8);
INSERT INTO `role_has_permissions` VALUES (22, 9);
INSERT INTO `role_has_permissions` VALUES (23, 1);
INSERT INTO `role_has_permissions` VALUES (23, 3);
INSERT INTO `role_has_permissions` VALUES (23, 4);
INSERT INTO `role_has_permissions` VALUES (23, 5);
INSERT INTO `role_has_permissions` VALUES (23, 6);
INSERT INTO `role_has_permissions` VALUES (23, 7);
INSERT INTO `role_has_permissions` VALUES (23, 8);
INSERT INTO `role_has_permissions` VALUES (23, 9);
INSERT INTO `role_has_permissions` VALUES (24, 1);
INSERT INTO `role_has_permissions` VALUES (24, 3);
INSERT INTO `role_has_permissions` VALUES (24, 4);
INSERT INTO `role_has_permissions` VALUES (24, 5);
INSERT INTO `role_has_permissions` VALUES (24, 6);
INSERT INTO `role_has_permissions` VALUES (24, 7);
INSERT INTO `role_has_permissions` VALUES (24, 8);
INSERT INTO `role_has_permissions` VALUES (24, 9);
INSERT INTO `role_has_permissions` VALUES (25, 1);
INSERT INTO `role_has_permissions` VALUES (25, 3);
INSERT INTO `role_has_permissions` VALUES (25, 4);
INSERT INTO `role_has_permissions` VALUES (25, 5);
INSERT INTO `role_has_permissions` VALUES (25, 6);
INSERT INTO `role_has_permissions` VALUES (25, 7);
INSERT INTO `role_has_permissions` VALUES (25, 8);
INSERT INTO `role_has_permissions` VALUES (25, 9);
INSERT INTO `role_has_permissions` VALUES (26, 1);
INSERT INTO `role_has_permissions` VALUES (26, 3);
INSERT INTO `role_has_permissions` VALUES (26, 4);
INSERT INTO `role_has_permissions` VALUES (26, 5);
INSERT INTO `role_has_permissions` VALUES (26, 6);
INSERT INTO `role_has_permissions` VALUES (26, 7);
INSERT INTO `role_has_permissions` VALUES (26, 8);
INSERT INTO `role_has_permissions` VALUES (26, 9);
INSERT INTO `role_has_permissions` VALUES (27, 1);
INSERT INTO `role_has_permissions` VALUES (27, 3);
INSERT INTO `role_has_permissions` VALUES (27, 4);
INSERT INTO `role_has_permissions` VALUES (27, 5);
INSERT INTO `role_has_permissions` VALUES (27, 6);
INSERT INTO `role_has_permissions` VALUES (27, 7);
INSERT INTO `role_has_permissions` VALUES (27, 8);
INSERT INTO `role_has_permissions` VALUES (27, 9);
INSERT INTO `role_has_permissions` VALUES (28, 1);
INSERT INTO `role_has_permissions` VALUES (28, 3);
INSERT INTO `role_has_permissions` VALUES (28, 4);
INSERT INTO `role_has_permissions` VALUES (28, 5);
INSERT INTO `role_has_permissions` VALUES (28, 6);
INSERT INTO `role_has_permissions` VALUES (28, 7);
INSERT INTO `role_has_permissions` VALUES (28, 8);
INSERT INTO `role_has_permissions` VALUES (28, 9);
INSERT INTO `role_has_permissions` VALUES (29, 1);
INSERT INTO `role_has_permissions` VALUES (29, 3);
INSERT INTO `role_has_permissions` VALUES (29, 4);
INSERT INTO `role_has_permissions` VALUES (29, 5);
INSERT INTO `role_has_permissions` VALUES (29, 6);
INSERT INTO `role_has_permissions` VALUES (29, 7);
INSERT INTO `role_has_permissions` VALUES (29, 8);
INSERT INTO `role_has_permissions` VALUES (29, 9);
INSERT INTO `role_has_permissions` VALUES (30, 1);
INSERT INTO `role_has_permissions` VALUES (30, 3);
INSERT INTO `role_has_permissions` VALUES (30, 4);
INSERT INTO `role_has_permissions` VALUES (30, 5);
INSERT INTO `role_has_permissions` VALUES (30, 6);
INSERT INTO `role_has_permissions` VALUES (30, 7);
INSERT INTO `role_has_permissions` VALUES (30, 8);
INSERT INTO `role_has_permissions` VALUES (30, 9);
INSERT INTO `role_has_permissions` VALUES (31, 1);
INSERT INTO `role_has_permissions` VALUES (31, 3);
INSERT INTO `role_has_permissions` VALUES (31, 4);
INSERT INTO `role_has_permissions` VALUES (31, 5);
INSERT INTO `role_has_permissions` VALUES (31, 6);
INSERT INTO `role_has_permissions` VALUES (31, 7);
INSERT INTO `role_has_permissions` VALUES (31, 8);
INSERT INTO `role_has_permissions` VALUES (31, 9);
INSERT INTO `role_has_permissions` VALUES (32, 1);
INSERT INTO `role_has_permissions` VALUES (32, 3);
INSERT INTO `role_has_permissions` VALUES (32, 4);
INSERT INTO `role_has_permissions` VALUES (32, 5);
INSERT INTO `role_has_permissions` VALUES (32, 6);
INSERT INTO `role_has_permissions` VALUES (32, 7);
INSERT INTO `role_has_permissions` VALUES (32, 8);
INSERT INTO `role_has_permissions` VALUES (32, 9);
INSERT INTO `role_has_permissions` VALUES (33, 1);
INSERT INTO `role_has_permissions` VALUES (33, 3);
INSERT INTO `role_has_permissions` VALUES (33, 4);
INSERT INTO `role_has_permissions` VALUES (33, 5);
INSERT INTO `role_has_permissions` VALUES (33, 6);
INSERT INTO `role_has_permissions` VALUES (33, 7);
INSERT INTO `role_has_permissions` VALUES (33, 8);
INSERT INTO `role_has_permissions` VALUES (33, 9);
INSERT INTO `role_has_permissions` VALUES (34, 1);
INSERT INTO `role_has_permissions` VALUES (34, 3);
INSERT INTO `role_has_permissions` VALUES (34, 4);
INSERT INTO `role_has_permissions` VALUES (34, 5);
INSERT INTO `role_has_permissions` VALUES (34, 6);
INSERT INTO `role_has_permissions` VALUES (34, 7);
INSERT INTO `role_has_permissions` VALUES (34, 8);
INSERT INTO `role_has_permissions` VALUES (34, 9);
INSERT INTO `role_has_permissions` VALUES (35, 1);
INSERT INTO `role_has_permissions` VALUES (35, 3);
INSERT INTO `role_has_permissions` VALUES (35, 4);
INSERT INTO `role_has_permissions` VALUES (35, 5);
INSERT INTO `role_has_permissions` VALUES (35, 6);
INSERT INTO `role_has_permissions` VALUES (35, 7);
INSERT INTO `role_has_permissions` VALUES (35, 8);
INSERT INTO `role_has_permissions` VALUES (35, 9);
INSERT INTO `role_has_permissions` VALUES (36, 1);
INSERT INTO `role_has_permissions` VALUES (36, 3);
INSERT INTO `role_has_permissions` VALUES (36, 4);
INSERT INTO `role_has_permissions` VALUES (36, 5);
INSERT INTO `role_has_permissions` VALUES (36, 6);
INSERT INTO `role_has_permissions` VALUES (36, 7);
INSERT INTO `role_has_permissions` VALUES (36, 8);
INSERT INTO `role_has_permissions` VALUES (36, 9);
INSERT INTO `role_has_permissions` VALUES (37, 1);
INSERT INTO `role_has_permissions` VALUES (37, 3);
INSERT INTO `role_has_permissions` VALUES (37, 4);
INSERT INTO `role_has_permissions` VALUES (37, 5);
INSERT INTO `role_has_permissions` VALUES (37, 6);
INSERT INTO `role_has_permissions` VALUES (37, 7);
INSERT INTO `role_has_permissions` VALUES (37, 8);
INSERT INTO `role_has_permissions` VALUES (37, 9);
INSERT INTO `role_has_permissions` VALUES (38, 1);
INSERT INTO `role_has_permissions` VALUES (38, 3);
INSERT INTO `role_has_permissions` VALUES (38, 4);
INSERT INTO `role_has_permissions` VALUES (38, 5);
INSERT INTO `role_has_permissions` VALUES (38, 6);
INSERT INTO `role_has_permissions` VALUES (38, 7);
INSERT INTO `role_has_permissions` VALUES (38, 8);
INSERT INTO `role_has_permissions` VALUES (38, 9);
INSERT INTO `role_has_permissions` VALUES (39, 1);
INSERT INTO `role_has_permissions` VALUES (39, 3);
INSERT INTO `role_has_permissions` VALUES (39, 4);
INSERT INTO `role_has_permissions` VALUES (39, 5);
INSERT INTO `role_has_permissions` VALUES (39, 6);
INSERT INTO `role_has_permissions` VALUES (39, 7);
INSERT INTO `role_has_permissions` VALUES (39, 8);
INSERT INTO `role_has_permissions` VALUES (39, 9);
INSERT INTO `role_has_permissions` VALUES (40, 1);
INSERT INTO `role_has_permissions` VALUES (40, 3);
INSERT INTO `role_has_permissions` VALUES (40, 4);
INSERT INTO `role_has_permissions` VALUES (40, 5);
INSERT INTO `role_has_permissions` VALUES (40, 6);
INSERT INTO `role_has_permissions` VALUES (40, 7);
INSERT INTO `role_has_permissions` VALUES (40, 8);
INSERT INTO `role_has_permissions` VALUES (40, 9);
INSERT INTO `role_has_permissions` VALUES (41, 1);
INSERT INTO `role_has_permissions` VALUES (41, 3);
INSERT INTO `role_has_permissions` VALUES (41, 4);
INSERT INTO `role_has_permissions` VALUES (41, 5);
INSERT INTO `role_has_permissions` VALUES (41, 6);
INSERT INTO `role_has_permissions` VALUES (41, 7);
INSERT INTO `role_has_permissions` VALUES (41, 8);
INSERT INTO `role_has_permissions` VALUES (41, 9);
INSERT INTO `role_has_permissions` VALUES (42, 1);
INSERT INTO `role_has_permissions` VALUES (42, 3);
INSERT INTO `role_has_permissions` VALUES (42, 4);
INSERT INTO `role_has_permissions` VALUES (42, 5);
INSERT INTO `role_has_permissions` VALUES (42, 6);
INSERT INTO `role_has_permissions` VALUES (42, 7);
INSERT INTO `role_has_permissions` VALUES (42, 8);
INSERT INTO `role_has_permissions` VALUES (42, 9);
INSERT INTO `role_has_permissions` VALUES (43, 1);
INSERT INTO `role_has_permissions` VALUES (43, 3);
INSERT INTO `role_has_permissions` VALUES (43, 4);
INSERT INTO `role_has_permissions` VALUES (43, 5);
INSERT INTO `role_has_permissions` VALUES (43, 6);
INSERT INTO `role_has_permissions` VALUES (43, 7);
INSERT INTO `role_has_permissions` VALUES (43, 8);
INSERT INTO `role_has_permissions` VALUES (43, 9);
INSERT INTO `role_has_permissions` VALUES (44, 1);
INSERT INTO `role_has_permissions` VALUES (44, 3);
INSERT INTO `role_has_permissions` VALUES (44, 4);
INSERT INTO `role_has_permissions` VALUES (44, 5);
INSERT INTO `role_has_permissions` VALUES (44, 6);
INSERT INTO `role_has_permissions` VALUES (44, 7);
INSERT INTO `role_has_permissions` VALUES (44, 8);
INSERT INTO `role_has_permissions` VALUES (44, 9);
INSERT INTO `role_has_permissions` VALUES (45, 1);
INSERT INTO `role_has_permissions` VALUES (45, 3);
INSERT INTO `role_has_permissions` VALUES (45, 4);
INSERT INTO `role_has_permissions` VALUES (45, 5);
INSERT INTO `role_has_permissions` VALUES (45, 6);
INSERT INTO `role_has_permissions` VALUES (45, 7);
INSERT INTO `role_has_permissions` VALUES (45, 8);
INSERT INTO `role_has_permissions` VALUES (45, 9);
INSERT INTO `role_has_permissions` VALUES (46, 1);
INSERT INTO `role_has_permissions` VALUES (46, 3);
INSERT INTO `role_has_permissions` VALUES (46, 4);
INSERT INTO `role_has_permissions` VALUES (46, 5);
INSERT INTO `role_has_permissions` VALUES (46, 6);
INSERT INTO `role_has_permissions` VALUES (46, 7);
INSERT INTO `role_has_permissions` VALUES (46, 8);
INSERT INTO `role_has_permissions` VALUES (46, 9);
INSERT INTO `role_has_permissions` VALUES (47, 1);
INSERT INTO `role_has_permissions` VALUES (47, 3);
INSERT INTO `role_has_permissions` VALUES (47, 4);
INSERT INTO `role_has_permissions` VALUES (47, 5);
INSERT INTO `role_has_permissions` VALUES (47, 6);
INSERT INTO `role_has_permissions` VALUES (47, 7);
INSERT INTO `role_has_permissions` VALUES (47, 8);
INSERT INTO `role_has_permissions` VALUES (47, 9);
INSERT INTO `role_has_permissions` VALUES (48, 1);
INSERT INTO `role_has_permissions` VALUES (48, 3);
INSERT INTO `role_has_permissions` VALUES (48, 4);
INSERT INTO `role_has_permissions` VALUES (48, 5);
INSERT INTO `role_has_permissions` VALUES (48, 6);
INSERT INTO `role_has_permissions` VALUES (48, 7);
INSERT INTO `role_has_permissions` VALUES (48, 8);
INSERT INTO `role_has_permissions` VALUES (48, 9);
INSERT INTO `role_has_permissions` VALUES (49, 1);
INSERT INTO `role_has_permissions` VALUES (49, 3);
INSERT INTO `role_has_permissions` VALUES (49, 4);
INSERT INTO `role_has_permissions` VALUES (49, 5);
INSERT INTO `role_has_permissions` VALUES (49, 6);
INSERT INTO `role_has_permissions` VALUES (49, 7);
INSERT INTO `role_has_permissions` VALUES (49, 8);
INSERT INTO `role_has_permissions` VALUES (49, 9);
INSERT INTO `role_has_permissions` VALUES (50, 1);
INSERT INTO `role_has_permissions` VALUES (50, 3);
INSERT INTO `role_has_permissions` VALUES (50, 4);
INSERT INTO `role_has_permissions` VALUES (50, 5);
INSERT INTO `role_has_permissions` VALUES (50, 6);
INSERT INTO `role_has_permissions` VALUES (50, 7);
INSERT INTO `role_has_permissions` VALUES (50, 8);
INSERT INTO `role_has_permissions` VALUES (50, 9);
INSERT INTO `role_has_permissions` VALUES (51, 1);
INSERT INTO `role_has_permissions` VALUES (51, 3);
INSERT INTO `role_has_permissions` VALUES (51, 4);
INSERT INTO `role_has_permissions` VALUES (51, 5);
INSERT INTO `role_has_permissions` VALUES (51, 6);
INSERT INTO `role_has_permissions` VALUES (51, 7);
INSERT INTO `role_has_permissions` VALUES (51, 8);
INSERT INTO `role_has_permissions` VALUES (51, 9);
INSERT INTO `role_has_permissions` VALUES (52, 1);
INSERT INTO `role_has_permissions` VALUES (52, 3);
INSERT INTO `role_has_permissions` VALUES (52, 4);
INSERT INTO `role_has_permissions` VALUES (52, 5);
INSERT INTO `role_has_permissions` VALUES (52, 6);
INSERT INTO `role_has_permissions` VALUES (52, 7);
INSERT INTO `role_has_permissions` VALUES (52, 8);
INSERT INTO `role_has_permissions` VALUES (52, 9);
INSERT INTO `role_has_permissions` VALUES (53, 1);
INSERT INTO `role_has_permissions` VALUES (53, 3);
INSERT INTO `role_has_permissions` VALUES (53, 4);
INSERT INTO `role_has_permissions` VALUES (53, 5);
INSERT INTO `role_has_permissions` VALUES (53, 6);
INSERT INTO `role_has_permissions` VALUES (53, 7);
INSERT INTO `role_has_permissions` VALUES (53, 8);
INSERT INTO `role_has_permissions` VALUES (53, 9);
INSERT INTO `role_has_permissions` VALUES (54, 1);
INSERT INTO `role_has_permissions` VALUES (54, 3);
INSERT INTO `role_has_permissions` VALUES (54, 4);
INSERT INTO `role_has_permissions` VALUES (54, 5);
INSERT INTO `role_has_permissions` VALUES (54, 6);
INSERT INTO `role_has_permissions` VALUES (54, 7);
INSERT INTO `role_has_permissions` VALUES (54, 8);
INSERT INTO `role_has_permissions` VALUES (54, 9);
INSERT INTO `role_has_permissions` VALUES (55, 1);
INSERT INTO `role_has_permissions` VALUES (55, 3);
INSERT INTO `role_has_permissions` VALUES (55, 4);
INSERT INTO `role_has_permissions` VALUES (55, 5);
INSERT INTO `role_has_permissions` VALUES (55, 6);
INSERT INTO `role_has_permissions` VALUES (55, 7);
INSERT INTO `role_has_permissions` VALUES (55, 8);
INSERT INTO `role_has_permissions` VALUES (55, 9);
INSERT INTO `role_has_permissions` VALUES (56, 1);
INSERT INTO `role_has_permissions` VALUES (56, 3);
INSERT INTO `role_has_permissions` VALUES (56, 4);
INSERT INTO `role_has_permissions` VALUES (56, 5);
INSERT INTO `role_has_permissions` VALUES (56, 6);
INSERT INTO `role_has_permissions` VALUES (56, 7);
INSERT INTO `role_has_permissions` VALUES (56, 8);
INSERT INTO `role_has_permissions` VALUES (56, 9);
INSERT INTO `role_has_permissions` VALUES (57, 1);
INSERT INTO `role_has_permissions` VALUES (57, 3);
INSERT INTO `role_has_permissions` VALUES (57, 4);
INSERT INTO `role_has_permissions` VALUES (57, 5);
INSERT INTO `role_has_permissions` VALUES (57, 6);
INSERT INTO `role_has_permissions` VALUES (57, 7);
INSERT INTO `role_has_permissions` VALUES (57, 8);
INSERT INTO `role_has_permissions` VALUES (57, 9);
INSERT INTO `role_has_permissions` VALUES (58, 1);
INSERT INTO `role_has_permissions` VALUES (58, 3);
INSERT INTO `role_has_permissions` VALUES (58, 4);
INSERT INTO `role_has_permissions` VALUES (58, 5);
INSERT INTO `role_has_permissions` VALUES (58, 6);
INSERT INTO `role_has_permissions` VALUES (58, 7);
INSERT INTO `role_has_permissions` VALUES (58, 8);
INSERT INTO `role_has_permissions` VALUES (58, 9);
INSERT INTO `role_has_permissions` VALUES (59, 1);
INSERT INTO `role_has_permissions` VALUES (59, 3);
INSERT INTO `role_has_permissions` VALUES (59, 4);
INSERT INTO `role_has_permissions` VALUES (59, 5);
INSERT INTO `role_has_permissions` VALUES (59, 6);
INSERT INTO `role_has_permissions` VALUES (59, 7);
INSERT INTO `role_has_permissions` VALUES (59, 8);
INSERT INTO `role_has_permissions` VALUES (59, 9);
INSERT INTO `role_has_permissions` VALUES (60, 1);
INSERT INTO `role_has_permissions` VALUES (60, 3);
INSERT INTO `role_has_permissions` VALUES (60, 4);
INSERT INTO `role_has_permissions` VALUES (60, 5);
INSERT INTO `role_has_permissions` VALUES (60, 6);
INSERT INTO `role_has_permissions` VALUES (60, 7);
INSERT INTO `role_has_permissions` VALUES (60, 8);
INSERT INTO `role_has_permissions` VALUES (60, 9);
INSERT INTO `role_has_permissions` VALUES (61, 1);
INSERT INTO `role_has_permissions` VALUES (61, 3);
INSERT INTO `role_has_permissions` VALUES (61, 4);
INSERT INTO `role_has_permissions` VALUES (61, 5);
INSERT INTO `role_has_permissions` VALUES (61, 6);
INSERT INTO `role_has_permissions` VALUES (61, 7);
INSERT INTO `role_has_permissions` VALUES (61, 8);
INSERT INTO `role_has_permissions` VALUES (61, 9);
INSERT INTO `role_has_permissions` VALUES (62, 1);
INSERT INTO `role_has_permissions` VALUES (62, 3);
INSERT INTO `role_has_permissions` VALUES (62, 4);
INSERT INTO `role_has_permissions` VALUES (62, 5);
INSERT INTO `role_has_permissions` VALUES (62, 6);
INSERT INTO `role_has_permissions` VALUES (62, 7);
INSERT INTO `role_has_permissions` VALUES (62, 8);
INSERT INTO `role_has_permissions` VALUES (62, 9);
INSERT INTO `role_has_permissions` VALUES (63, 1);
INSERT INTO `role_has_permissions` VALUES (63, 3);
INSERT INTO `role_has_permissions` VALUES (63, 4);
INSERT INTO `role_has_permissions` VALUES (63, 5);
INSERT INTO `role_has_permissions` VALUES (63, 6);
INSERT INTO `role_has_permissions` VALUES (63, 7);
INSERT INTO `role_has_permissions` VALUES (63, 8);
INSERT INTO `role_has_permissions` VALUES (63, 9);
INSERT INTO `role_has_permissions` VALUES (64, 1);
INSERT INTO `role_has_permissions` VALUES (64, 3);
INSERT INTO `role_has_permissions` VALUES (64, 4);
INSERT INTO `role_has_permissions` VALUES (64, 5);
INSERT INTO `role_has_permissions` VALUES (64, 6);
INSERT INTO `role_has_permissions` VALUES (64, 7);
INSERT INTO `role_has_permissions` VALUES (64, 8);
INSERT INTO `role_has_permissions` VALUES (64, 9);
INSERT INTO `role_has_permissions` VALUES (65, 1);
INSERT INTO `role_has_permissions` VALUES (65, 3);
INSERT INTO `role_has_permissions` VALUES (65, 4);
INSERT INTO `role_has_permissions` VALUES (65, 5);
INSERT INTO `role_has_permissions` VALUES (65, 6);
INSERT INTO `role_has_permissions` VALUES (65, 7);
INSERT INTO `role_has_permissions` VALUES (65, 8);
INSERT INTO `role_has_permissions` VALUES (65, 9);
INSERT INTO `role_has_permissions` VALUES (66, 1);
INSERT INTO `role_has_permissions` VALUES (66, 3);
INSERT INTO `role_has_permissions` VALUES (66, 4);
INSERT INTO `role_has_permissions` VALUES (66, 5);
INSERT INTO `role_has_permissions` VALUES (66, 6);
INSERT INTO `role_has_permissions` VALUES (66, 7);
INSERT INTO `role_has_permissions` VALUES (66, 8);
INSERT INTO `role_has_permissions` VALUES (66, 9);
INSERT INTO `role_has_permissions` VALUES (67, 1);
INSERT INTO `role_has_permissions` VALUES (67, 3);
INSERT INTO `role_has_permissions` VALUES (67, 4);
INSERT INTO `role_has_permissions` VALUES (67, 5);
INSERT INTO `role_has_permissions` VALUES (67, 6);
INSERT INTO `role_has_permissions` VALUES (67, 7);
INSERT INTO `role_has_permissions` VALUES (67, 8);
INSERT INTO `role_has_permissions` VALUES (67, 9);
INSERT INTO `role_has_permissions` VALUES (68, 1);
INSERT INTO `role_has_permissions` VALUES (68, 3);
INSERT INTO `role_has_permissions` VALUES (68, 4);
INSERT INTO `role_has_permissions` VALUES (68, 5);
INSERT INTO `role_has_permissions` VALUES (68, 6);
INSERT INTO `role_has_permissions` VALUES (68, 7);
INSERT INTO `role_has_permissions` VALUES (68, 8);
INSERT INTO `role_has_permissions` VALUES (68, 9);
INSERT INTO `role_has_permissions` VALUES (69, 1);
INSERT INTO `role_has_permissions` VALUES (69, 3);
INSERT INTO `role_has_permissions` VALUES (69, 4);
INSERT INTO `role_has_permissions` VALUES (69, 5);
INSERT INTO `role_has_permissions` VALUES (69, 6);
INSERT INTO `role_has_permissions` VALUES (69, 7);
INSERT INTO `role_has_permissions` VALUES (69, 8);
INSERT INTO `role_has_permissions` VALUES (69, 9);
INSERT INTO `role_has_permissions` VALUES (70, 1);
INSERT INTO `role_has_permissions` VALUES (70, 3);
INSERT INTO `role_has_permissions` VALUES (70, 4);
INSERT INTO `role_has_permissions` VALUES (70, 5);
INSERT INTO `role_has_permissions` VALUES (70, 6);
INSERT INTO `role_has_permissions` VALUES (70, 7);
INSERT INTO `role_has_permissions` VALUES (70, 8);
INSERT INTO `role_has_permissions` VALUES (70, 9);
INSERT INTO `role_has_permissions` VALUES (71, 1);
INSERT INTO `role_has_permissions` VALUES (71, 3);
INSERT INTO `role_has_permissions` VALUES (71, 4);
INSERT INTO `role_has_permissions` VALUES (71, 5);
INSERT INTO `role_has_permissions` VALUES (71, 6);
INSERT INTO `role_has_permissions` VALUES (71, 7);
INSERT INTO `role_has_permissions` VALUES (71, 8);
INSERT INTO `role_has_permissions` VALUES (71, 9);
INSERT INTO `role_has_permissions` VALUES (72, 1);
INSERT INTO `role_has_permissions` VALUES (72, 3);
INSERT INTO `role_has_permissions` VALUES (72, 4);
INSERT INTO `role_has_permissions` VALUES (72, 5);
INSERT INTO `role_has_permissions` VALUES (72, 6);
INSERT INTO `role_has_permissions` VALUES (72, 7);
INSERT INTO `role_has_permissions` VALUES (72, 8);
INSERT INTO `role_has_permissions` VALUES (72, 9);
INSERT INTO `role_has_permissions` VALUES (73, 1);
INSERT INTO `role_has_permissions` VALUES (73, 3);
INSERT INTO `role_has_permissions` VALUES (73, 4);
INSERT INTO `role_has_permissions` VALUES (73, 5);
INSERT INTO `role_has_permissions` VALUES (73, 6);
INSERT INTO `role_has_permissions` VALUES (73, 7);
INSERT INTO `role_has_permissions` VALUES (73, 8);
INSERT INTO `role_has_permissions` VALUES (73, 9);
INSERT INTO `role_has_permissions` VALUES (74, 1);
INSERT INTO `role_has_permissions` VALUES (74, 3);
INSERT INTO `role_has_permissions` VALUES (74, 4);
INSERT INTO `role_has_permissions` VALUES (74, 5);
INSERT INTO `role_has_permissions` VALUES (74, 6);
INSERT INTO `role_has_permissions` VALUES (74, 7);
INSERT INTO `role_has_permissions` VALUES (74, 8);
INSERT INTO `role_has_permissions` VALUES (74, 9);
INSERT INTO `role_has_permissions` VALUES (75, 1);
INSERT INTO `role_has_permissions` VALUES (75, 3);
INSERT INTO `role_has_permissions` VALUES (75, 4);
INSERT INTO `role_has_permissions` VALUES (75, 5);
INSERT INTO `role_has_permissions` VALUES (75, 6);
INSERT INTO `role_has_permissions` VALUES (75, 7);
INSERT INTO `role_has_permissions` VALUES (75, 8);
INSERT INTO `role_has_permissions` VALUES (75, 9);
INSERT INTO `role_has_permissions` VALUES (76, 1);
INSERT INTO `role_has_permissions` VALUES (76, 3);
INSERT INTO `role_has_permissions` VALUES (76, 4);
INSERT INTO `role_has_permissions` VALUES (76, 5);
INSERT INTO `role_has_permissions` VALUES (76, 6);
INSERT INTO `role_has_permissions` VALUES (76, 7);
INSERT INTO `role_has_permissions` VALUES (76, 8);
INSERT INTO `role_has_permissions` VALUES (76, 9);
INSERT INTO `role_has_permissions` VALUES (77, 1);
INSERT INTO `role_has_permissions` VALUES (77, 3);
INSERT INTO `role_has_permissions` VALUES (77, 4);
INSERT INTO `role_has_permissions` VALUES (77, 5);
INSERT INTO `role_has_permissions` VALUES (77, 6);
INSERT INTO `role_has_permissions` VALUES (77, 7);
INSERT INTO `role_has_permissions` VALUES (77, 8);
INSERT INTO `role_has_permissions` VALUES (77, 9);
INSERT INTO `role_has_permissions` VALUES (78, 1);
INSERT INTO `role_has_permissions` VALUES (78, 3);
INSERT INTO `role_has_permissions` VALUES (78, 4);
INSERT INTO `role_has_permissions` VALUES (78, 5);
INSERT INTO `role_has_permissions` VALUES (78, 6);
INSERT INTO `role_has_permissions` VALUES (78, 7);
INSERT INTO `role_has_permissions` VALUES (78, 8);
INSERT INTO `role_has_permissions` VALUES (78, 9);
INSERT INTO `role_has_permissions` VALUES (79, 1);
INSERT INTO `role_has_permissions` VALUES (79, 3);
INSERT INTO `role_has_permissions` VALUES (79, 4);
INSERT INTO `role_has_permissions` VALUES (79, 5);
INSERT INTO `role_has_permissions` VALUES (79, 6);
INSERT INTO `role_has_permissions` VALUES (79, 7);
INSERT INTO `role_has_permissions` VALUES (79, 8);
INSERT INTO `role_has_permissions` VALUES (79, 9);
INSERT INTO `role_has_permissions` VALUES (80, 1);
INSERT INTO `role_has_permissions` VALUES (80, 3);
INSERT INTO `role_has_permissions` VALUES (80, 4);
INSERT INTO `role_has_permissions` VALUES (80, 5);
INSERT INTO `role_has_permissions` VALUES (80, 6);
INSERT INTO `role_has_permissions` VALUES (80, 7);
INSERT INTO `role_has_permissions` VALUES (80, 8);
INSERT INTO `role_has_permissions` VALUES (80, 9);
INSERT INTO `role_has_permissions` VALUES (81, 1);
INSERT INTO `role_has_permissions` VALUES (81, 3);
INSERT INTO `role_has_permissions` VALUES (81, 4);
INSERT INTO `role_has_permissions` VALUES (81, 5);
INSERT INTO `role_has_permissions` VALUES (81, 6);
INSERT INTO `role_has_permissions` VALUES (81, 7);
INSERT INTO `role_has_permissions` VALUES (81, 8);
INSERT INTO `role_has_permissions` VALUES (81, 9);
INSERT INTO `role_has_permissions` VALUES (82, 1);
INSERT INTO `role_has_permissions` VALUES (82, 3);
INSERT INTO `role_has_permissions` VALUES (82, 4);
INSERT INTO `role_has_permissions` VALUES (82, 5);
INSERT INTO `role_has_permissions` VALUES (82, 6);
INSERT INTO `role_has_permissions` VALUES (82, 7);
INSERT INTO `role_has_permissions` VALUES (82, 8);
INSERT INTO `role_has_permissions` VALUES (82, 9);
INSERT INTO `role_has_permissions` VALUES (83, 1);
INSERT INTO `role_has_permissions` VALUES (83, 3);
INSERT INTO `role_has_permissions` VALUES (83, 4);
INSERT INTO `role_has_permissions` VALUES (83, 5);
INSERT INTO `role_has_permissions` VALUES (83, 6);
INSERT INTO `role_has_permissions` VALUES (83, 7);
INSERT INTO `role_has_permissions` VALUES (83, 8);
INSERT INTO `role_has_permissions` VALUES (83, 9);
INSERT INTO `role_has_permissions` VALUES (84, 1);
INSERT INTO `role_has_permissions` VALUES (84, 3);
INSERT INTO `role_has_permissions` VALUES (84, 4);
INSERT INTO `role_has_permissions` VALUES (84, 5);
INSERT INTO `role_has_permissions` VALUES (84, 6);
INSERT INTO `role_has_permissions` VALUES (84, 7);
INSERT INTO `role_has_permissions` VALUES (84, 8);
INSERT INTO `role_has_permissions` VALUES (84, 9);
INSERT INTO `role_has_permissions` VALUES (85, 1);
INSERT INTO `role_has_permissions` VALUES (85, 3);
INSERT INTO `role_has_permissions` VALUES (85, 4);
INSERT INTO `role_has_permissions` VALUES (85, 5);
INSERT INTO `role_has_permissions` VALUES (85, 6);
INSERT INTO `role_has_permissions` VALUES (85, 7);
INSERT INTO `role_has_permissions` VALUES (85, 8);
INSERT INTO `role_has_permissions` VALUES (85, 9);
INSERT INTO `role_has_permissions` VALUES (86, 1);
INSERT INTO `role_has_permissions` VALUES (86, 3);
INSERT INTO `role_has_permissions` VALUES (86, 4);
INSERT INTO `role_has_permissions` VALUES (86, 5);
INSERT INTO `role_has_permissions` VALUES (86, 6);
INSERT INTO `role_has_permissions` VALUES (86, 7);
INSERT INTO `role_has_permissions` VALUES (86, 8);
INSERT INTO `role_has_permissions` VALUES (86, 9);
INSERT INTO `role_has_permissions` VALUES (87, 1);
INSERT INTO `role_has_permissions` VALUES (87, 3);
INSERT INTO `role_has_permissions` VALUES (87, 4);
INSERT INTO `role_has_permissions` VALUES (87, 5);
INSERT INTO `role_has_permissions` VALUES (87, 6);
INSERT INTO `role_has_permissions` VALUES (87, 7);
INSERT INTO `role_has_permissions` VALUES (87, 8);
INSERT INTO `role_has_permissions` VALUES (87, 9);
INSERT INTO `role_has_permissions` VALUES (88, 1);
INSERT INTO `role_has_permissions` VALUES (88, 3);
INSERT INTO `role_has_permissions` VALUES (88, 4);
INSERT INTO `role_has_permissions` VALUES (88, 5);
INSERT INTO `role_has_permissions` VALUES (88, 6);
INSERT INTO `role_has_permissions` VALUES (88, 7);
INSERT INTO `role_has_permissions` VALUES (88, 8);
INSERT INTO `role_has_permissions` VALUES (88, 9);
INSERT INTO `role_has_permissions` VALUES (89, 1);
INSERT INTO `role_has_permissions` VALUES (89, 3);
INSERT INTO `role_has_permissions` VALUES (89, 4);
INSERT INTO `role_has_permissions` VALUES (89, 5);
INSERT INTO `role_has_permissions` VALUES (89, 6);
INSERT INTO `role_has_permissions` VALUES (89, 7);
INSERT INTO `role_has_permissions` VALUES (89, 8);
INSERT INTO `role_has_permissions` VALUES (89, 9);
INSERT INTO `role_has_permissions` VALUES (90, 1);
INSERT INTO `role_has_permissions` VALUES (90, 3);
INSERT INTO `role_has_permissions` VALUES (90, 4);
INSERT INTO `role_has_permissions` VALUES (90, 5);
INSERT INTO `role_has_permissions` VALUES (90, 6);
INSERT INTO `role_has_permissions` VALUES (90, 7);
INSERT INTO `role_has_permissions` VALUES (90, 8);
INSERT INTO `role_has_permissions` VALUES (90, 9);
INSERT INTO `role_has_permissions` VALUES (91, 1);
INSERT INTO `role_has_permissions` VALUES (91, 3);
INSERT INTO `role_has_permissions` VALUES (91, 4);
INSERT INTO `role_has_permissions` VALUES (91, 5);
INSERT INTO `role_has_permissions` VALUES (91, 6);
INSERT INTO `role_has_permissions` VALUES (91, 7);
INSERT INTO `role_has_permissions` VALUES (91, 8);
INSERT INTO `role_has_permissions` VALUES (91, 9);
INSERT INTO `role_has_permissions` VALUES (92, 1);
INSERT INTO `role_has_permissions` VALUES (92, 3);
INSERT INTO `role_has_permissions` VALUES (92, 4);
INSERT INTO `role_has_permissions` VALUES (92, 5);
INSERT INTO `role_has_permissions` VALUES (92, 6);
INSERT INTO `role_has_permissions` VALUES (92, 7);
INSERT INTO `role_has_permissions` VALUES (92, 8);
INSERT INTO `role_has_permissions` VALUES (92, 9);
INSERT INTO `role_has_permissions` VALUES (93, 1);
INSERT INTO `role_has_permissions` VALUES (93, 3);
INSERT INTO `role_has_permissions` VALUES (93, 4);
INSERT INTO `role_has_permissions` VALUES (93, 5);
INSERT INTO `role_has_permissions` VALUES (93, 6);
INSERT INTO `role_has_permissions` VALUES (93, 7);
INSERT INTO `role_has_permissions` VALUES (93, 8);
INSERT INTO `role_has_permissions` VALUES (93, 9);
INSERT INTO `role_has_permissions` VALUES (94, 1);
INSERT INTO `role_has_permissions` VALUES (94, 3);
INSERT INTO `role_has_permissions` VALUES (94, 4);
INSERT INTO `role_has_permissions` VALUES (94, 5);
INSERT INTO `role_has_permissions` VALUES (94, 6);
INSERT INTO `role_has_permissions` VALUES (94, 7);
INSERT INTO `role_has_permissions` VALUES (94, 8);
INSERT INTO `role_has_permissions` VALUES (94, 9);
INSERT INTO `role_has_permissions` VALUES (95, 1);
INSERT INTO `role_has_permissions` VALUES (95, 3);
INSERT INTO `role_has_permissions` VALUES (95, 4);
INSERT INTO `role_has_permissions` VALUES (95, 5);
INSERT INTO `role_has_permissions` VALUES (95, 6);
INSERT INTO `role_has_permissions` VALUES (95, 7);
INSERT INTO `role_has_permissions` VALUES (95, 8);
INSERT INTO `role_has_permissions` VALUES (95, 9);
INSERT INTO `role_has_permissions` VALUES (96, 1);
INSERT INTO `role_has_permissions` VALUES (96, 3);
INSERT INTO `role_has_permissions` VALUES (96, 4);
INSERT INTO `role_has_permissions` VALUES (96, 5);
INSERT INTO `role_has_permissions` VALUES (96, 6);
INSERT INTO `role_has_permissions` VALUES (96, 7);
INSERT INTO `role_has_permissions` VALUES (96, 8);
INSERT INTO `role_has_permissions` VALUES (96, 9);
INSERT INTO `role_has_permissions` VALUES (97, 1);
INSERT INTO `role_has_permissions` VALUES (97, 3);
INSERT INTO `role_has_permissions` VALUES (97, 4);
INSERT INTO `role_has_permissions` VALUES (97, 5);
INSERT INTO `role_has_permissions` VALUES (97, 6);
INSERT INTO `role_has_permissions` VALUES (97, 7);
INSERT INTO `role_has_permissions` VALUES (97, 8);
INSERT INTO `role_has_permissions` VALUES (97, 9);
INSERT INTO `role_has_permissions` VALUES (98, 1);
INSERT INTO `role_has_permissions` VALUES (98, 3);
INSERT INTO `role_has_permissions` VALUES (98, 4);
INSERT INTO `role_has_permissions` VALUES (98, 5);
INSERT INTO `role_has_permissions` VALUES (98, 6);
INSERT INTO `role_has_permissions` VALUES (98, 7);
INSERT INTO `role_has_permissions` VALUES (98, 8);
INSERT INTO `role_has_permissions` VALUES (98, 9);
INSERT INTO `role_has_permissions` VALUES (99, 1);
INSERT INTO `role_has_permissions` VALUES (99, 3);
INSERT INTO `role_has_permissions` VALUES (99, 4);
INSERT INTO `role_has_permissions` VALUES (99, 5);
INSERT INTO `role_has_permissions` VALUES (99, 6);
INSERT INTO `role_has_permissions` VALUES (99, 7);
INSERT INTO `role_has_permissions` VALUES (99, 8);
INSERT INTO `role_has_permissions` VALUES (99, 9);
INSERT INTO `role_has_permissions` VALUES (100, 1);
INSERT INTO `role_has_permissions` VALUES (100, 3);
INSERT INTO `role_has_permissions` VALUES (100, 4);
INSERT INTO `role_has_permissions` VALUES (100, 5);
INSERT INTO `role_has_permissions` VALUES (100, 6);
INSERT INTO `role_has_permissions` VALUES (100, 7);
INSERT INTO `role_has_permissions` VALUES (100, 8);
INSERT INTO `role_has_permissions` VALUES (100, 9);
INSERT INTO `role_has_permissions` VALUES (101, 1);
INSERT INTO `role_has_permissions` VALUES (101, 3);
INSERT INTO `role_has_permissions` VALUES (101, 4);
INSERT INTO `role_has_permissions` VALUES (101, 5);
INSERT INTO `role_has_permissions` VALUES (101, 6);
INSERT INTO `role_has_permissions` VALUES (101, 7);
INSERT INTO `role_has_permissions` VALUES (101, 8);
INSERT INTO `role_has_permissions` VALUES (101, 9);
INSERT INTO `role_has_permissions` VALUES (102, 1);
INSERT INTO `role_has_permissions` VALUES (102, 3);
INSERT INTO `role_has_permissions` VALUES (102, 4);
INSERT INTO `role_has_permissions` VALUES (102, 5);
INSERT INTO `role_has_permissions` VALUES (102, 6);
INSERT INTO `role_has_permissions` VALUES (102, 7);
INSERT INTO `role_has_permissions` VALUES (102, 8);
INSERT INTO `role_has_permissions` VALUES (102, 9);
INSERT INTO `role_has_permissions` VALUES (103, 1);
INSERT INTO `role_has_permissions` VALUES (103, 3);
INSERT INTO `role_has_permissions` VALUES (103, 4);
INSERT INTO `role_has_permissions` VALUES (103, 5);
INSERT INTO `role_has_permissions` VALUES (103, 6);
INSERT INTO `role_has_permissions` VALUES (103, 7);
INSERT INTO `role_has_permissions` VALUES (103, 8);
INSERT INTO `role_has_permissions` VALUES (103, 9);
INSERT INTO `role_has_permissions` VALUES (104, 1);
INSERT INTO `role_has_permissions` VALUES (104, 3);
INSERT INTO `role_has_permissions` VALUES (104, 4);
INSERT INTO `role_has_permissions` VALUES (104, 5);
INSERT INTO `role_has_permissions` VALUES (104, 6);
INSERT INTO `role_has_permissions` VALUES (104, 7);
INSERT INTO `role_has_permissions` VALUES (104, 8);
INSERT INTO `role_has_permissions` VALUES (104, 9);
INSERT INTO `role_has_permissions` VALUES (105, 1);
INSERT INTO `role_has_permissions` VALUES (105, 3);
INSERT INTO `role_has_permissions` VALUES (105, 4);
INSERT INTO `role_has_permissions` VALUES (105, 5);
INSERT INTO `role_has_permissions` VALUES (105, 6);
INSERT INTO `role_has_permissions` VALUES (105, 7);
INSERT INTO `role_has_permissions` VALUES (105, 8);
INSERT INTO `role_has_permissions` VALUES (105, 9);
INSERT INTO `role_has_permissions` VALUES (106, 1);
INSERT INTO `role_has_permissions` VALUES (106, 3);
INSERT INTO `role_has_permissions` VALUES (106, 4);
INSERT INTO `role_has_permissions` VALUES (106, 5);
INSERT INTO `role_has_permissions` VALUES (106, 6);
INSERT INTO `role_has_permissions` VALUES (106, 7);
INSERT INTO `role_has_permissions` VALUES (106, 8);
INSERT INTO `role_has_permissions` VALUES (106, 9);
INSERT INTO `role_has_permissions` VALUES (107, 1);
INSERT INTO `role_has_permissions` VALUES (107, 3);
INSERT INTO `role_has_permissions` VALUES (107, 4);
INSERT INTO `role_has_permissions` VALUES (107, 5);
INSERT INTO `role_has_permissions` VALUES (107, 6);
INSERT INTO `role_has_permissions` VALUES (107, 7);
INSERT INTO `role_has_permissions` VALUES (107, 8);
INSERT INTO `role_has_permissions` VALUES (107, 9);
INSERT INTO `role_has_permissions` VALUES (108, 1);
INSERT INTO `role_has_permissions` VALUES (108, 3);
INSERT INTO `role_has_permissions` VALUES (108, 4);
INSERT INTO `role_has_permissions` VALUES (108, 5);
INSERT INTO `role_has_permissions` VALUES (108, 6);
INSERT INTO `role_has_permissions` VALUES (108, 7);
INSERT INTO `role_has_permissions` VALUES (108, 8);
INSERT INTO `role_has_permissions` VALUES (108, 9);
INSERT INTO `role_has_permissions` VALUES (109, 1);
INSERT INTO `role_has_permissions` VALUES (109, 3);
INSERT INTO `role_has_permissions` VALUES (109, 4);
INSERT INTO `role_has_permissions` VALUES (109, 5);
INSERT INTO `role_has_permissions` VALUES (109, 6);
INSERT INTO `role_has_permissions` VALUES (109, 7);
INSERT INTO `role_has_permissions` VALUES (109, 8);
INSERT INTO `role_has_permissions` VALUES (109, 9);
INSERT INTO `role_has_permissions` VALUES (110, 1);
INSERT INTO `role_has_permissions` VALUES (110, 3);
INSERT INTO `role_has_permissions` VALUES (110, 4);
INSERT INTO `role_has_permissions` VALUES (110, 5);
INSERT INTO `role_has_permissions` VALUES (110, 6);
INSERT INTO `role_has_permissions` VALUES (110, 7);
INSERT INTO `role_has_permissions` VALUES (110, 8);
INSERT INTO `role_has_permissions` VALUES (110, 9);
INSERT INTO `role_has_permissions` VALUES (111, 1);
INSERT INTO `role_has_permissions` VALUES (111, 3);
INSERT INTO `role_has_permissions` VALUES (111, 4);
INSERT INTO `role_has_permissions` VALUES (111, 5);
INSERT INTO `role_has_permissions` VALUES (111, 6);
INSERT INTO `role_has_permissions` VALUES (111, 7);
INSERT INTO `role_has_permissions` VALUES (111, 8);
INSERT INTO `role_has_permissions` VALUES (111, 9);
INSERT INTO `role_has_permissions` VALUES (112, 1);
INSERT INTO `role_has_permissions` VALUES (112, 3);
INSERT INTO `role_has_permissions` VALUES (112, 4);
INSERT INTO `role_has_permissions` VALUES (112, 5);
INSERT INTO `role_has_permissions` VALUES (112, 6);
INSERT INTO `role_has_permissions` VALUES (112, 7);
INSERT INTO `role_has_permissions` VALUES (112, 8);
INSERT INTO `role_has_permissions` VALUES (112, 9);
INSERT INTO `role_has_permissions` VALUES (113, 1);
INSERT INTO `role_has_permissions` VALUES (113, 3);
INSERT INTO `role_has_permissions` VALUES (113, 4);
INSERT INTO `role_has_permissions` VALUES (113, 5);
INSERT INTO `role_has_permissions` VALUES (113, 6);
INSERT INTO `role_has_permissions` VALUES (113, 7);
INSERT INTO `role_has_permissions` VALUES (113, 8);
INSERT INTO `role_has_permissions` VALUES (113, 9);
INSERT INTO `role_has_permissions` VALUES (114, 1);
INSERT INTO `role_has_permissions` VALUES (114, 3);
INSERT INTO `role_has_permissions` VALUES (114, 4);
INSERT INTO `role_has_permissions` VALUES (114, 5);
INSERT INTO `role_has_permissions` VALUES (114, 6);
INSERT INTO `role_has_permissions` VALUES (114, 7);
INSERT INTO `role_has_permissions` VALUES (114, 8);
INSERT INTO `role_has_permissions` VALUES (114, 9);
INSERT INTO `role_has_permissions` VALUES (115, 1);
INSERT INTO `role_has_permissions` VALUES (115, 3);
INSERT INTO `role_has_permissions` VALUES (115, 4);
INSERT INTO `role_has_permissions` VALUES (115, 5);
INSERT INTO `role_has_permissions` VALUES (115, 6);
INSERT INTO `role_has_permissions` VALUES (115, 7);
INSERT INTO `role_has_permissions` VALUES (115, 8);
INSERT INTO `role_has_permissions` VALUES (115, 9);
INSERT INTO `role_has_permissions` VALUES (116, 1);
INSERT INTO `role_has_permissions` VALUES (116, 3);
INSERT INTO `role_has_permissions` VALUES (116, 4);
INSERT INTO `role_has_permissions` VALUES (116, 5);
INSERT INTO `role_has_permissions` VALUES (116, 6);
INSERT INTO `role_has_permissions` VALUES (116, 7);
INSERT INTO `role_has_permissions` VALUES (116, 8);
INSERT INTO `role_has_permissions` VALUES (116, 9);
INSERT INTO `role_has_permissions` VALUES (117, 1);
INSERT INTO `role_has_permissions` VALUES (117, 3);
INSERT INTO `role_has_permissions` VALUES (117, 4);
INSERT INTO `role_has_permissions` VALUES (117, 5);
INSERT INTO `role_has_permissions` VALUES (117, 6);
INSERT INTO `role_has_permissions` VALUES (117, 7);
INSERT INTO `role_has_permissions` VALUES (117, 8);
INSERT INTO `role_has_permissions` VALUES (117, 9);
INSERT INTO `role_has_permissions` VALUES (118, 1);
INSERT INTO `role_has_permissions` VALUES (118, 3);
INSERT INTO `role_has_permissions` VALUES (118, 4);
INSERT INTO `role_has_permissions` VALUES (118, 5);
INSERT INTO `role_has_permissions` VALUES (118, 6);
INSERT INTO `role_has_permissions` VALUES (118, 7);
INSERT INTO `role_has_permissions` VALUES (118, 8);
INSERT INTO `role_has_permissions` VALUES (118, 9);
INSERT INTO `role_has_permissions` VALUES (119, 1);
INSERT INTO `role_has_permissions` VALUES (119, 3);
INSERT INTO `role_has_permissions` VALUES (119, 4);
INSERT INTO `role_has_permissions` VALUES (119, 5);
INSERT INTO `role_has_permissions` VALUES (119, 6);
INSERT INTO `role_has_permissions` VALUES (119, 7);
INSERT INTO `role_has_permissions` VALUES (119, 8);
INSERT INTO `role_has_permissions` VALUES (119, 9);
INSERT INTO `role_has_permissions` VALUES (120, 1);
INSERT INTO `role_has_permissions` VALUES (120, 3);
INSERT INTO `role_has_permissions` VALUES (120, 4);
INSERT INTO `role_has_permissions` VALUES (120, 5);
INSERT INTO `role_has_permissions` VALUES (120, 6);
INSERT INTO `role_has_permissions` VALUES (120, 7);
INSERT INTO `role_has_permissions` VALUES (120, 8);
INSERT INTO `role_has_permissions` VALUES (120, 9);
INSERT INTO `role_has_permissions` VALUES (121, 1);
INSERT INTO `role_has_permissions` VALUES (121, 3);
INSERT INTO `role_has_permissions` VALUES (121, 4);
INSERT INTO `role_has_permissions` VALUES (121, 5);
INSERT INTO `role_has_permissions` VALUES (121, 6);
INSERT INTO `role_has_permissions` VALUES (121, 7);
INSERT INTO `role_has_permissions` VALUES (121, 8);
INSERT INTO `role_has_permissions` VALUES (121, 9);
INSERT INTO `role_has_permissions` VALUES (122, 1);
INSERT INTO `role_has_permissions` VALUES (122, 3);
INSERT INTO `role_has_permissions` VALUES (122, 4);
INSERT INTO `role_has_permissions` VALUES (122, 5);
INSERT INTO `role_has_permissions` VALUES (122, 6);
INSERT INTO `role_has_permissions` VALUES (122, 7);
INSERT INTO `role_has_permissions` VALUES (122, 8);
INSERT INTO `role_has_permissions` VALUES (122, 9);
INSERT INTO `role_has_permissions` VALUES (123, 1);
INSERT INTO `role_has_permissions` VALUES (123, 3);
INSERT INTO `role_has_permissions` VALUES (123, 4);
INSERT INTO `role_has_permissions` VALUES (123, 5);
INSERT INTO `role_has_permissions` VALUES (123, 6);
INSERT INTO `role_has_permissions` VALUES (123, 7);
INSERT INTO `role_has_permissions` VALUES (123, 8);
INSERT INTO `role_has_permissions` VALUES (123, 9);
INSERT INTO `role_has_permissions` VALUES (124, 1);
INSERT INTO `role_has_permissions` VALUES (124, 3);
INSERT INTO `role_has_permissions` VALUES (124, 4);
INSERT INTO `role_has_permissions` VALUES (124, 5);
INSERT INTO `role_has_permissions` VALUES (124, 6);
INSERT INTO `role_has_permissions` VALUES (124, 7);
INSERT INTO `role_has_permissions` VALUES (124, 8);
INSERT INTO `role_has_permissions` VALUES (124, 9);
INSERT INTO `role_has_permissions` VALUES (125, 1);
INSERT INTO `role_has_permissions` VALUES (125, 3);
INSERT INTO `role_has_permissions` VALUES (125, 4);
INSERT INTO `role_has_permissions` VALUES (125, 5);
INSERT INTO `role_has_permissions` VALUES (125, 6);
INSERT INTO `role_has_permissions` VALUES (125, 7);
INSERT INTO `role_has_permissions` VALUES (125, 8);
INSERT INTO `role_has_permissions` VALUES (125, 9);
INSERT INTO `role_has_permissions` VALUES (126, 1);
INSERT INTO `role_has_permissions` VALUES (126, 3);
INSERT INTO `role_has_permissions` VALUES (126, 4);
INSERT INTO `role_has_permissions` VALUES (126, 5);
INSERT INTO `role_has_permissions` VALUES (126, 6);
INSERT INTO `role_has_permissions` VALUES (126, 7);
INSERT INTO `role_has_permissions` VALUES (126, 8);
INSERT INTO `role_has_permissions` VALUES (126, 9);
INSERT INTO `role_has_permissions` VALUES (127, 1);
INSERT INTO `role_has_permissions` VALUES (127, 3);
INSERT INTO `role_has_permissions` VALUES (127, 4);
INSERT INTO `role_has_permissions` VALUES (127, 5);
INSERT INTO `role_has_permissions` VALUES (127, 6);
INSERT INTO `role_has_permissions` VALUES (127, 7);
INSERT INTO `role_has_permissions` VALUES (127, 8);
INSERT INTO `role_has_permissions` VALUES (127, 9);
INSERT INTO `role_has_permissions` VALUES (128, 1);
INSERT INTO `role_has_permissions` VALUES (128, 3);
INSERT INTO `role_has_permissions` VALUES (128, 4);
INSERT INTO `role_has_permissions` VALUES (128, 5);
INSERT INTO `role_has_permissions` VALUES (128, 6);
INSERT INTO `role_has_permissions` VALUES (128, 7);
INSERT INTO `role_has_permissions` VALUES (128, 8);
INSERT INTO `role_has_permissions` VALUES (128, 9);
INSERT INTO `role_has_permissions` VALUES (129, 1);
INSERT INTO `role_has_permissions` VALUES (129, 3);
INSERT INTO `role_has_permissions` VALUES (129, 4);
INSERT INTO `role_has_permissions` VALUES (129, 5);
INSERT INTO `role_has_permissions` VALUES (129, 6);
INSERT INTO `role_has_permissions` VALUES (129, 7);
INSERT INTO `role_has_permissions` VALUES (129, 8);
INSERT INTO `role_has_permissions` VALUES (129, 9);
INSERT INTO `role_has_permissions` VALUES (130, 1);
INSERT INTO `role_has_permissions` VALUES (130, 3);
INSERT INTO `role_has_permissions` VALUES (130, 4);
INSERT INTO `role_has_permissions` VALUES (130, 5);
INSERT INTO `role_has_permissions` VALUES (130, 6);
INSERT INTO `role_has_permissions` VALUES (130, 7);
INSERT INTO `role_has_permissions` VALUES (130, 8);
INSERT INTO `role_has_permissions` VALUES (130, 9);
INSERT INTO `role_has_permissions` VALUES (131, 1);
INSERT INTO `role_has_permissions` VALUES (131, 3);
INSERT INTO `role_has_permissions` VALUES (131, 4);
INSERT INTO `role_has_permissions` VALUES (131, 5);
INSERT INTO `role_has_permissions` VALUES (131, 6);
INSERT INTO `role_has_permissions` VALUES (131, 7);
INSERT INTO `role_has_permissions` VALUES (131, 8);
INSERT INTO `role_has_permissions` VALUES (131, 9);
INSERT INTO `role_has_permissions` VALUES (132, 1);
INSERT INTO `role_has_permissions` VALUES (132, 3);
INSERT INTO `role_has_permissions` VALUES (132, 4);
INSERT INTO `role_has_permissions` VALUES (132, 5);
INSERT INTO `role_has_permissions` VALUES (132, 6);
INSERT INTO `role_has_permissions` VALUES (132, 7);
INSERT INTO `role_has_permissions` VALUES (132, 8);
INSERT INTO `role_has_permissions` VALUES (132, 9);
INSERT INTO `role_has_permissions` VALUES (133, 1);
INSERT INTO `role_has_permissions` VALUES (133, 3);
INSERT INTO `role_has_permissions` VALUES (133, 4);
INSERT INTO `role_has_permissions` VALUES (133, 5);
INSERT INTO `role_has_permissions` VALUES (133, 6);
INSERT INTO `role_has_permissions` VALUES (133, 7);
INSERT INTO `role_has_permissions` VALUES (133, 8);
INSERT INTO `role_has_permissions` VALUES (133, 9);
INSERT INTO `role_has_permissions` VALUES (134, 1);
INSERT INTO `role_has_permissions` VALUES (134, 3);
INSERT INTO `role_has_permissions` VALUES (134, 4);
INSERT INTO `role_has_permissions` VALUES (134, 5);
INSERT INTO `role_has_permissions` VALUES (134, 6);
INSERT INTO `role_has_permissions` VALUES (134, 7);
INSERT INTO `role_has_permissions` VALUES (134, 8);
INSERT INTO `role_has_permissions` VALUES (134, 9);
INSERT INTO `role_has_permissions` VALUES (135, 1);
INSERT INTO `role_has_permissions` VALUES (135, 3);
INSERT INTO `role_has_permissions` VALUES (135, 4);
INSERT INTO `role_has_permissions` VALUES (135, 5);
INSERT INTO `role_has_permissions` VALUES (135, 6);
INSERT INTO `role_has_permissions` VALUES (135, 7);
INSERT INTO `role_has_permissions` VALUES (135, 8);
INSERT INTO `role_has_permissions` VALUES (135, 9);
INSERT INTO `role_has_permissions` VALUES (136, 1);
INSERT INTO `role_has_permissions` VALUES (136, 3);
INSERT INTO `role_has_permissions` VALUES (136, 4);
INSERT INTO `role_has_permissions` VALUES (136, 5);
INSERT INTO `role_has_permissions` VALUES (136, 6);
INSERT INTO `role_has_permissions` VALUES (136, 7);
INSERT INTO `role_has_permissions` VALUES (136, 8);
INSERT INTO `role_has_permissions` VALUES (136, 9);
INSERT INTO `role_has_permissions` VALUES (137, 1);
INSERT INTO `role_has_permissions` VALUES (137, 3);
INSERT INTO `role_has_permissions` VALUES (137, 4);
INSERT INTO `role_has_permissions` VALUES (137, 5);
INSERT INTO `role_has_permissions` VALUES (137, 6);
INSERT INTO `role_has_permissions` VALUES (137, 7);
INSERT INTO `role_has_permissions` VALUES (137, 8);
INSERT INTO `role_has_permissions` VALUES (137, 9);
INSERT INTO `role_has_permissions` VALUES (138, 1);
INSERT INTO `role_has_permissions` VALUES (138, 3);
INSERT INTO `role_has_permissions` VALUES (138, 4);
INSERT INTO `role_has_permissions` VALUES (138, 5);
INSERT INTO `role_has_permissions` VALUES (138, 6);
INSERT INTO `role_has_permissions` VALUES (138, 7);
INSERT INTO `role_has_permissions` VALUES (138, 8);
INSERT INTO `role_has_permissions` VALUES (138, 9);
INSERT INTO `role_has_permissions` VALUES (139, 1);
INSERT INTO `role_has_permissions` VALUES (139, 3);
INSERT INTO `role_has_permissions` VALUES (139, 4);
INSERT INTO `role_has_permissions` VALUES (139, 5);
INSERT INTO `role_has_permissions` VALUES (139, 6);
INSERT INTO `role_has_permissions` VALUES (139, 7);
INSERT INTO `role_has_permissions` VALUES (139, 8);
INSERT INTO `role_has_permissions` VALUES (139, 9);
INSERT INTO `role_has_permissions` VALUES (140, 1);
INSERT INTO `role_has_permissions` VALUES (140, 3);
INSERT INTO `role_has_permissions` VALUES (140, 4);
INSERT INTO `role_has_permissions` VALUES (140, 5);
INSERT INTO `role_has_permissions` VALUES (140, 6);
INSERT INTO `role_has_permissions` VALUES (140, 7);
INSERT INTO `role_has_permissions` VALUES (140, 8);
INSERT INTO `role_has_permissions` VALUES (140, 9);
INSERT INTO `role_has_permissions` VALUES (141, 1);
INSERT INTO `role_has_permissions` VALUES (141, 3);
INSERT INTO `role_has_permissions` VALUES (141, 4);
INSERT INTO `role_has_permissions` VALUES (141, 5);
INSERT INTO `role_has_permissions` VALUES (141, 6);
INSERT INTO `role_has_permissions` VALUES (141, 7);
INSERT INTO `role_has_permissions` VALUES (141, 8);
INSERT INTO `role_has_permissions` VALUES (141, 9);
INSERT INTO `role_has_permissions` VALUES (142, 1);
INSERT INTO `role_has_permissions` VALUES (142, 3);
INSERT INTO `role_has_permissions` VALUES (142, 4);
INSERT INTO `role_has_permissions` VALUES (142, 5);
INSERT INTO `role_has_permissions` VALUES (142, 6);
INSERT INTO `role_has_permissions` VALUES (142, 7);
INSERT INTO `role_has_permissions` VALUES (142, 8);
INSERT INTO `role_has_permissions` VALUES (142, 9);
INSERT INTO `role_has_permissions` VALUES (143, 1);
INSERT INTO `role_has_permissions` VALUES (143, 3);
INSERT INTO `role_has_permissions` VALUES (143, 4);
INSERT INTO `role_has_permissions` VALUES (143, 5);
INSERT INTO `role_has_permissions` VALUES (143, 6);
INSERT INTO `role_has_permissions` VALUES (143, 7);
INSERT INTO `role_has_permissions` VALUES (143, 8);
INSERT INTO `role_has_permissions` VALUES (143, 9);
INSERT INTO `role_has_permissions` VALUES (144, 1);
INSERT INTO `role_has_permissions` VALUES (144, 3);
INSERT INTO `role_has_permissions` VALUES (144, 4);
INSERT INTO `role_has_permissions` VALUES (144, 5);
INSERT INTO `role_has_permissions` VALUES (144, 6);
INSERT INTO `role_has_permissions` VALUES (144, 7);
INSERT INTO `role_has_permissions` VALUES (144, 8);
INSERT INTO `role_has_permissions` VALUES (144, 9);
INSERT INTO `role_has_permissions` VALUES (145, 1);
INSERT INTO `role_has_permissions` VALUES (145, 3);
INSERT INTO `role_has_permissions` VALUES (145, 4);
INSERT INTO `role_has_permissions` VALUES (145, 5);
INSERT INTO `role_has_permissions` VALUES (145, 6);
INSERT INTO `role_has_permissions` VALUES (145, 7);
INSERT INTO `role_has_permissions` VALUES (145, 8);
INSERT INTO `role_has_permissions` VALUES (145, 9);
INSERT INTO `role_has_permissions` VALUES (146, 1);
INSERT INTO `role_has_permissions` VALUES (146, 3);
INSERT INTO `role_has_permissions` VALUES (146, 4);
INSERT INTO `role_has_permissions` VALUES (146, 5);
INSERT INTO `role_has_permissions` VALUES (146, 6);
INSERT INTO `role_has_permissions` VALUES (146, 7);
INSERT INTO `role_has_permissions` VALUES (146, 8);
INSERT INTO `role_has_permissions` VALUES (146, 9);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'free', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (2, 'expired', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (3, 'UTY', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (4, 'UTM', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (5, 'TTY', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (6, 'TTM', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (7, 'OTY', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (8, 'OTM', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');
INSERT INTO `roles` VALUES (9, 'admin', 'web', '2021-07-14 07:32:04', '2021-07-14 07:32:04');

-- ----------------------------
-- Table structure for subscription_items
-- ----------------------------
DROP TABLE IF EXISTS `subscription_items`;
CREATE TABLE `subscription_items`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `subscription_items_subscription_id_stripe_plan_unique`(`subscription_id`, `stripe_plan`) USING BTREE,
  INDEX `subscription_items_stripe_id_index`(`stripe_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subscription_items
-- ----------------------------

-- ----------------------------
-- Table structure for subscriptions
-- ----------------------------
DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantity` int(11) NULL DEFAULT NULL,
  `trial_ends_at` timestamp(0) NULL DEFAULT NULL,
  `ends_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subscriptions_user_id_stripe_status_index`(`user_id`, `stripe_status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subscriptions
-- ----------------------------

-- ----------------------------
-- Table structure for tenants
-- ----------------------------
DROP TABLE IF EXISTS `tenants`;
CREATE TABLE `tenants`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tree_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `database` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tenants_tree_id_unique`(`tree_id`) USING BTREE,
  UNIQUE INDEX `tenants_database_unique`(`database`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tenants
-- ----------------------------
INSERT INTO `tenants` VALUES (1, 'tenant1', '1', 'tenant1', NULL, NULL);
INSERT INTO `tenants` VALUES (2, 'tenant2', '2', 'tenant2', NULL, NULL);

-- ----------------------------
-- Table structure for trees
-- ----------------------------
DROP TABLE IF EXISTS `trees`;
CREATE TABLE `trees`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `current_tenant` tinyint(4) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of trees
-- ----------------------------
INSERT INTO `trees` VALUES (1, 1, 1, 'tree1', '', NULL, NULL);
INSERT INTO `trees` VALUES (2, 2, 1, 'tree2', '', NULL, NULL);

-- ----------------------------
-- Table structure for user_company
-- ----------------------------
DROP TABLE IF EXISTS `user_company`;
CREATE TABLE `user_company`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_company
-- ----------------------------
INSERT INTO `user_company` VALUES (1, 1, 1);
INSERT INTO `user_company` VALUES (2, 2, 2);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `card_brand` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `card_last_four` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `trial_ends_at` timestamp(0) NULL DEFAULT NULL,
  `paypal_subscription_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  INDEX `users_stripe_id_index`(`stripe_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'John', 'Dev', 'wwdev0807@gmail.com', NULL, '$2y$10$9P821Xd3HhmOe10JNYwwFOA7ksiemhwQAri2kgI1ZhbG1hwvpeHqq', NULL, '2021-07-15 07:18:13', '2021-07-15 07:18:13', NULL, NULL, NULL, NULL, 'I-J86JU97C24N2');
INSERT INTO `users` VALUES (2, 'Nick', 'dev', 'sb-gqsay6818823@personal.example.com', NULL, '$2y$10$f06M.JjKsQOuUpiJ50guPuXZdavYWIQ5eLl5kIqBqELhGhjS3aQU.', NULL, '2021-07-17 15:44:10', '2021-07-17 15:44:10', NULL, NULL, '', NULL, 'I-VG6UXS6NLFKF');

SET FOREIGN_KEY_CHECKS = 1;
