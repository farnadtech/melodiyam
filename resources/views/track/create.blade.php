<x-layouts.app title="آپلود آهنگ">
    <div class="max-w-2xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold text-white mb-8">آپلود آهنگ جدید</h1>

        @if(isset($isArtist) && $isArtist)
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 p-8 rounded-3xl shadow-2xl text-center mb-12 animate-in zoom-in duration-500">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white mb-3">شما هنرمند هستید!</h2>
                <p class="text-emerald-100 mb-8 max-w-sm mx-auto">شما به عنوان هنرمند ثبت‌نام کرده‌اید و باید برای آپلود و مدیریت آهنگ‌های خود از داشبورد اختصاصی هنرمندان استفاده کنید.</p>
                <a href="{{ route('artist.dashboard') }}" class="inline-flex items-center px-8 py-3 bg-white text-emerald-700 font-black rounded-full hover:bg-emerald-50 transition shadow-xl">
                    ورود به پنل هنرمندان
                </a>
            </div>
            <div class="hidden">
        @elseif(!$canUpload)
            <div class="bg-gradient-to-br from-purple-600 to-indigo-700 p-8 rounded-3xl shadow-2xl text-center mb-12 animate-in zoom-in duration-500">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-white mb-3">ارتقا به حساب ویژه</h2>
                <p class="text-purple-100 mb-8 max-w-sm mx-auto">برای انتشار آثار خود و دسترسی به امکانات نامحدود، پلن کاربری خود را ارتقا دهید.</p>
                <a href="{{ route('premium') }}" class="inline-flex items-center px-8 py-3 bg-white text-purple-700 font-black rounded-full hover:bg-purple-50 transition shadow-xl">
                    مشاهده پلن‌های اشتراک
                </a>
            </div>
            
            <div class="opacity-50 pointer-events-none grayscale">
        @endif

        <form action="{{ route('track.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="glass-card p-6 rounded-2xl space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">نام هنرمند</label>
                    <input type="text" name="artist_name" required placeholder="مثلاً: همایون شجریان" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-primary-500 outline-none">
                    @error('artist_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">عنوان آهنگ</label>
                    <input type="text" name="title" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-primary-500 outline-none">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">عنوان انگلیسی</label>
                    <input type="text" name="title_en" placeholder="مثلاً: Track Title" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-primary-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">متن آهنگ</label>
                    <textarea name="lyrics" rows="5" placeholder="متن ترانه را اینجا وارد کنید..." class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-primary-500 outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">توضیحات</label>
                    <textarea name="description" rows="2" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-primary-500 outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">ژانر</label>
                    <select name="genre_id" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-primary-500 outline-none">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name_fa }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-2xl">
                    <label class="block text-sm font-medium text-gray-400 mb-3">فایل صوتی (MP3/WAV)</label>
                    <input type="file" name="audio" accept="audio/*" required class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-500 file:text-white hover:file:bg-primary-600">
                    @error('audio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="glass-card p-6 rounded-2xl">
                    <label class="block text-sm font-medium text-gray-400 mb-3">تصویر کاور</label>
                    <input type="file" name="cover" accept="image/*" required class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-500 file:text-white hover:file:bg-primary-600">
                    @error('cover') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl transition shadow-lg">
                انتشار آهنگ
            </button>
        </form>

        @if(!$canUpload)
            </div>
        @endif
    </div>
</x-layouts.app>
