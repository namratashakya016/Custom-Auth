<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
        protected $table = 'qrcodes';
        protected $fillable = ['user_id', 'data'];
        // Define the inverse relationship to User
        public function user()
        {
                return $this->belongsTo(User::class);
        }
}
