<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class AdminStokController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.stok', compact('menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $menu = Menu::findOrFail($id);

        // update stok
        $menu->stok = $request->stok;
        $menu->save();

        return redirect()
            ->route('admin.stok')
            ->with('success', 'Stok berhasil diperbarui!');
    }
}