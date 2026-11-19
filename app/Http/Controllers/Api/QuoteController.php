<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function getRandomQuote()
    {
        // Daftar kumpulan quote ilmuwan pilihan
        $quotes = [
            ['content' => 'Imajinasi lebih penting daripada pengetahuan. Karena pengetahuan terbatas, sedangkan imajinasi merangkul seluruh dunia.', 'author' => 'Albert Einstein'],
            ['content' => 'Tidak ada jalan yang rata untuk sukses yang gemilang.', 'author' => 'Isaac Newton'],
            ['content' => 'Satu-satunya sumber pengetahuan adalah pengalaman.', 'author' => 'Albert Einstein'],
            ['content' => 'Pendidikan adalah senjata paling ampuh untuk mengubah dunia.', 'author' => 'Nelson Mandela'],
            ['content' => 'Mulailah dari tempatmu berada, gunakan apa yang kamu miliki, dan lakukan apa yang kamu bisa.', 'author' => 'Arthur Ashe']
        ];

        // Mengambil secara acak satu quote
        $random = $quotes[array_rand($quotes)];

        return response()->json([
            'success' => true,
            'data' => $random
        ]);
    }
}
