<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    // direct admin dashboard
    public function dashboard() {
        $totalSaleAmount = PaymentHistory::sum('total_amt');
        $orderRequest = Order::where('status',1)->count('id');
        $pendingRequest = Order::where('status',0)->count('id');
        $registeredUser = User::where('role','user')->count('id');

        return view('admin.home.dashboard', compact('totalSaleAmount','orderRequest','pendingRequest','registeredUser'));
    }

    // direct new admin page
    public function createAdminPage() {
        return view('admin.account.newAdmin');
    }

    // create new admin
    public function createAdmin(Request $request) {
        $this->checkValidation($request);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ];

        User::create($data);

        Alert::success('Success Title', 'New Admin Added Successfully!');
        return back();
    }

    // display admin list
    public function adminList() {
        $admins = User::select('id','name','nickname','email','address','phone','role','created_at','provider','profile')
                        ->whereIn('role', ['admin','superadmin'])
                        ->when(request('searchKey'), function($query) {
                            $query->whereAny(['name','email','address','provider'], 'like', '%'.request('searchKey').'%');
                        })
                        ->paginate(4);

        return view('admin.account.adminList', compact('admins'));
    }

    // delete admin account
    public function adminDelete($id) {
        User::where('id',$id)->delete();

        return back();
    }

    // display user list
    public function userList() {
        $users = User::select('id','name','nickname','email','address','phone','role','created_at','provider','profile')
                        ->where('role', 'user' )
                        ->when(request('searchKey'), function($query) {
                            $query->whereAny(['name','email','address','provider'], 'like', '%'.request('searchKey').'%');
                        })
                        ->paginate(4);

        return view('admin.account.userList', compact('users'));
    }

    // delete user account
    public function userDelete($id) {
        User::where('id',$id)->delete();

        return back();
    }

    // check account validation
    private function checkValidation($request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'confirmPassword' => 'required|same:password'
        ]);
    }
}
