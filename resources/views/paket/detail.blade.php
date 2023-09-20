@extends('layout/form')
@section('container')
    <div class="row">
        {{-- <div class="col align-self-center">
            <a href="#carouselExampleControls" data-slide="prev" class="btn btn-lg"><i class="bi bi-chevron-left text-success"
                    style="font-size: 2.5rem"></i></a>
        </div> --}}
        <div class="col-10" style="height: 40rem">
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
                                            <option value="{{ $response[0]->tph_tjt_kode }}">{{$response[0]->tjt_desc}}</option>
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
                                                <select class="form-control" id="floatingtph_tp_kode_asal"
                                                    name="tph_tp_kode_asal">
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
                                                <select name="tph_tk_kode_asal" class="form-control"
                                                    id="floatingtph_tk_kode_asal">
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
                                            <input type="number" name="tph_harga" class="form-control"
                                                id="floatingtph_harga" readonly value="{{ $response[0]->tph_harga }}">
                                            <label for="floatingtph_harga">
                                                <h6>Harga</h6>
                                            </label>
                                        </div>
                                    </div>
                                    <a class="btn mt-3 btn-outline-success float-start" href="/admin/paket/list?tph_kode={{$response[0]->tph_kode}}"><i class="bi bi-chevron-right"></i>
                                        List Tujuan</a>
                                    <button class="btn btn-primary mt-3 float-end" type="submit">Update Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="carousel-item">
                        <div class="card mx-auto mt-5">
                            <div class="card-header float-end">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3"><Strong>List Objek Paket Wisata</Strong></h5>
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
                                            @foreach ($responseDet->sortBy('tpd_jam')->sortBy('tpd_hari') as $key => $responseDet)
                                                <tr class="align-middle">
                                                    <td hidden><input type="text" name="tpd_kode"
                                                            value="{{ $responseDet->tpd_kode }}" hidden></td>
                                                    <td>{{ $responseDet->tot_kode }}</td>
                                                    <td>{{ $responseDet->tjo_desc }}</td>
                                                    <td>{{ $responseDet->tot_nama }}</td>
                                                    <td>{{ $responseDet->tot_alamat }}, {{ $responseDet->tk_nama }},
                                                        {{ $responseDet->tp_nama }}</td>
                                                    <td><select class="form-control"
                                                            id="{{ 'floatingtpd_hari' . $responseDet->tpd_kode }}"
                                                            name="tpd_hari">
                                                            <option value="{{ $responseDet->tpd_hari }}">
                                                                {{ $responseDet->tpd_hari }}</option>
                                                            @for ($i = 1; $i <= $response[0]->tph_durasi; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select></td>
                                                    <td style="witdh:10em"><input type="time"
                                                            id="{{ 'tpd_jam' . $responseDet->tpd_kode }}"
                                                            value="{{ $responseDet->tpd_jam }}"
                                                            pattern="[0-9]{2}:[0-9]{2}"></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-lg-2 px-sm-3 btn-primary align-center"
                                                            onclick="updateDet('{{ $responseDet->tpd_kode }}')"><i
                                                                class="bi bi-upload"></i></button>
                                                        <button class="btn btn-lg-2 px-sm-3 btn-danger align-center"
                                                            onclick="delDet('{{ $responseDet->tpd_kode }}')"><i
                                                                class="bi bi-trash-fill"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        {{-- <div class="col align-self-center">
            <a href="/admin/paket/list?tph_kode={{$response[0]->tph_kode}}" class="btn btn-lg"><i
                    class="bi bi-chevron-right text-success" style="font-size: 2.5rem"></i></a>
        </div> --}}
    </div>
    <!-- Modal -->
    {{-- <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Objek Tujuan</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/paketAddDet" method="post">
                        @csrf
                        <div class="form-floating my-3">
                            <input type="text" name="tpd_tph_kode" class="form-control" readonly
                                value="{{ $response[0]->tph_kode }}" id="floatingtph_kode">
                            <label for="floatingtph_kode">
                                <h6>Kode Paket</h6>
                            </label>
                        </div>

                        <div class="form-floating my-3">
                            <select class="form-control" id="floatingtrd_tot_tjo_kode" required>
                                <option value="">--Jenis Objek--</option>
                                <option value="1">Hotel</option>
                                <option value="2">Wisata</option>
                                <option value="3">Belanja</option>
                                <option value="4">Restoran</option>
                            </select>
                            <label for="floatingtrd_tot_kode">
                                <h6>Jenis Objek</h6>
                            </label>
                        </div> --}}

                        {{-- <div class="form-floating my-3">
                            <select class="form-control" id="floatingtpd_tot_kode" name="tpd_tot_kode" required
                                onclick="getObjek('{{ $response[0]->tph_provinsi_tujuan }}', '{{ $response[0]->tph_kota_tujuan }}' )">
                                <option value="">--Objek Wisata--
                                </option>
                            </select>
                            <label for="floatingtpd_tot_kode">
                                <h6>Objek Wisata</h6>
                            </label>
                        </div> --}}

                        {{-- <div class="form-floating my-3">
                            <select class="form-control" id="floatingtpd_hari" name="tpd_hari" required>
                                <option value="">--Hari--</option>
                                @for ($i = 1; $i <= $response[0]->tph_durasi; $i++)
                                    <option value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            <label for="floatingtpd_hari">
                                <h6>Hari</h6>
                            </label>
                        </div>

                        <div class="form-floating my-3">
                            <input type="time" name="tpd_jam" class="form-control" id="floatingtpd_jam" required>
                            <label for="floatingtpd_jam">
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
    </div> --}}
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
