<!DOCTYPE html>
<html>

<head>
  <title>{{ $profil->nama_profil }}</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <!--  Favicon -->
  <link rel="shortcut icon" type="image/png" href="/upload/profil/{{ $profil->favicon }}" />
  <style>
    body,
    h1 {
      font-family: "Raleway", sans-serif
    }

    body,
    html {
      height: 100%
    }

    .bgimg {
      background-image: url('https://images.hdqwalls.com/download/retrowave-road-car-4k-j1-3840x2400.jpg');
      min-height: 100%;
      background-position: center;
      background-size: cover;
    }
  </style>
</head>

<body>

  <div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
    <div class="w3-display-topleft w3-padding-large w3-xlarge">
      <a href="" class="text-nowrap logo-img d-block px-4 py-9 w-100">
        <img src="/upload/profil/{{ $profil->favicon }}" width="60" alt="">
      </a>
    </div>
    <div class="w3-display-middle">
      <a href="{{ route('login') }}">
        <h1 class="w3-jumbo w3-animate-top">MY LOGIN SYSTEM</h1>
      </a>
      <hr class="w3-border-grey" style="margin:auto;width:40%">
      <p class="w3-large w3-center">Silahkan Login Untuk Menggunakan Sistem Ini</p>
    </div>
    <div class="w3-display-bottomleft w3-padding-large">
      Powered by <a href="#" target="_blank">{{ $profil->nama_profil }}</a>
    </div>
  </div>

</body>

</html>