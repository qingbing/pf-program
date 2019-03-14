-- --------------------------------------------------------

--
-- 表的结构 `pub_replace_setting`
--

CREATE TABLE IF NOT EXISTS `pub_replace_setting` (
  `key` varchar(255) NOT NULL COMMENT '替换配置标识符',
  `name` varchar(255) NOT NULL COMMENT '替换配置名称',
  `description` varchar(255) DEFAULT NULL COMMENT '内容描述',
  `x_flag` varchar(50) DEFAULT NULL COMMENT '在线编辑器标识符',
  `template` text DEFAULT NULL COMMENT '默认模板',
  `content` text DEFAULT NULL COMMENT '模板',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态',
  `replace_type` set('system','login','client') DEFAULT NULL COMMENT '替换字段的几种默认类型',
  `replace_fields` text COMMENT '替换字段集(JSON键值对),字段可以从模板中提取',
  PRIMARY KEY (`key`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站中的内容配置';

--
-- 转存表中的数据 `pub_replace_setting`
--

INSERT INTO `pub_replace_setting` (`key`, `name`, `description`, `template`, `sort_order`, `is_enable`, `replace_type`, `replace_fields`) VALUES
('mail_active', '用户邮箱激活', '用户激活邮箱是发送的内容', '<div style="width:600px;word-wrap:break-word;word-break:normal;">    <p style="text-align:left;text-indent:0em;">尊敬的<span style="color: #096995; font-size: 16px; font-weight: bold;">{login_nickname}</span>：</p>    <p style="text-indent:2em;text-align:left;">您好！</p>    <p style="text-indent:2em;text-align:left;">感谢使用<a href="{domain}">{site_name}</a>，请点击下面的链接激活您的账户：</p>    <p style="text-indent:2em;text-align:left;"><a href="{active_link}">{active_link}</a></p>    <p style="text-indent:2em;text-align:left;">以上链接有效期为{expire_time}，如果点击以上链接没有反应，请将该网址复制并粘贴到新的浏览器窗口中。</p>    <p style="text-indent:2em;text-align:left;">如果您是误收到这封邮件，则可能是因为其他用户在尝试用您的邮箱进行用户注册，您可以进行如下操作：</p>    <p style="text-indent:2em;text-align:left;">1、通过邮件修改在<a href="{domain}">{site_name}</a>中的密码，别人就无法再次登录，您可以继续用该邮箱账号在<a href="{domain}">{site_name}</a>中进行访问浏览。</p>    <p style="text-indent:2em;text-align:left;">2、通过网站下方提供的邮箱地址联系我们，我们将尽快在网站中禁用该用户。</p>    <p style="text-indent:2em;text-align:left;">最后，祝愿您的事业蒸蒸日上，一天更比一天好！</p>    <p style="text-indent:2em;text-align:left;">此致</p>    <p style="text-indent:2em;text-align:left;">ecphp.org工作室敬上</p>    <p style="text-indent:0em;text-align:left;">温馨提示，该邮件为用户注册时系统自动发送，请勿回复。要了解您的账户或网站详情，请访问我们的网站：</p>    <p style="text-indent:2em;text-align:left;"><a href="{domain}">{site_name}</a></p></div>', 88, 1, 'login', '{active_link:激活链接}\r\n{expire_time:激活链接有效期}'),
('mail_findPassword', '找回密码内容', '用户通过邮箱找回密码的内容', '<div style="width:600px;word-wrap:break-word;word-break:normal;">    <p style="text-align:left;text-indent:0em;">尊敬的<span style="color: #096995; font-size: 16px; font-weight: bold;">{email}</span>：</p>    <p style="text-indent:2em;text-align:left;">您好！</p>    <p style="text-indent:2em;text-align:left;">感谢使用<a href="{domain}">{site_name}</a>，要重设您在<a href="{domain}">{site_name}</a>上的帐户{email}的密码，请点击以下链接重新设置：</p>    <p style="text-indent:2em;text-align:left;"><a href="{password_back_link}">{password_back_link}</a></p>    <p style="text-indent:2em;text-align:left;">以上链接有效期为{expire_time}，如果点击以上链接没有反应，请将该网址复制并粘贴到新的浏览器窗口中。</p>    <p style="text-indent:2em;text-align:left;">如果您是误收到这封邮件，则可能是因为其他用户在尝试用您的邮箱进行用户注册，您可以进行如下操作：</p>    <p style="text-indent:2em;text-align:left;">1、通过邮件修改在<a href="{domain}">{site_name}</a>中的密码，别人就无法再次登录，您可以继续用该邮箱账号在<a href="{domain}">{site_name}</a>中进行访问浏览。</p>    <p style="text-indent:2em;text-align:left;">2、通过网站下方提供的邮箱地址联系我们，我们将尽快在网站中禁用该用户。</p>    <p style="text-indent:2em;text-align:left;">最后，祝愿您的事业蒸蒸日上，一天更比一天好！</p>    <p style="text-indent:2em;text-align:left;">此致</p>    <p style="text-indent:2em;text-align:left;">ecphp.org工作室敬上</p>    <p style="text-indent:0em;text-align:left;">温馨提示，该邮件为用户注册时系统自动发送，请勿回复。要了解您的账户或网站详情，请访问我们的网站：</p>    <p style="text-indent:2em;text-align:left;"><a href="{domain}">{site_name}</a></p></div>', 87, 1, 'define', '{email:邮箱账户}\r\n{password_back_link:密码重置链接}\r\n{expire_time:激活链接有效期}'),
('mail_register', '用户注册通知', '用户注册时发送到用户邮箱的提示内容', '<div style="width:600px;word-wrap:break-word;word-break:normal;">    <p style="text-align:left;text-indent:0em;">尊敬的<span style="font-size:16px;color:#096995;font-weight: bold;">{nickname}</span>：</p>    <p style="text-indent:2em;text-align:left;">您好！</p>    <p style="text-indent:2em;text-align:left;">您于{now_time}在<a href="{domain}">{site_name}</a>上已经成功注册，并成为了我们的注册用户。</p>    <p style="text-indent:2em;text-align:left;">首先要感谢您对我们的支持，我们将竭诚为您服务。登录名为您的邮箱，该邮箱是您在<a href="{domain}">{site_name}</a>上的唯一标识，请妥善保管。</p>    <p style="text-indent:2em;text-align:left;">如果是您自己的操作，建议您尽快激活您的账户，以便成为我们的激活用户。</p>    <p style="text-indent:2em;text-align:left;">激活地址：<a href="{active_link}">{active_link}</a></p>    <p style="text-indent:2em;text-align:left;">以上链接有效期为{expire_time}，如果点击以上链接没有反应，请将该网址复制并粘贴到新的浏览器窗口中。</p>    <p style="text-indent:2em;text-align:left;">如果您是误收到这封邮件，则可能是因为其他用户在尝试用您的邮箱进行用户注册，您可以进行如下操作：</p>    <p style="text-indent:2em;text-align:left;">1、通过邮件修改在<a href="{domain}">{site_name}</a>中的密码，别人就无法再次登录，您可以继续用该邮箱账号在<a href="{domain}">{site_name}</a>中进行访问浏览。</p>    <p style="text-indent:2em;text-align:left;">2、通过网站下方提供的邮箱地址联系我们，我们将尽快在网站中禁用该用户。</p>    <p style="text-indent:2em;text-align:left;">最后，祝愿您的事业蒸蒸日上，一天更比一天好！</p>    <p style="text-indent:2em;text-align:left;">此致</p>    <p style="text-indent:2em;text-align:left;">ecphp.org工作室敬上</p>    <p style="text-indent:0em;text-align:left;">温馨提示，该邮件为用户注册时系统自动发送，请勿回复。要了解您的账户或网站详情，请访问我们的网站：</p>    <p style="text-indent:2em;text-align:left;"><a href="{domain}">{site_name}</a></p></div>', 89, 1, 'define', '{mail:注册邮箱}\r\n{nickname:注册昵称}\r\n{active_link:激活链接}\r\n{expire_time:激活链接有效期}');
