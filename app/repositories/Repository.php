<?php
namespace App\Repositories;

use PDO;
use PDOException;

class Repository
{
    protected PDO $connection;

    public function __construct()
    {
        require __DIR__ . '/../config/dbconfig.php';

        try {
            if ($type === 'sqlsrv') {
                $port = $port ?? '1433';
                $encrypt = $encrypt ?? 'yes';
                $trustServerCertificate = $trustServerCertificate ?? 'no';
                $loginTimeout = $loginTimeout ?? 30;

                $dsn = "sqlsrv:Server={$servername},{$port};Database={$dbname};Encrypt={$encrypt};TrustServerCertificate={$trustServerCertificate};LoginTimeout={$loginTimeout};";
            } 
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new PDOException('Connection failed: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }
    }
}
