<?php


namespace App\Tests\Api;

use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;
use PHPUnit\Framework\Assert;

class LoginCest {

	public function _before(ApiTester $I) {
	}

	// tests
	public function emptyCredentials(ApiTester $I): void {
		$I->wantTo('Empty user credentials');
		$I->sendPOST('/api/auth/authenticate');
		$I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->seeResponseIsJson();
		$I->seeResponseJsonMatchesJsonPath('$.error.code');
		$I->seeResponseJsonMatchesJsonPath('$.error.message');
		$I->seeResponseJsonMatchesJsonPath('$.error.userMessage');

		$response = json_decode($I->grabResponse());
		Assert::assertEquals(
			"1001",
			$response->error->code,
			"Invalid error code"
		);
		Assert::assertEquals(
			"Invalid email or password.",
			$response->error->message,
			"Invalid error message"
		);
	}

}
