
-- --------------------------------------------------------

--
-- 表的结构 `pub_static_page`
--

CREATE TABLE IF NOT EXISTS `pub_static_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '引用代码',
  `subject` varchar(100) NOT NULL COMMENT '内容主题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo的keywords',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo的description',
  `sort_order` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `x_flag` varchar(20) NOT NULL DEFAULT '' COMMENT '编辑器标志',
  `content` text COMMENT '内容',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '更新IP',
  `uid` BIGINT(20) UNSIGNED NOT NULL COMMENT '用户ID',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`),
  KEY `idx_sortOrder` (`sort_order`),
  KEY `idx_subject` (`subject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='静态页面管理表';

