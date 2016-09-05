DROP TABLE IF EXISTS `an_user`;
CREATE TABLE `an_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `user_name` varchar(100) NOT NULL COMMENT '用户名称',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱地址',
  `tel` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `weixin` varchar(255) DEFAULT NULL COMMENT '微信号',
  `qq` varchar(255) DEFAULT NULL COMMENT 'qq号码',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `an_user` VALUES ('1', '1', 'demo1', 'demo1@qq.com', '13100000000', 'weixin_test1', '123456');
INSERT INTO `an_user` VALUES ('2', '2', 'demo2', 'demo2@qq.com', '13100000001', 'weixin_test2', '123456');
INSERT INTO `an_user` VALUES ('3', '3', 'demo3', 'demo3@qq.com', '13100000002', 'weixin_test3', '123456');
INSERT INTO `an_user` VALUES ('4', '4', 'demo4', 'demo4@qq.com', '13100000003', 'weixin_test4', '123456');
INSERT INTO `an_user` VALUES ('5', '5', 'demo5', 'demo5@qq.com', '13100000004', 'weixin_test5', '123456');
INSERT INTO `an_user` VALUES ('6', '6', 'demo6', 'demo6@qq.com', '13100000005', 'weixin_test6', '123456');
INSERT INTO `an_user` VALUES ('7', '7', 'demo7', 'demo7@qq.com', '13100000006', 'weixin_test7', '123456');
INSERT INTO `an_user` VALUES ('8', '8', 'demo8', 'demo8@qq.com', '13100000007', 'weixin_test8', '123456');
INSERT INTO `an_user` VALUES ('9', '9', 'demo9', 'demo9@qq.com', '13100000008', 'weixin_test9', '123456');