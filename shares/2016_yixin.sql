-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 09 月 18 日 17:48
-- 服务器版本: 5.5.47
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `2016_yixin`
--

-- --------------------------------------------------------

--
-- 表的结构 `sp_ad`
--

CREATE TABLE IF NOT EXISTS `sp_ad` (
  `ad_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `ad_name` varchar(255) NOT NULL,
  `ad_content` text,
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`ad_id`),
  KEY `ad_name` (`ad_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_asset`
--

CREATE TABLE IF NOT EXISTS `sp_asset` (
  `aid` bigint(20) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `filepath` varchar(200) NOT NULL,
  `uploadtime` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `meta` text,
  `suffix` varchar(50) DEFAULT NULL,
  `download_times` int(6) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_auth_access`
--

CREATE TABLE IF NOT EXISTS `sp_auth_access` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(255) NOT NULL COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) DEFAULT NULL COMMENT '权限规则分类，请加应用前缀,如admin_',
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sp_auth_access`
--

INSERT INTO `sp_auth_access` (`role_id`, `rule_name`, `type`) VALUES
(4, 'protal/protype/delete', 'admin_url'),
(4, 'portal/prostatus/edit_release', 'admin_url'),
(4, 'portal/prostatus/index', 'admin_url'),
(4, 'admin/goods/default', 'admin_url'),
(4, 'admin/storesh/enable', 'admin_url'),
(4, 'admin/storesh/index', 'admin_url'),
(4, 'admin/storemx/index', 'admin_url'),
(4, 'admin/store/addscore', 'admin_url'),
(4, 'admin/store/fanxian', 'admin_url'),
(4, 'admin/store/edit_post', 'admin_url'),
(4, 'admin/store/qiyong', 'admin_url'),
(3, 'portal/adminpage/restore', 'admin_url'),
(3, 'admin/withdrawcg/index', 'admin_url'),
(3, 'admin/withdrawdcl/index', 'admin_url'),
(3, 'admin/withdraw/default', 'admin_url'),
(3, 'admin/user/cancelban', 'admin_url'),
(3, 'admin/user/ban', 'admin_url'),
(3, 'admin/user/add_post', 'admin_url'),
(3, 'admin/user/add', 'admin_url'),
(3, 'admin/user/edit', 'admin_url'),
(3, 'admin/user/edit_post', 'admin_url'),
(3, 'admin/user/delete', 'admin_url'),
(3, 'admin/rbac/roleadd', 'admin_url'),
(3, 'admin/rbac/roleadd_post', 'admin_url'),
(3, 'admin/user/index', 'admin_url'),
(3, 'admin/rbac/roledelete', 'admin_url'),
(3, 'admin/rbac/roleedit_post', 'admin_url'),
(3, 'admin/rbac/roleedit', 'admin_url'),
(3, 'admin/rbac/authorize_post', 'admin_url'),
(3, 'admin/rbac/authorize', 'admin_url'),
(3, 'admin/rbac/member', 'admin_url'),
(3, 'admin/rbac/index', 'admin_url'),
(3, 'user/indexadmin/default3', 'admin_url'),
(3, 'user/usermx/index', 'admin_url'),
(3, 'user/indexadmin/cancelban', 'admin_url'),
(3, 'user/indexadmin/ban', 'admin_url'),
(3, 'user/indexadmin/index', 'admin_url'),
(3, 'user/indexadmin/default', 'admin_url'),
(3, 'user/indexadmin/default1', 'admin_url'),
(3, 'admin/mailer/active_post', 'admin_url'),
(3, 'admin/setting/clearcache', 'admin_url'),
(3, 'admin/mailer/index_post', 'admin_url'),
(3, 'admin/mailer/active', 'admin_url'),
(3, 'admin/mailer/index', 'admin_url'),
(3, 'admin/mailer/default', 'admin_url'),
(3, 'admin/route/listorders', 'admin_url'),
(3, 'admin/route/ban', 'admin_url'),
(3, 'admin/route/open', 'admin_url'),
(3, 'admin/route/delete', 'admin_url'),
(3, 'admin/route/edit_post', 'admin_url'),
(3, 'admin/route/edit', 'admin_url'),
(3, 'admin/route/add_post', 'admin_url'),
(3, 'admin/route/index', 'admin_url'),
(3, 'admin/route/add', 'admin_url'),
(3, 'admin/setting/site_post', 'admin_url'),
(3, 'admin/setting/site', 'admin_url'),
(3, 'admin/setting/password_post', 'admin_url'),
(3, 'admin/setting/password', 'admin_url'),
(3, 'admin/user/userinfo_post', 'admin_url'),
(3, 'admin/user/userinfo', 'admin_url'),
(3, 'admin/setting/userdefault', 'admin_url'),
(3, 'admin/setting/default', 'admin_url'),
(3, 'admin/menu/lists', 'admin_url'),
(3, 'admin/menu/delete', 'admin_url'),
(3, 'admin/menu/edit', 'admin_url'),
(3, 'admin/menu/edit_post', 'admin_url'),
(3, 'admin/menu/export_menu', 'admin_url'),
(3, 'admin/menu/listorders', 'admin_url'),
(3, 'admin/menu/add_post', 'admin_url'),
(3, 'admin/menu/add', 'admin_url'),
(3, 'admin/menu/index', 'admin_url'),
(3, 'admin/menu/default', 'admin_url'),
(3, 'admin/storage/setting_post', 'admin_url'),
(3, 'admin/storage/index', 'admin_url'),
(3, 'api/oauthadmin/setting_post', 'admin_url'),
(3, 'api/oauthadmin/setting', 'admin_url'),
(3, 'admin/link/add', 'admin_url'),
(3, 'admin/link/add_post', 'admin_url'),
(3, 'admin/link/edit_post', 'admin_url'),
(3, 'admin/link/edit', 'admin_url'),
(3, 'admin/link/delete', 'admin_url'),
(3, 'admin/link/toggle', 'admin_url'),
(3, 'admin/link/listorders', 'admin_url'),
(3, 'admin/ad/add', 'admin_url'),
(3, 'admin/link/index', 'admin_url'),
(3, 'admin/ad/add_post', 'admin_url'),
(3, 'admin/ad/edit_post', 'admin_url'),
(3, 'admin/ad/edit', 'admin_url'),
(3, 'admin/ad/delete', 'admin_url'),
(3, 'admin/ad/toggle', 'admin_url'),
(3, 'admin/ad/index', 'admin_url'),
(3, 'admin/slidecat/add_post', 'admin_url'),
(3, 'admin/slidecat/add', 'admin_url'),
(3, 'admin/slidecat/edit_post', 'admin_url'),
(3, 'admin/slidecat/edit', 'admin_url'),
(3, 'admin/slidecat/delete', 'admin_url'),
(3, 'admin/slidecat/index', 'admin_url'),
(3, 'admin/slide/ban', 'admin_url'),
(3, 'admin/slide/cancelban', 'admin_url'),
(3, 'admin/slide/add', 'admin_url'),
(3, 'admin/slide/add_post', 'admin_url'),
(3, 'admin/slide/edit_post', 'admin_url'),
(3, 'admin/slide/edit', 'admin_url'),
(3, 'admin/slide/delete', 'admin_url'),
(3, 'admin/slide/toggle', 'admin_url'),
(3, 'admin/slide/listorders', 'admin_url'),
(3, 'admin/slide/default', 'admin_url'),
(3, 'admin/slide/index', 'admin_url'),
(3, 'admin/plugin/update', 'admin_url'),
(3, 'admin/plugin/uninstall', 'admin_url'),
(3, 'admin/plugin/install', 'admin_url'),
(3, 'admin/plugin/setting_post', 'admin_url'),
(3, 'admin/plugin/setting', 'admin_url'),
(3, 'admin/plugin/toggle', 'admin_url'),
(3, 'admin/backup/import', 'admin_url'),
(3, 'admin/plugin/index', 'admin_url'),
(3, 'admin/backup/download', 'admin_url'),
(3, 'admin/backup/del_backup', 'admin_url'),
(3, 'admin/backup/index_post', 'admin_url'),
(3, 'admin/backup/index', 'admin_url'),
(3, 'admin/backup/restore', 'admin_url'),
(3, 'admin/backup/default', 'admin_url'),
(4, 'admin/store/index', 'admin_url'),
(4, 'admin/store/edit', 'admin_url'),
(4, 'admin/storetype/delete', 'admin_url'),
(4, 'admin/storetype/edit', 'admin_url'),
(4, 'admin/storetype/add', 'admin_url'),
(4, 'admin/user/cancelban', 'admin_url'),
(4, 'admin/storetype/index', 'admin_url'),
(4, 'admin/store/default', 'admin_url'),
(4, 'admin/user/ban', 'admin_url'),
(4, 'admin/user/add_post', 'admin_url'),
(4, 'admin/user/delete', 'admin_url'),
(4, 'admin/user/edit', 'admin_url'),
(4, 'admin/user/edit_post', 'admin_url'),
(4, 'admin/user/add', 'admin_url'),
(4, 'admin/user/index', 'admin_url'),
(4, 'admin/rbac/roleadd_post', 'admin_url'),
(4, 'admin/rbac/roleadd', 'admin_url'),
(4, 'admin/rbac/roleedit_post', 'admin_url'),
(4, 'admin/rbac/roledelete', 'admin_url'),
(3, 'admin/extension/default', 'admin_url'),
(3, 'portal/adminpage/clean', 'admin_url'),
(3, 'portal/adminpage/recyclebin', 'admin_url'),
(3, 'portal/adminpost/clean', 'admin_url'),
(3, 'portal/adminpost/restore', 'admin_url'),
(3, 'portal/adminpost/recyclebin', 'admin_url'),
(3, 'admin/recycle/default', 'admin_url'),
(3, 'portal/adminpage/add_post', 'admin_url'),
(3, 'portal/adminpage/add', 'admin_url'),
(3, 'portal/adminpage/edit_post', 'admin_url'),
(3, 'portal/adminpage/edit', 'admin_url'),
(3, 'portal/adminpage/delete', 'admin_url'),
(3, 'portal/adminpage/listorders', 'admin_url'),
(3, 'portal/adminpage/index', 'admin_url'),
(3, 'portal/adminterm/add_post', 'admin_url'),
(3, 'portal/adminterm/add', 'admin_url'),
(3, 'portal/adminterm/edit_post', 'admin_url'),
(3, 'portal/adminterm/edit', 'admin_url'),
(3, 'portal/adminterm/delete', 'admin_url'),
(3, 'portal/adminterm/index', 'admin_url'),
(3, 'portal/adminterm/listorders', 'admin_url'),
(3, 'portal/adminpost/add_post', 'admin_url'),
(3, 'portal/adminpost/add', 'admin_url'),
(3, 'portal/adminpost/edit_post', 'admin_url'),
(3, 'portal/adminpost/edit', 'admin_url'),
(4, 'admin/rbac/roleedit', 'admin_url'),
(4, 'admin/rbac/authorize_post', 'admin_url'),
(4, 'admin/rbac/authorize', 'admin_url'),
(4, 'admin/rbac/member', 'admin_url'),
(4, 'admin/rbac/index', 'admin_url'),
(4, 'user/indexadmin/default3', 'admin_url'),
(4, 'user/usermx/dctx', 'admin_url'),
(4, 'user/usermx/index', 'admin_url'),
(5, 'user/usermx/index', 'admin_url'),
(3, 'admin/withdrawall/index', 'admin_url'),
(5, 'user/indexadmin/cancelban', 'admin_url'),
(5, 'user/indexadmin/ban', 'admin_url'),
(5, 'user/indexadmin/index', 'admin_url'),
(5, 'user/indexadmin/default1', 'admin_url'),
(3, 'portal/adminpost/delete', 'admin_url'),
(3, 'portal/adminpost/check', 'admin_url'),
(3, 'portal/adminpost/move', 'admin_url'),
(3, 'portal/adminpost/recommend', 'admin_url'),
(3, 'portal/adminpost/top', 'admin_url'),
(3, 'portal/adminpost/listorders', 'admin_url'),
(3, 'portal/adminpost/index', 'admin_url'),
(3, 'comment/commentadmin/check', 'admin_url'),
(3, 'comment/commentadmin/delete', 'admin_url'),
(3, 'comment/commentadmin/index', 'admin_url'),
(3, 'api/guestbookadmin/delete', 'admin_url'),
(3, 'api/guestbookadmin/index', 'admin_url'),
(3, 'admin/content/default', 'admin_url'),
(5, 'user/indexadmin/default', 'admin_url'),
(3, 'admin/dls/default', 'admin_url'),
(3, 'admin/dls/index', 'admin_url'),
(3, 'admin/dlstype/index', 'admin_url'),
(3, 'admin/dlsfr/index', 'admin_url'),
(3, 'admin/store/default', 'admin_url'),
(3, 'admin/storetype/index', 'admin_url'),
(3, 'admin/storetype/add', 'admin_url'),
(3, 'admin/storetype/edit', 'admin_url'),
(3, 'admin/storetype/delete', 'admin_url'),
(3, 'admin/store/index', 'admin_url'),
(3, 'admin/store/edit', 'admin_url'),
(3, 'admin/store/edit_post', 'admin_url'),
(3, 'admin/store/qiyong', 'admin_url'),
(3, 'admin/store/fanxian', 'admin_url'),
(3, 'admin/store/addscore', 'admin_url'),
(3, 'admin/storemx/index', 'admin_url'),
(3, 'admin/storesh/index', 'admin_url'),
(3, 'admin/storesh/enable', 'admin_url'),
(4, 'portal/protype/index', 'admin_url'),
(4, 'portal/prostatus/is_index', 'admin_url'),
(4, 'portal/prostatus/check', 'admin_url'),
(4, 'portal/prostatus/listorders', 'admin_url'),
(4, 'portal/prostatus/delete', 'admin_url'),
(4, 'portal/prostatus/edit_goods_post', 'admin_url'),
(4, 'portal/prostatus/edit_goods', 'admin_url'),
(4, 'user/indexadmin/cancelban', 'admin_url'),
(4, 'user/indexadmin/ban', 'admin_url'),
(4, 'user/indexadmin/index', 'admin_url'),
(4, 'user/indexadmin/default1', 'admin_url'),
(4, 'user/indexadmin/default', 'admin_url'),
(4, 'portal/adminpage/add_post', 'admin_url'),
(4, 'portal/adminpage/add', 'admin_url'),
(4, 'portal/adminpage/edit_post', 'admin_url'),
(4, 'portal/adminpage/delete', 'admin_url'),
(4, 'portal/adminpage/edit', 'admin_url'),
(4, 'portal/adminpage/listorders', 'admin_url'),
(4, 'portal/adminpage/index', 'admin_url'),
(4, 'portal/adminpost/add_post', 'admin_url'),
(4, 'portal/adminpost/add', 'admin_url'),
(4, 'portal/adminpost/edit_post', 'admin_url'),
(4, 'portal/adminpost/edit', 'admin_url'),
(4, 'portal/adminpost/delete', 'admin_url'),
(4, 'portal/adminpost/check', 'admin_url'),
(4, 'portal/adminpost/move', 'admin_url'),
(4, 'portal/adminpost/recommend', 'admin_url'),
(4, 'portal/adminpost/top', 'admin_url'),
(4, 'portal/adminpost/listorders', 'admin_url'),
(4, 'portal/adminpost/index', 'admin_url'),
(4, 'admin/content/default', 'admin_url'),
(2, 'admin/cwgl/dctx', 'admin_url'),
(2, 'admin/cwgl/index', 'admin_url'),
(2, 'admin/withdrawall/dctx', 'admin_url'),
(2, 'admin/withdrawall/enable', 'admin_url'),
(2, 'admin/withdrawall/index', 'admin_url'),
(2, 'admin/withdrawcg/dctx', 'admin_url'),
(2, 'admin/withdrawcg/index', 'admin_url'),
(2, 'admin/withdrawdcl/dctx', 'admin_url'),
(2, 'admin/withdrawdcl/enable', 'admin_url'),
(2, 'admin/withdrawdcl/index', 'admin_url'),
(2, 'admin/withdraw/default', 'admin_url'),
(2, 'user/usermx/dctx', 'admin_url'),
(2, 'user/usermx/index', 'admin_url'),
(2, 'user/indexadmin/default1', 'admin_url'),
(2, 'user/indexadmin/default', 'admin_url'),
(4, 'portal/protype/edit', 'admin_url'),
(4, 'protal/protype/edit_post', 'admin_url'),
(4, 'portal/protype/check', 'admin_url'),
(4, 'portal/protype/class_attr', 'admin_url'),
(4, 'portal/protype/class_attr_delete', 'admin_url'),
(4, 'protal/protype/class_attr_edit', 'admin_url'),
(4, 'portal/protype/class_attr_check', 'admin_url'),
(4, 'portal/protype/class_attr_search', 'admin_url'),
(4, 'portal/brand/index', 'admin_url'),
(4, 'portal/brand/add', 'admin_url'),
(4, 'portal/brand/edit', 'admin_url'),
(4, 'portal/brand/edit_post', 'admin_url'),
(4, 'portal/brand/delete', 'admin_url'),
(4, 'portal/brand/check', 'admin_url'),
(4, 'portal/brand/is_index', 'admin_url');

-- --------------------------------------------------------

--
-- 表的结构 `sp_auth_rule`
--

CREATE TABLE IF NOT EXISTS `sp_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` varchar(30) NOT NULL DEFAULT '1' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `param` varchar(255) DEFAULT NULL COMMENT '额外url参数',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限规则表' AUTO_INCREMENT=267 ;

--
-- 转存表中的数据 `sp_auth_rule`
--

INSERT INTO `sp_auth_rule` (`id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition`) VALUES
(1, 'Admin', 'admin_url', 'admin/content/default', NULL, '内容管理', 1, ''),
(2, 'Api', 'admin_url', 'api/guestbookadmin/index', NULL, '所有留言', 1, ''),
(3, 'Api', 'admin_url', 'api/guestbookadmin/delete', NULL, '删除网站留言', 1, ''),
(4, 'Comment', 'admin_url', 'comment/commentadmin/index', NULL, '评论管理', 1, ''),
(5, 'Comment', 'admin_url', 'comment/commentadmin/delete', NULL, '删除评论', 1, ''),
(6, 'Comment', 'admin_url', 'comment/commentadmin/check', NULL, '评论审核', 1, ''),
(7, 'Portal', 'admin_url', 'portal/adminpost/index', NULL, '文章管理', 1, ''),
(8, 'Portal', 'admin_url', 'portal/adminpost/listorders', NULL, '文章排序', 1, ''),
(9, 'Portal', 'admin_url', 'portal/adminpost/top', NULL, '文章置顶', 1, ''),
(10, 'Portal', 'admin_url', 'portal/adminpost/recommend', NULL, '文章推荐', 1, ''),
(11, 'Portal', 'admin_url', 'portal/adminpost/move', NULL, '批量移动', 1, ''),
(12, 'Portal', 'admin_url', 'portal/adminpost/check', NULL, '文章审核', 1, ''),
(13, 'Portal', 'admin_url', 'portal/adminpost/delete', NULL, '删除文章', 1, ''),
(14, 'Portal', 'admin_url', 'portal/adminpost/edit', NULL, '编辑文章', 1, ''),
(15, 'Portal', 'admin_url', 'portal/adminpost/edit_post', NULL, '提交编辑', 1, ''),
(16, 'Portal', 'admin_url', 'portal/adminpost/add', NULL, '添加文章', 1, ''),
(17, 'Portal', 'admin_url', 'portal/adminpost/add_post', NULL, '提交添加', 1, ''),
(18, 'Portal', 'admin_url', 'portal/adminterm/index', NULL, '分类管理', 1, ''),
(19, 'Portal', 'admin_url', 'portal/adminterm/listorders', NULL, '文章分类排序', 1, ''),
(20, 'Portal', 'admin_url', 'portal/adminterm/delete', NULL, '删除分类', 1, ''),
(21, 'Portal', 'admin_url', 'portal/adminterm/edit', NULL, '编辑分类', 1, ''),
(22, 'Portal', 'admin_url', 'portal/adminterm/edit_post', NULL, '提交编辑', 1, ''),
(23, 'Portal', 'admin_url', 'portal/adminterm/add', NULL, '添加分类', 1, ''),
(24, 'Portal', 'admin_url', 'portal/adminterm/add_post', NULL, '提交添加', 1, ''),
(25, 'Portal', 'admin_url', 'portal/adminpage/index', NULL, '页面管理', 1, ''),
(26, 'Portal', 'admin_url', 'portal/adminpage/listorders', NULL, '页面排序', 1, ''),
(27, 'Portal', 'admin_url', 'portal/adminpage/delete', NULL, '删除页面', 1, ''),
(28, 'Portal', 'admin_url', 'portal/adminpage/edit', NULL, '编辑页面', 1, ''),
(29, 'Portal', 'admin_url', 'portal/adminpage/edit_post', NULL, '提交编辑', 1, ''),
(30, 'Portal', 'admin_url', 'portal/adminpage/add', NULL, '添加页面', 1, ''),
(31, 'Portal', 'admin_url', 'portal/adminpage/add_post', NULL, '提交添加', 1, ''),
(32, 'Admin', 'admin_url', 'admin/recycle/default', NULL, '回收站', 1, ''),
(33, 'Portal', 'admin_url', 'portal/adminpost/recyclebin', NULL, '文章回收', 1, ''),
(34, 'Portal', 'admin_url', 'portal/adminpost/restore', NULL, '文章还原', 1, ''),
(35, 'Portal', 'admin_url', 'portal/adminpost/clean', NULL, '彻底删除', 1, ''),
(36, 'Portal', 'admin_url', 'portal/adminpage/recyclebin', NULL, '页面回收', 1, ''),
(37, 'Portal', 'admin_url', 'portal/adminpage/clean', NULL, '彻底删除', 1, ''),
(38, 'Portal', 'admin_url', 'portal/adminpage/restore', NULL, '页面还原', 1, ''),
(39, 'Admin', 'admin_url', 'admin/extension/default', NULL, '扩展工具', 1, ''),
(40, 'Admin', 'admin_url', 'admin/backup/default', NULL, '备份管理', 1, ''),
(41, 'Admin', 'admin_url', 'admin/backup/restore', NULL, '数据还原', 1, ''),
(42, 'Admin', 'admin_url', 'admin/backup/index', NULL, '数据备份', 1, ''),
(43, 'Admin', 'admin_url', 'admin/backup/index_post', NULL, '提交数据备份', 1, ''),
(44, 'Admin', 'admin_url', 'admin/backup/download', NULL, '下载备份', 1, ''),
(45, 'Admin', 'admin_url', 'admin/backup/del_backup', NULL, '删除备份', 1, ''),
(46, 'Admin', 'admin_url', 'admin/backup/import', NULL, '数据备份导入', 1, ''),
(47, 'Admin', 'admin_url', 'admin/plugin/index', NULL, '插件管理', 1, ''),
(48, 'Admin', 'admin_url', 'admin/plugin/toggle', NULL, '插件启用切换', 1, ''),
(49, 'Admin', 'admin_url', 'admin/plugin/setting', NULL, '插件设置', 1, ''),
(50, 'Admin', 'admin_url', 'admin/plugin/setting_post', NULL, '插件设置提交', 1, ''),
(51, 'Admin', 'admin_url', 'admin/plugin/install', NULL, '插件安装', 1, ''),
(52, 'Admin', 'admin_url', 'admin/plugin/uninstall', NULL, '插件卸载', 1, ''),
(53, 'Admin', 'admin_url', 'admin/slide/default', NULL, '幻灯片', 1, ''),
(54, 'Admin', 'admin_url', 'admin/slide/index', NULL, '幻灯片管理', 1, ''),
(55, 'Admin', 'admin_url', 'admin/slide/listorders', NULL, '幻灯片排序', 1, ''),
(56, 'Admin', 'admin_url', 'admin/slide/toggle', NULL, '幻灯片显示切换', 1, ''),
(57, 'Admin', 'admin_url', 'admin/slide/delete', NULL, '删除幻灯片', 1, ''),
(58, 'Admin', 'admin_url', 'admin/slide/edit', NULL, '编辑幻灯片', 1, ''),
(59, 'Admin', 'admin_url', 'admin/slide/edit_post', NULL, '提交编辑', 1, ''),
(60, 'Admin', 'admin_url', 'admin/slide/add', NULL, '添加幻灯片', 1, ''),
(61, 'Admin', 'admin_url', 'admin/slide/add_post', NULL, '提交添加', 1, ''),
(62, 'Admin', 'admin_url', 'admin/slidecat/index', NULL, '幻灯片分类', 1, ''),
(63, 'Admin', 'admin_url', 'admin/slidecat/delete', NULL, '删除分类', 1, ''),
(64, 'Admin', 'admin_url', 'admin/slidecat/edit', NULL, '编辑分类', 1, ''),
(65, 'Admin', 'admin_url', 'admin/slidecat/edit_post', NULL, '提交编辑', 1, ''),
(66, 'Admin', 'admin_url', 'admin/slidecat/add', NULL, '添加分类', 1, ''),
(67, 'Admin', 'admin_url', 'admin/slidecat/add_post', NULL, '提交添加', 1, ''),
(68, 'Admin', 'admin_url', 'admin/ad/index', NULL, '网站广告', 1, ''),
(69, 'Admin', 'admin_url', 'admin/ad/toggle', NULL, '广告显示切换', 1, ''),
(70, 'Admin', 'admin_url', 'admin/ad/delete', NULL, '删除广告', 1, ''),
(71, 'Admin', 'admin_url', 'admin/ad/edit', NULL, '编辑广告', 1, ''),
(72, 'Admin', 'admin_url', 'admin/ad/edit_post', NULL, '提交编辑', 1, ''),
(73, 'Admin', 'admin_url', 'admin/ad/add', NULL, '添加广告', 1, ''),
(74, 'Admin', 'admin_url', 'admin/ad/add_post', NULL, '提交添加', 1, ''),
(75, 'Admin', 'admin_url', 'admin/link/index', NULL, '友情链接', 1, ''),
(76, 'Admin', 'admin_url', 'admin/link/listorders', NULL, '友情链接排序', 1, ''),
(77, 'Admin', 'admin_url', 'admin/link/toggle', NULL, '友链显示切换', 1, ''),
(78, 'Admin', 'admin_url', 'admin/link/delete', NULL, '删除友情链接', 1, ''),
(79, 'Admin', 'admin_url', 'admin/link/edit', NULL, '编辑友情链接', 1, ''),
(80, 'Admin', 'admin_url', 'admin/link/edit_post', NULL, '提交编辑', 1, ''),
(81, 'Admin', 'admin_url', 'admin/link/add', NULL, '添加友情链接', 1, ''),
(82, 'Admin', 'admin_url', 'admin/link/add_post', NULL, '提交添加', 1, ''),
(83, 'Api', 'admin_url', 'api/oauthadmin/setting', NULL, '第三方登陆', 1, ''),
(84, 'Api', 'admin_url', 'api/oauthadmin/setting_post', NULL, '提交设置', 1, ''),
(85, 'Admin', 'admin_url', 'admin/menu/default', NULL, '菜单管理', 1, ''),
(86, 'Admin', 'admin_url', 'admin/navcat/default1', NULL, '前台菜单', 1, ''),
(87, 'Admin', 'admin_url', 'admin/nav/index', NULL, '菜单管理', 1, ''),
(88, 'Admin', 'admin_url', 'admin/nav/listorders', NULL, '前台导航排序', 1, ''),
(89, 'Admin', 'admin_url', 'admin/nav/delete', NULL, '删除菜单', 1, ''),
(90, 'Admin', 'admin_url', 'admin/nav/edit', NULL, '编辑菜单', 1, ''),
(91, 'Admin', 'admin_url', 'admin/nav/edit_post', NULL, '提交编辑', 1, ''),
(92, 'Admin', 'admin_url', 'admin/nav/add', NULL, '添加菜单', 1, ''),
(93, 'Admin', 'admin_url', 'admin/nav/add_post', NULL, '提交添加', 1, ''),
(94, 'Admin', 'admin_url', 'admin/navcat/index', NULL, '菜单分类', 1, ''),
(95, 'Admin', 'admin_url', 'admin/navcat/delete', NULL, '删除分类', 1, ''),
(96, 'Admin', 'admin_url', 'admin/navcat/edit', NULL, '编辑分类', 1, ''),
(97, 'Admin', 'admin_url', 'admin/navcat/edit_post', NULL, '提交编辑', 1, ''),
(98, 'Admin', 'admin_url', 'admin/navcat/add', NULL, '添加分类', 1, ''),
(99, 'Admin', 'admin_url', 'admin/navcat/add_post', NULL, '提交添加', 1, ''),
(100, 'Admin', 'admin_url', 'admin/menu/index', NULL, '后台菜单', 1, ''),
(101, 'Admin', 'admin_url', 'admin/menu/add', NULL, '添加菜单', 1, ''),
(102, 'Admin', 'admin_url', 'admin/menu/add_post', NULL, '提交添加', 1, ''),
(103, 'Admin', 'admin_url', 'admin/menu/listorders', NULL, '后台菜单排序', 1, ''),
(104, 'Admin', 'admin_url', 'admin/menu/export_menu', NULL, '菜单备份', 1, ''),
(105, 'Admin', 'admin_url', 'admin/menu/edit', NULL, '编辑菜单', 1, ''),
(106, 'Admin', 'admin_url', 'admin/menu/edit_post', NULL, '提交编辑', 1, ''),
(107, 'Admin', 'admin_url', 'admin/menu/delete', NULL, '删除菜单', 1, ''),
(108, 'Admin', 'admin_url', 'admin/menu/lists', NULL, '所有菜单', 1, ''),
(109, 'Admin', 'admin_url', 'admin/setting/default', NULL, '系统设置', 1, ''),
(110, 'Admin', 'admin_url', 'admin/setting/userdefault', NULL, '个人信息', 1, ''),
(111, 'Admin', 'admin_url', 'admin/user/userinfo', NULL, '修改信息', 1, ''),
(112, 'Admin', 'admin_url', 'admin/user/userinfo_post', NULL, '修改信息提交', 1, ''),
(113, 'Admin', 'admin_url', 'admin/setting/password', NULL, '修改密码', 1, ''),
(114, 'Admin', 'admin_url', 'admin/setting/password_post', NULL, '提交修改', 1, ''),
(115, 'Admin', 'admin_url', 'admin/setting/site', NULL, '网站信息', 1, ''),
(116, 'Admin', 'admin_url', 'admin/setting/site_post', NULL, '提交修改', 1, ''),
(117, 'Admin', 'admin_url', 'admin/route/index', NULL, '路由列表', 1, ''),
(118, 'Admin', 'admin_url', 'admin/route/add', NULL, '路由添加', 1, ''),
(119, 'Admin', 'admin_url', 'admin/route/add_post', NULL, '路由添加提交', 1, ''),
(120, 'Admin', 'admin_url', 'admin/route/edit', NULL, '路由编辑', 1, ''),
(121, 'Admin', 'admin_url', 'admin/route/edit_post', NULL, '路由编辑提交', 1, ''),
(122, 'Admin', 'admin_url', 'admin/route/delete', NULL, '路由删除', 1, ''),
(123, 'Admin', 'admin_url', 'admin/route/ban', NULL, '路由禁止', 1, ''),
(124, 'Admin', 'admin_url', 'admin/route/open', NULL, '路由启用', 1, ''),
(125, 'Admin', 'admin_url', 'admin/route/listorders', NULL, '路由排序', 1, ''),
(126, 'Admin', 'admin_url', 'admin/mailer/default', NULL, '邮箱配置', 1, ''),
(127, 'Admin', 'admin_url', 'admin/mailer/index', NULL, 'SMTP配置', 1, ''),
(128, 'Admin', 'admin_url', 'admin/mailer/index_post', NULL, '提交配置', 1, ''),
(129, 'Admin', 'admin_url', 'admin/mailer/active', NULL, '邮件模板', 1, ''),
(130, 'Admin', 'admin_url', 'admin/mailer/active_post', NULL, '提交模板', 1, ''),
(131, 'Admin', 'admin_url', 'admin/setting/clearcache', NULL, '清除缓存', 1, ''),
(132, 'User', 'admin_url', 'user/indexadmin/default', NULL, '用户管理', 1, ''),
(133, 'User', 'admin_url', 'user/indexadmin/default1', NULL, '用户组', 1, ''),
(134, 'User', 'admin_url', 'user/indexadmin/index', NULL, '本站用户', 1, ''),
(135, 'User', 'admin_url', 'user/indexadmin/ban', NULL, '拉黑会员', 1, ''),
(136, 'User', 'admin_url', 'user/indexadmin/cancelban', NULL, '启用会员', 1, ''),
(137, 'User', 'admin_url', 'user/oauthadmin/index', NULL, '第三方用户', 1, ''),
(138, 'User', 'admin_url', 'user/oauthadmin/delete', NULL, '第三方用户解绑', 1, ''),
(139, 'User', 'admin_url', 'user/indexadmin/default3', NULL, '管理组', 1, ''),
(140, 'Admin', 'admin_url', 'admin/rbac/index', NULL, '角色管理', 1, ''),
(141, 'Admin', 'admin_url', 'admin/rbac/member', NULL, '成员管理', 1, ''),
(142, 'Admin', 'admin_url', 'admin/rbac/authorize', NULL, '权限设置', 1, ''),
(143, 'Admin', 'admin_url', 'admin/rbac/authorize_post', NULL, '提交设置', 1, ''),
(144, 'Admin', 'admin_url', 'admin/rbac/roleedit', NULL, '编辑角色', 1, ''),
(145, 'Admin', 'admin_url', 'admin/rbac/roleedit_post', NULL, '提交编辑', 1, ''),
(146, 'Admin', 'admin_url', 'admin/rbac/roledelete', NULL, '删除角色', 1, ''),
(147, 'Admin', 'admin_url', 'admin/rbac/roleadd', NULL, '添加角色', 1, ''),
(148, 'Admin', 'admin_url', 'admin/rbac/roleadd_post', NULL, '提交添加', 1, ''),
(149, 'Admin', 'admin_url', 'admin/user/index', NULL, '管理员', 1, ''),
(150, 'Admin', 'admin_url', 'admin/user/delete', NULL, '删除管理员', 1, ''),
(151, 'Admin', 'admin_url', 'admin/user/edit', NULL, '管理员编辑', 1, ''),
(152, 'Admin', 'admin_url', 'admin/user/edit_post', NULL, '编辑提交', 1, ''),
(153, 'Admin', 'admin_url', 'admin/user/add', NULL, '管理员添加', 1, ''),
(154, 'Admin', 'admin_url', 'admin/user/add_post', NULL, '添加提交', 1, ''),
(155, 'Admin', 'admin_url', 'admin/plugin/update', NULL, '插件更新', 1, ''),
(156, 'Admin', 'admin_url', 'admin/storage/index', NULL, '文件存储', 1, ''),
(157, 'Admin', 'admin_url', 'admin/storage/setting_post', NULL, '文件存储设置提交', 1, ''),
(158, 'Admin', 'admin_url', 'admin/slide/ban', NULL, '禁用幻灯片', 1, ''),
(159, 'Admin', 'admin_url', 'admin/slide/cancelban', NULL, '启用幻灯片', 1, ''),
(160, 'Admin', 'admin_url', 'admin/user/ban', NULL, '禁用管理员', 1, ''),
(161, 'Admin', 'admin_url', 'admin/user/cancelban', NULL, '启用管理员', 1, ''),
(162, 'Admin', 'admin_url', 'admin/tx/default', NULL, '提现管理', 1, ''),
(163, 'Admin', 'admin_url', 'admin/dcltx/index', NULL, '待处理提现', 1, ''),
(164, 'Admin', 'admin_url', 'admin/cgtx/index', NULL, '成功提现', 1, ''),
(165, 'Admin', 'admin_url', 'admin/sytx/index', NULL, '所有提现', 1, ''),
(166, 'Admin', 'admin_url', 'admin/dls/default', NULL, '代理商管理', 1, ''),
(167, 'Admin', 'admin_url', 'admin/dls/index', NULL, '代理商管理', 1, ''),
(168, 'Admin', 'admin_url', 'admin/dlssh/index', NULL, '代理商审核', 1, ''),
(169, 'Admin', 'admin_url', 'admin/dlstype/index', NULL, '代理商级别', 1, ''),
(170, 'Admin', 'admin_url', 'admin/dlsfr/index', NULL, '分佣明细', 1, ''),
(171, 'Admin', 'admin_url', 'admin/store/default', NULL, '联盟商家', 1, ''),
(172, 'Admin', 'admin_url', 'admin/store/index', NULL, '商家管理', 1, ''),
(173, 'Admin', 'admin_url', 'admin/storesh/index', NULL, '商家审核', 1, ''),
(174, 'Admin', 'admin_url', 'admin/storemx/index', NULL, '收入明细', 1, ''),
(175, 'Admin', 'admin_url', 'admin/cwgl/index', NULL, '财务统计', 1, ''),
(176, 'Admin', 'admin_url', 'admin/goods/default', NULL, '商品管理', 1, ''),
(177, 'Portal', 'admin_url', 'portal/goods/default', NULL, '商品管理', 1, ''),
(178, 'Admin', 'admin_url', 'admin/goodstype/default', NULL, '商品分类', 1, ''),
(179, 'Admin', 'admin_url', 'admin/goodspp/default', NULL, '品牌管理', 1, ''),
(180, 'Admin', 'admin_url', 'admin/order/default', NULL, '订单管理', 1, ''),
(181, 'Admin', 'admin_url', 'admin/orderdcl/default', NULL, '待处理订单', 1, ''),
(182, 'Admin', 'admin_url', 'admin/ordercg/default', NULL, '成功订单', 1, ''),
(183, 'Admin', 'admin_url', 'admin/ordersx/default', NULL, '失效订单', 1, ''),
(184, 'Admin', 'admin_url', 'admin/orderall/default', NULL, '所有订单', 1, ''),
(185, 'Admin', 'admin_url', 'admin/smms/default', NULL, '短信管理', 1, ''),
(186, 'Admin', 'admin_url', 'admin/weixin/default', NULL, '公众号管理', 1, ''),
(187, 'Admin', 'admin_url', 'admin/withdraw/default', NULL, '提现管理', 1, ''),
(188, 'Admin', 'admin_url', 'admin/weixinwb/index', NULL, '文本回复', 1, ''),
(189, 'Portal', 'admin_url', 'portal/prostatus/index', NULL, '商品列表', 1, ''),
(190, 'Portal', 'admin_url', 'portal/protype/index', NULL, '商品分类', 1, ''),
(191, 'Portal', 'admin_url', 'portal/brand/index', NULL, '品牌管理', 1, ''),
(192, 'Portal', 'admin_url', 'portal/orderdcl/index', NULL, '订单列表', 1, ''),
(193, 'Admin', 'admin_url', 'admin/storetype/index', NULL, '类别管理', 1, ''),
(194, 'Admin', 'admin_url', 'admin/admin/defult', NULL, '物流管理', 1, ''),
(195, 'Portal', 'admin_url', 'portal/express/index', NULL, '模板列表', 1, ''),
(196, 'Admin', 'admin_url', 'admin/smms/index', NULL, '短信管理', 1, ''),
(197, 'User', 'admin_url', 'user/usermx/index', NULL, '用户明细', 1, ''),
(198, 'Admin', 'admin_url', 'admin/rebate/index', NULL, '返佣管理', 1, ''),
(199, 'Admin', 'admin_url', 'admin/withdrawall/enable', NULL, '状态修改', 1, ''),
(200, 'Admin', 'admin_url', 'admin/withdrawall/dctx', NULL, '导出Excel', 1, ''),
(201, 'Admin', 'admin_url', 'admin/withdrawcg/dctx', NULL, '导出提现', 1, ''),
(202, 'Admin', 'admin_url', 'admin/withdrawdcl/enable', NULL, '状态修改', 1, ''),
(203, 'Admin', 'admin_url', 'admin/withdrawdcl/dctx', NULL, '导出提现', 1, ''),
(204, 'Admin', 'admin_url', 'admin/dls/edit', NULL, '查看详情', 1, ''),
(205, 'Admin', 'admin_url', 'admin/dls/edit_post', NULL, '编辑内容', 1, ''),
(206, 'Admin', 'admin_url', 'admin/dls/enable', NULL, '状态修改', 1, ''),
(207, 'Admin', 'admin_url', 'admin/dlstype/add', NULL, '添加级别', 1, ''),
(208, 'Admin', 'admin_url', 'admin/dlstype/edit', NULL, '查看内容', 1, ''),
(209, 'Admin', 'admin_url', 'admin/dlstype/edit_post', NULL, '编辑内容', 1, ''),
(210, 'Admin', 'admin_url', 'admin/store/edit', NULL, '查看详情', 1, ''),
(211, 'Admin', 'admin_url', 'admin/store/edit_post', NULL, '编辑内容', 1, ''),
(212, 'Admin', 'admin_url', 'admin/store/qiyong', NULL, '状态修改', 1, ''),
(213, 'Admin', 'admin_url', 'admin/store/fanxian', NULL, '返现控制', 1, ''),
(214, 'Admin', 'admin_url', 'admin/store/addscore', NULL, '积分操作', 1, ''),
(215, 'Admin', 'admin_url', 'admin/storesh/enable', NULL, '通过审核', 1, ''),
(216, 'Admin', 'admin_url', 'admin/storetype/add', NULL, '添加类别', 1, ''),
(217, 'Admin', 'admin_url', 'admin/storetype/edit', NULL, '查看内容', 1, ''),
(218, 'Admin', 'admin_url', 'admin/storetype/delete', NULL, '编辑内容', 1, ''),
(219, 'Portal', 'admin_url', 'portal/prostatus/edit_release', NULL, '查看内容', 1, ''),
(220, 'Portal', 'admin_url', 'portal/prostatus/edit_goods', NULL, '查看详细', 1, ''),
(221, 'Portal', 'admin_url', 'portal/prostatus/edit_goods_post', NULL, '编辑商品', 1, ''),
(222, 'Portal', 'admin_url', 'portal/prostatus/delete', NULL, '删除商品', 1, ''),
(223, 'Portal', 'admin_url', 'portal/prostatus/listorders', NULL, '排序', 1, ''),
(224, 'Portal', 'admin_url', 'portal/prostatus/check', NULL, '上架控制', 1, ''),
(225, 'Portal', 'admin_url', 'portal/prostatus/is_index', NULL, '推荐设置', 1, ''),
(226, 'Protal', 'admin_url', 'protal/protype/delete', NULL, '删除分类', 1, ''),
(227, 'Portal', 'admin_url', 'portal/protype/edit', NULL, '查看内容', 1, ''),
(228, 'Protal', 'admin_url', 'protal/protype/edit_post', NULL, '编辑内容', 1, ''),
(229, 'Portal', 'admin_url', 'portal/protype/check', NULL, '显示控制', 1, ''),
(230, 'Portal', 'admin_url', 'portal/protype/class_attr', NULL, '商品属性', 1, ''),
(231, 'Portal', 'admin_url', 'portal/protype/class_attr_delete', NULL, '删除属性', 1, ''),
(232, 'Protal', 'admin_url', 'protal/protype/class_attr_edit', NULL, '修改属性', 1, ''),
(233, 'Portal', 'admin_url', 'portal/protype/class_attr_check', NULL, '显示控制', 1, ''),
(234, 'Portal', 'admin_url', 'portal/protype/class_attr_search', NULL, '搜索管理', 1, ''),
(235, 'Portal', 'admin_url', 'portal/brand/add', NULL, '添加品牌', 1, ''),
(236, 'Portal', 'admin_url', 'portal/brand/edit', NULL, '修改品牌', 1, ''),
(237, 'Portal', 'admin_url', 'portal/brand/edit_post', NULL, '编辑内容', 1, ''),
(238, 'Portal', 'admin_url', 'portal/brand/delete', NULL, '删除品牌', 1, ''),
(239, 'Portal', 'admin_url', 'portal/brand/check', NULL, '显示控制', 1, ''),
(240, 'Portal', 'admin_url', 'portal/brand/is_index', NULL, '推荐管理', 1, ''),
(241, 'Protal', 'admin_url', 'protal/orderdcl/order_view', NULL, '订单详情', 1, ''),
(242, 'Admin', 'admin_url', 'admin/rebate/dorebate', NULL, '返现操作', 1, ''),
(243, 'Admin', 'admin_url', 'admin/rebate/setting', NULL, '保存设置', 1, ''),
(244, 'Portal', 'admin_url', 'portal/express/add', NULL, '增加/查看', 1, ''),
(245, 'Portal', 'admin_url', 'portal/express/edit', NULL, '修改模板', 1, ''),
(246, 'Portal', 'admin_url', 'portal/express/add_post', NULL, '编辑内容', 1, ''),
(247, 'Portal', 'admin_url', 'portal/express/check', NULL, '显示控制', 1, ''),
(248, 'Portal', 'admin_url', 'portal/express/delete', NULL, '删除模板', 1, ''),
(249, 'User', 'admin_url', 'user/usermx/dctx', NULL, '导出提现', 1, ''),
(250, 'Admin', 'admin_url', 'admin/cwgl/dcmx', NULL, '导出明细', 1, ''),
(251, 'Admin', 'admin_url', 'admin/cwgl/dctx', NULL, '导出明细', 1, ''),
(252, 'Admin', 'admin_url', 'admin/admin/index', NULL, 'test', 1, ''),
(253, 'Admin', 'admin_url', 'admin/withdrawall/index', NULL, '所有提现', 1, ''),
(254, 'Admin', 'admin_url', 'admin/withdrawcg/index', NULL, '成功提现', 1, ''),
(255, 'Admin', 'admin_url', 'admin/withdrawdcl/index', NULL, '待处理提现', 1, ''),
(256, 'Admin', 'admin_url', 'admin/curriculum/index', NULL, '课程管理', 1, ''),
(257, 'Admin', 'admin_url', 'admin/xxx/xxx', NULL, '课程管理', 1, ''),
(258, 'Admin', 'admin_url', 'admin/curriculum/add', NULL, '添加课程', 1, ''),
(259, 'Admin', 'admin_url', 'admin/interface/index', NULL, '线下订单列表', 1, ''),
(260, 'Admin', 'admin_url', 'admin/interface/add', NULL, '添加课程订单', 1, ''),
(261, 'Admin', 'admin_url', 'admin/interface/indexx', NULL, '线下订单列表', 1, ''),
(262, 'Admin', 'admin_url', 'admin/interface/xxxx', NULL, '线下订单补充接口', 1, ''),
(263, 'Admin', 'admin_url', 'admin/userrank/xxx', NULL, '用户关系', 1, ''),
(264, 'Admin', 'admin_url', 'admin/userrank/add', NULL, '关系调整', 1, ''),
(265, 'Admin', 'admin_url', 'admin/userrank/chage', NULL, '关系调整', 1, ''),
(266, 'Admin', 'admin_url', 'admin/userrank/index', NULL, '调整记录', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `sp_comments`
--

CREATE TABLE IF NOT EXISTS `sp_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_table` varchar(100) NOT NULL COMMENT '评论内容所在表，不带表前缀',
  `post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL COMMENT '原文地址',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '发表评论的用户id',
  `to_uid` int(11) NOT NULL DEFAULT '0' COMMENT '被评论的用户id',
  `full_name` varchar(50) DEFAULT NULL COMMENT '评论者昵称',
  `email` varchar(255) DEFAULT NULL COMMENT '评论者邮箱',
  `createtime` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  `content` text NOT NULL COMMENT '评论内容',
  `type` smallint(1) NOT NULL DEFAULT '1' COMMENT '评论类型；1实名评论',
  `parentid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论id',
  `path` varchar(500) DEFAULT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '状态，1已审核，0未审核',
  PRIMARY KEY (`id`),
  KEY `comment_post_ID` (`post_id`),
  KEY `comment_approved_date_gmt` (`status`),
  KEY `comment_parent` (`parentid`),
  KEY `table_id_status` (`post_table`,`post_id`,`status`),
  KEY `createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_common_action_log`
--

CREATE TABLE IF NOT EXISTS `sp_common_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) DEFAULT '0' COMMENT '用户id',
  `object` varchar(100) DEFAULT NULL COMMENT '访问对象的id,格式：不带前缀的表名+id;如posts1表示xx_posts表里id为1的记录',
  `action` varchar(50) DEFAULT NULL COMMENT '操作名称；格式规定为：应用名+控制器+操作名；也可自己定义格式只要不发生冲突且惟一；',
  `count` int(11) DEFAULT '0' COMMENT '访问次数',
  `last_time` int(11) DEFAULT '0' COMMENT '最后访问的时间戳',
  `ip` varchar(15) DEFAULT NULL COMMENT '访问者最后访问ip',
  PRIMARY KEY (`id`),
  KEY `user_object_action` (`user`,`object`,`action`),
  KEY `user_object_action_ip` (`user`,`object`,`action`,`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sp_common_action_log`
--

INSERT INTO `sp_common_action_log` (`id`, `user`, `object`, `action`, `count`, `last_time`, `ip`) VALUES
(1, 0, 'posts6', 'Portal-Article-index', 1, 1462601799, '119.146.220.9'),
(2, 0, 'posts9', 'Portal-Article-index', 1, 1463385505, '119.146.220.4'),
(3, 0, 'posts11', 'Portal-Article-index', 1, 1463582485, '220.166.254.211');

-- --------------------------------------------------------

--
-- 表的结构 `sp_curriculum`
--

CREATE TABLE IF NOT EXISTS `sp_curriculum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `curriculum_name` varchar(50) NOT NULL,
  `curriculum_pic` varchar(2000) NOT NULL,
  `curriculum_content` varchar(3000) NOT NULL,
  `one_level` decimal(10,2) DEFAULT NULL,
  `two_level` decimal(10,2) DEFAULT NULL,
  `three_level` decimal(10,2) DEFAULT NULL,
  `curriculum_money` decimal(10,2) NOT NULL,
  `sold_number` int(10) DEFAULT NULL,
  `curriculum_status` int(10) NOT NULL DEFAULT '1' COMMENT '0:下架，1：上架',
  `ks_list` varchar(2000) DEFAULT NULL COMMENT '课时列表',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `teacher_name` varchar(255) DEFAULT NULL COMMENT '老师姓名',
  `curriculum_number` int(10) DEFAULT NULL COMMENT '课程数',
  `student_number` int(10) DEFAULT NULL COMMENT '学生数',
  `teacher_pic` varchar(500) DEFAULT NULL COMMENT '老师照片',
  `teacher_content` varchar(1000) DEFAULT NULL COMMENT '老师简介',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `sp_curriculum`
--

INSERT INTO `sp_curriculum` (`id`, `curriculum_name`, `curriculum_pic`, `curriculum_content`, `one_level`, `two_level`, `three_level`, `curriculum_money`, `sold_number`, `curriculum_status`, `ks_list`, `listorder`, `teacher_name`, `curriculum_number`, `student_number`, `teacher_pic`, `teacher_content`) VALUES
(9, '玛雅易信会员', '["\\/data\\/upload\\/57c7f1d976102.png","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg"]', '&lt;p&gt;玛雅/易信会员8大权益&lt;/p&gt;&lt;p&gt;1、享价值3800元一天“信用产生资本”训练营学习；&lt;/p&gt;&lt;p&gt;2、送：刷卡神器，关键是加技术指导；&lt;/p&gt;&lt;p&gt;3、拥有易信金融APP的代理推广权。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;旗下所有商户按0.4%结算，分润万5—15元，关键是秒结算。&lt;/p&gt;&lt;p&gt;4、推荐会员享三级分销，一级470元，二级190元，三级280元。&lt;/p&gt;&lt;p&gt;只要坚持一推十，三级内轻松获利30万；&lt;/p&gt;&lt;p&gt;5、送微交易经纪人权限，分享玩家获交易量万一百二十九元奖励，而且是一天一算。&lt;/p&gt;&lt;p&gt;6、享金融医院投融资免费咨询服务；&lt;/p&gt;&lt;p&gt;7、所缴纳1566元费用，享每月1.5%返还，直至返完。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '470.00', '190.00', '280.00', '1566.00', 755, 1, '{"\\u4fe1\\u7528\\u548c\\u94b1\\u7684\\u5173\\u7cfb":"","\\u6210\\u4e3a\\u6709\\u94b1\\u4eba\\u7684\\u4e09\\u5927\\u6cd5\\u5219":"","\\u94f6\\u884c\\u8d5a\\u94b1\\u7684\\u79d8\\u5bc6":"","\\u4e16\\u754c\\u4e0a\\u4e2a\\u4eba\\u8d5a\\u94b1\\u7684 \\u56db\\u79cd\\u6a21\\u5f0f":"","\\u4e16\\u754c\\u4e0a\\u4f01\\u4e1a\\u8d5a\\u94b1\\u7684\\u56db\\u79cd\\u8ff7\\u5931":""}', 0, '蒋皓天', 20, 3000, '/data/upload/57c84a6730cdc.jpg', '玛雅信用体系创始人之一\r\n高级个人融资规划师\r\n融资实操专家\r\n百达汇资深讲师'),
(10, '内训实操班', '["\\/data\\/upload\\/57c7f2720eeb8.png","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg"]', '&lt;p&gt;报名条件：&lt;/p&gt;&lt;p&gt;1、玛雅/易信合作商内部工作人员； &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;/p&gt;&lt;p&gt;2、玛雅/易信合作商推荐人员；&lt;/p&gt;&lt;p&gt;3、认可玛雅/易信价值理念，愿为会员提供服务的会员；&lt;/p&gt;&lt;p&gt;4、有能力缴纳5800元学习费用的会员。&lt;/p&gt;&lt;p&gt;凡不属于上述前三项其中一项和第四项的会员，无权报名参加实操内训班的学习。&lt;/p&gt;&lt;p&gt;实操内训班实操内容：&lt;/p&gt;&lt;p&gt;1、打造融资规划师； &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;/p&gt;&lt;p&gt;2、通过手机获得最高50万的授信&lt;/p&gt;&lt;p&gt;3、打造自己融资资本，如何获得100万的储备银行；&lt;/p&gt;&lt;p&gt;4、.教你信用卡规划和使用，让额度快速提升2-10倍&lt;/p&gt;&lt;p&gt;5、研究银行习性，发现银行授信的密码，让银行主动为你授信。&lt;/p&gt;&lt;p&gt;6、如何做到买房买车不花钱还倒拿钱，轻松实现一年给自己配置两套房；&lt;/p&gt;&lt;p&gt;7、轻资产人群如何三到六个月打造20—50万的授信；&lt;/p&gt;&lt;p&gt;8、加入全国投融资平台&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '0.00', '0.00', '0.00', '5800.00', 327, 1, '[]', 0, '杨进老师', 20, 1500, '/data/upload/57c84aef3b89d.jpg', '玛雅信用体系创始人之一\r\n蓝塔节能科技公司副总裁\r\n广西玛诺生物有限公司市场总监\r\n高级融资规划师'),
(11, '私懂会--超级投资家', '["\\/data\\/upload\\/57c7f2aa3a1c2.png","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg"]', '&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;私懂会至易信投资俱乐部（&lt;/span&gt;15800&lt;span style=&quot;font-family:宋体&quot;&gt;元）&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;私懂会超级投资家两大权益：&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family:宋体;font-size:14px&quot;&gt;一、&lt;/span&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;学习&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-indent:28px&quot;&gt;&lt;span style=&quot;font-family:宋体;font-size:14px&quot;&gt;1、&lt;/span&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;设计互联网金融模式八大法则，让你的产品插上互联网和金融的翅膀。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-indent:28px&quot;&gt;&lt;span style=&quot;font-family:宋体;font-size:14px&quot;&gt;2、&lt;/span&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;掌握投资法门，实现财富快速增长。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-indent:28px&quot;&gt;&lt;span style=&quot;font-family:宋体;font-size:14px&quot;&gt;3、&lt;/span&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;人过三十，如果你没钱。不是你不努力，是你不懂动的做风控。风控四大标准，为你的财富建立防火墙。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-indent:28px&quot;&gt;&lt;span style=&quot;font-family:宋体;font-size:14px&quot;&gt;4、&lt;/span&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;专属投资顾问，为你量身定做投资方案。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family:宋体;font-size:14px&quot;&gt;二、&lt;/span&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;平台&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;1&lt;span style=&quot;font-family:宋体&quot;&gt;、全国投融资落地渠道和资源；&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;2&lt;span style=&quot;font-family:宋体&quot;&gt;、会员金融模式设计；&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;3&lt;span style=&quot;font-family:宋体&quot;&gt;、会员项目平台路演招商；&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:14px&quot;&gt;4&lt;span style=&quot;font-family:宋体&quot;&gt;、无风险套利项目抱团投资；&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '0.00', '0.00', '0.00', '15800.00', 85, 1, '[]', 0, '华力', 20, 500, '/data/upload/57c853ee66740.jpg', '《易信资本创始人》\r\n《广州华力网络科技有限公司总裁》\r\n《中国风控模型设计专家》\r\n《国际金融投资操盘手》'),
(12, '合作商之家', '["\\/data\\/upload\\/57c7f315d480e.png","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg"]', '', '0.00', '0.00', '0.00', '99.00', 77, 1, '[]', 0, '熊珂', 10, 100, '/data/upload/57c84cc63bdbb.jpg', '玛雅信用体系创始人\r\n西藏本草药业集团股份公司CEO\r\n中国大学生互助创业组委会委员\r\n中航铁训人力资源有限公司董事长\r\n逆向思维行销专家\r\n自动化营销体系建设专家'),
(13, '量化交易投资技巧', '["\\/data\\/upload\\/57c7f3450eff7.png","","","","",""]', '', '0.00', '0.00', '0.00', '0.00', 0, 1, '[]', 0, '', 0, 0, '', ''),
(7, '微交易投资技巧', '["\\/data\\/upload\\/57c7f110efc29.png","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg","\\/statics\\/simpleboot\\/image\\/135.jpg"]', '', '0.00', '0.00', '0.00', '0.00', 572, 1, '[]', 0, '', 0, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `sp_dl_integral`
--

CREATE TABLE IF NOT EXISTS `sp_dl_integral` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rebate_uid` int(11) NOT NULL COMMENT '返佣人id',
  `acquire_uid` int(11) NOT NULL COMMENT '获佣人id',
  `rank` int(10) NOT NULL COMMENT '对应级别',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `date` int(11) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_dl_level`
--

CREATE TABLE IF NOT EXISTS `sp_dl_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `fybl` decimal(10,2) DEFAULT NULL COMMENT '分佣比例',
  `fybl_sj` decimal(10,2) NOT NULL COMMENT '商家分佣比例',
  `qyfd` decimal(10,2) NOT NULL COMMENT '区域返点',
  `orderid` int(11) DEFAULT NULL COMMENT '排序',
  `lv_remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `sp_dl_level`
--

INSERT INTO `sp_dl_level` (`id`, `name`, `fybl`, `fybl_sj`, `qyfd`, `orderid`, `lv_remark`) VALUES
(2, '普通代理', '0.50', '0.80', '0.00', 1, '自己推荐的'),
(5, '省级代理', '0.60', '0.80', '0.60', 0, '四川省'),
(3, '区域代理', '0.50', '0.80', '0.80', 2, '区域内所有商家'),
(4, '市级代理', '0.60', '0.80', '0.60', 0, '市级所有佣金');

-- --------------------------------------------------------

--
-- 表的结构 `sp_express`
--

CREATE TABLE IF NOT EXISTS `sp_express` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `shipping` int(11) DEFAULT NULL COMMENT '是否包邮',
  `valuation_type` int(11) DEFAULT NULL COMMENT '计价方式',
  `transport_type` varchar(255) DEFAULT NULL COMMENT '运送方式',
  `calculation1` varchar(500) DEFAULT NULL COMMENT '计算方式快递',
  `calculation2` varchar(500) DEFAULT NULL COMMENT '计算方式EMS',
  `calculation3` varchar(500) DEFAULT NULL COMMENT '计算方式平邮',
  `isshow` int(11) DEFAULT NULL COMMENT '是否显示',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sp_express`
--

INSERT INTO `sp_express` (`id`, `name`, `shipping`, `valuation_type`, `transport_type`, `calculation1`, `calculation2`, `calculation3`, `isshow`) VALUES
(1, '韵达', 1, 2, '1,2,3', 'a:4:{s:1:"a";s:1:"5";s:1:"b";s:1:"5";s:1:"c";s:1:"5";s:1:"d";s:1:"5";}', 'a:4:{s:1:"a";s:1:"6";s:1:"b";s:1:"6";s:1:"c";s:1:"6";s:1:"d";s:1:"6";}', 'a:4:{s:1:"a";s:1:"7";s:1:"b";s:1:"7";s:1:"c";s:1:"7";s:1:"d";s:1:"7";}', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods`
--

CREATE TABLE IF NOT EXISTS `sp_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `brand_id` int(11) DEFAULT NULL COMMENT '所属品牌ID',
  `listorder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `class_id` int(11) DEFAULT NULL COMMENT '所属分类',
  `selling` varchar(255) DEFAULT NULL COMMENT '商品卖点',
  `price_yp` decimal(10,2) DEFAULT NULL COMMENT '市场价格（前台灰色显示）',
  `nums_year` int(11) DEFAULT NULL COMMENT '年产量',
  `nums_now` int(11) DEFAULT NULL COMMENT '现产量',
  `state` int(11) DEFAULT NULL COMMENT '上架状态',
  `refuse_no` varchar(255) DEFAULT NULL COMMENT '审核拒绝原因',
  `saleno` int(11) NOT NULL DEFAULT '0' COMMENT '商品销量',
  `saleno_dw` varchar(50) DEFAULT NULL COMMENT '商品销量单位',
  `readno` int(11) DEFAULT NULL COMMENT '商品人气',
  `is_index` int(11) DEFAULT NULL COMMENT '平台首页推荐',
  `store` int(11) DEFAULT NULL COMMENT '商品库存',
  `describe` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `pl_good` int(11) DEFAULT NULL COMMENT '好评数量',
  `pl_dif` int(11) DEFAULT NULL COMMENT '差评数量',
  `pl_mid` int(11) DEFAULT NULL COMMENT '中评数量',
  `fhsd` int(11) DEFAULT NULL COMMENT '发货速度',
  `bbms` int(11) DEFAULT NULL COMMENT '宝贝描述',
  `fwtd` int(11) DEFAULT NULL COMMENT '服务态度',
  `wlsd` int(11) DEFAULT NULL COMMENT '物流速度',
  `spec_color` varchar(255) DEFAULT NULL COMMENT '规格—颜色',
  `spec_size` varchar(255) DEFAULT NULL COMMENT '规格—尺码',
  `date` int(11) DEFAULT NULL COMMENT '申请时间',
  `goods_v` decimal(10,2) DEFAULT NULL COMMENT '商品体积',
  `goods_g` decimal(10,2) DEFAULT NULL COMMENT '商品重量',
  `express_id` int(11) DEFAULT NULL COMMENT '运费模板ID',
  `goods_bh` varchar(255) DEFAULT NULL COMMENT '商品编号',
  `sj_date` int(11) DEFAULT NULL COMMENT '上架时间',
  `is_status` int(11) DEFAULT NULL COMMENT '是否上架',
  `is_seindex` int(11) DEFAULT NULL COMMENT '店铺首页推荐',
  `pl_all` int(11) DEFAULT NULL COMMENT '总评论数',
  `is_tg` int(11) DEFAULT NULL COMMENT '搜索结果页推广',
  `has_pic` int(11) DEFAULT NULL COMMENT '有图评价',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `sp_goods`
--

INSERT INTO `sp_goods` (`id`, `name`, `brand_id`, `listorder`, `price`, `class_id`, `selling`, `price_yp`, `nums_year`, `nums_now`, `state`, `refuse_no`, `saleno`, `saleno_dw`, `readno`, `is_index`, `store`, `describe`, `pl_good`, `pl_dif`, `pl_mid`, `fhsd`, `bbms`, `fwtd`, `wlsd`, `spec_color`, `spec_size`, `date`, `goods_v`, `goods_g`, `express_id`, `goods_bh`, `sj_date`, `is_status`, `is_seindex`, `pl_all`, `is_tg`, `has_pic`) VALUES
(8, 'fdsgsdg', NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, '<p>dsagfdsghfdsgfdsgf</p><p><img alt="eg.jpg" src="http://localhost/xyh/easecredit/data/upload/ueditor/20160826/57bfa0609195a.jpg" title="eg.jpg"/></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1472176285, NULL, NULL, NULL, 'PT201608260001', NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods_attr`
--

CREATE TABLE IF NOT EXISTS `sp_goods_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `attr_id` int(11) DEFAULT NULL COMMENT '商品类型扩展ID',
  `val` varchar(255) DEFAULT NULL COMMENT '商品属性值',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods_brand`
--

CREATE TABLE IF NOT EXISTS `sp_goods_brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '品牌名称',
  `class_id` int(11) DEFAULT NULL COMMENT '品牌分类',
  `is_index` int(11) DEFAULT NULL COMMENT '首页推荐',
  `is_show` int(11) DEFAULT NULL COMMENT '是否显示',
  `logo` varchar(255) DEFAULT NULL COMMENT '品牌logo',
  `first` varchar(10) DEFAULT NULL COMMENT '品牌首字母',
  `intro` varchar(255) DEFAULT NULL COMMENT '品牌描述',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `sp_goods_brand`
--

INSERT INTO `sp_goods_brand` (`id`, `name`, `class_id`, `is_index`, `is_show`, `logo`, `first`, `intro`) VALUES
(1, '七匹狼', 7, 1, 1, '/data/upload/56fb46ebf0d19.jpg', 'Q', ''),
(2, '战地吉普', 7, 1, 1, '', 'Z', ''),
(3, '海澜之家', 7, 1, 1, '', 'H', ''),
(4, '杰克琼斯', 7, 1, 1, '', 'J', ''),
(5, '恒源祥', 7, 1, 1, '', 'H', ''),
(6, '马克华菲', 7, 1, 1, '', 'M', ''),
(7, '稻草人', 7, 1, 1, '', 'D', ''),
(8, '森马', 7, 1, 1, '', 'S', ''),
(9, '好多多', 1, 1, 1, '', 'H', '');

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods_class`
--

CREATE TABLE IF NOT EXISTS `sp_goods_class` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL COMMENT '父级类别ID类',
  `name` varchar(255) DEFAULT NULL COMMENT '类别名称',
  `first` varchar(10) DEFAULT NULL COMMENT '首字母',
  `listorder` int(11) DEFAULT NULL COMMENT '显示顺序',
  `is_index` int(11) DEFAULT NULL COMMENT '是否首页楼层显示',
  `img` varchar(255) DEFAULT NULL COMMENT '图标',
  `describe` varchar(255) DEFAULT NULL COMMENT '商品描述',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `sp_goods_class`
--

INSERT INTO `sp_goods_class` (`id`, `parent_id`, `name`, `first`, `listorder`, `is_index`, `img`, `describe`) VALUES
(1, 0, '美食餐饮', 'M', 0, 1, '/data/upload/570e1551cfe71.png', ''),
(2, 0, '服饰鞋类', 'F', 0, 1, '/data/upload/570e1599d4538.png', ''),
(3, 1, '二级类别1', 'E', 0, 1, '', ''),
(4, 1, '二级类别12', 'E', 1, 1, '', ''),
(5, 2, '二级类别21', 'E', 0, 1, '', ''),
(6, 2, '二级类别22', 'E', 0, 1, '', ''),
(8, 0, '数码电器', 'D', 0, 1, '/data/upload/570e15da81002.png', ''),
(10, 0, '旅游咨询', 'L', 0, 1, '/data/upload/570e161e6afff.png', ''),
(11, 0, '黄金珠宝', 'H', 0, 1, '/data/upload/570e16417c945.png', ''),
(12, 0, '婚庆摄影', 'H', 0, 1, '', ''),
(13, 0, '医疗保健', 'Y', 0, 1, '', ''),
(15, 0, '培训教育', 'P', 0, 1, '', ''),
(16, 0, '休闲娱乐', 'X', 0, 1, '', ''),
(17, 0, '酒店住宿', 'J', 0, 1, '', ''),
(18, 0, '运动健身', 'Y', 0, 1, '', ''),
(19, 0, '批发零售', 'P', 0, 1, '', ''),
(20, 0, '家居建材', 'J ', 0, 1, '', ''),
(21, 0, '汽车服务', 'Q', 0, 1, '', ''),
(22, 0, '美容美发', 'M', 0, 1, '', ''),
(23, 0, '广告策划', 'G', 0, 1, '', ''),
(24, 0, '生活服务', 'S', 0, 1, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods_class_attr`
--

CREATE TABLE IF NOT EXISTS `sp_goods_class_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL COMMENT '类别ID',
  `name` varchar(50) DEFAULT NULL COMMENT '属性名称',
  `is_search` int(11) DEFAULT NULL COMMENT '是否搜索',
  `is_show` int(11) DEFAULT NULL COMMENT '是否显示',
  `itype` int(11) DEFAULT NULL COMMENT '扩展类型',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sp_goods_class_attr`
--

INSERT INTO `sp_goods_class_attr` (`id`, `class_id`, `name`, `is_search`, `is_show`, `itype`) VALUES
(1, 1, '风格', 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods_class_value`
--

CREATE TABLE IF NOT EXISTS `sp_goods_class_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attr_id` int(11) DEFAULT NULL COMMENT '类别扩展ID',
  `name` varchar(255) DEFAULT NULL COMMENT '值名称',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sp_goods_class_value`
--

INSERT INTO `sp_goods_class_value` (`id`, `attr_id`, `name`) VALUES
(1, 1, '潮流'),
(2, 1, '\n仿古'),
(3, 1, '\n外国');

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods_pic`
--

CREATE TABLE IF NOT EXISTS `sp_goods_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `imgurl` varchar(1500) DEFAULT NULL COMMENT '（序列化）',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `sp_goods_pic`
--

INSERT INTO `sp_goods_pic` (`id`, `goods_id`, `imgurl`) VALUES
(21, 8, 'a:6:{i:0;s:45:"/xyh/easecredit/data/upload/57bfa04fd150c.png";i:1;s:45:"/xyh/easecredit/data/upload/57bfa0526e799.png";i:2;s:45:"/xyh/easecredit/data/upload/57bfa054cacb1.png";i:3;s:0:"";i:4;s:0:"";i:5;s:0:"";}');

-- --------------------------------------------------------

--
-- 表的结构 `sp_goods_spec`
--

CREATE TABLE IF NOT EXISTS `sp_goods_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `spec_color` varchar(255) DEFAULT NULL COMMENT '规格—颜色',
  `spec_size` varchar(255) DEFAULT NULL COMMENT '规格—尺码',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `stock` int(11) DEFAULT NULL COMMENT '库存',
  `itemno` varchar(255) DEFAULT NULL COMMENT '货号',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_guestbook`
--

CREATE TABLE IF NOT EXISTS `sp_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL COMMENT '留言者姓名',
  `email` varchar(100) NOT NULL COMMENT '留言者邮箱',
  `title` varchar(255) DEFAULT NULL COMMENT '留言标题',
  `msg` text NOT NULL COMMENT '留言内容',
  `createtime` datetime NOT NULL,
  `status` smallint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_interface_list`
--

CREATE TABLE IF NOT EXISTS `sp_interface_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL COMMENT '订单id',
  `uid` int(10) NOT NULL COMMENT '会员id',
  `curriculum_id` int(10) NOT NULL COMMENT '课程id',
  `interface_bz` varchar(500) DEFAULT NULL,
  `add_date` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sp_interface_list`
--

INSERT INTO `sp_interface_list` (`id`, `order_id`, `uid`, `curriculum_id`, `interface_bz`, `add_date`, `operation_id`) VALUES
(1, 71, 2, 9, 'tttt', 1473326981, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_links`
--

CREATE TABLE IF NOT EXISTS `sp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL COMMENT '友情链接地址',
  `link_name` varchar(255) NOT NULL COMMENT '友情链接名称',
  `link_image` varchar(255) DEFAULT NULL COMMENT '友情链接图标',
  `link_target` varchar(25) NOT NULL DEFAULT '_blank' COMMENT '友情链接打开方式',
  `link_description` text NOT NULL COMMENT '友情链接描述',
  `link_status` int(2) NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0' COMMENT '友情链接评级',
  `link_rel` varchar(255) DEFAULT '',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sp_links`
--

INSERT INTO `sp_links` (`link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_description`, `link_status`, `link_rating`, `link_rel`, `listorder`) VALUES
(1, 'http://www.thinkcmf.com', 'ThinkCMF', '', '_blank', '', 1, 0, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `sp_menu`
--

CREATE TABLE IF NOT EXISTS `sp_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `app` char(20) NOT NULL COMMENT '应用名称app',
  `model` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '操作名称',
  `data` char(50) NOT NULL COMMENT '额外参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`),
  KEY `model` (`model`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=258 ;

--
-- 转存表中的数据 `sp_menu`
--

INSERT INTO `sp_menu` (`id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder`) VALUES
(1, 0, 'Admin', 'Content', 'default', '', 0, 1, '内容管理', 'th', '', 30),
(2, 1, 'Api', 'Guestbookadmin', 'index', '', 1, 1, '所有留言', '', '', 0),
(3, 2, 'Api', 'Guestbookadmin', 'delete', '', 1, 0, '删除网站留言', '', '', 0),
(4, 1, 'Comment', 'Commentadmin', 'index', '', 1, 1, '评论管理', '', '', 0),
(5, 4, 'Comment', 'Commentadmin', 'delete', '', 1, 0, '删除评论', '', '', 0),
(6, 4, 'Comment', 'Commentadmin', 'check', '', 1, 0, '评论审核', '', '', 0),
(7, 1, 'Portal', 'AdminPost', 'index', '', 1, 1, '文章管理', '', '', 1),
(8, 7, 'Portal', 'AdminPost', 'listorders', '', 1, 0, '文章排序', '', '', 0),
(9, 7, 'Portal', 'AdminPost', 'top', '', 1, 0, '文章置顶', '', '', 0),
(10, 7, 'Portal', 'AdminPost', 'recommend', '', 1, 0, '文章推荐', '', '', 0),
(11, 7, 'Portal', 'AdminPost', 'move', '', 1, 0, '批量移动', '', '', 1000),
(12, 7, 'Portal', 'AdminPost', 'check', '', 1, 0, '文章审核', '', '', 1000),
(13, 7, 'Portal', 'AdminPost', 'delete', '', 1, 0, '删除文章', '', '', 1000),
(14, 7, 'Portal', 'AdminPost', 'edit', '', 1, 0, '编辑文章', '', '', 1000),
(15, 14, 'Portal', 'AdminPost', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(16, 7, 'Portal', 'AdminPost', 'add', '', 1, 0, '添加文章', '', '', 1000),
(17, 16, 'Portal', 'AdminPost', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(18, 1, 'Portal', 'AdminTerm', 'index', '', 0, 1, '分类管理', '', '', 2),
(19, 18, 'Portal', 'AdminTerm', 'listorders', '', 1, 0, '文章分类排序', '', '', 0),
(20, 18, 'Portal', 'AdminTerm', 'delete', '', 1, 0, '删除分类', '', '', 1000),
(21, 18, 'Portal', 'AdminTerm', 'edit', '', 1, 0, '编辑分类', '', '', 1000),
(22, 21, 'Portal', 'AdminTerm', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(23, 18, 'Portal', 'AdminTerm', 'add', '', 1, 0, '添加分类', '', '', 1000),
(24, 23, 'Portal', 'AdminTerm', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(25, 1, 'Portal', 'AdminPage', 'index', '', 1, 1, '页面管理', '', '', 3),
(26, 25, 'Portal', 'AdminPage', 'listorders', '', 1, 0, '页面排序', '', '', 0),
(27, 25, 'Portal', 'AdminPage', 'delete', '', 1, 0, '删除页面', '', '', 1000),
(28, 25, 'Portal', 'AdminPage', 'edit', '', 1, 0, '编辑页面', '', '', 1000),
(29, 28, 'Portal', 'AdminPage', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(30, 25, 'Portal', 'AdminPage', 'add', '', 1, 0, '添加页面', '', '', 1000),
(31, 30, 'Portal', 'AdminPage', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(32, 1, 'Admin', 'Recycle', 'default', '', 1, 1, '回收站', '', '', 4),
(33, 32, 'Portal', 'AdminPost', 'recyclebin', '', 1, 1, '文章回收', '', '', 0),
(34, 33, 'Portal', 'AdminPost', 'restore', '', 1, 0, '文章还原', '', '', 1000),
(35, 33, 'Portal', 'AdminPost', 'clean', '', 1, 0, '彻底删除', '', '', 1000),
(36, 32, 'Portal', 'AdminPage', 'recyclebin', '', 1, 1, '页面回收', '', '', 1),
(37, 36, 'Portal', 'AdminPage', 'clean', '', 1, 0, '彻底删除', '', '', 1000),
(38, 36, 'Portal', 'AdminPage', 'restore', '', 1, 0, '页面还原', '', '', 1000),
(39, 0, 'Admin', 'Extension', 'default', '', 0, 1, '扩展工具', 'cloud', '', 40),
(40, 39, 'Admin', 'Backup', 'default', '', 1, 1, '备份管理', '', '', 0),
(41, 40, 'Admin', 'Backup', 'restore', '', 1, 1, '数据还原', '', '', 0),
(42, 40, 'Admin', 'Backup', 'index', '', 1, 1, '数据备份', '', '', 0),
(43, 42, 'Admin', 'Backup', 'index_post', '', 1, 0, '提交数据备份', '', '', 0),
(44, 40, 'Admin', 'Backup', 'download', '', 1, 0, '下载备份', '', '', 1000),
(45, 40, 'Admin', 'Backup', 'del_backup', '', 1, 0, '删除备份', '', '', 1000),
(46, 40, 'Admin', 'Backup', 'import', '', 1, 0, '数据备份导入', '', '', 1000),
(47, 39, 'Admin', 'Plugin', 'index', '', 1, 1, '插件管理', '', '', 0),
(48, 47, 'Admin', 'Plugin', 'toggle', '', 1, 0, '插件启用切换', '', '', 0),
(49, 47, 'Admin', 'Plugin', 'setting', '', 1, 0, '插件设置', '', '', 0),
(50, 49, 'Admin', 'Plugin', 'setting_post', '', 1, 0, '插件设置提交', '', '', 0),
(51, 47, 'Admin', 'Plugin', 'install', '', 1, 0, '插件安装', '', '', 0),
(52, 47, 'Admin', 'Plugin', 'uninstall', '', 1, 0, '插件卸载', '', '', 0),
(53, 39, 'Admin', 'Slide', 'default', '', 1, 1, '幻灯片', '', '', 1),
(54, 53, 'Admin', 'Slide', 'index', '', 1, 1, '幻灯片管理', '', '', 0),
(55, 54, 'Admin', 'Slide', 'listorders', '', 1, 0, '幻灯片排序', '', '', 0),
(56, 54, 'Admin', 'Slide', 'toggle', '', 1, 0, '幻灯片显示切换', '', '', 0),
(57, 54, 'Admin', 'Slide', 'delete', '', 1, 0, '删除幻灯片', '', '', 1000),
(58, 54, 'Admin', 'Slide', 'edit', '', 1, 0, '编辑幻灯片', '', '', 1000),
(59, 58, 'Admin', 'Slide', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(60, 54, 'Admin', 'Slide', 'add', '', 1, 0, '添加幻灯片', '', '', 1000),
(61, 60, 'Admin', 'Slide', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(62, 53, 'Admin', 'Slidecat', 'index', '', 1, 1, '幻灯片分类', '', '', 0),
(63, 62, 'Admin', 'Slidecat', 'delete', '', 1, 0, '删除分类', '', '', 1000),
(64, 62, 'Admin', 'Slidecat', 'edit', '', 1, 0, '编辑分类', '', '', 1000),
(65, 64, 'Admin', 'Slidecat', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(66, 62, 'Admin', 'Slidecat', 'add', '', 1, 0, '添加分类', '', '', 1000),
(67, 66, 'Admin', 'Slidecat', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(68, 39, 'Admin', 'Ad', 'index', '', 1, 1, '网站广告', '', '', 2),
(69, 68, 'Admin', 'Ad', 'toggle', '', 1, 0, '广告显示切换', '', '', 0),
(70, 68, 'Admin', 'Ad', 'delete', '', 1, 0, '删除广告', '', '', 1000),
(71, 68, 'Admin', 'Ad', 'edit', '', 1, 0, '编辑广告', '', '', 1000),
(72, 71, 'Admin', 'Ad', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(73, 68, 'Admin', 'Ad', 'add', '', 1, 0, '添加广告', '', '', 1000),
(74, 73, 'Admin', 'Ad', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(75, 39, 'Admin', 'Link', 'index', '', 0, 1, '友情链接', '', '', 3),
(76, 75, 'Admin', 'Link', 'listorders', '', 1, 0, '友情链接排序', '', '', 0),
(77, 75, 'Admin', 'Link', 'toggle', '', 1, 0, '友链显示切换', '', '', 0),
(78, 75, 'Admin', 'Link', 'delete', '', 1, 0, '删除友情链接', '', '', 1000),
(79, 75, 'Admin', 'Link', 'edit', '', 1, 0, '编辑友情链接', '', '', 1000),
(80, 79, 'Admin', 'Link', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(81, 75, 'Admin', 'Link', 'add', '', 1, 0, '添加友情链接', '', '', 1000),
(82, 81, 'Admin', 'Link', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(83, 39, 'Api', 'Oauthadmin', 'setting', '', 1, 1, '第三方登陆', 'leaf', '', 4),
(84, 83, 'Api', 'Oauthadmin', 'setting_post', '', 1, 0, '提交设置', '', '', 0),
(85, 0, 'Admin', 'Menu', 'default', '', 1, 1, '菜单管理', 'list', '', 20),
(100, 85, 'Admin', 'Menu', 'index', '', 1, 1, '后台菜单', '', '', 0),
(101, 100, 'Admin', 'Menu', 'add', '', 1, 0, '添加菜单', '', '', 0),
(102, 101, 'Admin', 'Menu', 'add_post', '', 1, 0, '提交添加', '', '', 0),
(103, 100, 'Admin', 'Menu', 'listorders', '', 1, 0, '后台菜单排序', '', '', 0),
(104, 100, 'Admin', 'Menu', 'export_menu', '', 1, 0, '菜单备份', '', '', 1000),
(105, 100, 'Admin', 'Menu', 'edit', '', 1, 0, '编辑菜单', '', '', 1000),
(106, 105, 'Admin', 'Menu', 'edit_post', '', 1, 0, '提交编辑', '', '', 0),
(107, 100, 'Admin', 'Menu', 'delete', '', 1, 0, '删除菜单', '', '', 1000),
(108, 100, 'Admin', 'Menu', 'lists', '', 1, 0, '所有菜单', '', '', 1000),
(109, 0, 'Admin', 'Setting', 'default', '', 0, 1, '系统设置', 'cogs', '', 0),
(110, 109, 'Admin', 'Setting', 'userdefault', '', 0, 1, '个人信息', '', '', 0),
(111, 110, 'Admin', 'User', 'userinfo', '', 1, 1, '修改信息', '', '', 0),
(112, 111, 'Admin', 'User', 'userinfo_post', '', 1, 0, '修改信息提交', '', '', 0),
(113, 110, 'Admin', 'Setting', 'password', '', 1, 1, '修改密码', '', '', 0),
(114, 113, 'Admin', 'Setting', 'password_post', '', 1, 0, '提交修改', '', '', 0),
(115, 109, 'Admin', 'Setting', 'site', '', 1, 1, '网站信息', '', '', 0),
(116, 115, 'Admin', 'Setting', 'site_post', '', 1, 0, '提交修改', '', '', 0),
(117, 115, 'Admin', 'Route', 'index', '', 1, 0, '路由列表', '', '', 0),
(118, 115, 'Admin', 'Route', 'add', '', 1, 0, '路由添加', '', '', 0),
(119, 118, 'Admin', 'Route', 'add_post', '', 1, 0, '路由添加提交', '', '', 0),
(120, 115, 'Admin', 'Route', 'edit', '', 1, 0, '路由编辑', '', '', 0),
(121, 120, 'Admin', 'Route', 'edit_post', '', 1, 0, '路由编辑提交', '', '', 0),
(122, 115, 'Admin', 'Route', 'delete', '', 1, 0, '路由删除', '', '', 0),
(123, 115, 'Admin', 'Route', 'ban', '', 1, 0, '路由禁止', '', '', 0),
(124, 115, 'Admin', 'Route', 'open', '', 1, 0, '路由启用', '', '', 0),
(125, 115, 'Admin', 'Route', 'listorders', '', 1, 0, '路由排序', '', '', 0),
(126, 109, 'Admin', 'Mailer', 'default', '', 1, 1, '邮箱配置', '', '', 0),
(127, 126, 'Admin', 'Mailer', 'index', '', 1, 1, 'SMTP配置', '', '', 0),
(128, 127, 'Admin', 'Mailer', 'index_post', '', 1, 0, '提交配置', '', '', 0),
(129, 126, 'Admin', 'Mailer', 'active', '', 1, 1, '邮件模板', '', '', 0),
(130, 129, 'Admin', 'Mailer', 'active_post', '', 1, 0, '提交模板', '', '', 0),
(131, 109, 'Admin', 'Setting', 'clearcache', '', 1, 1, '清除缓存', '', '', 1),
(132, 0, 'User', 'Indexadmin', 'default', '', 1, 1, '用户管理', 'group', '', 10),
(133, 132, 'User', 'Indexadmin', 'default1', '', 1, 1, '用户组', '', '', 0),
(134, 133, 'User', 'Indexadmin', 'index', '', 1, 1, '本站用户', 'leaf', '', 0),
(135, 134, 'User', 'Indexadmin', 'ban', '', 1, 0, '拉黑会员', '', '', 0),
(136, 134, 'User', 'Indexadmin', 'cancelban', '', 1, 0, '启用会员', '', '', 0),
(162, 0, 'Admin', 'Withdraw', 'default', '', 1, 1, '提现管理', '', '', 0),
(163, 162, 'Admin', 'Withdrawdcl', 'index', '', 1, 1, '待处理提现', '', '', 2),
(139, 132, 'User', 'Indexadmin', 'default3', '', 1, 1, '管理组', '', '', 0),
(140, 139, 'Admin', 'Rbac', 'index', '', 1, 1, '角色管理', '', '', 0),
(141, 140, 'Admin', 'Rbac', 'member', '', 1, 0, '成员管理', '', '', 1000),
(142, 140, 'Admin', 'Rbac', 'authorize', '', 1, 0, '权限设置', '', '', 1000),
(143, 142, 'Admin', 'Rbac', 'authorize_post', '', 1, 0, '提交设置', '', '', 0),
(144, 140, 'Admin', 'Rbac', 'roleedit', '', 1, 0, '编辑角色', '', '', 1000),
(145, 144, 'Admin', 'Rbac', 'roleedit_post', '', 1, 0, '提交编辑', '', '', 0),
(146, 140, 'Admin', 'Rbac', 'roledelete', '', 1, 1, '删除角色', '', '', 1000),
(147, 140, 'Admin', 'Rbac', 'roleadd', '', 1, 1, '添加角色', '', '', 1000),
(148, 147, 'Admin', 'Rbac', 'roleadd_post', '', 1, 0, '提交添加', '', '', 0),
(149, 139, 'Admin', 'User', 'index', '', 1, 1, '管理员', '', '', 0),
(150, 149, 'Admin', 'User', 'delete', '', 1, 0, '删除管理员', '', '', 1000),
(151, 149, 'Admin', 'User', 'edit', '', 1, 0, '管理员编辑', '', '', 1000),
(152, 151, 'Admin', 'User', 'edit_post', '', 1, 0, '编辑提交', '', '', 0),
(153, 149, 'Admin', 'User', 'add', '', 1, 0, '管理员添加', '', '', 1000),
(154, 153, 'Admin', 'User', 'add_post', '', 1, 0, '添加提交', '', '', 0),
(155, 47, 'Admin', 'Plugin', 'update', '', 1, 0, '插件更新', '', '', 0),
(156, 39, 'Admin', 'Storage', 'index', '', 1, 1, '文件存储', '', '', 0),
(157, 156, 'Admin', 'Storage', 'setting_post', '', 1, 0, '文件存储设置提交', '', '', 0),
(158, 54, 'Admin', 'Slide', 'ban', '', 1, 0, '禁用幻灯片', '', '', 0),
(159, 54, 'Admin', 'Slide', 'cancelban', '', 1, 0, '启用幻灯片', '', '', 0),
(160, 149, 'Admin', 'User', 'ban', '', 1, 0, '禁用管理员', '', '', 0),
(161, 149, 'Admin', 'User', 'cancelban', '', 1, 0, '启用管理员', '', '', 0),
(164, 162, 'Admin', 'Withdrawcg', 'index', '', 1, 1, '成功提现', '', '', 1),
(165, 162, 'Admin', 'Withdrawall', 'index', '', 1, 1, '所有提现', '', '', 0),
(174, 171, 'Admin', 'Storemx', 'index', '', 1, 1, '收入明细', '', '', 3),
(254, 252, 'Admin', 'Interface', 'index', '', 1, 1, '线下订单列表', '', '', 0),
(180, 0, 'Admin', 'Order', 'default', '', 1, 1, '订单管理', '', '', 0),
(181, 180, 'Portal', 'Orderdcl', 'index', '', 1, 1, '订单列表', '', '', 0),
(255, 0, 'Admin', 'Userrank', 'xxx', '', 1, 1, '用户关系', '', '', 0),
(194, 133, 'User', 'Usermx', 'index', '', 1, 1, '用户明细', '', '', 0),
(195, 0, 'Admin', 'Rebate', 'Index', '', 1, 1, '返佣管理', '', '', 0),
(196, 165, 'Admin', 'Withdrawall', 'enable', '', 1, 0, '状态修改', '', '', 0),
(197, 165, 'Admin', 'Withdrawall', 'dctx', '', 1, 0, '导出Excel', '', '', 0),
(198, 164, 'Admin', 'Withdrawcg', 'dctx', '', 1, 0, '导出提现', '', '', 0),
(199, 163, 'Admin', 'Withdrawdcl', 'enable', '', 1, 0, '状态修改', '', '', 0),
(200, 163, 'Admin', 'Withdrawdcl', 'dctx', '', 1, 0, '导出提现', '', '', 0),
(228, 227, 'Portal', 'Protype', 'class_attr_delete', '', 1, 0, '删除属性', '', '', 0),
(229, 227, 'Protal', 'Protype', 'class_attr_edit', '', 1, 0, '修改属性', '', '', 0),
(230, 227, 'Portal', 'Protype', 'class_attr_check', '', 1, 0, '显示控制', '', '', 0),
(231, 227, 'Portal', 'Protype', 'class_attr_search', '', 1, 0, '搜索管理', '', '', 0),
(238, 181, 'Protal', 'Orderdcl', 'order_view', '', 1, 0, '订单详情', '', '', 0),
(239, 195, 'Admin', 'Rebate', 'dorebate', '', 1, 0, '返现操作', '', '', 0),
(240, 195, 'Admin', 'Rebate', 'setting', '', 1, 0, '保存设置', '', '', 0),
(251, 249, 'Admin', 'Curriculum', 'add', '', 1, 1, '添加课程', '', '', 1),
(250, 249, 'Admin', 'Curriculum', 'index', '', 1, 1, '课程列表', '', '', 0),
(249, 0, 'Admin', 'xxx', 'xxx', '', 1, 1, '课程管理', '', '', 0),
(246, 194, 'User', 'Usermx', 'dctx', '', 1, 0, '导出提现', '', '', 0),
(252, 0, 'Admin', 'Interface', 'xxxx', '', 1, 1, '线下订单补充接口', '', '', 0),
(253, 252, 'Admin', 'Interface', 'add', '', 1, 1, '添加课程订单', '', '', 0),
(256, 255, 'Admin', 'Userrank', 'chage', '', 1, 1, '关系调整', '', '', 0),
(257, 255, 'Admin', 'Userrank', 'index', '', 1, 1, '调整记录', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `sp_nav`
--

CREATE TABLE IF NOT EXISTS `sp_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `target` varchar(50) DEFAULT NULL,
  `href` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(6) DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sp_nav`
--

INSERT INTO `sp_nav` (`id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path`) VALUES
(1, 1, 0, '首页', '', 'home', '', 1, 0, '0-1'),
(2, 1, 0, '列表演示', '', 'a:2:{s:6:"action";s:17:"Portal/List/index";s:5:"param";a:1:{s:2:"id";s:1:"1";}}', '', 1, 0, '0-2'),
(3, 1, 0, '瀑布流', '', 'a:2:{s:6:"action";s:17:"Portal/List/index";s:5:"param";a:1:{s:2:"id";s:1:"2";}}', '', 1, 0, '0-3');

-- --------------------------------------------------------

--
-- 表的结构 `sp_nav_cat`
--

CREATE TABLE IF NOT EXISTS `sp_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `remark` text,
  PRIMARY KEY (`navcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sp_nav_cat`
--

INSERT INTO `sp_nav_cat` (`navcid`, `name`, `active`, `remark`) VALUES
(1, '主导航', 1, '主导航');

-- --------------------------------------------------------

--
-- 表的结构 `sp_oauth_user`
--

CREATE TABLE IF NOT EXISTS `sp_oauth_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_nicename` varchar(50) NOT NULL DEFAULT '' COMMENT '用户美名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `user_img` varchar(255) DEFAULT NULL COMMENT '用户头像，相对于upload/avatar目录',
  `sex` smallint(1) DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `create_time` int(11) NOT NULL COMMENT '注册时间',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `score` decimal(10,2) NOT NULL COMMENT '用户积分',
  `yfjf` decimal(10,2) NOT NULL COMMENT '以返积分',
  `wfjf` decimal(10,2) NOT NULL COMMENT '未返积分',
  `user_type` smallint(1) DEFAULT NULL COMMENT '用户类型，1:普通会员,2:商家会员,3:代理商',
  `tjrs` int(11) NOT NULL COMMENT '推荐人数',
  `fybl` decimal(10,2) NOT NULL COMMENT '返佣比例',
  `tjrr` varchar(20) NOT NULL COMMENT '所属推荐人',
  `mobile` varchar(20) NOT NULL COMMENT '手机',
  `khyh` varchar(50) NOT NULL COMMENT '开户银行',
  `khxm` varchar(20) NOT NULL COMMENT '开户姓名',
  `yhzh` varchar(20) NOT NULL COMMENT '银行账号',
  `zfmm` varchar(50) NOT NULL COMMENT '支付密码',
  `openid` varchar(50) DEFAULT NULL,
  `idcard` varchar(20) NOT NULL COMMENT '身份证',
  `khzh` varchar(50) DEFAULT NULL,
  `zs_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `sp_oauth_user`
--

INSERT INTO `sp_oauth_user` (`id`, `user_nicename`, `password`, `user_img`, `sex`, `create_time`, `user_status`, `score`, `yfjf`, `wfjf`, `user_type`, `tjrs`, `fybl`, `tjrr`, `mobile`, `khyh`, `khxm`, `yhzh`, `zfmm`, `openid`, `idcard`, `khzh`, `zs_name`) VALUES
(1, '', 'c535018ee946e10adc3949ba59abbe56e057f20f883e89af', NULL, 0, 1472442124, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '18328681194', '', '', '', '', 'otU18wPjrj7QzH-_9sRYzME2Z7a4', '', NULL, NULL),
(2, '测试账号', 'c535018ee946e10adc3949ba59abbe56e057f20f883e89af', '/xyh/easecredit/data/upload/57c94ac141cf7.png', 0, 1472442324, 1, '2.00', '0.00', '0.00', 1, 0, '0.00', '0', '18328681193', '建设银行', '1', '9885682015874532141', 'c535018ee946e10adc3949ba59abbe56e057f20f883e89af', '', '222543399862301015', 'asdfdsfds', 'xxx'),
(3, 'Markliy', 'c535018ee946e10adc3949ba59abbe56e057f20f883e89af', 'http://wx.qlogo.cn/mmopen/E8lrASRbUEGibwN02F81gfILqzzSDfOKhNex65JDSyqxqCuic8V6svAZ0thm5NSfvPZhwN7icr7tLr9Riczjn8DGn4wvOicrgSbqe/0', 0, 1472702293, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '13981930304', '', '', '', '', 'oh7Rlwr7HkdTI05R_VTwsOSK_sEU', '', NULL, NULL),
(4, '易信资本文案号', 'c535018ee946234ea25d9ab384e02f0a62df6da9df1689af', 'http://wx.qlogo.cn/mmopen/zmFzkXm19j6Z4QB4jZoQBhFvOVvgNoA0dxqWKD01GibYs4LVoFId9Sr6XfxHpLIuxt7MzoXqT5dfB09ia9CtuO80wLhsFh5tHX/0', 0, 1472714378, 1, '34.00', '0.00', '0.00', 1, 1, '0.00', '0', '13501531456', '华夏银行', '陈建辉', '6230200152245499', 'c535018ee946ccdea9eed5186245a4bae7dc219e585889af', 'oh7RlwmAp0vswaGS9E2c9-ah6AqQ', '410526198504024115', '华夏银行番禺支行', NULL),
(5, '誉', 'c535018ee946a4081556d88a58ab5b0b44e066358a7289af', NULL, 0, 1472729152, 1, '24.00', '0.00', '0.00', 1, 1, '0.00', '4', '13977156536', '工商银行', '黄桂余', '6222082102000762731', 'c535018ee946bdf9dcea3f4a193ea242e7c3e1b6200f89af', 'oh7Rlwpb9hhrg5ylnt8buOxy779s', '450105198204152020', '南宁茶花园支行', NULL),
(6, '', 'c535018ee9469e9041988f66f92760f286be3bca96df89af', NULL, 0, 1472731523, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '5', '17713539320', '', '', '', '', 'oh7RlwmzFZ4_ajQLNJNEJq9VSRkQ', '', NULL, NULL),
(7, '【 熊 珂】', 'c535018ee94678ca303af19fc3ae44bf4a9199308c6c89af', 'http://wx.qlogo.cn/mmopen/zmFzkXm19j6AQQ3cB6ZiaU9rG8QslCAibibRpibeKiay8gtkwvFNmv4xTpBgGBkiaI9OIcvVGIjZia1V5Zt3uicQaMbARZ6ykZ08JCGP/0', 0, 1472733215, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '17761250190', '', '', '', '', 'oh7RlwnvNkpQ84ovhyrkotR-jdNQ', '', NULL, NULL),
(8, '陈静', 'c535018ee946fa832722ba5c7647cd736157d377b72989af', 'http://wx.qlogo.cn/mmopen/cwBxtduY9AZsfEjy5tnKwovqBLicPdjO1e358zlY0f4DPY6Cd6fZPq2esuStmkias2AmbDVSVpRF9xzEWxeTb1zWibHf06Miav25/0', 0, 1472742830, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '13880089168', '', '', '', '', 'oh7Rlwn-yXUAhVzpLBltsyEpIo-w', '', NULL, NULL),
(9, '卢宁', 'c535018ee94632b4626112b2dbbd3c6425010004c93f89af', 'http://wx.qlogo.cn/mmopen/zmFzkXm19j7bmCheM58Fia4CaP4JVOicicvynEYicj0hVS974vBAtfibEvnlrNDmJIMKNat5ZDpKLoP6Z0hO76oRx5iaViamrBiaqHCH/0', 0, 1472743098, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '13668161318', '', '', '', '', 'oh7RlwhRSEqzTdl-9dNl6FneGr8Y', '', NULL, NULL),
(10, '百达汇--赵袁圆', 'c535018ee946838cf4e942726856d3d98a01baca6ed089af', 'http://wx.qlogo.cn/mmopen/E8lrASRbUEGqaEHPP1RDsCGLamnRdic0xghqPAMswDibtFVxZUCR7w03wTx4SZltia9EWB6kHsF9OxC0R2mWBMMN6xv1stOyLIJ/0', 0, 1472743116, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '15390052511', '', '', '', '', 'oh7RlwsC_CPGV6F4hRSdgTJdQnJg', '', NULL, NULL),
(11, '菜菜', 'c535018ee946a33456c6b9ad11ca4a007360576b4ef389af', 'http://wx.qlogo.cn/mmopen/zmFzkXm19j6o8C93mibZuQGYkcwqqNyhj96YZqfLyiajMLVIHnZSZ9BHCUDiakicrdJDA87YCCJxmJIRmWIcycCIhsVyjXWsop8S/0', 0, 1472743134, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '13551295113', '', '', '', '', 'oh7RlwgGwZ3s1ZCuNUP1DssI3TRY', '', NULL, NULL),
(12, '信用体系廖凌', 'c535018ee946d733a56fabd6408d3254b61fa81e9c2389af', 'http://wx.qlogo.cn/mmopen/E8lrASRbUEEAxIbSlicYMlibELTrwhSApicIKXpB7Mot58lKEGZwQlfHibXNfcIYevUWAN9c48Mwjk1vHKVwU50OzNBDMWNWMy1u/0', 0, 1472743166, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '13558802722', '', '', '', '', 'oh7RlwqJ81n0ZIXz-MnkSVIifHV4', '', NULL, NULL),
(13, 'Alva', 'c535018ee946e10adc3949ba59abbe56e057f20f883e89af', 'http://wx.qlogo.cn/mmopen/E8lrASRbUEGibwN02F81gfHYEoR7Dyib4rGGUdEp7icO5sbDpic5zH3kFeGcGT7ESMUqvpDawlgVJWJ0BKAdeKpTzByibPO12V7as/0', 0, 1472743487, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '13551129912', '', '', '', '', 'oh7RlwgRv1mD9X8uF4JAUYoNHC-M', '', NULL, NULL),
(14, '娇子', 'c535018ee946ef9e5ef3d19da1e0c15059a648a4459089af', 'http://wx.qlogo.cn/mmopen/zmFzkXm19j6kq6uGy8TnrTUswTSzQIOSsRFFmEeZuGQ2h6f86zpFlQEa2UGr5SHC8OL6fCfbZrWJGwpR6EIbEKyVt0xO6wca/0', 0, 1472744758, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '18583906010', '', '', '', '', 'oh7Rlwsbz0YBF6Dwq2mhzYgo_rVQ', '', NULL, NULL),
(15, '彭行', 'c535018ee94606dbacf00ee36c95de8a5be610d7becd89af', 'http://wx.qlogo.cn/mmopen/zmFzkXm19j5HmzGZ5BPgcicSEkUwAVYWKDfxSsNqlJz6jhLr8X5KZZm6HS0cBOQsiawOZONRybbSRZkxK3iaX7brICNcOCu1dZ3/0', 0, 1472745571, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '15736247324', '建设银行', '彭行', '6217003810051104977', 'c535018ee946cc3ba053473a0ea2e6e9b8a1a829647689af', 'oh7RlwsR7B7iKxG4OzaPfWacGSFU', '500381199403301216', '郫县红光支行', NULL),
(16, '唐英～千禧', 'c535018ee946e10adc3949ba59abbe56e057f20f883e89af', 'http://wx.qlogo.cn/mmopen/0Qcq6tCVqBFyZfaP9eheNe1XcoZQ9K3DkvqTPBBlsib0WRx2axoCX5OQOafCicOAzs515ibn8Xu7a5ewuK9C3KtSN52HdVaJDiar/0', 0, 1472745697, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '18000501238', '', '', '', '', 'oh7RlwiJPITmdYmmhY7OoQLqLqlk', '', NULL, NULL),
(17, '杨进', 'c535018ee9460c6c841a04a8de311a0bb708998f4aad89af', 'http://wx.qlogo.cn/mmopen/zmFzkXm19j7ibcKZbJk1oAk9SiaETCo0TSTQzqX20Lc667707dKLZcEo0p6GlOCDXAEegazbXulZ592IaNQPqPiaRrfg5VpAc8C/0', 0, 1472746053, 1, '0.00', '0.00', '0.00', 1, 0, '0.00', '0', '13086655800', '', '', '', '', 'oh7RlwifkHpks0g65z0RBMLJDaMc', '', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sp_options`
--

CREATE TABLE IF NOT EXISTS `sp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sp_options`
--

INSERT INTO `sp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'member_email_active', '{"title":"\\u90ae\\u4ef6\\u6fc0\\u6d3b\\u901a\\u77e5."}', 1),
(2, 'site_options', '{"site_name":"\\u739b\\u96c5\\u6613\\u4fe1\\u4f1a\\u5458\\u4e4b\\u5bb6","site_pcname":"","site_host":"http:\\/\\/yixin.woyii.com","site_txhy":"2","site_yhcard":"\\u5efa\\u8bbe\\u94f6\\u884c\\n\\u5de5\\u5546\\u94f6\\u884c\\n\\u519c\\u4e1a\\u94f6\\u884c\\n\\u62db\\u5546\\u94f6\\u884c\\n\\u4e2d\\u56fd\\u94f6\\u884c\\n\\u6210\\u90fd\\u94f6\\u884c\\n\\u90ae\\u653f\\u94f6\\u884c\\n\\u534e\\u590f\\u94f6\\u884c\\n\\u4ea4\\u901a\\u94f6\\u884c\\n\\u6c11\\u751f\\u94f6\\u884c\\n\\u5e73\\u5b89\\u94f6\\u884c\\n\\u5e7f\\u53d1\\u94f6\\u884c","site_tpl":"simplebootx_mobile","site_adminstyle":"flat","site_icp":"","site_admin_email":"","site_tongji":"\\u7a0b\\u5fd7\\u7684\\uff1a\\nAppSecret\\uff1a5565edd37736c8e3daa089ae9f1711ea\\nAppId\\uff1awxb0549ab6e493c07f","site_copyright":"","site_AppSecret":"6c63227dbed3f62cfe52846cf0817207","site_AppId":"wx9a68aff48ed92184","site_smsuserid":"1454","site_smsuser":"GGHW","site_smspass":"123456","site_seo_title":"\\u521b\\u5bcc\\u5b9d","site_seo_keywords":"","site_seo_description":"\\u739b\\u96c5\\u6613\\u4fe1\\u4f1a\\u5458\\u4e4b\\u5bb6","urlmode":"0","html_suffix":"","comment_time_interval":60}', 1),
(3, 'cmf_settings', '{"banned_usernames":""}', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_order`
--

CREATE TABLE IF NOT EXISTS `sp_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员ID',
  `orderno` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `order_state` int(11) DEFAULT NULL COMMENT '订单状态',
  `order_date` int(11) DEFAULT NULL COMMENT '提交时间',
  `pay_date` int(11) DEFAULT NULL COMMENT '支付时间',
  `curriculum_id` int(10) NOT NULL,
  `order_money` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- 转存表中的数据 `sp_order`
--

INSERT INTO `sp_order` (`id`, `uid`, `orderno`, `order_state`, `order_date`, `pay_date`, `curriculum_id`, `order_money`) VALUES
(1, 5, '16090114727325481681', 1, 1472732548, 1472732583, 10, '10.00'),
(2, 6, '16090114727325785220', 1, 1472732578, 1472732597, 10, '10.00'),
(3, 4, '16090114727340805594', 0, 1472734080, NULL, 13, '0.00'),
(4, 4, '16090114727426442061', 1, 1472742644, 1472742658, 9, '2.00'),
(5, 4, '16090114727426729039', 1, 1472742672, 1472742875, 10, '2.00'),
(6, 4, '16090114727427108763', 1, 1472742710, 1472742914, 11, '2.00'),
(7, 4, '16090114727427497876', 1, 1472742749, 1472742946, 12, '1.00'),
(8, 8, '16090114727428915751', 1, 1472742891, 1472742914, 10, '2.00'),
(9, 8, '16090114727429308544', 1, 1472742930, 1472742946, 11, '2.00'),
(10, 8, '16090114727429632913', 1, 1472742963, 1472742979, 12, '1.00'),
(11, 9, '16090114727431457329', 1, 1472743145, 1472743368, 9, '2.00'),
(12, 10, '16090114727431958408', 1, 1472743195, 1472743395, 9, '2.00'),
(13, 9, '16090114727431988396', 1, 1472743198, 1472743401, 10, '2.00'),
(14, 11, '16090114727432215875', 1, 1472743221, 1472743421, 9, '2.00'),
(15, 9, '16090114727432281303', 1, 1472743228, 1472743433, 11, '2.00'),
(16, 10, '16090114727432381070', 1, 1472743238, 1472743438, 10, '2.00'),
(17, 9, '16090114727432586788', 1, 1472743258, 1472743458, 12, '1.00'),
(18, 11, '16090114727432603329', 1, 1472743260, 1472743458, 10, '2.00'),
(19, 10, '16090114727432749218', 1, 1472743274, 1472743473, 11, '2.00'),
(20, 10, '16090114727433273187', 1, 1472743327, 1472743531, 12, '1.00'),
(21, 11, '16090114727433459261', 1, 1472743345, 1472743541, 12, '1.00'),
(22, 11, '16090114727433998182', 1, 1472743399, 1472743602, 11, '2.00'),
(23, 11, '16090114727434424761', 0, 1472743442, NULL, 7, '0.00'),
(24, 8, '16090114727434714326', 0, 1472743471, NULL, 7, '0.00'),
(25, 13, '16090114727436219674', 1, 1472743621, 1472743834, 9, '2.00'),
(26, 14, '16090114727449915549', 1, 1472744991, 1472745205, 9, '2.00'),
(27, 14, '16090114727450508677', 1, 1472745050, 1472745269, 10, '2.00'),
(28, 7, '16090114727450843013', 1, 1472745084, 1472745288, 9, '2.00'),
(29, 13, '16090114727451135523', 1, 1472745113, 1472745340, 10, '2.00'),
(30, 7, '16090114727451166335', 1, 1472745116, 1472745307, 10, '2.00'),
(31, 7, '16090114727451457144', 1, 1472745145, 1472745347, 11, '2.00'),
(32, 14, '16090114727451573357', 1, 1472745157, 1472745371, 11, '2.00'),
(33, 11, '16090114727451709827', 0, 1472745170, NULL, 13, '0.00'),
(34, 13, '16090114727451864254', 1, 1472745186, 1472745389, 11, '2.00'),
(35, 7, '16090114727451862289', 1, 1472745186, 1472745377, 12, '1.00'),
(36, 14, '16090114727452035155', 1, 1472745203, 1472745412, 12, '1.00'),
(37, 7, '16090114727452186331', 0, 1472745218, NULL, 13, '0.00'),
(38, 13, '16090114727452395771', 1, 1472745239, 1472745444, 12, '1.00'),
(39, 12, '16090114727453679901', 1, 1472745367, 1472745594, 9, '2.00'),
(40, 12, '16090114727454349721', 1, 1472745434, 1472745657, 10, '2.00'),
(41, 12, '16090114727454626621', 1, 1472745462, 1472745675, 11, '2.00'),
(42, 12, '16090114727454914992', 1, 1472745491, 1472745683, 12, '1.00'),
(43, 12, '16090114727455262051', 0, 1472745526, NULL, 7, '0.00'),
(44, 12, '16090114727455498808', 0, 1472745549, NULL, 13, '0.00'),
(45, 15, '16090214727456662385', 1, 1472745666, 1472745876, 9, '2.00'),
(46, 15, '16090214727457026538', 1, 1472745702, 1472745925, 10, '2.00'),
(47, 15, '16090214727457294581', 1, 1472745729, 1472745931, 11, '2.00'),
(48, 15, '16090214727457571975', 1, 1472745757, 1472745964, 12, '1.00'),
(49, 16, '16090214727457955181', 1, 1472745795, 1472745996, 10, '2.00'),
(50, 16, '16090214727458333925', 1, 1472745833, 1472746031, 11, '2.00'),
(51, 16, '16090214727459165056', 1, 1472745916, 1472746112, 12, '1.00'),
(52, 16, '16090214727459476748', 1, 1472745947, 1472746145, 9, '2.00'),
(53, 17, '16090214727461113775', 1, 1472746111, 1472746334, 9, '2.00'),
(54, 17, '16090214727461601685', 1, 1472746160, 1472746372, 10, '2.00'),
(55, 17, '16090214727462112054', 1, 1472746211, 1472746431, 11, '2.00'),
(56, 17, '16090214727462726251', 1, 1472746272, 1472746483, 12, '1.00'),
(57, 5, '16090214727465309906', 1, 1472746530, 1472746732, 12, '1.00'),
(58, 5, '16090214727465592534', 1, 1472746559, 1472746762, 11, '2.00'),
(59, 5, '16090214727465988772', 1, 1472746598, 1472746793, 9, '2.00'),
(60, 3, '16090214727786444421', 0, 1472778644, NULL, 9, '1566.00'),
(71, 2, NULL, 1, 1473326981, 1473326981, 9, '1566.00');

-- --------------------------------------------------------

--
-- 表的结构 `sp_order_goods`
--

CREATE TABLE IF NOT EXISTS `sp_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `orderno` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `goods_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `spec_color` varchar(255) DEFAULT NULL COMMENT '规格—颜色',
  `spec_size` varchar(255) DEFAULT NULL COMMENT '规格—尺码',
  `nums` int(11) DEFAULT NULL COMMENT '数量',
  `price` decimal(10,2) DEFAULT NULL COMMENT '单价',
  `imgs` varchar(255) DEFAULT NULL COMMENT '图片',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `sp_order_goods`
--

INSERT INTO `sp_order_goods` (`id`, `order_id`, `orderno`, `goods_id`, `goods_name`, `spec_color`, `spec_size`, `nums`, `price`, `imgs`) VALUES
(1, 1, NULL, 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '16GB', 1, '5000.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(2, 2, '20160415183849234', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(3, 3, '20160418101437106', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 2, '5688.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(4, 4, '20160502150218752', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 2, '5688.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(5, 5, '20160502154820687', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(6, 6, '20160502171206609', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '16GB', 1, '4888.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(7, 7, '20160502214044485', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '16GB', 1, '4888.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(8, 8, '20160419140451892', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '金色', '64GB', 1, '5588.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(9, 8, '20160419140451892', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '16GB', 3, '4888.00', '/o2o/data/upload/56fc8e24f08dd.png'),
(10, 9, '20160420171110358', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/data/upload/5710916510708.jpg'),
(11, 10, '20160420171538268', 6, '稻草人（MEXICAN）皮衣修身立领休闲外套2016新款皮夹克男 6602黑色-薄款(尺码偏小-建议选大一码) XL', '6602卡其-薄款(尺码偏小-建议选大一码)', 'XLL', 1, '178.00', '/data/upload/571093fd7a65c.jpg'),
(12, 11, '20160420171606672', 6, '稻草人（MEXICAN）皮衣修身立领休闲外套2016新款皮夹克男 6602黑色-薄款(尺码偏小-建议选大一码) XL', '6602卡其-薄款(尺码偏小-建议选大一码)', 'XLL', 1, '178.00', '/data/upload/571093fd7a65c.jpg'),
(13, 12, '20160420172501971', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/data/upload/5710916510708.jpg'),
(14, 13, '20160420172549674', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/data/upload/5710916510708.jpg'),
(15, 14, '20160420172604307', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/data/upload/5710916510708.jpg'),
(16, 15, '20160420172734312', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/data/upload/5710916510708.jpg'),
(17, 16, '20160420173340793', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/data/upload/5710916510708.jpg'),
(18, 17, '20160420175545784', 6, '稻草人（MEXICAN）皮衣修身立领休闲外套2016新款皮夹克男 6602黑色-薄款(尺码偏小-建议选大一码) XL', '6602卡其-薄款(尺码偏小-建议选大一码)', 'XLL', 1, '178.00', '/data/upload/571093fd7a65c.jpg'),
(19, 18, '20160421065427068', 6, '稻草人（MEXICAN）皮衣修身立领休闲外套2016新款皮夹克男 6602黑色-薄款(尺码偏小-建议选大一码) XL', '6602卡其-薄款(尺码偏小-建议选大一码)', 'XLL', 1, '178.00', '/data/upload/571093fd7a65c.jpg'),
(20, 19, '20160421111611631', 6, '稻草人（MEXICAN）皮衣修身立领休闲外套2016新款皮夹克男 6602黑色-薄款(尺码偏小-建议选大一码) XL', '6602卡其-薄款(尺码偏小-建议选大一码)', 'XL', 1, '178.00', '/data/upload/571093fd7a65c.jpg'),
(21, 20, '20160429094004397', 3, '中跟短靴粗跟后拉链裸靴尖头马丁靴', NULL, NULL, 2, '186.00', '/data/upload/571092153f93e.jpg'),
(22, 21, '20160512134511729', 3, '中跟短靴粗跟后拉链裸靴尖头马丁靴', NULL, NULL, 1, '186.00', '/data/upload/571092153f93e.jpg'),
(23, 22, '20160515135908465', 6, '稻草人（MEXICAN）皮衣修身立领休闲外套2016新款皮夹克男 6602黑色-薄款(尺码偏小-建议选大一码) XL', '6602卡其-薄款(尺码偏小-建议选大一码)', 'XL', 1, '178.00', '/data/upload/571093fd7a65c.jpg'),
(24, 23, '20160516120956986', 1, 'Apple iPhone 6s (A1700) 64G 玫瑰金色 移动联通电信4G手机', '玫瑰金', '64GB', 1, '5688.00', '/data/upload/5710916510708.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `sp_phone_message`
--

CREATE TABLE IF NOT EXISTS `sp_phone_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机',
  `message` varchar(1000) DEFAULT NULL COMMENT '内容',
  `date` int(11) DEFAULT NULL COMMENT '发送时间',
  `flag` varchar(255) DEFAULT NULL COMMENT '发送结果',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- 转存表中的数据 `sp_phone_message`
--

INSERT INTO `sp_phone_message` (`id`, `mobile`, `message`, `date`, `flag`) VALUES
(1, '13683499997', '792143 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1460988784, '714175463'),
(2, '18224412295', '236041 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1460989134, '714179243'),
(3, '18224412295', '359412 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1460990726, '714193983'),
(4, '18224412295', '670312 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1460990827, '714194973'),
(5, '18224412295', '289467 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1460990827, '714194983'),
(6, '18224412295', '082367 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1460990828, '714194993'),
(7, '18224412295', '428506 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461060695, '716063313'),
(8, '18224412295', '365491 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461145194, '717848953'),
(9, '13308189890', '581970 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461145265, '717853103'),
(10, '13308189890', '219703 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461145553, '717862183'),
(11, '13308189890', '863759 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461145680, '717865313'),
(12, '13308189890', '704532 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461146019, '717873233'),
(13, '18224412295', '580672 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461146091, '717874783'),
(14, '18224412295', '709423 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461146259, '717879633'),
(15, '18224412295', '458192 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461183841, '718231223'),
(16, '13683499997', '495236 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461185855, '718232513'),
(17, '13683499997', '682379 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461185989, '718232533'),
(18, '18224412295', '609754 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461187535, '718233283'),
(19, '13683499997', '827316 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461189494, '718234553'),
(20, '18224412295', '321756 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461189832, '718234743'),
(21, '13308189890', '465790 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461193253, '718238953'),
(22, '13350089002', '418270 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461200658, '718393553'),
(23, '18111625535', '012536 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461208258, '718873693'),
(24, '18111625535', '293587 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461209464, '718937093'),
(25, '13308189890', '528649 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461299155, '721055133'),
(26, '13350089002', '914308 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461398180, '723374703'),
(27, '18980007557', '891304 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461413605, '723717733'),
(28, '15008448347', '860391 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461565718, '726094573'),
(29, '15008448347', '152089 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461565914, '726099383'),
(30, '18224412295', '635071 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461566220, '726107223'),
(31, '18224412295', '378045 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461658938, '728355783'),
(32, '13683499997', '437618 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461758311, '730622133'),
(33, '13683499997', '301859 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461758464, '730626163'),
(34, '13683499997', '721859 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461758587, '730628443'),
(35, '13350089002', '647259 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461769348, '730768763'),
(36, '13350089002', '593026 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461775613, '730794683'),
(37, '18123304579', '382147 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461814371, '731425583'),
(38, '18180993333', '029175 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461858536, '732561573'),
(39, '15008448347', '890467 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461893676, '732817133'),
(40, '15008448347', '169524 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1461893759, '732819543'),
(41, '13350089002', '569287 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1462329716, '739878183'),
(42, '15828915521', '450863 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1464185538, '780636683'),
(43, '15828915521', '174523 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1464185581, '780637433'),
(44, '15882222827', '487190 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1464577301, '288478562'),
(45, '18328681193', '473896 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1472435437, '306404312'),
(46, '18328681193', '913278 当前验证码,为了您的账户安全切勿泄露！【创富宝】', 1472435439, '306404362'),
(47, '18328681193', '769581 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472435632, '306409492'),
(48, '18328681193', '518372 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472435746, '306411892'),
(49, '18328681193', '296487 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472435897, '306414752'),
(50, '18328681193', '960532 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472440962, '306506012'),
(51, '18328681193', '602541 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472442103, '306517682'),
(52, '18328681193', '156937 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472442303, '306519592'),
(53, '18328681193', '279861 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472457042, '306677302'),
(54, '13981930304', '567129 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472702258, '307921032'),
(55, '13501531456', '746251 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472714360, '308027072'),
(56, '13977156536', '039846 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472729129, '308147202'),
(57, '17713539320', '710563 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472731487, '933296623'),
(58, '17713539320', '293654 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472731488, '933296633'),
(59, '17761250190', '465127 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472733173, '933310373'),
(60, '17761250190', '260178 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472733175, '933310413'),
(61, '13880089168', '265971 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472742811, '308217352'),
(62, '13668161318', '248650 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472743078, '308218402'),
(63, '15390052511', '602971 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472743095, '933424203'),
(64, '13551295113', '827015 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472743115, '308218552'),
(65, '13558802722', '857902 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472743138, '308218622'),
(66, '18000501238', '591274 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472743328, '933425513'),
(67, '18000501238', '513690 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472743330, '933425523'),
(68, '13551129912', '580612 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472743464, '308219752'),
(69, '18583906010', '405237 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472744735, '933432743'),
(70, '15736247324', '027431 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472745453, '308225542'),
(71, '15736247324', '051247 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472745549, '308225852'),
(72, '18000501238', '416057 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472745657, '933436733'),
(73, '18000501238', '596170 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472745658, '933436763'),
(74, '13086655800', '160379 当前验证码,为了您的账户安全切勿泄露！【易信】', 1472746040, '933439213');

-- --------------------------------------------------------

--
-- 表的结构 `sp_plugins`
--

CREATE TABLE IF NOT EXISTS `sp_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) NOT NULL COMMENT '插件名，英文',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '插件名称',
  `description` text COMMENT '插件描述',
  `type` tinyint(2) DEFAULT '0' COMMENT '插件类型, 1:网站；8;微信',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态；1开启；',
  `config` text COMMENT '插件配置',
  `hooks` varchar(255) DEFAULT NULL COMMENT '实现的钩子;以“，”分隔',
  `has_admin` tinyint(2) DEFAULT '0' COMMENT '插件是否有后台管理界面',
  `author` varchar(50) DEFAULT '' COMMENT '插件作者',
  `version` varchar(20) DEFAULT '' COMMENT '插件版本号',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `listorder` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='插件表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_posts`
--

CREATE TABLE IF NOT EXISTS `sp_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned DEFAULT '0' COMMENT '发表者id',
  `post_keywords` varchar(150) NOT NULL COMMENT 'seo keywords',
  `post_source` varchar(150) DEFAULT NULL COMMENT '转载文章的来源',
  `post_date` datetime DEFAULT '2000-01-01 00:00:00' COMMENT 'post创建日期，永久不变，一般不显示给用户',
  `post_content` longtext COMMENT 'post内容',
  `post_title` text COMMENT 'post标题',
  `post_excerpt` text COMMENT 'post摘要',
  `post_status` int(2) DEFAULT '1' COMMENT 'post状态，1已审核，0未审核',
  `comment_status` int(2) DEFAULT '1' COMMENT '评论状态，1允许，0不允许',
  `post_modified` datetime DEFAULT '2000-01-01 00:00:00' COMMENT 'post更新时间，可在前台修改，显示给用户',
  `post_content_filtered` longtext,
  `post_parent` bigint(20) unsigned DEFAULT '0' COMMENT 'post的父级post id,表示post层级关系',
  `post_type` int(2) DEFAULT NULL,
  `post_mime_type` varchar(100) DEFAULT '',
  `comment_count` bigint(20) DEFAULT '0',
  `smeta` text COMMENT 'post的扩展字段，保存相关扩展属性，如缩略图；格式为json',
  `post_hits` int(11) DEFAULT '0' COMMENT 'post点击数，查看数',
  `post_like` int(11) DEFAULT '0' COMMENT 'post赞数',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶 1置顶； 0不置顶',
  `recommended` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐 1推荐 0不推荐',
  PRIMARY KEY (`id`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`id`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`),
  KEY `post_date` (`post_date`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sp_posts`
--

INSERT INTO `sp_posts` (`id`, `post_author`, `post_keywords`, `post_source`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended`) VALUES
(1, 1, '易信 会员', '自己写的', '2016-09-01 11:03:26', '<blockquote style="text-align: left;"><p style="text-align: center;"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px;">玛雅/易信会员8大权益</span></strong></p></blockquote><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 0, 0);">缴</span></strong></span></p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 0, 0);"><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);">-----------</span><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);"></span><span style="color: rgb(255, 255, 255); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);"></span><span style="color: rgb(238, 236, 225); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);"></span></span></strong></span></p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="color: rgb(238, 236, 225); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"></span><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);">1566/元</span><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"></span></span></strong></span></p><p><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 0, 0);"></span></strong></span>&nbsp;</p><ol class="custom_num1 list-paddingleft-1"><li class="list-num-2-1 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">1、享价值3800元一天“信用产生资本”训练营学习；<span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(215, 227, 188);"></span></span><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; background-color: rgb(215, 227, 188);"></span></span></p></li><li class="list-num-2-2 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">2、送：刷卡神器，关键是加技术指导；</span></p></li><li class="list-num-2-3 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">3、拥有易信金融APP的代理推广权。</span></p></li><li class="list-num-2-4 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">&nbsp; &nbsp; &nbsp;旗下所有商户按0.4%结算，分润万5—15元，关键是秒结算。</span></p></li><li class="list-num-2-5 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">4、推荐会员享三级分销，一级470元，二级190元，三级280元。</span></p></li><li class="list-num-2-6 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">&nbsp; &nbsp; &nbsp;只要坚持一推十，三级内轻松获利30万；</span></p></li><li class="list-num-2-7 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">5、送微交易经纪人权限，分享玩家获交易量万一百二十九元奖励，而且是一天一算。</span></p></li><li class="list-num-2-8 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">6、享金融医院投融资免费咨询服务；</span></p></li><li class="list-num-2-9 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">7、所缴纳1566元费用，享每月1.5%返还，直至返完。</span></p></li><li class="list-num-2-10 list-num1-paddingleft-1"><p style="text-align: left;"><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;;">8、更多权限敬请期待。</span></p></li></ol><p>&nbsp;</p>', '玛雅/易信会员', '易信玛雅会员待遇', 1, 1, '2016-09-01 11:02:23', NULL, 0, NULL, '', 0, '{"thumb":"57c7d817b7671.jpg"}', 0, 0, 0, 0),
(2, 1, '实操 内训', '原创', '2016-09-01 11:18:26', '<p style="text-align: center;"><strong><span style="font-family: 微软雅黑,Microsoft YaHei; font-size: 24px;">实 操 内 训 班</span></strong></p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 0, 0);">缴</span></strong></span></p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 0, 0);"><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);">-----------</span><span style="color: rgb(255, 255, 255); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);"></span><span style="color: rgb(238, 236, 225); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);"></span></span></strong></span></p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="color: rgb(238, 236, 225); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);">5880/元</span><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"></span></span></strong></span></p><p><span style="font-family: 宋体; font-size: 14px;"></span>&nbsp;</p><ol class="custom_num1 list-paddingleft-1"><li class="list-num-2-1 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">报名条件：</span></strong></p></li><li class="list-num-2-2 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">1、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">玛雅</span>/<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">易信合作商内部工作人员；</span></span></p></li><li class="list-num-2-3 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">2、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">玛雅</span>/<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">易信合作商推荐人员；</span></span></p></li><li class="list-num-2-4 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">3、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">认可玛雅</span>/<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">易信价值理念，愿为会员提供服务的会员；</span></span></p></li><li class="list-num-2-5 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">4、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">有能力缴纳</span>5800<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">元学习费用的会员。</span></span></p></li><li class="list-num-2-6 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">注： 凡不属于上述前三项其中一项和第四项的会员，无权报名参加实操内训班的学习。</span></p></li><li class="list-num-2-7 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;"></span></p></li><li class="list-num-2-8 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">实操内训班实操内容：</span></strong></p></li><li class="list-num-2-9 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">1、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">打造融资规划师；</span></span></p></li><li class="list-num-2-10 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">2、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">通过手机获得最高</span>50<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">万的授信</span></span></p></li><li class="list-num-2-11 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">3、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">打造自己融资资本，如何获得</span>100<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">万的储备银行；</span></span></p></li><li class="list-num-2-12 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">4、.<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">教你信用卡规划和使用，让额度快速提升</span><span style="color: rgb(89, 89, 89); font-family: Calibri; font-size: 16px;">2-10</span><span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">倍</span></span></p></li><li class="list-num-2-13 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">5、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">研究银行习性，发现银行授信的密码，让银行主动为你授信。</span></span></p></li><li class="list-num-2-14 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">6、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">如何做到买房买车不花钱还倒拿钱，轻松实现一年给自己配置两套房；</span></span></p></li><li class="list-num-2-15 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">7、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">轻资产人群如何三到六个月打造</span>20<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">—</span><span style="color: rgb(89, 89, 89); font-family: Calibri; font-size: 16px;">50</span><span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">万的授信；</span></span></p></li><li class="list-num-2-16 list-num1-paddingleft-1"><p><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 14px;">8、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">加入全国投融资平台</span></span></p></li></ol><p><span style="color: rgb(89, 89, 89);">&nbsp;</span></p>', '实操内训班', '内训班，实战检验', 1, 1, '2016-09-01 11:17:18', NULL, 0, NULL, '', 0, '{"thumb":"57c7d9371fda3.jpg"}', 0, 0, 0, 0),
(3, 1, '私 懂 会', '', '2016-09-01 11:19:21', '<p style="text-align: center;"><strong><span style="font-family: 微软雅黑,Microsoft YaHei; font-size: 24px;">私董会超级投资家两大权益</span></strong></p><p><strong><span style="font-family: 微软雅黑,Microsoft YaHei; font-size: 24px;"></span></strong>&nbsp;</p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 0, 0);">缴</span></strong></span></p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 0, 0);"><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);">-----------</span><span style="color: rgb(255, 255, 255); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);"></span><span style="color: rgb(238, 236, 225); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);"></span></span></strong></span></p><p style="text-align: center;"><span style="color: rgb(238, 236, 225); background-color: rgb(255, 0, 0);"><strong><span style="color: rgb(238, 236, 225); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"></span><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(255, 255, 255);">15800/元</span><span style="color: rgb(0, 0, 0); font-family: 微软雅黑, &quot;Microsoft YaHei&quot;; font-size: 24px; background-color: rgb(0, 0, 0);"></span></span></strong></span></p><p><strong><span style="font-family: 微软雅黑,Microsoft YaHei; font-size: 24px;"></span></strong>&nbsp;</p><p><span style="font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;"></span>&nbsp;</p><ol class="custom_num1 list-paddingleft-1"><li class="list-num-2-1 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">一、学习</span></strong></p></li><li class="list-num-2-2 list-num1-paddingleft-1"><p style="text-indent: 28px;"><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">1、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">设计互联网金融模式八大法则，让你的产品插上互联网和金融的翅膀。</span></span></strong></p></li><li class="list-num-2-3 list-num1-paddingleft-1"><p style="text-indent: 28px;"><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">2、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">掌握投资法门，实现财富快速增长。</span></span></strong></p></li><li class="list-num-2-4 list-num1-paddingleft-1"><p style="text-indent: 28px;"><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">3、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">人过三十，如果你没钱。不是你不努力，是你不懂动的做风控。风控四大标准，为你的财富建立防火墙。</span></span></strong></p></li><li class="list-num-2-5 list-num1-paddingleft-1"><p style="text-indent: 28px;"><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">4、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">专属投资顾问，为你量身定做投资方案。</span></span></strong></p></li><li class="list-num-2-6 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;"><span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 14px;">二、<span style="color: rgb(89, 89, 89); font-family: 宋体; font-size: 16px;">平台</span></span></span></strong></p></li><li class="list-num-2-7 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1、全国投融资落地渠道和资源；</span></strong></p></li><li class="list-num-2-8 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2、会员金融模式设计；</span></strong></p></li><li class="list-num-2-9 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3、会员项目平台路演招商；</span></strong></p></li><li class="list-num-2-10 list-num1-paddingleft-1"><p><strong><span style="color: rgb(89, 89, 89); font-family: 微软雅黑,Microsoft YaHei; font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4、无风险套利项目抱团投资；</span></strong></p></li></ol><p><br/></p>', '私懂会—超级投资家', '私 懂 会—超级投资家', 1, 1, '2016-09-01 11:18:29', NULL, 0, NULL, '', 0, '{"thumb":"57c7d98de656b.jpg"}', 0, 0, 0, 0),
(4, 1, '合作 商家 家庭', '', '2016-09-01 11:20:14', '<p>这就是合作商之家<br/></p>', '合作商之家', '合作商', 1, 1, '2016-09-01 11:19:24', NULL, 0, NULL, '', 0, '{"thumb":"57c7d9f60feea.jpg"}', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `sp_rebate`
--

CREATE TABLE IF NOT EXISTS `sp_rebate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fyje` decimal(10,2) NOT NULL COMMENT '返佣金额',
  `isrebate` int(11) NOT NULL COMMENT '是否自动返佣',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sp_rebate`
--

INSERT INTO `sp_rebate` (`id`, `fyje`, `isrebate`) VALUES
(1, '4500.00', 0);

-- --------------------------------------------------------

--
-- 表的结构 `sp_rebate_list`
--

CREATE TABLE IF NOT EXISTS `sp_rebate_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `buy_uid` int(10) NOT NULL,
  `get_uid` int(10) NOT NULL,
  `curriculum_id` int(10) NOT NULL,
  `rank` int(10) NOT NULL,
  `rebate_money` decimal(10,2) NOT NULL,
  `rebate_date` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `sp_rebate_list`
--

INSERT INTO `sp_rebate_list` (`id`, `buy_uid`, `get_uid`, `curriculum_id`, `rank`, `rebate_money`, `rebate_date`) VALUES
(1, 5, 4, 10, 1, '3.00', 1472731574),
(2, 6, 5, 10, 1, '3.00', 1472733697),
(3, 6, 4, 10, 2, '2.00', 1472737324),
(4, 5, 4, 12, 1, '0.00', 1472736531),
(5, 5, 4, 11, 1, '0.00', 1472734586),
(6, 5, 4, 9, 1, '0.00', 1472737561),
(7, 5, 4, 12, 1, '0.00', 1472738745),
(8, 5, 4, 11, 1, '0.00', 1472731122),
(9, 5, 4, 9, 1, '0.00', 1472736187);

-- --------------------------------------------------------

--
-- 表的结构 `sp_record_fx`
--

CREATE TABLE IF NOT EXISTS `sp_record_fx` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) DEFAULT NULL COMMENT '返现金额',
  `dfds` int(11) DEFAULT NULL COMMENT '待返点数',
  `syje` decimal(10,2) NOT NULL COMMENT '剩余金额',
  `fx_date` int(11) DEFAULT NULL COMMENT '返现日期',
  `date` int(11) DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `sp_record_fx`
--

INSERT INTO `sp_record_fx` (`id`, `price`, `dfds`, `syje`, `fx_date`, `date`) VALUES
(7, '10000.00', 267, '37.45', 1464624000, 1464663516),
(6, '2370.00', 237, '10.00', 1464451200, 1464662825);

-- --------------------------------------------------------

--
-- 表的结构 `sp_role`
--

CREATE TABLE IF NOT EXISTS `sp_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '角色名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父角色ID',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `sp_role`
--

INSERT INTO `sp_role` (`id`, `name`, `pid`, `status`, `remark`, `create_time`, `update_time`, `listorder`) VALUES
(1, '超级管理员', 0, 1, '拥有网站最高管理员权限！', 1329633709, 1329633709, 0);

-- --------------------------------------------------------

--
-- 表的结构 `sp_role_user`
--

CREATE TABLE IF NOT EXISTS `sp_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sp_route`
--

CREATE TABLE IF NOT EXISTS `sp_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `full_url` varchar(255) DEFAULT NULL COMMENT '完整url， 如：portal/list/index?id=1',
  `url` varchar(255) DEFAULT NULL COMMENT '实际显示的url',
  `listorder` int(5) DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1：启用 ;0：不启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_slide`
--

CREATE TABLE IF NOT EXISTS `sp_slide` (
  `slide_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slide_cid` bigint(20) NOT NULL,
  `slide_name` varchar(255) NOT NULL,
  `slide_pic` varchar(255) DEFAULT NULL,
  `slide_url` varchar(255) DEFAULT NULL,
  `slide_des` varchar(255) DEFAULT NULL,
  `slide_content` text,
  `slide_status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(10) DEFAULT '0',
  PRIMARY KEY (`slide_id`),
  KEY `slide_cid` (`slide_cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `sp_slide`
--

INSERT INTO `sp_slide` (`slide_id`, `slide_cid`, `slide_name`, `slide_pic`, `slide_url`, `slide_des`, `slide_content`, `slide_status`, `listorder`) VALUES
(9, 0, 'safdsgf', '/xyh/easecredit/data/upload/57c7d601e1a9e.png', '#', 'fgshgfdh', 'fshdfsgdf', 1, 0),
(10, 0, 'gjhgfj', '/xyh/easecredit/data/upload/57c7f6f6c30e5.png', '#', 'hfjhgf', 'jhgfhgfjg', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `sp_slide_cat`
--

CREATE TABLE IF NOT EXISTS `sp_slide_cat` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_idname` varchar(255) NOT NULL,
  `cat_remark` text,
  `cat_status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`),
  KEY `cat_idname` (`cat_idname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sp_slide_cat`
--

INSERT INTO `sp_slide_cat` (`cid`, `cat_name`, `cat_idname`, `cat_remark`, `cat_status`) VALUES
(1, '首页幻灯片', 'banner', '', 1),
(2, '店铺列表', 'sellerlist', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_store`
--

CREATE TABLE IF NOT EXISTS `sp_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员id',
  `name` varchar(255) DEFAULT NULL COMMENT '店铺名称',
  `cid` int(11) DEFAULT NULL COMMENT '商家类别',
  `score` decimal(10,2) DEFAULT '0.00' COMMENT '商家积分',
  `fybl` decimal(10,2) DEFAULT '100.00' COMMENT '返佣比例',
  `sheng` varchar(255) DEFAULT NULL COMMENT '省',
  `shi` varchar(255) DEFAULT NULL COMMENT '市',
  `qu` varchar(255) DEFAULT NULL COMMENT '区',
  `address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `remark` varchar(5000) DEFAULT NULL COMMENT '备注',
  `phone` varchar(255) DEFAULT NULL COMMENT '电话',
  `rjxf` varchar(255) DEFAULT NULL COMMENT '人均消费',
  `lng` varchar(255) DEFAULT NULL COMMENT '经度',
  `lat` varchar(255) DEFAULT NULL COMMENT '纬度',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  `about` varchar(1000) NOT NULL COMMENT '简介',
  `content` text NOT NULL COMMENT '内容',
  `banner` varchar(255) DEFAULT NULL COMMENT 'banner',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `isreturn` int(11) NOT NULL COMMENT '开通返现',
  `isenable` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `sp_store`
--

INSERT INTO `sp_store` (`id`, `uid`, `name`, `cid`, `score`, `fybl`, `sheng`, `shi`, `qu`, `address`, `remark`, `phone`, `rjxf`, `lng`, `lat`, `logo`, `about`, `content`, `banner`, `status`, `isreturn`, `isenable`) VALUES
(1, 8, '鹏程科技有限公司1', 0, '0.00', '100.00', '四川省', '成都市', '金牛区', '金牛万达3', '', '156924393112', '5004', '104.063461', '30.735467', '', '鹏程高科5', '', '/o2o/data/upload/5751497345c28.jpg,/o2o/data/upload/5751497f6d3c7.jpg', 1, 0, 0),
(2, 1, '阳阳宠物店', 3, '0.00', '100.00', '四川省', '成都市', '青羊区', '青羊大道58号', '', '13094475000', '40', '104.015955', '30.673669', '/data/upload/5747b738b1de9.jpg', '阳阳宠物店成立于2008年，6年来本店始终坚持“诚信经营，服务第一，顾客至上”的原则，为新老顾客推出宠物美容、宠物托管、宠物用品、宠物出售等服务。 同时我们的宠物用品超市丰富多样化，并由专业的销售顾问根据您的宝贝提出更适宜的购买建议，让你物有所值。', '', '/data/upload/573fcf8bd6322.jpg,/data/upload/573fd1e7ccceb.jpg,/data/upload/573fd1e857df0.jpg,/data/upload/573fd37799bfd.jpg', 1, 0, 0),
(3, 2, '创富宝.消费全额赠送大平台', 4, '28932.80', '100.00', '四川省', '成都市', '金牛区', '金牛万达甲级写字楼A座12/6号', '', '028-68897918', '', '104.080336', '30.695979', '/data/upload/573c256773b12.jpg', '创富宝致力于打造合情、合理、合法，真实贴近消费者的O2O电商服务平台，意在服务全国 各地的商圈，帮助传统企业轻松实现电商梦。是线下消费真实返现O2O全新商业模式开拓者。平 台以“让商家受益，让消费者获利”为核心，让消费者的刚需消费更实惠，吸引商户加入平台， 平台汇集了衣食住行、吃喝玩乐等无界行业的电商平台，借助互联网快速组成强大的消费联盟，帮 助合作伙伴在各地获得盈利成功。', '', '/data/upload/573c26c809fa7.JPG,/data/upload/573c26cbedf5f.JPG,/data/upload/573c26d00740b.JPG', 1, 1, 1),
(4, 9, '大同门老火锅', 2, '0.00', '100.00', '四川省', '成都市', '金牛区', '金牛区蜀兴西街17号', '', '18280028670', '60', '104.032091', '30.695673', '/data/upload/573c2bf29abb5.jpg', '大同门老火锅成立于2010年，是一家经营川味火锅的全新餐牌，我们没有强大的背景实力，也没有荣誉的奖牌。有的只是＂用心做火锅，只为您满意＂的经营理念，用心了解每一位顾客需求，并倾力让每一个顾客满意！', '', '/data/upload/573c2bfa6c588.jpg,/data/upload/573c2bfb0979d.jpg', 1, 0, 1),
(5, 9, '大同门老火锅', 2, '0.00', '100.00', '四川省', '成都市', '金牛区', '金牛区蜀兴西街18号', '', '18280028670', '80', '', '', '', '大同门老火锅成立于2010年，是一家经营川味火锅的全新餐牌，我们没有强大的背景实力，也没有荣誉的奖牌。有的只是＂用心做火锅，只为您满意＂的经营理念，用心了解每一位顾客需求，并倾力让每一个顾客满意！', '', '/data/upload/573c2b1f4e9f6.jpg,/data/upload/573c2b227ba18.jpg', 1, 0, 0),
(6, 47, '墙墙猫咖啡店', 2, '1640.00', '100.00', '四川省', '成都市', '成华区', ' 建设南街16好', '', '13308070900', '', '104.112988', '30.675202', '/data/upload/573c3326d0ac9.jpg', '墙墙猫咖啡店是一家以原味、温和、自主、健康休闲饮品为主打的外带式茶饮连锁，总部设在新加坡。墙墙猫咖啡店是由一群热爱自然，崇尚健康生活，拥有多年丰富的商业品牌运作经验和食品进出口贸易资历的朋友走到一起而成长的。墙墙猫咖啡店充分从消费者的角度出发，不仅仅从视觉形象，更从丰富的产品线，口感方面都做了很大的调整。', '<p>内容内容内容内容内容</p>', '/data/upload/573c33335d2ae.jpg,/data/upload/573c33345790e.jpg', 1, 0, 1),
(7, 32, '', 0, '0.00', '100.00', '请选择省份', '请选择市', '请选择区|县', '', '', '', '', '', '', '', '', '', NULL, 1, 0, 0),
(8, 11, '甜甜圈蛋糕店', 2, '8056.00', '100.00', '四川省', '成都市', '武侯区', '郭家桥北街5号附39号', '', '', '50', '104.08775', '30.629874', '/data/upload/573c3be7e17e8.jpg', '甜甜圈蛋糕店是一家专门从事烘焙食品经营的连锁企业，产品定位于城市居民中的中高端消费人群，以全新的经营模式和服务为现代都市生活带来高雅品位和时尚体验。甜甜圈蛋糕店选用国内外优质食材和配方，在各个门店内用最先进的系列设备加工制作，以最新鲜、最健康、最美味的烘焙食品满足消费者的需求。甜甜圈蛋糕店包括面包系列、生日蛋糕系列、西式甜点系列、饼干系列、月饼系列和饮品系列等。立志于通过诚实经营、品质为先的经营理念，打造出一个国内一流的食品品牌和遍布全国的连锁经营网络，为广大消费者创造甜蜜和快乐，为企业员工带来安居和乐业，做一个基业长青的百年企业。', '', '/data/upload/573c3c168330e.jpg,/data/upload/573c3c1740cb4.jpeg', 1, 0, 1),
(12, 51, '外婆心中式快餐', 2, '0.00', '100.00', '四川省', '成都市', '金牛区', '肖三南巷38号', '', '028-83210308', '50', '104.080972', '30.694492', '/data/upload/573fce681b812.png', '外婆心首家餐厅于2002年在重庆南坪开设，采用台湾吧台式四餐经营模式，独创特色砂锅、席家木盆菜系列，集美味与营养、特色与时尚于一体，成为特色中式快餐的佼佼者。外婆心以砂锅、席家木盆菜系列为主特色融合现代快餐理念，开创了更符合国人膳食结构与饮食习惯的快餐连锁体系。', '', '/data/upload/573fc5a283a53.jpg,/data/upload/573fc5a353510.jpg,/data/upload/573fc5a3bb921.jpg', 1, 0, 1),
(9, 36, '', 0, '0.00', '100.00', '请选择省份', '请选择市', '请选择区|县', '', '', '', '', '', '', '', '', '', NULL, 1, 0, 1),
(10, 30, '', 0, '0.00', '100.00', '请选择省份', '请选择市', '请选择区|县', '', '', '', '', '', '', '', '', '', NULL, 1, 0, 1),
(11, 70, '大鸿门老火锅', 2, '0.00', '100.00', '四川省', '成都市', '金牛区', '金牛区蜀兴西街266号', '', '18508208510', '50', '104.031717', '30.696053', '/data/upload/57400374a42a6.jpg', '大鸿门老火锅是川渝地区汉族传统美食之一，以麻辣为主，咸鲜、酸辣味兼有，分清汤火锅、红汤火锅和鸳鸯火锅。它以调汤考究见长，具有原料多样，荤素皆可，适应广泛，风格独特，场面热烈等特色，因而最热辣山城。', '<p><img src="http://cfb.woyii.com/data/upload/ueditor/20160521/5740088d8e1aa.jpg" title="1.jpg" alt="1.jpg"/></p><p><br/></p><p>内容11&lt;br/&gt;</p>', '/data/upload/574005d4aaf27.jpg,/data/upload/574005d540057.jpg,/data/upload/574005d5bd844.jpg', 1, 0, 1),
(13, 68, '111', 0, '0.00', '100.00', '天津市', '天津市', '请选择区|县', '12', '', '2233', '11', '', '', '/data/upload/573d2f265405f.jpg', '1', '', '', 1, 0, 1),
(14, 84, '', 0, '0.00', '100.00', '请选择省份', '请选择市', '请选择区|县', '', '', '', '', '', '', '', '', '', NULL, 1, 0, 1),
(15, 99, '', 2, '0.00', '100.00', '四川省', '成都市', '成华区', '', '', '', '', '', '', '', '', '', NULL, 1, 0, 1),
(16, 108, '快乐发语', 5, '0.00', '100.00', '四川省', '成都市', '成华区', '建设南街15号', '', '13882033321', '40', '104.112988', '30.675202', '/data/upload/57459f4c9e751.jpg', '', '<p><img src="http://cfb.woyii.com/data/upload/ueditor/20160525/57459f8a3f9d5.jpg" title="mmexport1464180088784.jpg" alt="mmexport1464180088784.jpg"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160525/57459f953fc4a.jpg" style="" title="mmexport1464180096179.jpg"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160525/57459f954daf5.jpg" style="" title="mmexport1464180112662.jpg"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160525/57459f95870fb.jpg" style="" title="mmexport1464180106169.jpg"/></p><p><br/></p>', NULL, 1, 0, 1),
(17, 107, '川灵宏升海外特产店', 2, '0.00', '20.00', '四川省', '成都市', '武侯区', '科华北路69号世外桃源三楼', '', '15881484491', '9.9元-19.9元', '104.083808', '30.635287', '/data/upload/5747b72838be0.jpg', '经营优质国际商品，提供越南，泰国，加拿大，法国，韩国港澳台等地特色商品礼品。可提供进出口相关单据，真正直接进口！越南咖啡19.9等特价欢迎大家订购！', '<p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bb8de0f83.png" style="" title="1.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bb942e0d7.png" style="" title="2.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bb9ba06a2.png" style="" title="3.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bba76f366.png" style="" title="5.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bba9d483e.png" style="" title="4.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbb4a7cab.png" style="" title="7.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbb58ef34.png" style="" title="9.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbb763848.png" style="" title="6.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbbaf39c1.png" style="" title="8.png"/></p><p><br/></p>', '/data/upload/5747ba6b8adac.jpg', 1, 0, 0),
(18, 118, '成都川灵宏升贸易有限公司', 2, '0.00', '20.00', '四川省', '成都市', '武侯区', '科华北路69号世外桃源三楼', '', '15881484491', '9.9元-19.9元', '104.083808', '30.635287', '/data/upload/5747c3cf2fc3c.gif', '经营优质国际商品，提供越南，泰国，加拿大，法国，韩国港澳台等地特色商品礼品。可提供进出口相关单据，真正直接进口！越南咖啡19.9等特价欢迎大家订购！', '<p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bb8de0f83.png" style="" title="1.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bb942e0d7.png" style="" title="2.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bb9ba06a2.png" style="" title="3.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bba76f366.png" style="" title="5.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bba9d483e.png" style="" title="4.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbb4a7cab.png" style="" title="7.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbb58ef34.png" style="" title="9.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbb763848.png" style="" title="6.png"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747bbbaf39c1.png" style="" title="8.png"/></p><p><br/></p>', '/data/upload/5747ba6b8adac.jpg', 1, 0, 1),
(19, 61, '易飞易国际旅行社', 6, '0.00', '10.00', '四川省', '成都市', '武侯区', '高升桥一环路南四段14号奇伍大厦', '', '13540718362 ', '', '104.055256', '30.642625', '/data/upload/5747f942db1b4.jpg', '易飞易旅行-------让旅行更美好！ 易飞易国旅系2012年度四川省旅游局授予的“旅游标准化试点单位之一” 是具有出境旅游资质的国际旅游公司之一，公司经过多年的沉淀，整合行业优势资源，致力于发展成为西南地区有影响力的旅游渠道运营商。', '<p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747f8b8b979a.jpg" style="" title="2.jpg"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747f8b94c668.jpg" style="" title="3.jpg"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/5747f8ba120fb.jpg" style="" title="1.jpg"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/57480ffd21ac0.jpg" style="" title="5.jpg"/></p><p><img src="http://cfb.woyii.com/data/upload/ueditor/20160527/57480ffec6c86.jpg" style="" title="4.jpg"/></p><p><br/></p>', NULL, 1, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_store_class`
--

CREATE TABLE IF NOT EXISTS `sp_store_class` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `orderid` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `sp_store_class`
--

INSERT INTO `sp_store_class` (`id`, `name`, `orderid`) VALUES
(1, '服饰鞋包', 5),
(2, '餐饮美食', 1),
(3, '酒店住宿', 4),
(4, '广告商务', 7),
(5, '美容美发', 3),
(6, '休闲娱乐', 2),
(7, '数码电器', 6);

-- --------------------------------------------------------

--
-- 表的结构 `sp_store_xn`
--

CREATE TABLE IF NOT EXISTS `sp_store_xn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `name` varchar(255) DEFAULT NULL COMMENT '店铺名称',
  `sheng` varchar(255) DEFAULT NULL COMMENT '省',
  `shi` varchar(255) DEFAULT NULL COMMENT '市',
  `qu` varchar(255) DEFAULT NULL COMMENT '区',
  `address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `phone` varchar(255) DEFAULT NULL COMMENT '电话',
  `rjxf` varchar(255) DEFAULT NULL COMMENT '人均消费',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  `about` varchar(1000) DEFAULT NULL COMMENT '简介',
  `op` varchar(20) DEFAULT NULL COMMENT '操作',
  `date` int(11) NOT NULL COMMENT '申请时间',
  `status` int(11) DEFAULT NULL COMMENT '状态',
  `lng` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sp_store_xn`
--

INSERT INTO `sp_store_xn` (`id`, `uid`, `name`, `sheng`, `shi`, `qu`, `address`, `phone`, `rjxf`, `logo`, `about`, `op`, `date`, `status`, `lng`, `lat`, `banner`) VALUES
(1, 8, '鹏程科技有限公司111', '四川省', '成都市', '金牛区', '金牛万达33', '1569243931122', '50044', '', '鹏程高科55', 'add', 1464581523, 0, '104.081822', '30.72932', '/o2o/data/upload/57514a569edf4.jpg,/o2o/data/upload/57514a5b63db5.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `sp_terms`
--

CREATE TABLE IF NOT EXISTS `sp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(200) DEFAULT NULL COMMENT '分类名称',
  `slug` varchar(200) DEFAULT '',
  `taxonomy` varchar(32) DEFAULT NULL COMMENT '分类类型',
  `description` longtext COMMENT '分类描述',
  `parent` bigint(20) unsigned DEFAULT '0' COMMENT '分类父id',
  `count` bigint(20) DEFAULT '0' COMMENT '分类文章数',
  `path` varchar(500) DEFAULT NULL COMMENT '分类层级关系路径',
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_keywords` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `list_tpl` varchar(50) DEFAULT NULL COMMENT '分类列表模板',
  `one_tpl` varchar(50) DEFAULT NULL COMMENT '分类文章页模板',
  `listorder` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `sp_terms`
--

INSERT INTO `sp_terms` (`term_id`, `name`, `slug`, `taxonomy`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `listorder`, `status`) VALUES
(5, '首页文章', '', 'article', '首页文章列表', 0, 0, '0-5', '', '', '', 'list', 'article', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_term_relationships`
--

CREATE TABLE IF NOT EXISTS `sp_term_relationships` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'posts表里文章id',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`tid`),
  KEY `term_taxonomy_id` (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `sp_term_relationships`
--

INSERT INTO `sp_term_relationships` (`tid`, `object_id`, `term_id`, `listorder`, `status`) VALUES
(1, 6, 3, 1, 0),
(2, 7, 3, 0, 0),
(3, 9, 3, 0, 0),
(4, 10, 3, 0, 0),
(5, 11, 3, 2, 0),
(6, 12, 3, 3, 0),
(7, 13, 3, 4, 0),
(8, 14, 5, 0, 1),
(9, 1, 5, 0, 1),
(10, 2, 5, 0, 1),
(11, 3, 5, 0, 1),
(12, 4, 5, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_userrank_chage`
--

CREATE TABLE IF NOT EXISTS `sp_userrank_chage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `active_uid` int(10) NOT NULL COMMENT '变更用户',
  `up_uid` int(10) NOT NULL COMMENT '变更上级id',
  `chage_date` int(11) NOT NULL COMMENT '变更时间',
  `chage_bz` varchar(500) DEFAULT NULL COMMENT '备注',
  `operation_id` int(10) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sp_userrank_chage`
--

INSERT INTO `sp_userrank_chage` (`id`, `active_uid`, `up_uid`, `chage_date`, `chage_bz`, `operation_id`) VALUES
(1, 2, 1, 1473412790, 'tt1', 1),
(2, 2, 0, 1473412874, 'tt2', 1),
(3, 2, 1, 1473645730, '', 1),
(4, 2, 0, 1473645764, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_users`
--

CREATE TABLE IF NOT EXISTS `sp_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；sp_password加密',
  `user_nicename` varchar(50) NOT NULL DEFAULT '' COMMENT '用户美名',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网站',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像，相对于upload/avatar目录',
  `sex` smallint(1) DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `signature` varchar(255) DEFAULT NULL COMMENT '个性签名',
  `last_login_ip` varchar(16) NOT NULL COMMENT '最后登录ip',
  `last_login_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '最后登录时间',
  `create_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '注册时间',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `user_type` smallint(1) DEFAULT '1' COMMENT '用户类型，1:会员 ;2:商家;3：代理商',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `sp_users`
--

INSERT INTO `sp_users` (`id`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `avatar`, `sex`, `birthday`, `signature`, `last_login_ip`, `last_login_time`, `create_time`, `user_activation_key`, `user_status`, `score`, `user_type`) VALUES
(1, 'admin', 'c535018ee946a6c2caeb5c0dfbe27b61a3d41db1bd1389af', 'admin', '2690762182@qq.com', '', NULL, 0, '0000-00-00', '', '0.0.0.0', '2016-09-14 16:55:05', '2016-02-24 10:27:43', '', 1, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_address`
--

CREATE TABLE IF NOT EXISTS `sp_user_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL COMMENT '用户ID',
  `name` varchar(50) DEFAULT NULL COMMENT '收货姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `sheng` varchar(255) DEFAULT NULL COMMENT '省',
  `shi` varchar(255) DEFAULT NULL COMMENT '市',
  `qu` varchar(255) DEFAULT NULL COMMENT '区',
  `address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `default` tinyint(4) DEFAULT NULL COMMENT '是否默认',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `sp_user_address`
--

INSERT INTO `sp_user_address` (`id`, `userid`, `name`, `phone`, `sheng`, `shi`, `qu`, `address`, `default`) VALUES
(5, 4, '嘎嘎1', '13094475000', '北京市', '北京市', '西城区', '城区', 1),
(6, 5, '李勇', '13683490107', '北京市', '北京市', '宣武区', '不知道了', 0),
(7, 5, '阳阳', '13683490107', '河北省', '张家口市', '下花园区', 'bbb', 0),
(8, 5, '宇宇', '13683490107', '湖北省', '省直辖县级行政单位', '仙桃市', '通天塔', 1),
(9, 4, '3213', '13683490107', '北京市', '北京市', '延庆县', '12312', 0),
(10, 6, '111', '13683499997', '河北省', '承德市', '隆化镇', 'rryhbryhb', 1),
(11, 6, '李勇', '13683490107', '天津市', '天津市', '静海县', '23123', 0),
(12, 10, 'y y y', '13366666666', '上海市', '上海市', '徐汇区', 't y y', 1),
(13, 12, '莫1慢慢', '18111625535', '四川省', '成都市', '成华区', '哈更就忘记具体了1律师估计就', 1),
(14, 16, '啊啊啊', '13685264536', '上海市', '上海市', '普陀区', '哈哈哈', 1),
(15, 35, '蒲薇', '13808081051', '四川省', '成都市', '金牛区', '万达甲级写字楼A座1206', 1),
(16, 55, '叶妮', '18280028670', '四川省', '成都市', '金牛区', '万达广场', 1),
(17, 101, '聪聪', '18628979977', '四川省', '成都市', '金牛区', '万达甲级写字楼1206', 1),
(18, 17, '任娟娟', '13540275657', '四川省', '成都市', '成华区', '万象城', 1),
(19, 112, '聪聪', '18628979977', '四川省', '成都市', '金牛区', '万达广场甲级写字楼1206', 1),
(20, 9, '蒲薇', '13808081051', '四川省', '成都市', '金牛区', '人民北路一段万达甲级写字楼A座', 1),
(21, 88, '叶晓妮', '18280028670', '四川省', '成都市', '金牛区', '金牛万达广场', 1),
(23, 82, '刘艳', '15828915521', '四川省', '巴中市', '南江县', '正直镇千金磅23号 刘艳', 1),
(24, 94, '张佳', '15928966286', '四川省', '成都市', '郫县', '犀浦校园东路111号', 1),
(25, 154, '刘华川', '18708158627', '四川省', '成都市', '金牛区', '成都市金牛区蜀明西路5号附11号', 1),
(26, 170, '胡宁东', '18180889807', '四川省', '成都市', '金牛区', '杜家十组圆圆超市', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_buycar`
--

CREATE TABLE IF NOT EXISTS `sp_user_buycar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员ID',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品名称ID',
  `spec_color` varchar(255) DEFAULT NULL COMMENT '规格—颜色',
  `spec_size` varchar(255) DEFAULT NULL COMMENT '规格—尺码',
  `nums` int(11) DEFAULT NULL COMMENT '商品数量',
  `date` int(11) DEFAULT NULL COMMENT '加入时间',
  `size_id` int(11) DEFAULT NULL COMMENT '规格ID',
  `sessionid` varchar(255) DEFAULT NULL COMMENT '浏览器ID',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `sp_user_buycar`
--

INSERT INTO `sp_user_buycar` (`id`, `uid`, `goods_id`, `spec_color`, `spec_size`, `nums`, `date`, `size_id`, `sessionid`) VALUES
(25, 136, 6, '6602卡其-薄款(尺码偏小-建议选大一码)', 'X', 1, 1464535857, 62, '100ido2p0ogshsvbbr2vv5cgb0');

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_dl`
--

CREATE TABLE IF NOT EXISTS `sp_user_dl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '会员编号',
  `lid` int(11) DEFAULT NULL COMMENT '代理级别编号',
  `dl_score` decimal(10,2) NOT NULL COMMENT '代理积分',
  `fybl` decimal(10,2) DEFAULT NULL COMMENT '分佣比例',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `sheng` varchar(255) NOT NULL COMMENT '省',
  `shi` varchar(255) NOT NULL COMMENT '市',
  `qu` varchar(255) NOT NULL COMMENT '区',
  `isenable` int(11) NOT NULL COMMENT '禁用',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `sp_user_dl`
--

INSERT INTO `sp_user_dl` (`id`, `uid`, `lid`, `dl_score`, `fybl`, `remark`, `sheng`, `shi`, `qu`, `isenable`) VALUES
(1, 7, 2, '0.00', '0.00', '', '请选择省份', '请选择市', '请选择区|县', 1),
(2, 98, 2, '284.23', '0.00', '', '请选择省份', '请选择市', '请选择区|县', 1),
(3, 97, 3, '2.88', '0.00', '', '四川省', '成都市', '成华区', 1),
(4, 107, 2, '0.00', '0.00', '', '请选择省份', '请选择市', '请选择区|县', 1),
(5, 38, 2, '0.00', '0.00', '', '请选择省份', '请选择市', '请选择区|县', 1),
(6, 114, 2, '0.00', '0.00', '', '请选择省份', '请选择市', '请选择区|县', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_favorites`
--

CREATE TABLE IF NOT EXISTS `sp_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '收藏内容的标题',
  `url` varchar(255) DEFAULT NULL COMMENT '收藏内容的原文地址，不带域名',
  `description` varchar(500) DEFAULT NULL COMMENT '收藏内容的描述',
  `table` varchar(50) DEFAULT NULL COMMENT '收藏实体以前所在表，不带前缀',
  `object_id` int(11) DEFAULT NULL COMMENT '收藏内容原来的主键id',
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_integral`
--

CREATE TABLE IF NOT EXISTS `sp_user_integral` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL COMMENT '用户ID',
  `sellerid` int(11) NOT NULL COMMENT '商家ID',
  `op` varchar(20) DEFAULT NULL COMMENT '操作',
  `itype` int(11) NOT NULL COMMENT '用户类型',
  `integral` decimal(10,2) DEFAULT NULL COMMENT '操作积分',
  `integral_sj` decimal(10,2) DEFAULT NULL COMMENT '实际积分',
  `cur_integral` decimal(10,2) DEFAULT NULL COMMENT '当前余额',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `date` int(11) DEFAULT NULL COMMENT '操作时间',
  `is_fanxian` int(11) DEFAULT NULL COMMENT '商家是否返现',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '微信订单号',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sp_user_integral`
--

INSERT INTO `sp_user_integral` (`id`, `userid`, `sellerid`, `op`, `itype`, `integral`, `integral_sj`, `cur_integral`, `remark`, `date`, `is_fanxian`, `out_trade_no`) VALUES
(1, 2, 0, 'tixian', 1, '6000.00', '6000.00', '49000.00', '您提出了提现申请 金额：6000 手续费：0 元,实际到账：6000 元', 1472458493, NULL, NULL),
(2, 2, 0, 'tixian', 1, '17000.00', '16998.00', '0.00', '您提出了提现申请 金额：17000 手续费：2 元,实际到账：16998 元', 1473127049, NULL, NULL),
(3, 2, 0, 'tixian', 1, '2000.00', '1998.00', '0.00', '您提出了提现申请 金额：2000 手续费：2 元,实际到账：1998 元', 1473127167, NULL, NULL),
(4, 2, 0, 'tixian', 1, '9998.00', '9996.00', '2.00', '您提出了提现申请 金额：9998 手续费：2 元,实际到账：9996 元', 1473127297, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_message`
--

CREATE TABLE IF NOT EXISTS `sp_user_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sendid` int(11) NOT NULL COMMENT '发送人ID',
  `userid` int(11) DEFAULT NULL COMMENT '用户ID',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` varchar(2000) DEFAULT NULL COMMENT '内容',
  `date` int(11) DEFAULT NULL COMMENT '发布时间',
  `is_read` int(11) DEFAULT NULL COMMENT '阅读',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sp_user_message`
--

INSERT INTO `sp_user_message` (`id`, `sendid`, `userid`, `title`, `content`, `date`, `is_read`) VALUES
(1, 5, 4, '推荐人注册', '您有新推荐的用户加入了！', 1472729152, 1),
(2, 6, 5, '推荐人注册', '您有新推荐的用户加入了！', 1472731523, 0);

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_sd`
--

CREATE TABLE IF NOT EXISTS `sp_user_sd` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL COMMENT 'openid',
  `topid` int(11) DEFAULT NULL COMMENT '上级ID',
  `time` int(11) DEFAULT NULL COMMENT '锁定时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=172 ;

-- --------------------------------------------------------

--
-- 表的结构 `sp_user_withdraw`
--

CREATE TABLE IF NOT EXISTS `sp_user_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `itype` int(11) DEFAULT NULL COMMENT '提现类别',
  `price` decimal(10,2) DEFAULT NULL COMMENT '提现金额',
  `fee` decimal(10,2) DEFAULT NULL COMMENT '手续费',
  `sjdz` decimal(10,2) DEFAULT NULL COMMENT '实际到账',
  `state` int(11) DEFAULT NULL COMMENT '提现状态',
  `khyh` varchar(50) DEFAULT NULL COMMENT '开户银行',
  `khxm` varchar(20) DEFAULT NULL COMMENT '开户姓名',
  `yhzh` varchar(20) DEFAULT NULL COMMENT '银行账号',
  `date` int(11) DEFAULT NULL COMMENT '操作时间',
  `khzh` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sp_user_withdraw`
--

INSERT INTO `sp_user_withdraw` (`id`, `uid`, `itype`, `price`, `fee`, `sjdz`, `state`, `khyh`, `khxm`, `yhzh`, `date`, `khzh`) VALUES
(1, 2, 1, '6000.00', '0.00', '6000.00', 2, '农业银行', '1', '9885682015874532141', 1472458493, '成都高新区新希望国际支行'),
(2, 2, 1, '17000.00', '2.00', '16998.00', 1, '建设银行', '1', '9885682015874532141', 1473127049, 'asdfdsfds'),
(3, 2, 1, '2000.00', '2.00', '1998.00', 1, '建设银行', '1', '9885682015874532141', 1473127167, 'asdfdsfds'),
(4, 2, 1, '9998.00', '2.00', '9996.00', 1, '建设银行', '1', '9885682015874532141', 1473127297, 'asdfdsfds');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
