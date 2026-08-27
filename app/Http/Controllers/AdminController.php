<?php

namespace App\Http\Controllers;
use App\Models\Contact;

class AdminController extends Controller
{
    public function index()
    {
        // カテゴリー一覧
        $categories = [];  

        // お問い合わせ一覧
        $contacts = Contact::paginate(10);    
        
        return view('admin.index', compact('categories', 'contacts'));
    }

}
