<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PulkitJalan\GeoIP\Facades\GeoIP;

class AuthController extends Controller
{
  /**
   * login function.
   *
   * @param \illuminate\Http\Client\Request $request
   * @return \Illuminate\Http\
   */
  public function login(Request $request)
  {
    $credentials = [
      'email' => $request->email,
      'password' => $request->password
    ];
    if (auth()->attempt($credentials)) {
      $user = Auth::user();
      $success['token'] = $user->createToken('realstate')->accessToken;
      $success['data'] = $user;
      return response()->json([
        'success' => $success,
      ], Response::HTTP_CREATED);
    } else {
      return response()->json([
        'error' => 'Unauthorised',
      ], Response::HTTP_UNAUTHORIZED);
    }
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    try {
      $status = $request->filled('status') ? $request->status : 1;
      $role = $request->filled('role') ? $request->role : 0;
      $sort = $request->filled('sort') ? $request->sort : 1;
      $result_count = $request->filled('result_count') ? $request->result_count : 10;


      $user_role = function () use ($role) {
        $role_map = [0 => 'user', 1 => 'admin', 2 => 'agent'];
        if (in_array($role, array_keys($role_map))) {
          return $role_map[$role];
        } else {
          return $role_map[0];
        }
      };

      $user_status = function () use ($status) {
        $status_map = [0 => 'disabled', 1 => 'active'];
        if (in_array($status, array_keys($status_map))) {
          return $status_map[$status];
        } else {
          return $status_map[0];
        }
      };

      $user_sort = function () use ($sort) {
        $sort_map = [0 => "desc", 1 => 'asc'];
        if (in_array($sort, array_keys($sort_map))) {
          return $sort_map[$sort];
        } else {
          return $sort_map[0];
        }
      };

      $user_result_count = function () use ($result_count) {
        if (in_array($result_count, [10, 25, 50, 100])) {
          return $result_count;
        } else {
          return 10;
        }
      };

      // $users = User::where('status', $user_status())
      //   ->where('role', $user_role())
      //   ->orderBy('created_at', $user_sort())
      //   ->paginate($user_result_count());

        $users = User::where('role', $user_role())
        ->orderBy('created_at', $user_sort())
        ->paginate($user_result_count());
      foreach ($users as $key => $user) {
        $users[$key]->product_count = $user->products()->count();
      }
      $success['data'] = $users;
      return response()->json([
        'success' => $success,
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json([
        'error' => 'No Item Found',
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'error' => sprintf("message: %s. Error File: %s. Error Line: %s", $e->getMessage(), $e->getFile(), $e->getLine()),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'first_name' => 'required|alpha|max:25|min:2',
      'last_name' => 'required|alpha|max:25|min:2',
      'username' => 'required|alpha_dash|max:25|min:2',
      'phone' => 'required|string|max:15|min:8',
      'email' => 'required|email:rfc,dns|max:150|min:5',
      'password' => 'required|string',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'error' => $validator->$validator->errors()
      ]);
    }

    $data = $request->all();
    $data['password'] = Hash::make($data['password']);
    $data['country_id'] = GeoIP::getCountry();
    $data['city_id'] = GeoIP::getCity();
    $data['last_ip'] = $request->getClientIp();
    $data['last_login'] = now();
    $user = User::create($data);
    if ($user) {
      $success['token'] = $user->createToken('realstate')->accessToken;
      $success['data'] = $user;
      return response()->json([
        'success' => $success,
      ], Response::HTTP_CREATED);
    } else {
      return response()->json([
        'error' => 'Unauthorised',
      ], Response::HTTP_UNAUTHORIZED);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    // $user = Auth::user()
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  { {
      $validator = Validator::make($request->all(), [
        'first_name' => 'required|alpha|max:25|min:2',
        'last_name' => 'required|alpha|max:25|min:2',
        'username' => 'required|alpha_dash|max:25|min:2',
        'phone' => 'required|string|max:15|min:8',
        'email' => 'required|email:rfc,dns|max:150|min:5',
        'password' => 'required|string',
        'bio' => 'string|min:5|max:255',
        'avatar_file' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
        'twitter' => 'string|',
        'facebook' => 'string|',
        'instagram' => 'string|',
        'google' => 'string|',
      ]);
      if ($validator->fails()) {
        return response()->json([
          'error' => $validator->$validator->errors()
        ]);
      }
      try {
        $data = $request->all();
        $data['country_id'] = GeoIP::getCountry();
        $data['city_id'] = GeoIP::getCity();
        //adding images
        $image = $request->file('avatar_file');
        $img_ext = $image->getClientOriginalExtension();
        $img_name = sprintf("UPIMG_%s.%s", $id, $img_ext);
        $image->storeAs("images/users/profile", $img_name);
        $data['avatar'] = $img_name;
        User::where('id', $id)->update($data);
        $updated_user = User::where('id', $id)->firstOrFail();
        $success['data'] = $updated_user;
        return response()->json([
          'success' => $success,
        ], Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json([
          'error' => 'User not Found',
        ], Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json([
          'error' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }


  /**
   * Block a user.
   *
   * @param  int  $action, $id
   * @return \Illuminate\Http\Response
   */
  public function switchUserStatus($action = null, $id)
  {
    $user_action = function () use ($action) {
      if (in_array($action, ['block', 'unblock'])) {
        return $action;
      } else {
        return null;
      }
    };
    if ($user_action() == 'block') {
      try {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'disabled';
        $user->blocked_at = now();
        $user->blocked = true;
        $user->updated();
        User::where('id', $id)->products()->update([
          'status' => 'disabled',
        ]);
        return response()->json([
          'success' => 'User Blocked!',
        ], Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json([
          'error' => 'No Item Found',
        ], Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json([
          'error' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } elseif ($user_action() == 'unblock') {
      try {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'active';
        $user->blocked_at = null;
        $user->blocked = false;
        $user->updated();
        User::where('id', $id)->products()->update([
          'status' => 'active',
        ]);
        return response()->json([
          'success' => 'User Unblocked!',
        ], Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json([
          'error' => 'No Item Found',
        ], Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json([
          'error' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } else {
      return response()->json([
        'error' => 'Invalid Action',
      ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

  /**
   * Swap a user Role.
   *
   * @param  int  $role, $id
   * @return \Illuminate\Http\Response
   */
  public function swapUserRole($role = null, $id)
  {
    $user_role = function () use ($role) {
      $action_map = [0 => 'user', 1 => 'admin', 2 => 'agent'];
      if (in_array($role, array_keys($action_map))) {
        return $action_map[$role];
      } else {
        return null;
      }
    };
    if ($user_role != null) {
      try {
        $user = User::where('id', $id)->firstOrFail();
        $user->role = $user_role();
        $user->blocked_at = now();
        $user->blocked = true;
        $user->updated();
        return response()->json([
          'success' => "User Changed to {$user->role}",
        ], Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json([
          'error' => 'No Item Found',
        ], Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json([
          'error' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } else {
      return response()->json([
        'error' => 'Invalid Action',
      ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }
}
