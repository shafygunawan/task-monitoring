<?php

namespace App\Filters;

use App\Models\AffiliationModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class OfficeFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // ambil identifier office
        $officeIdentifier = current_url(true)->getPath();
        $officeIdentifier = substr($officeIdentifier, 8, 24);

        // cek apakah office identifier cocok dengan data asli
        $affiliationModel = new AffiliationModel();
        $offices = $affiliationModel->where([
            'userId' => session('id')
        ])->join('offices', 'offices.officeId = affiliations.officeId')->findAll();
        $isOffice = false;

        foreach ($offices as $office) {
            $officeIdentifierIsMatch = $office['officeIdentifier'] === $officeIdentifier;
            if ($officeIdentifierIsMatch) {
                $isOffice = true;
                break;
            }
        }

        // cek apakah office tidak ada
        if (!$isOffice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman yang Anda cari tidak ditemukan!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
