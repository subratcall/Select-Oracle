@extends('SelectOracleNavbar')
@section('content')


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <fieldset>
                    <div class="row">
                        <div class="col-sm-8">
                            <h4 class="text-left text-uppercase" id="header-koneksi">SERVER : {{ $connection }}</h4>
                        </div>
                        <div class="col-sm-4">
                            <h4 class="text-right" id="header-tanggal"></h4>
                        </div>
                    </div>
                </fieldset>
                <div class="row">

                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Select Oracle</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="tabel" class="col-sm-2 col-form-label">Tabel</label>
                                    <div class="col-sm-4">
                                        <select class="form-control selectized text-left" id="tabel">
                                            <option value="" selected disabled>- PILIH TABEL -</option>
                                            @foreach($tablelist as $t)
                                            <option value="{{ $t->table_name }}">{{ strtoupper($t->table_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="tipe" class="col-sm-2 col-form-label">Tipe</label>
                                    <div class="col-sm-4">
                                        <select type="text" class="form-control selectized text-left" id="tipe">
                                            <option value=""selected disabled>- PILIH TIPE QUERY -</option>
                                            <option value="select">SELECT</option>
                                            <option value="insert">INSERT</option>
                                            <option value="update">UPDATE</option>
                                            <option value="delete">DELETE</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="insert" style="display:none">

                                </div>
                                <div id="tab" style="display:none">
                                    <ul class="nav nav-tabs custom-color" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="btn-select-otomatis" data-toggle="tab" href="#otomatis">OTOMATIS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="btn-select-manual" data-toggle="tab" href="#manual">MANUAL</a>
                                        </li>
                                    </ul>
                                    <br>
                                    <div class="tab-content">
                                        <div id="manual" class="container tab-pane pl-0 pr-0 fix-height">
                                            <div class="card-body ">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="query-manual" class="col-sm-2 col-form-label">Query</label>
                                                            <div class="col-sm-8">
                                                                <textarea type="number" class="form-control diisi" id="query-manual"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="select" style="display:none">
                                    <div class="form-group row mb-0 select-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Select</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column select selectized text-left" onchange="column_onchange(event)">
                                                <option value="" selected disabled>- Pilih Tabel terlebih dahulu -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="col-sm-10 btn btn-info" onclick="tambah_select()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="update" style="display:none">
                                    <div class="form-group row mb-0 update-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Set</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column update selectized text-left" onchange="column_onchange(event)">
                                                <option value="" selected disabled>- Pilih Tabel terlebih dahulu -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input class="form form-control value" type="text" disabled>
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="col-sm-10 btn btn-info" onclick="tambah_update()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="where" style="display:none">
                                    <div class="form-group row mb-0 where-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Where</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column where selectized text-left" onchange="column_onchange(event)">
                                                <option value="" selected disabled>- Pilih Tabel terlebih dahulu -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form form-control operator" type="text" disabled>
                                                <option value="" selected disabled>- Operator -</option>
                                                <option value="=">=</option>
                                                <option value="<"><</option>
                                                <option value="<="><=</option>
                                                <option value=">=">>=</option>
                                                <option value=">">></option>
                                                <option value="<>"><></option>
                                                <option value="LIKE">LIKE</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input class="form form-control value" type="text" disabled>
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="col-sm-10 btn btn-info" onclick="tambah_where()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="group" style="display:none">
                                    <div class="form-group row mb-0 group-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Group By</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column group selectized text-left" onchange="column_onchange(event)">
                                                <option value="" selected disabled>- Pilih Tabel terlebih dahulu -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="col-sm-10 btn btn-info" onclick="tambah_group()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="order" style="display:none">
                                    <div class="form-group row mb-0 order-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Order By</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column order selectized text-left">
                                                <option value="" selected disabled>- Pilih Tabel terlebih dahulu -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select type="text" class="form-control direction">
                                                <option value="ASC" selected>ASC</option>
                                                <option value="DESC">DESC</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="col-sm-10 btn btn-info" onclick="tambah_order()">+</button>
                                        </div>
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
                        <button class="col-sm btn btn-secondary btn-danger" id="btn-execute">EXECUTE</button>
                    </div>
                </div>
                <br>
                <fieldset class="card border-secondary" id="field-result" style="display:none">
                    <legend  class="w-auto ml-5">Query Result</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12 table-wrapper-scroll-y my-custom-scrollbar scroll-y">
                                <table id="table-result" class="table table-sm table-bordered mb-3">
                                    <thead id="result-header">
                                    </thead>
                                    <tbody id="result-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-1"></div>
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

        .nowrap{
            white-space: nowrap;
        }

        .selectize-dropdown, .selectize-input {
            line-height: inherit !important;
        }


    </style>

    <script>
        $(document).ready(function () {
            $('#header-tanggal').append(now());

            $('#tabel').selectize();
            $('#tipe').selectize();

            currentTime = new Date();
            const hour = currentTime.getHours();

            checkLoginStatus(hour);
        });

        function checkLoginStatus(hour) {
            window.setInterval(function(){
                date = new Date();

                refreshTime();

                if(hour != date.getHours()){
                    location.reload();
                }
                else{
                    console.log('sama');
                }
            }, 1000);
        }



        columnlist = '';
        result = '';
        column = [];

        function refreshTime() {
            tanggal = $('#header-tanggal').html().substr(0, $('#header-tanggal').html().length - 8);
            time = $('#header-tanggal').html().substr(-8);
            time = time.split(':');
            h = parseInt(time[0]);
            m = parseInt(time[1]);
            s = parseInt(time[2]);

            s = parseInt(s) + 1;

            if(s == 60){
                s = '00';
                m = parseInt(m) + 1;

                if(m == 60){
                    m = '00';
                    h = parseInt(h) + 1;
                }
            }

            if(s < 10 && s != '00')
                s = '0' + s;

            if(m < 10 && m != '00')
                m = '0' + m;

            $('#header-tanggal').html(tanggal + h + ':' + m + ':' + s);
        }

        function now(){
            date = new Date('{{ $now }}');

            var weekday = new Array(7);
            weekday[0] = "Minggu";
            weekday[1] = "Senin";
            weekday[2] = "Selasa";
            weekday[3] = "Rabu";
            weekday[4] = "Kamis";
            weekday[5] = "Jumat";
            weekday[6] = "Sabtu";

            var hari = weekday[date.getDay()];

            tgl = date.getDate();
            bln = date.getMonth() + 1;
            if(bln < 10)
                bln = '0' + bln;
            thn = date.getFullYear();

            jam = date.getHours();
            menit = date.getMinutes();
            detik = date.getSeconds();

            if(detik < 10)
                detik = '0' + detik;
            if(menit < 10)
                menit = '0' + menit;

            return hari+', '+tgl+'/'+bln+'/'+thn+' '+jam+':'+menit+':'+detik;
        }

        $('#btn-select-otomatis').on('click',function(){
            $('#manual').hide();

            $('#tab').show();
            $('#select').show();
            $('#where').show();
            $('#group').show();
            $('#order').show();
            $('#insert').hide();
            $('#update').hide();
            $('#field-result').show();
        });

        $('#btn-select-manual').on('click',function(){
            $('#manual').show();

            $('#select').hide();
            $('#where').hide();
            $('#group').hide();
            $('#order').hide();
            $('#insert').hide();
            $('#update').hide();
        });

        $('#tipe').on('change',function(){
            $('#select').find('input').val('');
            $('#where').find('input').val('');
            $('#group').find('input').val('');
            $('#order').find('input').val('');
            $('#insert').find('input').val('');
            $('#update').find('input').val('');

            if($(this).val() == 'select'){
                $('#tab').show();
                $('#select').show();
                $('#where').show();
                $('#group').show();
                $('#order').show();
                $('#insert').hide();
                $('#update').hide();
                $('#field-result').show();
            }
            else if($(this).val() == 'delete'){
                $('#tab').hide();
                $('#where').show();
                $('#select').hide();
                $('#group').hide();
                $('#order').hide();
                $('#insert').hide();
                $('#update').hide();
                $('#field-result').hide();
            }
            else if($(this).val() == 'insert'){
                $('#tab').hide();
                $('#insert').show();
                $('#select').hide();
                $('#where').hide();
                $('#group').hide();
                $('#order').hide();
                $('#update').hide();
                $('#field-result').hide();
            }
            else if($(this).val() == 'update'){
                $('#tab').hide();
                $('#where').show();
                $('#update').show();
                $('#insert').hide();
                $('#select').hide();
                $('#group').hide();
                $('#order').hide();
                $('#field-result').hide();
            }
            else{
                $('#tab').hide();
                $('#where').hide();
                $('#update').hide();
                $('#insert').hide();
                $('#select').hide();
                $('#group').hide();
                $('#order').hide();
                $('#field-result').hide();
            }
        });

        $('#tabel').on('change',function(){
            if($(this).val() != ''){
                $.ajax({
                    url: '{{ url('select-oracle/getColumnList') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {table: $(this).val()},
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        swal({
                            title: 'Tabel '+$('#tabel').val()+' berhasil dipilih!',
                            text: '{{ strtoupper($_SESSION['connection']) }}',
                            icon: 'success',
                            buttons: false,
                            timer: 1000,
                        }).then(function(){
                            if($('#modal-loader').is(':visible')){
                                $('#modal-loader').modal('hide');
                            }
                        });
                        $('.column').find('option').remove();
                        $('.column').append("<option value='*' selected>* - SEMUA</option>");

                        $('#update').find('option').remove();
                        $('#update').find('.column').append('<option value="" disabled selected>- Pilih kolom -</option>');

                        columnlist = [];

                        $('#insert').find('div').remove();
                        for(i=0;i<response.length;i++){
                            arrColumn = response;
                            columnlist.push(response[i].column_name);
                            html = "<option value='"+response[i].column_name+"'>" + response[i].column_name + "</option>";
                            $('.column').append(html);

                            if(toLower(response[i].data_type) == 'timestamp without time zone' || toLower(response[i].data_type) =='date'){
                                $('#insert').append(
                                    '<div class="form-group row mb-0 insert-row">' +
                                    '<label for="tabel" class="col-sm-2 col-form-label">'+ response[i].column_name +'</label>' +
                                    '<div class="col-sm-4">' +
                                    '<input class="form form-control insert-column tanggal" type="text" id="'+ response[i].column_name +'" maxlength="' + nvl(response[i].data_length,999999) + '">' +
                                    '</div>' +
                                    '<label for="tabel" class="col-sm col-form-label text-left">'+ response[i].data_type +'</label>' +
                                    '</div>'
                                );
                            }
                            else if(toLower(response[i].data_type) == 'char'){
                                $('#insert').append(
                                    '<div class="form-group row mb-0 insert-row">' +
                                    '<label for="tabel" class="col-sm-2 col-form-label">'+ response[i].column_name +'</label>' +
                                    '<div class="col-sm-4">' +
                                    '<input class="form form-control insert-column" type="text" id="'+ response[i].column_name +'" maxlength="' + nvl(response[i].data_length,999999) + '">' +
                                    '</div>' +
                                    '<label for="tabel" class="col-sm col-form-label text-left">'+ response[i].data_type +'(1)</label>' +
                                    '</div>'
                                );
                            }
                            else{
                                $('#insert').append(
                                    '<div class="form-group row mb-0 insert-row">' +
                                    '<label for="tabel" class="col-sm-2 col-form-label">'+ response[i].column_name +'</label>' +
                                    '<div class="col-sm-4">' +
                                    '<input class="form form-control insert-column" type="text" id="'+ response[i].column_name +'" maxlength="' + nvl(response[i].data_length,999999) + '">' +
                                    '</div>' +
                                    '<label for="tabel" class="col-sm col-form-label text-left">'+ response[i].data_type +'</label>' +
                                    '</div>'
                                );
                            }

                            column.push(response[i].column_name);
                        }
                        $('.tanggal').datepicker({
                            "dateFormat" : "dd/mm/yy"
                        });

                        $('.select').selectize();
                        $('.where').selectize();
                        $('.update').selectize();
                        $('.group').selectize();
                        $('.order').selectize();

                    }
                });
            }
        });

        function column_onchange(event){
            if($(event.target).val() != '' && $(event.target).val() != '*'){
                $(event.target).parent().parent().find('.operator').prop('disabled',false);
                $(event.target).parent().parent().find('.operator').val('');
                $(event.target).parent().parent().find('.operator').select();
                $(event.target).parent().parent().find('.value').prop('disabled',false);
                $('.value').each(function(){
                    if($(this).hasClass('hasDatepicker')){
                        $(this).datepicker('destroy');
                        $(this).removeClass('hasDatepicker');
                    }
                })
                for(i=0;i<arrColumn.length;i++){
                    if(toLower(arrColumn[i]['data_type']) == 'timestamp without time zone' || toLower(arrColumn[i]['data_type']) =='date'){
                        $(event.target).parent().parent().find('.value').datepicker({
                            "dateFormat" : "dd/mm/yy"
                        });
                    }
                    else{
                        $(event.target).parent().parent().find('.value').datepicker('destroy');
                    }
                    if(toLower(arrColumn[i]['column_name']) == $(event.target).val()){
                        $(event.target).parent().parent().find('.value').prop('maxlength',nvl(arrColumn[i]['data_length'],999));
                        break;
                    }
                }
                $(event.target).parent().parent().find('.value').val('');
            }
            else{
                $(event.target).parent().parent().find('.operator').prop('disabled',true);
                $(event.target).parent().parent().find('.operator').val('');
                $(event.target).parent().parent().find('.value').prop('disabled',true);
                $(event.target).parent().parent().find('.value').val('');
            }
        }

        function tambah_select(){
            html = '<div class="form-group row mb-0 select-row">' +
                '<div class="col-sm-2"></div>' +
                '<div class="col-sm-4">' +
                '<select type="text" class="form-control column select selectized text-left" onchange="column_onchange(event)">' +
                '<option value="" selected disabled>- Pilih kolom -</option>';

            for(i=0;i<columnlist.length;i++){
                html += "<option value='" + columnlist[i] + "'>" + columnlist[i] + "</option>";
            }

            html += '</select>' +
                '</div>' +
                '<div class="col-sm-1">' +
                '<button class="col-sm-10 btn btn-danger" onclick="delete_row(event)">X</button>' +
                '</div>' +
                '</div>';

            $('#select').append(html);
            $('#select').find('.select').each(function(){
                if(!$(this).hasClass('selectized')){
                    $(this).selectize();
                }
            });
        }

        function tambah_where(){
            html = '<div class="form-group row mb-0 where-row">' +
                    '<div class="col-sm-2"></div>' +
                    '<div class="col-sm-4">' +
                        '<select type="text" class="form-control column where selectized text-left" onchange="column_onchange(event)">' +
                            '<option value="" selected disabled>- Pilih kolom -</option>';

            for(i=0;i<columnlist.length;i++){
                html += "<option value='" + columnlist[i] + "'>" + columnlist[i] + "</option>";
            }

            html += '</select>' +
                        '</div>' +
                        '<div class="col-sm-2">' +
                            '<select class="form form-control operator" type="text" disabled>\n' +
                                '<option value="" selected disabled>- Operator -</option>\n' +
                                '<option value="=">=</option>' +
                                '<option value="<"><</option>' +
                                '<option value="<="><=</option>' +
                                '<option value=">=">>=</option>' +
                                '<option value=">">></option>' +
                                '<option value="<>"><></option>' +
                                '<option value="LIKE">LIKE</option>' +
                            '</select>' +
                        '</div>' +
                        '<div class="col-sm-3">' +
                            '<input class="form form-control value" type="text" disabled>' +
                        '</div>' +
                        '<div class="col-sm-1">' +
                            '<button class="col-sm-10 btn btn-danger" onclick="delete_row(event)">X</button>' +
                        '</div>' +
                    '</div>';

            $('#where').append(html);
        }

        function tambah_group(){
            html = '<div class="form-group row mb-0 group-row">' +
                '<div class="col-sm-2"></div>' +
                '<div class="col-sm-4">' +
                '<select type="text" class="form-control column group selectized text-left" onchange="column_onchange(event)">' +
                '<option value="" selected disabled>- Pilih kolom -</option>';

            for(i=0;i<columnlist.length;i++){
                html += "<option value='"+columnlist[i] + "'>" + columnlist[i] + "</option>";
            }

            html += '</select>' +
                '</div>' +
                '<div class="col-sm-1">' +
                '<button class="col-sm-10 btn btn-danger" onclick="delete_row(event)">X</button>' +
                '</div>' +
                '</div>';

            $('#group').append(html);
        }

        function tambah_order(){
            html = '<div class="form-group row mb-0 order-row">' +
                '<div class="col-sm-2"></div>' +
                '<div class="col-sm-4">' +
                '<select type="text" class="form-control column order selectized text-left" onchange="column_onchange(event)">' +
                '<option value="" selected disabled>- Pilih kolom -</option>';

            for(i=0;i<columnlist.length;i++){
                html += "<option value='"+columnlist[i] + "'>" + columnlist[i] + "</option>";
            }

            html += '</select>' +
                        '</div>' +
                        '<div class="col-sm-2">\n' +
                            '<select type="text" class="form-control direction">' +
                                '<option value="ASC" selected>ASC</option>' +
                                '<option value="DESC">DESC</option>' +
                            '</select>' +
                        '</div>' +
                        '<div class="col-sm-1">' +
                            '<button class="col-sm-10 btn btn-danger" onclick="delete_row(event)">X</button>' +
                        '</div>' +
                    '</div>';

            $('#order').append(html);
        }

        function tambah_update(){
            html = '<div class="form-group row mb-0 update-row">' +
                '<div class="col-sm-2"></div>' +
                '<div class="col-sm-4">' +
                '<select type="text" class="form-control column update selectized text-left" onchange="column_onchange(event)">' +
                '<option value="" selected disabled>- Pilih kolom -</option>';

            for(i=0;i<columnlist.length;i++){
                html += "<option value='"+columnlist[i] + "'>" + columnlist[i] + "</option>";
            }

            html += '</select>' +
                '</div>' +
                '<div class="col-sm-4">' +
                '<input class="form form-control value" type="text" disabled>' +
                '</div>' +
                '<div class="col-sm-1">' +
                '<button class="col-sm-10 btn btn-danger" onclick="delete_row(event)">X</button>' +
                '</div>' +
                '</div>';

            $('#update').append(html);
        }

        function delete_row(event){
            $(event.target).parent().parent().remove();
        }

        function initial(){
            $('input').val('');
            $('select').val('');
            $('.direction').val('ASC');
            $('#where').hide();
            $('#update').hide();
            $('#insert').hide();
            $('#select').hide();
            $('#group').hide();
            $('#order').hide();
            $('#field-result').hide();

            var $select = $('#tabel').selectize();
            var control = $select[0].selectize;
            control.clear();
        }

        $('#btn-execute').on('click',function(){
            swal({
                title: 'Yakin ingin menjalankan query?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function (ok) {
                if(ok){
                    $('input').each(function(){
                        if(!$.isNumeric($(this).val())){
                            $(this).val($(this).val().toUpperCase());
                        }
                    });

                    select = '';
                    where = '';
                    group = '';
                    order = '';

                    tipe = $('#tipe').val();
                    tabel = $('#tabel').val();
                    if(tipe == 'select'){
                        if(!$('#manual').is(':visible')){
                            query = 'SELECT ';

                            $('.select-row').each(function(){
                                if(select.length == 0){
                                    select = $(this).find('.select').val();

                                    if($(this).find('.select').val() != '*'){
                                        column = [];
                                    }
                                }
                                else{
                                    select += ', ' + $(this).find('.select').val();
                                }
                                if($(this).find('.select').val() != '*') {
                                    column.push($(this).find('.select').val());
                                }
                                else{
                                    column = columnlist;
                                }
                            });

                            query += select;
                            query += ' FROM ' + $('#tabel').val();


                            $('.where-row').each(function(){
                                if($(this).find('.where').val() != null && $(this).find('.where').val() != '*'){
                                    if(where.length == 0){
                                        where = ' WHERE ' + $(this).find('.where').val() + " " + $(this).find('.operator').val() + " '" + $(this).find('.value').val() + "'";
                                    }
                                    else{
                                        where += " AND " + $(this).find('.where').val() + " " +  $(this).find('.operator').val() + " '" + $(this).find('.value').val() + "' ";
                                    }
                                }
                            });

                            query += where;

                            $('.group-row').each(function(){
                                if($(this).find('.group').val() != null) {
                                    if($(this).find('.group').val() != '*'){
                                        if(group.length == 0){
                                            group = ' GROUP BY ' + $(this).find('.group').val();
                                        }
                                        else{
                                            group += ', ' + $(this).find('.group').val();
                                        }
                                    }
                                }
                            });

                            query += group;

                            $('.order-row').each(function(){
                                if($(this).find('.order').val() != null) {
                                    if($(this).find('.order').val() != '*'){
                                        if(order.length == 0){
                                            order = ' ORDER BY ' + $(this).find('.order').val() + ' ' + $(this).find('.direction').val();
                                        }
                                        else{
                                            order += ', ' + $(this).find('.order').val();
                                        }
                                    }
                                }
                            });

                            query += order;
                        }
                        else{
                            query = $('#query-manual').val();
                        }
                    }
                    else if(tipe == 'insert'){
                        query = 'INSERT INTO ' + $('#tabel').val() + '(';
                        values = 'VALUES(';
                        $('.insert-column').each(function(){
                            if($(this).val() != ''){
                                query += $(this).attr('id') + ', ';
                                values += "'" + $(this).val().toUpperCase() + "', ";
                            }
                        });

                        query = query.slice(0,-2) + ') ';
                        query += values.slice(0,-2) + ')';
                    }
                    else if(tipe == 'update'){
                        query = 'UPDATE ' + $('#tabel').val() + ' SET ';

                        $('.update-row').each(function(){
                            zzz = $(this).find('.update').val();
                            xxx = $(this).find('.value').val();
                            if($(this).find('.update').val() != '' && $(this).find('.value').val() != ''){
                                query += $(this).find('.update').val() + " = '" + $(this).find('.value').val().toUpperCase() + "', ";
                            }
                        });
                        query = query.slice(0,-2);
                        where = '';
                        $('.where-row').each(function(){
                            if($(this).find('.where').val() != '' && $(this).find('.operator').val() != '' && $(this).find('.value').val() != ''){
                                if(where == '')
                                    where = ' WHERE ';
                                if(where != ' WHERE '){
                                    where += ' AND ';
                                }
                                where += $(this).find('.where').val() + ' ' + $(this).find('.operator').val() + " '" + $(this).find('.value').val() + "'";
                            }
                        })

                        query += where;
                    }
                    else if(tipe == 'delete'){
                        query = 'DELETE FROM ' + $('#tabel').val();
                        where = '';

                        $('.where-row').each(function(){
                            if($(this).find('.operator').val() != '' && $(this).find('.value').val() != ''){
                                if(where != ''){
                                    where += ' AND ';
                                }
                                if(where == ''){
                                    where = ' WHERE ';
                                }
                                where += $(this).find('.where').val() + ' ' + $(this).find('.operator').val() + "'" + $(this).find('.value').val() + "'";
                            }
                        });

                        query += where;
                    }

                    console.log(query);

                    $.ajax({
                        url: '{{ url('select-oracle/execute') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {table: $('#tabel').val(), data: query, column: column},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            if($('#modal-loader').is(':visible'))
                                $('#modal-loader').modal('hide');
                            console.log(response);

                            result = response.result;

                            if(response.status == 'success'){
                                if($('#table-result').find('tr').length != 0){
                                    $('#table-result').DataTable().destroy();
                                    $('#table-result').find('tr').remove();
                                }

                                if(tipe == 'select'){
                                    $('#field-result').show();
                                    header = '<tr class="text-center">';
                                    for(i=0;i<column.length;i++){
                                        header += "<th>" + column[i].toUpperCase() + "</th>";
                                    }
                                    header += "</tr>";

                                    $('#result-header').append(header);
                                    for(i=0;i<result.length;i++){
                                        html = '<tr class="text-left">';
                                        for(j=0;j<column.length;j++){
                                            html += '<td class="nowrap">' + nvl(result[i][column[j].toLowerCase()], '') + '</td>';
                                        }
                                        html += '</tr>';

                                        $('#result-body').append(html);
                                    }

                                    $('#table-result').DataTable();
                                }
                                else{
                                    $('#field-result').hide();
                                }

                                if(tipe == 'insert' || tipe == 'update'){
                                    $('#insert').find('input').val('');
                                    $('#update').find('input').val('');
                                    $('#where').find('input').val('');
                                }

                                swal({
                                    title: 'Query berhasil dijalankan!',
                                    text: response.message,
                                    icon: response.status
                                }).then(function(ok){
                                    if(ok && tipe != 'select')
                                        initial();
                                    if($('#modal-loader').is(':visible'))
                                        $('#modal-loader').modal('hide');
                                });
                            }
                            else{
                                swal({
                                    title: 'Query gagal dijalankan!',
                                    text: response.message,
                                    icon: response.status
                                }).then(function(ok){
                                    if(ok && tipe != 'select')
                                        initial();
                                    if($('#modal-loader').is(':visible'))
                                        $('#modal-loader').modal('hide');
                                });
                            }
                        }
                    });
                }
            })
        });
    </script>

@endsection
