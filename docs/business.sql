DROP TABLE IF EXISTS `sys_user_extend`;
CREATE TABLE `sys_user_extend`
(
    `id`         bigint(20) NOT NULL COMMENT '编号',
    `user_id`    bigint(20) NOT NULL COMMENT '用户表(sys_user)外键',
    `sex`        int(11) DEFAULT '1' COMMENT '性别: 0女;1男;2未知',
    `signature`  varchar(100) NOT NULL COMMENT '个人签名',
    `bg_image`   text COMMENT '背景图片',

    `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `deleted_at` timestamp             DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES `sys_user` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT ='系统用户补充数据表';

DROP TABLE IF EXISTS `sys_user_files`;
CREATE TABLE `sys_user_files`
(
    `id`         bigint(20) NOT NULL COMMENT '编号',
    `user_id`    bigint(20) NOT NULL COMMENT '用户表(sys_user)外键',

    `url`        varchar(1000) NOT NULL COMMENT '文件地址',
    `type`       int(1) DEFAULT '1' COMMENT '附件类型 1:图片 2视频',

    `created_at` timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `deleted_at` timestamp              DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES `sys_user` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT ='系统用户附件表';

DROP TABLE IF EXISTS `app_banner`;
CREATE TABLE `app_banner`
(
    `id`         bigint(20) NOT NULL COMMENT '编号',
    `title`      varchar(100) NOT NULL COMMENT '标题',
    `type`       int(11) NOT NULL COMMENT '轮播的位置',
    `remarks`    varchar(255)          DEFAULT NULL COMMENT '备注',
    `image`      text COMMENT '轮播图地址',
    `arguments`  varchar(255)          DEFAULT NULL COMMENT '跳转参数',
    `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `deleted_at` timestamp             DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT ='app轮播表';

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post`
(
    `id`         bigint(20) NOT NULL COMMENT '编号',
    `user_id`    bigint(20) NOT NULL COMMENT '用户表(sys_user)外键',

    `title`      varchar(100) NOT NULL COMMENT '标题',
    `type`       int(11) DEFAULT NULL COMMENT '发起人类型 1管理员 2用户',
    `content`    text COMMENT '内容',
    `images`     text COMMENT '图片集合',
    `hot_num`    int(11) DEFAULT '0' COMMENT '热度',
    `status`     int(11) DEFAULT '1' COMMENT '帖子状态 1正常 2封禁',
    `like_num`   int(11) DEFAULT '0' COMMENT '喜欢数',
    `review_num` int(11) DEFAULT '0' COMMENT '评论数',

    `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `deleted_at` timestamp             DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES `sys_user` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT ='帖子表';

DROP TABLE IF EXISTS `post_files`;
CREATE TABLE `post_files`
(
    `id`         bigint(20) NOT NULL COMMENT '编号',
    `post_id`    bigint(20) NOT NULL COMMENT '帖子表(post)外键',
    `url`        varchar(1000) NOT NULL COMMENT '文件地址',
    `type`       int(1) DEFAULT '1' COMMENT '附件类型 1:图片 2视频',

    `created_at` timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `deleted_at` timestamp              DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT ='帖子附件表';

DROP TABLE IF EXISTS `post_reply_message`;
CREATE TABLE `post_reply_message`
(
    `id`           bigint(20) NOT NULL COMMENT '编号',
    `post_id`      bigint(20) NOT NULL COMMENT '帖子表(post)外键',
    `parent_id`    bigint(20) DEFAULT '0' COMMENT '父级编号: 0-帖子回复，other-信息表(post_reply_message.id)',
    `reply_id`     bigint(20) NOT NULL COMMENT '发送者-用户表(sys_user)外键',
    `receive_id`   bigint(20) DEFAULT NULL COMMENT '接收者-用户表(sys_user)外键',

    `content`      varchar(1000) NOT NULL COMMENT '消息内容',
    `image`        varchar(255)           DEFAULT NULL COMMENT '图片',
    `like_number`  int(11) DEFAULT '0' COMMENT '点赞数',
    `reply_number` int(11) DEFAULT '0' COMMENT '回复数',
    `status`       int                    DEFAULT '1' COMMENT '状态: 1-正常 other-其他状态',

    `created_at`   timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at`   timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `deleted_at`   timestamp              DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
    FOREIGN KEY (`reply_id`) REFERENCES `sys_user` (`id`),
    FOREIGN KEY (`receive_id`) REFERENCES `sys_user` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT ='帖子回帖信息表';
