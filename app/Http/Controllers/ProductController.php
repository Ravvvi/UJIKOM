<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $products = Product::when($search, function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        })->get();

        return view('welcome', compact('products'));
    }


    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan Admin.');
        }
        return view('create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki otoritas ini.');
        }

        $data = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048' 
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        Product::create($data);
        return redirect('/')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses terbatas untuk Admin.');
        }

        $product = Product::findOrFail($id);
        return view('edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Update gagal: Anda bukan Admin.');
        }

        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);
        return redirect('/')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Hanya Admin yang boleh menghapus produk.');
        }

        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect('/')->with('success', 'Produk berhasil dihapus!');
    }
}