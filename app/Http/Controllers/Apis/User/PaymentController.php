<?php

namespace App\Http\Controllers\Apis\User;

use App\Traits\GlobalTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class PaymentController extends Controller
{

    use GlobalTrait;
    public function get_checkout_id(Request $request)
    {
        (new BaseConroller())->setLang($request);

        $validator = Validator::make($request->all(), [
            "price" => array('required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1'),
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }



        $url = env('PAY_CHECKOUTS_URL', 'https://oppwa.com/v1/checkouts');
        $data =
            "entityId=" . env('PAY_ENTITYID', '8ac7a4ca6d0680f7016d14c5bbb716d8') .
            "&amount=" . $request->price .
            "&currency=SAR" .
            "&paymentType=DB" .
            "&notificationUrl=https://mcallapp.com";

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer ' . env('PAY_AUTHORIZATION', 'OGFjN2E0Y2E2ZDA2ODBmNzAxNmQxNGM1NzMwYzE2ZDR8QVpZRXI1ZzZjZQ')));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, env('PAY_SSL', false));// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {

            }
            curl_close($ch);

        } catch (\Exception $ex) {

            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

        $id = json_decode($responseData)->id;

        return $this->returnData('checkoutId', $id, trans('messages.Checkout id successefully retrieved'), 'S001');

    }


    public function checkPaymentStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "checkoutId" => 'required',
            "resource" => 'required',
        ]);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $url = env('PAY_BASE_URL', 'https://test.oppwa.com/');
        $url .= $request->resource;
        $url .= "?entityId=" . env('PAY_ENTITYID', '8ac7a4ca6d0680f7016d14c5bbb716d8');


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . env('PAY_AUTHORIZATION', 'OGFjN2E0Y2E2ZDA2ODBmNzAxNmQxNGM1NzMwYzE2ZDR8QVpZRXI1ZzZjZQ')));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, env('PAY_SSL', false));// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {

            return $this->returnData('status', 'حدث خطا ما يرجي المحاولة مجددا', trans('messages.Payment status'), 'D001');
        }
        curl_close($ch);
        $r = json_decode($responseData);
        $obj = new \stdClass();
        $obj->id = isset($r->id) ? $r->id : '0';
        $obj->res = $r->result;

        return $this->returnData('status', $obj, trans('messages.Payment status'), 'S001');
    }

}
