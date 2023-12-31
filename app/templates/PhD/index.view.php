<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="icon" href="<?= IMG . 'logo.png'  ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS . 'bootstrap.min.css'  ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS . 'bootstrap.min.css.map'  ?>">
    <link rel="stylesheet" href="<?= '/css/shortcut.css' ?>">
    <link rel="stylesheet" href="<?= '/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?= CSS . "main.css" ?>">
    <link rel="stylesheet" href="<?= CSS . $lang . DS . $file_css  . ".css"  ?>">
</head>
    <body>


<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm bg-black z-3" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://www.ttu.edu.jo/">
            <img src="<?= IMG . 'logo.png' ?>" alt="TTU Logo" class="logo w-25 h-25 mr-15">
            <span><?= $TTU ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $student_links ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="https://webapp.ttu.edu.jo:2011/login.aspx">
                                <i class="fa-solid fa-toilets-portable mr-15"></i>
                                <span><?= $student_ported ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="http://www.ttu.edu.jo/wp-content/uploads/2021/09/cal.pdf">
                                <i class="fa-solid fa-calendar mr-15"></i>
                                <span><?= $calender  ?></span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="http://www.ttu.edu.jo/admission/bachelors-degree/">
                                <i class="fa-solid fa-folder-tree mr-15"></i>
                                <span><?= $student_plans  ?></span>
                            </a>
                        </li>


                    </ul>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $collages_links  ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="http://www.ttu.edu.jo/college-of-engineering/">
                                <i class="fa-solid fa-gear mr-15"></i>
                                <span><?= $engineering  ?></span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2 search-nav" type="search" placeholder="Search" aria-label="Search">
                <button class="btn border-1 border-black btn-search" type="submit">
                    <?= $search  ?>
                </button>
            </form>
        </div>
    </div>
</nav>
<aside class="d-flex flex-column bg-black p-20 gap-20 " id="main-aside" expanded="false">
    <button class="aside-toggle d-flex align-items-center gap-10" btn-aside-toggel>
        <i class="fa-solid fa-angles-left"></i>
    </button>
    <header class="header d-flex gap-20 align-items-center ">
        <figure class="user-img object-fit-cover m-0 justify-content-between overflow-hidden">
            <img src="<?= IMG . 'avatar_student_default.png' ?>" class="w-100 object-fit-cover" alt="User Image">
        </figure>
        <div class="user-details">
            <p class="title fs-10 fw-500 text-truncate">
                Intelligent System Engineering
            </p>
            <p class="name mb-0 fw-bold fs-14">
                Feras Barhmeh
            </p>
        </div>
    </header>

    <nav class="d-flex flex-column flex-1 relative">
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate">Main </p>
            <ul class="plr-10">
                <li class="li-aside-menu active" has-sub-menu="false" title="Home">
                    <a href="/" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-home"></i>
                        <span class="text">Home</span>
                    </a>
                </li>
                <!-- Start With Sub menu -->
                <li class="li-aside-menu" has-sub-menu="true" title="Students >> ">
                    <button  class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-users"></i>
                        <span class="text">Students</span>
                        <i class="fa-solid fa-arrow-down arrow ml-auto"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu" >
                            <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-plus"></i>
                                <span class="text">Add Student</span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-trash"></i>
                                <span class="text">Delete Student</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End With Sub menu -->

                <!-- Start With Sub menu -->
                <li class="li-aside-menu" has-sub-menu="true" title="Doctor >> ">
                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-certificate"></i>
                        <span class="text">Doctors</span>
                        <i class="fa-solid fa-arrow-down arrow ml-auto"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/PhD" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text">Doctors</span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/PhD/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
                                <span class="text">Add Doctor</span>
                            </a>
                        </li>
<!--                        <li class="li-aside-menu">-->
<!--                            <a href="/PhD/delete" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">-->
<!--                                <i class="fa fa-trash"></i>-->
<!--                                <span class="text">Delete Doctor</span>-->
<!--                            </a>-->
<!--                        </li>-->
                    </ul>
                </li>
                <!-- End With Sub menu -->


                <li class="li-aside-menu " has-sub-menu="false" title="New Vote">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-vote-yea"></i>
                        <span class="text">New Vote</span>
                    </a>
                </li>




            </ul>
        </div>


        <!-- Start Setting -->
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate">Settings </p>
            <ul class="plr-10">
                <li class="li-aside-menu " has-sub-menu="false"  title="Setting">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-gears"></i>
                        <span class="text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Setting -->



        <!-- Start Account -->
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate">Account </p>
            <ul class="plr-10">
                <li class="li-aside-menu " has-sub-menu="false"  title="Help">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-info-circle"></i>
                        <span class="text">Help</span>
                    </a>
                </li>
                <li class="li-aside-menu " has-sub-menu="false"  title="Logout">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-arrow-left"></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Account -->




    </nav>
</aside>

<main class="">
    <h1>Feras</h1>
</main>




    <footer></footer>
    <script src="<?= JS . "main"      . ".js" ?>"></script>
    <script src="<?=  JS . "shortcut"  . ".js" ?>"></script>
    <script src="<?=  JS . "all.min"  . ".js" ?>"></script>
    <script src="<?=  BOOTSTRAP_JS . "bootstrap.bundle"  . ".js" ?>"></script>
    <script src="<?=  JS . $file_js  . ".js" ?>"></script>
    </body>
</html>