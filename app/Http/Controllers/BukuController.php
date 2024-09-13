<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy('judul', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan !',
            'body' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'judul' => 'required|max:50',
                'pengarang' => 'required|max:20',
                'tanggal_publikasi' => 'required'
            ], [
                'judul.required' => 'Judul Wajib diisi !',
                'judul.max' => 'Panjang Judul Maksimal 50 Karakter',
                'pengarang.required' => 'Pengarang Wajib diisi !',
                'pengarang.max' => 'Panjang Pengarang Maksimal 20 Karakter !',
                'tanggal_publikasi.required' => 'Tanggal Publikasi Wajib diisi !'
            ]);
            $data = [
                'judul' => $request->judul,
                'pengarang' => $request->pengarang,
                'tanggal_publikasi' => $request->tanggal_publikasi
            ];
            Buku::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditambahkan !',
                'body' => $data
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukan data !',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Buku::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Ditemukan !',
                'body' => $data
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan !',
                'errors' => 'Buku dengan id ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'judul' => 'required|max:50',
                'pengarang' => 'required|max:20',
                'tanggal_publikasi' => 'required'
            ], [
                'judul.required' => 'Judul Wajib diisi !',
                'judul.max' => 'Panjang Judul Maksimal 50 Karakter',
                'pengarang.required' => 'Pengarang Wajib diisi !',
                'pengarang.max' => 'Panjang Pengarang Maksimal 20 Karakter !',
                'tanggal_publikasi.required' => 'Tanggal Publikasi Wajib diisi !'
            ]);
            $data = [
                'judul' => $request->judul,
                'pengarang' => $request->pengarang,
                'tanggal_publikasi' => $request->tanggal_publikasi
            ];
            Buku::where('id', $id)->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Diubah !',
                'body' => $data
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Mengubah Data !',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Buku::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menghapus Data !'
        ], 200);
    }
}
