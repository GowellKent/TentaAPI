@extends('layout/form')
@section('container')
    {{-- <body style="background-color: #F0f0f0;"> --}}
    <div class="row">
        <div class="col align-self-center">
            {{-- <a href="#carouselExampleControls" data-slide="prev" class="btn btn-lg"><i class="bi bi-chevron-left text-success"
                    style="font-size: 2.5rem"></i></a> --}}
        </div>
        <div class="col-10">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <form action="/admin/reservasi/create" method="post">
                        @csrf
                        <div class="carousel-item active"> {{-- page 1 --}}
                            <div class="card mx-auto mt-5" style="width: 40rem;">
                                <div class="card-body">
                                    <div class="form-floating my-3">
                                        <input type="text" name="trh_kode" class="form-control" readonly value="AUTO"
                                            id="floatingtrh_kode">
                                        <label for="floatingtrh_kode">
                                            <h6>Kode Reservasi</h6>
                                        </label>
                                    </div>
                                    <div class="form-floating my-3">
                                        <input type="text" name="trh_tu_kode" class="form-control" readonly
                                            value="1" id="floatingtrh_tu_kode">
                                        <label for="floatingtrh_tu_kode">
                                            <h6>Kode Client</h6>
                                        </label>
                                    </div>
                                    <div class="form-floating">
                                        <select class="form-control" id="floatingtrh_tjt_kode" name="trh_tjt_kode">
                                            <option value=null>--Jenis Trip--</option>
                                        </select>
                                        <label for="floatingtrh_tjt_kode">
                                            <h6>Jenis Trip</h6>
                                        </label>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <select class="form-control" id="floatingtrh_provinsi_asal"
                                                    name="trh_provinsi_asal">
                                                    <option value="{{ old('trh_provinsi_asal') }}">--Provinsi Asal--
                                                    </option>
                                                </select>
                                                <label for="floatingtrh_provinsi_asal">
                                                    <h6>Provinsi Asal</h6>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <select name="trh_kota_asal" class="form-control"
                                                    id="floatingtrh_kota_asal">
                                                    <option value="{{ old('trh_kota_asal') }}">--Select--</option>
                                                </select>
                                                <label for="floatingtrh_kota_asal">
                                                    <h6>Kota Asal</h6>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <select class="form-control" id="floatingtrh_provinsi_tujuan"
                                                    name="trh_provinsi_tujuan">
                                                    <option value="{{ old('trh_provinsi_tujuan') }}">--Provinsi Tujuan--
                                                    </option>
                                                </select>
                                                <label for="floatingtrh_provinsi_tujuan">
                                                    <h6>Provinsi Tujuan</h6>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <select name="trh_kota_tujuan" class="form-control"
                                                    id="floatingtrh_kota_tujuan">
                                                    <option value="{{ old('trh_kota_tujuan') }}">--Select--</option>
                                                </select>
                                                <label for="floatingtrh_kota_tujuan">
                                                    <h6>Kota Tujuan</h6>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating my-3">
                                        <input type="date" name="trh_tgl_jalan" class="form-control"
                                            id="floatingtrh_tgl_jalan" value="{{ old('trh_tgl_jalan') }}">
                                        <label for="floatingtrh_tgl_jalan">
                                            <h6>Tanggal Perjalanan</h6>
                                        </label>
                                    </div>
                                    <div class="form-floating my-3">
                                        <input type="number" name="trh_pax" class="form-control" id="floatingtrh_pax"
                                            value="{{ old('trh_pax') }}">
                                        <label for="floatingtrh_pax">
                                            <h6>Pax</h6>
                                        </label>
                                    </div>

                                    <div class="row">
                                        <div class="col float-end">
                                            <a class="btn btn-primary mt-3 float-end" data-slide="next"
                                                href="#carouselExampleControls" style="max-width: fit-content"
                                                onclick="searchPaket()">Paket <i class="bi bi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item"> {{-- page2 --}}
                            <div class="card mx-auto mt-5" style="width: 40rem;">
                                <div class="card-header" style="background-color: #007363">
                                    <h3 class="card-title mt-3 text-light">Pilih Paket Wisata</h3>
                                </div>
                                <div class="card-body">

                                    <div class="form-floating">
                                        <div id="radio"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col float-end">
                                            <a class="btn btn-outline-primary mt-3 float-start" data-slide="prev"
                                                href="#carouselExampleControls" style="max-width: fit-content">Data <i
                                                    class="bi bi-chevron-left"></i></a>
                                        </div>
                                        <div class="col float-end">
                                            <a class="btn btn-primary mt-3 float-end" data-slide="next"
                                                href="#carouselExampleControls" style="max-width: fit-content"
                                                onclick="searchBus()">Transportasi <i class="bi bi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item"> {{-- page3 --}}
                            <div class="card mx-auto mt-5" style="width: 40rem;">
                                <div class="card-header" style="background-color: #007363">
                                    <h3 class="card-title mt-3 text-light">Pilih transportasi</h3>
                                </div>
                                <div class="card-body">

                                        <div class="form-floating">
                                            <div id="radioTp"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col float-end">
                                                <a class="btn btn-outline-primary mt-3 float-start" data-slide="prev"
                                                    href="#carouselExampleControls" style="max-width: fit-content">Paket
                                                    <i class="bi bi-chevron-left"></i></a>
                                            </div>
                                            <div class="col float-end">
                                                <button class="btn btn-success mt-3 float-end" type="submit" style="max-width: fit-content">Insert
                                                    Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col align-self-center">
            {{-- <a href="#carouselExampleControls" data-slide="next" class="btn btn-lg"><i
                    class="bi bi-chevron-right text-success" style="font-size: 2.5rem"></i></a> --}}
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
                $('#floatingtrh_provinsi_asal').append(data.map(function(provs) {
                        return $('<option>', {
                            text: provs.tp_nama,
                            value: provs.tp_kode
                        })
                    }))
                    .change(function() {
                        // console.log("prov asal ", this.value)
                        // fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' + this
                        fetch('/api/daerah/kota?id_provinsi=' + this
                                .value, {
                                    method: "GET"
                                })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                // console.log(data.kota_kabupaten)
                                // let listKotaAsal = data.kota_kabupaten
                                $('#floatingtrh_kota_asal').empty();
                                $('#floatingtrh_kota_asal').append(data.map(function(kota) {
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
                $('#floatingtrh_provinsi_tujuan').append(data.map(function(provs) {
                        return $('<option>', {
                            text: provs.tp_nama,
                            value: provs.tp_kode
                        })
                    }))
                    .change(function() {
                        // console.log("prov tujuan ", this.value)
                        fetch('/api/daerah/kota?id_provinsi=' + this
                                .value)
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                // console.log(data.kota_kabupaten)
                                $('#floatingtrh_kota_tujuan').empty();
                                $('#floatingtrh_kota_tujuan').append(data.map(function(kota) {
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


        fetch('/api/paket/head/jenis')
            .then((response) => {
                return response.json()
            })
            .then((data) => {
                let listJenis = data
                $('#floatingtrh_tjt_kode').append(listJenis.map(function(jenis) {
                    return $('<option>', {
                        text: jenis.tjt_desc,
                        value: jenis.tjt_kode
                    })
                })).change(function() {
                    $("#floatingtrh_tph_kode").empty();
                })
            })
    });
</script>
<script>
    function searchPaket() {

        $('#floatingtrh_tph_kode').empty()

        let kota_asal = $("#floatingtrh_kota_asal").val()
        let kota_tujuan = $("#floatingtrh_kota_tujuan").val()
        let tjt_kode = $("#floatingtrh_tjt_kode").val()

        fetch("/api/paket/head/search?" + new URLSearchParams({
            "tph_tk_kode_asal": kota_asal,
            "tph_tk_kode_tujuan": kota_tujuan,
            "tph_tjt_kode": tjt_kode
        })).then((response) => {
            return response.json();
        }).catch((err) => {
            console.log(err)
        }).then((data) => {
            $('#radio').empty();
            let listPaket = data
            if (listPaket.length != undefined) {
                    // console.log(303, data)
                for (i = 0; i < listPaket.length; i++) {
                    // var radioBtn = $('<input type="radio" name="trh_tph_kode">'+listPaket[i].tph_nama+'</input><br>');
                    var bodyString = listPaket[i].tph_durasi+' hari, Rp '+listPaket[i].tph_harga+' /Pax'
                    var radioBtn = $(' <label><input id="listpaket" type="radio" name="trh_tph_kode" value='+listPaket[i].tph_kode+' class="card-input-element" /><div class="card card-default card-input"><div class="card-header text-light" style="background-color:#00BFA6"><strong>'+listPaket[i].tph_nama+'</strong></div><div class="card-body" style="background-color:#ffffff">'+bodyString+'</div></div></label>');
                    radioBtn.appendTo('#radio');
                }
            }
        })
    }

    function searchBus() {
        $('#floatingtrh_tb_kode').empty()

        let kota_asal = $("#floatingtrh_kota_asal").val()
        let kota_tujuan = $("#floatingtrh_kota_tujuan").val()
        let tb_pax = $("#floatingtrh_pax").val()

        fetch("/api/transport/search?" + new URLSearchParams({
            "tt_tk_kode_asal": kota_asal,
            "tt_tk_kode_tujuan": kota_tujuan
        })).then((response) => {
            return response.json();
        }).catch((err) => {
            console.log(err)
        }).then((data) => {
            $('#radioTp').empty();
            let listBus = data
            if (listBus.length != undefined) {
                // $('#floatingtrh_tb_kode').append(listBus.map(function(Bus) {
                //     textString = Bus.tb_nama + ", " + Bus.tb_pax + " Pax, Rp " + Bus.tb_harga
                //     return $('<option>', {
                //         text: textString,
                //         value: Bus.tb_kode
                //     })
                // }))
                for (i = 0; i < listBus.length; i++) {
                    // var radioBtn = $('<input type="radio" name="trh_tph_kode">'+listBus[i].tph_nama+'</input><br>');
                    var bodyString = 'Max'+listBus[i].tt_pax+' pax, Rp '+listBus[i].tt_harga+' /Pax'
                    var radioBtn = $(' <label><input id="listBus" type="radio" name="trh_tt_kode" value='+listBus[i].tt_kode+' class="card-input-element" /><div class="card card-default card-input"><div class="card-header text-light" style="background-color:#00BFA6"><strong>'+listBus[i].tt_nama+'</strong></div><div class="card-body" style="background-color:#ffffff">'+bodyString+'</div></div></label>');
                    radioBtn.appendTo('#radioTp');
                }
            }
        })
    }
</script>
<style>
    label {
    width: 100%;
}

.card-input-element {
    display: none;
}

.card-input {
    margin: 10px;
    padding: 0px;
}

.card-input:hover {
    cursor: pointer;
}

.card-input-element:checked + .card-input {
     box-shadow: 0 0 1px 1px #2ecc71;
}
</style>
