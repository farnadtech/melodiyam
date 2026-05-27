<?php

namespace App\Helpers;

/**
 * Simple Jalali (Solar Hijri / Shamsi) date converter.
 * No external dependency — pure PHP implementation.
 */
class Jalali
{
    /**
     * Convert a Gregorian date to Jalali.
     * Returns ['year', 'month', 'day'].
     * Based on the well-known jdf algorithm (jdf.scr.ir).
     */
    public static function toJalali(int $gy, int $gm, int $gd): array
    {
        $gDM = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
        $jDM = [0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336];

        if ($gy > 1600) {
            $jy = 979;
            $gy -= 1600;
        } else {
            $jy = 0;
            $gy -= 621;
        }

        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy)
              + (int)(($gy2 + 3) / 4)
              - (int)(($gy2 + 99) / 100)
              + (int)(($gy2 + 399) / 400)
              - 80
              + $gd
              + $gDM[$gm - 1];

        $jy += 33 * (int)($days / 12053);
        $days %= 12053;

        $jy += 4 * (int)($days / 1461);
        $days %= 1461;

        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }

        $jm = ($days < 186)
            ? 1 + (int)($days / 31)
            : 7 + (int)(($days - 186) / 30);

        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));

        return ['year' => $jy, 'month' => $jm, 'day' => $jd];
    }

    /**
     * Convert a Jalali date to Gregorian.
     * Returns ['year', 'month', 'day'].
     * Based on the well-known jdf algorithm (jdf.scr.ir).
     */
    public static function toGregorian(int $jy, int $jm, int $jd): array
    {
        if ($jy > 979) {
            $gy = 1600;
            $jy -= 979;
        } else {
            $gy = 621;
        }

        $days = (365 * $jy)
              + (int)($jy / 33) * 8
              + (int)(($jy % 33 + 3) / 4)
              + 78
              + $jd
              + (($jm < 7) ? ($jm - 1) * 31 : (($jm - 7) * 30) + 186);

        $gy += 400 * (int)($days / 146097);
        $days %= 146097;

        if ($days > 36524) {
            $days--;
            $gy += 100 * (int)($days / 36524);
            $days %= 36524;
            if ($days >= 365) {
                $days++;
            }
        }

        $gy += 4 * (int)($days / 1461);
        $days %= 1461;

        if ($days > 365) {
            $gy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }

        $gd = $days + 1;
        $sal_a = [0, 31, ($gy % 4 === 0 && ($gy % 100 !== 0 || $gy % 400 === 0)) ? 29 : 28,
                  31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $gm = 0;
        for ($i = 0; $gd > $sal_a[$i + 1]; $i++) {
            $gd -= $sal_a[$i + 1];
            $gm++;
        }

        return ['year' => $gy, 'month' => $gm + 1, 'day' => $gd];
    }

    /**
     * Format a Gregorian date string (Y-m-d or Carbon) to a Jalali string.
     * Default format: Y/m/d  — supports Y, m, d tokens.
     */
    public static function format(mixed $date, string $format = 'Y/m/d'): string
    {
        if (empty($date)) return '';
        if ($date instanceof \DateTimeInterface) {
            [$gy, $gm, $gd] = [(int)$date->format('Y'), (int)$date->format('m'), (int)$date->format('d')];
        } else {
            $parts = explode('-', substr((string)$date, 0, 10));
            if (count($parts) < 3) return (string)$date;
            [$gy, $gm, $gd] = [(int)$parts[0], (int)$parts[1], (int)$parts[2]];
        }
        $j = self::toJalali($gy, $gm, $gd);
        return str_replace(
            ['Y', 'm', 'd'],
            [
                $j['year'],
                str_pad($j['month'], 2, '0', STR_PAD_LEFT),
                str_pad($j['day'],   2, '0', STR_PAD_LEFT),
            ],
            $format
        );
    }

    /**
     * Convert a Jalali date string (Y/m/d) to a Gregorian date string (Y-m-d).
     * Returns null if input is invalid.
     */
    public static function toGregorianString(string $jalaliDate): ?string
    {
        $jalaliDate = trim(str_replace('-', '/', $jalaliDate));
        $parts = explode('/', $jalaliDate);
        if (count($parts) !== 3) return null;
        [$jy, $jm, $jd] = [(int)$parts[0], (int)$parts[1], (int)$parts[2]];
        if ($jy < 1300 || $jm < 1 || $jm > 12 || $jd < 1 || $jd > 31) return null;
        $g = self::toGregorian($jy, $jm, $jd);
        return sprintf('%04d-%02d-%02d', $g['year'], $g['month'], $g['day']);
    }

    /**
     * Get Jalali month names in Persian.
     */
    public static function monthName(int $month): string
    {
        return ['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور',
                'مهر','آبان','آذر','دی','بهمن','اسفند'][$month - 1] ?? '';
    }

    /**
     * Format with Persian month name: e.g. "۱۲ اردیبهشت ۱۴۰۳"
     */
    public static function formatFull(mixed $date): string
    {
        if (empty($date)) return '';
        if ($date instanceof \DateTimeInterface) {
            [$gy, $gm, $gd] = [(int)$date->format('Y'), (int)$date->format('m'), (int)$date->format('d')];
        } else {
            $parts = explode('-', substr((string)$date, 0, 10));
            if (count($parts) < 3) return (string)$date;
            [$gy, $gm, $gd] = [(int)$parts[0], (int)$parts[1], (int)$parts[2]];
        }
        $j = self::toJalali($gy, $gm, $gd);
        return $j['day'] . ' ' . self::monthName($j['month']) . ' ' . $j['year'];
    }
}
