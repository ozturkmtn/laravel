<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function account(Request $request)
    {
        $request->validate([
            'email' => 'required | email',
            'password' => 'required | min:3 | max:12'
        ]);


        return $request->input();
        dump( $request->path());
        dump( $request->path());
        dump( $request->method());
        dump( $request->getSession());
        dump( $request->getSession()->previousUrl());
        dump( $request->getSession()->token());
        dump( $request->getSession()->getId());
        dump( $request->getUser());
        dump( $request->format());
        dump( $request->query());
        die;
        return $request->input();
    }
}
