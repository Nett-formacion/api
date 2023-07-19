<?php

namespace Tests\Feature;

use App\Models\Alumno;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AlumnoApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     */

    public function test_can_get_all_alumnos(){
        $alumnos =Alumno::factory(5)->create();
        $respuesta = $this->getJson("api/alumnos");

        $respuesta->assertJsonFragment([
            'nombre'=>$alumnos[0]->nombre
        ])
        ->assertJsonFragment([
            'nombre'=>$alumnos[1]->nombre
        ])
            ->assertJsonFragment([
            'nombre'=>$alumnos[3]->nombre
        ]);

    }
    public function test_can_get_one_alumno() {
        $alumno = Alumno::factory()->create();
        $response =$this->getJson("/api/alumnos/$alumno->id");
        $response->assertJsonFragment([
            'nombre'=>$alumno->nombre
        ]);


    }

    public function test_can_create_alumno(){

        $this->postJson(route("alumnos.store",[
            'nombre'=>"Manuel",
            'email'=>"a@a.com",
            'password'=>bcrypt("12345678")
        ]))->assertJsonFragment([
            'nombre'=>"Manuel"
        ]);

        $this->assertDatabaseHas('alumnos',
            ['nombre'=>"Manuel"]);

    }
    public function test_can_update_alumno(){
        $alumno = Alumno::factory()->create();
        $this->patchJson(route("alumnos.update",$alumno),
            ['nombre'=>"ManuelModificado"]
                )->assertJsonFragment([
                    'nombre'=>"ManuelModificado"
        ]);

        $this->assertDatabaseHas('alumnos',
            ['nombre'=>"ManuelModificado"]);
    }
    public function test_can_delete(){
        $alumno = Alumno::factory()->create();
        $this->deleteJson(route("alumnos.destroy",$alumno))
            ->assertNoContent();

    }
}
