<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sectore extends Model
{
    public static function getNumeroSectorMenu($menu)
    {
        return sectore::where("menu", "=", $menu)->first()->sector;
    }
    public static function getNumeroSectorEmpleado($empleado)
    {
        return sectore::where("empleado", "=", $empleado)->first()->sector;
    }
}
