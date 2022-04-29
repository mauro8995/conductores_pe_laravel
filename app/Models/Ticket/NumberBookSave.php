<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class NumberBookSave extends Model
{
  protected $table = 'number_book_saves';
  protected $fillable  = ['number_book','modified_by'];
}
