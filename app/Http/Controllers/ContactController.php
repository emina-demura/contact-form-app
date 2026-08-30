<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;

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
}
