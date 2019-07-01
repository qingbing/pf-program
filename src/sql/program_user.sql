-- --------------------------------------------------------
-- 只有超管能添加程序员，其他成员不可见该模块

--
-- 表的结构 `program_user`
--

CREATE TABLE IF NOT EXISTS `program_user` (
  `uid` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(50) NOT NULL COMMENT '邮箱账户',
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
  `refer_uid` BIGINT(20) unsigned NOT NULL DEFAULT '0' COMMENT '引荐人或添加人UID',
  `register_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '注册或添加IP',
  `register_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册或添加时间',
  `login_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `is_super` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否超级程序员',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户启用状态',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uk_username` (`username`),
  UNIQUE KEY `uk_nickname` (`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='开发人员表';

--
-- 转存表中的数据 `program_user`
--
INSERT INTO `program_user` (`uid`, `username`, `password`, `nickname`, `real_name`, `sex`, `birthday`, `avatar`, `mobile`, `phone`, `qq`, `address`, `zip_code`, `refer_uid`, `register_ip`, `login_times`, `last_login_ip`, `last_login_time`, `is_super`, `is_enable`) VALUES
('1', 'top-world@qq.com', '9db06bcff9248837f86d1a6bcf41c9e7', 'Charles', '超级程序员', '1', NULL, '', '', '', '', '', '', '0', '127.0.0.1', '1', '192.168.146.1', '2017-08-21 08:15:01', '1', '1');
