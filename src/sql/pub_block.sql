
-- --------------------------------------------------------

--
-- 表的结构 `pub_block_category`
--

CREATE TABLE IF NOT EXISTS `pub_block_category` (
  `key` varchar(255) NOT NULL COMMENT '引用标识',
  `type` varchar(20) NOT NULL DEFAULT '1' COMMENT '页面区块类型：content, link-cloud-words, cloud-words, links, images, image-links',
  `name` varchar(255) NOT NULL COMMENT '区块名称',
  `description` varchar(255) DEFAULT NULL COMMENT '区块描述',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开放，否时管理员不可操作（不可见）',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '页面区块启用状态',
  `x_flag` varchar(50) DEFAULT NULL COMMENT 'type为content的在线编辑器标识符',
  `content` text COMMENT 'type为content时存放内容',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`key`),
  KEY `create_time` (`create_time`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站页面区块类型';

--
-- 表的结构 `pub_block_option`
--

CREATE TABLE IF NOT EXISTS `pub_block_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `key` varchar(255) NOT NULL COMMENT '所属区块标识',
  `label` varchar(255) DEFAULT NULL COMMENT '链接显示名称',
  `link` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `src` varchar(255) DEFAULT NULL COMMENT '图片地址',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否对管理开放',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用发布显示',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_label` (`key`,`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='页面区块详情';
