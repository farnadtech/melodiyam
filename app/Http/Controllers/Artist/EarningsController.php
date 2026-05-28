<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EarningsController extends Controller
{
    private function artistOrAbort()
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');
        return $artist;
    }

    public function index(): View
    {
        $artist = $this->artistOrAbort();
        return view('artist.earnings', compact('artist'));
    }
}
