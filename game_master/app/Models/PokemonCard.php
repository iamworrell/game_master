<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokemonCard extends Model
{
    // Manually specify the table name (optional if it matches Laravel's convention)
    protected $table = 'pokemon_cards';

    // Specify fillable fields for mass assignment
    protected $fillable = [
        'pokemon_name',
        'pokemon_type',
        'hit_points',
        'moveset',
    ];

    // protected $casts makes Laravel treat the moveset JSON column as a 
    // PHP array when accessed (and encode it when saving)
    protected $casts = [
        'moveset' => 'array',
    ];
}
