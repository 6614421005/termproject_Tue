<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Guest และ User เข้าดูได้ปกติ)
     */
    public function index()
    {
        $cards = Card::latest()->get();
        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     * (ต้อง Login เท่านั้น - คุมโดย web.php)
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     * (ต้อง Login เท่านั้น - คุมโดย web.php)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'card_name' => 'required|string|max:255',
            'game_system' => 'required|string',
            'card_set' => 'nullable|string',
            'card_number' => 'required|string',
            'rarity' => 'nullable|string',
            'condition' => 'nullable|string',
            'language' => 'nullable|string',
            'card_type' => 'nullable|string',
            'main_attribute' => 'nullable|string',
            'grade_cost' => 'nullable|string',
            'power_stats' => 'nullable|string',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image_upload')) {
            $data['image_path'] = $request->file('image_upload')->store('cards', 'public');
        }

        Card::create($data);

        return redirect()->route('cards.index')->with('success', 'บันทึกข้อมูลการ์ดสำเร็จ');
    }

    /**
     * Display the specified resource.
     * (Guest และ User เข้าดูได้ปกติ)
     */
    public function show(string $id)
    {
        $card = Card::findOrFail($id);
        return view('cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     * (ต้อง Login เท่านั้น - คุมโดย web.php)
     */
    public function edit(string $id)
    {
        $card = Card::findOrFail($id);
        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     * (ต้อง Login เท่านั้น - คุมโดย web.php)
     */
    public function update(Request $request, string $id)
    {
        $card = Card::findOrFail($id);

        $data = $request->validate([
            'card_name' => 'required|string|max:255',
            'game_system' => 'required|string',
            'card_set' => 'nullable|string',
            'card_number' => 'required|string',
            'rarity' => 'nullable|string',
            'condition' => 'nullable|string',
            'language' => 'nullable|string',
            'card_type' => 'nullable|string',
            'main_attribute' => 'nullable|string',
            'grade_cost' => 'nullable|string',
            'power_stats' => 'nullable|string',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image_upload')) {
            if ($card->image_path) {
                Storage::disk('public')->delete($card->image_path);
            }
            $data['image_path'] = $request->file('image_upload')->store('cards', 'public');
        }

        $card->update($data);

        return redirect()->route('cards.show', $card->id)
                         ->with('success', 'อัปเดตข้อมูลสำเร็จ!');
    }

    /**
     * Remove the specified resource from storage.
     * (ต้อง Login เท่านั้น - คุมโดย web.php)
     */
    public function destroy(string $id)
    {
        $card = Card::findOrFail($id);
        
        if ($card->image_path) {
            Storage::disk('public')->delete($card->image_path);
        }
        
        $card->delete();

        return redirect()->route('cards.index')->with('success', 'ลบข้อมูลการ์ดเรียบร้อยแล้ว');
    }
}