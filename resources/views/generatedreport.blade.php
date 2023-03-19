<!DOCTYPE html>
<html>
<head>
  <title>{{ $title }}</title>
  <style>
  @media print{@page {size: landscape}}
  table {
  border-collapse: collapse;
  }
   th {
    background: #ccc;
  }

  table, th, td {
    border: 1px solid #000000;
    padding: 8px;
  }

  </style>
</head>
<body style="margin: 40px;">
<!-- HEADER -->
<div style="margin-top: 40px;">
  <h3 style="text-align: center;">LAPORAN JASA PENGELOLAAN GUDANG INDUK PT INKA (PERSERO)</h3>
</div>
<!-- BODY -->
<!-- judul dan table 1 -->
<section>
  <div>
    <h5>I. LAPORAN MONITORING KINERJA PERSONIL GUDANG (Terhitung mulai tgl :  {{ $tanggal }})</h5>
    <table style="width: 100%;">
      <thead>
        <tr>
          <th rowspan="2">Operator</th>
          <th colspan="3">STTP</th>
          <th colspan="3">BPM</th>
          <th rowspan="2">Hours/Items</th>
        </tr>
        <tr>
          <th>doc</th>
          <th>item</th>
          <th>hour</th>
          <th>doc</th>
          <th>item</th>
          <th>hour</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $item)
        <tr>
          <td>{{ $item->nip }} : {{ $item->name }}</td>
          <td>{{ $item->count_sttp }}</td>
          <td>{{ $item->count_in_item }}</td>
          <td>
            <?php  $hours = (int)($item->sttp_sum / 3600);
              $minutes = floor(($item->sttp_sum / 60) % 60);
              $seconds = $item->sttp_sum % 60;
              
              echo $hours.' Hours '.'<br>'.$minutes.' Minutes';
            ?>
          </td>
          <td>{{ $item->count_bpm }}</td>
          <td>{{ $item->count_out_item }}</td>
          <td>
            <?php  $hours = (int)($item->bpm_sum / 3600);
              $minutes = floor(($item->bpm_sum / 60) % 60);
              $seconds = $item->bpm_sum % 60;
              
              echo $hours.' Hours '.'<br>'.$minutes.' Minutes';
            ?>
          </td>
          <td>
            <?php  $hours = (int)($item->average_hour / 3600);
              $minutes = floor(($item->average_hour / 60) % 60);
              $seconds = $item->average_hour % 60;
              
              echo $hours.' Hours '.'<br>'.$minutes.' Minutes';
            ?>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>
<div style="page-break-after: always;"></div>
<!-- judul dan table 2 -->
<section>
  <div style="margin-top: 40px;">
    <h5>II. LAPORAN MONITORING STOCK GUDANG PERIODE BULAN {{ $header_date }} (Terhitung mulai tanggal : {{ $tanggal }})</h5>
    <table style="width: 50%;">
      <thead>
        <tr>
          <th>Pelayanan Gudang</th>
          <th>Jumlah Dokumen</th>
          <th>Jumlah Item Barang</th>
          <th>Jumlah Total Barang</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Pelayanan barang masuk (STTP)</td>
          <td>{{ $sttp_count_doc }}</td>
          <td>{{ $sttp_count_line }}</td>
          <td>{{ $sttp_count_qty }}</td>
        </tr>
        <tr>
          <td>Pelayanan keluar (BPM)</td>
          <td>{{ $bpm_count_doc }}</td>
          <td>{{ $bpm_count_line }}</td>
          <td>{{ $bpm_count_qty }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
<br>
<br>
<!-- ttd -->
<section>
  <div style="width: 100%; display: flex; justify-content: space-between;">
    <div style="float: left;">
        <br>
        DIPERIKSA
        <br>
        {{ $jabatan_pemeriksa }}
        <br>
        <br>
        <br>
        <br>
        {{ $nama_pemeriksa }}
    </div>
    <div style="float: right;">
        Madiun, <?php echo date('d F Y') ?>
        <br>
        DISIAPKAN
        <br>
        {{ Auth::user()->position->position_name }}
        <br>
        <br>
        <br>
        <br>
        {{ Auth::user()->name }}
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div style="width: 100%; display: flex; justify-content: center; margin-left: 40%;">
    <div>
        <br>
        DISAHKAN
        <br>
        {{ $jabatan_pengesah }}
        <br>
        <br>
        <br>
        <br>
        {{ $nama_pengesah }}
    </div>
  </div>
</section>
</body>
</html>