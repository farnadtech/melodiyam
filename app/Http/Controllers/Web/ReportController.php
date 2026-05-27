<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Report;
use App\Models\Track;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:track,album',
            'id'          => 'required|integer',
            'reason'      => 'required|in:' . implode(',', array_keys(Report::$reasons)),
            'description' => 'required|string|min:10|max:1000',
        ]);

        $model = match($request->type) {
            'track' => Track::findOrFail($request->id),
            'album' => Album::findOrFail($request->id),
        };

        $userId = auth()->id();
        $type   = get_class($model);

        // بررسی شکایت pending موجود از همین محتوا
        $existing = Report::where('user_id', $userId)
            ->where('reportable_type', $type)
            ->where('reportable_id', $model->id)
            ->whereIn('status', ['pending', 'reviewed'])
            ->exists();

        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'شما قبلاً برای این محتوا شکایت فعال دارید.'], 422);
            }
            return back()->with('report_error', 'شما قبلاً برای این محتوا شکایت فعال دارید.');
        }

        Report::create([
            'user_id'          => $userId,
            'reportable_type'  => $type,
            'reportable_id'    => $model->id,
            'reason'           => $request->reason,
            'description'      => $request->description,
            'status'           => 'pending',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('report_success', 'شکایت شما با موفقیت ثبت شد.');
    }
}
