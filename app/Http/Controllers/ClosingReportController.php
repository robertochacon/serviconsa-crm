<?php

namespace App\Http\Controllers;

use App\Models\Closing;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Buyer;

class ClosingReportController extends Controller
{
    public function report(int $id)
    {

        $closing = Closing::where("id", $id)->first();

        $customer = new Buyer([
            'provider' => $closing["provider"],
            'services' => $closing["services"],
            'payments' => $closing["payments"],
            'total' => $closing["total_do"],
            'meters' => $closing["total_meters"],
            'pending' => $closing["pending"],
        ]);

        $item = InvoiceItem::make('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->addItem($item)
            ->logo(public_path('vendor/invoices/logo.png'))
            ->template('closing_report');

        return $invoice->stream();
    }
}
