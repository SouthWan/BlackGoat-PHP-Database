# Black Goat [Database-plus] 1.0

------

> Black Goat是一款轻量级的数据库操作类，所有的CURD ( 增删改查 ) 操作都被聚合到查询引擎 (Goat Engine) 中，因此仅仅需要学习查询器的使用方式即可轻松完成CURD，当然Black Goat也有专门为事务封装完整的操作基类供开发者使用，起步仅仅需要配置一些参数即可完成对MySQL数据库的操作，后续陆续支持Goat Engine以及专门处理事务机制的 GoatTransaction 为Black Goat赋能...

## 版本特性

------

1.  简化PDO的底层操作
2.  采用`PHP7`强类型（严格模式）

## 版本支持说明

------

PHP版本要求：

```php
php >= 7.4
```

MySQL版本要求：

```sql
mysql >= 5.5
```

## 数据库支持说明

------

> 在开发过程中因为某些不可控因素导致，仅仅对MySQL数据库进行支持，当然也可以对源代码进行修改以便支持更多的数据库，在后续的开发中会陆续支持其它的数据库，敬请期待....

## 起步 [配置]

------

> 仅仅需要修改一些配置项，Black Goat就可以正常工作了，接下来可以通过阅读以下教程并尝试配置，同时您可以通过一些非必须的配置项提升开发效率，在扩展教程中有介绍，您可以选择使用它或者忽略它，忽略并不会对您的项目有任何影响，您大可放心使用Black Goat

### Black Goat 配置项

------

配置文件位置：

```text
/config/black.goat.config.php
```

配置项：

```php
/**
 * 当前环境 (开发者环境 or 生产环境)
 * 可选值 [developer] or [production]
 */
defined("GOAT_ENVIRONMENT") or define("GOAT_ENVIRONMENT", "developer");

/**
 * 当前版本 [当前FastDatabase版本]
 * 可以通过方法获取到此版本号
 */
defined("GOAT_VERSION") or define("GOAT_VERSION", 1.0);

/**
 * 执行查询时希望得到的数据类型 [关联数组(key)，下标数组(index)，关联数组+下标数组(all)]
 * 默认关联数组(key) (可选值key/index/all)
 */
defined("GOAT_QUERY_DATA_TYPE") or define("GOAT_QUERY_DATA_TYPE", "key");
```

配置项介绍：

| 名称                 | 可选值                  | 可选值类型 | 描述                         |
| -------------------- | ----------------------- | ---------- | ---------------------------- |
| GOAT_ENVIRONMENT     | developer \| production | enum       | 当前环境                     |
| GOAT_VERSION         | 1.0                     | int        | 当前版本号(不要更改)         |
| GOAT_QUERY_DATA_TYPE | key \| index \| all     | enum       | 执行查询时希望得到的数据类型 |

### 数据库的配置项

------

配置文件位置：

```text
/config/black.goat.sql.config.php
```

配置项：

```php
# 开发者模式与生成模式下的Sql配置
if (Environment == "developer") {
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
} elseif (Environment == "production") {
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
```

配置项介绍：

| 名称    | 可选值  | 可选值类型 | 描述                 |
| ------- | ------- | ---------- | -------------------- |
| db_type | mysql   | enum       | 当前环境选用的数据库 |
| mysql   | array() | array      | mysql配置项          |

mysql配置项介绍：

| 名称    | 可选值    | 可选值类型     | 描述                                          |
| ------- | --------- | -------------- | --------------------------------------------- |
| host    | null      | string or null | 连接字符串即dsn，一旦配置此项其他项有可能失效 |
| type    | mysql     | enum           | 数据库类型，不要尝试改动，可能会出现意外      |
| site    | localhost | string         | 数据库连接地址，本地即localhost               |
| port    | 3306      | int            | 数据库端口，默认3306                          |
| name    | test      | string         | 数据库名称                                    |
| user    | root      | string         | 数据库用户名                                  |
| pass    | root      | string         | 数据库密码                                    |
| charset | utf8      | string         | 数据库字符集                                  |

## Goat Engine 引擎

------

> Goat Engine 引擎的主要工作是完成Black Goat的CURD(增删改查)工作，其中涵盖了大量提升开发效率的方法，能够很大程度帮助开发者提升开发效率，简化开发过程，接下来就来上手Goat Engine引擎吧！！！

Goat Engine 还在开发中...

## 原生 SQL 方法

------

