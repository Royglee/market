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
            'countq.required' => 'Please specify the amount of account(s) to sell.',
            'countq.boolean' => 'Please specify the amount of account(s) to sell.',
            'count.min' => 'Please set the number above 1 for the number of accounts to sell.',
            'count.integer' => 'Please set an integer as the number of accounts to sell.',
            'count.required_if' => 'Please set the number of accounts in stock, if you want to sell more.',
            'has_email.required' => 'Please specify, whether you have the original e-mail to the account(s).',
            'has_email.boolean' => 'Please specify, whether you have the original e-mail to the account(s).',
            'first_owner.required' => 'Please specify whether you are the first owner of the account(s).',
            'first_owner.boolean' => 'Please specify whether you are the first owner of the account(s).',
            'duration.required' => 'Please choose a duration for your account(s)to be available on our website.',
            'duration.in' => 'Please choose a duration for your account(s)to be available on our website from the list below.',
            'delivery.required' => 'Please choose a delivery time for your account(s).',
            'title.required' => 'Please set the title for your account(s).',
            'title.max' => 'The title for your account(s) has to be between 3 and 255 characters.',
            'title.max' => 'The title for your account(s) has to be between 3 and 255 characters.',
            'server.required' => 'Please choose a server for your account(s).',
            'server.in' => 'Please choose a valid server for your account(s).',
            'league.required' => 'Please choose a league for your account(s).',
            'league.in' => 'Please choose a valid league for your account(s).',
            'division.required' => 'Please choose a division for your account(s).',
            'division.integer' => 'Please set an integer between 0 and 5 as the division for your account(s).',
            'division.min' => 'Please set an integer between 0 and 5 as the division for your account(s).',
            'division.max' => 'Please set an integer between 0 and 5 as the division for your account(s).',
            'champions.required' => 'Please set the number of champions for your account(s).',
            'champions.digits_between' => 'The number of champions has to be a 1, 2 or 3 digit number.',
            'champions.integer' => 'Please set an integer as the number of champions for your account(s).',
            'skins.required' => 'Please set the number of skins for your account(s).',
            'skins.digits_between' => 'The number of skins has to be a 1, 2 or 3 digit number.',
            'skins.integer' => 'Please set an integer as the number of skins for your account(s).',
            'price.required' => 'Please set a price for your account(s).',
            'price.digits_between' => 'The price of your account(s) has to be a number between 1 and 6 digits.',
            'body.required' => 'Please add a description for your account(s).',
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
