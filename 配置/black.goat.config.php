<?php

namespace BlackGoat\config;

/**
 * BlackGoat 配置项
 * @author SouthWan
 */

/* ================  配置项部分  ================ */

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
 * 希望得到的数据类型 [关联数组(key)，下标数组(index)，关联数组+下标数组(all)]
 * 默认关联数组(key) (可选值key/index/all)
 */
defined("GOAT_QUERY_DATA_TYPE") or define("GOAT_QUERY_DATA_TYPE", "key");
