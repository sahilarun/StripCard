<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AddSubBalanceLogs extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $statusInfo = [
            "success" =>      1,
            "pending" =>      2,
            "rejected" =>     3,
        ];
        return[
            'id' => $this->id,
            'trx' => $this->trx_id,
            'transaction_type' => $this->type,
            'transaction_heading' => "Balance Update From Admin (".$this->creator_wallet->currency->code.")",
            'request_amount' => getAmount($this->request_amount,2).' '.get_default_currency_code() ,
            'current_balance' => getAmount($this->available_balance,2).' '.get_default_currency_code(),
            'receive_amount' => getAmount($this->payable,2).' '.get_default_currency_code(),
            'exchange_rate' => '1 ' .get_default_currency_code().' = '.getAmount($this->user_wallet->currency->rate,2).' '.$this->user_wallet->currency->code,
            'total_charge' => getAmount($this->charge->total_charge,2).' '.get_default_currency_code(),
            'remark' => $this->remark,
            'status' => $this->stringStatus->value ,
            'date_time' => $this->created_at ,
            'status_info' =>(object)$statusInfo ,

        ];
    }
}
