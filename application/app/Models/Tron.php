<?php

namespace App\Models;

use IEXBase\TronAPI\Exception\TronException;
use IEXBase\TronAPI\Provider\HttpProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Tron extends Model
{
    use HasFactory;
    private $full_node;
    private $solidity_node;
    private $event_server;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->full_node = new HttpProvider('https://api.trongrid.io');
        $this->solidity_node = new HttpProvider('https://api.trongrid.io');
        $this->event_server = new HttpProvider('https://api.trongrid.io');
    }
    public function createAccount(){
        try{
            $gass_key = getenv('GAS_ACCOUNT_KEY');
            $gass_address = getenv('GAS_ACCOUNT_ADDRESS');

            $tron = new \IEXBase\TronAPI\Tron($this->full_node, $this->solidity_node, $this->event_server);
            $tron->setAddress($gass_address);
            $tron->setPrivateKey($gass_key);
            // $tron = new \IEXBase\TronAPI\Tron();
            $address = $tron->createAccount();
            $is_valid = $tron->isAddress($address->getAddress(true));
            if ($is_valid){
                return $address;
            }else{
                Log::info('Tron address invalid: '.json_encode($address));
                return false;
            }
        }catch (TronException $e){
            Log::info('tron error: '.$e->getMessage());
            return false;
        }
    }

    public function getBalance($address){
        try {
            $tron = new \IEXBase\TronAPI\Tron($this->full_node, $this->solidity_node, $this->event_server);
            $tron->setAddress($address);
            $balance = $tron->getBalance(null, true);
            return $balance;
        } catch (TronException $e) {
            Log::info('tron balance error: '.$e->getMessage());
            return false;
        }
    }

    public function sendTrx($pkey, $from_address, $amount, $to_address){
        try {
            $tron = new \IEXBase\TronAPI\Tron($this->full_node, $this->solidity_node, $this->event_server);
            $tron->setAddress($from_address);
            $tron->setPrivateKey($pkey);
            $t_amount = $amount - 2;
            $transfer = $tron->send($to_address, $t_amount);
            return $transfer;
        } catch (TronException $e) {
            Log::info('tron balance error: '.$e->getMessage());
            return false;
        }
    }

    public function getGass($address){
        $gass_key = getenv('GAS_ACCOUNT_KEY');
        $gass_address = getenv('GAS_ACCOUNT_ADDRESS');
        try {
            $tron = new \IEXBase\TronAPI\Tron($this->full_node, $this->solidity_node, $this->event_server);
            $tron->setAddress($gass_address);
            $tron->setPrivateKey($gass_key);
            $transfer = $tron->send($address, 10);
            return $transfer;
        } catch (TronException $e) {
            Log::info('tron balance error: '.$e->getMessage());
            return false;
        }
    }

    public function getTokenPriceInTrx($token_contract){
        $fp = fopen("https://apilist.tronscan.org/api/token_trc20?contract={$token_contract}&showAll=1", 'r', false);
        $data = json_decode(stream_get_contents($fp));
        return $data->trc20_tokens[0]->market_info->priceInTrx;
    }

    public function convert($token_contract, $usd_amount){
        //convert the usd to trx
        $fp = fopen('https://apilist.tronscan.org/api/token_trc20?contract=TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t&showAll=1', 'r', false);
        $data = json_decode(stream_get_contents($fp));
        $amount_of_trx_per_usd = $data->trc20_tokens[0]->market_info->priceInTrx;
        $total_trx = $usd_amount * $amount_of_trx_per_usd;

        //get token price in trx
        $token_price_in_trx = $this->getTokenPriceInTrx($token_contract);
        $token_amount = $total_trx / $token_price_in_trx;
        return $token_amount;
    }

    public function convertToTrx($usd_amount){
        $fp = fopen('https://apilist.tronscan.org/api/token_trc20?contract=TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t&showAll=1', 'r', false);
        $data = json_decode(stream_get_contents($fp));
        $amount_of_trx_per_usd = $data->trc20_tokens[0]->market_info->priceInTrx;
        $total_trx = $usd_amount * $amount_of_trx_per_usd;
        return $total_trx;
    }

    public function getTrc20Balance($contract_address, $address){
        try {
            $tron = new \IEXBase\TronAPI\Tron($this->full_node, $this->solidity_node, $this->event_server);
            $contract = $tron->contract($contract_address);
            $balance = $contract->balanceOf($address);
            return $balance;
        } catch (TronException $e) {
            Log::info('trc20 balance error: '.$e->getMessage());
            return false;
        }
    }

    public function sendTrc20($pkey, $from_address, $amount, $to_address, $contract_address){
        try {
            $tron = new \IEXBase\TronAPI\Tron($this->full_node, $this->solidity_node, $this->event_server);
            $tron->setPrivateKey($pkey);
            $contract = $tron->contract($contract_address);
            $transfer = $contract->transfer($to_address, $amount, $from_address);
            return $transfer;
        } catch (TronException $e) {
            Log::info('tron balance error: '.$e->getMessage());
            return false;
        }
    }
}
