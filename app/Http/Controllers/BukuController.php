<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $buku = Buku::all();

            if ($acceptHeader === 'application/json') {

                $outPut = [
                    "message" => "bukus",
                    "results" => $buku
                ];

                return response()->json($buku, 200);
            } else {
                // create xml posts element
                $xml = new \SimpleXMLElement('<buku/>');
                foreach ($buku->items('data') as $item) {
                    $xmlItem = $xml->addChild('buku');

                    // mengubah setiap field post menjadi bentuk xml
                    $xmlItem->addChild('id_buku', $item->id_buku);
                    $xmlItem->addChild('judul', $item->judul);
                    $xmlItem->addChild('kategori', $item->kategori);
                    $xmlItem->addChild('pengarang', $item->pengarang);
                    $xmlItem->addChild('penerbit', $item->penerbit);
                    $xmlItem->addChild('tahun_terbit', $item->tahun_terbit);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable', 406);
        }
    }

    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $buku = Buku::find($id);

            if ($acceptHeader === 'application/json') {

                if(!$buku) {
                    abort(404);
                }

                return response()->json($buku, 200);

            } else {
                // create xml buku element
                $xml = new \SimpleXMLElement('<buku/>');

                // create xml buku element
                $xmlItem = $xml->addChild('buku');

                // mengubah setiap field post menjadi bentuk xml
                $xmlItem->addChild('id_buku', $item->id_buku);
                $xmlItem->addChild('judul', $item->judul);
                $xmlItem->addChild('kategori', $item->kategori);
                $xmlItem->addChild('pengaranag', $item->pengarang);
                $xmlItem->addChild('penerbit', $item->penerbit);
                $xmlItem->addChild('tahun_terbit', $item->tahun_terbit);
                $xmlItem->addChild('created_at', $item->created_at);
                $xmlItem->addChild('updated_at', $item->updated_at);

                return $xml->asXML();
            }

        } else {
            return response('Not Acceptable', 406);
        }
    }

    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

                $input = $request->all();

                $validationRules = [
                    'judul' => 'required|min:5',
                    'kategori' => 'required',
                    'pengarang' => 'required',
                    'penerbit' => 'required',
                    'tahun_terbit' => 'required|max:4',
                ];

                $validator = Validator::make($input, $validationRules);

                if ($validator->fails()){
                    return response()->json($validator->errors(), 400);
                }

                $buku = Buku::create($input);
                return response()->json($buku, 200);
        } else {
            return response('Not Acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $input = $request->all();

            $buku = Buku::find($id);

            if(!$buku) {
                abort(404);
            }

            // validation
            $validationRules = [
                'judul' => 'required|min:5',
                'kategori' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required|max:4',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
            // validation end

            $buku->fill($input);
            $buku->save();

            return response()->json($buku, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $buku = Buku::find($id);

            if ($acceptHeader === 'application/json') {
                if(!$buku) {
                    abort(404);
                }

                $buku->delete();
                $message = ['message' => 'deleted successfully', 'id_buku' => $id];

                return response()->json($message, 200);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
