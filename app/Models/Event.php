<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'location',
        'event_date',
        'image_path',
        'price',
        'capacity',
        'status',
        'user_id'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2'
    ];

    public static function categories()
    {
        return [
            'cultura' => 'Cultura y Tradiciones',
            'turismo' => 'Turismo y Naturaleza',
            'arte' => 'Arte y Espectáculos',
            'gastronomia' => 'Gastronomía',
            'educacion' => 'Educación y Talleres',
            'deportes' => 'Deportes y Aventura',
            'nocturna' => 'Vida Nocturna y Entretenimiento',
            'social' => 'Social y Comunitario',
            'religioso' => 'Religioso y Espiritual',
            'negocios' => 'Negocios y Tecnología'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}
