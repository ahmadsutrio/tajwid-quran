<?php
function koneksi()
{
    $servername = 'localhost';
    $database = 'qurandantajwid';
    $username = 'root';
    $password = '';
    $conn       = mysqli_connect($servername, $username, $password, $database);
    // mengecek koneksi
    if (!$conn) {
        die("connnection failed." . mysqli_connect_error());
        echo "gagal";
    }
    return $conn;
}
function testing()
{
    $servername = 'localhost';
    $database = 'qurandantajwidTesting';
    $username = 'root';
    $password = '';
    $conn       = mysqli_connect($servername, $username, $password, $database);
    // mengecek koneksi
    if (!$conn) {
        die("connnection failed." . mysqli_connect_error());
        echo "gagal";
    }
    return $conn;
}

function koneksi2()
{
    $servername = 'localhost';
    $database = 'db_tajwid';
    $username = 'root';
    $password = '';
    $conn       = mysqli_connect($servername, $username, $password, $database);
    // mengecek koneksi
    if (!$conn) {
        die("connnection failed." . mysqli_connect_error());
        echo "gagal";
    }
    return $conn;
}

function query($sql){
    $koneksi = koneksi();
    $query = mysqli_query($koneksi,$sql);
    return $query;
}

function getIdSurah($nama_surah){
    $koneksi = koneksi();
    $sql = "SELECT nomor_surah FROM surah WHERE nama_surah = '$nama_surah'";
    $query = mysqli_query($koneksi, $sql);
    $nomor_surah = mysqli_fetch_assoc($query);
    $nomor_surah = $nomor_surah['nomor_surah'];
    return $nomor_surah;
}

