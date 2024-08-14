<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        "first_name",
        "last_name",
        "topic_url",
        "group",
        "generation",
    ];

    protected $casts = [
        "first_name" => 'string',
        "last_name" => 'string',
        "topic_url" => 'string',
        "group" => 'string',
        'generation' => 'integer',
    ];

    public function name(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
