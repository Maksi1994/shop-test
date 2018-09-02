<?php

namespace App\Models\Backend;

use App\Tools\Db;

class BackendBaseModel extends Db
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = $this->connectDb();
    }
}