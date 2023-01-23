 <!-- Navbar -->
 <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg  blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid px-0">
                        <a class="navbar-brand font-weight-bolder ms-sm-3" href="./" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom">
                        SIES - KELOMPOK 1
                        </a>
                            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon mt-2">
                                    <span class="navbar-toggler-bar bar1"></span>
                                    <span class="navbar-toggler-bar bar2"></span>
                                    <span class="navbar-toggler-bar bar3"></span>
                                </span>
                            </button>
                        <div class="collapse navbar-collapse pt-3 pb-2 py-lg-0 w-100" id="navigation">
                            <ul class="navbar-nav navbar-nav-hover ms-auto">
                                <li class="nav-item dropdown dropdown-hover mx-1">
                                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center <?= $page == "home" ? "text-primary" : "" ?>" href="./" aria-expanded="false">
                                        <i class="material-icons opacity-6  me-1 text-md">home</i> Home
                                    </a>
                                </li>
                                <li class="nav-item dropdown dropdown-hover mx-1">
                                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center <?= $page == "ekskul" ? "text-primary" : "" ?><?= $page == "ekskul/detail_ekskul" ? "text-primary" : "" ?><?= $page == "ekskul/form_pendaftaran" ? "text-primary" : "" ?>" href="./?page=ekskul/" aria-expanded="false">
                                        <i class="material-icons opacity-6 me-1 text-md">sports_volleyball</i> Ekskul
                                    </a>
                                </li>
                                <li class="nav-item dropdown dropdown-hover mx-2">
                                    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="usersDropDon" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons opacity-6 me-2 text-md">people_alt</i> Login
                                        <span class="material-icons">keyboard_arrow_down</span>
                                    </a>
                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animation dropdown-md dropdown-md-responsive p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="usersDropDon">
                                                    <div class="d-lg-block d-sm-block">
                                                        <li class="nav-item dropdown dropdown-hover dropdown-subitem">
                                                            <a class="dropdown-item py-2 ps-3 border-radius-md" href="./admin/FormLogin.php">
                                                                
                                                                <div class="w-100 d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <h6 class="text-dark font-weight-bolder d-flex justify-content-cente align-items-center p-0">Admin</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item dropdown dropdown-hover dropdown-subitem">
                                                            <a class="dropdown-item py-2 ps-3 border-radius-md" href="./pembina_ekskul/FormLogin.php">
                                                                <div class="w-100 d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <h6 class="text-dark font-weight-bolder d-flex justify-content-cente align-items-center p-0">Pembina</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item dropdown dropdown-hover dropdown-subitem">
                                                            <a class="dropdown-item py-2 ps-3 border-radius-md" href="./ketua_ekskul/FormLogin.php">
                                                                <div class="w-100 d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <h6 class="text-dark font-weight-bolder d-flex justify-content-cente align-items-center p-0">Ketua</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </div>
                                                </ul>
                                            </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>