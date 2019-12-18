/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50725
 Source Host           : localhost:3306
 Source Schema         : siam_admin

 Target Server Type    : MySQL
 Target Server Version : 50725
 File Encoding         : 65001

 Date: 08/07/2019 17:51:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for siam_auths
-- ----------------------------
DROP TABLE IF EXISTS `siam_auths`;
CREATE TABLE `siam_auths`  (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `auth_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限名',
  `auth_rules` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '路由地址',
  `auth_icon` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `auth_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '权限类型 0菜单1按钮',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`auth_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siam_auths
-- ----------------------------
INSERT INTO `siam_auths` VALUES (1, '后台管理', '/admin/*/*', 'layui-icon-rate-half', 1, 0, 0);
INSERT INTO `siam_auths` VALUES (2, '权限管理', '/auths/list', '', 1, 0, 0);
INSERT INTO `siam_auths` VALUES (3, '角色管理', '/roles/list', '', 1, 0, 0);
INSERT INTO `siam_auths` VALUES (4, '用户管理', '/user/list', '', 1, 0, 0);
INSERT INTO `siam_auths` VALUES (5, '查看权限缓存', '/api/system/showCache', '', 3, 1562548805, 1562548805);
INSERT INTO `siam_auths` VALUES (6, '清空权限缓存', '/api/system/clearCache', '', 3, 1562548820, 1562548820);
INSERT INTO `siam_auths` VALUES (7, '添加角色', '/api/roles/add', '', 3, 1562551947, 1562551947);

-- ----------------------------
-- Table structure for siam_migrations
-- ----------------------------
DROP TABLE IF EXISTS `siam_migrations`;
CREATE TABLE `siam_migrations`  (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `start_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siam_migrations
-- ----------------------------
INSERT INTO `siam_migrations` VALUES (20190422152409, 'Users', '2019-04-23 10:33:31', '2019-04-23 10:33:31', 0);
INSERT INTO `siam_migrations` VALUES (20190422153129, 'Auth', '2019-04-23 10:33:31', '2019-04-23 10:33:31', 0);
INSERT INTO `siam_migrations` VALUES (20190422153557, 'Role', '2019-04-23 10:33:32', '2019-04-23 10:33:32', 0);
INSERT INTO `siam_migrations` VALUES (20190422153927, 'System', '2019-04-23 10:33:32', '2019-04-23 10:33:32', 0);
INSERT INTO `siam_migrations` VALUES (20190423082658, 'UserChange', '2019-04-23 16:29:56', '2019-04-23 16:29:57', 0);
INSERT INTO `siam_migrations` VALUES (20190423083012, 'UserAddAuth', '2019-04-23 16:32:08', '2019-04-23 16:32:10', 0);

-- ----------------------------
-- Table structure for siam_roles
-- ----------------------------
DROP TABLE IF EXISTS `siam_roles`;
CREATE TABLE `siam_roles`  (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `role_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名',
  `role_auth` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '角色权限',
  `role_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '角色状态 0正常1禁用',
  `level` tinyint(1) NOT NULL DEFAULT 0 COMMENT '角色级别 越小权限越高',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siam_roles
-- ----------------------------
INSERT INTO `siam_roles` VALUES (1, '管理员', '1,2,3,4', 0, 0, 0, 0);
INSERT INTO `siam_roles` VALUES (2, '测试', '1,2', 0, 1, 0, 0);

-- ----------------------------
-- Table structure for siam_system
-- ----------------------------
DROP TABLE IF EXISTS `siam_system`;
CREATE TABLE `siam_system`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_next_id` int(11) NOT NULL COMMENT '下一个用户id',
  `auth_order` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]' COMMENT '权限排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siam_system
-- ----------------------------
INSERT INTO `siam_system` VALUES (1, 10021, '[{\"id\":1,\"child\":[{\"id\":2,\"child\":[{\"id\":5},{\"id\":6}]},{\"id\":3,\"child\":[{\"id\":7}]},{\"id\":4}]}]');

-- ----------------------------
-- Table structure for siam_users
-- ----------------------------
DROP TABLE IF EXISTS `siam_users`;
CREATE TABLE `siam_users`  (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'e10adc3949ba59abbe56e057f20f883e' COMMENT '用户密码',
  `u_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `u_account` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户登录名',
  `p_u_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '上级u_id',
  `role_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `u_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '用户状态 -1删除 0禁用 1正常',
  `u_level_line` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0-' COMMENT '用户层级链',
  `last_login_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `u_auth` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`u_id`) USING BTREE,
  UNIQUE INDEX `u_id`(`u_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siam_users
-- ----------------------------
INSERT INTO `siam_users` VALUES (1, 'e10adc3949ba59abbe56e057f20f883e', 'Siam', '1001', '0', '1', 1, '0-1', '0', 0, 0, 0, '');
INSERT INTO `siam_users` VALUES (2, 'e10adc3949ba59abbe56e057f20f883e', '测试', '100083', '1', '2', 1, '0-1-2', '0', 0, 0, 0, '15');

SET FOREIGN_KEY_CHECKS = 1;
