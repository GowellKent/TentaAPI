@extends('layout/form')
@section('container')
    {{-- <body style="background-color: #F0f0f0;"> --}}
    <div class="card mx-auto mt-5" style="width: 40rem;">
        <div class="card-body">
            <form action="/admin/paket/create" method="post">
                @csrf
                <div class="form-floating my-3">
                    <input type="text" name="tph_kode" class="form-control" readonly value="AUTO" id="floatingtph_kode">
                    <label for="floatingtph_kode">
                        <h6>Kode Paket</h6>
                    </label>
                </div>
                <div class="form-floating">
                    <select class="form-control" id="floatingtph_tjt_kode" name="tph_tjt_kode">
                        <option value={{ old('tph_tjt_kode') }}>--Jenis Paket--</option>
                    </select>
                    <label for="floatingtph_tjt_kode">
                        <h6>Jenis Paket</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <input type="text" name="tph_nama" class="form-control" id="floatingtph_nama"
                        value="{{ old('tph_nama') }}">
                    <label for="floatingtph_nama">
                        <h6>Nama Paket</h6>
                    </label>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" id="floatingtph_provinsi_asal" name="tph_tp_kode_asal">
                                <option value={{ old('tph_tp_kode_asal') }}>--Provinsi Asal--</option>
                            </select>
                            <label for="floatingtph_provinsi_asal">
                                <h6>Provinsi Asal</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select name="tph_tk_kode_asal" class="form-control" id="floatingtph_kota_asal">
                                <option value="{{ old('tph_tk_kode_asal') }}">--Select--</option>
                            </select>
                            <label for="floatingtph_kota_asal">
                                <h6>Kota Asal</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" id="floatingtph_provinsi_tujuan" name="tph_tp_kode_tujuan">
                                <option value={{ old('tph_tp_kode_tujuan') }}>--Provinsi Tujuan--</option>
                            </select>
                            <label for="floatingtph_provinsi_tujuan">
                                <h6>Provinsi Tujuan</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select name="tph_tk_kode_tujuan" class="form-control" id="floatingtph_kota_tujuan">
                                <option value="{{ old('tph_tk_kode_tujuan') }}">--Select--</option>
                            </select>
                            <label for="floatingtph_kota_tujuan">
                                <h6>Kota Tujuan</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-floating my-3">
                    <input type="number" name="tph_durasi" class="form-control" id="floatingtph_durasi"
                        value="{{ old('tph_durasi') }}">
                    <label for="floatingtph_durasi">
                        <h6>Durasi</h6>
                    </label>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp </span>
                    </div>
                    <div class="form-floating">
                        <input type="number" name="tph_harga" class="form-control" id="floatingtph_harga" readonly
                            value="0">
                        <label for="floatingtph_harga">
                            <h6>Harga</h6>
                        </label>
                    </div>
                </div>

                <button class="btn btn-primary mt-3 float-end" type="submit">Insert Data</button>
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
                $('#floatingtph_provinsi_asal').append(data.map(function(provs) {
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
                                $('#floatingtph_kota_asal').empty();
                                $('#floatingtph_kota_asal').append(data.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.tk_nama,
                                            value: kota.tk_kode
                                        })
                                    }))
                            })
                    })
                $('#floatingtph_provinsi_tujuan').append(data.map(function(provs) {
                        return $('<option>', {
                            text: provs.tp_nama,
                            value: provs.tp_kode
                        })
                    }))
                    .change(function() {
                        fetch('/api/daerah/kota?id_provinsi=' + this
                                .value)
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                $('#floatingtph_kota_tujuan').empty();
                                $('#floatingtph_kota_tujuan').append(data.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.tk_nama,
                                            value: kota.tk_kode
                                        })
                                    }))
                            })
                    })
            });

        fetch('/api/paket/head/jenis')
            .then((response) => {
                // console.log(response.json())
                return response.json()
            })
            .then((data) => {
                let listJenis = data
                $('#floatingtph_tjt_kode').append(listJenis.map(function(jenis) {
                    return $('<option>', {
                        text: jenis.tjt_desc,
                        value: jenis.tjt_kode
                    })
                }))
            })
    });
</script>
