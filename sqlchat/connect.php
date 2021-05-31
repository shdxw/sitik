<?php

function connect(): PDO
{
    $host='localhost';
    $db = 'sit';
    $user = 'postgres';
    $password = 'password';
    try {
        $dsn = "pgsql:host=$host;port=5432;dbname=$db;";

        //соединение с бд
        return new PDO(
            $dsn,
            $user,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die($e->getMessage());
    } finally {
        echo '+';//глупый индикатор
    }
}

return connect();