> Goat Engine 是基于原生引擎的上层封装，在需要使用原生SQL的 情况下推荐使用具有预处理特性的方法，这类方法能够避免一部分的SQL注入风险，当然做好SQL过滤也是需要的，在此项文档中不会介绍其它的原生SQL方法，仅仅介绍具有预处理特性的SQL方法

支持的原生SQL方法

- [x] PrepareExecute[ 预处理 ] ( 增加 - insert | 删除 - delete | 修改 - update )

### PrepareExecute [ 预处理 ] 

------

如何使用：

```php
PrepareInsert (string sql,array param);
```

入参介绍：

| 参数名 | 类型   | 示例值                                             | 说明             |
| ------ | ------ | -------------------------------------------------- | ---------------- |
| sql    | string | INSERT INTO user (user,pass) VALUES (:user,:pass); | 预处理的sql语句  |
| param  | array  | [":user"=>"BlackGoat",":pass"=>"123456"]           | 预处理绑定的参数 |

源代码示例：

```php
# 创建BlackGoat对象
$db = new BlackGoat();
# 设置待处理sql
$sql = "INSERT INTO user (user,pass) VALUES (:user,:pass);";
# 设置处理参数
$param = [":user"=>"BlackGoat",":pass"=>"123456"];
# 执行并取得返回值
$data = $db->PrepareInsert($sql,$param);
```

使用说明：

```php
# 在设置 sql 时需要注意与 param 对应 
$sql = "INSERT INTO user (user,pass) VALUES (:user,:pass);";
# 注意 sql 中的 :user 与 :pass 必须与之对应，否则无法正常执行
$param = [":user"=>"BlackGoat",":pass"=>"123456"];
```

其它使用方法：

```php
# 创建BlackGoat对象
$db = new BlackGoat();
# 设置待处理sql
$sql = "INSERT INTO user (user,pass) VALUES (?,?);";
# 设置处理参数
$param = ["BlackGoat","123456"];
# 执行并取得返回值
$data = $db->PrepareInsert($sql,$param);
```

其它使用方法说明：

```php
# 使用第二种办法同样可以执行，但是需要注意一些差异
$sql = "INSERT INTO user (user,pass) VALUES (?,?);";
# sql 参数中的 :user 和 :pass 需要被替换为 ? 
$param = ["BlackGoat","123456"];
# 同样 param 参数不再需要使用键值，直接按照顺序输入数据即可
```

返回值：

| 状态码(code) | 信息(msg) | 处理            | 说明        |
| ------------ | --------- | --------------- | ----------- |
| 200          | 执行成功  | 无需处理        | sql执行成功 |
| 300          | 执行失败  | 检查sql是否异常 | sql执行失败 |

### PrepareQuery [ 预处理 ] 

------

如何使用：

```php
PrepareQuery(string sql,array param, string type)
```

入参介绍：

| 参数名 | 类型   | 示例值                                             | 默认值 | 说明             |
| ------ | ------ | -------------------------------------------------- | ------ | ---------------- |
| sql    | string | INSERT INTO user (user,pass) VALUES (:user,:pass); | 无     | 预处理的sql语句  |
| param  | array  | [":user"=>"BlackGoat",":pass"=>"123456"]           | 无     | 预处理绑定的参数 |
| type   | string | index 或 all 或 key                                | key    | 返回值数据类型   |

源代码示例：

```php
# 实例化 BlackGoat
$db = new BlackGoat();
# 执行查询，param 可以选择不入值，但是必须存在
$data = $db->PrepareQuery("SELECT * FROM user;",[],"index");
# type 可以忽略，它会选择默认值作为 type 值
echo json_encode($data, JSON_UNESCAPED_UNICODE);
```

返回值：

| 状态码(code) | 信息(msg)              | 处理            | 说明               |
| ------------ | ---------------------- | --------------- | ------------------ |
| 200          | array[] - 查询到的数据 | 无需处理        | 执行成功并得到数据 |
| 300          | 执行失败               | 检查sql是否异常 | sql执行失败        |

## 作者致谢

------

> 非常感谢各位开发者使用 BlackGoat ，因为一些个人原因工作进度一直得不到推进，致使目前只有两个实际可以使用的方法非常的抱歉，希望各位开发者能够理解，同时希望您认为BlackGoat做的不错可以基于此版本进行再次开发，如果您有任何宝贵的意见，您可以经管提出，我会在第一时间给您答复，非常感谢，我们下一个版本再见，祝您工作顺利，身体健康.....
