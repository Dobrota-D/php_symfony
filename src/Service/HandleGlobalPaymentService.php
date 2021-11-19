<?php

namespace App\Service;

class HandleGlobalPaymentService
{
    private array $globalPayments;
    private array $inDebt;

    public function __construct()
    {
        //Get All Payment --TODO call DB by tricount_id--
        $this->globalPayments = [
            ["id"=>1, "pay_master_id"=>1, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>130],
            ["id"=>2, "pay_master_id"=>4, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>34],
            ["id"=>3, "pay_master_id"=>2, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>400],
            ["id"=>4, "pay_master_id"=>1, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>60],
        ];
        $this->inDebt = [
            ["id"=>1, "id_participant_id"=>1, "tricount_id"=>1, "depense_id"=>1, "amount_personnal"=>65],
            ["id"=>2, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>1, "amount_personnal"=>65],
            ["id"=>3, "id_participant_id"=>2, "tricount_id"=>1, "depense_id"=>2, "amount_personnal"=>11],
            ["id"=>4, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>2, "amount_personnal"=>11],
            ["id"=>5, "id_participant_id"=>4, "tricount_id"=>1, "depense_id"=>2, "amount_personnal"=>11],
            ["id"=>6, "id_participant_id"=>1, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>7, "id_participant_id"=>2, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>8, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>9, "id_participant_id"=>4, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>11, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>4, "amount_personnal"=>60],
        ];
    }

    public function paymentGraphicData(): array
    {
        $return = [];
        foreach ($this->globalPayments as $payment){
            if (isset($return[$payment["pay_master_id"]])){
                $return[$payment["pay_master_id"]]["amount"] += $payment["amount_total"];
            }else{
                $return[$payment["pay_master_id"]] = ["amount"=>$payment["amount_total"]];
            }

            foreach ($this->inDebt as $person){
                if ($person["depense_id"] == $payment["id"] && $person["id_participant_id"] != $payment["pay_master_id"]){
                    if (!isset($return[$person["id_participant_id"]])) $return[$person["id_participant_id"]] = ["amount"=>0];
                    $return[$person["id_participant_id"]]["amount"] -= $person["amount_personnal"];
                }
            }
        }
        foreach ($return as $key=>$value){
            $return[$key]["isDebt"] = abs($value["amount"]) != $value["amount"];
            $return[$key]["prop"] = abs($value["amount"]) *0.5;
        }
        return $return;
    }

    public function paymentToRefund(): array
    {
        $return = [];
        foreach ($this->inDebt as $debt){
            foreach ($this->globalPayments as $payMaster){
                $key = $debt["id_participant_id"]."->".$payMaster["pay_master_id"];
                $reverseKey = $payMaster["pay_master_id"].'->'.$debt["id_participant_id"];
                if ($debt["depense_id"] == $payMaster["id"] && $debt["id_participant_id"] != $payMaster["pay_master_id"]){
                    if (isset($return[$key])){
                        $return[$key] += $debt["amount_personnal"];
                    }elseif (isset($return[$reverseKey])){
                        $return[$reverseKey] -= $debt["amount_personnal"];
                        if ($return[$reverseKey]<0){
                            $val = $return[$reverseKey]*-1;
                            unset($return[$reverseKey]);
                            $return[$key] = $val;
                        }
                    }else {
                        $return[$key] = $debt["amount_personnal"];
                    }
                }
            }
        }
        return $return;
    }
}