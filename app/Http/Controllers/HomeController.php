<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Model\{Prospecto,llamada};
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProspectoResource;

class HomeController extends Controller
{

    public function index()
    {   
        //$donors = Donor::all();
        //$donations = $user->donations;
        return view('home');
            //->with('donors', $donors)
            //->with('donations', $donations);
    }

    public function store(Prospecto $prospecto)
    {

        $validator = Validator::make(request()->all(), [
            'nombre' => 'required',
            'celular' => 'required|integer',
            'email' => 'required|email',
            'estatus'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>'verifica la información',
                'errors'=> $validator->messages()
            ], 422);
        }

        $prospecto = $prospecto->create(request()->all());
 
        return response()->json([
            'message'=>'Prospecto agregado',
            'prospecto' => $prospecto,
            'errors'=> ''
        ], 200);

    }

    public function show()
    {

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $order = (request()->has('sort') && request()->sort != null) ? explode("|", request()->sort) : null;
        $nombre = $order != null ? $order[0] : 'created_at';
        $orderBy = $order != null ? $order[1] : 'DESC';

        if (request()->has('filter') && request()->filter != ''){
            $prospecto = Prospecto::where('user_id', 'like', '%' . request()->filter . '%')
            ->orderBy($nombre, $orderBy)
            ->paginate($perPage);
        } else {
            $prospecto = Prospecto::orderBy($nombre, $orderBy)->paginate($perPage);
        }

        return ProspectoResource::collection($prospecto);

    }

    public function ver(Prospecto $prospecto)
    {
        
        return view('prospectos.show')
            ->with('prospecto', $prospecto);

    }

    public function update(Request $request, Prospecto $prospecto)
    {
        $validator = Validator::make(request()->all(), [
            'nombre' => 'required',
            'celular' => 'required|integer',
            'email' => 'required|email',
            'estatus'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>'verifica la información',
                'errors'=> $validator->messages()
            ], 422);
        }

        $prospecto->update(request()->all());

        return response()->json([
            'message'=>'Se Actualizo corretamente',
            'errors'=> '',
            'prospectos' => $prospecto
        ], 200);

    }

    public function destroy(Prospecto $prospecto)
    {
        
        $prospecto->delete();
        return response()->json([
            'prospectos' => $prospecto,
            'errors'=> ''
        ], 200);

    }

}
