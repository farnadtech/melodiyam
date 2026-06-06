<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Track;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Podcast;
use Illuminate\Support\Facades\Storage;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the XML sitemap';

    public function handle()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static pages
        $xml .= $this->url(url('/'), 'daily', '1.0');
        $xml .= $this->url(route('albums.index'), 'daily', '0.8');
        $xml .= $this->url(route('podcasts.index'), 'daily', '0.8');

        // Tracks
        Track::published()->chunk(100, function ($tracks) use (&$xml) {
            foreach ($tracks as $track) {
                $xml .= $this->url(route('track.show', $track), 'weekly', '0.6', $track->updated_at);
            }
        });

        // Albums
        Album::where('status', 'published')->chunk(100, function ($albums) use (&$xml) {
            foreach ($albums as $album) {
                $xml .= $this->url(route('album.show', $album), 'weekly', '0.6', $album->updated_at);
            }
        });

        // Artists
        Artist::chunk(100, function ($artists) use (&$xml) {
            foreach ($artists as $artist) {
                $xml .= $this->url(route('artist.show', $artist), 'weekly', '0.6', $artist->updated_at);
            }
        });

        // Podcasts
        Podcast::where('status', 'published')->chunk(100, function ($podcasts) use (&$xml) {
            foreach ($podcasts as $podcast) {
                $xml .= $this->url(route('podcast.show', $podcast), 'weekly', '0.6', $podcast->updated_at);
            }
        });

        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated successfully: ' . url('sitemap.xml'));
    }

    protected function url($url, $freq, $priority, $lastmod = null)
    {
        $lastmod = $lastmod ? $lastmod->toAtomString() : now()->toAtomString();
        return "<url>
            <loc>{$url}</loc>
            <lastmod>{$lastmod}</lastmod>
            <changefreq>{$freq}</changefreq>
            <priority>{$priority}</priority>
        </url>";
    }
}
