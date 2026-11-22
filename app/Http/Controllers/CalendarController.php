<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getHolidays(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $holidays = [];

        // 1. DAFTAR HARI PERINGATAN TETAP (BULAN-TANGGAL) - OTOMATIS BERLAKU SEMUA TAHUN
        $calendarDatabase = [
            // JANUARI
            '01-01' => ['name' => '🎉 Tahun Baru ' . $year . ' Masehi', 'is_holiday' => true],
            '01-03' => ['name' => '📜 Hari Amal Bhakti Kementerian Agama', 'is_holiday' => false],
            '01-10' => ['name' => '🌿 Hari Sejuta Pohon Sedunia', 'is_holiday' => false],
            
            // FEBRUARI
            '02-04' => ['name' => '🎗️ Hari Kanker Sedunia', 'is_holiday' => false],
            '02-09' => ['name' => '📰 Hari Pers Nasional (HPN)', 'is_holiday' => false],
            '02-14' => ['name' => '💝 Hari Kasih Sayang (Valentine)', 'is_holiday' => false],

            // MARET
            '03-08' => ['name' => '👩 Hari Perempuan Internasional', 'is_holiday' => false],
            '03-22' => ['name' => '💧 Hari Air Sedunia', 'is_holiday' => false],
            '03-30' => ['name' => '🎬 Hari Film Nasional', 'is_holiday' => false],

            // APRIL
            '04-07' => ['name' => '🏥 Hari Kesehatan Sedunia', 'is_holiday' => false],
            '04-21' => ['name' => '🌸 Hari Kartini', 'is_holiday' => false],
            '04-22' => ['name' => '🌍 Hari Bumi Sedunia (Earth Day)', 'is_holiday' => false],

            // MEI
            '05-01' => ['name' => '✊ Hari Buruh Internasional', 'is_holiday' => true],
            '05-02' => ['name' => '📚 Hari Pendidikan Nasional (Hardiknas)', 'is_holiday' => false],
            '05-20' => ['name' => '🏛️ Hari Kebangkitan Nasional', 'is_holiday' => false],
            '05-31' => ['name' => '🚭 Hari Tanpa Tembakau Sedunia', 'is_holiday' => false],

            // JUNI
            '06-01' => ['name' => '🇮🇩 Hari Lahir Pancasila', 'is_holiday' => true],
            '06-05' => ['name' => '🌱 Hari Lingkungan Hidup Sedunia', 'is_holiday' => false],
            '06-26' => ['name' => '🚫 Hari Anti Narkoba Internasional', 'is_holiday' => false],

            // JULI
            '07-01' => ['name' => '👮 Hari Bhayangkara (HUT POLRI)', 'is_holiday' => false],
            '07-23' => ['name' => '👶 Hari Anak Nasional', 'is_holiday' => false],

            // AGUSTUS
            '08-14' => ['name' => '⛺ Hari Pramuka Nasional', 'is_holiday' => false],
            '08-17' => ['name' => '🇮🇩 Hari Kemerdekaan Republik Indonesia', 'is_holiday' => true],

            // SEPTEMBER
            '09-09' => ['name' => '🪖 Hari Olahraga Nasional (Haornas)', 'is_holiday' => false],
            '09-11' => ['name' => '📻 Hari Radio Republik Indonesia (RRI)', 'is_holiday' => false],
            '09-24' => ['name' => '🌾 Hari Tani Nasional', 'is_holiday' => false],
            '09-30' => ['name' => '🕯️ Peringatan G30S/PKI', 'is_holiday' => false],

            // OKTOBER (LENGKAP TERMASUK 22 OKTOBER)
            '10-01' => ['name' => '🕊️ Hari Kesaktian Pancasila', 'is_holiday' => false],
            '10-02' => ['name' => ' Batik Nasional', 'is_holiday' => false],
            '10-05' => ['name' => '🪖 Hari Tentara Nasional Indonesia (TNI)', 'is_holiday' => false],
            '10-10' => ['name' => '🧠 Hari Kesehatan Mental Sedunia', 'is_holiday' => false],
            '10-16' => ['name' => '🍲 Hari Pangan Sedunia', 'is_holiday' => false],
            '10-22' => ['name' => '📜 Hari Santri Nasional', 'is_holiday' => false], // <-- Tanggal 22 Oktober sekarang sudah ada!
            '10-24' => ['name' => '🌐 Hari Perserikatan Bangsa-Bangsa (PBB)', 'is_holiday' => false],
            '10-28' => ['name' => '📜 Hari Sumpah Pemuda', 'is_holiday' => false],
            '10-30' => ['name' => '💰 Hari Keuangan Nasional', 'is_holiday' => false],

            // NOVEMBER
            '11-10' => ['name' => '⚔️ Hari Pahlawan Nasional', 'is_holiday' => false],
            '11-12' => ['name' => '🦷 Hari Kesehatan Nasional', 'is_holiday' => false],
            '11-14' => ['name' => '🩸 Hari Diabetes Sedunia', 'is_holiday' => false],
            '11-25' => ['name' => '🎓 Hari Guru Nasional (PGRI)', 'is_holiday' => false],

            // DESEMBER
            '12-01' => ['name' => '🌍 Hari AIDS Sedunia', 'is_holiday' => false],
            '12-10' => ['name' => '📜 Hari Hak Asasi Manusia (HAM) Sedunia', 'is_holiday' => false],
            '12-19' => ['name' => '🗺️ Hari Bela Negara', 'is_holiday' => false],
            '12-22' => ['name' => '👩 Hari Ibu Nasional', 'is_holiday' => false],
            '12-25' => ['name' => '🎄 Hari Raya Natal', 'is_holiday' => true]
        ];

        // Masukkan data tetap ke array utama
        foreach ($calendarDatabase as $date => $info) {
            $holidays[] = [
                'holiday_date' => "{$year}-{$date}",
                'holiday_name' => $info['name'],
                'is_national_holiday' => $info['is_holiday']
            ];
        }

        // 2. AGENDA KHUSUS TAHUN 2026 (LIBUR KEAGAMAAN & KALENDER PENDIDIKAN)
        if ($year == '2026') {
            // Tanggal Merah Keagamaan 2026
            $holidays[] = ['holiday_date' => '2026-01-16', 'holiday_name' => "🕌 Isra Mi'raj Nabi Muhammad SAW", 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-02-17', 'holiday_name' => '🐉 Tahun Baru Imlek 2577 Kongzili', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-03-19', 'holiday_name' => '🧘 Hari Suci Nyepi (Tahun Baru Saka 1948)', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-03-20', 'holiday_name' => '🌙 Hari Raya Idul Fitri 1447 Hijriah', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-03-21', 'holiday_name' => '🌙 Hari Raya Idul Fitri 1447 Hijriah', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-04-03', 'holiday_name' => '✝️ Wafat Yesus Kristus (Jumat Agung)', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-04-05', 'holiday_name' => '✝️ Hari Raya Paskah', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-05-14', 'holiday_name' => '✝️ Kenaikan Yesus Kristus', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-05-27', 'holiday_name' => '🐑 Hari Raya Idul Adha 1447 Hijriah', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-05-31', 'holiday_name' => '☸️ Hari Raya Waisak 2570 BE', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-06-16', 'holiday_name' => '☪️ Tahun Baru Islam 1448 Hijriah', 'is_national_holiday' => true];
            $holidays[] = ['holiday_date' => '2026-08-25', 'holiday_name' => '☪️ Maulid Nabi Muhammad SAW', 'is_national_holiday' => true];

            // Kalender Pendidikan Sekolah 2026
            $holidays[] = ['holiday_date' => '2026-01-05', 'holiday_name' => '🏫 Masuk Efektif Semester Genap', 'is_national_holiday' => false];
            $holidays[] = ['holiday_date' => '2026-03-09', 'holiday_name' => '📝 Penilaian Tengah Semester (PTS) Genap', 'is_national_holiday' => false];
            $holidays[] = ['holiday_date' => '2026-06-08', 'holiday_name' => '📋 Penilaian Akhir Semester (PAS / Kenaikan Kelas)', 'is_national_holiday' => false];
            $holidays[] = ['holiday_date' => '2026-06-26', 'holiday_name' => '🎁 Pembagian Rapor & Libur Kenaikan Kelas', 'is_national_holiday' => false];
            $holidays[] = ['holiday_date' => '2026-07-13', 'holiday_name' => '🎒 Awal Masuk Tahun Ajaran Baru 2026/2027', 'is_national_holiday' => false];
            $holidays[] = ['holiday_date' => '2026-10-12', 'holiday_name' => '📝 Penilaian Tengah Semester (PTS) Ganjil', 'is_national_holiday' => false];
            $holidays[] = ['holiday_date' => '2026-12-07', 'holiday_name' => '📋 Penilaian Akhir Semester (PAS) Ganjil', 'is_national_holiday' => false];
            $holidays[] = ['holiday_date' => '2026-12-18', 'holiday_name' => '🎁 Pembagian Rapor Semester Ganjil', 'is_national_holiday' => false];
        }

        return response()->json($holidays);
    }
}