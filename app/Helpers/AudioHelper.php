<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class AudioHelper
{
    /**
     * Get duration of an audio file in seconds.
     * Uses ffprobe if available, otherwise falls back to a basic MP3 header parser.
     *
     * @param string $path Absolute path to the file
     * @return int Duration in seconds, or 0 on failure
     */
    public static function getDuration(string $path): int
    {
        if (!file_exists($path)) {
            return 0;
        }

        // Method 1: Try FFprobe (Best accuracy)
        try {
            $command = "ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($path);
            $output = shell_exec($command);
            
            if ($output !== null && is_numeric(trim($output))) {
                return (int) round((float) trim($output));
            }
        } catch (\Throwable $e) {
            // FFprobe not available or failed
        }

        // Method 2: Internal Fallback (Pure PHP)
        // This is a simplified MP3 duration detector based on bitrate and file size.
        // It's not 100% accurate for VBR files but works without server dependencies.
        try {
            return self::estimateMp3Duration($path);
        } catch (\Throwable $e) {
            Log::error("Failed to estimate duration for {$path}: " . $e->getMessage());
        }

        return 0;
    }

    /**
     * Generate waveform peaks for an audio file.
     *
     * @param string $path Absolute path to the file
     * @param int $samples Number of peak points to generate
     * @return array Array of normalized peaks (0.0 to 1.0)
     */
    public static function generateWaveform(string $path, int $samples = 200): array
    {
        if (!file_exists($path)) {
            return [];
        }

        try {
            $tempFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'wave_' . uniqid() . '.raw';
            
            // Extract raw 8-bit PCM, mono, 1000Hz sample rate
            // This is fast and gives us enough data to compute peaks
            $command = "ffmpeg -v error -i " . escapeshellarg($path) . " -f s8 -ac 1 -ar 1000 -y " . escapeshellarg($tempFile);
            shell_exec($command);

            if (!file_exists($tempFile) || filesize($tempFile) === 0) {
                return [];
            }

            $data = file_get_contents($tempFile);
            @unlink($tempFile);

            $bytes = unpack('c*', $data);
            $totalBytes = count($bytes);
            if ($totalBytes === 0) return [];

            $blockSize = (int) floor($totalBytes / $samples);
            if ($blockSize <= 0) $blockSize = 1;

            $peaks = [];
            for ($i = 0; $i < $samples; $i++) {
                $segment = array_slice($bytes, $i * $blockSize, $blockSize);
                if (empty($segment)) {
                    $peaks[] = 0;
                    continue;
                }
                
                $sum = 0;
                foreach ($segment as $b) {
                    $sum += abs($b);
                }
                $peaks[] = $sum / count($segment);
            }

            $max = max($peaks);
            if ($max <= 0) return array_fill(0, $samples, 0.1);

            return array_map(fn($p) => round($p / $max, 3), $peaks);

        } catch (\Throwable $e) {
            Log::error("Waveform generation failed for {$path}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Estimates MP3 duration by reading the first few frames.
     */
    private static function estimateMp3Duration(string $path): int
    {
        $fd = fopen($path, "rb");
        if (!$fd) return 0;

        $metadata_size = 0;
        $data = fread($fd, 10);
        
        // Skip ID3v2 tag
        if (substr($data, 0, 3) == "ID3") {
            $metadata_size = ((ord($data[6]) & 0x7f) << 21) | ((ord($data[7]) & 0x7f) << 14) | ((ord($data[8]) & 0x7f) << 7) | (ord($data[9]) & 0x7f);
            $metadata_size += 10;
            fseek($fd, $metadata_size);
        } else {
            rewind($fd);
        }

        // Find first sync frame (0xFF 0xFB/0xFA/0xF3/0xF2)
        $frame = fread($fd, 4);
        while (!feof($fd) && (ord($frame[0]) != 0xFF || (ord($frame[1]) & 0xE0) != 0xE0)) {
            $frame = substr($frame, 1) . fread($fd, 1);
        }

        if (feof($fd)) {
            fclose($fd);
            return 0;
        }

        // Extract bitrate from frame header
        $thirdByte = ord($frame[2]);
        $bitrateIndex = ($thirdByte & 0xF0) >> 4;
        $version = (ord($frame[1]) & 0x18) >> 3; // 3=V1, 2=V2

        // Bitrate table for MP3 (Layer 3)
        $bitrates = [
            3 => [0, 32, 40, 48, 56, 64, 80, 96, 112, 128, 160, 192, 224, 256, 320, 0], // V1
            2 => [0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0],    // V2
        ];

        $bitrate = $bitrates[$version][$bitrateIndex] ?? 128; // Default 128kbps
        fclose($fd);

        $fileSize = filesize($path) - $metadata_size;
        if ($fileSize <= 0) return 0;

        // Duration (s) = (FileSize (bytes) * 8) / Bitrate (bps)
        return (int) round(($fileSize * 8) / ($bitrate * 1000));
    }
}
