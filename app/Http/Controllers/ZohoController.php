<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountAndDeal\AccountAndDealRequest;
use App\Services\ZohoService;
use Illuminate\Http\JsonResponse;

class ZohoController extends Controller
{
    public function createAccountAndDeal(AccountAndDealRequest $request): JsonResponse
    {
        try {
            resolve(ZohoService::class)->createAccountAndDeal($request);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()
                ->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
