@extends('layout/form')
@section('container')
    <div class="card mx-auto mt-5" style="width: 40rem;">

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
            <div class="carousel-inner">
                @foreach ($path as $key => $path)
                    @if ($key == 0)
                        <div class="carousel-item active">
                            <img src={{ '/' . $path->tfo_path }} alt="..."class="card-img-top">
                        </div>
                    @else
                        <div class="carousel-item">
                            <img src={{ '/' . $path->tfo_path }} alt="..."class="card-img-top">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="#carouselExampleControls" data-slide="prev" class="btn btn-lg float-end"><i
                        class="bi bi-chevron-left text-success"></i></a>
            </div>
            <div class="col">
                <a href="#carouselExampleControls" data-slide="next" class="btn btn-lg float-start"><i
                        class="bi bi-chevron-right text-success"></i></a>
            </div>
        </div>


        {{-- <img src={{ '/'.$path[0]->tfo_path }} alt="..."class="card-img-top" > --}}
        {{-- <img src="{{ $response[0]->tot_foto }}" alt="foto_objek" class="my-3 px-3 img-fluid"> --}}
        <div class="card-body">
            <form action="/admin/objek/update" method="post">
                @csrf
                <div class="row">
                    <div class="col-9">
                        <div class="form-floating my-3">
                            <input type="text" name="tot_kode" class="form-control" readonly
                                value="{{ $response[0]->tot_kode }}" id="floatingtot_kode">
                            <label for="floatingtot_kode">
                                <h6>Kode Objek</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col-3">
                        <a class="btn btn-outline-secondary mt-4 float-start" type="button"
                            href="{{ '/admin/objek/listfoto?tot_kode=' . $response[0]->tot_kode }}">Foto Objek <i
                                class="bi bi-image"></i></a>
                    </div>
                </div>
                <div class="form-floating">
                    <select class="form-control" id="floatingtot_tjo_kode" name="tot_tjo_kode">
                        <option value="{{ $response[0]->tot_tjo_kode }}">{{ $response[0]->tjo_desc }}</option>
                    </select>
                    <label for="floatingtot_tjo_kode">
                        <h6>Jenis Objek</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <input type="text" name="tot_nama" class="form-control" id="floatingtot_nama"
                        value="{{ $response[0]->tot_nama }}">
                    <label for="floatingtot_nama">
                        <h6>Nama Objek</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <input type="text" name="tot_telp" class="form-control" id="floatingtot_telp"
                        value="{{ $response[0]->tot_telp }}">
                    <label for="floatingtot_telp">
                        <h6>Telepon</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <textarea type="text" name="tot_alamat" class="form-control" id="floatingtot_alamat" style="height: 7rem;">{{ $response[0]->tot_alamat }}</textarea>
                    <label for="floatingtot_alamat">
                        <h6>Alamat</h6>
                    </label>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" id="floatingtot_provinsi" name="tot_tp_kode">
                                <option value="{{ $response[0]->tot_tp_kode }}">{{ $response[0]->tp_nama }}</option>
                            </select>
                            <label for="floatingtot_provinsi">
                                <h6>Provinsi</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select name="tot_tk_kode" class="form-control" id="floatingtot_kota">
                                <option value="{{ $response[0]->tot_tk_kode }}">{{ $response[0]->tk_nama }}</option>
                            </select>
                            <label for="floatingtot_kota">
                                <h6>Kota</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp </span>
                    </div>
                    <div class="form-floating">
                        <input type="number" name="tot_harga" class="form-control" id="floatingtot_harga" step="1000"
                            value="{{ $response[0]->tot_harga }}">
                        <label for="floatingtot_harga">
                            <h6>Harga</h6>
                        </label>
                    </div>
                </div>
                <button class="btn btn-primary mt-3 float-end" type="submit">Update Data</button>
            </form>
        </div>
    </div>
    {{-- </body> --}}
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        fetch("/api/daerah/provinsi")
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                $('#floatingtot_provinsi').append(data.map(function(provs) {
                        return $('<option>', {
                            text: provs.tp_nama,
                            value: provs.tp_kode
                        })
                    }))
                    .change(function() {
                        fetch('/api/daerah/kota?id_provinsi=' + this
                                .value, {
                                    method: "GET"
                                })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                $('#floatingtot_kota').empty();
                                $('#floatingtot_kota').append(data.map(function(kota) {
                                    return $('<option>', {
                                        text: kota.tk_nama,
                                        value: kota.tk_kode
                                    })
                                }))
                            })
                    })
            });

        fetch('/api/objek/jenis')
            .then((response) => {
                return response.json()
            })
            .then((data) => {
                let listJenis = data
                $('#floatingtot_tjo_kode').append(listJenis.map(function(jenis) {
                    return $('<option>', {
                        text: jenis.tjo_desc,
                        value: jenis.tjo_kode
                    })
                }))
            })
    });
</script>