function getJumlahAyat($id_surah){
    $koneksi = koneksi();
    $sql = "SELECT nomor_ayat FROM ayat WHERE id_surah = '$id_surah'";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function getAyat($ayat, $id_surah){
    $koneksi = koneksi();
    $sql = "SELECT ayat.unicode_tajwid, 
            ayat.text_ayat, 
            ayat.nomor_ayat, 
            ayat.id_halaman,  
            ayat.id_ayat,  
            terjemahan.text_terjemah, 
            audio.audio_ayat, 
            surah.nomor_surah, 
            surah.id_surah, 
            surah.nama_surah,
            surah.terjemah_surah, 
            latin.translate_indo
            FROM ayat, terjemahan, audio, surah, latin 
            WHERE ayat.id_ayat=terjemahan.id_terjemah 
            AND ayat.id_ayat=audio.id_ayat 
            AND ayat.id_surah=surah.id_surah 
            AND latin.id_ayat = ayat.id_ayat 
            AND surah.nomor_surah = $id_surah
            AND ayat.nomor_ayat =  $ayat";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function cariSurah($nama_surah)
{
    $koneksi = koneksi();
    $sql = "SELECT ayat.unicode_tajwid, 
            ayat.text_ayat, 
            ayat.nomor_ayat, 
            ayat.id_halaman,  
            ayat.id_ayat,  
            terjemahan.text_terjemah, 
            audio.audio_ayat, 
            surah.nomor_surah, 
            surah.id_surah, 
            surah.nama_surah,
            surah.terjemah_surah, 
            latin.translate_indo
            FROM ayat, terjemahan, audio, surah, latin 
            WHERE ayat.id_ayat=terjemahan.id_terjemah 
            AND ayat.id_ayat=audio.id_ayat 
            AND ayat.id_surah=surah.id_surah 
            AND latin.id_ayat = ayat.id_ayat 
            AND surah.nomor_surah =  $nama_surah";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function totalSurah()
{
    $koneksi = koneksi();
    $sql = "SELECT id_surah,nama_surah FROM surah ";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function cari($keyword)
{
    $sql = "SELECT * FROM surah WHERE 
            nama_surah  LIKE '%$keyword%' OR
            terjemah_surah  LIKE '%$keyword%' OR
            nomor_surah  LIKE '%$keyword%'";
    return $sql;
}

function penomoranAyat($nomor){
    $arabic_number = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $jumlah_karakter = strlen($nomor);
    $temp = '';
    for($i=0; $i< $jumlah_karakter; $i++){
        $char = substr($nomor,$i,1);
        $temp .= $arabic_number[$char];
    }
    return $temp;
}

// Function Tajwid

function qolqolah($ayat){
    $koneksi = koneksi2();
    $qolqolah = "SELECT huruf_tajwid FROM tajwid";
    $query = mysqli_query($koneksi, $qolqolah);
    $query = mysqli_fetch_assoc($query);
    $query = $query['huruf_tajwid'];
    $data = explode(",", $query);

    foreach ($data as $data) {
        $kalimat = $ayat;
        $dicari = "$data";
        if (preg_match("/$dicari/i", $kalimat)) {
            $replace = str_replace($dicari, "[q[$data]", $kalimat);
            $ayat = $replace;
        }else{
            $ayat = $ayat;
        }
    }
    return $ayat;
}

function madLazimMusy($ayat){
    $koneksi = koneksi2();
    $madLazim = "SELECT huruf_tajwid FROM mad_lazim_musy";
    $query = mysqli_query($koneksi, $madLazim);
    $query = mysqli_fetch_assoc($query);
    $query = $query['huruf_tajwid'];
    $data = explode(",", $query);

    foreach ($data as $data) {
        $kalimat = $ayat;
        $dicari = "$data";
        if (preg_match("/$dicari/i", $kalimat)) {
            $replace = str_replace($dicari, "[m[$data]", $kalimat);
            $ayat = $replace;
        } else {
            $ayat = $ayat;
        }
    }

    return $ayat;
}

function madLazimHarfi($ayat){
    $koneksi = koneksi2();
    $madLazim = "SELECT huruf_tajwid FROM mad_lazim_harfi";
    $query = mysqli_query($koneksi, $madLazim);
    $query = mysqli_fetch_assoc($query);
    $query = $query['huruf_tajwid'];
    $data = explode(",", $query);

    foreach ($data as $data) {
        $kalimat = $ayat;
        $dicari = "$data";
        if (preg_match("/$dicari/i", $kalimat)) {
            $replace = str_replace($dicari, "[p[$data]", $kalimat);
            $ayat = $replace;
        } else {
            $ayat = $ayat;
        }
    }

    return $ayat;
}

function ghunnah($ayat){
    $koneksi = koneksi2();
    $madLazim = "SELECT huruf_tajwid FROM ghunnah";
    $query = mysqli_query($koneksi, $madLazim);
    $query = mysqli_fetch_assoc($query);
    $query = $query['huruf_tajwid'];
    $data = explode(",", $query);

    foreach ($data as $data) {
        $kalimat = $ayat;
        $dicari = "$data";
        if (preg_match("/$dicari/i", $kalimat)) {
            $replace = str_replace($dicari, "[g[$data]", $kalimat);
            $ayat = $replace;
        } else {
            $ayat = $ayat;
        }
    }
    return $ayat;
}
function alifLamSyamsiah($ayat){
    $koneksi = koneksi2();
    $madLazim = "SELECT huruf_tajwid FROM alif_lam_samsiah";
    $query = mysqli_query($koneksi, $madLazim);
    $query = mysqli_fetch_assoc($query);
    $query = $query['huruf_tajwid'];
    $data = explode(",", $query);

    foreach ($data as $data) {
        $kalimat = $ayat;
        $dicari = "$data";
        // var_dump($dicari);
        if (preg_match("/$dicari/i", $kalimat)) {
            $replace = str_replace($dicari, "[l[$data]", $kalimat);
            $ayat = $replace;
        } else {
            $ayat = $ayat;
        }
    }
    return $ayat;
}
function iqlab($ayat){
    $koneksi = koneksi2();
    $madLazim = "SELECT huruf_tajwid FROM iqlab";
    $query = mysqli_query($koneksi, $madLazim);
    $query = mysqli_fetch_assoc($query);
    $query = $query['huruf_tajwid'];
    $data = explode(",", $query);

    foreach ($data as $data) {
        $kalimat = $ayat;
        $dicari = "$data";
        // var_dump($dicari);
        if (preg_match("/$dicari/i", $kalimat)) {
            $replace = str_replace($dicari, "[i[$data]", $kalimat);
            $ayat = $replace;
        } else {
            $ayat = $ayat;
        }
    }
    return $ayat;
}
// Admin

function tampilAyat($awalData,$jumlahDataPerHalaman){
    $koneksi = testing();
    $sql = "SELECT * FROM ayat LIMIT $awalData , $jumlahDataPerHalaman";
    $query = mysqli_query($koneksi,$sql);
    return $query;
}

function tambahAyat($id_surah,$id_halaman,$text_ayat,$nomor_ayat,$unicode_ayat,$unicode_tajwid){

    $id_surah = $id_surah;
    $id_halaman = $id_halaman;
    $text_ayat = $text_ayat;
    $nomor_ayat = $nomor_ayat;
    $unicode_ayat = $unicode_ayat;
    $unicode_tajwid = $unicode_tajwid;

    $koneksi = testing();
    $sql = "INSERT INTO ayat (
            id_surah,
            id_halaman,
            text_ayat,
            nomor_ayat,
            unicode_ayat,
            unicode_tajwid
            ) VALUES (
                '$id_surah',
                '$id_halaman',
                '$text_ayat',
                '$nomor_ayat',
                '$unicode_ayat',
                '$unicode_tajwid'
            )";
    $query = mysqli_query($koneksi,$sql);
    return $query;
}

function hapusAyat($id_ayat){
    $koneksi = testing();
    $sql = "DELETE FROM ayat WHERE id_ayat = $id_ayat ;";
    $query = mysqli_query($koneksi,$sql);
    return $query;
}

function updateAyat($id_ayat, $id_surah, $id_halaman, $text_ayat, $nomor_ayat, $unicode_ayat, $unicode_tajwid){
    $id_ayat = $id_ayat;
    $id_surah = $id_surah;
    $id_halaman = $id_halaman;
    $text_ayat = $text_ayat;
    $nomor_ayat = $nomor_ayat;
    $unicode_ayat = $unicode_ayat;
    $unicode_tajwid = $unicode_tajwid;

    $koneksi = testing();
    $sql = "UPDATE ayat SET
            id_surah ='$id_surah',
            id_halaman = '$id_halaman',
            text_ayat = '$text_ayat',
            nomor_ayat = '$nomor_ayat',
            unicode_ayat = '$unicode_ayat',
            unicode_tajwid = '$unicode_tajwid'
            WHERE id_ayat = '$id_ayat';
            ";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

// admin halaman

function tampilHalaman($awalData, $jumlahDataPerHalaman)
{
    $koneksi = testing();
    $sql = "SELECT * FROM halaman LIMIT $awalData , $jumlahDataPerHalaman";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function updateHalaman($id_halaman, $halaman)
{
    $id_halaman = $id_halaman;
    $halaman = $halaman;

    $koneksi = testing();
    $sql = "UPDATE halaman SET
            halaman = '$halaman'
            WHERE id_halaman = '$id_halaman';
            ";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function tambahHalaman( $halaman)
{
    // $id_halaman = $id_halaman;
    $halaman = $halaman;

    $koneksi = testing();
    $sql = "INSERT INTO halaman (
            halaman
            ) VALUES (
                '$halaman'
            )";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function hapusHalaman($id_halaman)
{
    $koneksi = testing();
    $sql = "DELETE FROM halaman WHERE id_halaman = $id_halaman ;";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function  getHalaman(){
    $koneksi = testing();
    $sql = "SELECT * FROM halaman ";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}
function  getSurah(){
    $koneksi = testing();
    $sql = "SELECT * FROM surah ";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

//audio admin
function tampilAudio($awalData, $jumlahDataPerHalaman)
{
    $koneksi = testing();
    $sql = "SELECT * FROM audio LIMIT $awalData , $jumlahDataPerHalaman";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function tambahAudio($id_ayat, $audio_ayat)
{

    $id_ayat = $id_ayat;
    $audio_ayat = $audio_ayat;

    $koneksi = testing();
    $sql = "INSERT INTO audio (
            id_ayat,
            audio_ayat
            ) VALUES (
                '$id_ayat',
                '$audio_ayat'
            )";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function hapusAudio($id_audio)
{
    $koneksi = testing();
    $sql = "DELETE FROM audio WHERE id_audio = $id_audio ;";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}

function updateAudio($id_audio, $audio_ayat)
{
    $id_audio = $id_audio;
    $audio_ayat = $audio_ayat;

    $koneksi = testing();
    $sql = "UPDATE audio SET
            audio_ayat = '$audio_ayat'
            WHERE id_audio = '$id_audio';
            ";
    $query = mysqli_query($koneksi, $sql);
    return $query;
}