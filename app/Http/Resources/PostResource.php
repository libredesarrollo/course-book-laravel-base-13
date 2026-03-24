<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //  return [
        //     'id' => $this->id,
        //     'titulo_post' => $this->title, // Renombrado para el cliente (Abstracción)
        //     'resumen' => $this->description,
        //     'contenido' => $this->content,
        //     'fecha' => $this->created_at->format('d-m-Y'),
        //     // Incluye la relación solo si ha sido cargada (Eficiencia)
        //     'categoria' => new CategoryResource($this->whenLoaded('category')),
        // ];
         return [
            'id' => $this->id,
            'title' => $this->title, 
            'slug' => $this->slug, 
            'description' => $this->description,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'fecha' => $this->created_at->format('d-m-Y'),
            // Incluye la relación solo si ha sido cargada (Eficiencia)
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
        // return parent::toArray($request);
    }
}
