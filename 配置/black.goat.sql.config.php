<?php

namespace FastDataBase\config;

/**
 * 数据库配置文件
 * | -------------------------------------------------- |
 * | 大部分的项目仅仅需要以下的配置项即可满足业务需求
 * | 如果暂且还是不能满足请您告知，我们会尽快做出决策
 * | -------------------------------------------------- |
 * @author SouthWan
 */

# 引入 BlackGoat 配置项
include "black.goat.config.php";

# 开发者模式与生成模式下的Sql配置
if (GOAT_ENVIRONMENT == "developer") {
    # 开发者环境下的Sql配置
    return array(
        # 选用的数据库类型
        "db_type" => "mysql",
        # mysql数据库配置信息
        "mysql" => array(
            # 连接字符串（使用此字符串以下部分配置会被忽略）[DSN]
            "host" => null,
            # 数据库类型(注意：不要更改！！！)
            "type" => "mysql",
            # 数据库连接地址
            "site" => "localhost",
            # 数据库端口
            "port" => 3306,
            # 数据库名称
            "name" => "black_goat",
            # 数据库用户名
            "user" => "root",
            # 数据库密码
            "pass" => "root",
            # 数据库字符集
            "charset" => "utf8"
        )
    );
} elseif (GOAT_ENVIRONMENT == "production") {
    # 生产环境下的Sql配置
    return array(
        # 选用的数据库类型
        "db_type" => "mysql",
        # mysql数据库配置信息
        "mysql" => array(
            # 连接字符串（使用此字符串以下部分配置会被忽略）
            "host" => null,
            # 数据库类型(注意：不要更改！！！)
            "type" => "mysql",
            # 数据库连接地址
            "site" => "",
            # 数据库端口
            "port" => 3306,
            # 数据库名称
            "name" => "",
            # 数据库用户名
            "user" => "",
            # 数据库密码
            "pass" => "",
            # 数据库字符集
            "charset" => "utf8"
        )
    );
}