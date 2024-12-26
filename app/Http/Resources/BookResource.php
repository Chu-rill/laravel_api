<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request); to show everything from the db 
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "author"=>$this->author,
            "description"=> $this->description,
            "borrowed"=>(bool)$this->borrowed,
            "publishedYear"=>$this->published_year
        ];
    }
}
