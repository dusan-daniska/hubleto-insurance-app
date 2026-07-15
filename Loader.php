<?php

namespace Hubleto\App\Custom\Insurance;

class Loader extends \Hubleto\Erp\App
{
  public function init(): void
  {
    parent::init();

    $this->router()->get([
      '/^insurance\/?$/' => Controllers\Insurance::class,
      '/^insurance\/policies(\/(?<recordId>\d+))?\/?$/' => Controllers\Policies::class,
      '/^insurance\/policies\/add?\/?$/' => ['controller' => Controllers\Policies::class, 'vars' => ['recordId' => -1]],
      '/^insurance\/claims(\/(?<recordId>\d+))?\/?$/' => Controllers\Claims::class,
      '/^insurance\/claims\/add?\/?$/' => ['controller' => Controllers\Claims::class, 'vars' => ['recordId' => -1]],
      '/^insurance\/renewals(\/(?<recordId>\d+))?\/?$/' => Controllers\Renewals::class,
      '/^insurance\/renewals\/add?\/?$/' => ['controller' => Controllers\Renewals::class, 'vars' => ['recordId' => -1]],
    ]);
  }

  public function installApp(int $round): void
  {
    if ($round == 1) {
      $this->getModel(Models\Policy::class)->upgradeSchema();
      $this->getModel(Models\Claim::class)->upgradeSchema();
      $this->getModel(Models\Renewal::class)->upgradeSchema();
    }
  }

  public function renderSecondSidebar(): string
  {
    return '
      <div class="flex flex-col gap-2">
        <a class="btn btn-square btn-primary-outline" href="' . $this->env()->projectUrl . '/insurance">
          <span class="icon"><i class="fas fa-shield-alt"></i></span>
          <span class="text">' . $this->translate('Insurance') . '</span>
        </a>
        <a class="btn btn-transparent" href="' . $this->env()->projectUrl . '/insurance/policies">
          <span class="icon"><i class="fas fa-file-contract"></i></span>
          <span class="text">' . $this->translate('Policies') . '</span>
        </a>
        <a class="btn btn-transparent" href="' . $this->env()->projectUrl . '/insurance/claims">
          <span class="icon"><i class="fas fa-exclamation-circle"></i></span>
          <span class="text">' . $this->translate('Claims') . '</span>
        </a>
        <a class="btn btn-transparent" href="' . $this->env()->projectUrl . '/insurance/renewals">
          <span class="icon"><i class="fas fa-sync-alt"></i></span>
          <span class="text">' . $this->translate('Renewals') . '</span>
        </a>
      </div>
    ';
  }
}
