<?php

namespace App\Console\Commands;

use App\Models\Track;
use App\Models\PodcastEpisode;
use App\Helpers\AudioHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateWaveforms extends Command
{
    protected $signature = 'waveforms:generate {--force : Re-generate even if already exists}';
    protected $description = 'Generate waveform peaks for tracks and podcast episodes';

    public function handle()
    {
        $force = $this->option('force');

        $this->info('Generating waveforms for tracks...');
        $tracks = Track::when(!$force, function ($q) {
            return $q->whereNull('waveform');
        })->get();

        foreach ($tracks as $track) {
            $filePath = $track->file_path_320 ?: $track->file_path;
            if (!$filePath) {
                $this->warn("No file path for track: {$track->title}");
                continue;
            }
            $path = Storage::disk('public')->path($filePath);
            if (file_exists($path)) {
                $this->line("Processing track: {$track->title}");
                $waveform = AudioHelper::generateWaveform($path);
                if (!empty($waveform)) {
                    $track->update(['waveform' => $waveform]);
                }
            } else {
                $this->warn("File not found for track: {$track->title} at {$path}");
            }
        }

        $this->info('Generating waveforms for podcast episodes...');
        $episodes = PodcastEpisode::when(!$force, function ($q) {
            return $q->whereNull('waveform');
        })->get();

        foreach ($episodes as $episode) {
            $filePath = $episode->file_path;
            if (!$filePath) {
                $this->warn("No file path for episode: {$episode->title}");
                continue;
            }
            $path = Storage::disk('public')->path($filePath);
            if (file_exists($path)) {
                $this->line("Processing episode: {$episode->title}");
                $waveform = AudioHelper::generateWaveform($path);
                if (!empty($waveform)) {
                    $episode->update(['waveform' => $waveform]);
                }
            } else {
                $this->warn("File not found for episode: {$episode->title} at {$path}");
            }
        }

        $this->info('Waveform generation completed.');
    }
}
