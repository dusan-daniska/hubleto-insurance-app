<?php

namespace Hubleto\App\Custom\Insurance\Controllers;

class Insurance extends \Hubleto\Erp\Controller
{
  public function prepareView(): void
  {
    parent::prepareView();
    $this->setView('@Hubleto:App:Custom:Insurance/Insurance.twig');
  }
}
