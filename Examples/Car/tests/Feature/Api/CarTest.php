<?php

namespace Tests\Feature\Api;

use App\Models\Car;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Shomisha\Crudly\Exceptions\IncompleteTestException;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    public function createAndAuthenticateUser() : User
    {
        $user = User::factory()->create();
        $this->be($user);

        return $user;
    }

    private function getCarData(array $override = []) : array
    {
        if (!array_key_exists('manufacturer_id', $override)) {
            $override['manufacturer_id'] = Manufacturer::factory()->create()->id;
        }

        return array_merge(['model' => 'Nam vel magni expedita quaerat sit.', 'production_year' => 98964, 'first_registration_date' => '1985-03-23', 'horse_power' => 9381], $override);
    }

    private function authorizeUser(User $user) : void
    {
        throw IncompleteTestException::provideUserAuthorization();
    }

    private function deauthorizeUser(User $user) : void
    {
        throw IncompleteTestException::provideUserDeauthorization();
    }

    private function getIndexRoute() : string
    {
        throw IncompleteTestException::missingRouteGetter('index');
    }

    private function getShowRoute(Car $car) : string
    {
        throw IncompleteTestException::missingRouteGetter('show');
    }

    private function getStoreRoute() : string
    {
        throw IncompleteTestException::missingRouteGetter('store');
    }

    private function getUpdateRoute(Car $car) : string
    {
        throw IncompleteTestException::missingRouteGetter('update');
    }

    private function getDestroyRoute(Car $car) : string
    {
        throw IncompleteTestException::missingRouteGetter('destroy');
    }

    private function getForceDeleteRoute(Car $car) : string
    {
        throw IncompleteTestException::missingRouteGetter('force-delete');
    }

    private function getRestoreRoute(Car $car) : string
    {
        throw IncompleteTestException::missingRouteGetter('restore');
    }

    /**
     * @test
     */
    public function user_can_get_a_list_of_cars()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $cars = Car::factory()->count(5)->create();
        $response = $this->get(route('cars.index'));
        $response->assertStatus(200);
        $responseCarIds = collect($response->json('data'))->pluck('id');
        $this->assertCount($cars->count(), $responseCarIds);
        foreach ($cars as $car) {
            $this->assertContains($car->id, $responseCarIds);
        }
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_get_the_cars_list()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $response = $this->get(route('cars.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function user_can_get_single_car()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $car = Car::factory()->create();
        $response = $this->get(route('cars.show', $car));
        $response->assertStatus(200);
        $responseCarId = $response->json('data.id');
        $this->assertEquals($car->id, $responseCarId);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_get_single_car()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $car = Car::factory()->create();
        $response = $this->get(route('cars.show', $car));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function user_can_create_cars()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $data = $this->getCarData([]);
        $response = $this->post(route('cars.store'), $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('cars', []);
    }

    public function invalidCarDataProvider()
    {
        return ['Model is not a string' => ['model', false], 'Model is missing' => ['model', null], 'Manufacturer id is not an integer' => ['manufacturer_id', 'not an integer'], 'Manufacturer id is missing' => ['manufacturer_id', null], 'Production year is not an integer' => ['production_year', 'not an integer'], 'First registration date is not a date' => ['first_registration_date', 'not a date'], 'Horse power is not an integer' => ['horse_power', 'not an integer']];
    }

    /**
     * @test
     * @dataProvider invalidCarDataProvider
     */
    public function user_cannot_create_new_cars_using_invalid_data(string $field, $value)
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $data = $this->getCarData([$field => $value]);
        $response = $this->post(route('cars.store'), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
        $this->assertDatabaseCount('cars', 0);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_create_new_cars()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $data = $this->getCarData([]);
        $response = $this->post(route('cars.store'), $data);
        $response->assertForbidden();
        $this->assertDatabaseCount('cars', 0);
    }

    /**
     * @test
     */
    public function user_can_update_cars()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $car = Car::factory()->create([]);
        $data = $this->getCarData([]);
        $response = $this->put(route('cars.update', $car), $data);
        $response->assertStatus(204);
        $car->refresh();
    }

    /**
     * @test
     * @dataProvider invalidCarDataProvider
     */
    public function user_cannot_update_cars_using_invalid_data(string $field, $value)
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $car = Car::factory()->create([]);
        $data = $this->getCarData([$field => $value]);
        $response = $this->put(route('cars.update', $car), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
        $car->refresh();
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_update_cars()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $car = Car::factory()->create([]);
        $data = $this->getCarData([]);
        $response = $this->put(route('cars.update', $car), $data);
        $response->assertForbidden();
        $car->refresh();
    }

    /**
     * @test
     */
    public function user_can_delete_cars()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $car = Car::factory()->create();
        $response = $this->delete(route('cars.destroy', $car));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_delete_cars()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $car = Car::factory()->create();
        $response = $this->delete(route('cars.destroy', $car));
        $response->assertForbidden();
        $this->assertDatabaseHas('cars', ['id' => $car->id]);
    }
}