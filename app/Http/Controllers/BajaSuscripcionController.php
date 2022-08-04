<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarBajaSuscripcionRequest;
use App\Http\Resources\BajaSuscripcionResource;
use App\Mail\BajaSub;
use App\Models\BajaSuscripcion;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BajaSuscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }


    public function index()
    {
        return BajaSuscripcionResource::collection(BajaSuscripcion::orderBy('id', 'DESC')->get());
    }

    public function create()
    {
        //
    }

    public function store(GuardarBajaSuscripcionRequest $request, $email)
    {
        $sub = Suscripcion::where('email', $email)->first();
        $now = Carbon::now();
        $eliminado = 0;

        if (!$sub) {
            return response()->json([
                "respuesta" => false,
                "mensaje" => "No se ha encontrado ningun supcriptor con ese id"
            ]);
        }

        $mail_data = [
            'nombre' => $sub->nombre,
            'email' => $sub->email,
            'fecha_sub' => $sub->fecha_sub,
            'fecha_baja' => $now->format('Y-m-d'),
        ];

        Mail::to($sub->email)->send(new BajaSub($mail_data));

        if ($eliminado == 0) {
            $sub->delete();
            $eliminado = 1;
        }

        $datos = [
            'suscripcion_id' => $sub->id,
            'nombre' => $sub->nombre,
            'email' => $sub->email,
            'fecha_baja' => $now->format('Y-m-d'),
            'eliminado' => $eliminado
        ];

        return (new BajaSuscripcionResource(BajaSuscripcion::create($datos)))->additional(['mensaje' => 'Siento mucho que te hayas arrepentido de recibir mis adelantos, no volvera a pasar']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
