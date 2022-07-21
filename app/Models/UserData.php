<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    //Disable timestamps
    public $timestamps = false;
    public $primaryKey = 'user_id';
    public $incrementing = false;
    public $table = 'user_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'photo',
        'apartment',
        'address',
        'zip_code',
        'city',
        'state',
        'country',
    ];
}
