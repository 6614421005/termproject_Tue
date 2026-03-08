<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                🎴 คลังการ์ดทั้งหมด
            </h2>
            {{-- 1. ซ่อนปุ่มเพิ่มการ์ดใหม่จาก Guest --}}
            @auth
                <a href="{{ route('cards.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    เพิ่มการ์ดใหม่
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-100 shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 sm:rounded-2xl border border-slate-100">
                <div class="p-0 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">รูปภาพ</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">รหัสการ์ด</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">ชื่อการ์ด</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">สถานะ</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">ราคา</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">สต็อก</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">จัดการ</th>
                            </tr>
                        </thead>
                        {{-- ใช้ divide-white 4px เพื่อคั่นแบ่งแต่ละแถวไม่ให้สีกลืนติดกัน --}}
                        <tbody class="divide-y-4 divide-white">
                            @forelse($cards as $card)
                                @php
                                    // กำหนด Class แบบเต็มตัวอักษร เพื่อให้ Tailwind ทำงานได้ 100%
                                    $style = match ($card->game_system) {
                                        'Vanguard' => [
                                            'bg_row' => 'bg-rose-50 hover:bg-rose-100/80',
                                            'badge' => 'bg-rose-600',
                                            'status_text' => 'text-rose-600',
                                            'status_border' => 'border-rose-200',
                                            'dot' => 'bg-rose-500',
                                            'price_bg' => 'bg-rose-100',
                                            'price_text' => 'text-rose-800',
                                            'btn_eye' => 'text-rose-500 border-rose-200 hover:bg-rose-100',
                                        ],
                                        'Union Arena' => [
                                            'bg_row' => 'bg-amber-50 hover:bg-amber-100/80',
                                            'badge' => 'bg-amber-600',
                                            'status_text' => 'text-amber-600',
                                            'status_border' => 'border-amber-200',
                                            'dot' => 'bg-amber-500',
                                            'price_bg' => 'bg-amber-100',
                                            'price_text' => 'text-amber-800',
                                            'btn_eye' => 'text-amber-500 border-amber-200 hover:bg-amber-100',
                                        ],
                                        'Shadowverse' => [
                                            'bg_row' => 'bg-emerald-50 hover:bg-emerald-100/80',
                                            'badge' => 'bg-emerald-600',
                                            'status_text' => 'text-emerald-600',
                                            'status_border' => 'border-emerald-200',
                                            'dot' => 'bg-emerald-500',
                                            'price_bg' => 'bg-emerald-100',
                                            'price_text' => 'text-emerald-800',
                                            'btn_eye' => 'text-emerald-500 border-emerald-200 hover:bg-emerald-100',
                                        ],
                                        default => [
                                            'bg_row' => 'bg-slate-50 hover:bg-slate-100/80',
                                            'badge' => 'bg-slate-600',
                                            'status_text' => 'text-slate-600',
                                            'status_border' => 'border-slate-200',
                                            'dot' => 'bg-slate-500',
                                            'price_bg' => 'bg-slate-200',
                                            'price_text' => 'text-slate-800',
                                            'btn_eye' => 'text-slate-500 border-slate-200 hover:bg-slate-100',
                                        ],
                                    };
                                @endphp

                                {{-- 🎯 พื้นหลังแถวเป็นสีตามเกม (bg_row) และมี Animation ตอน Hover --}}
                                <tr class="group {{ $style['bg_row'] }} transition-colors duration-150">
                                    <td class="px-6 py-4 text-center">
                                        <div class="relative inline-block">
                                            @if($card->image_path)
                                                <img src="{{ asset('storage/' . $card->image_path) }}"
                                                    class="h-16 w-12 object-contain rounded-md shadow-md border-2 border-white transform group-hover:scale-110 transition-transform">
                                            @else
                                                <div class="h-16 w-12 bg-white rounded-md border border-slate-200 flex items-center justify-center text-slate-300 shadow-inner">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono text-slate-500 font-medium">{{ $card->card_number }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-black text-slate-800">{{ $card->card_name }}</div>
                                        <div class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest {{ $style['badge'] }} text-white shadow-sm">
                                            {{ $card->game_system }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- 🎯 ป้ายสถานะแบบมีจุดกลมและขอบสีตามเกม --}}
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm bg-white {{ $style['status_text'] }} border {{ $style['status_border'] }}">
                                            <span class="w-2 h-2 mr-2 rounded-full {{ $style['dot'] }} animate-pulse"></span>
                                            {{ $card->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{-- 🎯 ป้ายราคาแบบกลมมน สีอ่อน --}}
                                        <span class="text-sm font-black px-3 py-1.5 rounded-xl {{ $style['price_bg'] }} {{ $style['price_text'] }} shadow-sm">
                                            ฿{{ number_format($card->selling_price, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-bold text-slate-700 bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                                            {{ $card->stock_quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            {{-- ปุ่มดูรายละเอียด (ดึงสีตามค่ายเกม) --}}
                                            <a href="{{ route('cards.show', $card->id) }}"
                                                class="p-2.5 bg-white rounded-xl shadow-sm border {{ $style['btn_eye'] }} transition-all transform hover:-translate-y-0.5" title="ดูรายละเอียด">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>

                                            {{-- 2. ซ่อนปุ่มแก้ไขและลบจาก Guest --}}
                                            @auth
                                                {{-- ปุ่มแก้ไข (สีส้ม Amber) --}}
                                                <a href="{{ route('cards.edit', $card->id) }}"
                                                    class="p-2.5 bg-white text-amber-500 hover:bg-amber-50 rounded-xl shadow-sm border border-amber-200 transition-all transform hover:-translate-y-0.5"
                                                    title="แก้ไข">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                {{-- ปุ่มลบ (สีแดง Rose) --}}
                                                <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบการ์ดใบนี้?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 bg-white text-rose-500 hover:bg-rose-50 rounded-xl shadow-sm border border-rose-200 transition-all transform hover:-translate-y-0.5" title="ลบ">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                            </div>
                                            <span class="text-slate-500 text-sm font-medium">ยังไม่มีข้อมูลการ์ดในระบบ</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>