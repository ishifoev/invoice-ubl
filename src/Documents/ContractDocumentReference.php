<?php

namespace Ishifoev\Invoice\Documents;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Ishifoev\Invoice\Schema;

class ContractDocumentReference implements XmlSerializable
{
    private $id;

    /**
     * Get The identification of a contract.
     * Example value: 123Contractref
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set id
     */
    public function setId(?string $id): ContractDocumentReference
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Xml Serialize Contract Document Reference
     */
    public function xmlSerialize(Writer $writer)
    {
        if ($this->id !== null) {
            $writer->write([
              Schema::CBC . 'ID' => $this->id
            ]);
        }
    }
}
