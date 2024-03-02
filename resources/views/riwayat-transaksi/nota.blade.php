<style>
    @media print {
        @page {
            size: A5;
            margin: 10px;
        }
        body {
            margin: 10px;
        }
    }
    * {
        margin: 0px;
        font-family: monospace;
    }
    .center{
        width: 100hw;
        text-align: center;
    }
    .detail-transaksi {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
</style>

<div>
    <h5 class="center">-[ Nota Kasir ]-</h5>
    <h5 class="center">{{ auth()->user()->name }}</h5>
    <h5 class="center">{{ date('Y-M-d h:i:s') }}</h5>
    <div class="detail-transaksi" style="margin-top: 20px;">
        <h5>Kode Pembayaran</h5><h5>:{{ $model->code }}</h5>
    </div>
    <div class="detail-transaksi">
        <h5>id_transaksi</h5><h5>:{{ $model->id }}</h5>
    </div>
    <div class="detail-transaksi">
        <h5>Nama Konsumen</h5><h5>:{{ $model->nama_pelanggan }}</h5>
    </div>
    <div class="detail-transaksi">
        <h5>Nominal</h5><h5>:Rp {{ $model->total }}</h5>
    </div>
    <h5 style="margin-top: 20px;">-- DETAIL CARA PEMBAYARAN --</h5>
    <div class="detail-transaksi">
        <h5>Total Tagihan</h5><h5>:Rp {{ $model->total_before }}</h5>
    </div>
    <div class="detail-transaksi">
        <h5>Total Diskon</h5><h5>:Rp {{ $model->total_before - $model->total }}</h5>
    </div>
    <div class="detail-transaksi">
        <h5>Setelah Diskon</h5><h5>:Rp {{ $model->total }}</h5>
    </div>
    <div class="detail-transaksi" style="margin-top: 20px;">
        <h5>Tunai</h5><h5>:Rp {{ $model->total }}</h5>
    </div>
    <div class="detail-transaksi">
        <h5>Non Tunai/Kartu</h5><h5>:Rp {{ 0 }}</h5>
    </div>
    <div class="detail-transaksi">
        <h5>Tunai</h5><h5>:Rp {{ 0 }}</h5>
    </div>
    <h5 class="center" style="margin-top: 20px;">Hubungi Call Center 000-0000000</h5>
    <h5 class="center">Terima Kasih</h5>
</div>
