-- --------------------------------------------------------
-- 只有超管能添加管理员(不能添加或操作超管，超管又程序员设置)，其他成员不可见该模块

--
-- 表的结构 `admin_user`
--

CREATE TABLE IF NOT EXISTS `admin_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `nickname` varchar(30) NOT NULL COMMENT '用户昵称',
  `real_name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `sex` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '性别[0:保密,1:男士,2:女士]',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号码',
  `phone` varchar(15) NOT NULL DEFAULT '' COMMENT '固定电话',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'QQ',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '联系地址',
  `zip_code` char(6) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `refer_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '引荐人或添加人UID',
  `register_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '注册或添加IP',
  `register_time` datetime DEFAULT NULL COMMENT '注册或添加时间',
  `login_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `is_super` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否超级管理员',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户启用状态',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理人员表';
