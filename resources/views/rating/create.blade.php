@extends('layout.master')

@section('content')
    <div class="card-rating">
        <form action="{{ route('rating.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $postingan->id }}">
            <div class="judul">
                <a href="{{ route('detailProduct', ['id' => $postingan->id]) }}"><i class="bi bi-arrow-left" style="color: #2eada7; font-size: 1.5em; font-weight: bold;"></i></a>
                <h5 style="font-weight: bold;">Nilai Product</h5>
                <button type="submit" class="btn-rating">Kirim</button>
            </div>
            <div class="detail-rating">
                @if ($postingan->image)
                    @php
                    $imagePaths = explode(',', $postingan->image);
                    $firstImagePath = trim($imagePaths[0]);
                @endphp
                    <img src="{{ asset($firstImagePath) }}" alt="Gambar Postingan">
                @else
                    <p>Tidak ada gambar yang tersedia.</p>
                @endif
                <p>{{$postingan->nama_menu}}</p>
            </div>
            <center>
                <div class="form-group">
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5" title="5 star">&#9733;</label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="4 star">&#9733;</label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="3 star">&#9733;</label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="2 star">&#9733;</label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="1 star">&#9733;</label>
                    </div>
                    <h5 style="margin-top: 10px; font-weight: bold;">Nilai kepuasanmu terhadap produk ini</h5>
                </div>
            </center>
            <div class="komen">
                <div class="image-create">
                    <div class="form-group">
                        <center><i class="bi bi-camera" style="font-size: 2rem; color: #2eada7;"></i></center>
                        <center>
                        <label for="imageInput" style="cursor: pointer;">
                            <span id="selectedImageCount">Tambahkan Foto</span>
                        </label>
                        <input type="file" name="image[]" id="imageInput" class="form-control-file visually-hidden" required multiple
                            onchange="displayImages()">
                        </center>
                    </div>
                </div>
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="card-komen">
                    <div class="form-group">
                        <label for="comentar"></label>
                        <textarea name="comentar" class="form-control" placeholder="Beritahu pengguna lain mengapa anda menyukai product ini" style="height: 100px;">{{ old('comentar') }}</textarea>
                    </div>
                    @error('comentar')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </form>
    </div>

    <style>
        .card-rating{
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.49);
            margin-top: 100px;
            color: #333;
        }

        .judul {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .btn-rating {
            height: 20px;
            border: none;
            background-color: transparent;
            color: #2eada7;
        }

        .detail-rating{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }

        .detail-rating img{
            width: 100px;
            height: 100px;
        }
        
        .rating {
            font-size: 0;
            direction: rtl;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            width: 30px;
            height: 30px;
            margin: 0 5px;
            font-size: 34px;
            line-height: 30px;
            text-align: center;
            color: #ccc;
            display: inline-block;
        }

        .rating input:checked ~ label {
            color: #ffcc00;
        }

        .image-create{
            width: 100%;
            height: 80px;
            border : 2px solid #2eada7;
            color: #2eada7;
        }

        .visually-hidden {
            position: absolute !important;
            height: 1px;
            width: 1px;
            overflow: hidden;
            clip: rect(1px, 1px, 1px, 1px);
            white-space: nowrap;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var currentRating = document.querySelector('.rating input:checked');
            if (currentRating) {
                currentRating.nextElementSibling.classList.add('checked');
            }

            document.querySelectorAll('.rating input').forEach(function (radioInput) {
                radioInput.addEventListener('change', function (event) {
                    var clickedLabel = event.target.nextElementSibling;
                    document.querySelectorAll('.rating label').forEach(function (label) {
                        label.classList.remove('checked');
                    });
                    clickedLabel.classList.add('checked');
                });
            });
        });
        function displayImages() {
            var input = document.getElementById('imageInput');
            var selectedImageDiv = document.getElementById('selectedImage');
            selectedImageDiv.innerHTML = '';

            function readAndDisplayImage(index) {
                if (index < input.files.length) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Selected Image';
                        img.className = 'selected-img';
                        selectedImageDiv.appendChild(img);

                        readAndDisplayImage(index + 1);
                    };

                    reader.onerror = function(error) {
                        console.error('Error reading image:', error);
                        readAndDisplayImage(index + 1);
                    };

                    reader.readAsDataURL(input.files[index]);
                }
            }
            readAndDisplayImage(0);
        }
        function displayImages() {
            var input = document.getElementById('imageInput');
            var selectedImageCount = document.getElementById('selectedImageCount');

            if (input.files && input.files.length > 0) {
                selectedImageCount.textContent = input.files.length + ' Gambar Dipilih';
            } else {
                selectedImageCount.textContent = 'Tambahkan Foto';
            }
        }
    </script>
@endsection
