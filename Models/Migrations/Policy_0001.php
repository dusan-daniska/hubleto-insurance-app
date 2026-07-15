<?php

namespace Hubleto\App\Custom\Insurance\Models\Migrations;

use Hubleto\Framework\Migration;

class Policy_0001 extends Migration
{
  public function upgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0; drop table if exists `insurance_policies`; set foreign_key_checks = 1;");
    $this->db->execute("SET foreign_key_checks = 0;
create table `insurance_policies` (
 `id` int(8) primary key auto_increment,
 `policy_number` varchar(255) not null,
 `id_customer` int(8) null default null,
 `id_contact` int(8) null default null,
 `product_name` varchar(255) null default null,
 `coverage_type` varchar(255) null default null,
 `premium_amount` decimal(14, 4) null default null,
 `deductible` decimal(14, 4) null default null,
 `date_start` date null default null,
 `date_end` date null default null,
 `status` varchar(50) null default null,
 `is_active` int(1) null default 1,
 `notes` text null default null,
 `date_created` datetime null default null,
 index `id_customer` (`id_customer`),
 index `id_contact` (`id_contact`),
 index `status` (`status`),
 index `date_start` (`date_start`),
 index `date_end` (`date_end`)) ENGINE = InnoDB;
SET foreign_key_checks = 1;");
  }

  public function downgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0; drop table if exists `insurance_policies`; set foreign_key_checks = 1;");
  }

  public function upgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `insurance_policies`
      ADD CONSTRAINT `fk_ins_policy_customer`
      FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
    $this->db->execute("ALTER TABLE `insurance_policies`
      ADD CONSTRAINT `fk_ins_policy_contact`
      FOREIGN KEY (`id_contact`) REFERENCES `contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
  }

  public function downgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `insurance_policies` DROP FOREIGN KEY `fk_ins_policy_customer`;");
    $this->db->execute("ALTER TABLE `insurance_policies` DROP FOREIGN KEY `fk_ins_policy_contact`;");
  }
}
