<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Events\TradeStatusChangedEvent;
use App\Feedback;
use App\Jobs\ExecutePayment;
use App\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Http\Request;

use App\Http\Requests;
use Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class TradeController extends Controller
{

    public function show($order)
    {
//        $userId = Auth::user()->id;
//        $users = User::whereNotIn('id', $order->thread->participantsUserIds($userId))->get();
        //dd($order->partnersFeedback());
        return view('orders.buyer', compact('order'));
    }

    public function stepProcessor($order, Request $request)
    {
        $commandArray = $request->all();
        if($order->isSeller){
            if($commandArray['step']==2){
                if($commandArray['action']=='check' && $order->SellerDelivered == 0 && $order->BuyerCancelRequest == 0){
                    $order->SellerDelivered = 1;
                    $order->save();
                    Event::fire(new TradeStatusChangedEvent([$order->buyer->id]));
                    return 200;
                }
                elseif($commandArray['action']=='cancel' && $order->SellerDelivered == 0 && $order->BuyerCancelRequest == 0){
                    $order->SellerDelivered = -1;
                    $order->save();
                    Event::fire(new TradeStatusChangedEvent([$order->buyer->id]));
                    return 200;
                }
            }
            if($commandArray['step']==5 && $commandArray['action']=='feedback' && $order->SellerSentFeedback == 0){
                $feedback = (new Feedback())->create([
                    'feedback'      => $commandArray['feedback'],
                    'review'        => $commandArray['review'],
                    'sender_id'     => $order->seller->id,
                    'receiver_id'   => $order->buyer->id,
                    'order_id'      => $order->id
                ]);
                $order->SellerSentFeedback = 1;
                $order->save();

                return 200;
            }
        }
        if($order->isBuyer){
            if($commandArray['step']==2){
                if($commandArray['action']=='cancel' && $order->SellerDelivered == 0 && $order->BuyerCancelRequest == 0){
                    $order->BuyerCancelRequest = 1;
                    $order->save();
                    Event::fire(new TradeStatusChangedEvent([$order->seller->id]));
                    return 200;
                }
            }
            if($commandArray['step']==3){
                if($commandArray['action']=='check' && $order->SellerDelivered == 1 && $order->BuyerChecked == 0){
                    $order->BuyerChecked = 1;
                    $order->save();

                    $this->dispatch(new ExecutePayment($order));
                    Event::fire(new TradeStatusChangedEvent([$order->seller->id]));
                    return 200;
                }
                elseif($commandArray['action']=='error' && $order->SellerDelivered == 1 && $order->BuyerChecked == 0){
                    $order->BuyerChecked = -1;
                    $order->save();
                    Event::fire(new TradeStatusChangedEvent([$order->seller->id]));
                    return 200;
                }
                elseif($commandArray['action']=='error' && $order->SellerDelivered == 1 && $order->BuyerChecked == 0){
                    $order->BuyerChecked = -1;
                    $order->save();
                    Event::fire(new TradeStatusChangedEvent([$order->seller->id]));
                    return 200;
                }
            }
            if($commandArray['step']==5 && $commandArray['action']=='feedback' && $order->BuyerSentFeedback == 0){
                $feedback = (new Feedback())->create([
                    'feedback'      => $commandArray['feedback'],
                    'review'        => $commandArray['review'],
                    'sender_id'     => $order->buyer->id,
                    'receiver_id'   => $order->seller->id,
                    'order_id'      => $order->id
                ]);
                $order->BuyerSentFeedback = 1;
                $order->save();

                    return 200;
            }

        }

        abort(400);
    }

    public function stepList($order)
    {

        return view('orders.partials.steps', compact('order'));
    }

    public function storeChatMessage($order, Request $request, Message $message)
    {
        $thread = $order->thread;


        $thread->activateAllParticipants();

        // Message
        $message->create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'body'      => $request->get('message'),
            ]
        );
        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();

        //Event push
        $users=$thread
            ->participants()
            ->whereNotIn('user_id', [$request->user()->id])
            ->lists('user_id')->all(); //összes résztvevõ idje listázva, kivéve a küldõ
        Event::fire(new NewMessageEvent($users, Auth::user()->name, $request->get('message')));

        return [Auth::user()->name];

    }

}
