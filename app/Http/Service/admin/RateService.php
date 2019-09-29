<?php

namespace App\Http\Service\admin;

use App\Model\Rate;

class RateService
{
	protected $rateModel;

	public function __construct(Rate $rateModel)
    {
        $this->rateModel = $rateModel;
    }

	public function getRateList()
    {
        $rateList = $this->rateModel->all();
        $data = [
            'rateList' => $rateList,
        ];

        return $data;
    }

    public function postRate($request, $rateId)
    {
        return $this->rateModel->updateOrCreate(
            ['id' => $rateId],
            [
                'name' => $request->name,
            ]
        );
    }
}