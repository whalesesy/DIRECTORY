<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'ext' => $this->ext,
        ];

        if ($this->is_senior) {
            $data['email'] = $this->email;
            $data['message'] = $this->office_message;
        }

        return $data;
    }
}
