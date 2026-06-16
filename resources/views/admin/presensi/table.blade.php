<table>
    <thead><tr><th>Tanggal</th><th>Guru</th><th>Masuk</th><th>Pulang</th><th>Status</th><th>Metode</th></tr></thead>
    <tbody>
        @forelse ($presensis as $presensi)
            <tr>
                <td>{{ $presensi->tanggal->format('d-m-Y') }}</td>
                <td>{{ $presensi->guru->nama }}</td>
                <td>{{ $presensi->jam_masuk ?? '-' }}</td>
                <td>{{ $presensi->jam_pulang ?? '-' }}</td>
                <td><span @class(['status-pill', 'status-empty' => $presensi->status === 'belum_presensi'])>{{ str_replace('_', ' ', $presensi->status) }}</span></td>
                <td>{{ $presensi->metode_input ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada presensi.</td></tr>
        @endforelse
    </tbody>
</table>
