<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Card;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. สร้างบัญชีผู้ใช้สำหรับทดสอบ
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 2. เตรียมระบบไฟล์รูปภาพ (สร้างโฟลเดอร์ cards ใน storage/public)
        Storage::disk('public')->makeDirectory('cards');

        // 3. ข้อมูลการ์ดพร้อมระบุชื่อไฟล์รูปภาพ
        $cards = [
            [
                'card_name' => 'Izuku Midoriya (Deku)',
                'game_system' => 'Union Arena',
                'card_set' => 'EX06BT',
                'card_number' => 'MHA-2-026',
                'rarity' => 'SR★★',
                'condition' => 'Mint',
                'language' => 'Japanese',
                'card_type' => 'Character',
                'main_attribute' => 'Yellow',
                'grade_cost' => '8',
                'power_stats' => '5000',
                'selling_price' => 1250.00,
                'stock_quantity' => 2,
                'status' => 'Available',
                'description' => '[Impact 1] / [เมื่อลงสนาม] สามารถเลือกการ์ด [One For All] จากมือหรือดรอปโซน 1 ใบ นำไปวางใน Energy L ในสถานะ Rest',
                'image_filename' => 'deku.jpg', // ชื่อไฟล์รูปที่คุณเตรียมไว้
            ],
            [
                'card_name' => 'Cursed Queen, Nahtnaught',
                'game_system' => 'Shadowverse',
                'card_set' => 'SP-Series',
                'card_number' => 'SP-001', 
                'rarity' => 'SP',
                'condition' => 'Mint',
                'language' => 'Japanese',
                'card_type' => 'Follower',
                'main_attribute' => 'Wasteland / Commander',
                'grade_cost' => '4',
                'power_stats' => '3 / 5',
                'selling_price' => 2800.00,
                'stock_quantity' => 1,
                'status' => 'Available',
                'description' => '[Fanfare] ค้นหาการ์ดคอสต์ 1 จากเด็ค 1 ใบนำไปวางใน EX Area / [Act(0)] เลือกผู้ติดตามฝ่ายตรงข้าม 1 ใบ สั่ง Rest และทำให้อยู่ในสถานะ "ถูกกล่องขัง" จนจบเทิร์นถัดไปของผู้เล่นนั้น (เทิร์นละ 1 ครั้ง)',
                'image_filename' => 'queen.jpg',
            ],
            [
                'card_name' => 'One Who Embraces Resolve and Sin, Liel=Animus',
                'game_system' => 'Vanguard',
                'card_set' => 'DZ-BT12',
                'card_number' => 'DZ-BT12/SEC03',
                'rarity' => 'SEC',
                'condition' => 'Mint',
                'language' => 'Japanese',
                'card_type' => 'Normal Unit',
                'main_attribute' => 'Dark States / Keter Sanctuary',
                'grade_cost' => '3',
                'power_stats' => '13000',
                'selling_price' => 3500.00,
                'stock_quantity' => 3,
                'status' => 'Available',
                'description' => '[ถาวร] การ์ดนี้สามารถไรด์ทับได้เฉพาะเกรด 3 ที่มีชื่อ "Odium" หรือ "Amorta" เท่านั้น / [อัตโนมัติ] เมื่อลงสนาม เลือกเกรด 3 ที่ระบุชื่อดังกล่าวจากโซลหรือดรอป 1 ใบ การ์ดนี้จะได้รับชื่อและความสามารถทั้งหมดของการ์ดใบนั้นตลอดการต่อสู้',
                'image_filename' => 'liel.jpg',
            ]
        ];

        // 4. วนลูปบันทึกข้อมูลและจัดการไฟล์รูป
        foreach ($cards as $data) {
            $imageFilename = $data['image_filename'];
            unset($data['image_filename']); // ลบ key ชั่วคราวออกก่อนบันทึก db

            // ทางเลือก A: ถ้าคุณมีไฟล์รูปเตรียมไว้ในโฟลเดอร์ public/seed_images/
            $sourcePath = public_path('seed_images/' . $imageFilename);
            
            if (File::exists($sourcePath)) {
                // ก๊อปปี้ไฟล์ไปยัง storage/app/public/cards/
                $destinationPath = 'cards/' . $imageFilename;
                Storage::disk('public')->put($destinationPath, File::get($sourcePath));
                $data['image_path'] = $destinationPath;
            } else {
                $data['image_path'] = null; // ถ้าไม่มีไฟล์รูปให้เป็น null
            }

            Card::create($data);
        }
    }
}