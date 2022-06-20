<?php

namespace FakePlayer\Eventos;

use FakePlayer\Loader;

use pocketmine\{
 event\Event, 
 player\Player, 
 event\Listener as Events,  
 event\player\PlayerChatEvent, 
};

class Listener implements Events {
 
 private $plugin;
 
 public function __construct($plugin) {
  $this->plugin = $plugin;
 }
 
 public function onChat(PlayerChatEvent $event) {
  $player = $event->getPlayer();
  $xuid = $player->getXuid();
  $message = $event->getMessage();  
  if($this->plugin->iFake("has", "$xuid") == true){
   $name = $this->plugin->iFake("get", "$xuid");
   $message = "§e{$name}: §7{$message}";
  }else{
   $message = "§e{$player->getName()}: §7{$message}";
  }
  $event->setFormat($message); 
 }
 
}
