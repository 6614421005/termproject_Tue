<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cards = Card::latest()->get();

        if ($request->is('api/*')) {
            return response()->json($cards, 200);
        }

        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
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

        $card = Card::create($data);

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Created successfully',
                'data' => $card
            ], 201);
        }

        return redirect()->route('cards.index')->with('success', 'บันทึกข้อมูลการ์ดสำเร็จ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Card $card)
    {
        if ($request->is('api/*')) {
            return response()->json($card, 200);
        }

        return view('cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
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
            // ลบรูปภาพเก่าออกถ้ามีการอัปโหลดรูปใหม่
            if ($card->image_path) {
                Storage::disk('public')->delete($card->image_path);
            }
            $data['image_path'] = $request->file('image_upload')->store('cards', 'public');
        }

        $card->update($data);

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Updated successfully',
                'data' => $card
            ], 200);
        }

        return redirect()->route('cards.show', $card->id)
                         ->with('success', 'อัปเดตข้อมูลสำเร็จ!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Card $card)
    {
        // ลบรูปภาพออกจาก Storage
        if ($card->image_path) {
            Storage::disk('public')->delete($card->image_path);
        }
        
        $card->delete();

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Deleted successfully'
            ], 200);
        }

        return redirect()->route('cards.index')->with('success', 'ลบข้อมูลการ์ดเรียบร้อยแล้ว');
    }
}