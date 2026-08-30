<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // お問い合わせを20件作成
            $contacts = Contact::create([
                'first_name' => fake('ja_JP')->firstName(),
                'last_name' => fake('ja_JP')->lastName(),
                // genderは1:男性、2:女性、3:その他
                'gender' => fake('ja_JP')->randomElement([1, 2, 3]),
                'email' => fake('ja_JP')->unique()->safeEmail(),
                'tel' => fake('ja_JP')->unique()->phoneNumber(),
                'address' => fake('ja_JP')->address(),
                'building' => fake('ja_JP')->secondaryAddress(),
                // カテゴリを関連付ける
                'category_id' => Category::inRandomOrder()->first()->id,
                'detail' => fake('ja_JP')->text(120),
            ]);

            // タグを1〜3個ランダムで付与（仕様書の要件）
            $tags = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $contacts->tags()->attach($tags);
        }
    }
}
