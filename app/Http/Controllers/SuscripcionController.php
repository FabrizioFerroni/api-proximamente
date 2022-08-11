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
use Illuminate\Support\Facades\Validator;


class SuscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    public function index()
    {
        return SuscripcionResource::collection(Suscripcion::orderBy('status', 'DESC')->orderBy('fecha_sub', 'DESC')->get());
        // return SuscripcionResource::collection(Suscripcion::withTrashed()->orderBy('status', "DESC")->get());

    }

    public function getbyID($id)
    {
        $sus = Suscripcion::find($id);
        return response()->json([
            "suscriptor" => $sus
        ], 200);
    }

    public function editSus(Request $req, $id)
    {

        $validator = Validator::make($req->all(), [
            'status' => 'required|max:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'El campo estado es obligatorio.',
            ], 404);
        }

        $sus = Suscripcion::find($id);
        $sus->status = $req->input('status');
        if ($sus->save()) {
            return response()->json([
                'mensaje' => 'Se cambio el estado con éxito'
            ], 200);
        } else {
            return response()->json([
                'mensaje' => 'Hubo un error para cambiar el estado'
            ], 400);
        }
    }

    public function store(GuardarSubcripcionRequest $request)
    {
        $now = Carbon::now();

        $mail_data = [
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'fecha_sub' =>  $now->format('d-m-Y'),
            'host' => env('HOST_DNS'),
            'url' => env('HOST_DNS'),
            'fecha' => $now->format('d/m/Y', 'America/Argentina/Cordoba'),
            'hora' => $now->format('H:i', 'America/Argentina/Cordoba'),
        ];

        $datos = [
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'fecha_sub' => $now->format('Y-m-d')
        ];

        $nsub = new SuscripcionResource(Suscripcion::create($datos));

        if ($nsub) {
            Mail::to($request->input('email'))->send(new SubWelcome($mail_data));
            return ($nsub)->additional(['mensaje' => 'Te has suscrito con éxito a mi boletín de noticias']);
        } else {
            return response()->json([
                'mensaje' => 'Hubo un error al registrar tu suscripción'
            ], 400);
        }
    }

    public function count()
    {
        return response()->json([
            "total" => count(Suscripcion::withTrashed()->get()),
        ], 200);
    }
}
