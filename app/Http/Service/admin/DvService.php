<?php

namespace App\Http\Service\admin;

use App\Model\Service;

class DvService
{
	protected $serviceModel;

	public function __construct(Service $service)
    {
        $this->serviceModel = $service;
    }

	public function serviceAdd($inputs)
    {
        return $this->serviceModel->create([
            'name' => $inputs['name'],
            'price' => str_replace(',', '', $inputs['price']),
            'percent' => $inputs['percent'],
            'assistant_percent' => $inputs['assistant_percent'],
            'main_request_percent' => $inputs['main_request_percent'],
        ]);
    }

    public function serviceListView()
    {
        $serviceList = $this->serviceModel->where('status', 1)
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(8);
        $data = [
            'serviceList' => $serviceList,
        ];

        return $data;
    }

    public function oldDataService($id)
    {
        $oldData = $this->serviceModel->findOrFail($id);
        $data = [
            'oldData' => $oldData,
        ];

        return $data;
    }

    public function serviceEdit($inputs, $id)
    {
        $service = $this->serviceModel->findOrFail($id);
        $service->name = $inputs['name'];
        $service->price = str_replace(',', '', $inputs['price']);
        $service->percent = $inputs['percent'];
        $service->main_request_percent = $inputs['main_request_percent'];
        $service->assistant_percent = $inputs['assistant_percent'];
        
        return $service->save();
    }

    public function serviceDelete($id)
    {
        return $this->serviceModel->updateOrCreate(
            ['id' => $id],
            [
                'status' => 0
            ]
        );
    }

    public function serviceSearch($serviceName)
    {
        if ($serviceName != '') {
            $serviceList = $this->serviceModel->where('name', 'like', '%' . $serviceName . '%')
                                              ->orderBy('id', 'desc')
                                              ->get();
        } else {
            $serviceList = $this->serviceModel->where('name', 'like', '%' . $serviceName . '%')
                                              ->orderBy('id', 'desc')
                                              ->paginate(8);
        }
        $data = ['serviceList' => $serviceList];

        return $data;
    }
}
