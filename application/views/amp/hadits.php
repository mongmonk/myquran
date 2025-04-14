<!doctype html>
<html ⚡="" lang="id-ID">
  <head>
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <title><?php echo $title ?></title>
    <meta name="google-site-verification" content="v41YLnzLxTtkqUVRPNP4qRvhFd4OLz5SHvhimMvEv7w" />
    <link rel="canonical" href="<?php echo base_url($_SERVER['REQUEST_URI'])?>" />
    <meta name="description" value="Jadikanlah Al-quranul Karim dan Sunnah Nabi sebagai tuntunan hidupmu agar kamu tidak sesat">
    <meta property="og:locale" content="id_ID" /><meta property="og:type" content="website" /><meta property="og:title" content="<?php echo SITE_NAME ?>" /><meta property="og:description" content="Jadikanlah Al-quranul Karim dan Sunnah Nabi sebagai tuntunan hidupmu agar kamu tidak sesat" /><meta property="og:url" content="<?php echo base_url($_SERVER['REQUEST_URI'])?>" /><meta property="og:site_name" content="<?php echo SITE_NAME ?>" /><meta property="og:image" content="<?php echo base_url('inc/alquran.png')?>" /><meta property="og:image:width" content="800" /><meta property="og:image:height" content="500" /><meta property="og:image:type" content="image/png" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script
      custom-element="amp-carousel"
      src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"
      async=""
    ></script>
    <script
      custom-element="amp-sidebar"
      src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"
      async=""
    ></script>
    <script
      custom-element="amp-accordion"
      src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"
      async=""
    ></script>
    <?php $this->load->view('amp/css')?>
  </head>
  <body>
    <?php $this->load->view('amp/nav')?>
    <main id="content" role="main" class="pt4">
      <article class="recipe-article center border-bottom pt4">
        <header>
          <span class="block my3 arab">سْمِ ٱللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</span>
          <h1 class="h2"><?php echo $title ?></h1>          
        </header>
        <form class="sample-form my3" method="GET" action="/hadits/search/<?php echo $this->uri->segment(2) !== 'search' ? $this->uri->segment(2) : $this->uri->segment(3) ?>" target="_top">
          <input type="search" class="py1 px1" placeholder="H.R. <?php echo $perowi ?> tentang..." value="<?php echo $this->input->get('query') ?>" name="query">
          <button type="submit" class="py1">Search</button>
        </form>
      </article>
      <?php echo $pagination ?>
      <ul class="list-reset">
        <?php foreach($data as $i => $list){?>
            <li class="mb2 px3">
                <p>Hadis Riwayat <?php echo $perowi ?> no: <?php echo $list->number ?></p>
                <p class="arab text-right my2"><?php echo $list->arab ?></p>
                <p><?php echo $this->uri->segment(2) !== 'search' ? $list->id : str_ireplace($this->input->get('query'), "<b class='query'><em>{$this->input->get('query')}</em></b>", $list->id) ?></p>
                <div class="dash"></div>
            </li>
        <?php }?>
      </ul>
      <?php echo $pagination ?>
    </main>
    <footer class="ampstart-footer flex flex-column items-center px3">
      <nav class="ampstart-footer-nav">
        <ul class="list-reset flex flex-wrap mb3">
          <li class="px1">
            <a class="text-decoration-none ampstart-label" href="/quran/about">ABOUT</a>
          </li>
          <li class="px1">
            <a class="text-decoration-none ampstart-label" href="/quran/contact">CONTACT</a>
          </li>
          <li class="px1">
            <a class="text-decoration-none ampstart-label" href="/quran/privacy">PRIVACY POLICY</a>
          </li>
        </ul>
      </nav>
      <p>&copy;<?php echo date('Y')?> <a href="<?php echo base_url()?>"><?php echo SITE_NAME ?></a>. Developed by <a href="https://t.me/cemonggaul">Cemonggaul</a></p>
    </footer>
  </body>
</html>