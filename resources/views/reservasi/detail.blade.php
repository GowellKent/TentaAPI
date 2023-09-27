@extends('layout/form')
@section('container')
    <div class="card mx-auto my-5" style="width: 40rem;">
        <div class="card-body">
            <form action="/admin/reservasi/update" method="post">
                @csrf
                <div class="form-floating my-3">
                    <input type="text" name="trh_kode" class="form-control" readonly value="{{ $response[0]->trh_kode }}"
                        id="floatingtrh_kode">
                    <label for="floatingtrh_kode">
                        <h6>Kode Reservasi</h6>
                    </label>
                </div>
                <div class="form-floating">
                    <select class="form-control" id="floatingtrh_tph_kode" disabled>
                        <option value="{{ $response[0]->trh_tph_kode }}">{{ $response[0]->tph_nama }}
                        </option>
                    </select>
                    <label for="floatingtrh_tph_kode">
                        <h6>Paket Wisata</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <input type="text" class="form-control" readonly value="{{ $response[0]->trh_tu_kode }}"
                        id="floatingtrh_tu_kode">
                    <label for="floatingtrh_tu_kode">
                        <h6>Kode Client</h6>
                    </label>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" id="floatingtrh_provinsi_asal" disabled>
                                <option value="{{ $response[0]->trh_tp_kode_asal }}">
                                    {{ $response[0]->trh_tp_nama_asal }}</option>
                            </select>
                            <label for="floatingtrh_provinsi_asal">
                                <h6>Provinsi Asal</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" disabled id="floatingtrh_kota_asal">
                                <option value="{{ $response[0]->trh_tk_kode_asal }}">
                                    {{ $response[0]->trh_tk_nama_asal }}</option>
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
                            <select class="form-control" id="floatingtrh_provinsi_tujuan" disabled>
                                <option value="{{ $response[0]->trh_tp_kode_tujuan }}">
                                    {{ $response[0]->trh_tp_nama_tujuan }}</option>
                            </select>
                            <label for="floatingtrh_provinsi_tujuan">
                                <h6>Provinsi Tujuan</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" disabled id="floatingtrh_kota_tujuan">
                                <option value="{{ $response[0]->trh_tk_kode_tujuan }}">
                                    {{ $response[0]->trh_tk_nama_tujuan }}</option>
                            </select>
                            <label for="floatingtrh_kota_tujuan">
                                <h6>Kota Tujuan</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col">
                        <div class="form-floating">
                            <input type="date" disabled class="form-control" id="floatingtrh_tgl_reservasi"
                                value="{{ $response[0]->trh_tgl_reservasi }}">
                            <label for="floatingtrh_tgl_reservasi">
                                <h6>Tanggal Reservasi</h6>
                            </label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating">
                            <input type="date" name="trh_tgl_jalan" class="form-control" id="floatingtrh_tgl_jalan"
                                value="{{ $response[0]->trh_tgl_jalan }}">
                            <label for="floatingtrh_tgl_jalan">
                                <h6>Tanggal Perjalanan</h6>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-floating my-3">
                            <input type="number" name="trh_pax" class="form-control" id="floatingtrh_pax"
                                value="{{ $response[0]->trh_pax }}">
                            <label for="floatingtrh_pax">
                                <h6>Pax</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating my-3">
                            <select class="form-control" id="floatingtrh_tsr_kode" name="trh_tsr_kode">
                                <option value="{{ $response[0]->trh_tsr_kode }}">
                                    {{ $response[0]->tsr_desc }}
                                </option>
                            </select>
                            <label for="floatingtrh_tsr_kode">
                                <h6>Status Reservasi</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="form-floating me-3">
                        <input class="form-control" id="floatingtrh_tb_kode_brk" name="trh_tt_kode" readonly
                            value="{{ $response[0]->tt_nama }}" style="border-radius: 5px">
                        <label for="floatingtrh_tb_kode">
                            <h6>Transportasi Keberangkatan</h6>
                        </label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-lg btn-outline-success" type="button"
                            style="max-width: fit-content; height: 2.9em" onclick="searchBus()" data-toggle="modal"
                            data-target="#myModal"><i class="bi bi-pencil-square"></i></button>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp
                        </span>
                    </div>
                    <div class="form-floating">
                        <input type="number" class="form-control" id="floatingtrh_harga" readonly
                            value="{{ $response[0]->trh_harga }}">
                        <label for="floatingtrh_harga">
                            <h6>Harga</h6>
                        </label>
                    </div>
                </div>
                <div class="form-floating">
                    <input type="number" class="form-control my-3" id="floatingtrh_durasi"
                        value="{{ $response[0]->trh_durasi }}">
                    <label for="floatingtrh_durasi">
                        <h6>Durasi</h6>
                    </label>
                </div>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pilih Transportasi</h5>
                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="form-floating my-3">
                                    <div id="radioTp"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                    {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                                </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col float-end">
                        <button class="btn btn-primary mt-3 float-end" type="submit"
                            style="max-width: fit-content">Update
                            Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- </div> --}}
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
                        fetch('/api/daerah/kota?id_provinsi=' + this
                                .value, {
                                    method: "GET"
                                })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                $('#floatingtrh_kota_asal').empty();
                                $('#floatingtrh_kota_asal').append(data.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.tk_nama,
                                            value: kota.tk_kode
                                        })
                                    }))
                                    .change(function() {})
                            })
                    })
                $('#floatingtrh_provinsi_tujuan').append(data.map(function(provs) {
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
                                $('#floatingtrh_kota_tujuan').empty();
                                $('#floatingtrh_kota_tujuan').append(data.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.tk_nama,
                                            value: kota.tk_kode
                                        })
                                    }))
                                    .change(function() {})
                            })
                    })
            });

        fetch('/api/reservasi/head/status')
            .then((response) => {
                return response.json()
            })
            .then((data) => {
                let listJenis = data
                $('#floatingtrh_tsr_kode').append(listJenis.map(function(jenis) {
                    return $('<option>', {
                        text: jenis.tsr_desc,
                        value: jenis.tsr_kode
                    })
                }))
            })
    });
