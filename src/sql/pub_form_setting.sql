-- --------------------------------------------------------
-- 分类由程序员来管理，管理员可以对开放的、启用状态下的分类进行简单的操作（排序，是否显示等）
-- 在管理员中，对配置类型和搜集表单进行单独处理
-- 程序代码中对于配置表单，提供统一配置项出口 \app\pub\U::setting($key)->$key;

--
-- 表的结构 `pub_form_category`
--

CREATE TABLE IF NOT EXISTS `pub_form_category` (
  `key` varchar(255) NOT NULL COMMENT '表单索引或标志，全站唯一',
  `name` varchar(255) NOT NULL COMMENT '表单类别名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '表单类别描述',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_setting` tinyint(1) NOT NULL DEFAULT '1' COMMENT '配置类型[0:搜集表单，1:配置项]',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开放，否时管理员不可操作（不可见）',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态',
  PRIMARY KEY (`key`),
  KEY (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单设置类别表';

-- --------------------------------------------------------

--
-- 表的结构 `pub_form_option`
--

CREATE TABLE IF NOT EXISTS `pub_form_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `key` varchar(255) NOT NULL COMMENT '所属表单分类（来自form_category）',
  `code` varchar(255) NOT NULL COMMENT '字段名',
  `label` varchar(255) NOT NULL COMMENT '表单显示名',
  `default` varchar(255) NOT NULL DEFAULT '' COMMENT '默认值',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类配置描述',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '当前分类排序',
  `input_type` enum('text','select','textarea','editor','checkbox','checkbox_list','radio_list','password','hidden','file') NOT NULL DEFAULT 'text' COMMENT '输入类型',
  `data_type` enum('required','email','url','ip','phone','mobile','contact','fax','zip','time','date','username','password','compare','preg','string','numeric','integer','money','file','select','choice','checked') DEFAULT 'string' COMMENT '前端数据验证',
  `input_data` text COMMENT '非直接输入框的json键值对',
  `allow_empty` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许为空',
  `compare_field` varchar(255) NOT NULL DEFAULT '' COMMENT '对比字段，只对compare的数据类型有效，对应于compareField',
  `pattern` varchar(255) NOT NULL DEFAULT '' COMMENT '正则匹配表达式，对正则匹配验证有效',
  `tip_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '页面提示信息，对应于tipMsg',
  `error_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '页面错误提示信息，对应于errorMsg',
  `empty_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '信息为空提示信息，对应于emptyMsg',
  `min` tinyint(4) DEFAULT NULL COMMENT '最小值/最小长度，对应于min,minLength',
  `min_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '最小值提示信息，对应于minErrorMsg',
  `max` tinyint(4) DEFAULT NULL COMMENT '最大值/最大长度，对应于max,maxLength',
  `max_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '最大值提示信息，对应于maxErrorMsg',
  `file_extensions` varchar(255) NOT NULL DEFAULT '' COMMENT '文件上传时支持的文件后缀类型,用|分隔',

  `callback` varchar(255) NOT NULL DEFAULT '' COMMENT '验证回调函数，在页面中需要定义对应的回调函数',
  `ajax_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'ajax验证URL',

  `tip_id` varchar(255) NOT NULL DEFAULT '' COMMENT '表单验证的信息提示框',
  `css_id` varchar(255) NOT NULL DEFAULT '' COMMENT '表单元素ID',
  `css_class` varchar(255) NOT NULL DEFAULT '' COMMENT '表单元素的类',
  `css_style` varchar(255) NOT NULL DEFAULT '' COMMENT '输入表单元素的样式',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '表单项目启用状态',
  PRIMARY KEY (`id`),
  KEY (`sort_order`),
  UNIQUE KEY `key_code` (`code`,`key`),
  UNIQUE KEY `key_label` (`label`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单配置项目' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pub_form_setting`
--

CREATE TABLE IF NOT EXISTS `pub_form_setting` (
  `key` varchar(255) NOT NULL COMMENT '表单分类（来自form_category）',
  `content` text COMMENT '表单配置项目值',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='表单配置类别值';



INSERT INTO `pub_form_category` (`key`, `name`, `description`, `sort_order`, `is_setting`, `is_enable`) VALUES ('email-noreply', '邮件通知', '邮件通知维护', '0', '1', '1');

INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('1', 'email-noreply', 'field_required', 'required', '', '', '0', 'text', 'required', '', '', '', '必填', '不能为空', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('2', 'email-noreply', 'field_email', 'email', '', '', '0', 'text', 'email', '', '', '', '邮箱', '邮件格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('3', 'email-noreply', 'field_url', 'url', '', '', '0', 'text', 'url', '', '', '', 'URL', 'URl格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('4', 'email-noreply', 'field_ip', 'ip', '', '', '0', 'text', 'ip', '', '', '', 'IP', 'IP格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('5', 'email-noreply', 'field_phone', 'phone', '', '', '0', 'text', 'phone', '', '', '', 'Phone', 'Phone格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('6', 'email-noreply', 'field_mobile', 'mobile', '', '', '0', 'text', 'mobile', '', '', '', 'mobile', 'Mobile格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('7', 'email-noreply', 'field_contact', 'contact', '', '', '0', 'text', 'contact', '', '', '', 'contact', 'Contace格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('8', 'email-noreply', 'field_fax', 'fax', '', '', '0', 'text', 'fax', '', '', '', 'fax', 'Fax格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('9', 'email-noreply', 'field_zip', 'zip', '', '', '0', 'text', 'zip', '', '', '', 'zip', 'Zipcode格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('10', 'email-noreply', 'field_time', 'time', '', '', '0', 'text', 'time', '', '', '', 'time', 'Time格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('11', 'email-noreply', 'field_date', 'date', '', '', '0', 'text', 'date', '', '', '', 'date', 'Date格式不对', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('12', 'email-noreply', 'field_password', 'password', '', '', '0', 'password', 'password', '', '', '', '密码输入', '密码不规范', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', 'field_password_id', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('13', 'email-noreply', 'field_compare', 'compare', '', '', '0', 'text', 'compare', '', 'field_password_id', '', '确认密码', '密码确认不正确', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('14', 'email-noreply', 'field_string', 'string', '', '', '0', 'editor', 'string', '', '', '', '输入信息', '请输入信息', '{attribute}不能为空', NULL, '长度不能小于{min}', NULL, '长度不能大于{max}', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('15', 'email-noreply', 'field_username', 'username', '', '', '0', 'text', 'username', '', '', '', '输入用户名', '用户名不规范', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('16', 'email-noreply', 'field_numeric', 'numeric', '', '', '0', 'text', 'numeric', '', '', '', '输入数字', 'Numer格式不对', '{attribute}不能为空', NULL, '不能小于{min}', NULL, '不能大于{max}', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('17', 'email-noreply', 'field_integer', 'integer', '', '', '0', 'text', 'integer', '', '', '', '输入整数', 'Integer格式不对', '{attribute}不能为空', NULL, '不能小于{min}', NULL, '不能大于{max}', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('18', 'email-noreply', 'field_money', 'money', '', '', '0', 'text', 'money', '', '', '', '输入money', 'Money格式不对', '{attribute}不能为空', NULL, '不能小于{min}', NULL, '不能大于{max}', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('19', 'email-noreply', 'field_preg', 'preg', '', '', '0', 'text', 'preg', '', '', '/^.{6,32}$/', '输入匹配值', '匹配不正确', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('20', 'email-noreply', 'field_file', 'file', '', '', '0', 'file', 'file', '', '', '', '上传文件', '文件输入', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('21', 'email-noreply', 'field_select', 'select', '', '', '0', 'select', 'select', '{\"1\":\"密\",\"2\":\"男\",\"3\":\"女\"}', '', '', '选择', '选择项目输入', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('22', 'email-noreply', 'field_radioList', 'radioList', '', '', '0', 'radio_list', 'radioList', '{\"1\":\"密\",\"2\":\"男\",\"3\":\"女\"}', '', '', '单选', '单选组输入', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('23', 'email-noreply', 'field_checkbox', 'checkbox', '', '', '0', 'checkbox', 'checkbox', '', '', '', '确认checkbox', 'Checkbox勾选', '{attribute}不能为空', NULL, '', NULL, '', '', '', '', '', '', '', '', '0', '1');
INSERT INTO `pub_form_option` (`id`, `key`, `code`, `label`, `default`, `description`, `sort_order`, `input_type`, `data_type`, `input_data`, `compare_field`, `pattern`, `tip_msg`, `error_msg`, `empty_msg`, `min`, `min_msg`, `max`, `max_msg`, `file_extensions`, `callback`, `ajax_url`, `tip_id`, `css_id`, `css_class`, `css_style`, `allow_empty`, `is_enable`) VALUES ('24', 'email-noreply', 'field_checkboxList', 'checkboxList', '', '', '0', 'checkbox_list', 'checkboxList', '{\"orange\":\"橙子\",\"apple\":\"苹果\",\"banana\":\"香蕉\",\"pear\":\"梨子\",\"peach\":\"桃子\"}', '', '', '勾选check box组', 'Checkbox勾选组', '{attribute}不能为空', '2', '', '3', '', '', '', '', 'checkbox_list_tip_id', '', '', '', '0', '1');
