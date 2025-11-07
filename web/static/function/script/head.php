<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- TODO replace dot path to actual hostname -->

<link rel="apple-touch-icon" sizes="57x57" href="/static/asset/logo/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/static/asset/logo/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/static/asset/logo/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/static/asset/logo/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/static/asset/logo/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/static/asset/logo/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/static/asset/logo/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/static/asset/logo/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/static/asset/logo/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="/static/asset/logo/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/static/asset/logo/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/static/asset/logo/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/static/asset/logo/favicon-16x16.png">
<link rel="icon" type="image/x-icon" href="/static/asset/logo/favicon.ico">
<link rel="manifest" href="/static/asset/logo/manifest.json">
<meta name="msapplication-TileColor" content="#75292d">
<meta name="msapplication-TileImage" content="/static/asset/logo/ms-icon-144x144.png">
<meta name="theme-color" content="#75292d">
<?php
    //(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
    $host_url = "https://$_SERVER[HTTP_HOST]";
    $current_url = "$host_url$_SERVER[REQUEST_URI]";

    $og = array(
        'title' => "TIChE2026 - Organized by Department of Chemical Engineering, Faculty of Engineering, Ubon Ratchathani University",
        'logo'=> "$host_url/static/asset/header_16x9.png",
        'height'=> 1280,
        'width'=> 720
    );
    
    if (strpos($current_url, "/post/") && isset($_GET['id'])) {
        //Mean you're currently browsing in post page
        $post = new Post((int) $_GET['id']);
        if ($post->getID() != -1) {
            $img = $post->getProperty("cover");
            $og['title'] = $post->getTitle() . " | " . $og['title'];
            if ($img != null && !empty($img) && file_exists($img)) {
                list($ogwidth, $ogheight, $ogtype, $ogattr) = getimagesize($img);
                $og['logo']=$current_url."/../".$img;
                $og['height']=$ogheight;
                $og['width']= $ogwidth;
            }
        }
    } /* else if (strpos($current_url, "/epub/") && isset($_GET['id'])) {
        $newsletter = new Newsletter((int) $_GET['id']);
        $title = $newsletter->getProperty("title") . " | " . $title;
        $img = $newsletter->getProperty("cover");
        if ($img != null && !empty($img)) {
            list($ogwidth, $ogheight, $ogtype, $ogattr) = getimagesize($img);
            $og = array(
                'logo'=> $current_url."/../".$img,
                'height'=> $ogheight,
                'width'=> $ogwidth
            );
        }
    } */
?>
<title><?php echo $og['title']; ?></title>
<meta property="og:title" content="<?php echo $og['title']; ?>" />
<meta property="og:image" content="<?php echo $og['logo']; ?>" />
<meta property="og:image:width" content="<?php echo $og['width']; ?>" />
<meta property="og:image:height" content="<?php echo $og['height']; ?>" />
<meta name="twitter:card" content="summary"></meta>
<link rel="image_src" href="<?php echo $og['logo']; ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $current_url; ?>" />

<link rel="stylesheet" href="/static/library/fontawesome-free-6.2.1-web/css/all.min.css"/>
<link rel="stylesheet" href="/static/library/bootstrap-4.6.1-dist/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/static/library/mdbootstrap-4.19.1/css/mdb.min.css"/>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;700&family=Inter:wght@400;500;700&family=Kanit:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&family=Sarabun:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="/static/asset/style.css"/>

<script src="/static/library/jquery-3.6.0.min.js"></script>
<script src="/static/library/bootstrap-4.6.1-dist/js/bootstrap.bundle.min.js"></script>            
<script src="/static/library/mdbootstrap-4.19.1/js/mdb.min.js"></script>

<!-- SweetAlert -->
<script src="/static/library/sweetalert-2.1.2.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2WGHK9GM3L"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-2WGHK9GM3L');
</script>

<!-- Cloudflare Turnstile -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>