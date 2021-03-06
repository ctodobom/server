<?php

/**
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\TwoFactor_BackupCodes\Controller;

use OCA\TwoFactor_BackupCodes\Service\BackupCodeStorage;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\IUserSession;

class SettingsController extends Controller {

	/** @var BackupCodeStorage */
	private $storage;

	/** @var IUserSession */
	private $userSession;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param BackupCodeStorage $storage
	 * @param IUserSession $userSession
	 */
	public function __construct($appName, IRequest $request, BackupCodeStorage $storage, IUserSession $userSession) {
		parent::__construct($appName, $request);
		$this->userSession = $userSession;
		$this->storage = $storage;
	}

	/**
	 * @NoAdminRequired
	 * @return JSONResponse
	 */
	public function state() {
		$user = $this->userSession->getUser();
		return $this->storage->getBackupCodesState($user);
	}

	/**
	 * @NoAdminRequired
	 * @return JSONResponse
	 */
	public function createCodes() {
		$user = $this->userSession->getUser();
		$codes = $this->storage->createCodes($user);
		return [
		    'codes' => $codes,
		    'state' => $this->storage->getBackupCodesState($user),
		];
	}

}
