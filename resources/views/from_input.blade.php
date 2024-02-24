<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="{{ asset('desain/css/galery.css')}}">
</head>

<style>
    body {
  margin: 0;
  background-image: url("{{ asset('img/contoh.gif') }}");
  background-size: cover;
}

.text-blk{
    text-decoration: none;
    color: white;
    font-weight: bold;
}
</style>

<body>
    <div class="desktop_7" unique-script-id="w-w-dm-id">
        <div class="responsive-container-block bigContainer">
            <div class="responsive-container-block Container">
                <p class="text-blk headingText">
                    Kedu Warna
                </p>
                <div class="responsive-container-block optionsContainer">
                    <a href="{{ route('home') }}" class="text-blk  list">
                        Home
                    </a>
                    <a href="{{ route('from_input') }}" class="text-blk  list">
                        Gallery
                    </a>
                    <a href="{{ route('login') }}" class="text-blk  list">
                        Login
                    </a>
                    <p class="text-blk list" data-filter="three">
                        Option
                    </p>
                    <p class="text-blk list" data-filter="four">
                        Option
                    </p>
                    <p class="text-blk list" data-filter="four">
                        Option
                    </p>
                </div>
                <div class="responsive-container-block imageContainer">
                    <div class="project">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <button class="close">
                                    Close X
                                </button>
                                <div class="hdImgs">
                                    <img alt="" class="againImg"
                                        src="{{ asset('img/1.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <img class="squareImg one"
                            src="{{ asset('img/1.jpg') }}">
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                    <div class="project">
                        <img class="squareImg two"
                            src="{{ asset('img/2.jpg') }}">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <button class="close">
                                    Close X
                                </button>
                                <div class="hdImgs">
                                    <img class="squareImg two"
                                        src="{{ asset('img/2.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                    <div class="project">
                        <img class="squareImg three"
                            src="{{ asset('img/3.jpg') }}">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <button class="close">
                                    Close X
                                </button>
                                <div class="hdImgs">
                                    <img alt="" class="againImg"
                                        src="{{ asset('img/3.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                    <div class="project">
                        <img class="squareImg four"
                            src="{{ asset('img/4.jpg') }}">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <button class="close">
                                    Close X
                                </button>
                                <div class="hdImgs">
                                    <img alt="" class="againImg"
                                        src="{{ asset('img/4.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                    <div class="project">
                        <img class="squareImg five"
                            src="{{ asset('img/5.jpg') }}">
                        <div class="hdImg">
                            <img alt="" class="againImg"
                                src="{{ asset('img/5.jpg') }}">
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                    <div class="project">
                        <img class="squareImg one"
                            src="{{ asset('img/6.jpg') }}">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <button class="close">
                                    Close X
                                </button>
                                <div class="hdImgs">
                                    <img alt="" class="againImg"
                                        src="{{ asset('img/6.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                    <div class="project">
                        <img class="squareImg two"
                            src="{{ asset('img/7.jpg') }}">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <button class="close">
                                    Close X
                                </button>
                                <div class="hdImgs">
                                    <img alt="" class="againImg"
                                        src="{{ asset('img/7.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                    <div class="project">
                        <img class="squareImg three"
                            src="{{ asset('img/8.jpg') }}">
                        <div class="overlay">
                            <div class="overlay-inner">
                                <button class="close">
                                    Close X
                                </button>
                                <div class="hdImgs">
                                    <img alt="" class="againImg"
                                        src="{{ asset('img/8.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                View
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('desain/js/script.js') }}"></script>

</html>