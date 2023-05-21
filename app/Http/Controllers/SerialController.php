<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Serial;
use PDF;

class SerialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all()->pluck('nama_product', 'id_product');

        return view('serial.index', compact('product'));
    }

    public function data()
    {
        $serial = Serial::leftJoin('product', 'product.id_product', 'serial.id_product')
            ->select('serial.*', 'nama_product','harga','merek','nomor_model')
            ->orderBy('nomor_seri', 'asc')
            ->get();

        return datatables()
            ->of($serial)
            ->addIndexColumn()
            ->addColumn('select_all', function ($serial) {
                return '
                    <input type="checkbox" name="id_serial[]" value="'. $serial->id_serial .'">
                ';
            })
            ->addColumn('nomor_seri', function ($serial) {
                return '<span class="label label-success">'. $serial->nomor_seri .'</span>';
            })
            ->addColumn('harga', function ($serial) {
                return format_uang($serial->harga);
            })
            ->addColumn('stok', function ($serial) {
                return format_uang($serial->stok);
            })
            ->addColumn('aksi', function ($serial) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('serial.update', $serial->id_serial) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('serial.destroy', $serial->id_serial) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'nomor_seri', 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $serial = Serial::latest()->first() ?? new Serial();
        $request['nomor_seri'] = 'S'. tambah_nol_didepan((int)$serial->id_serial +1, 6);
        $request['used'] = 0;

        $serial = Serial::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serial = Serial::find($id);

        return response()->json($serial);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $serial = Serial::find($id);
        $serial->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    public function updateStatus(Request $request)
    {
        $serial = Serial::find($request->id_serial);
        $serial->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serial = Serial::find($id);
        $serial->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_serial as $id) {
            $serial = Serial::find($id);
            $serial->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataserial = array();
        foreach ($request->id_serial as $id) {
            $serial = Serial::find($id);
            $dataserial[] = $serial;
        }

        $no  = 1;
        $pdf = PDF::loadView('serial.barcode', compact('dataserial', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('serial.pdf');
    }
}
