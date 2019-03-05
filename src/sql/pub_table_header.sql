-- --------------------------------------------------------
-- 分类由程序员来管理，管理员可以对开放的分类进行简单的操作（排序，是否显示等）
-- 对程序代码，提供统一出口 \Tools\TableHeader::i($key)->getHeader();

--
-- 表的结构 `pub_header_category`
--

CREATE TABLE IF NOT EXISTS `pub_header_category` (
  `key` varchar(255) NOT NULL COMMENT '表头索引或标志，全站唯一',
  `name` varchar(255) NOT NULL COMMENT '表头标志别名',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '表头描述',
  `sort_order` int(8) NOT NULL DEFAULT '1000' COMMENT '排序',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开放表头，否时管理员不可操作（不可见）',
  PRIMARY KEY (`key`),
  UNIQUE KEY (`name`),
  KEY (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表头设置分类';

-- --------------------------------------------------------

--
-- 表的结构 `pub_header_option`
--

CREATE TABLE IF NOT EXISTS `pub_header_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `key` varchar(255) NOT NULL COMMENT '所属表头分类（来自header_category）',
  `code` varchar(255) NOT NULL COMMENT '字段名',
  `label` varchar(255) NOT NULL COMMENT '显示名',
  `default` varchar(255) NOT NULL DEFAULT ' - ' COMMENT '默认值',
  `width` varchar(20) DEFAULT '100px' COMMENT '宽度',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分类排序',
  `css_class` varchar(255) DEFAULT 'text-center' COMMENT '元素显示位置[text-left:靠左;text-center:居中;text-right:靠右;]',
  `is_required` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否必选',
  `is_default` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否默认',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启',
  `is_sortable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可排序',
  PRIMARY KEY (`id`),
  KEY (`sort_order`),
  UNIQUE KEY `key_code` (`code`,`key`),
  UNIQUE KEY `key_label` (`label`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表头配置选项';
