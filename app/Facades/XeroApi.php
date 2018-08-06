<?php

namespace App\Facades;

use XeroPHP\Application\PrivateApplication;

class XeroApi{
	
    function __construct(){
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getAllContacts() { 
	$xero = new PrivateApplication(config('services.xero_base_config'));
	# get contacts from XERO
	return $xero->load('Accounting\\Contact')->execute();
    }


    /**
     * Get the ContactID by Email registered
     *
     * @return string
     */
    public static function getContactByEmail($email) {
    	$xero = new PrivateApplication(config('services.xero_base_config'));
	# get contacts from XERO 
    	$contacts = $xero->load('Accounting\\Contact')->execute();
	foreach($contacts as $contact){
		if(strtolower($contact->EmailAddress) == strtolower($email)){
			return $contact->ContactID;
		}
	}
	return false;    
    }



    /**
     * Get the ContactID by Email registered
     *
     * @return string
     */
    public static function getAllInvoices() {
    	$xero = new PrivateApplication(config('services.xero_base_config'));
	# get invoices from XERO 
    	return $xero->load('Accounting\\Invoice')->execute();     
    }



    /**
     * Get the invoices by status EG; INVOICE_STATUS_AUTHORISED
     *
     * @return string
     */
    public static function getInvoicesByStatus($status){
    	$xero = new PrivateApplication(config('services.xero_base_config'));
	# get invoices from XERO 
    	return $xero->load('Accounting\\Invoice')
    				->where('Status', \XeroPHP\Models\Accounting\Invoice::$status)
    					->execute();  
    }


    /**
     * Create invoice
     *
     * @return string
     */
    public static function createInvoice($ContactEmail = '', $data){
    	$xero = new PrivateApplication(config('services.xero_base_config'));
    	if($ContactEmail != ''){
    		$ContactID = self::getContactByEmail($ContactEmail);
    		if($ContactID)
			$contact = $xero->loadByGUID('Accounting\\Contact', $ContactID); //EG. f7883ae0-f4fb-47c2-bf17-154209859243 
		else
			return false; # user doesn't exist
    	}else{
    		# Create a new contact
    		# ...
    		return false; # Missing email. 
    	}

	$xeroInvoice = new \XeroPHP\Models\Accounting\Invoice($xero);
	$xeroInvoice->setType($data['Type']);
	$xeroInvoice->setContact($contact);
	$xeroInvoice->setReference($data['Reference']);
	$xeroInvoice->setLineAmountType($data['AmountType']);
	$xeroInvoice->setInvoiceNumber($data['InvoiceNumber']);
	$xeroInvoice->setStatus($data['Status']);
	$xeroInvoice->setDueDate(\DateTime::createFromFormat('Y-m-d', $data['DueDate'] ));

	foreach($data['LineItems'] as $LineItem){
		$xeroLineItem = new \XeroPHP\Models\Accounting\Invoice\LineItem($xero);
		$xeroLineItem->setQuantity($LineItem['Quantity']);
		$xeroLineItem->setDescription($LineItem['Description']);
		$xeroLineItem->setUnitAmount($LineItem['UnitAmount']);
		$xeroLineItem->setTaxType($LineItem['TaxType']);
		$xeroLineItem->setAccountCode($LineItem['AccountCode']);
		$xeroInvoice->addLineItem($xeroLineItem);
	}
	$xeroInvoice->save();
    	
	return 'Invoice created successfully';	
    }



    /**
     * Create Contact
     *
     * @return string
     */
    public static function createContact($contact){
    	$xero = new PrivateApplication(config('services.xero_base_config'));
	$xero_new_contact = new \XeroPHP\Models\Accounting\Contact($xero);
	$xero_new_contact->setName($contact['Username'])
	    ->setFirstName($contact['FirstName'])
	    ->setLastName($contact['LastName'])
	    ->setEmailAddress($contact['Email']);
	$xero_new_contact->save(); # for arrays of objects->   $xero->saveAll();

	return 'Contact crated successfully';
    }

}