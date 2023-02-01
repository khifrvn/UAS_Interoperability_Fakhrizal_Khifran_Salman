<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $admin = Admin::all();

            if ($acceptHeader === 'application/json') {

                $outPut = [
                    "message" => "admins",
                    "results" => $admin
                ];

                return response()->json($admin, 200);
            } else {
                // create xml posts element
                $xml = new \SimpleXMLElement('<admin/>');
                foreach ($admin->items('data') as $item) {
                    $xmlItem = $xml->addChild('admin');

                    // mengubah setiap field post menjadi bentuk xml
                    $xmlItem->addChild('id_admin', $item->id_admin);
                    $xmlItem->addChild('name', $item->name);
                    $xmlItem->addChild('umur', $item->umur);
                    $xmlItem->addChild('no_telp', $item->no_telp);
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

            $admin = Admin::find($id);

            if ($acceptHeader === 'application/json') {

                if(!$admin) {
                    abort(404);
                }

                return response()->json($admin, 200);

            } else {
                // create xml admin element
                $xml = new \SimpleXMLElement('<admin/>');

                // create xml admin element
                $xmlItem = $xml->addChild('admin');

                // mengubah setiap field post menjadi bentuk xml
                $xmlItem->addChild('id_admin', $item->id_admin);
                $xmlItem->addChild('name', $item->name);
                $xmlItem->addChild('umur', $item->umur);
                $xmlItem->addChild('no_telp', $item->no_telp);
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
                    'name' => 'required|min:5',
                    'umur' => 'required',
                    'no_telp' => 'required',
                ];

                $validator = Validator::make($input, $validationRules);

                if ($validator->fails()){
                    return response()->json($validator->errors(), 400);
                }

                $admin = Admin::create($input);
                return response()->json($admin, 200);
        } else {
            return response('Not Acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $input = $request->all();

            $admin = Admin::find($id);

            if(!$admin) {
                abort(404);
            }

            // validation
            $validationRules = [
                'name' => 'required|min:5',
                'umur' => 'required',
                'no_telp' => 'required',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
            // validation end

            $admin->fill($input);
            $admin->save();

            return response()->json($admin, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $admin = Admin::find($id);

            if ($acceptHeader === 'application/json') {
                if(!$admin) {
                    abort(404);
                }

                $admin->delete();
                $message = ['message' => 'deleted successfully', 'id_admin' => $id];

                return response()->json($message, 200);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
