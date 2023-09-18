@extends('layout/menu')
@section('container')

<body>
    <div class="table-responsive rounded-3" style="height: 55em; overflow: auto;" class="mt-4">
        <table class="table table-striped table-bordered">
            <thead class="position-sticky">
                <tr style="position: sticky; top: 0; z-index: 1; box-shadow: inset .1px .1px #000, 0 1px #000" class="bg-green text-light">
                    <th scope="col">ID</th>
                    <th scope="col">Nama User</th>
                    <th scope="col">Email User</th>
                    <th scope="col">No. Whatsapp</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                </tr>
            </thead>
            <tbody id="indexTable">
                @foreach ($response as $key => $response)
                <tr class="align-middle">
                    <td>{{ $response->id }}</td>
                    <td>{{ $response->name }}</td>
                    <td>{{ $response->email }}</td>
                    <td>{{ $response->whatsapp }}</td>
                    <td>{{ $response->created_at }}</td>
                    <td>{{ $response->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection