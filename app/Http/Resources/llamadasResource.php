<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class llamadasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'id' => $this->id,
            'asunto' => $this->asunto,
            'fecha' => date('d-m-Y', strtotime($this->fecha)),
            'estatus' => $this->estatus
        ];
    }
}
