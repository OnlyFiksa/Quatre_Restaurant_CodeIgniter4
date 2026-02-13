<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menu';           // Nama tabel di database
    protected $primaryKey       = 'id_menu';        // Primary key tabel tersebut
    
    // Agar id_menu (varchar) tidak dianggap integer (0) oleh CI4
    protected $useAutoIncrement = false;            
    protected $returnType       = 'array';          // Kita pakai array biar gampang
    
    // Fitur keamanan CI4: Hanya kolom ini yang boleh diisi lewat form
    // (Sesuai kolom di db_resto.sql Anda)
    protected $allowedFields    = [
        'id_menu', 
        'id_kategori', 
        'nama_menu', 
        'harga', 
        'status_menu', 
        'gambar', 
        'deskripsi'
    ];

    // Aktifkan ini jika ingin CI4 otomatis mengisi created_at

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kosongkan karena tidak ada updated_at di tabel
}