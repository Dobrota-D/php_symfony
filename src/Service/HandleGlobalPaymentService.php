<?php

namespace App\Service;

class HandleGlobalPaymentService
{
    public function __construct()
    {

    }

    public function paymentGraphicData(): array
    {
        //Get All Payment --TODO call DB by tricount_id--
        $globPayements = [
            ["id"=>1, "pay_master_id"=>1, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>130],
            ["id"=>2, "pay_master_id"=>4, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>34],
            ["id"=>3, "pay_master_id"=>2, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>400],
            ["id"=>4, "pay_master_id"=>1, "tricount_id"=>1, "title"=>"Voiture", "created_at"=>null, "amount_total"=>60],
        ];
        $inDebt = [
            ["id"=>1, "id_participant_id"=>1, "tricount_id"=>1, "depense_id"=>1, "amount_personnal"=>65],
            ["id"=>2, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>1, "amount_personnal"=>65],
            ["id"=>3, "id_participant_id"=>2, "tricount_id"=>1, "depense_id"=>2, "amount_personnal"=>11],
            ["id"=>4, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>2, "amount_personnal"=>11],
            ["id"=>5, "id_participant_id"=>4, "tricount_id"=>1, "depense_id"=>2, "amount_personnal"=>11],
            ["id"=>6, "id_participant_id"=>1, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>7, "id_participant_id"=>2, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>8, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>9, "id_participant_id"=>4, "tricount_id"=>1, "depense_id"=>3, "amount_personnal"=>100],
            ["id"=>10, "id_participant_id"=>1, "tricount_id"=>1, "depense_id"=>4, "amount_personnal"=>30],
            ["id"=>11, "id_participant_id"=>3, "tricount_id"=>1, "depense_id"=>4, "amount_personnal"=>30],
        ];
        $return = [];
        foreach ($globPayements as $payement){
            if (isset($return[$payement["pay_master_id"]])){
                $return[$payement["pay_master_id"]] += $payement["amount_total"];
            }else{
                $return[$payement["pay_master_id"]] = $payement["amount_total"];
            }

            foreach ($inDebt as $person){
                if ($person["depense_id"] == $payement["id"] && $person["id_participant_id"] != $payement["pay_master_id"]){
                    if (!isset($return[$person["id_participant_id"]])) $return[$person["id_participant_id"]] = 0;
                    $return[$person["id_participant_id"]] -= $person["amount_personnal"];
                }
            }
        }
        return $return;
    }

}