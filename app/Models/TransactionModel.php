<?php

namespace App\Models;

use CodeIgniter\Model;


class TransactionModel extends Model
{

    protected $table = 'transactions';


    protected $primaryKey = 'id';


    protected $allowedFields = [

        'customer_id',
        'type',
        'amount',
        'description',
        'created_at'

    ];


    protected $useTimestamps = true;

}