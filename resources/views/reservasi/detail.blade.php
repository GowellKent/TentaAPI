@extends('layout/form')
@section('container')
    <div class="row">
        <div class="col align-self-center">
            <a href="#carouselExampleControls" data-slide="prev" class="btn btn-lg"><i class="bi bi-chevron-left text-success"
                    style="font-size: 2.5rem"></i></a>
        </div>
        <div class="col-10" style="height: 40rem">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card mx-auto my-5" style="width: 40rem;">
                            <div class="card-body">
                                <form action="/resUpdate" method="post">
                                    @csrf
                                    <div class="form-floating my-3">
                                        <input type="text" name="trh_kode" class="form-control" readonly
                                            value="{{ $response[0]->trh_kode }}" id="floatingtrh_kode">
                                        <label for="floatingtrh_kode">
                                            <h6>Kode Reservasi</h6>
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
                                                <input type="date" disabled class="form-control"
                                                    id="floatingtrh_tgl_reservasi"
                                                    value="{{ $response[0]->trh_tgl_reservasi }}">
                                                <label for="floatingtrh_tgl_reservasi">
                                                    <h6>Tanggal Reservasi</h6>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="date" name="trh_tgl_jalan" class="form-control"
                                                    id="floatingtrh_tgl_jalan" value="{{ $response[0]->trh_tgl_jalan }}">
                                                <label for="floatingtrh_tgl_jalan">
                                                    <h6>Tanggal Perjalanan</h6>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating my-3">
                                                <input type="number" name="trh_pax" class="form-control"
                                                    id="floatingtrh_pax" value="{{ $response[0]->trh_pax }}">
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
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp </span>
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
                                    <div class="row">
                                        <div class="col float-end" style="max-width: fit-content">
                                            <button class="btn btn-success float-end" type="button"
                                                style="max-width: fit-content" onclick="searchBus()">Cari Transportasi</button>
                                        </div>
                                    </div>
                                    <hr>
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
                                        <select class="form-control" id="floatingtrh_tb_kode_brk" name="trh_tb_kode_brk">
                                            <option value="{{ $response[0]->trh_tt_kode }}">{{ $response[0]->tt_nama }}
                                            </option>
                                        </select>
                                        <label for="floatingtrh_tb_kode">
                                            <h6>Pilih Transportasi Keberangkatan</h6>
                                        </label>
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
                    </div>
                    <div class="carousel-item">
                        <div class="card mx-auto mt-5">
                            <div class="card-header float-end">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3"><Strong>List Objek Reservasi</Strong></h5>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary float-end" type="button" data-toggle="modal"
                                            data-target="#myModal"><i class="bi bi-plus"
                                                style="font-size: 24pt"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #FFFFFF">
                                <div class="table-responsive rounded-3" style="height: 40em; overflow: auto;"
                                    class="mt-4">
                                    <table class="table table-striped table-bordered">
                                        <thead class="position-sticky">
                                            <tr style="position: sticky; top: 0; z-index: 1; box-shadow: inset .1px .1px #000, 0 1px #000"
                                                class="bg-green text-light">
                                                <th scope="col">Kode</th>
                                                <th scope="col">Jenis Objek</th>
                                                <th scope="col">Nama Objek</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col" style="width: 10%">Hari</th>
                                                <th scope="col">Jam</th>
                                                <th scope="col" style="width: 15%">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody id="indexTable">
                                            @foreach ($responseDet->sortBy('trd_jam')->sortBy('trd_hari') as $key => $responseDet)
                                                <tr class="align-middle">
                                                    <td>{{ $responseDet->tot_kode }}</td>
                                                    <td>{{ $responseDet->tjo_desc }}</td>
                                                    <td>{{ $responseDet->tot_nama }}</td>
                                                    <td>{{ $responseDet->tot_alamat }}, {{ $responseDet->tot_kota }},
                                                        {{ $responseDet->tot_provinsi }}</td>
                                                    <td><select class="form-control"
                                                            id="{{ 'floatingtrd_hari' . $responseDet->trd_kode }}"
                                                            name="tpd_hari">
                                                            <option value="{{ $responseDet->trd_hari }}">
                                                                {{ $responseDet->trd_hari }}</option>
                                                            @for ($i = 1; $i <= $response[0]->trh_durasi; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select></td>
                                                    <td style="witdh:10em"><input type="time"
                                                            id="{{ 'trd_jam' . $responseDet->trd_kode }}"
                                                            value="{{ $responseDet->trd_jam }}"
                                                            pattern="[0-9]{2}:[0-9]{2}"></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-lg-2 px-sm-3 btn-primary align-center"
                                                            onclick="updateDet('{{ $responseDet->trd_kode }}')"><i
                                                                class="bi bi-upload"></i></button>
                                                        <button class="btn btn-lg-2 px-sm-3 btn-danger align-center"
                                                            onclick="delDet('{{ $responseDet->trd_kode }}')"><i
                                                                class="bi bi-trash-fill"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col align-self-center">
            <a href="#carouselExampleControls" data-slide="next" class="btn btn-lg"><i
                    class="bi bi-chevron-right text-success" style="font-size: 2.5rem"></i></a>
        </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Objek Tujuan</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/resAddDet" method="post">
                        @csrf
                        <div class="form-floating my-3">
                            <input type="text" name="trd_trh_kode" class="form-control" readonly
                                value="{{ $response[0]->trh_kode }}" id="floatingtrh_kode">
                            <label for="floatingtrh_kode">
                                <h6>Kode Reservasi</h6>
                            </label>
                        </div>
                        <div class="form-floating my-3">
                            <select class="form-control" id="floatingtrd_tot_tjo_kode" required>
                                <option value="">--Jenis Objek--</option>
                                <option value="1">Hotel</option>
                                <option value="2">Wisata</option>
                                <option value="3">Belanja</option>
                                <option value="4">Restoran</option>
                                <option value="5">Singgah</option>
                            </select>
                            <label for="floatingtrd_tot_kode">
                                <h6>Objek Wisata</h6>
                            </label>
                        </div>
                        <div class="form-floating my-3">
                            <select class="form-control" id="floatingtrd_tot_kode" name="trd_tot_kode" required
                                onclick="getObjek()">
                                <option value="">--Objek Wisata--
                                </option>
                            </select>
                            <label for="floatingtrd_tot_kode">
                                <h6>Objek Wisata</h6>
                            </label>
                        </div>
                        <div class="form-floating my-3">
                            <select class="form-control" id="floatingtrd_hari" name="trd_hari" required>
                                <option value="">
                                    Hari</option>
                                @for ($i = 1; $i <= $response[0]->trh_durasi; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            <label for="floatingtrd_hari">
                                <h6>Hari</h6>
                            </label>
                        </div>

                        <div class="form-floating my-3">
                            <input type="time" name="trd_jam" class="form-control" id="floatingtrd_jam" required>
                            <label for="floatingtrd_jam">
                                <h6>Jam</h6>
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
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
        fetch("https://dev.farizdotid.com/api/daerahindonesia/provinsi")
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                let listProvinsi = data.provinsi
                $('#floatingtph_provinsi_asal').append(listProvinsi.map(function(provs) {
                        return $('<option>', {
                            text: provs.nama,
                            value: provs.nama
                        })
                    }))
                    .change(function() {
                        let chosenId = ""
                        for (let i = 0; i < listProvinsi.length; i++) {
                            if (listProvinsi[i].nama == this.value) {
                                chosenId = listProvinsi[i].id
                            }
                        }
                        fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' +
                                chosenId, {
                                    method: "GET"
                                })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                let listKotaAsal = data.kota_kabupaten
                                $('#floatingtph_kota_asal').empty();
                                $('#floatingtph_kota_asal').append(listKotaAsal.map(
                                    function(kota) {
                                        return $('<option>', {
                                            text: kota.nama,
                                            value: kota.nama
                                        })
                                    }))
                            })
                    })
                $('#floatingtph_provinsi_tujuan').append(listProvinsi.map(function(provs) {
                        return $('<option>', {
                            text: provs.nama,
                            value: provs.nama
                        })
                    }))
                    .change(function() {
                        let chosenId = ""
                        for (let i = 0; i < listProvinsi.length; i++) {
                            if (listProvinsi[i].nama == this.value) {
                                chosenId = listProvinsi[i].id
                            }
                        }
                        fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' +
                                chosenId, {
                                    method: "GET"
                                })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                let listKotaTujuan = data.kota_kabupaten
                                $('#floatingtph_kota_tujuan').empty();
                                $('#floatingtph_kota_tujuan').append(listKotaTujuan.map(
                                    function(
                                        kota) {
                                        return $('<option>', {
                                            text: kota.nama,
                                            value: kota.nama
                                        })
                                    }))
                            })
                    })
            });
        fetch('/api/reservasi/status')
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
        // console.log(tot_provinsi, tot_kota)
        fetch('/api/objek/search?tot_provinsi=' + tot_provinsi + '&tot_kota=' + tot_kota).then((response) => {
            return response.json();
        }).then((data) => {
            let listObjek = data
            // console.log(listObjek)
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

        fetch("/api/bus/search?" + new URLSearchParams({
            "tb_kota_asal": kota_asal,
            "tb_kota_tujuan": kota_tujuan,
            "tb_pax": tb_pax
        })).then((response) => {
            return response.json();
        }).catch((err) => {
            console.log(err)
        }).then((data) => {
            let listBus = data
            if (listBus.length != undefined) {
                $('#floatingtrh_tb_kode_brk').append(listBus.map(function(Bus) {
                    textString = Bus.tb_nama + ", " + Bus.tb_pax + " Pax, Rp " + Bus.tb_harga
                    return $('<option>', {
                        text: textString,
                        value: Bus.tb_kode
                    })
                }))
                $('#floatingtrh_tb_kode_pul').append(listBus.map(function(Bus) {
                    textString = Bus.tb_nama + ", " + Bus.tb_pax + " Pax, Rp " + Bus.tb_harga
                    return $('<option>', {
                        text: textString,
                        value: Bus.tb_kode
                    })
                }))
            }
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
    }}

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
    }}
</script>
