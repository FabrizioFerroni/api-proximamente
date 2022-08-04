<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class BajaSuscripcionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'subscripcion_id' => $this->subscripcion_id,
            'nombre' => Str::of($this->nombre)->title(),
            'email' => Str::of($this->email)->lower(),
            'fecha_baja' => $this->fecha_baja,
            'eliminado' => $this->eliminado,
            'fecha_creacion' => $this->created_at->format('d-m-y H:i:s'),
            'fecha_actualizacion' => $this->updated_at->format('d-m-y H:i:s'),
        ];
    }
    public function with($request){
        return [
            'respuesta' => true
        ];
    }
}
