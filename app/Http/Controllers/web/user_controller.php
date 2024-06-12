<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Transportation_company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class user_controller extends Controller
{
    public function registration(Request $req)
    {
        try {
            //code...
            DB::beginTransaction();
            $image = $req->file;
            $existing_user = User::where('email', $req->email)->first();
            if ($existing_user) {
                return redirect('register')->with('failure', 'This Account exist');
            } else {
                $new_user = new User();
                # code...
                if ($image) {
                    $image_name = Time() . '.' . $image->getClientOriginalExtension();
                    $req->file->move('profile_photo', $image_name);
                    $new_user->profile_image = $image_name;
                }

                $new_user->phone_number = $req->phone_number;
                $new_user->first_name = $req->first_name;
                $new_user->last_name = $req->last_name;
                $new_user->email = $req->email;
                $new_user->password = Hash::make($req->password);

                $registerd_user = $new_user->save();
                DB::commit();
                if ($registerd_user) {
                    return redirect('login')->with('success', 'Account created successifuly');
                } else {
                    DB::rollBack();
                    return redirect('register')->with('failure', 'Registration failed');
                }
            }
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function login(Request $req)
    {
        try {
            $user = User::where('email', $req->input('email'))->first();
            if (!$user) {
                return redirect('login')->with('failure', 'Incorrect email or password');
            } else {
                if ($user && Hash::check($req->input('password'), $user->password)) {
                    $transcompanies = Transportation_company::where('user_id', $user->id)->get();
                    $req->session()->put('user_id', $user->id);
                    $req->session()->put('user_object', $user);
                    $req->session()->put('usercompanies', $transcompanies);

                    return redirect('dashboard')->with('success', 'Login successfully');

                } else {
                    return redirect('login')->with('failure', 'Incorrect email or password');
                }
            }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json(
                [
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
