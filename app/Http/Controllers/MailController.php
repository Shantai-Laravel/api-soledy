<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PoliciesAcceptMail;


class MailController extends Controller
{
    public function acceptPolicies(Request $request)
    {
        try {
            $to = 'docrom2021@gmail.com';
            $data = [
                'name' => $request->get('name'),
                'cookieID' => $request->get('cookieID'),
                'browser' => $request->get('browser'),
                'device' => $request->get('device')
            ];

            Mail::to($to)->send(new PoliciesAcceptMail($data));
            // return new PoliciesAcceptMail($data);
        } catch (\Exception $e) {
            dd('error');
        }
    }
}
