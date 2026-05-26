<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageSectionsSeeder extends Seeder
{
    public function run(): void
    {
        HomepageSection::truncate();

        $sections = [
            [
                'title'      => 'Hero Banner',
                'title_fa'   => 'بنر اصلی',
                'slug'       => 'hero-banner',
                'type'       => 'hero',
                'sort_order' => 1,
                'is_active'  => true,
                'config'     => [
                    'hero_title'    => 'موسیقی بی‌پایان با ملودیام',
                    'hero_subtitle' => 'میلیون‌ها آهنگ، پادکست و پلی‌لیست. هر لحظه، هر جا، هر دستگاه.',
                    'hero_btn1_label' => 'شروع رایگان',
                    'hero_btn1_url'   => '/premium',
                    'hero_btn2_label' => 'مرور موسیقی',
                    'hero_btn2_url'   => '/browse',
                ],
            ],
            [
                'title'      => 'New Releases',
                'title_fa'   => 'تازه‌ترین‌ها',
                'slug'       => 'new-releases',
                'type'       => 'new_releases',
                'sort_order' => 2,
                'is_active'  => true,
                'config'     => ['limit' => 6, 'columns' => 6, 'layout' => 'grid', 'sort_by' => 'release_date', 'show_see_all' => true, 'see_all_url' => '/browse'],
            ],
            [
                'title'      => 'Trending',
                'title_fa'   => 'پرطرفدارها',
                'slug'       => 'trending',
                'type'       => 'trending',
                'sort_order' => 3,
                'is_active'  => true,
                'config'     => ['limit' => 6, 'columns' => 6, 'layout' => 'grid', 'sort_by' => 'play_count', 'show_see_all' => true, 'see_all_url' => '/browse'],
            ],
            [
                'title'      => 'Top Charts',
                'title_fa'   => 'چارت برتر',
                'slug'       => 'top-charts',
                'type'       => 'top_charts',
                'sort_order' => 4,
                'is_active'  => true,
                'config'     => ['limit' => 10, 'period' => 30],
            ],
            [
                'title'      => 'Featured Artists',
                'title_fa'   => 'هنرمندان برتر',
                'slug'       => 'featured-artists',
                'type'       => 'featured_artists',
                'sort_order' => 5,
                'is_active'  => true,
                'config'     => ['limit' => 8, 'columns' => 8, 'featured_only' => true],
            ],
            [
                'title'      => 'Genres',
                'title_fa'   => 'ژانرها',
                'slug'       => 'genres',
                'type'       => 'genres',
                'sort_order' => 6,
                'is_active'  => true,
                'config'     => ['limit' => 12, 'columns' => 6],
            ],
            [
                'title'      => 'Latest Albums',
                'title_fa'   => 'آلبوم‌های جدید',
                'slug'       => 'latest-albums',
                'type'       => 'latest_albums',
                'sort_order' => 7,
                'is_active'  => true,
                'config'     => ['limit' => 6, 'columns' => 6, 'sort_by' => 'release_date'],
            ],
            [
                'title'      => 'Featured Playlists',
                'title_fa'   => 'پلی‌لیست‌های ویژه',
                'slug'       => 'featured-playlists',
                'type'       => 'featured_playlists',
                'sort_order' => 8,
                'is_active'  => true,
                'config'     => ['limit' => 6, 'columns' => 6, 'featured_only' => true],
            ],
        ];

        foreach ($sections as $data) {
            HomepageSection::create($data);
        }

        $this->command->info('✅ ' . count($sections) . ' homepage sections seeded.');
    }
}
