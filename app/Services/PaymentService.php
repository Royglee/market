<?php
/**
 * Created by PhpStorm.
 * User: Marcell
 * Date: 2015.06.02.
 * Time: 2:19
 */
namespace App\Services;
use angelleye\PayPal\Adaptive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PaymentService {
    protected $PayPal;

    //Adaptive Pay adatok
    protected $PayRequestFields;
    protected $ClientDetailsFields;
    protected $Receivers;
    protected $SenderIdentifierFields;
    protected $AccountIdentifierFields;

    //Adaptive Pay visszatérési érték (fontosabbak)
    public $PayKey;
    public $RedirectURL;
    public $PayPalResult_Pay; // Errors,Ack,Build,CorrelationID,Timestamp,PayKey,PaymentExecStatus,RedirectURL,XMLRequest
    public $PayPalResult_SetPaymentOptions;

    protected $buyer;
    protected $account;

    function __construct(Request $request)
    {
        $this->PayPal = new Adaptive(config('paypal'));
        $this->buyer = $request->user();
    }
    protected function initFields()
    {
        $this->PayRequestFields = array(
            'ActionType' => 'PAY_PRIMARY', 								// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
            'CancelURL' => url('/success'), 									// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
            'CurrencyCode' => 'USD', 								// Required.  3 character currency code.
            'FeesPayer' => 'EACHRECEIVER', 									// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
            'IPNNotificationURL' => url('api/ipn').'/'.$this->buyer->id.'/'.$this->account->id, 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
            'Memo' => '', 										// A note associated with the payment (text, not HTML).  1000 char max
            'Pin' => '', 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
            'PreapprovalKey' => '', 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.
            'ReturnURL' => url('/'), 									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
            'ReverseAllParallelPaymentsOnError' => false, 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
            'SenderEmail' => '', 								// Sender's email address.  127 char max.
            'TrackingID' => ''	,								// Unique ID that you specify to track the payment.  127 char max.

        );
        $this->ClientDetailsFields = array(
            'CustomerID' =>  $this->buyer->id, 								// Your ID for the sender  127 char max.
            'CustomerType' => '', 								// Your ID of the type of customer.  127 char max.
            'GeoLocation' => '', 								// Sender's geographic location
            'Model' => '', 										// A sub-identification of the application.  127 char max.
            'PartnerName' => ''									// Your organization's name or ID
        );
        $this->SenderIdentifierFields = array(
            'UseCredentials' => false						// If TRUE, use credentials to identify the sender.  Default is false.
        );
        $this->AccountIdentifierFields = array(
            'Email' => $this->buyer->email, 								// Sender's email address.  127 char max.
            'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')								// Sender's phone number.  Numbers only.
        );
    }
    protected function setReceiver(){
        $this->Receivers = [];
        $Receiver = array(
            'Amount' => $this->account->price, 											// Required.  Amount to be paid to the receiver.
            'Email' => 'marcellrosta-facilitator@gmail.com', 												// Receiver's email address. 127 char max.
            'InvoiceID' => '', 											// The invoice number for the payment.  127 char max.
            'PaymentType' => '', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
            'PaymentSubType' => '', 									// The transaction subtype for the payment.
            'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
            'Primary' => 'true',												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
            'AccountID' => '',
        );
        array_push($this->Receivers,$Receiver);

        $Receiver = array(
            'Amount' => $this->account->price*0.9, 											// Required.  Amount to be paid to the receiver.
            'Email' => 'seller@accmarket.com', 												// Receiver's email address. 127 char max.
            'InvoiceID' => '', 											// The invoice number for the payment.  127 char max.
            'PaymentType' => '', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
            'PaymentSubType' => '', 									// The transaction subtype for the payment.
            'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
            'Primary' => 'false',												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
            'AccountID' => '',
        );
        array_push($this->Receivers,$Receiver);

        return $this;
    }
    protected function buildPayRequestData()
    {
       return array(
            'PayRequestFields' => $this->PayRequestFields,
            'ClientDetailsFields' => $this->ClientDetailsFields,
            'Receivers' => $this->Receivers,
            'SenderIdentifierFields' => $this->SenderIdentifierFields,
            'AccountIdentifierFields' => $this->AccountIdentifierFields,
        );
    }

    public function order($account)
    {
        $this->account = $account;
        $this->initFields();
        $this->setReceiver();
        return $this;
    }

    public function sendPayment(){

        $PayPalRequestData      = $this->buildPayRequestData();
        $this->PayPalResult_Pay = $this->PayPal->Pay($PayPalRequestData);

        $this->PayKey      = $this->PayPalResult_Pay['PayKey'];
        $this->RedirectURL = $this->PayPalResult_Pay['RedirectURL'];

        return $this;
    }

    public function  setPaymentOptions(){
        // Prepare request arrays
        $SPOFields = array(
            'PayKey' =>$this->PayPalResult_Pay['PayKey'],						// Required.  The pay key that identifies the payment for which you want to set payment options.
        );

        $DisplayOptions = array(
            'EmailHeaderImageURL' => '', 			// The URL of the image that displays in the header of customer emails.  1,024 char max.  Image dimensions:  43 x 240
            'EmailMarketingImageURL' => '', 		// The URL of the image that displays in the customer emails.  1,024 char max.  Image dimensions:  80 x 530
            'HeaderImageURL' => '', 				// The URL of the image that displays in the header of a payment page.  1,024 char max.  Image dimensions:  750 x 90
            'BusinessName' => ''					// The business name to display.  128 char max.
        );

        // Begin loop to populate receiver options.
        $ReceiverOptions = array();
        $ReceiverOption = array(
            'Description' => '', 					// A description you want to associate with the payment.  1000 char max.
            'CustomID' => '1' 						// An external reference number you want to associate with the payment.  1000 char max.
        );
        $InvoiceData = array(
            'TotalTax' => '', 							// Total tax associated with the payment.
            'TotalShipping' => '' 						// Total shipping associated with the payment.
        );

        $InvoiceItems = array();
        $InvoiceItem = array(
            'Name' => $this->account->title, 								// Name of item.
            'Identifier' => $this->account->id, 						// External reference to item or item ID.
            'Price' => $this->account->price, 								// Total of line item.
            'ItemPrice' => $this->account->price,							// Price of an individual item.
            'ItemCount' => '1'							// Item QTY
        );
        array_push($InvoiceItems,$InvoiceItem);

        $ReceiverIdentifier = array(
            'Email' => 'marcellrosta-facilitator@gmail.com', 						// Receiver's email address.  127 char max.
        );
        $ReceiverOption['InvoiceData'] = $InvoiceData;
        $ReceiverOption['InvoiceItems'] = $InvoiceItems;
        $ReceiverOption['ReceiverIdentifier'] = $ReceiverIdentifier;
        array_push($ReceiverOptions,$ReceiverOption);
        // End receiver options loop

        $PayPalRequestData = array(
            'SPOFields' => $SPOFields,
            'DisplayOptions' => $DisplayOptions,
            'ReceiverOptions' => $ReceiverOptions,
        );

        // Pass data into class for processing with PayPal and load the response array into PayPalResult_SetPaymentOptions
        $this->PayPalResult_SetPaymentOptions=$this->PayPal->SetPaymentOptions($PayPalRequestData);
        //dd('Adaptive Pay API Call Result',$this->PayPalResult_Pay,'SetPaymentOptions API Call Result',  $this->PayPalResult_SetPaymentOptions);
        return $this->PayPalResult_Pay['PayKey'];
    }

    public function ipnMessage($decode = false)
    {
        $raw_post_data= file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                if(!$decode){
                    $myPost[$keyval[0]] = urldecode($keyval[1]);
                } else
                {
                    $myPost[urldecode($keyval[0])] = urldecode($keyval[1]);
                }
        }
        return $myPost;
    }
    public function isIPNVerified()
    {
        $IPN_url = config('paypal')['Sandbox']? 'https://www.sandbox.paypal.com/cgi-bin/webscr':
                                                'https://www.paypal.com/cgi-bin/webscr';

        $myPost = $this->ipnMessage();
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
        $ch = curl_init($IPN_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        if( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);
        if (strcmp ($res, "VERIFIED") == 0) {
            return true;
        } else if (strcmp ($res, "INVALID") == 0) {
            return false;
        }
    }
  }