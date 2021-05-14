<?php

namespace FastDataBase\config;

/**
 * 数据库状态码模板(不建议更改)
 * @author SouthWan
 */

/*
 * ----------------------------
 * <code> 值说明
 * 100+ 表示100到199这个区间的值
 * ----------------------------
 * 100+ 不存在、未知、不确定的
 * 200 成功(200+仅有200一个值)
 * 300+ 异常、发生错误
 * 400+ 警告、不建议的行为
 * ----------------------------
 **/

/* ================  配置项部分  ================ */

/**
 * 执行成功时返回
*/
defined("GOAT_SUCCEED") or define("GOAT_SUCCEED",array(
    "code" => 200,
    "msg" => "成功"
));

/**
 * 执行失败时返回
*/
defined("GOAT_FAIL") or define("GOAT_FAIL",array(
    "code" => 300,
    "msg" => "失败"
));

/**
 * 加载配置项失败时返回
*/
defined("GOAT_CONFIG_FAIL") or define("GOAT_CONFIG_FAIL",array(
    "code" => 100,
    "msg" => "配置项不存在，请检查配置项是否存在"
));

/**
 * 执行语句后未发现任何影响时返回
 */
defined("GOAT_EXEC_INVALID") or define("GOAT_EXEC_INVALID",array(
    "code" => 400,
    "msg" => "语句被执行成功但未发生任何影响"
));