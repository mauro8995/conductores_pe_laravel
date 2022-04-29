<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Ticket;
use App\Models\Product\Product;

class TicketDs extends Model
{
  protected $table = 'ticket_ds';
  protected $fillable  = ['id_ticket', 'id_product','cant','price','id_money','total','status_user', 'created_at', 'modified_by'];

  public function driver(){
    return $this->belongsTo(Ticket::class);
  }
  public function getProduct()   {
    return $this->belongsTo(Product::class,     'id_product');
  }

  public function product(){
    return $this->belongsTo(Ticket::class,'id');
  }

}
