<!DOCTYPE html>
<html>
<head>
    <title>Report Password Generator {{ $tanggal }}</title>
</head>
<body>
<!-- <a href="/getPdf"><button>Download PDF</button></a> -->

<?php
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>{{ $perusahaan->prs_namaperusahaan }}<br><br>
            {{ $perusahaan->prs_namacabang }}<br><br>
            {{ $perusahaan->prs_namaregional }}</p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>TGL : {{ date("d-m-Y") }}<br><br>
            JAM : {{ $datetime->format('H:i:s') }}<br><br>
        </p>
{{--            PRG : IGR_BO_KKEKEBTOKO</p>--}}
    </div>
    <h2 style="text-align: center">** REPORT PASSWORD GENERATOR **<br>Tanggal : {{ $tanggal }}</h2>
    {{--<h2>KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **<br>Periode : {{ $periode }}</h2>--}}
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <td>NO</td>
            <td>KODE CABANG</td>
            <td>JAM</td>
            <td>OTP</td>
            <td>USER PEMAKAI</td>
            <td>KETERANGAN</td>
            <td>USER PEMBERI</td>
            <td>TANGGAL PEMBERIAN</td>
        </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @foreach($record as $r)
                @php $i++; @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $r->otp_kodeigr }}</td>
                    <td>{{ $r->otp_jam }}</td>
                    <td>{{ $r->otp_kode }}</td>
                    <td>{{ $r->otp_user }}</td>
                    <td class="keterangan">{{ $r->otp_keterangan }}</td>
                    <td>{{ $r->otp_create_by }}</td>
                    <td>{{ substr($r->otp_create_dt,0,19) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
{{--        <tr style="text-align: right">--}}
{{--            <td colspan="23"></td>--}}
{{--            <td>Total</td>--}}
{{--            <td>{{ $data[0]->kke_kubik1 }}</td>--}}
{{--            <td>{{ $data[0]->kke_kubik2 }}</td>--}}
{{--            <td>{{ $data[0]->kke_kubik3 }}</td>--}}
{{--            <td>{{ $data[0]->kke_kubik4 }}</td>--}}
{{--            <td>{{ $data[0]->kke_kubik5 }}</td>--}}
{{--            <td colspan="10"></td>--}}
{{--        </tr>--}}
        </tfoot>
    </table>

    <hr>
{{--    <strong>Kebutuhan Kontainer :</strong><br>--}}
{{--    20 Feet<br>--}}
{{--    <hr>--}}
{{--    <div style="float:left">--}}
{{--        NB :<br>--}}
{{--        1 Kubikase = 30 m3, 1 Tonase = 22<br>--}}
{{--        Toleransi Kubikase & Tonase adalah 5%--}}
{{--    </div>--}}

{{--    <table style="float:right" class="table-ttd table-borderless">--}}
{{--        <tr>--}}
{{--            <td>Disetujui</td>--}}
{{--            <td>Dibuat</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td></td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td></td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td></td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td class="ttd">Store Mgr</td>--}}
{{--            <td class="ttd">Store Jr. Mgr</td>--}}
{{--        </tr>--}}
{{--    </table>--}}
</main>

<br>
</body>
<style>
    @page {
        margin: 25px 25px;
        /*size: 1071pt 792pt;*/
        size: 595pt 842pt;
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    body {
        margin-top: 70px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
    }
    table{
        border-collapse: collapse;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    td {
        display: table-cell;
    }
    thead{
        text-align: center;
    }
    tbody{
        text-align: center;
    }

    .keterangan{
        text-align: left;
    }
    .table{
        width: 100%;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        margin-top: 25px;
    }
    .table-ttd{
        width: 15%;
    }
    .table tbody td {
        vertical-align: top;
        /*border-top: 1px solid #dee2e6;*/
        padding: 0.20rem 0;
        width: auto;
    }
    .table th{
        vertical-align: top;
        padding: 0.20rem 0;
    }
    .judul, .table-borderless{
        text-align: center;
    }
    .table-borderless th, .table-borderless td {
        border: 0;
        padding: 0.50rem;
    }
    .center{
        text-align: center;
    }
</style>
</html>