</script>
<script>
    function getObjek() {

        let tot_kota = $("#floatingtrh_kota_tujuan").val()
        let tot_provinsi = $("#floatingtrh_provinsi_tujuan").val()
        let tot_tjo_kode = $("#floatingtrd_tot_tjo_kode").val()
        fetch('/api/objek/search?tot_provinsi=' + tot_provinsi + '&tot_kota=' + tot_kota).then((response) => {
            return response.json();
        }).then((data) => {
            let listObjek = data
            $('#floatingtrd_tot_kode').empty()
            $('#floatingtrd_tot_kode').append(listObjek.map(function(objek) {
                if (objek.tot_tjo_kode == tot_tjo_kode) {
                    return $('<option>', {
                        text: objek.tot_nama,
                        value: objek.tot_kode
                    })
                }
            }))
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
                for (i = 0; i < listBus.length; i++) {
                    var bodyString = 'Max' + listBus[i].tt_pax + ' pax, Rp ' + listBus[i].tt_harga + ' /Pax'
                    var radioBtn = $(
                        ' <label><input id="listBus" type="radio" style="border-radius: 5px" name="trh_tt_kode" value=' +
                        listBus[i].tt_kode +
                        ' class="card-input-element" /><div class="card card-default card-input"><div class="card-header text-light" style="background-color:#00BFA6"><strong>' +
                        listBus[i].tt_nama +
                        '</strong></div><div class="card-body" style="background-color:#ffffff">' +
                        bodyString + '</div></div></label>');
                    radioBtn.appendTo('#radioTp');
                }
            }
            $(':radio[name="trh_tt_kode"]').change(function() {
                var value = $(this).filter(':checked').val()

                for (i = 0; i < listBus.length; i++) {
                    if (value == listBus[i].tt_kode) {
                        $("#floatingtrh_tb_kode_brk").val(listBus[i].tt_nama)
                    }
                }

            })
        })

    }


    function delDet(trd_kode) {
        let stringConfirm = "Data Detail reservasi " + trd_kode + " akan dihapus"
        if (confirm(stringConfirm)) {
            fetch("/resDeleteDet?trd_kode=" + trd_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                    window.location.reload();
                })
        }
    }

    function updateDet(trd_kode) {
        let stringConfirm = "Data Detail reservasi " + trh_kode + " akan dirubah"
        if (confirm(stringConfirm)) {
            fetch("/resUpdateDet?" + new URLSearchParams({
                    "trd_kode": trd_kode,
                    "trd_hari": $("#floatingtrd_hari" + trd_kode).val(),
                    "trd_jam": $("#trd_jam" + trd_kode).val()
                }))
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)

                })
        }
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

    .card-input-element:checked+.card-input {
        box-shadow: 0 0 1px 1px #2ecc71;
    }
</style>
