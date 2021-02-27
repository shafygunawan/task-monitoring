<?php

namespace App\Controllers;

class Office extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Offices | Task Monitoring',
            'user' => $this->getUser(),
            'offices' => $this->getOffices()
        ];

        return view('office/index', $data);
    }
}
