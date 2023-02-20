<?php

namespace Tests\Feature\Api\V1;

use App\Models\ZipCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZipCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testZipCodeExists()
    {
        $zipCode = ZipCode::factory()->create();
        $this->getJson('/api/zip-codes/' . $zipCode->d_codigo)
            ->assertOk()
            ->assertJsonStructure([
                'zip_code',
                'locality',
                'federal_entity',
                'settlements',
                'municipality'
            ])
            ->assertJsonPath('federal_entity.name', strtoupper($zipCode->d_estado));
    }

    public function testZipCodeDoesNotExist()
    {
        $this->getJson('/api/zip-codes/notexistingcode')
            ->assertStatus(500);
    }
}
