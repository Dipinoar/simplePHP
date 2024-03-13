<?php

class DB {

    private static $user = '';
    private static $password = '';
    private static $dbName = '';
    private static $host = '';
    private static $port = '';

    public static function setConnectionDetails($user, $password, $dbName, $host, $port) {
        self::$user = $user;
        self::$password = $password;
        self::$dbName = $dbName;
        self::$host = $host;
        self::$port = $port;
    }

    public static function getConnection() {
        try {
            $dsn = "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbName;
            $pdo = new PDO($dsn, self::$user, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            // Manejo de errores de conexión
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function query($sql, ...$params) {
        try {
            $sql = preg_replace_callback('/%[ids]/', function($matches) {
                return '?';
            }, $sql);
            
            $conn = self::getConnection();
            $stmt = $conn->prepare($sql);
            foreach ($params as $key => &$value) {
                if (is_int($value)) {
                    $stmt->bindParam($key + 1, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindParam($key + 1, $value, PDO::PARAM_STR);
                }
            }
    
            $stmt->execute();
    
            $isSelectQuery = stripos($sql, 'SELECT') !== false;
            if ($isSelectQuery) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            die("Error de consulta: " . $e->getMessage());
        }
    }
    

    public static function queryFirstRow($sql, ...$params) {
        try {
            // Convertir los marcadores de posición %i, %s, etc., a ?
            $sql = preg_replace_callback('/%[ids]/', function($matches) {
                return '?';
            }, $sql);
            
            $conn = self::getConnection();
            $stmt = $conn->prepare($sql);
    
            foreach ($params as $key => &$value) {
                if (is_int($value)) {
                    $stmt->bindParam($key + 1, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindParam($key + 1, $value, PDO::PARAM_STR);
                }
            }
    
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            die("Error de consulta: " . $e->getMessage());
        }
    }
    
}

DB::setConnectionDetails(
        'sql10691026',
        'FqkEr6KyRC',
        'sql10691026',
        'sql10.freemysqlhosting.net',
        '3306'
    );

?>
