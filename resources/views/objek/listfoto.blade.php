@extends('layout/menu')
@section('container')
<body>
    @section('button')
        <a class="btn btn-lg px-lg-3 btn-success float-end" href={{"/admin/objek/foto?tot_kode=".$response[0]->tfo_tot_kode}}><i class="bi bi-database-add"></i> Add</a>
    @endsection
    <div class="table-responsive rounded-3" style="height: 40em; overflow: auto; max-height: 55em;" class="mt-4">
        <table class="table table-striped table-bordered">
            <thead class="position-sticky">
                <tr style="position: sticky; top: 0; z-index: 1; box-shadow: inset .1px .1px #000, 0 1px #000"
                    class="text-light bg-green">
                    <th scope="col">Kode Foto</th>
                    <th scope="col">Kode Objek</th>
                    <th scope="col">Foto Objek</th>
                    <th scope="col">Path</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody id="indexTable">
                @foreach ($response as $key => $response)
                    <tr class="align-middle">
                        <td>{{ $response->tfo_kode }}</td>
                        <td>{{ $response->tfo_tot_kode }}</td>
                        <td><img src="{{ '/'.$response->tfo_path }}" alt="..." width="160" height="90"></td>
                        <td>{{ $response->tfo_path }}</td>
                        <td class="text-center"><button class="btn btn-lg-2 px-sm-3 btn-danger align-center"
                                id="delBtn" onclick="delRec('{{ $response->tfo_kode }}')"><i
                                    class="bi bi-trash-fill"></i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection

<script>
    function delRec(tfo_kode) {
        console.log(tfo_kode)
        let stringConfirm = "Foto Objek " + tfo_kode + " akan dihapus"
        if (confirm(stringConfirm)) {
            fetch("/admin/objek/delfoto?tfo_kode=" + tfo_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                })
        }
    }
</script>