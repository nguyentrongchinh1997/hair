<?php

namespace App\Http\Service\admin;

use App\Model\Card;
use App\Model\CardDetail;
use App\Model\Service;
use App\Model\Customer;

class CardService
{
	protected $cardModel, $cardDetailModel, $serviceModel, $customerModel;

	public function __construct(Card $card, CardDetail $cardDetail, Service $service, Customer $customer)
	{
		$this->cardModel = $card;
        $this->cardDetailModel = $cardDetail;
        $this->serviceModel = $service;
        $this->customerModel = $customer;
	}

    public function getCartList()
    {
        $serviceList = $this->serviceModel->where('status', '>', 0)->get();
        $cardList = $this->cardModel->where('status', '>', 0)->orderBy('id', 'desc')->paginate(20);
        $data = [
            'serviceList' => $serviceList,
            'cardList' => $cardList,
        ];

        return $data;
    }

    public function postCard($request)
    {
        $id = $this->cardModel->insertGetId(
            [
                'card_name' => $request->card_name,
                'price' => str_replace(',', '', $request->price),
                'created_at' => date('Y-m-d H:i:s'),
            ]
        );
        $i = 0;
        foreach ($request->service as $service) {
            $this->cardDetailModel->create(
                [
                    'service_id' => $service,
                    'card_id' => $id,
                    'percent' => $request->percent[$i],
                ]
            );
            $i++;
        }
    }

    public function cardDelete($id)
    {
        $card = $this->cardModel->findOrFail($id);
        $card->status = 0;

        return $card->save();
    }

    public function postOtherCard($request)
    {
        $price = str_replace(',', '', $request->price);
        $cardNew = $this->cardModel->create(
            [
                'card_name' => $request->card_name,
                'price' => $price,
                'type' => 1,
            ]
        );

        return $this->cardDetailModel->create(
            [
                'service_id' => $request->service_id,
                'card_id' => $cardNew->id,
                'number' => $request->number,
            ]
        );
    }
}
