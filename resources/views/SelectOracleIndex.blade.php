@extends('SelectOracleNavbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Select Oracle</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="tabel" class="col-sm-2 col-form-label">Tabel</label>
                                    <div class="col-sm-4">
                                        <select type="text" class="form-control" id="tabel">
                                            <option value="" selected disabled>- Pilih Tabel -</option>
                                            @foreach($tablelist as $t)
                                            <option value="{{ $t->table_name }}">{{ strtoupper($t->table_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="tipe" class="col-sm-2 col-form-label">Tipe</label>
                                    <div class="col-sm-4">
                                        <select type="text" class="form-control" id="tipe">
                                            <option value=""selected disabled>- Pilih tipe query -</option>
                                            <option value="select">SELECT</option>
                                            <option value="insert">INSERT</option>
                                            <option value="update">UPDATE</option>
                                            <option value="delete">DELETE</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="insert" style="display:none">

                                </div>
                                <div id="select" style="display:none">
                                    <div class="form-group row mb-0 select-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Select</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column select" onchange="column_onchange(event)">
                                                <option value="" selected disabled>- Pilih Tabel terlebih dahulu -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="col-sm-10 btn btn-info" onclick="tambah_select()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="where" style="display:none">
                                    <div class="form-group row mb-0 where-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Where</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column where" onchange="column_onchange(event)">
                                                <option value="" selected disabled>- Pilih Tabel terlebih dahulu -</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <input class="form form-control operator" type="text" disabled>
                                        </div>
                                        <div class="col-sm-4">
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
                                            <select type="text" class="form-control column group" onchange="column_onchange(event)">
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
                                            <select type="text" class="form-control column order">
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
                                <div id="update" style="display:none">
                                    <div class="form-group row mb-0 update-row">
                                        <label for="tabel" class="col-sm-2 col-form-label">Set</label>
                                        <div class="col-sm-4">
                                            <select type="text" class="form-control column update" onchange="column_onchange(event)">
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
        $(document).ready(function () {

        });

        columnlist = '';
        result = '';
        column = [];

        $('#tipe').on('change',function(){
            $('#select').find('input').val('');
            $('#where').find('input').val('');
            $('#group').find('input').val('');
            $('#order').find('input').val('');
            $('#insert').find('input').val('');
            $('#update').find('input').val('');

            if($(this).val() == 'select'){
                $('#select').show();
                $('#where').show();
                $('#group').show();
                $('#order').show();
                $('#insert').hide();
                $('#update').hide();
                $('#field-result').show();
            }
            else if($(this).val() == 'delete'){
                $('#where').show();
                $('#select').hide();
                $('#group').hide();
                $('#order').hide();
                $('#insert').hide();
                $('#update').hide();
                $('#field-result').hide();
            }
            else if($(this).val() == 'insert'){
                $('#insert').show();
                $('#select').hide();
                $('#where').hide();
                $('#group').hide();
                $('#order').hide();
                $('#update').hide();
                $('#field-result').hide();
            }
            else if($(this).val() == 'update'){
                $('#where').show();
                $('#update').show();
                $('#insert').hide();
                $('#select').hide();
                $('#group').hide();
                $('#order').hide();
                $('#field-result').hide();
            }
            else{
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
            $.ajax({
                url: '{{ url('select-oracle/getColumnList') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {table: $(this).val()},
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    if($('#modal-loader').is(':visible'))
                        $('#modal-loader').modal('toggle');

                    $('.column').find('option').remove();
                    $('.column').append("<option value='*' selected>* - SEMUA</option>");

                    $('#update').find('option').remove();
                    $('#update').find('.column').append('<option value="" disabled selected>- Pilih kolom -</option>');

                    columnlist = [];

                    $('#insert').find('div').remove();
                    for(i=0;i<response.length;i++){
                        columnlist.push(response[i].column_name);
                        html = "<option value='"+response[i].column_name+"'>" + response[i].column_name + "</option>";
                        $('.column').append(html);

                        $('#insert').append(
                            '<div class="form-group row mb-0 insert-row">' +
                                '<label for="tabel" class="col-sm-2 col-form-label">'+ response[i].column_name +'</label>' +
                                '<div class="col-sm-4">' +
                                    '<input class="form form-control insert-column" type="text" id="'+ response[i].column_name +'">' +
                                '</div>' +
                                '<label for="tabel" class="col-sm col-form-label text-left">('+ response[i].data_type +')</label>' +
                            '</div>'
                        );

                        column.push(response[i].column_name);
                    }
                }
            });
        });

        function column_onchange(event){
            if($(event.target).val() != '' && $(event.target).val() != '*'){
                $(event.target).parent().parent().find('.operator').prop('disabled',false);
                $(event.target).parent().parent().find('.operator').val('');
                $(event.target).parent().parent().find('.operator').select();
                $(event.target).parent().parent().find('.value').prop('disabled',false);
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
                '<select type="text" class="form-control column select" onchange="column_onchange(event)">' +
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
        }

        function tambah_where(){
            html = '<div class="form-group row mb-0 where-row">' +
                    '<div class="col-sm-2"></div>' +
                    '<div class="col-sm-4">' +
                        '<select type="text" class="form-control column where" onchange="column_onchange(event)">' +
                            '<option value="" selected disabled>- Pilih kolom -</option>';

            for(i=0;i<columnlist.length;i++){
                html += "<option value='" + columnlist[i] + "'>" + columnlist[i] + "</option>";
            }

            html += '</select>' +
                        '</div>' +
                        '<div class="col-sm-1">' +
                            '<input class="form form-control operator" type="text" disabled>' +
                        '</div>' +
                        '<div class="col-sm-4">' +
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
                '<select type="text" class="form-control column group" onchange="column_onchange(event)">' +
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
                '<select type="text" class="form-control column order" onchange="column_onchange(event)">' +
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
                '<select type="text" class="form-control column update" onchange="column_onchange(event)">' +
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
            $('#where').hide();
            $('#update').hide();
            $('#insert').hide();
            $('#select').hide();
            $('#group').hide();
            $('#order').hide();
            $('#field-result').hide();
        }

        $('#btn-execute').on('click',function(){
            swal({
                title: 'Yakin ingin menjalankan query?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function (ok) {
                if(ok){
                    select = '';
                    where = '';
                    group = '';
                    order = '';

                    tipe = $('#tipe').val();
                    tabel = $('#tabel').val();
                    if(tipe == 'select'){
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
                            if($(this).find('.update').val() != '' && $(this).find('.value').val() != ''){
                                query += $(this).find('.update').val() + " = '" + $(this).find('.value').val().toUpperCase() + "', ";
                            }
                        });
                        query = query.slice(0,-2);
                        where = ' WHERE ';
                        $('.where-row').each(function(){
                            if($(this).find('.where').val() != '' && $(this).find('.operator').val() != '' && $(this).find('.value').val() != ''){
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
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            if($('#modal-loader').is(':visible'))
                                $('#modal-loader').modal('toggle');
                            console.log(response);

                            result = response.result;

                            if(response.status == 'success'){
                                if(tipe == 'select'){
                                    $('tr').remove();

                                    $('#field-result').show();
                                    header = '<tr class="text-center">';
                                    for(i=0;i<column.length;i++){
                                        header += "<th>" + column[i] + "</th>";
                                    }
                                    header += "</tr>";

                                    $('#result-header').append(header);
                                    for(i=0;i<result.length;i++){
                                        html = '<tr class="text-left">';
                                        for(j=0;j<column.length;j++){
                                            html += '<td>' + nvl(result[i][column[j]], '') + '</td>';
                                        }
                                        html += '</tr>';

                                        $('#result-body').append(html);
                                    }
                                }
                                else{
                                    $('tr').remove();
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
                                });
                            }
                        }
                    });
                }
            })
        });
    </script>

@endsection
