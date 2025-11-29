<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about',
                'title' => 'About Handshake',
                'content' => '<h1>About Handshake</h1><p>Handshake is a modern bartering platform that connects people who want to trade goods and services. Our mission is to make trading easy, safe, and fun.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'terms',
                'title' => 'Terms and Conditions',
                'content' => '<h1>Terms and Conditions</h1><p>By using Handshake, you agree to the following terms...</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'privacy',
                'title' => 'Privacy Policy',
                'content' => '<h1>Privacy Policy</h1><p>We respect your privacy and are committed to protecting your personal data...</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'faq',
                'title' => 'Frequently Asked Questions',
                'content' => '<h1>FAQ</h1><h2>How does bartering work?</h2><p>You list items you have and want to trade...</p>',
                'is_published' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::create($pageData);
        }
    }
}
