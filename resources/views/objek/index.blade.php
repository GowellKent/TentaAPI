@extends('layout/menu')
@section('container')

    <body>
    @section('button')
        <a class="btn btn-lg px-lg-3 btn-success float-end" href="/admin/objek/create"><i class="bi bi-database-add"></i> Create</a>
    @endsection
    <div class="table-responsive rounded-3" style="height: 40em; overflow: auto; max-height: 55em;" class="mt-4">
        <table class="table table-striped table-bordered">
            <thead class="position-sticky">
                <tr style="position: sticky; top: 0; z-index: 1; box-shadow: inset .1px .1px #000, 0 1px #000"
                    class="text-light bg-green">
                    <th scope="col">Kode</th>
                    <th scope="col">Jenis Objek</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Telepon</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Provinsi</th>
                    <th scope="col">Kota</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody id="indexTable">
                @foreach ($response as $key => $response)
                    <tr class="align-middle">
                        <td>{{ $response->tot_kode }}</td>
                        <td>{{ $response->tjo_desc }}</td>
                        <td><a href="{{ '/admin/objek/detail?tot_kode=' . $response->tot_kode }}">{{ $response->tot_nama }}</a></td>
                        <td>{{ $response->tot_telp }}</td>
                        <td>{{ $response->tot_alamat }}</td>
                        <td>{{ $response->tp_nama }}</td>
                        <td>{{ $response->tk_nama }}</td>
                        <td>{{ $response->tot_harga }}</td>
                        <td class="text-center"><button class="btn btn-lg-2 px-sm-3 btn-danger align-center"
                                id="delBtn" onclick="delRec('{{ $response->tot_kode }}')"><i
                                    class="bi bi-trash-fill"></i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection

<script>
    function delRec(tot_kode) {
        let stringConfirm = "Data Objek " + tot_kode + " akan dihapus"
        if (confirm(stringConfirm)) {
            console.log(tot_kode)
            fetch("/admin/objek/delete?tot_kode=" + tot_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                })
        }
    }
</script>
