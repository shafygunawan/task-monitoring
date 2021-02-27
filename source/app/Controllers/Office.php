<?php

namespace App\Controllers;

class Office extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Offices | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'offices' => $this->getOffices()
        ];

        return view('office/index', $data);
    }
}
