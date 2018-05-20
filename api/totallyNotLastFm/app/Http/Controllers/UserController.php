<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

  //Constructor
  public function __construct(){
    //$this->middleware('auth', ['only' => ['me']]);
  }


  /*----------------------------Basic functions--------------------------*/


  /* Récupère email + mdp et génère token si good */

  //get all users
  public function getAllUsers(){
    $users = User::all();

    return response()->json(['data' => $users], 200);
  }

  //create user
  public function createUser(Request $request){
    $this->validateRequestUser($request);

    $user = User::create([
      'username' => $request->get('username'),
      'birthday' => $request->get('birthday'),
      'mail' => $request->get('mail'),
      'password' => Hash::make($request->get('password'))
    ]);

    return response()->json(['data' => "The user with id {$user->id} has been created"], 201);
  }

  //get User
  public function getUser($id){
    $user = User::find($id);

    if(!$user)
      return response()->json(['message' => "The user with id {$id} doesn't exist"], 404);

    return response()->json(['data' => $user], 200);
  }

  //update User
  public function updateUser(Request $request, $id){
    $user = User::find($id);

    if(!$user)
      return response()->json(['message' => "The user with id {$id} doesn't exist"], 404);

    $this->validateRequestUser($request);

    $user->username = $request->get('username');
    $user->user_birthday = $request->get('user_birthday');
    $user->email = $request->get('email');
    $user->password = Hash::make($request->get('password'));

    $user->save();

    return response()->json(['data' => "The user with id {$user->id} has been updated"], 200);
  }

  /*************** USER DIFFERENTS CHANGES **************/

  //change User Name
  public function changeUserName(Request $request, $id){
    $user = User::find($id);

    if(!$user)
      return response()->json(['message' => "The user with id {$id} doesn't exist"], 404);

    $this->validateRequestUser($request);

    $user->username = $request->get('username');
    //$user->password = Hash::make($request->get('password'));

    $user->save();

    return response()->json(['data' => "The user name with id {$user->id} has been updated"], 200);
  }

  //change User Password
  public function changeUserPassword(Request $request, $id){
    $user = User::find($id);

    if(!$user)
      return response()->json(['message' => "The user with id {$id} doesn't exist"], 404);

    $this->validateRequestUser($request);

    //$user->username = $request->get('username');
    $user->password = Hash::make($request->get('password'));

    $user->save();

    return response()->json(['data' => "The user password with id {$user->id} has been updated"], 200);
  }

  //change User Email
  public function changeUserEmail(Request $request, $id){
    $user = User::find($id);

    if(!$user)
      return response()->json(['message' => "The user with id {$id} doesn't exist"], 404);

    $this->validateRequestUser($request);

    //$user->username = $request->get('username');
    $user->email = $request->get('email');
    //$user->password = Hash::make($request->get('password'));

    $user->save();

    return response()->json(['data' => "The user email with id {$user->id} has been updated"], 200);
  }


  //delete User
  public function deleteUser($id){
    $user = User::find($id);

    if(!$user)
      return response()->json(['message' => "The user with id {$id} doesn't exist"], 404);

    $user->delete();

    return response()->json(['data' => "The user with id {$id} has been deleted"], 200);
  }

  //check existence of user mail
  public function mailExist($mail){
    $user = User::wher('mail', '=', $id)->count();
    if ($user == 0)
        return response()->json(['message' => "The user with mail $mail doesn't exist"], 200);
    return response()->json(['message' => "The user with mail $mail exist"], 404);
  }
  
  /*----------------------------Stats functions--------------------------*/


  /*----------------------------Annex functions--------------------------*/


  //validate request
  public function validateRequestUser(Request $request){
    $rules = [
      'username' => 'required|unique:user',
      'user_birthday' => 'required|date',
      'email' => 'required|email|unique:user',
      'password' => 'required|min:6'
    ];

    $this->validate($request, $rules);
  }

}

?>
