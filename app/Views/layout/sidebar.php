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
        <?php if ($userinfo->level == "Admin Cabang") { ?>
        <li>
            <a href="javascript: void(0);"><i class="mdi mdi-apps"></i><span>Master</span><span class="menu-arrow"><i
                        class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="/pasien"><span>Pasien</span></a></li>
                <li><a href="/kunjungan"><span>Riwayat Kunjungan</span></a></li>
                <li><a href="/product"><span>Info Product</span></a></li>
                <li><a href="/treatment"><span>Info Treatment</span></a></li>
                <li><a href="/sdm"><span>Info SDM</span></a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if ($userinfo->level == "Dokter") { ?>
        <li>
            <a href="javascript: void(0);"><i class="mdi mdi-account-heart">
                </i>
                <span>Diagnosa</span>
                <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i>
                </span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="/transaksi/kunjungan">Diagnosa</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if ($userinfo->level == "Admin Cabang") { ?>
        <li>
            <a href="javascript: void(0);"><i class="mdi mdi-sale">
                </i>
                <span>Transaksi</span>
                <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i>
                </span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="/transaksi/treatment">Treatment</a></li>
                <li><a href="/transaksi/product">Product</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);">
                <i class="mdi mdi-settings"></i>
                <span>Settings</span>
                <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i>
                </span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="/settings_admin">Settings</a></li>
            </ul>
        </li>
        <?php } ?>

        <?php if ($userinfo->level == 'Admin') { ?>
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
                <li><a href="/profile">Profile</a></li>
            </ul>
        </li>
        <?php } ?>
    </ul>
</div>