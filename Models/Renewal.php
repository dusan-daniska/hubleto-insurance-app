<?php

namespace Hubleto\App\Custom\Insurance\Models;

use Hubleto\App\Custom\Insurance\Models\RecordManagers\Renewal as RenewalRecordManager;
use Hubleto\Framework\Db\Column\Date;
use Hubleto\Framework\Db\Column\DateTime;
use Hubleto\Framework\Db\Column\Decimal;
use Hubleto\Framework\Db\Column\Lookup;
use Hubleto\Framework\Db\Column\Text;
use Hubleto\Framework\Db\Column\Varchar;

class Renewal extends \Hubleto\Erp\Model
{
  public string $table = 'insurance_renewals';
  public string $recordManagerClass = RenewalRecordManager::class;
  public ?string $lookupSqlValue = 'concat(ifnull({%TABLE%}.renewal_number, ""), " ", ifnull({%TABLE%}.status, ""))';
  public ?string $lookupUrlDetail = 'insurance/renewals/{%ID%}';

  public array $relations = [
    'POLICY' => [self::HAS_ONE, Policy::class, 'id_policy', 'id'],
  ];

  public function describeColumns(): array
  {
    return array_merge(parent::describeColumns(), [
      'renewal_number' => (new Varchar($this, $this->translate('Renewal number')))->setRequired()->setDefaultVisible(),
      'id_policy' => (new Lookup($this, $this->translate('Policy'), Policy::class))->setRequired()->setDefaultVisible(),
      'date_due' => (new Date($this, $this->translate('Due date'))),
      'date_sent' => (new Date($this, $this->translate('Sent date'))),
      'renewal_premium' => (new Decimal($this, $this->translate('Renewal premium')))->setUnit('€'),
      'status' => (new Varchar($this, $this->translate('Status')))->setDefaultValue('Pending'),
      'notes' => (new Text($this, $this->translate('Notes'))),
      'date_created' => (new DateTime($this, $this->translate('Created')))->setReadonly(),
    ]);
  }

  public function describeTable(): \Hubleto\Framework\Description\Table
  {
    $description = parent::describeTable();
    $description->ui['addButtonText'] = $this->translate('Add Renewal');
    return $description;
  }
}
