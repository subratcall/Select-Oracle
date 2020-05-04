@extends('SelectOracleNavbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Password Generator</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="cabang" class="col-sm-2 col-form-label">Cabang</label>
                                    <div class="col-sm-3">
                                        <select type="text" class="form-control" id="cabang">
                                            <option value="" selected disabled>- Pilih Cabang -</option>
                                            <option value="22">22 - SEMARANG</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="tanggal" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="jam" class="col-sm-2 col-form-label">Jam</label>
                                    <div class="col-sm-3">
                                        <select type="text" class="form-control" id="jam">
                                            <option value="" selected disabled>- Pilih Jam -</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <div class="form-group row">
                    <div class="col-sm-10"></div>
                    <div class="col-sm-2">
                        <button class="col-sm btn btn-secondary btn-danger" id="btn-generate">GENERATE</button>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>




    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        input{
            text-transform: uppercase;
        }

        .row_divisi:hover{
            cursor: pointer;
            background-color: grey;
        }

        textarea{
            height: 300px !important;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 564px;
            overflow-x: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }


    </style>
    <script>
        $('#tanggal').datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        $("#tanggal").datepicker().datepicker("setDate", new Date());

        $('#btn-generate').on('click',function(){
            date = $('#tanggal').val().split('/');

            tanggal = date[0];
            bulan = date[1];
            tahun = date[2];

            $.ajax({
                url: '{{ url('select-oracle/generate') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    cabang : $('#cabang').val(),
                    jam : $('#jam').val(),
                    tanggal : tanggal,
                    bulan : bulan,
                    tahun : tahun
                },
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    swal({
                        title: 'Password : ' + response
                    }).then(function(){
                        if($('#modal-loader').is(':visible'))
                            $('#modal-loader').modal('toggle');
                    });
                }
            });
        });
    </script>

@endsection
