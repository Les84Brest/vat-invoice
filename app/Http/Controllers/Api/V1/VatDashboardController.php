<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Types\InvoiceStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class VatDashboardController extends Controller
{
    public function dashboardData(Request $request): JsonResponse
    {

        $user = $request->user();
        if (!isset($user->company->id)) {
            return response()->json(["error" => true, "message" => "Не назначена компания"], 422);
        }

        $invoiceCount = Invoice::where('author_id', $user->id)
            ->where('sender_company_id', $user->company->id)
            ->count();
        $incomingVAT = Invoice::where('recipient_company_id', $user->company->id)
            ->where('status', InvoiceStatus::COMPLETED_SIGNED)
            ->sum('total_vat');
        $outgoingVAT = Invoice::where('author_id', $user->id)
            ->where('sender_company_id', $user->company->id)
            ->where('status', InvoiceStatus::COMPLETED_SIGNED)
            ->sum('total_vat');

        return response()->json([
            "invoiceCount" => $invoiceCount,
            "incomingVAT" => $incomingVAT,
            "outgoingVAT" => $outgoingVAT,
        ]);
    }
}
