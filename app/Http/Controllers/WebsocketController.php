<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class WebsocketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param null $order
     * @param Request $request
     * @return Response
     */
    public function token(Request $request)
    {
        $user = Auth::user();
        if ($user){
            $signer = new Sha256();

            $token = (new Builder())
                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                ->setExpiration(time() + 60) // Configures the expiration time of the token (nbf claim)
                ->set('user_id', $user->id)
                ->set('user_name', $user->name)
                ->set('from', URL::previous())
                ->sign($signer, env('JWT_SECRET')) // creates a signature using "testing" as key
                ->getToken(); // Retrieves the generated token

            return $token;
        }
        else{
            abort(401);
        }
    }

    public function tokenForTrade($order, Request $request)
    {
        $user = Auth::user();
        if ($user){
            $users=$order->thread
                ->participants()
                ->whereNotIn('user_id', [$request->user()->id])
                ->lists('user_id')->all();
            $signer = new Sha256();

            $token = (new Builder())
                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                ->setExpiration(time() + 60) // Configures the expiration time of the token (nbf claim)
                ->set('user_id', $user->id)
                ->set('user_name', $user->name)
                ->set('from', URL::previous())
                ->set('partners', $users)
                ->set('orderId', $order->id)
                ->sign($signer, env('JWT_SECRET')) // creates a signature using "testing" as key
                ->getToken(); // Retrieves the generated token

            return $token;
        }
        else{
            abort(401);
        }
    }

}