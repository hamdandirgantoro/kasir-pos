<?php

namespace App\Helpers;

class Pesan
{
    private $dataName;
    public $berhasilTambahData;
    public $gagalTambahData;
    public $berhasilUpdateData;
    public $gagalUpdateData;
    public $berhasilHapusData;
    public $gagalHapusData;
    public $berhasilAktivasiData;
    public $gagalAktivasiData;

    public function __construct($dataName = null)
    {
        $this->dataName = $dataName ? $dataName : 'Data';
        $this->berhasilTambahData = 'Berhasil Menambah '.$this->dataName;
        $this->gagalTambahData = 'Gagal Menambah '.$this->dataName;
        $this->berhasilUpdateData = 'Berhasil Mengupdate '.$this->dataName;
        $this->gagalUpdateData = 'Gagal Mengupdate '.$this->dataName;
        $this->berhasilHapusData = 'Berhasil Menghapus '.$this->dataName;
        $this->gagalHapusData = 'Gagal Menghapus '.$this->dataName;
        $this->berhasilAktivasiData = 'Berhasil Mengaktifkan '.$this->dataName;
        $this->gagalAktivasiData = 'Gagal Mengaktifkan '.$this->dataName;
    }

}
