@extends('layout.master')

<style>
.card-foto-profile {
    width: 100%;
    border: 1px solid #ddd;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    height: auto;
    text-align: center;
    }

    .img-pp{
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin-bottom: 15px;
        margin-top: 15px;
        object-fit: cover;
    }
    
    .input-pp{
        width: 80%;
        height: 40px;
        border-radius: 50px;
        border: 1px solid #2eada7;
        align-items: center;
        justify-content: center;
        display: flex;
        color: #333;
        font-weight: bold;
    }

    .inputfile {
        display: none;
    }
</style>

@section('judul')
    Unggah Gambar Profil
@endsection

@section('content')
    <div class="card-foto-profile">
        <form method="post" action="{{ route('profile.uploadImage') }}" enctype="multipart/form-data">
            @csrf
            <center>
                <img class="img-pp" id="preview" src="#" alt="Preview" style="display: none;">
            </center>
            <div class="form-group">
                <div class="label-pp">
                    <label for="image" style="font-weight: bold; color: #333; font-size: 25px; cursor: pointer;">Unggah Foto
                        Profil</label>
                </div>
                <center>
                    <div class="input-pp">
                        <input class="inputfile" type="file" name="image" id="image" style="display: none;"
                            onchange="previewImage(event)">
                        <p onclick="document.getElementById('image').click();" style="cursor: pointer; margin-bottom: 0;">Choose Files</p>
                    </div>
                </center>
            </div>
        
            @error('image')
            <div class="alert alert-warning">{{ $message }}</div>
            @enderror
        
            <button type="submit" class="btn" style="background-color: #2eada7; color: white;"><i class="bi bi-upload"></i>
                Post</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection