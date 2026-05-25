<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Album;
use App\Models\Track;
use App\Models\Plan;
use App\Models\Playlist;
use App\Models\HomepageSection;
use App\Models\ThemeSetting;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRolesAndPermissions();
        $this->seedUsers();
        $this->seedGenres();
        $this->seedPlans();
        $this->seedThemeSettings();
        $this->seedHomepageSections();
        $this->seedSampleMusic();
    }

    private function seedRolesAndPermissions(): void
    {
        $roles = ['admin', 'moderator', 'artist', 'listener'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $permissions = [
            'manage_users', 'manage_tracks', 'manage_albums', 'manage_artists',
            'manage_playlists', 'manage_podcasts', 'manage_subscriptions',
            'manage_ads', 'manage_settings', 'manage_themes', 'manage_pages',
            'upload_tracks', 'manage_own_tracks', 'view_analytics',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::findByName('admin')->givePermissionTo(Permission::all());
        Role::findByName('moderator')->givePermissionTo(['manage_tracks', 'manage_albums', 'manage_artists', 'manage_playlists']);
        Role::findByName('artist')->givePermissionTo(['upload_tracks', 'manage_own_tracks', 'view_analytics']);
    }

    private function seedUsers(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@melodiyam.ir'],
            [
                'name' => 'مدیر سیستم',
                'phone' => '09120000000',
                'password' => bcrypt('password'),
                'type' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Sample artists
        $artists = [
            ['name' => 'محسن چاوشی', 'phone' => '09121111111'],
            ['name' => 'سیروان خسروی', 'phone' => '09121111112'],
            ['name' => 'رضا بهرام', 'phone' => '09121111113'],
            ['name' => 'همایون شجریان', 'phone' => '09121111114'],
            ['name' => 'حامد همایون', 'phone' => '09121111115'],
            ['name' => 'مهراد هیدن', 'phone' => '09121111116'],
        ];

        foreach ($artists as $data) {
            $user = User::firstOrCreate(
                ['phone' => $data['phone']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                    'type' => 'artist',
                    'is_active' => true,
                    'phone_verified_at' => now(),
                ]
            );
            $user->assignRole('artist');

            Artist::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'display_name' => $data['name'],
                    'bio' => 'خواننده و آهنگساز ایرانی',
                    'verification_status' => 'approved',
                    'verified_at' => now(),
                    'is_featured' => true,
                    'monthly_listeners' => rand(50000, 5000000),
                    'total_streams' => rand(1000000, 100000000),
                    'followers_count' => rand(10000, 2000000),
                ]
            );
        }
    }

    private function seedGenres(): void
    {
        $genres = [
            ['name' => 'Pop', 'name_fa' => 'پاپ', 'color' => '#ec4899', 'icon' => 'music'],
            ['name' => 'Traditional', 'name_fa' => 'سنتی', 'color' => '#f59e0b', 'icon' => 'guitar'],
            ['name' => 'Rock', 'name_fa' => 'راک', 'color' => '#ef4444', 'icon' => 'bolt'],
            ['name' => 'Rap', 'name_fa' => 'رپ', 'color' => '#8b5cf6', 'icon' => 'microphone'],
            ['name' => 'Electronic', 'name_fa' => 'الکترونیک', 'color' => '#06b6d4', 'icon' => 'cpu'],
            ['name' => 'Classical', 'name_fa' => 'کلاسیک', 'color' => '#14b8a6', 'icon' => 'music-note'],
            ['name' => 'Jazz', 'name_fa' => 'جاز', 'color' => '#6366f1', 'icon' => 'sparkles'],
            ['name' => 'Folk', 'name_fa' => 'محلی', 'color' => '#84cc16', 'icon' => 'globe'],
            ['name' => 'R&B', 'name_fa' => 'آر اند بی', 'color' => '#d946ef', 'icon' => 'heart'],
            ['name' => 'Chill', 'name_fa' => 'آرام', 'color' => '#22d3ee', 'icon' => 'cloud'],
            ['name' => 'Workout', 'name_fa' => 'ورزشی', 'color' => '#f97316', 'icon' => 'fire'],
            ['name' => 'Romantic', 'name_fa' => 'عاشقانه', 'color' => '#f43f5e', 'icon' => 'heart'],
        ];

        foreach ($genres as $i => $genre) {
            Genre::firstOrCreate(
                ['name' => $genre['name']],
                array_merge($genre, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }

    private function seedPlans(): void
    {
        Plan::firstOrCreate(['slug' => 'free'], [
            'name' => 'Free', 'name_fa' => 'رایگان',
            'description' => 'Basic access', 'description_fa' => 'دسترسی پایه',
            'type' => 'free', 'price' => 0, 'duration_days' => 0,
            'features' => ['گوش دادن با تبلیغات', 'کیفیت معمولی'],
            'is_active' => true, 'sort_order' => 1,
            'max_devices' => 1, 'audio_quality' => 'normal',
            'ad_free' => false, 'offline_mode' => false, 'unlimited_skips' => false,
        ]);

        Plan::firstOrCreate(['slug' => 'premium-monthly'], [
            'name' => 'Premium Monthly', 'name_fa' => 'پریمیوم ماهانه',
            'description' => 'Full access monthly', 'description_fa' => 'دسترسی کامل ماهانه',
            'type' => 'premium', 'price' => 79000, 'duration_days' => 30,
            'features' => ['بدون تبلیغات', 'کیفیت ۳۲۰kbps', 'دانلود آفلاین', 'رد نامحدود'],
            'is_active' => true, 'is_popular' => true, 'sort_order' => 2,
            'max_devices' => 3, 'audio_quality' => 'high',
            'ad_free' => true, 'offline_mode' => true, 'unlimited_skips' => true,
        ]);

        Plan::firstOrCreate(['slug' => 'premium-yearly'], [
            'name' => 'Premium Yearly', 'name_fa' => 'پریمیوم سالانه',
            'description' => 'Full access yearly', 'description_fa' => 'دسترسی کامل سالانه',
            'type' => 'premium', 'price' => 699000, 'duration_days' => 365,
            'features' => ['بدون تبلیغات', 'کیفیت ۳۲۰kbps', 'دانلود آفلاین', 'رد نامحدود', '۲۶٪ تخفیف'],
            'is_active' => true, 'sort_order' => 3,
            'max_devices' => 5, 'audio_quality' => 'lossless',
            'ad_free' => true, 'offline_mode' => true, 'unlimited_skips' => true,
        ]);
    }

    private function seedThemeSettings(): void
    {
        $settings = [
            ['key' => 'primary_color', 'value' => '#0ea5e9', 'group' => 'colors', 'type' => 'color', 'label' => 'Primary Color', 'label_fa' => 'رنگ اصلی'],
            ['key' => 'accent_color', 'value' => '#d946ef', 'group' => 'colors', 'type' => 'color', 'label' => 'Accent Color', 'label_fa' => 'رنگ ثانویه'],
            ['key' => 'font_body', 'value' => 'YekanBakh', 'group' => 'typography', 'type' => 'text', 'label' => 'Body Font', 'label_fa' => 'فونت بدنه'],
            ['key' => 'font_heading', 'value' => 'Peyda', 'group' => 'typography', 'type' => 'text', 'label' => 'Heading Font', 'label_fa' => 'فونت عنوان'],
            ['key' => 'dark_mode_default', 'value' => 'true', 'group' => 'general', 'type' => 'boolean', 'label' => 'Dark Mode Default', 'label_fa' => 'حالت تاریک پیش‌فرض'],
            ['key' => 'site_name', 'value' => 'ملودیام', 'group' => 'general', 'type' => 'text', 'label' => 'Site Name', 'label_fa' => 'نام سایت'],
            ['key' => 'site_description', 'value' => 'پلتفرم استریم موسیقی فارسی', 'group' => 'general', 'type' => 'text', 'label' => 'Site Description', 'label_fa' => 'توضیح سایت'],
        ];

        foreach ($settings as $setting) {
            ThemeSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }

    private function seedHomepageSections(): void
    {
        $sections = [
            ['title' => 'New Releases', 'title_fa' => 'تازه‌ترین‌ها', 'type' => 'new_releases', 'sort_order' => 1],
            ['title' => 'Trending', 'title_fa' => 'پرطرفدارها', 'type' => 'trending', 'sort_order' => 2],
            ['title' => 'Featured Artists', 'title_fa' => 'هنرمندان برتر', 'type' => 'featured_artists', 'sort_order' => 3],
            ['title' => 'Genres', 'title_fa' => 'ژانرها', 'type' => 'genres', 'sort_order' => 4],
            ['title' => 'Featured Playlists', 'title_fa' => 'پلی‌لیست‌های ویژه', 'type' => 'featured_playlists', 'sort_order' => 5],
        ];

        foreach ($sections as $section) {
            HomepageSection::firstOrCreate(
                ['type' => $section['type']],
                array_merge($section, ['is_active' => true, 'config' => []])
            );
        }
    }

    private function seedSampleMusic(): void
    {
        $artists = Artist::all();
        $genres = Genre::all();

        if ($artists->isEmpty() || $genres->isEmpty()) return;

        $trackNames = [
            'دلتنگی', 'بهار', 'ستاره', 'عشق', 'رویا', 'دریا', 'آسمان',
            'ماه', 'باران', 'شب', 'فردا', 'خاطره', 'نگاه', 'آرامش',
            'امید', 'سکوت', 'فریاد', 'آخرین بار', 'با تو', 'بی تو',
        ];

        foreach ($artists as $artist) {
            // Create an album for each artist
            $album = Album::firstOrCreate(
                ['artist_id' => $artist->id, 'title' => 'آلبوم ' . $artist->display_name],
                [
                    'title_en' => 'Album by ' . $artist->display_name,
                    'type' => 'album',
                    'genre_id' => $genres->random()->id,
                    'release_date' => now()->subDays(rand(1, 365)),
                    'status' => 'published',
                    'published_at' => now()->subDays(rand(1, 30)),
                    'is_featured' => rand(0, 1),
                    'play_count' => rand(10000, 1000000),
                    'like_count' => rand(1000, 100000),
                ]
            );

            // Create tracks
            $selectedTracks = array_rand(array_flip($trackNames), rand(4, 8));
            foreach ($selectedTracks as $i => $title) {
                Track::firstOrCreate(
                    ['artist_id' => $artist->id, 'title' => $title],
                    [
                        'album_id' => $album->id,
                        'genre_id' => $genres->random()->id,
                        'title_en' => 'Track ' . ($i + 1),
                        'duration' => rand(180, 360),
                        'track_number' => $i + 1,
                        'disc_number' => 1,
                        'language' => 'fa',
                        'status' => 'published',
                        'published_at' => now()->subDays(rand(1, 60)),
                        'release_date' => now()->subDays(rand(1, 365)),
                        'is_featured' => rand(0, 1) ? true : false,
                        'play_count' => rand(5000, 5000000),
                        'like_count' => rand(500, 500000),
                        'mood' => collect(['happy', 'sad', 'energetic', 'calm', 'romantic'])->random(),
                        'bpm' => rand(60, 180),
                    ]
                );
            }
        }

        // Create featured playlists
        $playlistNames = ['بهترین‌های ایران', 'آهنگ‌های عاشقانه', 'انرژی‌بخش', 'آرامش', 'رانندگی'];
        $admin = User::where('type', 'admin')->first();
        if ($admin) {
            foreach ($playlistNames as $name) {
                $playlist = Playlist::firstOrCreate(
                    ['title' => $name, 'user_id' => $admin->id],
                    [
                        'visibility' => 'public',
                        'is_system' => true,
                        'is_featured' => true,
                        'tracks_count' => rand(10, 30),
                    ]
                );
            }
        }
    }
}
