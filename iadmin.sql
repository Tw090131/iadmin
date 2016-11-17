-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-11 08:01:31
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iadmin`
--

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_menus`
--

CREATE TABLE `iadmin_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `parent_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '父级菜单ID',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单权限',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单链接',
  `heightlight_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单高亮',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `iadmin_menus`
--

INSERT INTO `iadmin_menus` (`id`, `name`, `icon`, `parent_id`, `slug`, `url`, `heightlight_url`, `sort`, `created_at`, `updated_at`) VALUES
(1, '控制台', '', '0', 'admin.system.login', 'admin', 'admin', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(2, '系统管理', '', '0', 'admin.system.manage', 'admin/menu', 'admin/menu*,admin/user*,admin/role*,admin/permission*', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(3, '菜单管理', '', '2', 'admin.menus.list', 'admin/menu', 'admin/menu', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(4, '用户管理', '', '2', 'admin.users.add', 'admin/users', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(5, '权限管理', '', '2', 'admin.permissions.list', 'admin/permissions', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(6, '角色管理', '', '2', 'admin.roles.list', 'www.iwanli.me', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(7, 'web前端', '', '0', '', 'www.iwanli.me', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(8, 'ReactJs', '', '7', '', 'www.iwanli.me', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(9, 'JavaScript', '', '7', '', 'www.iwanli.me', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(10, 'AngularJs', '', '7', '', 'www.iwanli.me', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(11, 'NodeJs', '', '7', '', 'www.iwanli.me', '', 0, '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(13, 'Vue.js', '', '14', 'admin.game.manager', 'asdf', 'asdf', 1, '2016-11-09 00:42:23', '2016-11-10 01:30:01'),
(14, 'H5游戏分析', '', '0', 'admin.game.manager', 'admin/game', 'admin/menu', 0, '2016-11-10 01:13:24', '2016-11-10 01:13:24');

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_migrations`
--

CREATE TABLE `iadmin_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `iadmin_migrations`
--

INSERT INTO `iadmin_migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_11_07_064852_entrust_setup_tables', 1),
('2016_11_08_063345_create_menus_table', 1);

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_password_resets`
--

CREATE TABLE `iadmin_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_permissions`
--

CREATE TABLE `iadmin_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `iadmin_permissions`
--

INSERT INTO `iadmin_permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin.system.login', '登录后台', '登录后台', '2016-11-08 19:07:05', '2016-11-10 21:54:25'),
(2, 'admin.system.manage', '系统管理', '系统管理', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(3, 'admin.menus.list', '菜单列表', '菜单列表', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(4, 'admin.menus.add', '添加菜单', '添加菜单', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(5, 'admin.menus.edit', '修改菜单', '修改菜单', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(6, 'admin.menus.delete', '删除菜单', '删除菜单', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(7, 'admin.permissions.list', '权限列表', '权限列表', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(8, 'admin.permissions.add', '添加权限', '添加权限', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(9, 'admin.permissions.edit', '修改权限', '修改权限', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(10, 'admin.permissions.delete', '删除权限', '删除权限', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(11, 'admin.roles.delete', '删除角色', '删除角色', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(12, 'admin.roles.list', '角色列表', '角色列表', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(13, 'admin.roles.add', '添加角色', '添加角色', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(14, 'admin.roles.edit', '修改角色', '修改角色', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(15, 'admin.users.list', '用户列表', '用户列表', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(16, 'admin.users.add', '添加用户', '添加用户', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(17, 'admin.users.edit', '修改用户', '修改用户', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(18, 'admin.users.delete', '删除用户', '删除用户', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(19, 'admin.users.show', '查看用户', '查看用户', '2016-11-09 19:09:14', '2016-11-09 19:09:14'),
(20, 'admin.game.manager', '游戏分析', '游戏分析', '2016-11-09 19:17:24', '2016-11-09 19:17:24');

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_permission_role`
--

CREATE TABLE `iadmin_permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `iadmin_permission_role`
--

INSERT INTO `iadmin_permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(4, 2),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1);

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_roles`
--

CREATE TABLE `iadmin_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `iadmin_roles`
--

INSERT INTO `iadmin_roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', '超级管理员', '炒鸡管理员', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(2, 'user', '普通管理', '普通管理', '2016-11-08 19:07:05', '2016-11-08 19:07:05');

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_role_user`
--

CREATE TABLE `iadmin_role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `iadmin_role_user`
--

INSERT INTO `iadmin_role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- 表的结构 `iadmin_users`
--

CREATE TABLE `iadmin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `iadmin_users`
--

INSERT INTO `iadmin_users` (`id`, `name`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'zzw', 'zzw', 'ibanya@126.com', '$2y$10$ncEzALypuPbfQrJ5WMgnyuBAhDX7vyjB7ekQUz.AyXF7iVqX0g90K', 'pxpj9yR52oegta4SYFuqw9GjtnPxX5o08CBRUfAS7jvQ9z1zLgP9cbb2OKO7', '2016-11-08 19:07:05', '2016-11-09 23:00:11'),
(2, 'Guiseppe Wiegand', 'Lilly', 'kamryn.barrows@example.org', '$2y$10$EYv3eJa9Jmeb0ZecYEFXY.YY9Z94hstmAb4dMoeIqo7ODHXwzepfu', 'JvJ1SqwPR4', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(3, 'Keyon Weimann', 'Hertha', 'ggottlieb@example.net', '$2y$10$EYv3eJa9Jmeb0ZecYEFXY.YY9Z94hstmAb4dMoeIqo7ODHXwzepfu', 'VLK0f1nlx0', '2016-11-08 19:07:05', '2016-11-08 19:07:05'),
(4, 'Noah Schinner', 'Delaney', 'golda08@example.net', '$2y$10$EYv3eJa9Jmeb0ZecYEFXY.YY9Z94hstmAb4dMoeIqo7ODHXwzepfu', 'i8zu1nrlIb', '2016-11-08 19:07:05', '2016-11-08 19:07:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `iadmin_menus`
--
ALTER TABLE `iadmin_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iadmin_password_resets`
--
ALTER TABLE `iadmin_password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `iadmin_permissions`
--
ALTER TABLE `iadmin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `iadmin_permission_role`
--
ALTER TABLE `iadmin_permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `iadmin_roles`
--
ALTER TABLE `iadmin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `iadmin_role_user`
--
ALTER TABLE `iadmin_role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `iadmin_users`
--
ALTER TABLE `iadmin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `iadmin_menus`
--
ALTER TABLE `iadmin_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `iadmin_permissions`
--
ALTER TABLE `iadmin_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `iadmin_roles`
--
ALTER TABLE `iadmin_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `iadmin_users`
--
ALTER TABLE `iadmin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
