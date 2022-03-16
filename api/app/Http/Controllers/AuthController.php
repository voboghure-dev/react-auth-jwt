<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    return $this->_token( $user );
  }

  public function login( Request $request ) {
    $request->validate( [
      'email'    => ['required', 'string', 'email'],
      'password' => ['required', 'string'],
    ] );

    // Check if email exist
    $user = User::where( 'email', $request->email )->first();

    // Check if password match
    if ( ! $user || ! Hash::check( $request->password, $user->password ) ) {
      return response( [
        'message' => 'Credential does not match',
      ] );
    }

    return $this->_token( $user );
  }

  protected function _token( $user ) {
    $token = $user->createToken( 'ourapptoken' )->plainTextToken;

    $response = ['user' => $user, 'token' => $token];

    return response( $response, 201 );
  }
}
