<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SmartBro\Voucher\models\Voucher;
use SmartBro\Voucher\services\VoucherService;

class VouchersController extends Controller
{
    public function index(Request $request){
        $this->dataForView['menuName'] = 'voucher';
        $this->dataForView['vouchers'] = Voucher::orderBy('created_at','desc')->paginate();
        return view('backend.vouchers.index',$this->dataForView);
    }

    public function generator(Request $request){
        $bulk = $request->get('bulk');
        /**
         * @var VoucherService $voucherService
         */
        $voucherService = app('voucher');
        $voucherService->generate(
            $request->get('amount'),
            $bulk['type'],
            $bulk['discount_value'],
            $bulk['is_percent'],
            $bulk['commence'],
            $bulk['expired_at']
        );
        return redirect()->route('admin.voucher.mgr');
    }
}
