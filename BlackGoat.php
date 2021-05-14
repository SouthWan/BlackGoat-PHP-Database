<?php

namespace FastDataBase;

use PDO, PDOException;

include "config\black.goat.config.php";
include "config\black.goat.state.code.php";

/**
 * 数据库操作类
 * @author SouthWan(南挽)
 * @version 1.0（支持PHP7.4+）
 * @package FastDataBase
 * @internal 连接模式：PDO
 * | ------------------ 寄语 ------------------ |
 * | 一开始我想要把它做成一个高级的操作工具，但是经过数十次的尝试丝毫没有头绪
 * | 于是我重新定义了 [BlackGoat] 的核心架构，从Mybatis中学习了Sql模板，再加上
 * | BlackGoat优秀的动态配置
 * | ------------------ 以上 ------------------ |
 */
class BlackGoat
{
    /**
     * @internal 连接字符串（DSN）
     * @var string
     */
    private string $db_location;

    /**
     * @internal 数据库用户名
     * @var string
     */
    private string $db_user;

    /**
     * @internal 数据库密码
     * @var string
     */
    private string $db_pass;

    /**
     * @internal 错误信息
     * @var array
     */
    private array $db_error = array("code" => 200, "msg" => "无错误信息");

    /* + -------------- 配置层 -------------- + */

    /**
     * 构造配置信息
     */
    public function __construct()
    {
        # 引入配置文件
        $Data = include "config/black.goat.sql.config.php";
        if ($Data["db_type"] == "mysql") {
            # 加载mysql配置项
            $this->LoadConfig($Data["mysql"]);
        } else {
            $this->db_error = GOAT_CONFIG_FAIL;
        }
    }

    /**
     * 加载并解析配置项
     * @param array $config 配置项
     */
    private function LoadConfig(array $config)
    {
        # 指定数据库账号
        $this->db_user = $config["user"];
        # 指定数据库密码
        $this->db_pass = $config["pass"];
        # 连接字符串区分处理
        if ($config["host"] == null) {
            $this->db_location = $this->ConcatenationString($config["type"], $config["site"], $config["port"], $config["name"], $config["charset"]);
        } else {
            $this->db_location = $config["host"];
        }
    }

    /**
     * 拼接连接字符串
     * @param string $db_type 数据库类型
     * @param string $db_site 数据库连接地址
     * @param int $db_port 端口号
     * @param string $db_name 数据库名称
     * @param string $db_charset 数据库字符集
     * @return string 返回拼接完成的字符串
     */
    private function ConcatenationString(string $db_type, string $db_site, int $db_port, string $db_name, string $db_charset)
    {
        # 拼接 host 字符串
        $db_host = $db_site . ":" . $db_port;
        # 返回拼接完成的字符串
        return "$db_type:host=$db_host;dbname=$db_name;charset=$db_charset";
    }

    /* + -------------- 连接层 -------------- + */

    /**
     * 尝试建立连接，如果连接失败则会结束后续脚本执行
     * @return array
     */
    private function TryEstablish()
    {
        # 尝试建立连接
        try {
            # 得到PDO对象
            $DBHost = new PDO($this->db_location, $this->db_user, $this->db_pass);
            # 挂载PDO对象
            $Return = array(
                "code" => 200,
                "msg" => $DBHost
            );
        } catch (PDOException $e) {
            # 发生错误时挂载错误信息
            $Return = array(
                "code" => 300,
                "msg" => $e->getMessage()
            );
        }
        return $Return;
    }

    /* + -------------- 异常拦截处理 -------------- + */

    /**
     * 快速的错误处理
    */
    private function GoatError(){
        # 检测连接层是否存在错误
        if ($this->db_error["code"] == 200) {
            # 建立连接并返回
            $DB_Connection = $this->TryEstablish();
            # 检测是否成功连接
            $Return = $DB_Connection;
        } else {
            # 返回错误信息
            $Return = $this->db_error;
        }
        return $Return;
    }

    /* + -------------- 数据处理层 -------------- + */

