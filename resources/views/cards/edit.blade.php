<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 tracking-tight flex items-center">
                <span class="w-1.5 h-7 bg-amber-500 mr-3 rounded-full shadow-lg shadow-amber-200"></span>
                EDIT CARD: {{ $card->card_name }}
            </h2>
            <a href="{{ route('cards.index') }}" class="text-xs font-bold text-slate-400 hover:text-amber-600 transition-colors">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('cards.update', $card->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden flex flex-col md:flex-row items-stretch">
                    
                    <div class="md:w-[380px] bg-slate-50/50 p-10 border-r border-slate-100 flex flex-col items-center">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 self-start">Card Image</h3>
                        
                        <div class="relative w-full aspect-[3/4.2] bg-white rounded-3xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center p-6 text-center group hover:border-amber-400 hover:bg-amber-50/30 transition-all cursor-pointer shadow-sm overflow-hidden">
                            <input type="file" name="image_upload" id="image_upload" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(event)">
                            <img id="preview" src="{{ $card->image_path ? asset('storage/' . $card->image_path) : '' }}" class="{{ $card->image_path ? '' : 'hidden' }} absolute inset-0 w-full h-full object-contain rounded-2xl p-4">
                            <div id="placeholder" class="{{ $card->image_path ? 'hidden' : '' }} flex flex-col items-center">
                                <div class="p-5 bg-amber-50 rounded-2xl mb-4 shadow-sm"><svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></div>
                                <span class="text-sm font-bold text-slate-600">Change Image</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 p-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-7">
                            
                            <div class="col-span-full mb-2">
                                <h3 class="text-[11px] font-black text-amber-600 uppercase tracking-[0.3em] flex items-center">
                                    General Info
                                    <span class="ml-4 h-px bg-slate-100 flex-1"></span>
                                </h3>
                            </div>

                            <div class="col-span-full">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">ชื่อการ์ด</label>
                                <input type="text" name="card_name" value="{{ $card->card_name }}" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none" required>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">CardGame</label>
                                <select name="game_system" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none" required>
                                    <option value="Vanguard" {{ $card->game_system == 'Vanguard' ? 'selected' : '' }}>Cardfight!! Vanguard</option>
                                    <option value="Union Arena" {{ $card->game_system == 'Union Arena' ? 'selected' : '' }}>Union Arena</option>
                                    <option value="Shadowverse" {{ $card->game_system == 'Shadowverse' ? 'selected' : '' }}>Shadowverse Evolve</option>
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Card Number</label>
                                <input type="text" name="card_number" value="{{ $card->card_number }}" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-mono font-bold outline-none" required>
                            </div>

                            <div class="col-span-full mt-6 mb-2">
                                <h3 class="text-[11px] font-black text-amber-600 uppercase tracking-[0.3em] flex items-center">
                                    Card Info
                                    <span class="ml-4 h-px bg-slate-100 flex-1"></span>
                                </h3>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">รหัส</label>
                                <input type="text" name="card_set" value="{{ $card->card_set }}" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">เรทการ์ด</label>
                                <input type="text" name="rarity" value="{{ $card->rarity }}" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">สภาพการ์ด</label>
                                <input type="text" name="condition" value="{{ $card->condition }}" placeholder="เช่น Mint, NM, สภาพดี..." class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">การ์ดภาษา</label>
                                <input type="text" name="language" value="{{ $card->language }}" placeholder="เช่น Japanese, English..." class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">ชนิดของการ์ด</label>
                                <input type="text" name="card_type" value="{{ $card->card_type }}" placeholder="เช่น Unit, Follower..." class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">แคลน/ประเทศ</label>
                                <input type="text" name="main_attribute" value="{{ $card->main_attribute }}" placeholder="เช่น Yellow, Dark, Forest..." class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">เกรด/คอส</label>
                                <input type="text" name="grade_cost" value="{{ $card->grade_cost }}" placeholder="เช่น 3, 4, 8..." class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Power / Stats</label>
                                <input type="text" name="power_stats" value="{{ $card->power_stats }}" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none">
                            </div>

                            <div class="col-span-full">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">ความสามารถ</label>
                                <textarea name="description" rows="4" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-4 text-sm font-medium focus:ring-4 focus:ring-amber-500/10 outline-none transition-all">{{ $card->description }}</textarea>
                            </div>

                            <div class="col-span-full mt-6 mb-2">
                                <h3 class="text-[11px] font-black text-amber-600 uppercase tracking-[0.3em] flex items-center">
                                    Pricing & Inventory
                                    <span class="ml-4 h-px bg-slate-100 flex-1"></span>
                                </h3>
                            </div>

                            <div class="md:col-span-full">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">ราคา (฿)</label>
                                <input type="number" step="0.01" name="selling_price" value="{{ $card->selling_price }}" class="w-full bg-white border-amber-100 rounded-2xl px-5 py-3.5 text-xl font-black text-amber-600 focus:ring-4 focus:ring-amber-500/10 shadow-sm outline-none" required>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">จำนวนในStock</label>
                                <input type="number" name="stock_quantity" value="{{ $card->stock_quantity }}" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none" required>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5 ml-1">สถานะ</label>
                                <select name="status" class="w-full bg-slate-50 border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold outline-none" required>
                                    <option value="Available" {{ $card->status == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Out of Stock" {{ $card->status == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                                    <option value="Pre-order" {{ $card->status == 'Pre-order' ? 'selected' : '' }}>Pre-order</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-14 pt-8 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('cards.index') }}" class="px-10 py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black text-xs uppercase tracking-[0.2em] rounded-2xl transition-all">
                                ละทิ้ง
                            </a>
                            <button type="submit" class="px-10 py-4 bg-amber-500 hover:bg-amber-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-amber-500/20 transform transition-all hover:-translate-y-1 active:scale-95 flex items-center">
                                อัพเดต
                                <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>