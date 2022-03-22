<?php  

return [

    // Daftar wilker
	'wilker' => [
        'Besar' => 'Stasiun Karantina Pertanian Kelas I Sumbawa Besar',
        'Tano' => 'Wilker Pelabuhan Ferry Poto Tano',
        'Benete' => 'Wilker Pelabuhan Laut Benete',
        'Badas' => 'Wilker Pelabuhan Laut Badas',
        'Kaharuddin' => 'Wilker Bandara Sultan Muhammad Kaharuddin',
        'Kempo' => 'Wilker Pelabuhan Laut Soro Kempo',
        'M.Salahuddin' => 'Wilker Bandara M. Salahudin',
        'Bima' => 'Wilker Pelabuhan Laut Bima',
        'Sape' => 'Wilker Pelabuhan Penyeberangan Sape',
        'Induk' => 'Laboratorium Induk'
    ],

    // handle perbedaan nama wilker pada database dan laporan excel
    'wilker_except' => [
        'original' => 'Wilker Bandara Sultan M.Salahuddin',
        'replacement' => 'Wilker Bandara M. Salahudin'
    ],

    // tambahkan nama kolom pada file excel laporan disini
    // agar tidak ikut ter upload ke dalam database (exclude) 
    'guard' => [
        'nama_wilker' => 'nama_wilker',
        'no_voyage_terakhir' => 'no_voyage_terakhir'
    ],

    // Handle url untuk data users
    'url' => [
        'user-management' => env('APP_BASE_URL') . '/' . env('APP_USER_API_URL') . (env('APP_ENV') == 'local' ? '/public' : '') .'/login/e-office'
    ]
];

