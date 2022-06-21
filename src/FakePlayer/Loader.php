<?php

namespace FakePlayer;

use FakePlayer\{
 Eventos\Listener, 
 Commands\FakeCommand, 
};

use pocketmine\{
 Server, 
 utils\Config,
 player\Player, 
 plugin\Plugin,
 plugin\PluginBase, 
 utils\TextFormat as C, 
};

class Loader extends PluginBase {
 
 public $fake = array();
 
 public static $instance = null;
 
 public static function getInstance() : Loader {
		return self::$instance;
	}
 
 public function onEnable() : void {
  self::$instance = $this;
  $this->getCommands();
  $this->getConfig()->get("permission.use") ;
  $this->getLogger()->info(C::GREEN . "Plugin FakePlayer ativado!");
 }
 
 public function onDisable() : void {
  $this->getLogger()->info(C::RED . "Plugin FakePlayer desativado!");
 }
 
 public function getListener() {
  $manager = $this->getServer()->getPluginManager();
  $manager->registerEvents(new Listener($this), $this); 
 }
 
 public function getCommands() {
  $map = $this->getServer()->getCommandMap();
		$map->register("fake", new FakeCommand());  
 }
 
 public function iFake($function, $xuid, $nametag = "null"){
  switch ($function) {
   case "get":
    $this->getLogger()->notice("get ({$xuid} => {$this->fake[$xuid]})!");
    return $this->fake["$xuid"];
    break;
   case "set":
    $this->getLogger()->notice("set ({$nametag})!");
    $this->fake["$xuid"] = $nametag;
    break;
   case "unset":
    $this->getLogger()->notice("unset ({$xuid})!");
    unset($this->fake["$xuid"]);
    break;
   case "has":
    $this->getLogger()->notice("check => ({$xuid})!");
    if(isset($this->fake["$xuid"])){
     $this->getLogger()->notice("check => ({$xuid}) in true!");
     return true; 
    }else{
     $this->getLogger()->notice("check => ({$xuid}) in false!");
     return false;
    }
    break;
  }
 }
 
}
