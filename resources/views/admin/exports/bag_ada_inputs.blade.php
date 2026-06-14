<table>
    <tbody>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="17">DATA PELAKU PENGADAAN BERSERTA PAKET PENGADAAN BERKONTRAK T.A. {{ $year }}</td>
        </tr>
        <tr></tr>
        <tr>
            <td rowspan="2">NO</td>
            <td rowspan="2">SATKER</td>
            <td rowspan="2">PELAKU PENGADAAN</td>
            <td rowspan="2">NAMA</td>
            <td rowspan="2">PANGKAT</td>
            <td rowspan="2">NRP/NIP</td>
            <td colspan="2">KEP/SPRIN</td>
            <td rowspan="2">MENANGANI PAKET</td>
            <td colspan="2">NILAI</td>
            <td rowspan="2">METODE PENGADAAN</td>
            <td rowspan="2">NAMA PENYEDIA</td>
            <td colspan="3">KONTRAK</td>
            <td rowspan="2">KETERANGAN</td>
        </tr>
        <tr>
            <td>NOMOR</td>
            <td>TANGGAL</td>
            <td>PAGU</td>
            <td>KONTRAK</td>
            <td>NOMOR</td>
            <td>TANGGAL MULAI</td>
            <td>TANGGAL SELESAI</td>
        </tr>
        <tr>
            @for ($i = 1; $i <= 17; $i++)
                <td>{{ $i }}</td>
            @endfor
        </tr>
        <tr></tr>
        @php
            $no = 1;
        @endphp
        @foreach($groupedInputs as $satkerId => $inputs)
            @php
                $satker = $satkers->get($satkerId);
            @endphp
            @foreach($inputs as $index => $item)
                <tr>
                    @if($index === 0)
                        <td>{{ $no++ }}</td>
                        <td>{{ $satker ? $satker->name : '-' }}</td>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                    <td>{{ $item->pelakuPengadaan->nama_peran ?? '-' }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->pangkat ?? '-' }}</td>
                    <td>{{ $item->nrp_nip ?? '-' }}</td>
                    <td>{{ $item->kep_nomor ?? '-' }}</td>
                    <td>{{ $item->kep_tanggal ? $item->kep_tanggal->format('j F Y') : '-' }}</td>
                    <td>{{ $item->menangani_paket ?? '-' }}</td>
                    <td>{{ $item->nilai_pagu }}</td>
                    <td>{{ $item->nilai_kontrak }}</td>
                    <td>{{ $item->metodePengadaan->nama_metode ?? '-' }}</td>
                    <td>{{ $item->nama_penyedia ?? '-' }}</td>
                    <td>{{ $item->kontrak_nomor ?? '-' }}</td>
                    <td>{{ $item->kontrak_tanggal_mulai ? $item->kontrak_tanggal_mulai->format('j F Y') : '-' }}</td>
                    <td>{{ $item->kontrak_tanggal_selesai ? $item->kontrak_tanggal_selesai->format('j F Y') : '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
