<?php

namespace App\Services;

use App\Http\Requests\AccountAndDeal\AccountAndDealRequest;
use Illuminate\Support\Facades\Http;

class ZohoService
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function createAccountAndDeal(AccountAndDealRequest $request)
    {
        $authData = $this->authService->getActualizedAuthDataForUsingInApi();
        $response = Http::withHeader('Authorization', "Zoho-oauthtoken {$authData['access_token']}")
            ->post("{$authData['api_domain']}/crm/v6/Accounts", [
                'data' => [
                    [
                        'Account_Name' => $request->accountName,
                        'Website' => $request->accountWebsite,
                        'Phone' => $request->accountPhone,
                    ]
            ]
        ]);

        if(isset($response->json()['data'][0]['details']['id'])) {
            $accountId = $response->json()['data'][0]['details']['id'];
        } else {
            throw new \Exception('Account did not create');
        }

        $response = Http::withHeader('Authorization', "Zoho-oauthtoken {$authData['access_token']}")
            ->post("{$authData['api_domain']}/crm/v6/Deals", [
                'data' => [
                    [
                        'Deal_Name' => $request->dealName,
                        'Stage' => $request->dealStage,
                        'Account_Name' => $accountId,
                    ]
                ]
            ]);

        if(empty($response->json()['data'][0]['details']['id'])) {
            throw new \Exception('Deal did not create');
        }
    }
}
