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
        $customerList = $this->customerModel->all();
        $serviceList = $this->serviceModel->all();
        $cardList = $this->cardModel->paginate(20);
        $data = [
            'customerList' => $customerList,
            'serviceList' => $serviceList,
            'cardList' => $cardList,
        ];

        return $data;
    }

    public function postCard($request)
    {
        $id = $this->cardModel->insertGetId(
            [
                'customer_id' => $request->customer_id,
                'card_name' => $request->card_name,
                'price' => str_replace(',', '', $request->price),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        );
        $i = 0;
        foreach ($request->service as $service) {
            $this->cardDetailModel->create(
                [
                    'service_id' => $service,
                    'customer_id' => $request->customer_id,
                    'card_id' => $id,
                    'percent' => $request->percent[$i],
                ]
            );
            $i++;
        }
    }

    public function getExtensionView($id)
    {
        $card = $this->cardModel->findOrFail($id);
        $data = ['card' => $card];

        return $data;
    }

    public function postExtension($request, $id)
    {
        $card = $this->cardModel->findOrFail($id);
        $card->end_time = $request->end_time;

        return $card->save();
    }
}
