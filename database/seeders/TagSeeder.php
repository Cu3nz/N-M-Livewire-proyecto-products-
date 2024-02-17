<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $tags=[
            'infantil'=>'#03a9f4',
            'multimedia'=>'#e040fb',
            'digital'=>'#ffeb3b',
            'mecanico'=>'#BDBDBD',
            'hardware'=>'#ff9800',
            'deporte'=>'#cddc39'
        ];

        foreach ($tags as $nombre => $color) {
            Tag::create(compact('nombre' , 'color'));
        }

    }
}
