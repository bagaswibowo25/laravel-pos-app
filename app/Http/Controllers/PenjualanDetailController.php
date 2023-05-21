<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Setting;
use App\Models\Serial;
use App\Models\Product;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $serial = Serial::leftJoin('product', 'product.id_product', 'serial.id_product')
            ->where('used', 0)
            ->select('serial.*', 'nama_product','harga','merek','nomor_model')
            ->orderBy('nomor_seri', 'asc')
            ->get();

        // Cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            $penjualan = Penjualan::find($id_penjualan);

            return view('penjualan_detail.index', compact('serial', 'id_penjualan', 'penjualan'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $serial_detail = PenjualanDetail::with('serial')
            ->where('id_penjualan', $id)
            ->leftJoin('product', 'product.id_product', 'penjualan_detail.id_product')
            ->select('penjualan_detail.*','nama_product','nomor_model')
            ->get();
        
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($serial_detail as $item) {
            $row = array();
            $row['nomor_seri']  = $item->serial['nomor_seri'];
            $row['nama_product']  = $item->nama_product;
            $row['harga_jual']  = 'Rp. '. format_uang($item->harga_jual);
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('transaksi.destroy', $item->id_penjualan_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_jual;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'nomor_seri' => '
                <div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'nama_product' => '',
            'harga_jual'  => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'nomor_seri'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $serial = Serial::leftJoin('product', 'product.id_product', 'serial.id_product')
        ->where('id_serial', $request->id_serial)
        ->select('serial.*', 'nama_product','harga')
        ->first();
        if (! $serial) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan;
        $detail->id_serial = $serial->id_serial;
        $detail->id_product = $serial->id_product;
        $detail->harga_jual = $serial->harga;
        $detail->subtotal = $serial->harga;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon = 0, $total = 0, $diterima = 0)
    {
        $bayar   = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data    = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];

        return response()->json($data);
    }
}
