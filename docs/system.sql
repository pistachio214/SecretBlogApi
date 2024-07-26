DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user`
(
    `id`         bigint(20) NOT NULL AUTO_INCREMENT,
    `nickname`   varchar(64)  DEFAULT NULL COMMENT '昵称',
    `username`   varchar(64)  DEFAULT NULL,
    `password`   varchar(256) DEFAULT NULL,
    `type`       int(11) DEFAULT '1' COMMENT '用户类型: 1管理员; 2普通用户; ',
    `status`     int(11) NOT NULL,
    `avatar`     varchar(255) DEFAULT NULL,
    `email`      varchar(64)  DEFAULT NULL,
    `city`       varchar(64)  DEFAULT NULL,
    `last_login` datetime     DEFAULT NULL,

    `created_at` datetime NOT NULL,
    `updated_at` datetime     DEFAULT NULL,
    `deleted_at` timestamp    DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UK_USERNAME` (`username`) USING BTREE
)ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT ='用户表';

insert into `sys_user`(`id`, `nickname`, `username`, `password`, `type`, `avatar`, `email`, `city`, `last_login`,
                       `created_at`, `updated_at`, `status`, `deleted_at`)
values (1, '超级管理员', 'admin',
        '7533cd73daf8f5f723a97b6728f24bd9bb7d3c032ae7bd95b4928242e75aa1c1babed5aa3040294d63297186e8d4baf4f3c241ca27afb393c80d90de8a2e8b081a6938f2ab0c319a43d506170c602e951df13fc1104e36847dec3f00c8abfa1ed7bd6860b7d05918b6e98e6502da49942ac8f8eef69d7a7be0359c279d68e2bd',
        1, NULL, NULL, NULL, NULL, '2021-10-02 22:44:46', '2021-10-02 22:44:46', 1, NULL),
       (1689541974618537986, '测试管理员', 'test_user',
        '0b02361c545e299b2a90ce35c67485e98c045e46ca75cf9913f78b1def7ede1af77908192c2ccc1878d1cefbfcf70bdbae3b96b1c164d61f97a3a9c56fcb8988cd63b9bc1253ba0e916bec1b5022c3333cc302a7c9ac91a24d3a1acc673afd2f8c4adacef8297f7421c45d0deadac2bd5314aeec289490492236ad9687455248',
        NULL,
        'https://image-1300566513.cos.ap-guangzhou.myqcloud.com/upload/images/5a9f48118166308daba8b6da7e466aab.jpg',
        'test_user@qq.com', NULL, NULL, '2023-08-10 15:39:32', '2023-08-10 15:39:32', 1, NULL);