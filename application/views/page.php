<!DOCTYPE html>
<html lang="id-ID">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?></title>
    <link rel="canonical" href="<?php echo base_url($_SERVER['REQUEST_URI'])?>" />
    <meta name="description" value="Al-quran <?php echo $title ?>">
    <meta property="og:locale" content="id_ID" /><meta property="og:type" content="website" /><meta property="og:title" content="<?php echo $title ?>" /><meta property="og:description" content="Al-quran <?php echo $title ?>" /><meta property="og:url" content="<?php echo base_url($_SERVER['REQUEST_URI'])?>" /><meta property="og:site_name" content="<?php echo SITE_NAME ?>" /><meta property="og:image" content="<?php echo base_url('inc/alquran.png')?>" /><meta property="og:image:type" content="image/png" />
    <?php $this->load->view('css')?>
</head>
<body>
    <div class="wrapper mb-3 pb-5">
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
            <div class="halaman container">                
                <p class="arab text-justify" style="line-height: 2.5em;">
                    <?php 
                    foreach ($data as $k => $pages) {
                        $number = $this->quran->numConverter($pages->ayat);
                        $urutan = $pages->numList;
                        if ($pages->ayat == 1) {
                            if ($pages->surahNum == 1) {
                              if($pages->ayat < 2)continue;
                            }
                            if ($k == 0) {
                              echo "</p><p class='text-center arab my-4 mx-2'>بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ  <br/><small class='btn btn-sm btn-rounded btn-outline-success'>{$pages->surahAr} * الجزء : {$pages->juz}</small></p><div class='line'></div><p class='arab text-justify' style='line-height: 2.5em;'>";
                            } else {
                              echo "</p><div class='line'></div><p class='text-center arab my-4 mx-2'>بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ  <br/><small class='btn btn-sm btn-rounded btn-outline-success'>{$pages->surahAr} * الجزء : {$pages->juz}</small></p><div class='line'></div><p class='arab text-justify' style='line-height: 2.5em;'>";
                            }                
                          } else {
                            if ($pages->surahNum == 1 && $pages->ayat == 2 && $k !== 0) {
                              echo "</p><p class='text-center arab my-4 mx-2'>بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ  <br/><small class='btn btn-sm btn-rounded btn-outline-success'>{$pages->surahAr} * الجزء : {$pages->juz}</small></p><div class='line'></div><p class='arab text-justify' style='line-height: 2.5em;'>";
                            }                
                        }
                        echo "<span class='ayahAudio{$urutan}'>{$pages->ar} {$number}</span> ";
                    }?>
                </p>
                <div class="line"></div>
                <div class="text-center">
                    <?php     
                        $halaman = $this->uri->segment(3) ? $this->uri->segment(3): 1;                    
                        if ($halaman && $halaman != 1 && $halaman != 604) {
                            $prev = $halaman-1;
                            $next = $halaman+1;
                            echo "<a href='/quran/page/{$prev}' class='btn btn-sm btn-outline-success'>⊲</a>";
                            echo "<span class='btn btn-sm btn-outline-success mx-1'>".$this->quran->numConverter($halaman)."</span>";
                            echo "<a href='/quran/page/{$next}' class='btn btn-sm btn-outline-success'>⊳</a>";
                        } elseif (!$halaman || $halaman == 1) {
                            echo "<span class='btn btn-sm btn-outline-success mx-1'>".$this->quran->numConverter($halaman)."</span>";
                            echo "<a href='/quran/page/2' class='btn btn-sm btn-outline-success mx-1'>⊳</a>";
                        } else {
                            echo "<a href='/quran/page/603' class='btn btn-sm btn-outline-success'>⊲</a>";
                            echo "<span class='btn btn-sm btn-outline-success mx-1'>".$this->quran->numConverter($halaman)."</span>";
                        }
                    ?>
                </div>
            </div>          
        <div class="text-center text-secondary fixed-bottom">&copy;<?php echo date('Y')?> <a href="<?php echo base_url()?>"><?php echo SITE_NAME ?></a>. Developed by <a href="https://t.me/cemonggaul">Cemonggaul</a></div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="/inc/bootstrap-multiselect.js"></script>
    <script src="/inc/jquery.mediaplayer.js"></script>
    <script src="/inc/jquery.surah.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
        $(function() {
            $('#editionSelector').multiselect({ enableFiltering: true, enableCaseInsensitiveFiltering: true, maxHeight: 400, dropUp: true});
            $.alQuranSurah.editions('#editionSelector', '<?php echo end($data)->surahNum ?>');
            $.alQuranSurah.surahs('#surahSelector');
            $.alQuranMediaPlayer.init($("#surahPlayer")[0], 'surah', <?php echo $data[0]->numList ?>, <?php echo end($data)->numList ?>, <?php echo $data[0]->surahNum ?>, 0, '<?php echo $this->input->get('audio') == true ? $this->input->get('audio') : 'ar.alafasy' ?>');
            $.alQuranMediaPlayer.defaultPlayer();
            $.alQuranMediaPlayer.zoomIntoThisAyah();
        });
        $(function () {
            $('#surahSelector').change( function() {
                location.href = $(this).val();
            });
        });
    </script>
</body>

</html>