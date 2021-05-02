<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CarRequest;
use App\Models\Car;
use App\Models\Manufacturer;

class CarsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Car::class);
        $cars = Car::paginate();

        return view('cars.index', ['cars' => $cars]);
    }

    public function show(Car $car)
    {
        $this->authorize('view', $car);
        $car->load(['manufacturer']);

        return view('cars.show', ['car' => $car]);
    }

    public function create()
    {
        $this->authorize('create', Car::class);
        $manufacturers = Manufacturer::all();
        $car = new Car();

        return view('cars.create', ['car' => $car, 'manufacturers' => $manufacturers]);
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

        return redirect()->route('cars.index')->with('success', 'Successfully created new instance.');
    }

    public function edit(Car $car)
    {
        $this->authorize('update', $car);
        $manufacturers = Manufacturer::all();

        return view('cars.edit', ['car' => $car, 'manufacturers' => $manufacturers]);
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

        return redirect()->route('cars.index')->with('success', 'Successfully updated instance.');
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Successfully deleted instance.');
    }
}