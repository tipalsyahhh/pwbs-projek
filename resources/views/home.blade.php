<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('desain/css/home.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="container" id="animated-container">
        <div class="text-isi">
            <p style="font-weight: bold;">Novsosiaplaze</p>
            <i class="bi bi-three-dots" style="color: #333"></i>
            <h1>Welcome</h1>
            <h2>Sosial media and marketplace</h2>
            <p>Novsosiaplaze adalah tempat yang menyenangkan untuk menjelajahi dunia sosial media dan berbelanja.</p>
        </div>
        <center>
            <div class="image-nov">
                <img src="{{ asset('img/no-keranjang.png') }}" alt="">
            </div>
        </center>
        <center>
            <div class="bawah-home">
                <p>Klik next untuk login dan nikmati fiture di Novsosiaplaze</p>
                <a href="{{ route('login') }}" class="button-home">NEXT</a>
            </div>
        </center>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        var container = document.getElementById("animated-container");
        container.classList.add("fade-in");
        });
  </script>
</body>
</html>