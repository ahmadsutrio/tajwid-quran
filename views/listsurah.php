<?php require_once('common/header.php'); ?>
<?php
$koneksi = koneksi();
$sql = "SELECT * FROM surah ";
if (isset($_POST['cari'])) {
    $keyword = $_POST['keyword'];
    $keyword = addslashes($keyword);
    $sql = cari($keyword);
}
$query = mysqli_query($koneksi, $sql);
$num_rows = mysqli_num_rows($query);
?>

<!-- Content -->
<div class="container-fluid py-5 mt-5 ">
    <main class="container pb-5 pt-2" style="border-radius:20px; background-color:#ebeff1;">
        <form action="" method="POST" class="row justify-content-center mb-4">
            <div class="col-12">
                <h1 class="fw-bold text-center" style="color:#198754;">Qur'an<span style="color: #212529;">Ku</span></h1>
            </div>
            <div class="col-lg-7 col-md-7 d-flex">
                <input type="text" name="keyword" placeholder="Pencarian" class="form-control" autocomplete="off" value="<?php if(isset($_POST['cari'])) echo $keyword?>" id="">
                <button type="submit" name="cari" class="btn ms-2 text-white" style="background-color: #198754;">Cari</button>
            </div>
        </form>
        <div class="row offset-lg-1 justify-content-lg-start justify-content-md-center  gap-3 py-2 px-lg-0 px-2 ">
            <?php if ($num_rows >= 1) : ?>
                <?php foreach ($query as $query) : ?>
                    <div class="col-lg-2 col-md-3 box shadow rounded-3" data-aos="fade-up">
                        <a href="surah.php?nama_surah=<?= $query['nama_surah'] ?>" name="cari" class="text-decoration-none row row-cols-1 mt-3 mx-1">
                            <div class="col d-flex justify-content-between">
                                <div class="rounded-circle p-2 " style="line-height: 50%; background-color:#74c4ba; color: #006b25;">
                                    <span class="fs-6"><?= $query['nomor_surah'] ?></span>
                                </div>
                            </div>
                            <div class="col mt-5 overflow-auto ">
                                <h4 class="m-0 text-dark"><?= $query['nama_surah'] ?></h4>
                                <p class="text-muted"><?= $query['terjemah_surah'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-11">
                    <h3 class="text-center text-capitalize text-success">
                        Maaf pencarian anda tidak ditemukan
                    </h3>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<?php require_once('common/footer.php');?>