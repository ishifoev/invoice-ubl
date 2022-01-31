<?php

namespace Ishifoev\Invoice\Tests;

use PHPUnit\Framework\TestCase;

class SimpleDebitNoteTest extends TestCase {
    private $schema = 'http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-Invoice-2.1.xsd';

    /**@test */
    public function test_xml_is_valid() {
        //Address Country
        $country = (new Country())
            ->setIdentificationCode('NL');

        //Full Address
        $address = (new PostalAddress())
                ->setStreetName('Lisk Center Utreht')
                ->setAddionalStreetName('De Burren')
                ->setCityName('Utreht')
                ->setPostalZone('3521')
                ->setCountry($country);

        // Supplier company node
        $supplierCompany = (new Party())
        ->setName('Supplier Company Name')
        ->setPhysicalLocation($address)
        ->setPostalAddress($address);

        // Client company node
        $clientCompany = (new Party())
        ->setName('My client')
        ->setPostalAddress($address);

        $legalMonetaryTotal = (new LegalMonetaryTotal())
        ->setPayableAmount(10 + 2)
        ->setAllowanceTotalAmount(0);

         // Tax scheme
         $taxScheme = (new TaxScheme())
         ->setId(0);

           // Product
        $productItem = (new Item())
        ->setName('Product Name')
        ->setDescription('Product Description')
        ->setSellersItemIdentification('SELLERID')
        ->setBuyersItemIdentification('BUYERID');

        // Price
        $price = (new Price())
           ->setBaseQuantity(1)
           ->setUnitCode(UnitCode::UNIT)
           ->setPriceAmount(10);
   
        // Invoice Line tax totals
        $lineTaxTotal = (new TaxTotal())
               ->setTaxAmount(2.1);

        // Invoice Line(s)
        $invoiceLine = (new InvoiceLine())
           ->setId(0)
           ->setItem($productItem)
           ->setPrice($price)
           ->setTaxTotal($lineTaxTotal)
           ->setInvoicedQuantity(1);

       $invoiceLines = [$invoiceLine];

       // Total Taxes
       $taxCategory = (new TaxCategory())
           ->setId(0)
           ->setName('VAT21%')
           ->setPercent(.21)
           ->setTaxScheme($taxScheme);

       $taxSubTotal = (new TaxSubTotal())
           ->setTaxableAmount(10)
           ->setTaxAmount(2.1)
           ->setTaxCategory($taxCategory);

       $taxTotal = (new TaxTotal())
           ->setTaxSubtotal($taxSubTotal)
           ->setTaxAmount(2.1);

       // Invoice object
       $invoice = (new Invoice())
           ->setId(1234)
           ->setCopyIndicator(false)
           ->setIssueDate(new \DateTime())
           ->setAccountingSupplierParty($supplierCompany)
           ->setAccountingCustomerParty($clientCompany)
           ->setInvoiceLines($invoiceLines)
           ->setLegalMonetaryTotal($legalMonetaryTotal)
           ->setTaxTotal($taxTotal)
           ->setInvoiceTypeCode(InvoiceTypeCode::DEBIT_NOTE);

           $generateInvoice = new GenerateInvoice();
           $outputXMLString = $generateInvoice->invoice($invoice);

           $dom = new \DOMDocument;
           $dom->loadXML($outputXMLString);

           $dom->save('./tests/SimpleCreditNoteTest.xml');

           $this->assertEquals(true, $dom->schemaValidate($this->schema));

    }
}