<?php

namespace Ishifoev\Invoice\Financial;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Ishifoev\Invoice\Schema;

//require 'Schema.php';

class FinancialInstitutionBranch implements XmlSerializable {
    private $id;

    /**
     * Payment service provider identifier
     *  Example value: 9999
     */
    public function getId(): ?string {
       return $this->id;
    }

    /**
     * Set provider identifier
     */
    public function setId(?string $id): FinancialInstitutionBranch {
        $this->id = $id;
        return $this;
    }

    /**
     * Serialize XML FinancialInstitutionBranch
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([
           Schema::CBC . 'ID' => $this->id
        ]);
     }
}