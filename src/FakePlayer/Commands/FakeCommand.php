<?php
namespace FakePlayer\Commands;

use FakePlayer\Loader;

use pocketmine\plugin\{
 Plugin, 
 PluginOwned
};
use pocketmine\command\{
  Command,
  PluginCommand,
  CommandSender
};
use pocketmine\{
 utils\Config,
 player\Player, 
};

class FakeCommand extends Command { 
 
 public array $username = ["literateyet", "advocatecan", "chokehandle", "yeastdevice", "erraticunsteady", "rapidfatso", "pureforecast", "finishcarefully", "dealerscoreboard", "grainsimply", "evilprotect","innerkris", "pebblechutney", "teapainter", "embracelesson", "paltrystriking", "tangydream", "solverelevant", "runphoto", "bushshine", "overtestimony", "postulatesdraught", "peacetennis", "rainbowchemical", "goujonsever", "pantheonpeople", "tranquilproposed", "boardask", "surepepsi", "wastesdeltas", "parkarope", "mindevaluate", "squelchresolved", "affinityencounter", "naturallypast", "prayernescafe", "oblongatacharge", "flightglad", "physicallypaper", "businessdopping", "aukgymnastics", "appleturn", "holedick", "mourningsoup"];
 
 public function __construct(){
  parent::__construct('fake', '§7Ative o modo anonimo!');
 } 
 
 public function execute(CommandSender $player, string $commandLabel, array $args): bool{
  
  $plugin = Loader::getInstance();
  $player = $plugin->getServer()->getPlayerExact($player->getName());
  $xuid = $player->getXuid();
  $config = $plugin->getConfig();
  
  if($player instanceof Player){
   if($player->hasPermission($config->get("permission.use"))){
    if(isset($args[0])){
     $state = strtolower($args[0]);
     switch ($state) {
      case "on":
       if(isset(args[1])){
        $nametag = $args[1];
       }else{
        $id = mt_rand(0, count($this->username));
        $nametag = $this->username[$id];
       }
       if($plugin->iFake("has", "$xuid") == false){
        $player->setNameTag($nametag);
        $plugin->iFake("set", "$xuid", $nametag);
        $player->sendMessage(str_replace("{fake}", $nametag, $config->get("fake.on.sucess")));
       }else{
        $player->sendMessage($config->get("fake.on.hasenable"));
       }
       break;
      case "off":
       if($plugin->iFake("has", "$xuid") == true){
        $plugin->iFake("unset", "$xuid");
        $player->sendMessage($config->get("fake.off.sucess"));
       } else {
        $player->sendMessage($config->get("fake.off.hasdisable"));
       } 
       break;
     }
    }else{
     $player->sendMessage($config->get("fake.help") );
    }
   }else{
    $player->sendMessage($config->get("fake.nopermission"));
   }
  }else{
   $plugin->getLogger()->critical("Comando fake permitido apenas dentro do servidor!");
  }
  return true;
 }
}
 
