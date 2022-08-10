<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Str;


class UsuarioResource extends JsonResource
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
            'nombre' => Str::of($this->name)->title(),
            'email' => Str::of($this->email)->lower(),
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
