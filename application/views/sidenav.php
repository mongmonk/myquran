<!-- Sidebar Holder -->
        <nav id="sidebar" class="active">            
            <ul class="list-unstyled components">
                <li>
                    <a href="/quran/page">AL-QUR`AN PER HALAMAN</a>
                </li>
                <li>
                    <a href="/quran/daftarjuz">DAFTAR JUZ</a>
                </li>
                <li>
                    <a href="/quran/daftarsurah">DAFTAR SURAH</a>
                </li>
                <li>
                    <a href="/quran/daftarruku">RUKU`</a>
                </li>
                <li>
                    <a href="/quran/daftarsajdah">AYAT-AYAT SAJDAH</a>
                </li>
                <li>
                    <a href="/quran/daftarayat">TAHFIDZUL QUR`AN</a>
                </li>
                <li><a href="<?php echo base_url("quran/daftartafsir")?>">TAFSIR PER SURAH</a></li>
                <li>
                    <a href="/hadits/bukhari">HR.BUKHARI</a>
                </li>
                <li>
                    <a href="/hadits/muslim">HR.MUSLIM</a>
                </li>
                <li>
                    <a href="/hadits/abudaud">HR.ABU DAUD</a>
                </li>
                <li>
                    <a href="/hadits/ahmad">HR.AHMAD</a>
                </li>
                <li>
                    <a href="/hadits/darimi">HR.DARIMI</a>
                </li>
                <li>
                    <a href="/hadits/ibnumajah">HR.IBNU MAJAH</a>
                </li>
                <li>
                    <a href="/hadits/malik">HR.MALIK</a>
                </li>
                <li>
                    <a href="/hadits/nasai">HR.NASA`I</a>
                </li>
                <li>
                    <a href="/hadits/tirmidzi">HR.TIRMIDZI</a>
                </li>
                <li>
                    <a href="/quran/doa">DOA-DOA HARIAN</a>
                </li>
                <li>
                    <a href="/quran/tahlil">DOA TAHLIL</a>
                </li>
                <li>
                    <a href="/quran/jadwalsholat">JADWAL SHOLAT BULANAN</a>
                </li>
                <li>
                    <a href="/quran/jadwalsholatharian">JADWAL SHOLAT UNTUK MASJID</a>
                </li>
                <li>
                    <a href="/quran/about">TENTANG <?php echo SITE_NAME ?></a>
                </li>
                <li>
                    <a href="/quran/contact">HUBUNGI <?php echo SITE_NAME ?></a>
                </li>
                <li>
                    <a href="/quran/privacy">PRIVACY POLICY</a>
                </li>
                <li>
                    <a href="/quran/partnerapi">PARTNER API</a>
                </li>
            </ul>
        </nav>
        <!-- Page Content Holder -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="navbar-btn">☰</button>
                    <a class="navbar-brand text-success font-weight-bold" href="<?php echo base_url() ?>" title="<?php echo SITE_NAME ?>">
                        <img src="<?php echo base_url('inc/logo.png') ?>" width='200' height='45' alt="<?php echo SITE_NAME ?>"/>
                    </a>
                </div>
            </nav>
            <form method="GET" action="/quran/search/" target="_top" class="d-print-none">
                <div class="input-group my-2 px-5">
                    <input type="search" class="form-control" placeholder="Cari ayat tentang..." value="<?php echo $this->input->get('query') ?>" name="query">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                </div>
            </form>