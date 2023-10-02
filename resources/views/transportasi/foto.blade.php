@extends('layout/form')
@section('container')

    <body>
        <div class="card mx-auto mt-5" style="width: 40rem;">

            @if ($message = Session::get('success'))
                <img src={{ '/fotoTransport/' . Session::get('file') }} class="card-img-top">
            @endif

            <div class="card-body">

                <form action="/admin/transportasi/foto" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-floating my-3">
                        <input type="text" name="tft_tt_kode" class="form-control" readonly
                            value="{{ $response->tt_kode }}" id="floatingtft_tt_kode">
                        <label for="floatingtft_tt_kode">
                            <h6>Kode Objek</h6>
                        </label>
                    </div>
                    <label for="chooseFile">Select file</label>
                    <input type="file" name="file" class="form-control" id="chooseFile">
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4 float-end">
                        Upload Foto
                    </button>
                </form>

            </div>
        </div>
    </body>
@endsection

<style>
    .container {
        max-width: 500px;
    }

    dl,
    ol,
    ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
</style>
