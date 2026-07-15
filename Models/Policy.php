<?php

namespace Hubleto\App\Custom\Insurance\Models;

use Hubleto\App\Community\Customers\Models\Customer;
use Hubleto\App\Community\Contacts\Models\Contact;
use Hubleto\App\Custom\Insurance\Models\RecordManagers\Policy as PolicyRecordManager;
use Hubleto\Framework\Db\Column\Boolean;
use Hubleto\Framework\Db\Column\Date;
use Hubleto\Framework\Db\Column\DateTime;
use Hubleto\Framework\Db\Column\Decimal;
use Hubleto\Framework\Db\Column\Lookup;
use Hubleto\Framework\Db\Column\Text;
use Hubleto\Framework\Db\Column\Varchar;

class Policy extends \Hubleto\Erp\Model
{
  public string $table = 'insurance_policies';
  public string $recordManagerClass = PolicyRecordManager::class;
  public ?string $lookupSqlValue = 'concat(ifnull({%TABLE%}.policy_number, ""), " ", ifnull({%TABLE%}.product_name, ""))';
  public ?string $lookupUrlDetail = 'insurance/policies/{%ID%}';

  public array $relations = [
    'CUSTOMER' => [self::HAS_ONE, Customer::class, 'id_customer', 'id'],
    'CONTACT' => [self::HAS_ONE, Contact::class, 'id_contact', 'id'],
    'CLAIMS' => [self::HAS_MANY, Claim::class, 'id_policy', 'id'],
    'RENEWALS' => [self::HAS_MANY, Renewal::class, 'id_policy', 'id'],
  ];

  public function describeColumns(): array
  {
    return array_merge(parent::describeColumns(), [
      'policy_number' => (new Varchar($this, $this->translate('Policy number')))->setRequired()->setDefaultVisible(),
      'id_customer' => (new Lookup($this, $this->translate('Customer'), Customer::class))->setRequired()->setDefaultVisible(),
      'id_contact' => (new Lookup($this, $this->translate('Contact'), Contact::class)),
      'product_name' => (new Varchar($this, $this->translate('Product')))->setRequired()->setDefaultVisible(),
      'coverage_type' => (new Varchar($this, $this->translate('Coverage type'))),
      'premium_amount' => (new Decimal($this, $this->translate('Premium amount')))->setUnit('€'),
      'deductible' => (new Decimal($this, $this->translate('Deductible')))->setUnit('€'),
      'date_start' => (new Date($this, $this->translate('Start date'))),
      'date_end' => (new Date($this, $this->translate('End date'))),
      'status' => (new Varchar($this, $this->translate('Status')))->setDefaultValue('Active'),
      'is_active' => (new Boolean($this, $this->translate('Active')))->setDefaultValue(true),
      'notes' => (new Text($this, $this->translate('Notes'))),
      'date_created' => (new DateTime($this, $this->translate('Created')))->setReadonly(),
    ]);
  }

  public function describeTable(): \Hubleto\Framework\Description\Table
  {
    $description = parent::describeTable();
    $description->ui['addButtonText'] = $this->translate('Add Policy');
    return $description;
  }
}
