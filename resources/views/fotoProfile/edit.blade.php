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
        margin-top: 20px;
    }

    .img-pp {
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
        margin-bottom: 15px;
    }

    .inputfile {
        display: none;
    }
</style>

@section('content')

<div class="card-foto-profile">
    <form action="{{ route('foto-profile.update', ['user_id' => $user->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <center><img class="img-pp" id="preview" src="#" alt="Preview" style="display: none;"></center>
            <div class="form-group">
                <div class="label-pp">
                    <label for="image" style="font-weight: bold; color: #333; font-size: 25px;">Ubah Foto Profil</label>
                </div>
                <center>
                    <div class="input-pp">
                        <input class="inputfile" type="file" name="image" id="image" accept="image/*" style="display: none;"
                            onchange="previewImage(event)">
                        <label for="image" style="cursor: pointer; margin-bottom: 0;">Choose Files</label>
                    </div>
                </center>
            </div>
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <button type="submit" class="btn" style="background-color: #2eada7; color: white;">Simpan</button>
        </div>
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