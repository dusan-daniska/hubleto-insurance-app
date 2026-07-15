<?php

namespace Hubleto\App\Custom\Insurance\Models\RecordManagers;

use Hubleto\App\Community\Contacts\Models\RecordManagers\Contact;
use Hubleto\App\Community\Customers\Models\RecordManagers\Customer;
use Hubleto\App\Custom\Insurance\Models\RecordManagers\Claim;
use Hubleto\App\Custom\Insurance\Models\RecordManagers\Renewal;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Policy extends \Hubleto\Erp\RecordManager
{
  public $table = 'insurance_policies';

  public function CUSTOMER(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'id_customer', 'id');
  }

  public function CONTACT(): BelongsTo
  {
    return $this->belongsTo(Contact::class, 'id_contact', 'id');
  }

  public function CLAIMS(): HasMany
  {
    return $this->hasMany(Claim::class, 'id_policy', 'id');
  }

  public function RENEWALS(): HasMany
  {
    return $this->hasMany(Renewal::class, 'id_policy', 'id');
  }
}
