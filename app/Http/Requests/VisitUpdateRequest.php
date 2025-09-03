<?php
namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class VisitUpdateRequest extends FormRequest
{
public function authorize(): bool { return true; }


public function rules(): array
{
return [
    'name' => ['sometimes','string','max:255'],
    'email' => ['sometimes','email','max:255'],
    'latitude' => ['sometimes','numeric','between:-90,90'],
    'longitude' => ['sometimes','numeric','between:-180,180'],
];
}
}