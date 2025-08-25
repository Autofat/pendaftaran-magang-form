<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Peserta;
use Carbon\Carbon;


class PesertaController extends Controller
{
    // Tampilkan form pendaftaran
    public function create()
    {
        return view('form.pendaftaran');
    }

    // Simpan data pendaftaran
    public function store(Request $request)
    {
        $request->validate([
            'nomor_telpon' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'institusi' => 'required|string|max:255',
            'jenis_pendaftaran' => 'required|in:PKL,Magang Mandiri,Penelitian',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Hitung jumlah hari (minimal 31 hari)
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $days = $mulai->diffInDays($selesai) + 1;
        $days = $days < 31 ? 31 : $days;

        // Hitung biaya
        $biaya = 0;
        if ($request->jenis_pendaftaran === 'PKL' || $request->jenis_pendaftaran === 'Penelitian') {
            $biaya = 110000 * ceil($days / 31);
        } elseif ($request->jenis_pendaftaran === 'Magang Mandiri') {
            $biaya = 1100000 * ceil($days / 31);
        }

        $peserta = Peserta::create([
            'nomor_telpon' => $request->nomor_telpon,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'institusi' => $request->institusi,
            'jenis_pendaftaran' => $request->jenis_pendaftaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'biaya' => $biaya,
        ]);

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Data Anda telah tersimpan dan akan segera diproses.');
    }

    // Dashboard admin: daftar peserta
    public function dashboard()
    {
        $pesertas = Peserta::all();
        
        // Statistik berdasarkan jenis pendaftaran
        $stats = [
            'PKL' => $pesertas->where('jenis_pendaftaran', 'PKL')->count(),
            'Magang Mandiri' => $pesertas->where('jenis_pendaftaran', 'Magang Mandiri')->count(),
            'Penelitian' => $pesertas->where('jenis_pendaftaran', 'Penelitian')->count(),
        ];
        
        // Hitung peserta aktif (yang masa magangnya belum selesai)
        $today = Carbon::today();
        $activeCount = $pesertas->filter(function ($peserta) use ($today) {
            return Carbon::parse($peserta->tanggal_selesai)->gte($today);
        })->count();
        
        $totalCount = $pesertas->count();
        $inactiveCount = $totalCount - $activeCount;
        
        return view('admin.dashboard', compact('pesertas', 'stats', 'activeCount', 'inactiveCount', 'totalCount'));
    }

    // Hapus peserta
    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $nama = $peserta->nama_lengkap;
        
        $peserta->delete();
        
        return redirect()->route('admin.dashboard')->with('success', "Data peserta {$nama} berhasil dihapus.");
    }
}
