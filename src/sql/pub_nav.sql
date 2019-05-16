-- --------------------------------------------------------

--
-- 表的结构 `pub_nav`
--

CREATE TABLE `pub_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `is_category` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否分类导航',
  `flag` varchar(50) NOT NULL COMMENT '标记',
  `label` varchar(50) NOT NULL COMMENT '显示标签',
  `url` varchar(50) DEFAULT NULL COMMENT '导航url',
  `sort_order` tinyint(4) NOT NULL DEFAULT '100' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开放',
  `is_blank` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否新开窗口',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='导航管理';