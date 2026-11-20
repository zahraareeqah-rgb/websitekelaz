<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class FactController extends Controller
{
    public function getRandomFact()
    {
        $factsList = [
            'Tahukah kamu? Cahaya matahari yang kita lihat dan rasakan setiap hari di bumi sebenarnya membutuhkan waktu sekitar 8 menit 20 detik untuk menempuh perjalanan luar angkasa sejauh 150 juta kilometer sebelum akhirnya sampai ke permukaan bumi.',
            'Tahukah kamu? Lidah manusia ternyata memiliki keunikan yang mirip seperti sidik jari tangan. Setiap orang di dunia ini memiliki pola cetakan dan tekstur garis lidah yang sepenuhnya berbeda satu sama lain.',
            'Tahukah kamu? Secara klasifikasi botani ilmiah, buah pisang ternyata termasuk ke dalam kategori buah berry karena tumbuh dari bunga dengan ovarium tunggal. Sebaliknya, buah stroberi justru bukan termasuk buah berry.',
            'Tahukah kamu? Madu murni adalah satu-satunya jenis makanan alami di bumi yang memiliki ketahanan luar biasa dan tidak akan pernah basi atau membusuk meskipun disimpan selama ribuan tahun.',
            'Tahukah kamu? Dalam hal kekuatan fisik berdasarkan rasio ukuran otot, otot rahang manusia memegang rekor sebagai salah satu otot terkuat yang mampu menghasilkan kekuatan gigitan hingga ratusan kilogram.',
            'Tahukah kamu? Planet Venus memiliki keunikan arah rotasi yang berlawanan dengan sebagian besar planet lain di tata surya kita. Di Venus, matahari terbit di sebelah barat dan terbenam di sebelah timur.',
            'Tahukah kamu? Tubuh manusia dewasa sebenarnya terdiri dari sekitar 60% air, dan otak manusia sendiri mengandung sekitar 73% air yang membuatnya sangat sensitif terhadap dehidrasi.',
            'Tahukah kamu? Pohon bambu Jepang memiliki masa pertumbuhan yang unik di mana pada beberapa tahun pertama akarnya tumbuh sangat kuat di dalam tanah sebelum akhirnya batangnya melesat tinggi dalam hitungan minggu.'
        ];

        $randomFact = $factsList[array_rand($factsList)];

        return response()->json([
            'success' => true,
            'data' => [
                'fact' => $randomFact
            ]
        ]);
    }
}
