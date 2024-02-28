<?php
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location:login.php');
}
?>
<style>
    .logout-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
        color: inherit;
    }

    .logout-button:hover {
        background-color: transparent;
    }
    

    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background-color: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #d6dee1;
      border-radius: 10px;
      border: 2px solid transparent;
      background-clip: content-box;
    }

    ::-webkit-scrollbar-thumb:hover {
      background-color: #a8bbbf;
    }
</style>
<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-center">
                    <div class="logo">
                        <a href="index.php">
                            <h1>Aplikasi Masjid Jami' Nurul Iman</h1>
                        </a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>
                    <li class="sidebar-item">
                        <a href="index.php" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['is_login'])) {
                        ?>
                        <li class="sidebar-item  ">
                            <a href="form-warga.php" class='sidebar-link'>
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                <span>Form Penginfaq</span>
                            </a>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="data-penginfaq.php" class='sidebar-link'>
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                <span>Data Penginfaq</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="maps-google.php" class='sidebar-link'>
                                <i class="bi bi-map-fill"></i>
                                <span>Maps</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <form action="index.php" method="post">
                                <button type="submit" class="sidebar-link logout-button" name="logout">
                                    <i class="bi bi-door-open-fill"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="sidebar-item">
                            <a href="login.php" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Login</span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>