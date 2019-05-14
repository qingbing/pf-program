
-- --------------------------------------------------------

--
-- 表的结构 `pub_static_page`
--

CREATE TABLE IF NOT EXISTS `pub_static_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `code` varchar(255) DEFAULT NULL COMMENT '引用代码',
  `subject` varchar(255) NOT NULL COMMENT '内容主题',
  `keywords` varchar(255) DEFAULT NULL COMMENT 'seo的keywords',
  `description` varchar(255) DEFAULT NULL COMMENT 'seo的description',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `x_flag` varchar(20) DEFAULT NULL COMMENT '编辑器标志',
  `content` text COMMENT '内容',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '更新IP',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `sort_order` (`sort_order`),
  KEY `subject` (`subject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='静态页面管理表';
