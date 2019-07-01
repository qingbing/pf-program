
-- --------------------------------------------------------

--
-- 表的结构 `pub_block_category`
--

CREATE TABLE IF NOT EXISTS `pub_block_category` (
  `key` varchar(100) NOT NULL COMMENT '引用标识',
  `type` varchar(20) NOT NULL DEFAULT '1' COMMENT '页面区块类型：content, image-link, cloud-words, cloud-words-links, list, list-links, images, image-links',
  `name` varchar(100) NOT NULL COMMENT '区块名称',
  `description` varchar(255) DEFAULT NULL COMMENT '区块描述',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开放，否时管理员不可操作（不可见）',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '页面区块启用状态',
  `src` varchar(200) DEFAULT NULL COMMENT 'type为image-link时，为图片地址',
  `x_flag` varchar(20) DEFAULT NULL COMMENT 'type为content的在线编辑器标识符',
  `content` text COMMENT 'type为content时存放内容，为image-link时存放图片链接',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`key`),
  KEY `idx_created_at` (`created_at`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站页面区块类型';

--
-- 表的结构 `pub_block_option`
--

CREATE TABLE IF NOT EXISTS `pub_block_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `key` varchar(100) NOT NULL COMMENT '所属区块标识',
  `label` varchar(100) DEFAULT NULL COMMENT '链接显示名称',
  `link` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `src` varchar(200) DEFAULT NULL COMMENT '图片地址',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否对管理开放',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用发布显示',
  `is_blank` tinyint(1) NOT NULL DEFAULT '0' COMMENT '如果为链接，是否新开窗口',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_key_label` (`key`,`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='页面区块详情';
