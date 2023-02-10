<?php
require_once('../common/header.php');
require_once('../../vendor/autoload.php');
$koneksi = koneksi();
?>

<section class="container-fluid pt-5">
    <main class="container mt-lg-5 mt-3  " style="border-radius:20px; background-color:#ebeff1; ">
       
        <div class="row justify-content-center">
            <div class="col-11 offset-1">
                <div class="row gap-1 border ">
                    <a href="ayat.php" class="nav-link border col-lg-3 bg-dark rounded-3 text-white py-5">
                        <h3 class="text-center">
                            Ayat
                        </h3>
                    </a>
                    <a href="" class="nav-link border col-lg-3 bg-dark rounded-3 text-white py-5">
                        <h3 class="text-center">
                            Audio
                        </h3>
                    </a>
                    <a href="" class="nav-link border col-lg-3 bg-dark rounded-3 text-white py-5">
                        <h3 class="text-center">
                            Terjemahan
                        </h3>
                    </a>
                    <a href="halaman.php" class="nav-link border col-lg-3 bg-dark rounded-3 text-white py-5">
                        <h3 class="text-center">
                            Halaman
                        </h3>
                    </a>
                    <a href="" class="nav-link border col-lg-3 bg-dark rounded-3 text-white py-5">
                        <h3 class="text-center">
                            Juz
                        </h3>
                    </a>
                </div>
            </div>
        </div>
    </main>
</section>

<?php require_once('../common/footer.php')?>
