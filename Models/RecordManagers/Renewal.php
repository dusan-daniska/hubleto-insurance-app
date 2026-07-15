<?php

namespace Hubleto\App\Custom\Insurance\Models\RecordManagers;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Renewal extends \Hubleto\Erp\RecordManager
{
  public $table = 'insurance_renewals';

  public function POLICY(): BelongsTo
  {
    return $this->belongsTo(Policy::class, 'id_policy', 'id');
  }
}
