<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use App\Licencia;


class RegistroDatosController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function licencia(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'lic_id'                 => 'required|integer',
            'rut'                    => 'required',
            'lic_cod_unidad'         => 'required',
            'lic_descripcion_unidad' => 'required',
            'tipo_licencia'          => 'required',
            'id_tipo_licencia'       => 'required|integer',
            'serie'                  => 'required',
            'folio'                  => 'required',
            'fecha_licencia'         => 'required|date_format:Y-m-d',
            'fecha_desde'            => 'required|date_format:Y-m-d',
            'fecha_hasta'            => 'required|date_format:Y-m-d',
            'dias'                   => 'required',

        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Error de Validación'
            ];
            return response()->json($response, 400);
        }

        $datos_licencia = Licencia::updateOrCreate(
            [   
                'lic_id' => $input['lic_id']    
            ],
            [
                'rut'                    => $input['rut'],
                'lic_cod_unidad'         => $input['lic_cod_unidad'],
                'lic_descripcion_unidad' => $input['lic_descripcion_unidad'],
                'tipo_licencia'          => $input['tipo_licencia'],
                'id_tipo_licencia'       => $input['id_tipo_licencia'],
                'serie'                  => $input['serie'],
                'folio'                  => $input['folio'],
                'fecha_licencia'         => $input['fecha_licencia'],
                'fecha_desde'            => $input['fecha_desde'],
                'fecha_hasta'            => $input['fecha_hasta'],
                'dias'                   => $input['dias'],
            ]

        );
        $data = $datos_licencia->only(
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
        'dias');

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Licencia Registrada con éxito'
        ];

        return response()->json($response, 200);
    }

    public function borrar_licencia(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'lic_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Error de Validación'
            ];
            return response()->json($response, 400);
        }

        $datos_licencia = Licencia::where('lic_id', $input['lic_id'])->first();
        if($datos_licencia)
        {
            $datos_licencia->delete();

        $data = $datos_licencia->only(
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
        'dias');

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Licencia Borrada con éxito'
        ];

        return response()->json($response, 200);
        }else{
            $response = [
                'success' => false,
                'data' => ['lic_id' => 'El valor del campo lic id no existe'],
                'message' => 'El ID de licencia proporcionado no existe en el sistema'
            ];
            return response()->json($response, 400);
        }
        
        
    }
}
