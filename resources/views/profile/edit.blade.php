<x-layouts.app title="ویرایش پروفایل">
<div class="p-4 lg:p-8 max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">ویرایش پروفایل</h1>
        <p class="text-sm text-surface-500 mt-1">مشخصات و آواتار خود را به‌روزرسانی کنید</p>
    </div>

    @if(session('success'))
    <div class="rounded-xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 text-sm mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Profile Info Form -->
    <div class="glass-card rounded-2xl p-6 mb-6">
        <h2 class="font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            اطلاعات شخصی
        </h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Avatar -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <img id="avatar-preview" src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                         class="w-20 h-20 rounded-full object-cover border-2 border-surface-200 dark:border-surface-700">
                    <label for="avatar" class="absolute -bottom-1 -right-1 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center cursor-pointer hover:bg-primary-600 transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812-1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="document.getElementById('avatar-preview').src = URL.createObjectURL(this.files[0])">
                </div>
                <div>
                    <p class="font-medium text-surface-900 dark:text-white">آواتار</p>
                    <p class="text-xs text-surface-500">PNG, JPG تا ۲MB</p>
                </div>
            </div>

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">نام</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">ایمیل</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">موبایل</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <!-- Bio -->
            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">درباره من</label>
                <textarea name="bio" rows="3" maxlength="500"
                          class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-surface-500 mt-1">حداکثر ۵۰۰ کاراکتر</p>
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-xl transition-colors">
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>

    <!-- Password Change Form -->
    <div class="glass-card rounded-2xl p-6">
        <h2 class="font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            تغییر رمز عبور
        </h2>

        <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">رمز عبور فعلی</label>
                <input type="password" name="current_password" required
                       class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">رمز عبور جدید</label>
                <input type="password" name="password" required minlength="8"
                       class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">تکرار رمز عبور جدید</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="px-6 py-2.5 bg-surface-600 hover:bg-surface-700 dark:bg-surface-700 dark:hover:bg-surface-600 text-white font-medium rounded-xl transition-colors">
                    تغییر رمز عبور
                </button>
            </div>
        </form>
    </div>

</div>
</x-layouts.app>
