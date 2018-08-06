<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Facades\XeroApi;
use XeroPrivate;
use XeroPublic;

class XeroController extends Controller
{
    //
    public function xero_test(){
		
        $transaction = rand(1111,9999); # random for me
        $data = array(
                "Type" => "ACCREC", # Accounting received.
                "AmountType" => "Inclusive",
                "InvoiceNumber" => "LD".$transaction,
                "Reference" => "LD".$transaction." - Some reference", # small description ref 
                "DueDate" => date('Y-m-d'), # date('Y-m-d', strtotime("+3 days")),
                "Status" => "AUTHORISED",
                "LineItems"=> array(
                                           # add some arrays with items. Now just one.
                        array(
                            "Description" => "Just another test invoice",
                            "Quantity" => "2.00",
                            "UnitAmount" => "250.00",
                            "AccountCode" => "200", 
                            "TaxType" => 'OUTPUT2' # Tax in New Zealand
                        )
                    )
            );
    
        # before create a invoice, you MUST TO CREATE A CONTACT
            $xero_tests = XeroApi::createInvoice('contact@email.com', $data);
    
            dd($xero_tests);
    }
    public function test(){
        $invoices = XeroPrivate::load('Accounting\\Invoice')->execute();
        // dd('seen');
    }
}
