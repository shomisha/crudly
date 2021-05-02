<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;

class CarsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Car::class);
        $cars = Car::paginate();

        return CarResource::collection($cars);
    }

    public function show(Car $car)
    {
        $this->authorize('view', $car);
        $car->load(['manufacturer']);

        return new CarResource($car);
    }

    public function store(CarRequest $request)
    {
        $this->authorize('create', Car::class);
        $car = new Car();
        $car->model = $request->input('model');
        $car->manufacturer_id = $request->input('manufacturer_id');
        $car->production_year = $request->input('production_year');
        $car->first_registration_date = $request->input('first_registration_date');
        $car->horse_power = $request->input('horse_power');
        $car->save();

        return new CarResource($car);
    }

    public function update(CarRequest $request, Car $car)
    {
        $this->authorize('update', $car);
        $car->model = $request->input('model');
        $car->manufacturer_id = $request->input('manufacturer_id');
        $car->production_year = $request->input('production_year');
        $car->first_registration_date = $request->input('first_registration_date');
        $car->horse_power = $request->input('horse_power');
        $car->update();

        return response()->noContent();
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);
        $car->delete();

        return response()->noContent();
    }
}