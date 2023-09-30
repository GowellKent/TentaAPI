<?php
use Carbon\Carbon;
?>
<!DOCTYPE html>
<html>

<Head>
    <title>
        {{ $title }}
    </title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
</Head>

<Body>
    <div class="container">
        <div class="row">
            <h1><strong>Tenta Tour</strong></h1>
        </div>
        <div class="row">
            <h6>Jl Krakatau B.97, Kota Salatiga, Jawa Tengah (Kode Pos : 50732)</h6>
        </div>
        <div class="row">
            <div class="col">
                <h6> Telepon : 085741844404 Email : travelagent@gmail.com </h6>
            </div>
            <div class="col" style="float:right;">
                <h6>Invoice Date :
                    {{ Carbon::parse($response['head'][0]->trh_tgl_reservasi)->isoFormat('dddd, D-MMMM-YYYY') }}</h6>
            </div>
        </div>
        <hr>
        <div class="row" style="margin-bottom: 5rem">
            <div class="col" style="float:right;">
                <table>
                    <tbody>
                        <tr>
                            <td colspan="3"><strong>Detail Reservasi</strong></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td> :</td>
                            <td>{{ $response['head'][0]->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> :</td>
                            <td>{{ $response['head'][0]->email }}</td>
                        </tr>
                        <tr>
                            <td>Whatsapp</td>
                            <td> :</td>
                            <td>{{ $response['head'][0]->whatsapp }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Berangkat &nbsp;</td>
                            <td> :</td>
                            <td>{{ Carbon::parse($response['head'][0]->trh_tgl_jalan)->isoFormat('dddd, D-MMMM-YYYY') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Paket</td>
                            <td> :</td>
                            <td>{{ $response['head'][0]->tph_nama }}</td>
                        </tr>
                        <tr>
                            <td>Durasi Wisata</td>
                            <td> :</td>
                            <td>{{ $response['head'][0]->trh_durasi }} hari</td>
                        </tr>
                        <tr>
                            <td>Pax</td>
                            <td> :</td>
                            <td>{{ $response['head'][0]->trh_pax }}</td>
                        </tr>
                        <tr>
                            <td>Harga</td>
                            <td> :</td>
                            <td>Rp {{ $response['head'][0]->trh_harga }}</td>
                        </tr>
                        <tr>
                            <td>Transportasi</td>
                            <td> :</td>
                            <td>{{ $response['head'][0]->tt_nama}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h3 style="margin-bottom: 2rem"><strong>Rundown</strong></h3>
            @for ($i = 0; $i < $response['head'][0]->trh_durasi; $i++)
                <h5><strong>Singgah</strong> -
                    {{ Carbon::parse($response['head'][0]->trh_tgl_jalan)->addDays($i)->isoFormat('dddd, D-MMMM-YYYY') }}
                </h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th scope="col">Jam</th>
                            <th scope="col">Objek Wisata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($response['det']->sortBy('trd_jam') as $key => $responseDet)
                            @if ($responseDet->trd_hari == $i + 1 && $responseDet->tot_tjo_kode == 5)
                                <tr class="align-middle">
                                    <td>{{ $responseDet->trd_jam }}</td>
                                    <td>{{ $responseDet->tot_nama }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <h5><strong>Kegiatan</strong> -
                    {{ Carbon::parse($response['head'][0]->trh_tgl_jalan)->addDays($i)->isoFormat('dddd, D-MMMM-YYYY') }}
                </h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="success">
                            <th scope="col">Jam</th>
                            <th scope="col">Objek Wisata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($response['det']->sortBy('trd_jam') as $key => $responseDet)
                            @if ($responseDet->trd_hari == $i + 1 && $responseDet->tot_tjo_kode != 5)
                                <tr class="align-middle">
                                    <td>{{ $responseDet->trd_jam }}</td>
                                    <td>{{ $responseDet->tot_nama }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <hr>
            @endfor
        </div>
    </div>

</Body>

</html>
