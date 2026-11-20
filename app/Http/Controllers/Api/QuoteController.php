<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class QuoteController extends Controller
{
    public function getRandomQuote()
    {
        // Kumpulan quote bahasa Inggris pilihan yang deep, mudah dipahami, lengkap dengan tokoh aslinya
        $quotesCollection = [
            ['content' => 'The expert in anything was once a beginner.', 'author' => 'Helen Hayes'],
            ['content' => 'The future belongs to those who prepare for it today.', 'author' => 'Malcolm X'],
            ['content' => 'In the middle of every difficulty lies opportunity.', 'author' => 'Albert Einstein'],
            ['content' => 'Act as if what you do makes a difference. It does.', 'author' => 'William James'],
            ['content' => 'The journey of a thousand miles begins with a single step.', 'author' => 'Lao Tzu'],
            ['content' => 'Education is the most powerful weapon which you can use to change the world.', 'author' => 'Nelson Mandela'],
            ['content' => 'It always seems impossible until it’s done.', 'author' => 'Nelson Mandela'],
            ['content' => 'Don’t watch the clock; do what it does. Keep going.', 'author' => 'Sam Levenson'],
            ['content' => 'You are never too old to set another goal or to dream a new dream.', 'author' => 'C.S. Lewis'],
            ['content' => 'Believe you can and you’re halfway there.', 'author' => 'Theodore Roosevelt'],
            ['content' => 'Failure is simply the opportunity to begin again, this time more intelligently.', 'author' => 'Henry Ford'],
            ['content' => 'Success is not final; failure is not fatal: It is the courage to continue that counts.', 'author' => 'Winston Churchill']
        ];

        // Mengambil satu secara acak dari daftar yang banyak di atas
        $randomQuote = $quotesCollection[array_rand($quotesCollection)];

        return response()->json([
            'success' => true,
            'data' => [
                'content' => $randomQuote['content'],
                'author'  => $randomQuote['author'],
            ]
        ]);
    }
}
