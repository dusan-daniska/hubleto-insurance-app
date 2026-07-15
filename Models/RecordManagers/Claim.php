<?php

namespace Hubleto\App\Custom\Insurance\Models\RecordManagers;

use Hubleto\App\Community\Contacts\Models\RecordManagers\Contact;
use Hubleto\App\Community\Customers\Models\RecordManagers\Customer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Claim extends \Hubleto\Erp\RecordManager
{
  public $table = 'insurance_claims';

  public function POLICY(): BelongsTo
  {
    return $this->belongsTo(Policy::class, 'id_policy', 'id');
  }

  public function CUSTOMER(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'id_customer', 'id');
  }

  public function CONTACT(): BelongsTo
  {
    return $this->belongsTo(Contact::class, 'id_contact', 'id');
  }
}
