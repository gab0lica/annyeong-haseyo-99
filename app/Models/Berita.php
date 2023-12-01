<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table= 'berita';

    protected $fillable= [
        'link',
        'level',
        'web_id',
        'artis_id',
        'status',
        'admin_id',
    ];
    public $timestamps= true;

    // public function berita() {
    //     return $this->hasMany(Berita::class, 'berita_id');
    // }

    use HasFactory;
}
/*
            $table->id();
            $table->string('link')->min(20);
            $table->integer('level')->sizeof(1);//= 1 / 2
            $table->interger('web_id');//= dispatch 1 / the korea times 2 / the korea herald 3
            $table->integer('artis_id')->sizeof(1);//id artis
            $table->integer('status')->sizeof(1);//= aktif 0 / nonaktif 1
            $table->integer('admin_id')->sizeof(1);//role admin = 0, id user
            $table->timestamps();

CREATE TABLE `berita` (
  `berita_id` int(11) NOT NULL,
  `judul_idn` varchar(50) DEFAULT NULL,
  `deskripsi_idn` varchar(200) DEFAULT NULL,
  `judul_kor` varchar(50) DEFAULT NULL,
  `deskripsi_kor` varchar(200) DEFAULT NULL,
  `artis_id` int(11) DEFAULT NULL,
  `tanggal_rilis` date DEFAULT NULL,
  `link` varchar(100) NOT NULL,
  `sumber_id` int(1) NOT NULL COMMENT '1 = dispatch,\r\n2 = the korea times,\r\n3 = the korea herald'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/
