<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;// อนุญาตให้ฟิลด์เหล่านี้รับข้อมูลจากฟอร์มได้โดยตรง
    protected $fillable = [
        'card_name',
        'game_system',
        'card_set',
        'card_number',
        'rarity',
        'condition',
        'language',
        'card_type',
        'main_attribute',
        'grade_cost',
        'power_stats',
        'selling_price',
        'stock_quantity',
        'status',
        'description',
        'image_path',
    ];
}