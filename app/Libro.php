<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $fillable = ["codigo", "nombre_libro", "autor_id", "editorial_id", "publicacion"];
}
