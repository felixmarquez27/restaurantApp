<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href=<?php echo URL_BASE;?>>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/config-marca.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/styles.css" >
    <link href="../assets/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&family=Oswald:wght@300;500;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image" href="../assets/img/favicon.ico"/>
    <title><?php echo $tituloPagina;?></title>
    <meta property="og:url"                content="<?php echo $openGraph['url'];?>" />
	<meta property="og:type"               content="<?php echo $openGraph['type'];?>"/>
	<meta property="og:title"              content="<?php echo $openGraph['title'];?>" />
	<meta property="og:description"        content="<?php echo $openGraph['description'];?>" />
	<meta property="og:image"              content="<?php echo $openGraph['image'];;?>"/>
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '299367741474828');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=299367741474828&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>