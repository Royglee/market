<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateAccountRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'countq' => 'required|boolean',
            'count' => 'integer|min:2|integer|required_if:countq,1',
            'first_owner' => 'required|boolean',
            'has_email'=>'required|boolean',
            'duration'=>'required|in:7,14,30',
            'delivery'=>'required',
            'title' => 'required|max:255|min:3',
            'server' => 'required|in:NA,EUNE,EUW,OCE,BR,LA,RU,TR,KR',
            'league' => 'required|in:Unranked,Bronze,Silver,Gold,Platinum,Diamond,Master,Challenger',
            'division' => 'required|integer|min:0|max:5',
            'champions' => 'required|digits_between:1,3|integer',
            'skins' => 'required|digits_between:1,3|integer',
            'price' => 'required|digits_between:1,6',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'has_email.required' => 'Please specify, whether you have the original e-mail to the account(s).',
            'countq.required' => 'Please specify the amount of account(s) to sell.',
            'count.required_if' => 'Please set the number of accounts in stock, if you want to sell more.',
            'first_owner.required' => 'Please specify whether you are the first owner of the account(s).',
            'duration.required' => 'Please choose a duration for your account(s)to be available on our website.',
            'delivery.required' => 'Please choose a delivery time for your account(s).',
            'title.required' => 'Please set the title for your account(s)',
            'server.required' => 'Please choose a server for your account(s)',
            'league.required' => 'Please choose a league for your account(s)',
            'division.required' => 'Please choose a division for your account(s)',
            'champions.required' => 'Please set the number of champions for your account(s)',
            'skins.required' => 'Please set the number of skins for your account(s)',
            'price.required' => 'Please set a price for your account(s)',
            'body.required' => 'Please add a description for your account(s)',
        ];
    }

    public function attributes()
    {
        return [
            'countq' => 'count question',
            'has_email' => 'original e-mail'
        ];
    }
}
