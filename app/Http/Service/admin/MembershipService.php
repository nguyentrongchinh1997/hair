<?php

namespace App\Http\Service\admin;

use App\Model\Membership;
use App\Model\Card;
use App\Model\Customer;

class MembershipService
{
	protected $membershipModel, $cardModel, $customerModel;

	public function __construct(Membership $membership, Card $card, Customer $customer)
	{
		$this->membershipModel = $membership;
		$this->cardModel = $card;
		$this->customerModel = $customer;
	}

	public function viewListMemberShip()
	{
		$date = date('Y-m-d');
		$this->membershipModel->where(function($query) use ($date){
									$query->where('end_time', '!=', NULL)
										  ->where('end_time', '<', $date);
							  })
							  ->orWhere('number', 0)
							  ->update(['status' => 0]);
		$customerList = $this->customerModel->all();
		$membershipList = $this->membershipModel->where('status', 1)
												->orderBy('id', 'desc')
												->paginate(10);
		$cardList1 = $this->cardModel->where('status', '>', 0)
									 ->where('type', 0)
									 ->get();
		$cardList2 = $this->cardModel->where('status', '>', 0)
									 ->where('type', 1)
									 ->get();
		$data = [
            'date' => $date,
			'membershipList' => $membershipList,
			'cardList1' => $cardList1,
			'cardList2' => $cardList2,
			'customerList' => $customerList,
		];

		return $data;
	}

    public function membershipTimeList($request)
    {
        $date = $request->date;
        $membershipList = $this->membershipModel->where('status', 1)
                                                ->where('created_at', 'like', $date . '%')
                                                ->orderBy('id', 'desc')
                                                ->paginate(10);
        $customerList = $this->customerModel->all();
        $cardList1 = $this->cardModel->where('status', '>', 0)
                                     ->where('type', 0)
                                     ->get();
        $cardList2 = $this->cardModel->where('status', '>', 0)
                                     ->where('type', 1)
                                     ->get();
        $data = [
            'date' => $date,
            'membershipList' => $membershipList,
            'cardList1' => $cardList1,
            'cardList2' => $cardList2,
            'customerList' => $customerList,
        ];

        return $data;
    }

	public function membershipAdd($request)
	{
		return $this->membershipModel->create(
			$request->all()
		);
	}

	public function getExtensionView($id)
    {
        $card = $this->membershipModel->findOrFail($id);
        $data = ['card' => $card];

        return $data;
    }

    public function postExtension($request, $id)
    {
        $card = $this->membershipModel->findOrFail($id);
        $card->end_time = $request->end_time;

        return $card->save();
    }

    public function search($key)
    {
    	$customer = $this->customerModel->where(function($query) use ($key){
    										$query->where('full_name', 'like', '%' . $key . '%')
    											  ->orWhere('phone', 'like', $key . '%');
    								  })
    								  ->with('membership')
    								  ->has('membership')
    								  ->get();
    	$data = [
    		'customer' => $customer,
    	];

    	return $data;
    }

    public function membershipAddOther($request)
    {
    	$card = $this->cardModel->find($request->card_id);
    	foreach ($card->cardDetail as $cardDetail) {
    		$number = $cardDetail->number;
    	}

    	return $this->membershipModel->create(
    		[
    			'customer_id' => $request->customer_id,
    			'card_id' => $request->card_id,
    			'number' => $number,
    		]
    	);
    }

    public function membershipDelete($id)
    {
    	return $this->membershipModel->updateOrCreate(
    		['id' => $id],
    		[
    			'status' => 0,
    		]
    	);
    }
}
