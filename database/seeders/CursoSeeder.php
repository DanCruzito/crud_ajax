<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $curso1 = Curso::create([
            'nombre_curso' => 'LARAVEL',
            'descripcion' => 'CURSO LARAVEL 2023'
        ]);

        $curso2 = Curso::create([
            'nombre_curso' => 'ANGULAR',
            'descripcion' => 'CURSO ANGULAR 2024'
        ]);
    }
}
