<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoicerefund extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'inv_invoice_refunds';
}
