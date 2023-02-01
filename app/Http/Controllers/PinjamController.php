<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PinjamController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $pinjam = Pinjam::all();

            if ($acceptHeader === 'application/json') {

                $outPut = [
                    "message" => "pinjams",
                    "results" => $pinjam
                ];

                return response()->json($pinjam, 200);
            } else {
                // create xml posts element
                $xml = new \SimpleXMLElement('<pinjam/>');
                foreach ($pinjam->items('data') as $item) {
                    $xmlItem = $xml->addChild('pinjam');

                    // mengubah setiap field post menjadi bentuk xml
                    $xmlItem->addChild('kode_pinjam', $item->kode_pinjam);
                    $xmlItem->addChild('id_member', $item->id_member);
                    $xmlItem->addChild('tgl_pinjam', $item->tgl_pinjam);
                    $xmlItem->addChild('tgl_kembali', $item->tgl_kembali);
                    $xmlItem->addChild('jumlah_buku', $item->jumlah_buku);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable', 406);
        }
    }

    // public function show(Request $request, $id)
    // {
    //     $acceptHeader = $request->header('Accept');

    //     if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

    //         $pinjam = Pinjam::find($id);

    //         if ($acceptHeader === 'application/json') {

    //             if(!$pinjam) {
    //                 abort(404);
    //             }

    //             return response()->json($pinjam, 200);

    //         } else {
    //             // create xml pinjam element
    //             $xml = new \SimpleXMLElement('<pinjam/>');

    //             // create xml pinjam element
    //             $xmlItem = $xml->addChild('pinjam');

    //             // mengubah setiap field post menjadi bentuk xml
    //             $xmlItem->addChild('kode_pinjam', $item->kode_pinjam);
    //             $xmlItem->addChild('id_member', $item->id_member);
    //             $xmlItem->addChild('tgl_pinjam', $item->tgl_pinjam);
    //             $xmlItem->addChild('tgl_kembali', $item->tgl_kembali);
    //             $xmlItem->addChild('jumlah_buku', $item->jumlah_buku);
    //             $xmlItem->addChild('created_at', $item->created_at);
    //             $xmlItem->addChild('updated_at', $item->updated_at);

    //             return $xml->asXML();
    //         }

    //     } else {
    //         return response('Not Acceptable', 406);
    //     }
    // }

    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

                $input = $request->all();

                $validationRules = [
                    'id_member' => 'required',
                    'tgl_pinjam' => 'required',
                    'tgl_kembali' => 'required',
                    'jumlah_buku' => 'required',
                ];

                $validator = Validator::make($input, $validationRules);

                if ($validator->fails()){
                    return response()->json($validator->errors(), 400);
                }

                $pinjam = Pinjam::create($input);
                return response()->json($pinjam, 200);
        } else {
            return response('Not Acceptable', 406);
        }
    }

    // public function update(Request $request, $id)
    // {

    //     $acceptHeader = $request->header('Accept');

    //     if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

    //         $input = $request->all();

    //         $pinjam = Pinjam::find($id);

    //         if(!$pinjam) {
    //             abort(404);
    //         }

    //         // validation
    //         $validationRules = [
    //             'id_member' => 'required',
    //             'tgl_pinjam' => 'required',
    //             'tgl_kembali' => 'required',
    //             'jumlah_buku' => 'required',
    //         ];

    //         $validator = Validator::make($input, $validationRules);

    //         if ($validator->fails()){
    //             return response()->json($validator->errors(), 400);
    //         }
    //         // validation end

    //         $pinjam->fill($input);
    //         $pinjam->save();

    //         return response()->json($pinjam, 200);
    //     } else {
    //         return response('Not Acceptable!', 406);
    //     }
    // }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $pinjam = Pinjam::find($id);

            if ($acceptHeader === 'application/json') {
                if(!$pinjam) {
                    abort(404);
                }

                $pinjam->delete();
                $message = ['message' => 'deleted successfully', 'kode_pinjam' => $id];

                return response()->json($message, 200);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}