<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorporationInvoice extends Model
{
    protected $fillable = [
        'corporation_id',
        'invoice_id',

    ];
    protected $table = 'corporation_invoice';
    public $timestamps = true;
}
