<?php

class UserDao
{
    private $connection;

    public function __construct($db_connection)
    {
        $this->connection = $db_connection;
    }

    public function findAll()
    {
        $request = "SELECT * FROM users";

        $stmt = $this->connection->query($request);
        $data = $stmt->fetch();
        var_dump($data);
    }
}
