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
        return BajaSuscripcionResource::collection(BajaSuscripcion::orderBy('fecha_baja', 'DESC')->get());
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

        if ($eliminado == 0) {
            $sub->status = 0;
            $sub->save();
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

        $nbaja = new BajaSuscripcionResource(BajaSuscripcion::create($datos));

        if($nbaja){
            Mail::to($sub->email)->send(new BajaSub($mail_data));
            return ($nbaja)->additional(['mensaje' => 'Siento mucho que te hayas arrepentido de recibir mis adelantos, no volvera a pasar']);
        } else{
            return response()->json([
                'mensaje' => 'Hubo un error al registrar tu baja'
            ], 400);
        }
    }

    public function count()
    {
        return response()->json([
            "total" => count(BajaSuscripcion::get()),
        ], 200);
    }
}
