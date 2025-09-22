<title> {{ isset($metaData["title"]) && !empty($metaData["title"]) ? $metaData["title"] : 'MatrixLabs | Made In Gujarat' }} </title>

<link rel="icon" type="image/png" href="{{ asset('assets/images/logo-icon.png') }}">

<link rel="canonical" href="{{ isset($metaData['url']) && !empty($metaData['url']) ? $metaData['url'] : 'https://www.gujjuticks.com/' }}">

<meta name="description" content="{{ isset($metaData['description']) && !empty($metaData['description']) ? $metaData['description'] : 'Discover affordable and free essential services tailored for the Gujarati community at GujjuTicks.com. From education and social media to work management and daily task, access what you need at unbeatable prices or completely free. Join us in empowering the Gujarati community today!' }}">
<meta name="author" content="GujjuTicks">

<meta property="og:type" content="website">
<meta property="og:url" content="{{ isset($metaData['url']) && !empty($metaData['url']) ? $metaData['url'] : 'https://www.gujjuticks.com/' }}">
<meta property="og:title" content="{{ isset($metaData['title']) && !empty($metaData['title']) ? $metaData['title'] : 'MatrixLabs | Made In Gujarat' }}">
<meta property="og:description" content="{{ isset($metaData['description']) && !empty($metaData['description']) ? $metaData['description'] : 'Discover affordable and free essential services tailored for the Gujarati community at GujjuTicks.com. From education and social media to work management and daily task, access what you need at unbeatable prices or completely free. Join us in empowering the Gujarati community today!' }}">
<meta property="og:image" content="{{ isset($metaData['image']) && !empty($metaData['image']) ? $metaData['image'] : asset('brand/full-logo-black.png') }}">

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ isset($metaData['url']) && !empty($metaData['url']) ? $metaData['url'] : 'https://www.gujjuticks.com/' }}">
<meta property="twitter:title" content="{{ isset($metaData['title']) && !empty($metaData['title']) ? $metaData['title'] : 'MatrixLabs | Made In Gujarat' }}">
<meta property="twitter:description" content="{{ isset($metaData['description']) && !empty($metaData['description']) ? $metaData['description'] : 'Discover affordable and free essential services tailored for the Gujarati community at GujjuTicks.com. From education and social media to work management and daily task, access what you need at unbeatable prices or completely free. Join us in empowering the Gujarati community today!' }}">
<meta property="twitter:image" content="{{ isset($metaData['image']) && !empty($metaData['image']) ? $metaData['image'] : asset('brand/full-logo-black.png') }}">