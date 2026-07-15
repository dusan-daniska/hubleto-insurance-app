<?php

namespace Hubleto\App\Custom\Insurance\Models;

use Hubleto\App\Community\Customers\Models\Customer;
use Hubleto\App\Community\Contacts\Models\Contact;
use Hubleto\App\Custom\Insurance\Models\RecordManagers\Claim as ClaimRecordManager;
use Hubleto\Framework\Db\Column\Date;
use Hubleto\Framework\Db\Column\DateTime;
use Hubleto\Framework\Db\Column\Decimal;
use Hubleto\Framework\Db\Column\Lookup;
use Hubleto\Framework\Db\Column\Text;
use Hubleto\Framework\Db\Column\Varchar;

class Claim extends \Hubleto\Erp\Model
{
  public string $table = 'insurance_claims';
  public string $recordManagerClass = ClaimRecordManager::class;
  public ?string $lookupSqlValue = 'concat(ifnull({%TABLE%}.claim_number, ""), " ", ifnull({%TABLE%}.claim_subject, ""))';
  public ?string $lookupUrlDetail = 'insurance/claims/{%ID%}';

  public array $relations = [
    'POLICY' => [self::HAS_ONE, Policy::class, 'id_policy', 'id'],
    'CUSTOMER' => [self::HAS_ONE, Customer::class, 'id_customer', 'id'],
    'CONTACT' => [self::HAS_ONE, Contact::class, 'id_contact', 'id'],
  ];

  public function describeColumns(): array
  {
    return array_merge(parent::describeColumns(), [
      'claim_number' => (new Varchar($this, $this->translate('Claim number')))->setRequired()->setDefaultVisible(),
      'id_policy' => (new Lookup($this, $this->translate('Policy'), Policy::class))->setRequired()->setDefaultVisible(),
      'id_customer' => (new Lookup($this, $this->translate('Customer'), Customer::class))->setRequired(),
      'id_contact' => (new Lookup($this, $this->translate('Contact'), Contact::class)),
      'claim_subject' => (new Varchar($this, $this->translate('Subject')))->setRequired()->setDefaultVisible(),
      'incident_date' => (new Date($this, $this->translate('Incident date'))),
      'reported_date' => (new Date($this, $this->translate('Reported date'))),
      'status' => (new Varchar($this, $this->translate('Status')))->setDefaultValue('New'),
      'settlement_amount' => (new Decimal($this, $this->translate('Settlement amount')))->setUnit('€'),
      'notes' => (new Text($this, $this->translate('Notes'))),
      'date_created' => (new DateTime($this, $this->translate('Created')))->setReadonly(),
    ]);
  }

  public function describeTable(): \Hubleto\Framework\Description\Table
  {
    $description = parent::describeTable();
    $description->ui['addButtonText'] = $this->translate('Add Claim');
    return $description;
  }
}
