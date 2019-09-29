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
		$customerList = $this->customerModel->all();
		$membershipList = $this->membershipModel->paginate(10);
		$cardList = $this->cardModel->all();
		$data = [
			'membershipList' => $membershipList,
			'cardList' => $cardList,
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
}
