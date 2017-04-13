<?php
/**
 * 数据库参数配置类
 *
 * @author zhjiun@gmail.com
 */
class DbConfig {

    private static $dbms = "mysql";
    private static $host = '127.0.0.1';
    private static $port = '3306'
    private static $username = 'root';
    private static $password = 'root';
    private static $dbname = 'db';
    private static $charset = 'utf8';
    private static $dsn;

    /**
     *
     * @return   返回pdo dsn配置
     */
    public static function getDsn() {
        if (!isset(self::$dsn)) {
            self::$dsn = self::$dbms . ':host=' . self::$host . ';port=' .
                    self::$port . ';dbname=' . self::$dbname;
            if (strlen(self::$charset) > 0) {
                self::$dsn = self::$dsn . ';charset=' . self::$charset;
            }
        }
        return self::$dsn;
    }
	
	public static function getUsername(){
		
		return self::$username;
	}
	
	public static function getPassword(){
		
		return self::$password;
	}

    /**
     * 设置mysql数据库服务器主机
     * @param  $host 主机的IP地址
     */
    public static function setHost($host) {
        if (isset($host) && strlen($host) > 0)
            self::$host = trim($host);
    }

    /**
     * 设置mysql数据库服务器的端口
     * @param  $port 端口
     */
    public static function setPort($port) {
        if (isset($port) && strlen($port) > 0)
            self::$port = trim($port);
    }

    /**
     * 设置mysql数据库服务器的登陆用户名
     * @param  $username
     */
    public static function setUsername($username) {
        if (isset($username) && strlen($username) > 0)
            self::$username = $username;
    }

    /**
     * 设置mysql数据库服务器的登陆密码
     * @param  $password
     */
    public static function setPassword($password) {
        if (isset($password) && strlen($password) > 0)
            self::$password = $password;
    }

    /**
     * 设置mysql数据库服务器的数据库实例名
     * @param  $dbname 数据库实例名
     */
    public static function setDbname($dbname) {
        if (isset($dbname) && strlen($dbname) > 0)
            self::$dbname = $dbname;
    }

    /**
     * 设置数据库编码
     * @param  $charset
     */
    public static function setCharset($charset) {
        if (isset($charset) && strlen($charset) > 0)
            self::$charset = $charset;
    }

}