    /**
     * 对数组进行序列化
     * @param array $data 需要被序列化的数组
     * @param string $type 返回值数据类型 默认关联数组 即 key (可选值key/index/all)
     * @return array
     */
    private function SerializeArray(array $data, string $type = 'key')
    {
        # 预制数据容器
        $array_data = array();
        # 提取所有的数组键值
        $keys = array_keys($data[0]);
        for ($i = 0; $i < count($data); $i++) {
            # 遍历数组
            foreach ($keys as $key) {
                if ($type == 'key') {
                    # 仅提取键
                    if (is_string($key)) {
                        $array_data[$i][$key] = $data[$i][$key];
                    }
                } elseif ($type == 'index') {
                    # 仅提取下标
                    if (is_int($key)) {
                        $array_data[$i][$key] = $data[$i][$key];
                    }
                } else {
                    $array_data[$i][$key] = $data[$i][$key];
                }
            }
        }
        # 返回序列化后的数组
        return $array_data;
    }

    /**
     * 整合数据
     * @param $data
     * @return array
     */
    private function IntegratedData($data)
    {
        # 创建数据组用于盛放查询得到的数据
        $data_array = array();
        # 创建数据盛放下标
        $index = 0;
        # 整理数据到数据组中
        foreach ($data as $row) {
            $data_array[$index] = $row;
            $index++;
        }
        # 返回整理好的数据
        return $data_array;
    }

    /* + -------------- 预处理 * 安全SQL -------------- + */

    /**
     * 所有的预处理方法都需要通过此方法
     * @param string $sql 待执行的预处理sql
     * @return array
     */
    private function Prepare(string $sql)
    {
        $Goat = $this->GoatError();
        if ($Goat["code"] == 200){
            try {
                $stmt = $Goat["msg"]->prepare($sql);
                if ($stmt != false){
                    $Return = array(
                        "code" => 200,
                        "msg" => $stmt
                    );
                }else{
                    $Return = array(
                        "code" => 300,
                        "msg" => "预处理sql失效"
                    );
                }
            }catch (PDOException $e){
                $Return = array(
                    "code" => 300,
                    "msg" => $e->getMessage()
                );
            }
        }else{
            $Return = $Goat;
        }
        return $Return;
    }

    /**
     * 执行预处理语句
     * @param string $sql 待执行的sql语句
     * @param array $param 加入的参数
     * @return array
    */
    public function PrepareExecute(string $sql,array $param){
        $Goat = $this->Prepare($sql);
        if ($Goat["code"] == 200){
            $stmt = $Goat["msg"];
            foreach (array_keys($param) as $list){
                if (is_int($list)){
                    $stmt->bindParam($list+1, $param[$list]);
                }else{
                    $stmt->bindParam($list, $param[$list]);
                }
            }
            if ($stmt->execute()){
                $Return = GOAT_SUCCEED;
            }else{
                $Return = GOAT_SUCCEED;
            }
        }else{
            $Return = $Goat;
        }
        return $Return;
    }

    /**
     * 预处理查询语句
     * @param string $sql 待执行的sql语句
     * @param array $param 加入的参数
     * @param string $type 希望得到的数据 : 默认关联数组 即 key (可选值key/index/all)
     * @return array
     */
    public function PrepareQuery(string $sql,array $param,string $type = GOAT_QUERY_DATA_TYPE)
    {
        $Goat = $this->Prepare($sql);
        if ($Goat["code"] == 200){
            $stmt = $Goat["msg"];
            foreach (array_keys($param) as $list){
                if (is_int($list)){
                    $stmt->bindParam($list+1, $param[$list]);
                }else{
                    $stmt->bindParam($list, $param[$list]);
                }
            }
            if ($stmt->execute()){
                $Return = array(
                    "code" => 200,
                    "msg" => $this->SerializeArray($this->IntegratedData($stmt->fetchAll()), $type)
                );
            }else{
                $Return = GOAT_FAIL;
            }
        }else{
            $Return = $Goat;
        }
        return $Return;
    }
}