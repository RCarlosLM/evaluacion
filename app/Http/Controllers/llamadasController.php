<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\{Prospecto,llamada};
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\llamadasResource;

class llamadasController extends Controller
{


    public function store(llamada $llamada)
    {

        $validator = Validator::make(request()->all(), [
            'asunto' => 'required',
            'fecha' => 'required',
            'estatus'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>'verifica la información',
                'errors'=> $validator->messages()
            ], 422);
        }

        /*$llamada = $llamada->create(request()->all()+[
            'prospecto_id' => request()->prospecto,
        ]);*/
        $llamada = llamada::create([
            'asunto' => request()->asunto,
            'fecha' => date('Y-m-d', strtotime(request()->fecha)),
            'estatus' => request()->estatus,
            'prospecto_id' => request()->prospecto
        ]);
 
        return response()->json([
            'message'=>'llamada agregado',
            'llamada' => $llamada,
            'errors'=> ''
        ], 200);

    }

    public function show(Prospecto $prospecto)
    {

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $order = (request()->has('sort') && request()->sort != null) ? explode("|", request()->sort) : null;
        $asunto = $order != null ? $order[0] : 'created_at';
        $orderBy = $order != null ? $order[1] : 'DESC';

        $llamada = $prospecto->llamadas;

        return llamadasResource::collection($llamada);

    }

    public function update(Request $request, llamada $llamada)
    {
        $validator = Validator::make(request()->all(), [
            'asunto' => 'required',
            'fecha' => 'required',
            'estatus'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>'verifica la información',
                'errors'=> $validator->messages()
            ], 422);
        }

        $llamada->update([
            'asunto' => request()->asunto,
            'fecha' => date('Y-m-d', strtotime(request()->fecha)),
            'estatus' => request()->estatus,
            'prospecto_id' => request()->prospecto
        ]);

        return response()->json([
            'message'=>'Se Actualizo corretamente',
            'errors'=> '',
            'llamadas' => $llamada
        ], 200);

    }

    public function destroy(llamada $llamada)
    {
        
        $llamada->delete();
        return response()->json([
            'llamadas' => $llamada,
            'errors'=> ''
        ], 200);

    }

}
