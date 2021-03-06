<?php


namespace Ishifoev\Invoice\Payment;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use Ishifoev\Invoice\Financial\PayeeFinancialAccount;
use Ishifoev\Invoice\Schema;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

class PaymentMeans implements XmlSerializable, XmlDeserializable
{
    private $paymentMeansCode = 1;
    private $paymentMeansCodeAttributes = [
        'listID' => 'UN/ECE 4461',
        'listName' => 'Payment Means',
        'listURI' => 'http://docs.oasis-open.org/ubl/os-UBL-2.0-update/cl/gc/default/PaymentMeansCode-2.0.gc'
    ];
    private $paymentId;
    private $cardAccountHolder;
    private $payeeFinancialAccount;
    private $paymentMandate;

    /**
     * Payment means type code
     * Example value: 30
     */
    public function getPaymentMeansCode(): ?int
    {
        return $this->paymentMeansCode;
    }

    /**
     * Set Payment means code
     */
    public function setPaymentMeansCode(?int $paymentMeansCode, $attributes = null): PaymentMeans
    {
        $this->paymentMeansCode = $paymentMeansCode;
        if (isset($attributes)) {
            $this->paymentMeansCodeAttributes = $attributes;
        }
        return $this;
    }
    /**
     * This information element helps the Seller to assign an incoming payment to the relevant payment process.
     * Example value: 432948234234234
     */
    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    /**
     * Set payment id
     */
    public function setPaymentId(?string $paymentId): PaymentMeans
    {
        $this->paymentId = $paymentId;
        return $this;
    }

    /**
     * PAYMENT CARD INFORMATION
     */
    public function getCardAccountHolder(): ?CardAccount
    {
        return $this->cardAccountHolder;
    }

    /**
     * Set payment card account info
     */
    public function setCardAccountHolder(?CardAccount $cardAccountHolder): PaymentMeans
    {
        $this->cardAccountHolder = $cardAccountHolder;
        return $this;
    }

    /**
     * CREDIT TRANSFER
     */
    public function getPayeeFinancialAccount(): ?PayeeFinancialAccount
    {
        return $this->payeeFinancialAccount;
    }

    /**
     * Set payee Financial Account
     */
    public function setPayeeFinancialAccount(?PayeeFinancialAccount $payeeFinancialAccount): PaymentMeans
    {
        $this->payeeFinancialAccount = $payeeFinancialAccount;
        return $this;
    }

    /**
     * DIRECT DEBIT
     */
    public function getPaymentMandate(): ?PaymentMandate
    {
        return $this->paymentMandate;
    }

    /**
     * Set direct debit
     */
    public function setPaymentMandate(?PaymentMandate $paymentMandate): PaymentMeans
    {
        $this->paymentMandate = $paymentMandate;
        return $this;
    }
    /**
     * Serialize XML Payment Means
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name' => Schema::CBC . 'PaymentMeansCode',
            'value' => $this->paymentMeansCode,
            'attributes' => $this->paymentMeansCodeAttributes
        ]);

        if ($this->getPaymentId() !== null) {
            $writer->write([
                Schema::CBC . 'PaymentID' => $this->getPaymentId()
            ]);
        }

        if ($this->getPayeeFinancialAccount() !== null) {
            $writer->write([
                Schema::CAC . 'PayeeFinancialAccount' => $this->getPayeeFinancialAccount()
            ]);
        }
    }

    /**
     * Deserialize PaymentMeans
     */
    static function xmlDeserialize(Reader $reader)
    {
        $paymentMeans = new self();

        $keyValue = Sabre\Xml\Element\KeyValue::xmlDeserialize($reader);

        if (isset($keyValue[Schema::CBC . 'PaymentMeansCode'])) {
            $paymentMeans->paymentMeansCode = $keyValue[Schema::CBC . 'PaymentMeansCode'];
        }

        if (isset($keyValue[Schema::CBC . 'PaymentID'])) {
            $paymentMeans->paymentId = $keyValue[Schema::CBC . 'PaymentID'];
        }

        if (isset($keyValue[Schema::CAC . 'PayeeFinancialAccount'])) {
            $paymentMeans->payeeFinancialAccount = $keyValue[Schema::CAC . 'PayeeFinancialAccount'];
        }
        return $paymentMeans;
    }
}
