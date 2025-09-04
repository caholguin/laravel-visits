<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitStoreRequest;
use App\Http\Requests\VisitUpdateRequest;
use App\Http\Resources\VisitResource;
use App\Models\Visit;


class ApiVisitController extends Controller
{
    public function index()
    {
        $visits = Visit::query()->latest('id')->paginate(20);
        return VisitResource::collection($visits);
    }

    public function store(VisitStoreRequest $request)
    {
        $visit = Visit::create($request->validated());
        return new VisitResource($visit);
    }

    public function show(Visit $visit)
    {
        return new VisitResource($visit);
    }

    public function update(VisitUpdateRequest $request, Visit $visit)
    {
        $visit->update($request->validated());
        return new VisitResource($visit);
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return response()->json(['message' => 'Eliminado']);
    }
  
}
