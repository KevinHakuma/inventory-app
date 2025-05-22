<div class="max-h-96 overflow-y-auto space-y-4 pr-2">
    @foreach ($history as $item)
        <div class="border-b pb-2">
            <div><strong>Dari:</strong> {{ $item->cabangAsal->nama_cabang ?? '-' }}</div>
            <div><strong>Ke:</strong> {{ $item->cabangTujuan->nama_cabang ?? '-' }}</div>
            <div><strong>User Baru:</strong> {{ $item->user_baru }}</div>
            <div><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal_pindah)->format('d M Y H:i') }}</div>
            <div><strong>Keterangan:</strong> {{ $item->keterangan ?? '-' }}</div>
        </div>
    @endforeach
</div>
