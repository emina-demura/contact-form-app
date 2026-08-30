<?php

namespace App\Http\Controllers;


use App\Http\Requests\IndexContactRequest;
use App\Models\Category;
use App\Models\Contact;


class AdminController extends Controller
{
    // お問い合わせフォーム検索機能
    public function index(IndexContactRequest $request)
    {
        $categories = Category::all();

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
        return redirect()->route('admin.contacts.index')
            ->with('success', 'お問い合わせを削除しました。');
    }
}
