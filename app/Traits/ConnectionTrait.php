<?php

namespace App\Traits;

use LaravelLiberu\Multitenancy\Enums\Connections;

trait ConnectionTrait
{
    public function setConnection($conn = 'mysql', $db = 'genealogy')//'liberu')
    {
        if ($conn === Connections::Tenant) {
            $key = 'database.connections.tenant.database';
            config([$key => $db]);
        }
        \Session::put('conn', $conn);
        \Session::put('db', $db);
    }

    public function getConnection()
    {
        $conn = \Session::get('conn');
        $db = \Session::get('db');
        if ($conn === 'tenant') {
            $key = 'database.connections.tenant.database';
            $value = $db;
            config([$key => $value]);
        }

        return $conn;
    }

    public function getDB()
    {
        return \Session::get('db');
    }
}
