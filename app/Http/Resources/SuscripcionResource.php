<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;


class SuscripcionResource extends JsonResource
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
            'nombre' => Str::of($this->nombre)->title(),
            'email' => Str::of($this->email)->lower(),
            'fecha_subcripcion' => Str::of($this->fecha_sub)->title(),
            'fecha_creacion' => $this->created_at->format('d-m-y H:i:s'),
            'fecha_actualizacion' => $this->updated_at->format('d-m-y H:i:s'),
            // 'fecha_baja' => $this->deleted_at->format('d-m-y H:i:s'),
            'estado' => $this->status,
        ];
    }
    public function with($request){
        return [
            'respuesta' => true
        ];
    }
}
