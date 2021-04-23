<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    protected $table = 'licencias';

    protected $fillable = [
        'lic_id',
        'rut',
        'lic_cod_unidad',
        'lic_descripcion_unidad',
        'tipo_licencia',
        'id_tipo_licencia',
        'serie',
        'folio',
        'fecha_licencia',
        'fecha_desde',
        'fecha_hasta',
        'dias'
    ];
}
