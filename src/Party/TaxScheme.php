<?php

namespace Ishifoev\Invoice\Party;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Ishifoev\Invoice\Schema;
//require 'Schema.php';

class TaxScheme implements XmlSerializable {
    private $id;
    /**
     * For Seller Vat Identifier get
     * Example value: VAT
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     *Set ID 
     */
    public function setId(?string $id): TaxScheme {
        $this->id = $id;
        return $this;
    }

    /**
     * Serialize XML Tax Scheme
     */
    public function xmlSerialize(Writer $writer) {
       $writer->write([
          Schema::CBC . 'ID' => $this->id
       ]);
    }
}