<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->slug,
            'db_id' => $this->id,
            'name' => $this->name,
            'shortName' => $this->short_name,
            'icon' => $this->icon,
            'accent' => "border-t-[{$this->accent_color}]",
            'accentColor' => $this->accent_color,
            'senior' => new StaffResource($this->whenLoaded('senior')),
            'staff' => StaffResource::collection($this->whenLoaded('staff')),
        ];
    }
}
