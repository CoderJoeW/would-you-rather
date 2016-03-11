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
	
	private function getQuestion($type){
		$questions = $this->getConfig()->get($type);
		$draw = array_rand($questions);
		
		$question = $questions[$draw];
		return $question;
	}
	
	public function onCommand(CommandSender $sender,Command $command,$label,array $args){
		$cmd = $command->getName();
		if($cmd == "wyr"){
			if(!isset($args[0])){
				$sender->sendMessage("/wyr <type>");
				return;
			} else{
				switch($args[0]){
					case "help":
						$sender->sendMessage("Types:");
						$sender->sendMessage("children");
						$sender->sendMessage("adult");
						$sender->sendMessage("funny");
						$sender->sendMessage("hard");
					break;
					case "children":
						$getQuestion = $this->getQuestion("children-questions");
						$this->getServer()->broadcastMessage($getQuestion);
					break;
					case "adult":
						$getQuestion = $this->getQuestion("adult-questions");
						$this->getServer()->broadcastMessage($getQuestion);
					break;
					case "funny":
						$getQuestion = $this->getQuestion("funny-questions");
						$this->getServer()->broadcastMessage($getQuestion);
					break;
					case "hard":
						$getQuestion = $this->getQuestion("hard-questions");
						$this->getServer()->broadcastMessage($getQuestion);
					break;
				}
			}
		}
	}
}
?>
