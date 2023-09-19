@extends('layout/menu')
@section('container')

    <body>
    @section('button')
        <a class="btn btn-lg px-lg-3 btn-success float-end" href="create"><i class="bi bi-database-add"></i> Create</a>
    @endsection
    <div class="table-responsive rounded-3" style="height: 40em; overflow: auto;" class="mt-4">
        <table class="table table-striped table-bordered">
            <thead class="position-sticky">
                <tr style="position: sticky; top: 0; z-index: 1; box-shadow: inset .1px .1px #000, 0 1px #000"
                    class="bg-green text-light">
                    <th scope="col">Kode Transportasi</th>
                    <th scope="col">Nama Transportasi</th>
                    <th scope="col">Kota Asal</th>
                    <th scope="col">Kota Tujuan</th>
                    <th scope="col">Pax</th>
                    <th scope="col">Harga</th>
                    <th scope="col" class="text-center">Option</th>
                </tr>
            </thead>
            <tbody id="indexTable">
                @foreach ($response as $key => $response)
                    <tr class="align-middle">
                        <td>{{ $response->tt_kode }}</td>
                        <td><a href="{{ '/admin/transportasi/detail?tt_kode=' . $response->tt_kode }}">{{ $response->tt_nama }}</a></td>
                        <td>{{ $response->tt_kota_asal}}</td>
                        <td>{{ $response->tt_kota_tujuan }}</td>
                        <td>{{ $response->tt_pax }}</td>
                        <td>Rp {{ $response->tt_harga }}</td>
                        <td class="text-center"><a class="btn btn-lg-2 px-sm-3 btn-danger align-center" id="delBtn"
                                onclick="delBus('{{ $response->tt_kode }}', '{{ $response->tt_nama }}')"><i class="bi bi-trash-fill"></i></a></td>
                    </tr>
                @endforeach
            </ttody>
        </table>
    </div>
</body>
@endsection

<script>
    function delBus(tt_kode, tt_nama) {
        let stringConfirm = "Data Transportasi \"" + tt_nama + "\" akan dihapus"
        if (confirm(stringConfirm)) {
            fetch("/admin/transportasi/delete?tt_kode=" + tt_kode)
                .then(() => {
                    window.location.reload();
                }).catch((err) => function() {
                    console.log(err)
                })
        }
    }
</script>
