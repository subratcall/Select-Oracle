@extends('SelectOracleNavbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Report Password Generator</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-8">
                                <div class="form-group row mb-0">
                                    <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="tanggal" readonly>
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
                        <button class="col-sm btn btn-secondary btn-danger" id="btn-export">EXPORT</button>
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

        textarea{
            height: 300px !important;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#tanggal').datepicker({
                dateFormat : "dd/mm/yy"
            });
            $("#tanggal").datepicker().datepicker("setDate", new Date());
        });

        $('#btn-export').on('click',function() {
            tanggal = $('#tanggal').val().replace(/\//g, '-');

            url = '{{ url('/password-generator/show-report?tanggal=') }}' + tanggal;

            window.open(url);
        });
    </script>

@endsection
