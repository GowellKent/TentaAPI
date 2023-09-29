@extends('layout/form')
@section('container')
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card mx-auto mt-5" style="width: 40rem;">
                    <div class="card-body">
                        <form action="/admin/paket/update" method="post">
                            @csrf
                            <div class="form-floating my-3">
                                <input type="text" name="tph_kode" class="form-control" readonly
                                    value="{{ $response[0]->tph_kode }}" id="floatingtph_kode">
                                <label for="floatingtph_kode">
                                    <h6>Kode Paket</h6>
                                </label>
                            </div>
                            <div class="form-floating">
                                <select class="form-control" id="floatingtph_tjt_kode" name="tph_tjt_kode">
                                    <option value="{{ $response[0]->tph_tjt_kode }}">{{ $response[0]->tjt_desc }}</option>
                                </select>
                                <label for="floatingtph_tjt_kode">
                                    <h6>Jenis Paket</h6>
                                </label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="text" name="tph_nama" class="form-control" id="floatingtph_nama"
                                    value="{{ $response[0]->tph_nama }}">
                                <label for="floatingtph_nama">
                                    <h6>Nama Paket</h6>
                                </label>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-control" id="floatingtph_tp_kode_asal" name="tph_tp_kode_asal">
                                            <option value="{{ $response[0]->tph_tp_kode_asal }}">
                                                {{ $response[0]->prov_asal }}
                                            </option>
                                        </select>
                                        <label for="floatingtph_provinsi_asal">
                                            <h6>Provinsi Asal</h6>
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select name="tph_tk_kode_asal" class="form-control" id="floatingtph_tk_kode_asal">
                                            <option value="{{ $response[0]->tph_tk_kode_asal }}">
                                                {{ $response[0]->kota_asal }}</option>
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
                                        <select class="form-control" id="floatingtph_tp_kode_tujuan"
                                            name="tph_tp_kode_tujuan">
                                            <option value="{{ $response[0]->tph_tp_kode_tujuan }}">
                                                {{ $response[0]->prov_tujuan }}
                                            </option>
                                        </select>
                                        <label for="floatingtph_provinsi_tujuan">
                                            <h6>Provinsi Tujuan</h6>
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select name="tph_tk_kode_tujuan" class="form-control"
                                            id="floatingtph_tk_kode_tujuan">
                                            <option value="{{ $response[0]->tph_tk_kode_tujuan }}">
                                                {{ $response[0]->kota_tujuan }}</option>
                                        </select>
                                        <label for="floatingtph_kota_tujuan">
                                            <h6>Kota Tujuan</h6>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating my-3">
                                <input type="number" name="tph_durasi" class="form-control" id="floatingtph_durasi"
                                    value="{{ $response[0]->tph_durasi }}">
                                <label for="floatingtph_durasi">
                                    <h6>Durasi</h6>
                                </label>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp </span>
                                </div>
                                <div class="form-floating">
                                    <input type="number" name="tph_harga" class="form-control" id="floatingtph_harga"
                                        readonly value="{{ $response[0]->tph_harga }}">
                                    <label for="floatingtph_harga">
                                        <h6>Harga</h6>
                                    </label>
                                </div>
                            </div>
                            <a class="btn mt-3 btn-outline-success float-start"
                                href="/admin/paket/list?tph_kode={{ $response[0]->tph_kode }}"><i
                                    class="bi bi-chevron-right"></i>
                                List Tujuan</a>
                            <button class="btn btn-primary mt-3 float-end" type="submit">Update Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        fetch("/api/daerah/provinsi")
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                $('#floatingtph_tp_kode_asal').append(data.map(function(provs) {
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
                                $('#floatingtph_tk_kode_asal').empty();
                                $('#floatingtph_tk_kode_asal').append(data.map(function(kota) {
                                    return $('<option>', {
                                        text: kota.tk_nama,
                                        value: kota.tk_kode
                                    })
                                }))
                            })
                    })
                $('#floatingtph_tp_kode_tujuan').append(data.map(function(provs) {
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
                                $('#floatingtph_tk_kode_tujuan').empty();
                                $('#floatingtph_tk_kode_tujuan').append(data.map(function(kota) {
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
{{-- <script>
    function getObjek(tot_provinsi, tot_kota) {
        let tot_tjo_kode = $("#floatingtrd_tot_tjo_kode").val()
        // console.log(tot_provinsi, tot_kota)
        fetch('/api/objek/search?tot_provinsi=' + tot_provinsi + '&tot_kota=' + tot_kota).then((response) => {
            return response.json();
        }).then((data) => {
            let listObjek = data
            // console.log(listObjek)
            $('#floatingtpd_tot_kode').empty()
            $('#floatingtpd_tot_kode').append(listObjek.map(function(objek) {
                if (objek.tot_tjo_kode == tot_tjo_kode) {
                    return $('<option>', {
                        text: objek.tot_nama,
                        value: objek.tot_kode
                    })
                }
            }))
        })
    }

    function delDet(tpd_kode) {
        let stringConfirm = "Data reservasi " + tpd_kode + " akan dihapus"
        if (confirm(stringConfirm)) {
            fetch("/detailDelete?tpd_kode=" + tpd_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                    window.location.reload();
                })
        }
    }

    function updateDet(tpd_kode) {
        let stringConfirm = "Data Detail Paket " + tpd_kode + " akan dirubah"
        if (confirm(stringConfirm)) {
            fetch("/updatePaketDet?" + new URLSearchParams({
                    "tpd_kode": tpd_kode,
                    "tpd_hari": $("#floatingtpd_hari" + tpd_kode).val(),
                    "tpd_jam": $("#tpd_jam" + tpd_kode).val()
                }))
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)

                })
        }
    }
</script> --}}
