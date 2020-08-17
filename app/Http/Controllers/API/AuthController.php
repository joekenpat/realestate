<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
      $user->update([
        'last_login' => now()->format('Y-m-d H:i:s.u'),
        'last_ip' => $request->getClientIp(),
      ]);
      $success['token'] = $user->createToken('realstate')->accessToken;
      $success['data'] = $user;
      return response()->json([
        'success' => $success,
      ], Response::HTTP_CREATED);
    } else {
      return response()->json([
        'error' => 'Invalid Credentials',
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
        $users[$key]->property_count = $user->properties()->count();
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
    $this->validate($request, [
      'first_name' => 'required|alpha|max:25|min:2',
      'last_name' => 'required|alpha|max:25|min:2',
      'username' => 'required|alpha_dash|max:25|min:2',
      'phone' => 'required|string|max:15|min:8',
      'email' => 'required|email|max:150|min:5',
      'password' => 'required|string',
    ]);
    $data = $request->all();
    $data['password'] = Hash::make($data['password']);
    $data['country_id'] = GeoIP::getCountry();
    $data['city_id'] = GeoIP::getCity();
    $data['last_ip'] = $request->getClientIp();
    $data['last_login'] = now();
    $user = User::create($data);
    if ($user) {
      $user->update([
        'last_login' => now()->format('Y-m-d H:i:s.u'),
        'last_ip' => $request->getClientIp(),
      ]);
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
  public function update(Request $request)
  {
    $this->validate($request, [
      'first_name' => 'required|alpha|max:25|min:2',
      'last_name' => 'required|alpha|max:25|min:2',
      'username' => 'required|alpha_dash|max:25|min:2',
      'phone' => 'required|string|max:15|min:8',
      'city_id' => 'required|numeric|',
      'state_id' => 'required|numeric|',
      'bio' => 'required|string|min:5|max:255',
      'address' => 'required|string|min:5|max:255',
      'avatar' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);
    try {
      $user = User::where('id', Auth()->user()->id)->firstOrFail();
      $data = $request->all();
      //adding images
      if ($request->hasFile('avatar')) {
        $image = $request->file('avatar');
        $img_ext = $image->getClientOriginalExtension();
        $img_name = sprintf("A%s.%s", Auth()->user()->id, $img_ext);
        $image->move(public_path("images/users/profile/" . Auth()->user()->id), $img_name);
        $data['avatar'] = $img_name;
        if (File::exists("images/users/profile/" . Auth()->user()->id)) {
          File::delete("images/users/profile/" . Auth()->user()->id);
        }
        $user->avatar = $data['avatar'];
      }

      $user->first_name = $data['first_name'];
      $user->last_name = $data['last_name'];
      $user->username = $data['username'];
      $user->city_id = $data['city_id'];
      $user->state_id = $data['state_id'];
      $user->bio = $data['bio'];
      $user->address = $data['address'];
      $user->update();

      return response()->json('Profile Updated', Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json('User not Found', Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
  public function switchUserStatus($status = null, $user_id)
  {
    $user_action = function () use ($status) {
      if (in_array($status, ['blocked', 'active', 'reported'])) {
        $user_action = $status;
      } else {
        return response()->json([
          'error' => 'Invalid Action',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
      }
    };
    try {
      $user = User::where('id', $user_id)->firstOrFail();
      $user->status = 'blocked';
      if ($user_action == 'blocked') {
        $user->blocked_at = now();
      }
      $user->updated();
      return response()->json("User Status set to {$status}!", Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json([
        'error' => 'No Item Found',
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * Swap a user Role.
   *
   * @param  int  $role, $id
   * @return \Illuminate\Http\Response
   */
  public function swap_user_role($user_id, $role)
  {
    $user_role = function () use ($role) {
      $action_map = ['user', 'admin', 'agent'];
      if (in_array($role, $action_map)) {
        return $action_map[$role];
      } else {
        return null;
      }
    };
    if ($user_role != null) {
      try {
        $user = User::where('id', $user_id)->firstOrFail();
        $user->role = $user_role();
        $user->blocked_at = now();
        $user->blocked = true;
        $user->updated();
        return response()->json("User Changed to {$user->role}", Response::HTTP_OK);
      } catch (ModelNotFoundException $mnt) {
        return response()->json('No Item Found', Response::HTTP_NOT_FOUND);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    } else {
      return response()->json(
        'Invalid Action',
        Response::HTTP_UNPROCESSABLE_ENTITY
      );
    }
  }
}
