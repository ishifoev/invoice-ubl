## UBL Invoice

A library for creating a valid UBL files in PHP like standard EN16931.l A key objective of the European standard on eInvoicing (EN) is to make it possible for sellers to send invoices to many customers by using a single eInvoicing format and thus not having to adjust their sending and/or receiving to connect with individual trading parties.

### Requirements

* PHP 7.2
* composer

## Installation 

````
composer require ishifoev/invoice-ubl

````

````
composer install
````

### Check pass all test case for Invoices standard
````
vendor/bin/phpunit
````

### Usage for show classes in Invoice that you will generate

```php
include 'vendor/autoload.php';
 // Tax scheme
 $taxScheme = (new \Ishifoev\Invoice\Party\TaxScheme())
 ->setId('VAT');


  // Client contact node
  $clientContact = (new \Ishifoev\Invoice\Account\Contact())
   ->setName('Client name')
   ->setTelephone('908-99-74-74');


$country = (new \Ishifoev\Invoice\Account\Country())
            ->setIdentificationCode('NL');

         
        // Full address
$address = (new \Ishifoev\Invoice\Account\PostalAddress())
                ->setStreetName('Lisk Center Utreht')
                ->setAddionalStreetName('De Burren')
                ->setCityName('Utreht')
                ->setPostalZone('3521')
                ->setCountry($country);


$financialInstitutionBranch = (new \Ishifoev\Invoice\Financial\FinancialInstitutionBranch())
                ->setId('RABONL2U');
         

$payeeFinancialAccount = (new \Ishifoev\Invoice\Financial\PayeeFinancialAccount())
               ->setFinancialInstitutionBranch($financialInstitutionBranch)
                ->setName('Customer Account Holder')
                ->setId('NL00RABO0000000000');
              

$paymentMeans = (new  \Ishifoev\Invoice\Payment\PaymentMeans())
                ->setPayeeFinancialAccount($payeeFinancialAccount)
                ->setPaymentMeansCode(31, [])
                ->setPaymentId('our invoice 1234');

 // Supplier company node
 $supplierLegalEntity = (new \Ishifoev\Invoice\Legal\LegalEntity())		// $doc = new DOMDocument();
		// $doc->load($path);
 ->setRegistrationNumber('PonderSource')
 ->setCompanyId('NL123456789');


$supplierPartyTaxScheme = (new \Ishifoev\Invoice\Party\PartyTaxScheme())
 ->setTaxScheme($taxScheme)
 ->setCompanyId('NL123456789');

$supplierCompany = (new \Ishifoev\Invoice\Party\Party())
 ->setEndPointId('7300010000001', '0007')
 ->setPartyIdentificationId('99887766')
 ->setName('PonderSource')
 ->setLegalEntity($supplierLegalEntity)
 ->setPartyTaxScheme($supplierPartyTaxScheme)
 ->setPostalAddress($address);



// Client company node
$clientLegalEntity = (new \Ishifoev\Invoice\Legal\LegalEntity())
 ->setRegistrationNumber('Client Company Name')
 ->setCompanyId('Client Company Registration');



$clientPartyTaxScheme = (new \Ishifoev\Invoice\Party\PartyTaxScheme())
 ->setTaxScheme($taxScheme)
 ->setCompanyId('BE123456789');



$clientCompany = (new \Ishifoev\Invoice\Party\Party())
->setPartyIdentificationId('9988217')
->setEndPointId('7300010000002', '0002')
 ->setName('Client Company Name')
 ->setLegalEntity($clientLegalEntity)
 ->setPartyTaxScheme($clientPartyTaxScheme)
 ->setPostalAddress($address)
 ->setContact($clientContact);

$legalMonetaryTotal = (new \Ishifoev\Invoice\Legal\LegalMonetaryTotal())
 ->setPayableAmount(10 + 2.1)
 ->setAllowanceTotalAmount(0)
 ->setTaxInclusiveAmount(10 + 2.1)
 ->setLineExtensionAmount(10)
 ->setTaxExclusiveAmount(10);

 
 $classifiedTaxCategory = (new \Ishifoev\Invoice\Tax\ClassifiedTaxCategory())
 ->setId('S')
 ->setPercent(21.00)
 ->setTaxScheme($taxScheme);

  // Product
  $productItem = (new \Ishifoev\Invoice\Item())
  ->setName('Product Name')
  ->setClassifiedTaxCategory($classifiedTaxCategory)
  ->setDescription('Product Description');

// Price
 $price = (new \Ishifoev\Invoice\Payment\Price())
       ->setBaseQuantity(1)
       ->setUnitCode(\Ishifoev\Invoice\Payment\UnitCode::UNIT)
       ->setPriceAmount(10);
     
// Invoice Line tax totals
$lineTaxTotal = (new Ishifoev\Invoice\Tax\TaxTotal())
            ->setTaxAmount(2.1);
           

// InvoicePeriod
$invoicePeriod = (new Ishifoev\Invoice\Invoice\InvoicePeriod())
->setStartDate(new \DateTime());

// Invoice Line(s)
$invoiceLine = (new Ishifoev\Invoice\Invoice\InvoiceLine())
->setId(0)
->setItem($productItem)
->setPrice($price)
->setInvoicePeriod($invoicePeriod)
->setLineExtensionAmount(10)
->setInvoicedQuantity(1);



$invoiceLines = [$invoiceLine];

$taxCategory = (new \Ishifoev\Invoice\Tax\TaxCategory())
            ->setId('S', [])
            ->setPercent(21.00)
            ->setTaxScheme($taxScheme);
            
$allowanceCharge = (new \Ishifoev\Invoice\AllowanceCharge())
->setChargeIndicator(true)
->setAllowanceReason('Insurance')
->setAmount(10)
->setTaxCategory($taxCategory);

 $taxSubTotal = (new \Ishifoev\Invoice\Tax\TaxSubTotal())
            ->setTaxableAmount(10)
            ->setTaxAmount(2.1)
            ->setTaxCategory($taxCategory);

$taxTotal = (new \Ishifoev\Invoice\Tax\TaxTotal())
            ->setTaxSubtotal($taxSubTotal)
            ->setTaxAmount(2.1);

         
   // Payment Terms
$paymentTerms = (new \Ishifoev\Invoice\Payment\PaymentTerms())
   ->setNote('30 days net');
  
// Delivery
$deliveryLocation = (new \Ishifoev\Invoice\Account\PostalAddress())
->setStreetName('Delivery street 2')
->setAddionalStreetName('Building 56')
->setCityName('Utreht')
->setPostalZone('3521')
->setCountry($country);


$delivery = (new \Ishifoev\Invoice\Account\Delivery())
  ->setActualDeliveryDate(new \DateTime())
  ->setDeliveryLocation($deliveryLocation);
  

$orderReference = (new \Ishifoev\Invoice\Payment\OrderReference())
  ->setId('5009567')
  ->setSalesOrderId('tRST-tKhM');
  
   // Invoice object
   $invoice = (new  \Ishifoev\Invoice\Invoice\Invoice())
   ->setProfileID('urn:fdc:peppol.eu:2017')
   ->setCustomazationID('urn:cen.eu:en16931:2017')
   ->setId(1234)
   ->setIssueDate(new \DateTime())
   ->setNote('invoice note')
   ->setAccountingCostCode('4217:2323:2323')
   ->setDelivery($delivery)
   ->setAccountingSupplierParty($supplierCompany)
   ->setAccountingCustomerParty($clientCompany)
   ->setInvoiceLines($invoiceLines)
   ->setLegalMonetaryTotal($legalMonetaryTotal)
   ->setPaymentTerms($paymentTerms)
   //->setAllowanceCharges($allowanceCharge)
   ->setInvoicePeriod($invoicePeriod)
   ->setPaymentMeans($paymentMeans)
   ->setByerReference('BUYER_REF')
   ->setOrderReference($orderReference)
   ->setTaxTotal($taxTotal);


  $generateInvoice = new \Ishifoev\Invoice\Invoice\GenerateInvoice();
  $outputXMLString = $generateInvoice->invoice($invoice);
  $dom = new \DOMDocument;
  $dom->loadXML($outputXMLString);
  $dom->save('EN16931Test.xml');

```
