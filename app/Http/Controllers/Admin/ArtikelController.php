<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
     public function index()
    {
        // sementara tes saja
        return view('admin.artikel.index');
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        // simpan artikel baru
    }

    public function edit($id)
    {
        return view('admin.artikel.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // update artikel
    }

    public function destroy($id)
    {
        // hapus artikel
    }
}
