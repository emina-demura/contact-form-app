<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = [];
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');
        $date = $request->input('date');
        $contacts = Contact::query();

        // keyword（名前・メール）
        if (! empty($keyword)) {
            $contacts->where(function ($q) use ($keyword) {
                $q->where('last_name', 'like', "%{$keyword}%")
                    ->orWhere('first_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }
        // gender
        if (! empty($gender) && $gender != 0) {
            $contacts->where('gender', $gender);
        }
        // category_id
        if (! empty($category_id)) {
            $contacts->where('category_id', $category_id);
        }
        // date（完全一致）
        if (! empty($date)) {
            $contacts->whereDate('created_at', $date);
        }

        // お問い合わせ一覧
        $contacts = $contacts->paginate(7);

        return view('admin.index', compact('categories', 'contacts'));

    }

    public function show(Contact $contact)
    {
        return view('admin.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.index')
            ->with('success', 'お問い合わせを削除しました。');
    }
}
