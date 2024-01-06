<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualCardLogs extends JsonResource
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
            'transaction_type' => "Virtual Card".'('. @$this->remark.')',
            'request_amount' => getAmount($this->request_amount,2).' '.get_default_currency_code() ,
            'payable' => getAmount($this->payable,2).' '.get_default_currency_code(),
            'total_charge' => getAmount($this->charge->total_charge,2).' '.get_default_currency_code(),
            'card_amount' => getAmount(@$this->details->card_info->amount,2).' '.get_default_currency_code(),
            'card_number' => $this->details->card_info->card_pan??$this->details->card_info->maskedPan,
            'current_balance' => getAmount($this->available_balance,2).' '.get_default_currency_code(),
            'status' => $this->stringStatus->value ,
            'date_time' => $this->created_at ,
            'status_info' =>(object)$statusInfo ,

        ];

    }
}
