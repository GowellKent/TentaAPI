@extends('layout/menu')
@section('container')

    <body>
    @section('button')
        <a class="btn px-lg-3 my-3 mx-2 btn-success float-end" href="/admin/reservasi/create"><i class="bi bi-database-add"></i> Create</a>
        <a class="btn px-lg-3 my-3 btn-outline-success float-end" href="/resCustom"><i class="bi bi-database-gear"></i>
            Custom</a>
    @endsection
    <div class="table-responsive rounded-3" style="height: 55em; overflow: auto;" class="mt-4">
        <table class="table table-striped table-bordered" id="example">
            <thead class="position-sticky">
                <tr style="position: sticky; top: 0; z-index: 1; box-shadow: inset .1px .1px #000, 0 1px #000"
                    class="bg-green text-light">
                    <th scope="col" onclick="sortTable(0)">Kode</th>
                    <th scope="col" onclick="sortTable(1)">Nama Paket</th>
                    <th scope="col" onclick="sortTable(2)">Nama Client</th>
                    <th scope="col" onclick="sortTable(3)">Tanggal Reservasi</th>
                    <th scope="col" onclick="sortTable(4)">Tanggal Perjalanan</th>
                    <th scope="col" onclick="sortTable(5)">Pax</th>
                    <th scope="col" onclick="sortTable(6)">Status</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody id="indexTable">
                @foreach ($response as $key => $response)
                    <tr class="align-middle">
                        <td><a href="{{ '/resDetail?trh_kode=' . $response->trh_kode }}">{{ $response->trh_kode }}</td>
                        <td>{{ $response->tph_nama }}</td>
                        <td>{{ $response->name }}</td>
                        <td>{{ $response->trh_tgl_reservasi }}</td>
                        <td>{{ $response->trh_tgl_jalan }}</td>
                        <td>{{ $response->trh_pax }}</td>
                        <td>{{ $response->tsr_desc }}</td>
                        <td class="text-center">
                            <a class="btn btn-lg-2 px-sm-3 btn-primary align-center"
                                href="{{ '/resCetak?trh_kode=' . $response->trh_kode }}"><i
                                    class="bi bi-printer"></i></a>
                            <button class="btn btn-lg-2 px-sm-3 btn-danger align-center"
                                onclick="resDelete({{ $response->trh_kode }})"><i class="bi bi-trash-fill"></i></button>
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
    function resDelete(trh_kode) {
        // console.log(tph_kode)
        let stringConfirm = "Data reservasi " + trh_kode + " akan dihapus"
        if (confirm(stringConfirm)) {
            fetch("/resDelete?trh_kode=" + trh_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                    window.location.reload();
                })
        }
    };
</script>
