<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    // direct payment list page
    public function list() {
        $payments = Payment::select('id','account_number','account_name','type')
                            ->when(request('searchKey'), function($query) {
                                $query->whereAny(['type','account_name'], 'like', '%'.request('searchKey').'%');
                            })
                            ->orderBy('type')
                            ->paginate(5);
        return view('admin.payment.list', compact('payments'));
    }

    // create payment method
    public function create(Request $request) {
        $this->checkValidation($request);

        $data = [
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType,
        ];

        Payment::create($data);

        Alert::success('Success Title', 'Payment Created Successfully!');
        return back();
    }

    // delete payment method
    public function delete($id) {
        Payment::where('id',$id)->delete();

        return back();
    }

    // edit
    public function edit($id) {
        $payment = Payment::where('id',$id)->first();

        return view('admin.payment.update', compact('payment'));
    }

    // update
    public function update($id, Request $request) {
        $this->checkValidation($request);

        Payment::where('id',$id)->update([
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType,
        ]);

        Alert::success('Success Title', 'Payment Updated Successfully!');
        return to_route('paymentList');
    }

    // check validation
    private function checkValidation($request) {
        $request->validate([
            'accountType' => 'required',
            'accountName' => 'required',
            'accountNumber' => 'required',
        ]);
    }
}
