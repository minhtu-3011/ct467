<?php
    function connectdb() {
        $servername = "localhost";
        $username = "root";
        $password = "";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=ct476", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            
            return null;
        }
    }
?>