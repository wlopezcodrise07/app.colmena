<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
  protected $table      = "forma_pago";
  protected $guarded    = ['id'];
}
