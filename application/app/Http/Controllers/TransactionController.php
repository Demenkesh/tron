<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\Token;
use App\Models\Transaction;
use App\Models\Tron;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderByDesc('created_at')->paginate(10);
        return view('transactions', ['transactions' => $transactions]);
    }
    public function addToCart(Product $product)
    {
        if (Session::has('products')) {
            Session::push('products', $product);
        } else {
            Session::put('products', [$product]);
        }
        return redirect('/cart');
    }
    public function inFinale($product, $finale)
    {
        foreach ($finale as $item) {
            if ($item->id == $product->id) {
                return $item;
            }
        }
        return 0;
    }
    public function cart()
    {
        $finale = [];
        $products = [];
        $total = 0;
        if (Session::has('products')) {
            $products = Session::get('products');
            if (count($products) > 0) {
                foreach ($products as $product) {
                    $total += $product->price;
                    //add product to final array
                    if (count($finale) > 0) {
                        $in_finale = $this->inFinale($product, $finale);
                        if ($in_finale) {
                            $in_finale->count += 1;
                        } else {
                            $product->index = array_search($product, $products);
                            $product->count = 1;
                            $finale[] = $product;
                        }
                    } else {
                        $product->index = array_search($product, $products);
                        $product->count = 1;
                        $finale[] = $product;
                    }
                }
            }
        }
        return view('cart', ['products' => $finale, 'total' => $total]);
    }
    public function removeFromCart(Request $request)
    {
        $key = $request->key;
        $products = Session::pull('products');
        unset($products[$key]);
        Session::put('products', $products);
        return back();
    }
    public function checkout()
    {
        $finale = [];
        $products = [];
        $total = 0;
        if (Session::has('products')) {
            $products = Session::get('products');
            if (count($products) > 0) {
                foreach ($products as $product) {
                    $total += $product->price;
                    //add product to final array
                    if (count($finale) > 0) {
                        $in_finale = $this->inFinale($product, $finale);
                        if ($in_finale) {
                            $in_finale->count += 1;
                        } else {
                            $product->index = array_search($product, $products);
                            $product->count = 1;
                            $finale[] = $product;
                        }
                    } else {
                        $product->index = array_search($product, $products);
                        $product->count = 1;
                        $finale[] = $product;
                    }
                }
            }
        }
        if ($total > 0) {
            $tokens = Token::all();
            return view('checkout', [
                'total' => $total,
                'products' => $finale,
                'tokens' => $tokens,
            ]);
        } else {
            return redirect('/cart');
        }
    }

    public function pay(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', 'numeric'],
        ]);
        $token = Token::where('id', '=', $request->payment_method)->first();
        if ($token) {
            if (Session::has('products')) {
                $products = Session::get('products');
                if (count($products) > 0) {
                    $total = 0;
                    foreach ($products as $product) {
                        $total += $product->price;
                    }
                    //initiate payment
                    $tron = new Tron();
                    $tron_address = "TXqSBYc9E42WE2MSqv5AoBe9xDdjBqthND";
                    // dd( $tron_address);
                    if ($tron_address) {
                        // $address = $tron_address->getAddress(true);
                        // $pkey = $tron_address->getPrivateKey();
                        //get token amount
                        $token_amount =
                            strtolower($token->ticker) == 'trx'
                            ? round($tron->convertToTrx($total), 5)
                            : round(
                                $tron->convert(
                                    $token->contract_address,
                                    $total
                                ),
                                5
                            );

                        $transaction = Transaction::create([
                            'token_id' => $token->id,
                            'crypto_amount' => $token_amount,
                            'amount' => $total,
                            'address' => $tron_address,
                            // 'pkey' => $pkey,
                            'success' => false,
                        ]);
                        $message = "Send <span class='text-success'>{$token_amount} {$token->ticker} </span> <span class='text-info'>($$total)</span> to the address bellow and then click <span class='text-info'>I have Paid</span> to continue.Make sure that you are transacting on the Tron Block chain network and Note that if you send less amount, your transaction will be ignored";
                        return view('pay', [
                            'message' => $message,
                            'transaction' => $transaction,
                        ]);
                    } else {
                        session()->flash(
                            'failure_message',
                            'Something went wrong'
                        );
                        return back();
                    }
                } else {
                    session()->flash('failure_message', 'the cart is empty');
                    return redirect('/cart');
                }
            } else {
                session()->flash('failure_message', 'the cart is empty');
                return redirect('/cart');
            }
        } else {
            session()->flash(
                'failure_message',
                Lang::get('Invalid payment method')
            );
            return redirect('/checkout');
        }
    }

    public function checkTransaction(Request $request)
    {
        $tx = $request->txid;
        $transaction = Transaction::where('id', '=', $tx)->first();
        if ($transaction) {
            if ($transaction->success) {
                return response()->json([
                    'error' => false,
                    'message' => 'Transaction already processed',
                ]);
            }
            //check if payment was received
            $tron = new Tron();

            $balance =
                strtolower($transaction->token->ticker) == 'trx'
                ? $tron->getBalance($transaction->address)
                : $tron->getTrc20Balance(
                    $transaction->token->contract_address,
                    $transaction->address
                );
            if ($balance >= $transaction->crypto_amount) {
                $transaction->success = 1;
                $transaction->save();
                //clear cart
                Session::forget('products');
                //send the amount to the destination address
                $to_address = Setting::first()->destination_address;
                if (strtolower($transaction->token->ticker) == 'trx') {
                    $transfer = $tron->sendTrx(
                        $transaction->pkey,
                        $transaction->address,
                        $balance,
                        $to_address
                    );
                } else {
                    //transfer trc20
                    //get gass
                    $tron->getGass($transaction->address);
                    //wait for 50 seconds for the gas to be confirmed on the block chain
                    sleep(50);
                    $transfer = $tron->sendTrc20(
                        $transaction->pkey,
                        $transaction->address,
                        $balance,
                        $to_address,
                        $transaction->token->contract_address
                    );
                }
                return response()->json([
                    'error' => false,
                    'message' => 'Transaction successful',
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Insufficient balance',
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => 'invalid transaction',
            ]);
        }
    }

    public function success()
    {
        return view('success');
    }
}
