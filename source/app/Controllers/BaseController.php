<?php

namespace App\Controllers;

use App\Models\AffiliationModel;
use App\Models\OfficeModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();

		$this->session = \Config\Services::session();
	}

	// custom functions
	protected function getCurrentUser()
	{
		$userModel = new UserModel();
		$currentUser = $userModel->find(session('id'));

		return $currentUser;
	}

	public function getCurrentUserOffices($onlyMine = false)
	{
		$affiliationModel = new AffiliationModel();

		// cek apakah ingin mengembalikan kantor dengan pengguna saat ini sebagai member
		if (!$onlyMine) {
			$currentUserOffices = $affiliationModel->where([
				'userId' => session('id'),
				'affiliationLevel' => 'member'
			])->join('offices', 'offices.officeId = affiliations.officeId')->findAll();

			return $currentUserOffices;
		}

		// dapatkan kantor dengan pengguna saat ini sebagai admin
		$currentUserOffices = $affiliationModel->where([
			'userId' => session('id'),
			'affiliationLevel' => 'admin'
		])->join('offices', 'offices.officeId = affiliations.officeId')->findAll();

		return $currentUserOffices;
	}

	protected function currentUserIsAdmin($officeIdentifier)
	{
		// dapatkan kantor
		$officeModel = new OfficeModel();
		$office = $officeModel->where('officeIdentifier', $officeIdentifier)->first();

		// dapatkan keanggotaan user saat ini pada kantor
		$affiliationModel = new AffiliationModel();
		$affiliation = $affiliationModel->where([
			'userId' => session('id'),
			'officeId' => $office['officeId']
		])->first();

		// kembalikan boolean apakah user saat ini admin kantor
		return $affiliation['affiliationLevel'] === 'admin';
	}
}
