<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $request;

    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        // return response()->json(["users" => $users]);
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insertado = false;
        $insertado = DB::table('users')->insertGetId(
            [
                'name' => $this->request->input('name'),
                'email' => $this->request->input('email'),
                'password' => "abc",
                'status' => 1,
            ]
        );

        return response()->json(
            [
                "insertado" => $insertado
            ],
            201
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('users')->select('name', 'email', 'status')->where("id", $id)->first();
        return response()->json(
            $user,
            200
        );
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
        $this->validate(
            $this->request,
            [
                "name" => "required",
                "email" => "required|email"
            ]
        );

        $user  = DB::table('users')->where('id', $id)->update([
            'name' => $this->request->input('name'),
            'email' => $this->request->input('email'),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return response()->json(
            $user,
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = DB::table('users')->where('id', $id)->delete();
        //
        return response()->json(
            $user,
            200
        );
    }
}
