<?php

namespace Madtechservices\MadminCore\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class ChangeAccountController extends Controller
{
    public function changeAccount($id, Request $request)
    {
        $request->merge(['account_id' => $id]);
        $validated = $request->validate([
            'account_id' => [
                'required',
                'integer',
                Rule::exists('accounts', 'id'),
                Rule::in(
                    backpack_user()->selectable_accounts->pluck('id')->toArray()
                )
            ],
        ]);

        session()->put('account_id', $validated['account_id']);

        return back();
    }
    
}
