@extends('layout/form')
@section('container')

    <body>
        {{-- <div class="card mx-auto mt-5"> --}}
        {{-- <div class="card-header float-end"> --}}
        <div class="row my-3">
            <div class="col-md-5">
                <div class="input-group">
                    <input class="form-control border rounded" type="search" id="searchBar" placeholder="Search...">
                    <div class="input-group-append">
                        <span class="input-group-text py-sm-3 rounded-right"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="col">
                <button class="btn btn-primary float-end" type="button" data-toggle="modal" data-target="#myModal"><i
                        class="bi bi-plus" style="font-size: 24pt"></i></button>
            </div>
        </div>
        {{-- </div> --}}
        {{-- <div class="card-body" style="background-color: #FFFFFF"> --}}
        <div class="table-responsive rounded-3" style="height: 40em; overflow: auto;" class="mt-4">
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
                            <td>{{ $responseDet->tot_alamat }}, {{ $responseDet->tk_nama }},
                                {{ $responseDet->tp_nama }}</td>
                            <td><select class="form-control" id="{{ 'floatingtrd_hari' . $responseDet->trd_kode }}"
                                    name="tpd_hari">
                                    <option value="{{ $responseDet->trd_hari }}">
                                        {{ $responseDet->trd_hari }}</option>
                                    @for ($i = 1; $i <= $response[0]->trh_durasi; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}</option>
                                    @endfor
                                </select></td>
                            <td style="witdh:10em"><input type="time" id="{{ 'trd_jam' . $responseDet->trd_kode }}"
                                    value="{{ $responseDet->trd_jam }}" pattern="[0-9]{2}:[0-9]{2}"></td>
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
        {{-- </div> --}}
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
                        <form action="/admin/reservasi/list" method="post">
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
                                    onclick="getObjek('{{$response[0]->trh_tp_kode_tujuan}}', '{{$response[0]->trh_tk_kode_tujuan}}')">
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
    </body>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#searchBar").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#indexTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<script>
    function getObjek(tot_provinsi, tot_kota) {
        let tot_tjo_kode = $("#floatingtrd_tot_tjo_kode").val()
        // console.log(tot_provinsi, tot_kota)
        fetch('/api/objek/findbyloc?tot_tp_kode=' + tot_provinsi + '&tot_tk_kode=' + tot_kota).then((response) => {
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

    function delDet(trd_kode) {
        let stringConfirm = "Data reservasi " + trd_kode + " akan dihapus"
        if (confirm(stringConfirm)) {
            fetch("/admin/reservasi/delDet?trd_kode=" + trd_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                    window.location.reload();
                })
        }
    }

    function updateDet(trd_kode) {

        var kode = trd_kode
        var hari = $("#floatingtrd_hari" + trd_kode).val()
        var jam = $("#trd_jam" + trd_kode).val()

        var stringURL = "/api/reservasi/det/update?trd_kode=" + trd_kode + "&trd_hari=" + hari + "&trd_jam=" + jam

        let stringConfirm = "Data Detail Paket " + trd_kode + " akan dirubah"
        if (confirm(stringConfirm)) {
            fetch(stringURL)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                    window.location.reload()
                })
        }
    }
</script>
