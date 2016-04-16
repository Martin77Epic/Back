<?php

namespace Back;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\Listener;
use pocketmine\level\Position;
use pocketmine\level\Level;

class Back extends PluginBase implements Listener{
 
	public $lastdeath = array();

	public function onEnable(){
		 
		$this->getLogger()->info("onEnable() has been called!");        			
		 
		$this->getServer()->getPluginManager()->registerEvents($this, $this); 
	}
	public function onDisable(){
		
			$this->getLogger()->info("onDisable() has been called!");        		
	}

	 	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch($command->getName()){
			case "Back":
				if($this->lastdeath[$sender->getName()] instanceof Position){
					
					$sender->teleport($this->lastdeath[$sender->getName()]);
					$sender->sendMessage("§f§8[Back] Teleported to your last Death Postion.");
					unset($this->lastdeath[$sender->getName()]);
				}else{
					$sender->sendMessage("§f§8[Back] You need this Command only in Survival Mode.");
				}
				break;
		}
	}

		public function onPlayerDeath(PlayerDeathEvent $event){	
		$player = $event->getEntity();
		$this->lastdeath[$player->getName()] = new Position(
			round($player->getX()),
			round($player->getY()),
			round($player->getZ()),
			$player->getLevel()
		);
	}
	
}