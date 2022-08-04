<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarSuscripcionRequest;
use App\Http\Requests\GuardarSubcripcionRequest;
use App\Http\Resources\SuscripcionResource;
use App\Mail\SubWelcome;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SuscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    // public function __construct(Request $request)
    // {
    //     $token = $request->header('Authorization');
    //     if($token != '')
    //         //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
    //         $this->middleware('auth:api');
    // }

    public function index()
    {
        return SuscripcionResource::collection(Suscripcion::orderBy('id', 'DESC')->get());
    }

    public function store(GuardarSubcripcionRequest $request)
    {
        $now = Carbon::now();

        $mail_data = [
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'fecha_sub' =>  $now->format('Y-m-d'),
        ];

        Mail::to($request->input('email'))->send(new SubWelcome($mail_data));

        $datos = [
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'fecha_sub' => $now->format('Y-m-d')
        ];
        return (new SuscripcionResource(Suscripcion::create($datos)))->additional(['mensaje' => 'Te has suscrito con éxito a mi boletín de noticias']);
    }

    public function show(Suscripcion $suscripcion)
    {
        return (new SuscripcionResource($suscripcion))->additional(['mensaje' => 'Se ha encontrado un registro con el id buscado']);
    }

    public function update(ActualizarSuscripcionRequest $request, Suscripcion $suscripcion)
    {
        $suscripcion->update($request->all());
        return (new SuscripcionResource($suscripcion))->additional(['mensaje' => 'Subcriptor actualizado correctamente en la BD'])->response()->setStatusCode(202);
    }

    public function destroy(Suscripcion $suscripcion)
    {
        $suscripcion->delete();
        return (new SuscripcionResource($suscripcion))->additional(['mensaje' => 'Subcriptor eliminado correctamente en la BD'])->response()->setStatusCode(202);
    }

}
