<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexContactRequest;
use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // お問い合わせフォーム画面
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            return redirect()
                ->route('contacts.index')
                ->withInput();
        }
        $categories = Category::all();
        $tags = Tag::all();

        return view('contacts.index', compact('categories', 'tags'));
    }

    // 入力内容の確認画面
    public function confirm(Request $request)
    {
        $inputs = $request->all();

        return view('contacts.confirm', compact('inputs'));
    }

    // お問い合わせ内容の保存
    public function store(StoreContactRequest $request)
    {
        Contact::create($request->all());

        return redirect()->route('contacts.thanks');
    }

    // お問い合わせ完了画面
    public function thanks()
    {
        return view('contacts.thanks');
    }

    // お問い合わせ詳細画面
    public function show(Contact $contact)
    {
        $contact->load('contact', 'category', 'tags');

        return view('contacts.show', compact('contact'));
    }

    // お問い合わせ検索機能
    public function search(IndexContactRequest $request)
    {
        $query = Contact::query();

        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%'.$request->input('last_name').'%');
        }

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%'.$request->input('first_name').'%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->input('email').'%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $contacts = $query->paginate(10);

        return view('contacts.index', compact('contacts'));
    }
}
