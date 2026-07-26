<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'loan_id',
        'item_id',
        'quantity',
        'condition_on_return',
        'notes',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function item()
    {
        // PENTING: withTrashed supaya item yang sudah dihapus tetap muncul di history
        return $this->belongsTo(Item::class, 'item_id')->withTrashed();
    }
}
