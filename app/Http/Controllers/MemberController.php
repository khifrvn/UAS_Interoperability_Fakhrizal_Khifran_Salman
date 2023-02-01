<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $member = Member::all();

            if ($acceptHeader === 'application/json') {

                $outPut = [
                    "message" => "members",
                    "results" => $member
                ];

                return response()->json($member, 200);
            } else {
                // create xml posts element
                $xml = new \SimpleXMLElement('<member/>');
                foreach ($member->items('data') as $item) {
                    $xmlItem = $xml->addChild('member');

                    // mengubah setiap field post menjadi bentuk xml
                    $xmlItem->addChild('id_member', $item->id_member);
                    $xmlItem->addChild('name', $item->name);
                    $xmlItem->addChild('umur', $item->umur);
                    $xmlItem->addChild('alamat', $item->alamat);
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

            $member = Member::find($id);

            if ($acceptHeader === 'application/json') {

                if(!$member) {
                    abort(404);
                }

                return response()->json($member, 200);

            } else {
                // create xml member element
                $xml = new \SimpleXMLElement('<member/>');

                // create xml member element
                $xmlItem = $xml->addChild('member');

                // mengubah setiap field post menjadi bentuk xml
                $xmlItem->addChild('id_member', $item->id_member);
                $xmlItem->addChild('name', $item->name);
                $xmlItem->addChild('umur', $item->umur);
                $xmlItem->addChild('alamat', $item->alamat);
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
                    'alamat' => 'required',
                    'no_telp' => 'required',
                ];

                $validator = Validator::make($input, $validationRules);

                if ($validator->fails()){
                    return response()->json($validator->errors(), 400);
                }

                $member = Member::create($input);
                return response()->json($member, 200);
        } else {
            return response('Not Acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $input = $request->all();

            $member = Member::find($id);

            if(!$member) {
                abort(404);
            }

            // validation
            $validationRules = [
                'name' => 'required|min:5',
                'umur' => 'required',
                'alamat' => 'required',
                'no_telp' => 'required',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
            // validation end

            $member->fill($input);
            $member->save();

            return response()->json($member, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $member = Member::find($id);

            if ($acceptHeader === 'application/json') {
                if(!$member) {
                    abort(404);
                }

                $member->delete();
                $message = ['message' => 'deleted successfully', 'id_member' => $id];

                return response()->json($message, 200);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
