<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class AudioHelper
{
    /**
     * Get duration of an audio file in seconds using ffprobe.
     *
     * @param string $path Absolute path to the file
     * @return int Duration in seconds, or 0 on failure
     */
    public static function getDuration(string $path): int
    {
        if (!file_exists($path)) {
            return 0;
        }

        try {
            // Using ffprobe to get duration
            $command = "ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($path);
            $output = shell_exec($command);
            
            if ($output !== null && is_numeric(trim($output))) {
                return (int) round((float) trim($output));
            }
        } catch (\Throwable $e) {
            Log::error("Failed to get duration for {$path}: " . $e->getMessage());
        }

        return 0;
    }
}
