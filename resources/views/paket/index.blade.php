@extends('layout/menu')
@section('container')

    <body>
    @section('button')
        <a class="btn btn-lg px-lg-3 btn-success float-end" href="/admin/paket/create"><i class="bi bi-database-add"></i> Create</a>
    @endsection
    <div class="table-responsive rounded-3" style="height: 55em; overflow: auto;" class="mt-4">
        <table class="table table-striped table-bordered">
            <thead class="position-sticky">
                <tr style="position: sticky; top: 0; z-index: 1; box-shadow: inset .1px .1px #000, 0 1px #000"
                    class="bg-green text-light">
                    <th scope="col">Kode</th>
                    <th scope="col">Jenis Paket</th>
                    <th scope="col">Nama Paket</th>
                    <th scope="col">Durasi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Asal</th>
                    <th scope="col">Tujuan</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody id="indexTable">
                @foreach ($response as $key => $response)
                    <tr class="align-middle">
                        <td>{{ $response->tph_kode }}</td>
                        <td>{{ $response->tjt_desc }}</td>
                        <td><a href="{{ '/admin/paket/detail?tph_kode=' . $response->tph_kode }}">{{ $response->tph_nama }}</a></td>
                        <td>{{ $response->tph_durasi }} Hari</td>
                        <td class="text-nowrap">Rp {{ $response->tph_harga }}</td>
                        <td>{{ $response->prov_asal }}, {{ $response->kota_asal }}</td>
                        <td>{{ $response->prov_tujuan }}, {{ $response->kota_tujuan }}</td>
                        <td class="text-center"><button class="btn btn-lg-2 px-sm-3 btn-danger align-center"
                                onclick="delBus('{{ $response->tph_kode }}')" id="btnDel"><i
                                    class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    function delBus(tph_kode) {
        let stringConfirm = "Data Paket " + tph_kode + " akan dihapus"
        if (confirm(stringConfirm)) {        // console.log(tph_kode)
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
