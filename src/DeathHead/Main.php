<?php

namespace DeathHead;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item;
use onebone\economyapi\EconomyAPI;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->saveDefaultConfig();
$config = $this->getConfig();
$this->getServer()->getLogger()->info(TextFormat::BLUE."[DeathHead] DeathHead has been enabled!");
$this->getServer()->getLogger()->info(TextFormat::BLUE."[DeathHead] Created by ItzBulkDev. Helped by SavionLegendZzz and MinecrafterPH");
$this->money = EconomyAPI::getInstance();
if (!$this->money) {
	$this->getLogger()->info(TextFormat::BLUE. "[DeathHead]" . TextFormat::RED . "Unable to find EconomyAPI.");
	return true;
	}
}

public function onDeath(PlayerDeathEvent $event){
$config = $this->getConfig();
  $cause = $event->getEntity()->getLastDamageCause();
        if($cause instanceof EntityDamageByEntityEvent) {
            $player = $event->getEntity();
            $killer = $event->getEntity()->getLastDamageCause()->getDamager();
            $paid = $config->get("paid-amount");
            $lost = $config->get("lost-amount");
            $popups = $config->get("Enable-Popups")
            $enabled = $config->get("Enable-Money");
            if($killer instanceof Player and $enabled == true and $popups == true) {
$killer->getInventory()->setItemInHand(Item::get(144:3, 0, 1));
$killer->getInventory()->getItemInHand()->setCustomName(TextFormat::LIGHT_PURPLE."" . $player->getName() ."'s Head");
                $killer->sendPopup(TextFormat::GREEN."You earn $" . $paid . " for killing" . $player->getPlayer()->getName() . ".");
                    
		$player->sendMessage(TextFormat::RED."You lose $" . $lost . " for getting killed by" . $killer->getPlayer()->getName(). ".");
		
		$this->money->addMoney($killer, $paid);
                $this->money->reduceMoney($player, $lost);
                }
        }
}
}
