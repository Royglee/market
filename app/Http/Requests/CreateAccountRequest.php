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
            //'has_email.required' => 'Origial E-mail',
            'count.required_if' => 'You have to set the number of accounts in stock, if you want to sell more.',
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
