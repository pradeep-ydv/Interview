<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            session()->flash('success', 'Logged In Successfully');
            return redirect()->route('admin');
        } else {
            session()->flash('error', 'Email or password incorrect');
            return redirect('/');
        }
    }

    public function logout()
    {

        try {

            Auth::guard('web')->logout();
            session()->flash('success', 'logged out Successfully');
            return redirect('/');
        } catch (\Exception $e) {
            session()->flash('success', 'logged out Successfully' . $e->getMessage());
        }
    }

    public function index()
    {
        
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('users', json_encode($array));
    }

    public function profile()
    {
        $profile = Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Successfully updated your profile');
        } else {
            session()->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success', 'Password successfully changed');
    }

    // Pie chart
    public function userPieChart(Request $request)
    {
        // dd($request->all());
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('course', json_encode($array));
    }

    public function storageLink()
    {
        // check if the storage folder already linked;
        if (File::exists(public_path('storage'))) {
            // removed the existing symbolic link
            File::delete(public_path('storage'));

            //Regenerate the storage link folder
            try {
                Artisan::call('storage:link');
                session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            } catch (\Exception $exception) {
                session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        } else {
            try {
                Artisan::call('storage:link');
                session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            } catch (\Exception $exception) {
                session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
    }
}
