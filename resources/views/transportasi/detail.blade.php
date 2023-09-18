@extends('layout/form')
@section('container')

<body style="background-color: #F0f0f0;">
    <div class="card mx-auto mt-5" style="width: 40rem;">
        <div class="card-body">
            <form action="/admin/transportasi/update" method="post">
                @csrf
                <div class="form-floating my-3">
                    <input type="text" name="tt_kode" class="form-control" id="floatingtt_kode" readonly value="{{$response[0]->tt_kode}}">
                    <label for="floatingtt_kode">
                        <h6>Kode Transportasi</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <input type="text" name="tt_nama" class="form-control" id="floatingtt_nama" value="{{$response[0]->tt_nama}}">
                    <label for="floatingtt_nama">
                        <h6>Nama Transportasi</h6>
                    </label>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" id="floatingtt_prov_asal">
                                <option value=null>--Provinsi Asal--</option>
                            </select>
                            <label for="floatingtt_prov_asal">
                                <h6>Provinsi Asal</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select name="tt_kota_asal" class="form-control" id="floatingtt_kota_asal">
                                <option value="{{$response[0]->tt_kota_asal}}">{{$response[0]->tt_kota_asal}}</option>
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
                            <select class="form-control" id="floatingtt_prov_tujuan">
                                <option value=null>--Provinsi Tujuan--</option>
                            </select>
                            <label for="floatingtt_prov_tujuan">
                                <h6>Provinsi Tujuan</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select name="tt_kota_tujuan" class="form-control" id="floatingtt_kota_tujuan">
                                <option value="{{$response[0]->tt_kota_tujuan}}">{{$response[0]->tt_kota_tujuan}}</option>
                            </select>
                            <label for="floatingtt_kota_tujuan">
                                <h6>Kota Tujuan</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-floating my-3">
                    <input type="number" name="tt_pax" class="form-control" id="floatingtt_pax" value="{{$response[0]->tt_pax}}">
                    <label for="floatingtt_pax">
                        <h6>Pax</h6>
                    </label>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp </span>
                    </div>
                    <div class="form-floating">
                        <input type="number" name="tt_harga" class="form-control" id="floatingtt_harga" value="{{$response[0]->tt_harga}}" step="1000">
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
        fetch("https://dev.farizdotid.com/api/daerahindonesia/provinsi")
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                let listProvinsi = data.provinsi
                $('#floatingtt_prov_asal').append(listProvinsi.map(function(provs) {
                        return $('<option>', {
                            text: provs.nama,
                            value: provs.id
                        })
                    }))
                    .change(function() {
                        // console.log("prov asal ", this.value)
                        fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' + this.value, {method:"GET"})
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                // console.log(data.kota_kabupaten)
                                let listKotaAsal = data.kota_kabupaten
                                $('#floatingtt_kota_asal').empty();
                                $('#floatingtt_kota_asal').append(listKotaAsal.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.nama,
                                            value: kota.nama
                                        })
                                    }))
                                    .change(function() {
                                        // console.log("kota asal", this.value)
                                    })
                            })
                    })
                $('#floatingtt_prov_tujuan').append(listProvinsi.map(function(provs) {
                        return $('<option>', {
                            text: provs.nama,
                            value: provs.id
                        })
                    }))
                    .change(function() {
                        // console.log("prov tujuan ", this.value)
                        fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' + this.value)
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                // console.log(data.kota_kabupaten)
                                let listKotaTujuan = data.kota_kabupaten
                                $('#floatingtt_kota_tujuan').empty();
                                $('#floatingtt_kota_tujuan').append(listKotaTujuan.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.nama,
                                            value: kota.nama
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