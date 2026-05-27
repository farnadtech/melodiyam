<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ArtistApplication;
use App\Models\ArtistApplicationField;
use Illuminate\Http\Request;

class ArtistApplicationController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // اگر قبلاً هنرمند یا ادمین است
        if (!$user->isListener()) {
            return redirect()->route('artist.dashboard');
        }

        $application = ArtistApplication::where('user_id', $user->id)->first();
        $fields      = ArtistApplicationField::activeFields();

        return view('artist-application.show', compact('application', 'fields'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isListener()) {
            return redirect()->route('artist.dashboard');
        }

        // بررسی درخواست موجود
        $existing = ArtistApplication::where('user_id', $user->id)->first();
        if ($existing && in_array($existing->status, ['pending', 'reviewing'])) {
            return back()->with('error', 'شما یک درخواست در انتظار بررسی دارید.');
        }

        $fields = ArtistApplicationField::activeFields();

        // ساخت validation rules پویا
        $rules = [];
        foreach ($fields as $field) {
            $rule = $field->required ? 'required' : 'nullable';
            $rules["field_{$field->key}"] = match ($field->type) {
                'file'     => $rule . '|file|max:5120',
                'url'      => $rule . '|url',
                'number'   => $rule . '|numeric',
                'checkbox' => 'required|accepted',
                default    => $rule . '|string|max:1000',
            };
        }

        $validated = $request->validate($rules);

        // پردازش داده‌ها
        $data = [];
        foreach ($fields as $field) {
            $inputKey = "field_{$field->key}";

            if ($field->type === 'file' && $request->hasFile($inputKey)) {
                $path = $request->file($inputKey)->store("artist-applications/{$user->id}", 'public');
                $data[$field->key] = $path;
            } elseif ($field->type === 'checkbox') {
                $data[$field->key] = $request->boolean($inputKey);
            } else {
                $data[$field->key] = $request->input($inputKey);
            }
        }

        if ($existing) {
            $existing->update(['data' => $data, 'status' => 'pending', 'admin_note' => null]);
        } else {
            ArtistApplication::create([
                'user_id' => $user->id,
                'data'    => $data,
                'status'  => 'pending',
            ]);
        }

        return back()->with('success', 'درخواست شما با موفقیت ثبت شد. پس از بررسی نتیجه به شما اعلام می‌شود.');
    }
}
