<?php
namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class VisitResource extends JsonResource
{
/** @return array<string,mixed> */
public function toArray(Request $request): array
{
return [
'id' => $this->id,
'name' => $this->name,
'email' => $this->email,
'latitude' => (float) $this->latitude,
'longitude' => (float) $this->longitude,
'created_at' => $this->created_at?->toISOString(),
'updated_at' => $this->updated_at?->toISOString(),
];
}
}