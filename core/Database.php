<?php
class Database {
    private static $conn = null;

    public static function getConnection() {
        if (!self::$conn) {
            $host = 'localhost';
            $dbname = 'car_rental';
            $username = 'root';
            $password = '';

            try {
                self::$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$conn;
    }
}
?>
