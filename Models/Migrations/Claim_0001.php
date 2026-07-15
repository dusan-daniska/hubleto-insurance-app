<?php

namespace Hubleto\App\Custom\Insurance\Models\Migrations;

use Hubleto\Framework\Migration;

class Claim_0001 extends Migration
{
  public function upgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0; drop table if exists `insurance_claims`; set foreign_key_checks = 1;");
    $this->db->execute("SET foreign_key_checks = 0;
create table `insurance_claims` (
 `id` int(8) primary key auto_increment,
 `claim_number` varchar(255) not null,
 `id_policy` int(8) null default null,
 `id_customer` int(8) null default null,
 `id_contact` int(8) null default null,
 `claim_subject` varchar(255) null default null,
 `incident_date` date null default null,
 `reported_date` date null default null,
 `status` varchar(50) null default null,
 `settlement_amount` decimal(14, 4) null default null,
 `notes` text null default null,
 `date_created` datetime null default null,
 index `id_policy` (`id_policy`),
 index `id_customer` (`id_customer`),
 index `id_contact` (`id_contact`),
 index `status` (`status`)) ENGINE = InnoDB;
SET foreign_key_checks = 1;");
  }

  public function downgradeSchema(): void
  {
    $this->db->execute("set foreign_key_checks = 0; drop table if exists `insurance_claims`; set foreign_key_checks = 1;");
  }

  public function upgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `insurance_claims`
      ADD CONSTRAINT `fk_ins_claim_policy`
      FOREIGN KEY (`id_policy`) REFERENCES `insurance_policies` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
    $this->db->execute("ALTER TABLE `insurance_claims`
      ADD CONSTRAINT `fk_ins_claim_customer`
      FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
    $this->db->execute("ALTER TABLE `insurance_claims`
      ADD CONSTRAINT `fk_ins_claim_contact`
      FOREIGN KEY (`id_contact`) REFERENCES `contacts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
  }

  public function downgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `insurance_claims` DROP FOREIGN KEY `fk_ins_claim_policy`;");
    $this->db->execute("ALTER TABLE `insurance_claims` DROP FOREIGN KEY `fk_ins_claim_customer`;");
    $this->db->execute("ALTER TABLE `insurance_claims` DROP FOREIGN KEY `fk_ins_claim_contact`;");
  }
}
