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
            'duration'=>'required',
            'delivery'=>'required',
            'title' => 'required|max:255|min:3|alpha_num',
            'league' => 'required',
            'division' => 'required',
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
