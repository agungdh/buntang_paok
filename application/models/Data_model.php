<?php
class Data_model extends CI_Model {

    function isi_disposisi() {
        $isi_disposisi =
        [
            'Perlu Persetujuan',
            'Untuk Diperiksa',
            'Untuk Diselesaikan',
            'Mohon Dipertimbangkan',
            'Mohon Balasan',
            'Perlu Ditandatangani',
        ];

        return $isi_disposisi;
    }

}