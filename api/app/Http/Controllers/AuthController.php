<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {
  public function register( Request $request ) {
    $request->validate( [
      'name'     => ['required', 'string'],
      'email'    => ['required', 'string', 'unique:users,email'],
      'password' => ['required', 'string'],
    ] );

    $user = User::create( [
      'name'     => $request->name,
      'email'    => $request->email,
      'password' => bcrypt( $request->password ),
    ] );

    $token = $user->createToken( 'ourapptoken' )->plainTextToken;

    $response = ['user' => $user, 'token' => $token];

    return response( $response, 201 );
  }

  public function login( Request $request ) {
    $request->validate( [
      'email'    => ['required', 'string', 'email'],
      'password' => ['required', 'string'],
    ] );

    // Check if email exist
    $user = User::where('email', $request->email)->first();
  }
}
