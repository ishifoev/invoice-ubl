<?php

namespace Ishifoev\Invoice\Party;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Ishifoev\Invoice\Legal\LegalEntity;
use \Ishifoev\Invoice\Account\PostalAddress;
use Ishifoev\Invoice\Account\Contact;
use Ishifoev\Invoice\Party\PartyTaxScheme;

class Party implements XmlSerializable
{
    private $name;
    private $partyIdentificationId;
    private $postalAddress;
    private $physicalLocation;
    private $contact;
    private $partyTaxScheme;
    private $legalEntity;
    private $endpointID;
    private $endpointID_schemeID;
    private $partyIdAttrubutes;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Party
     */
    public function setName(?string $name): Party
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPartyIdentificationId(): ?string
    {
        return $this->partyIdentificationId;
    }

    /**
     * @param string $partyIdentificationId
     * @return Party
     */
    public function setPartyIdentificationId(?string $partyIdentificationId): Party
    {
        $this->partyIdentificationId = $partyIdentificationId;
        return $this;
    }

    /**
     * @param $endpointID
     * @param int|string $schemeID See list at https://docs.peppol.eu/poacc/billing/3.0/codelist/eas/
     * @return Party
     */
    public function setEndpointID($endpointID, $endpointID_schemeID): Party
    {
        $this->endpointID = $endpointID;
        $this->endpointID_schemeID = $endpointID_schemeID;
        return $this;
    }

    /**
     * @return Address
     */
    public function getPostalAddress(): ?PostalAddress
    {
        return $this->postalAddress;
    }

    /**
     * @param Address $postalAddress
     * @return Party
     */
    public function setPostalAddress(?PostalAddress $postalAddress): Party
    {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    /**
     * @return LegalEntity
     */
    public function getLegalEntity(): ?LegalEntity
    {
        return $this->legalEntity;
    }

    /**
     * @param LegalEntity $legalEntity
     * @return Party
     */
    public function setLegalEntity(?LegalEntity $legalEntity): Party
    {
        $this->legalEntity = $legalEntity;
        return $this;
    }

    /**
     * @return Address
     */
    public function getPhysicalLocation(): ?PostalAddress
    {
        return $this->physicalLocation;
    }

    /**
     * @param Address $physicalLocation
     * @return Party
     */
    public function setPhysicalLocation(?PostalAddress $physicalLocation): Party
    {
        $this->physicalLocation = $physicalLocation;
        return $this;
    }

    /**
     * @return PartyTaxScheme
     */
    public function getPartyTaxScheme(): ?PartyTaxScheme
    {
        return $this->partyTaxScheme;
    }

    /**
     * @param PartyTaxScheme $partyTaxScheme
     * @return Party
     */
    public function setPartyTaxScheme(PartyTaxScheme $partyTaxScheme)
    {
        $this->partyTaxScheme = $partyTaxScheme;
        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     * @return Party
     */
    public function setContact(?Contact $contact): Party
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        if($this->endpointID !== null && $this->endpointID_schemeID !== null) {
            $writer->write([
                'name' => Schema::CBC . 'EndpointID',
                    'value' => $this->endpointID,
                    'attributes' => [
                        'schemeID' => is_numeric($this->endpointID_schemeID)
                            ? sprintf('%04d', +$this->endpointID_schemeID)
                            : $this->endpointID_schemeID
                    ]
            ]);
        }
        if ($this->partyIdentificationId !== null) {
            $writer->write([
                Schema::CAC . 'PartyIdentification' => [
                    Schema::CBC . 'ID' => $this->partyIdentificationId
                ],
            ]);
        }

        $writer->write([
            Schema::CAC . 'PartyName' => [
                Schema::CBC . 'Name' => $this->name
            ],
            Schema::CAC . 'PostalAddress' => $this->postalAddress
        ]);

        if ($this->physicalLocation !== null) {
            $writer->write([
               Schema::CAC . 'PhysicalLocation' => [Schema::CAC . 'Address' => $this->physicalLocation]
            ]);
        }

        if ($this->partyTaxScheme !== null) {
            $writer->write([
                Schema::CAC . 'PartyTaxScheme' => $this->partyTaxScheme
            ]);
        }

        if ($this->legalEntity !== null) {
            $writer->write([
                Schema::CAC . 'PartyLegalEntity' => $this->legalEntity
            ]);
        }

        if ($this->contact !== null) {
            $writer->write([
                Schema::CAC . 'Contact' => $this->contact
            ]);
        }
    }
}