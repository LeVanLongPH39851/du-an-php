<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SanPhamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        //Quy định được thông tin hiển thị
        return [
            'id_san_pham' => $this->id,
            'name' => $this->ten_san_pham,
            'ma' => $this->ma_san_pham
        ];
    }
}