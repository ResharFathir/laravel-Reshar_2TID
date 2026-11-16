<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['payment_due_at' => 'datetime']; }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function shipment() { return $this->hasOne(Shipment::class); }
}
