<?php
class Koneksi
{
    public function DBConnect()
    {
        $dbhost = 'localhost'; // set the hostname
        $dbname = 'dpt_simpan'; // set the database name
        $dbuser = 'dpt_root'; // set the mysql username
        $dbpass = 'g0r0nt4l0';  // set the mysql password

        try {
            $dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $dbConnection->exec("set names utf8");
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return  $dbConnection;
        } catch (PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }
}
