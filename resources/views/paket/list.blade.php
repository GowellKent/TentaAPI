@extends('layout/menu')
@section('container')

    <body>
    @section('button')
        <a class="btn btn-lg px-lg-3 btn-outline-success float-start" href="/admin/paket/detail?tph_kode={{$responseDet[0]->tpd_tph_kode}}"><i class="bi bi-chevron-left"></i>
            Back</a>
        <a class="btn btn-lg px-lg-3 btn-success float-end" ><i class="bi bi-database-add"></i>
            Add</a>
    @endsection
    {{-- <div class="row">
         <div class="col align-self-center col-1">
            <a href="/admin/paket/detail?tph_kode={{$responseDet[0]->tpd_tph_kode}}" data-slide="prev" class="btn btn-lg"><i class="bi bi-chevron-left text-success"
                    style="font-size: 2.5rem"></i></a>
        </div>
        <div class="col align-self-center"> --}}

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
                        @foreach ($responseDet->sortBy('tpd_jam')->sortBy('tpd_hari') as $key => $responseDet)
                            <tr class="align-middle">
                                <td hidden><input type="text" name="tpd_kode" value="{{ $responseDet->tpd_kode }}" hidden>
                                </td>
                                <td>{{ $responseDet->tot_kode }}</td>
                                <td>{{ $responseDet->tjo_desc }}</td>
                                <td>{{ $responseDet->tot_nama }}</td>
                                <td>{{ $responseDet->tot_alamat }}, {{ $responseDet->tk_nama }},
                                    {{ $responseDet->tp_nama }}</td>
                                <td><select class="form-control" id="{{ 'floatingtpd_hari' . $responseDet->tpd_kode }}"
                                        name="tpd_hari">
                                        <option value="{{ $responseDet->tpd_hari }}">
                                            {{ $responseDet->tpd_hari }}</option>
                                        {{-- @for ($i = 1; $i <= $response[0]->tph_durasi; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor --}}
                                    </select></td>
                                <td style="witdh:10em"><input type="time" id="{{ 'tpd_jam' . $responseDet->tpd_kode }}"
                                        value="{{ $responseDet->tpd_jam }}" pattern="[0-9]{2}:[0-9]{2}"></td>
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
            {{-- </div>
        </div> --}}
    </div>
</body>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    function delBus(tph_kode) {
        let stringConfirm = "Data Paket " + tph_kode + " akan dihapus"
        if (confirm(stringConfirm)) { // console.log(tph_kode)
            fetch("/admin/paket/delete?tph_kode=" + tph_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                    window.location.reload();
                })
        }
    };
</script>

<script>
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
</script>
