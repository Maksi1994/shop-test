<?php

namespace App\Models;

use App\Tools\Db;

class BaseModel extends Db
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }
}