<?php
namespace App;

use Illuminate\Support\Facades\Auth;

class PasswordGrantVerifier
{
  public function verify($username, $password)
  {
      $emailCredentials = [
        'email'    => $username,
        'password' => $password,
      ];

      $nimCredentials = [
        'nim'    => $username,
        'password' => $password,
      ];

      if (Auth::once($emailCredentials) || Auth::once($nimCredentials)) {
          return Auth::user()->id;
      }

      return false;
  }
}
?>