<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    /*
     * For private model Eloquent.
     */
    protected $model;

    /**
     * For validate request.
     */
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users'
    ];

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->model = new User;

        parent::__construct($request);
    }

    /**
     * Allows to do something before create/update of the record
     *
     * @param $req
     * @param $item
     * @return void
     */
    public function setItem(&$req, &$item)
    {
        $item->name = $req->get('name');
        $item->email = $req->get('email');
        $item->password = Hash::make($req->get('password'));
    }
}
