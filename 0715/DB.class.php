<?php

class DB
{
//    声明属性
    // 准备 服务器地址 用户名 密码 数据库名 端口   字符集  连接资源
    private $host;
    private $user;
    private $password;
    private $dbName;
    private $port;
    private $charset;
    private $link;
    //声明静态属性 来保存对象
    private static $instance = null;

    //初始化属性
    private function __construct($config = null)
    {
//        属性赋值；
        $this->host = isset($config["host"]) ? $config["host"] : "127.0.0.1";
        $this->user = isset($config["user"]) ? $config["user"] : "root";
        $this->password = isset($config["password"]) ? $config["password"] : "root";
        $this->dbName = isset($config["dbName"]) ? $config["dbName"] : "work";
        $this->port = isset($config["port"]) ? $config["port"] : 3306;
        $this->charset = isset($config["charset"]) ? $config["charset"] : "utf8";
        //自动连接数据库
        $this->connect();
        //自动设定字符集
        $this->setCharset();
    }

    //静态方法创建对象
    public static function getInstance($config = null)
    {
        //实例化DB类
        if (self::$instance == null) {
            self::$instance = new DB($config);

        }
        return self::$instance;
    }

    //连接数据库的方法
    private function connect()
    {
        $this->link = @mysqli_connect($this->host, $this->user, $this->password, $this->dbName, $this->port);
        //判定连接是否成功
        if (!$this->link) {
            exit(
                "数据库连接失败<br/>" .
                "错误信息：" . @mysqli_connect_error() . "<br/>" .
                "错误编号：" . @mysqli_connect_errno()
            );
        }
    }

    // 设定通信编码  字符集
    private function setCharset()
    {
        //设定字符集的方法
        $rst = mysqli_set_charset($this->link, $this->charset);
//        判定是否设置成功
        if (!$rst) {
            exit(
                "设置编码失败<br/>" .
                "错误信息：" . mysqli_error($this->link) . "<br/>" .
                "错误编号：" . mysqli_errno($this->link)
            );
        }
    }

    //执行sql语句的方法 query 可以执行任何的sql语句
    public function query($sql)
    {
        $rst = mysqli_query($this->link, $sql);
        //判定执行结果
        if ($rst) {
            return $rst;
        } else {
            exit(
                "执行sql语句失败<br/>" .
                "错误信息：" . mysqli_error($this->link) . "<br/>" .
                "错误编号：" . mysqli_errno($this->link)."<br/>".
                "错误SQL：".$sql
            );
        }
    }

    //声明一个方法 返回所有数据
    public function fetchAll($sql)
    {
        //调用已有的方法 取得执行的结果
        $rst = $this->query($sql);
        //取得所有数据
        $rows = mysqli_fetch_all($rst, MYSQLI_ASSOC);
        if ($rows) {
            return $rows;
        } else {
            return [];
        }
    }

    //取得数据结果中的第一条数据
    public function fetchRow($sql)
    {
        //调用取得所有数据的方法
        $rows = $this->fetchAll($sql);
        if ($rows) {
            return $rows[0];
        } else {
            return null;
        }
    }

    //取得第一行第一列的数据
    public function fetchColumn($sql)
    {
        //取得第一行的数据
        $row = $this->fetchRow($sql);
        if ($row) {
            return array_shift($row);
        } else {
            return null;
        }
    }

    //私有化克隆
    private function __clone()
    {

    }

    //析构函数
    public function __destruct()
    {

    }

}
