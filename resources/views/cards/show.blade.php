<x-app-layout>
    @php
        // 1. กำหนดธีมสีตามระบบเกม
        $theme = match ($card->game_system) {
            'Vanguard' => 'rose',
            'Union Arena' => 'amber',
            'Shadowverse' => 'emerald',
            default => 'slate',
        };
    @endphp

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-slate-800 tracking-tight flex items-center">
                <span class="w-1.5 h-6 bg-{{ $theme }}-500 mr-3 rounded-full shadow-[0_0_10px_rgba(0,0,0,0.1)]"></span>
                CARD DETAILS
            </h2>
            <a href="{{ route('cards.index') }}"
                class="group flex items-center text-xs font-bold text-slate-400 hover:text-{{ $theme }}-600 transition-all">
                <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                BACK TO LIST
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white rounded-2xl shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden flex flex-col md:flex-row items-stretch">

                <div class="md:w-[320px] bg-slate-50/80 p-8 flex flex-col items-center border-r border-slate-100">
                    <div class="sticky top-10 flex flex-col items-center">
                        <div class="relative group">
                            <div
                                class="absolute -inset-1 bg-{{ $theme }}-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition duration-500">
                            </div>
                            @if($card->image_path)
                                <img src="{{ asset('storage/' . $card->image_path) }}"
                                    class="relative w-52 h-auto object-contain rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-4 border-white transform transition-transform duration-500 hover:scale-[1.03]">
                            @else
                                <div
                                    class="relative w-48 h-64 bg-white rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center">
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No
                                        Image</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8">
                            <span
                                class="px-4 py-1.5 rounded-lg bg-{{ $theme }}-600 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-{{ $theme }}-500/30">
                                {{ $card->game_system }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex-1 p-10">
                    <div class="mb-8">
                        <h1 class="text-3xl font-black text-slate-900 leading-none tracking-tight mb-2">
                            {{ $card->card_name }}</h1>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-mono font-bold text-slate-400">ID: {{ $card->card_number }}</span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span
                                class="text-xs font-black text-{{ $theme }}-500 uppercase tracking-widest">{{ $card->rarity }}</span>
                        </div>
                    </div>

                    <div
                        class="mb-8 p-5 bg-gradient-to-br from-{{ $theme }}-500 to-{{ $theme }}-600 rounded-2xl shadow-xl shadow-{{ $theme }}-500/20 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-black/10 rounded-lg">
                                <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-bold uppercase text-slate-900/70">Market Price</span>
                        </div>
                        <span
                            class="text-3xl font-black tracking-tight text-slate-900">฿{{ number_format($card->selling_price, 2) }}</span>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-px bg-slate-200 border border-slate-200 rounded-xl overflow-hidden mb-8">
                        @php
                            $details = [
                                'Set' => $card->card_set,
                                'เรทการ์ด' => $card->rarity,
                                'สภาพการ์ด' => $card->condition,
                                'การ์ดภาษา' => $card->language,
                                'ชนิดการ์ด' => $card->card_type,
                                'ประเทศ/สี/แคลน' => $card->main_attribute,
                                'เกรด/คอร์ส' => $card->grade_cost,
                                'พลัง' => $card->power_stats ?? '-',
                                'สถานะ' => $card->status,
                                'จำนวน' => $card->stock_quantity . ' Pcs.'
                            ];
                        @endphp

                        @foreach($details as $label => $value)
                            <div class="bg-white p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 sm:mb-0">{{ $label }}</span>
                                <span class="text-sm font-bold text-slate-700">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="relative group mb-10">
                        <div class="absolute -left-4 top-0 bottom-0 w-1 bg-{{ $theme }}-500 rounded-full opacity-50">
                        </div>
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-2">ความสามารถ</h3>
                        <div
                            class="p-6 bg-slate-900 text-slate-200 rounded-2xl leading-relaxed text-sm font-medium shadow-inner whitespace-pre-wrap italic">
                            {{ $card->description ?? 'No extra text provided.' }}
                        </div>
                    </div>

                    @auth
                        <div class="mt-12 pt-8 border-t border-slate-100 flex justify-end gap-3">
                            <a href="{{ route('cards.edit', $card->id) }}"
                                class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white text-xs font-black rounded-xl shadow-lg shadow-amber-500/30 transform transition-all hover:-translate-y-1 active:scale-95">
                                EDIT Card
                            </a>
                            <form action="{{ route('cards.destroy', $card->id) }}" method="POST"
                                onsubmit="return confirm('Confirm Deletion?');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="px-8 py-3 bg-white text-rose-500 border border-rose-100 hover:bg-rose-50 text-xs font-black rounded-xl shadow-sm transition-all active:scale-95">
                                    DELETE
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</x-app-layout>