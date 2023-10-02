@extends('layout/form')
@section('container')

    <body style="background-color: #F0f0f0;">
        <div class="card mx-auto mt-5" style="width: 40rem;">

            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    @foreach ($path as $key => $path)
                        @if ($key == 0)
                            <div class="carousel-item active">
                                <img src={{ '/' . $path->tft_path }} alt="..." class="card-img-top">
                            </div>
                        @else
                            <div class="carousel-item">
                                <img src={{ '/' . $path->tft_path }} alt="..." class="card-img-top">
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

                <div class="card-body mx-3">
                    <form action="/admin/transportasi/update" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-9">
                                <div class="form-floating my-3">
                                    <input type="text" name="tt_kode" class="form-control" id="floatingtt_kode" readonly
                                        value="{{ $response[0]->tt_kode }}">
                                    <label for="floatingtt_kode">
                                        <h6>Kode Transportasi</h6>
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <a class="btn btn-outline-secondary mt-4 float-start float-end" type="button"
                                    href="{{ '/admin/transportasi/listfoto?tt_kode=' . $response[0]->tt_kode }}">Foto <i
                                        class="bi bi-image"></i></a>
                            </div>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="tt_nama" class="form-control" id="floatingtt_nama"
                                value="{{ $response[0]->tt_nama }}">
                            <label for="floatingtt_nama">
                                <h6>Nama Transportasi</h6>
                            </label>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <div class="form-floating">
                                    <select class="form-control" id="floatingtt_prov_asal" name="tt_tp_kode_asal">
                                        <option value="{{ $response[0]->tt_tp_kode_asal }}">
                                            {{ $response[0]->tt_provinsi_asal }}</option>
                                    </select>
                                    <label for="floatingtt_prov_asal">
                                        <h6>Provinsi Asal</h6>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <select name="tt_tk_kode_asal" class="form-control" id="floatingtt_kota_asal">
                                        <option value="{{ $response[0]->tt_tk_kode_asal }}">{{ $response[0]->tt_kota_asal }}
                                        </option>
                                    </select>
                                    <label for="floatingtt_kota_asal">
                                        <h6>Kota Asal</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <div class="form-floating">
                                    <select name="tt_tp_kode_tujuan" class="form-control" id="floatingtt_prov_tujuan">
                                        <option value="{{ $response[0]->tt_tp_kode_tujuan }}">
                                            {{ $response[0]->tt_provinsi_tujuan }}</option>
                                    </select>
                                    <label for="floatingtt_prov_tujuan">
                                        <h6>Provinsi Tujuan</h6>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <select name="tt_tk_kode_tujuan" class="form-control" id="floatingtt_tk_kode_tujuan">
                                        <option value="{{ $response[0]->tt_tk_kode_tujuan }}">
                                            {{ $response[0]->tt_kota_tujuan }}</option>
                                    </select>
                                    <label for="floatingtt_kota_tujuan">
                                        <h6>Kota Tujuan</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating my-3">
                            <input type="number" name="tt_pax" class="form-control" id="floatingtt_pax"
                                value="{{ $response[0]->tt_pax }}">
                            <label for="floatingtt_pax">
                                <h6>Pax</h6>
                            </label>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp </span>
                            </div>
                            <div class="form-floating">
                                <input type="number" name="tt_harga" class="form-control" id="floatingtt_harga"
                                    value="{{ $response[0]->tt_harga }}" step="1000">
                                <label for="floatingtt_harga">
                                    <h6>Harga</h6>
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-3 float-end" type="submit">Update Data</button>
                    </form>
                </div>
            </div>
    </body>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // fetch("https://dev.farizdotid.com/api/daerahindonesia/provinsi")
        fetch("/api/daerah/provinsi")
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                // let listProvinsi = data.provinsi
                $('#floatingtt_prov_asal').append(data.map(function(provs) {
                        return $('<option>', {
                            text: provs.tp_nama,
                            value: provs.tp_kode
                        })
                    }))
                    .change(function() {
                        // console.log("prov asal ", this.value)
                        // fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' + this.value, {method:"GET"})
                        fetch('/api/daerah/kota?id_provinsi=' + this.value, {
                                method: "GET"
                            })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                // console.log(data.kota_kabupaten)
                                // let listKotaAsal = data.kota_kabupaten
                                $('#floatingtt_kota_asal').empty();
                                $('#floatingtt_kota_asal').append(data.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.tk_nama,
                                            value: kota.tk_kode
                                        })
                                    }))
                                    .change(function() {
                                        // console.log("kota asal", this.value)
                                    })
                            })
                    })
                $('#floatingtt_prov_tujuan').append(data.map(function(provs) {
                        return $('<option>', {
                            text: provs.tp_nama,
                            value: provs.tp_kode
                        })
                    }))
                    .change(function() {
                        // console.log("prov tujuan ", this.value)
                        // fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' + this.value)
                        fetch('/api/daerah/kota?id_provinsi=' + this.value)
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                // console.log(data.kota_kabupaten)
                                // let listKotaTujuan = data.kota_kabupaten
                                $('#floatingtt_kota_tujuan').empty();
                                $('#floatingtt_kota_tujuan').append(data.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.tk_nama,
                                            value: kota.tk_kode
                                        })
                                    }))
                                    .change(function() {
                                        // console.log("kota asal", this.value)
                                    })
                            })
                    })
            });
    });
</script>
