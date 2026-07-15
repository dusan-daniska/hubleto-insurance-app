<?php

namespace Hubleto\App\Custom\Insurance\Models\Migrations;

use Hubleto\Framework\Migration;

class Renewal_0001 extends Migration
{
  public function upgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0; drop table if exists `insurance_renewals`; set foreign_key_checks = 1;");
    $this->db->execute("SET foreign_key_checks = 0;
create table `insurance_renewals` (
 `id` int(8) primary key auto_increment,
 `renewal_number` varchar(255) not null,
 `id_policy` int(8) null default null,
 `date_due` date null default null,
 `date_sent` date null default null,
 `renewal_premium` decimal(14, 4) null default null,
 `status` varchar(50) null default null,
 `notes` text null default null,
 `date_created` datetime null default null,
 index `id_policy` (`id_policy`),
 index `status` (`status`),
 index `date_due` (`date_due`)) ENGINE = InnoDB;
SET foreign_key_checks = 1;");
  }

  public function downgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0; drop table if exists `insurance_renewals`; set foreign_key_checks = 1;");
  }

  public function upgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `insurance_renewals`
      ADD CONSTRAINT `fk_ins_renewal_policy`
      FOREIGN KEY (`id_policy`) REFERENCES `insurance_policies` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
  }

  public function downgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `insurance_renewals` DROP FOREIGN KEY `fk_ins_renewal_policy`;");
  }
}
