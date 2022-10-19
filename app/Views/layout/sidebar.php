<div class="left-sidenav">

    <ul class="metismenu left-sidenav-menu" id="side-nav">

        <li class="menu-title">Main</li>

        <li>
            <a href="javascript: void(0);"><i class="mdi mdi-monitor"></i><span>Dashboard</span><span
                    class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="/">Dashboard</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);"><i class="mdi mdi-apps"></i><span>Master</span><span class="menu-arrow"><i
                        class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="/pasien"><span>Pasien</span></a></li>
                <li><a href="#"><span>Riwayat Kunjungan</span></a></li>
                <li><a href="#"><span>Info Product</span></a></li>
                <li><a href="#"><span>Info Treatment</span></a></li>
                <li><a href="#"><span>Info SDM</span></a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="mdi mdi-sale">
                </i>
                <span>Transaksi</span>
                <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i>
                </span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="#">Kunjungan</a></li>
                <li><a href="#">Product</a></li>
                <li><a href="#">Treatment</a></li>
            </ul>
        </li>
        <?php if($userinfo->level !== 'Admin Cabang'){ ?>
        <li>
            <a href="javascript: void(0);">
                <i class="mdi mdi-settings"></i>
                <span>Settings</span>
                <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i>
                </span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="/lokasi">Lokasi Cabang</a></li>
                <li><a href="/infousers">Users</a></li>
            </ul>
        </li>
        <?php } ?>
    </ul>
</div>