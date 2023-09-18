@extends('layout/form')
@section('container')
    {{-- <body style="background-color: #F0f0f0;"> --}}
    <div class="card mx-auto mt-5" style="width: 40rem;">
        <div class="card-body">
            <form action="/admin/objek/create" method="post">
                @csrf
                <div class="form-floating my-3">
                    <input type="text" name="tot_kode" class="form-control" readonly value="AUTO" id="floatingtot_kode">
                    <label for="floatingtot_kode">
                        <h6>Kode Objek</h6>
                    </label>
                </div>
                <div class="form-floating">
                    <select class="form-control" id="floatingtot_tjo_kode" name="tot_tjo_kode">
                        <option value=null>--Jenis Objek--</option>
                    </select>
                    <label for="floatingtot_tjo_kode">
                        <h6>Jenis Objek</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <input type="text" name="tot_nama" class="form-control" id="floatingtot_nama"
                        value="{{ old('tot_nama') }}">
                    <label for="floatingtot_nama">
                        <h6>Nama Objek</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <input type="text" name="tot_telp" class="form-control" id="floatingtot_telp"
                        value="{{ old('tot_telp') }}">
                    <label for="floatingtot_telp">
                        <h6>Telepon</h6>
                    </label>
                </div>
                <div class="form-floating my-3">
                    <textarea type="text" name="tot_alamat" class="form-control" id="floatingtot_alamat" value="{{ old('tot_alamat') }}"
                        style="height: 7rem;"></textarea>
                    <label for="floatingtot_alamat">
                        <h6>Alamat</h6>
                    </label>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-control" id="floatingtot_provinsi" name="tot_provinsi">
                                <option value={{ old('tot_provinsi') }}>--Provinsi--</option>
                            </select>
                            <label for="floatingtot_provinsi">
                                <h6>Provinsi</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select name="tot_kota" class="form-control" id="floatingtot_kota">
                                <option value="{{ old('tot_kota') }}">--Kota--</option>
                            </select>
                            <label for="floatingtot_kota">
                                <h6>Kota</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="height:3.6em" id="basic-addon3">Rp </span>
                    </div>
                    <div class="form-floating">
                        <input type="number" name="tot_harga" class="form-control" id="floatingtot_harga" step="1000"
                            value="{{ old('tot_harga') }}">
                        <label for="floatingtot_harga">
                            <h6>Harga</h6>
                        </label>
                    </div>
                </div>

                <button class="btn btn-primary mt-3 float-end" type="submit">Insert Data</button>
            </form>
        </div>
    </div>
    {{-- </body> --}}
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        fetch("https://dev.farizdotid.com/api/daerahindonesia/provinsi")
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                let listProvinsi = data.provinsi
                $('#floatingtot_provinsi').append(listProvinsi.map(function(provs) {
                        return $('<option>', {
                            text: provs.nama,
                            value: provs.nama
                        })
                    }))
                    .change(function() {
                        let chosenId = ""
                        for(let i = 0; i < listProvinsi.length; i++){
                            if(listProvinsi[i].nama == this.value){
                                chosenId = listProvinsi[i].id
                            }
                        }
                        fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' + chosenId, {
                                    method: "GET"
                                })
                            .then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                // console.log(data.kota_kabupaten)
                                let listKotaAsal = data.kota_kabupaten;
                                $('#floatingtot_kota').empty()
                                $('#floatingtot_kota').append(listKotaAsal.map(function(kota) {
                                        return $('<option>', {
                                            text: kota.nama,
                                            value: kota.nama
                                        })
                                    }))
                                    .change(function() {
                                        // console.log("kota asal", this.value)
                                    })
                            })
                    })
            });
        fetch('/api/objek/jenis')
            .then((response) => {
                return response.json()
            })
            .then((data) => {
                let listJenis = data
                $('#floatingtot_tjo_kode').append(listJenis.map(function(jenis) {
                    return $('<option>', {
                        text: jenis.tjo_desc,
                        value: jenis.tjo_kode
                    })
                }))
            })
    });
</script>
