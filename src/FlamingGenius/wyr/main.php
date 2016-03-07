<?
namespace FlamingGenius\wyr;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class main extends PluginBase implements Listener{
	public function onEnable(){
		$this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
	}
	
	private function getQuestion(){
		$questions = $this->getConfig()->get("questions");
		$draw = array_rand($questions);
		
		$question = $questions[$draw];
		return $question;
	}
	
	public function onCommand(CommandSender $sender,Command $command,$label,array $args){
		$cmd = $command->getName();
		if($cmd === "wyr"){
			$this->getServer()->broadcastMessage($this->getQuestion());
		}
	}
}
?>
