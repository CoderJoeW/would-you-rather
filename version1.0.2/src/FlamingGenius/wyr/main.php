<?
namespace FlamingGenius\wyr;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;\
use pocketmine\utils\Config;
use pocketmine\tile\Sign;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\Event;
use pocketmine\event\Player\PlayerInteractEvent;

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
	
	private function signQuestion(SignChangeEvent $event){
		if($event->getBlock()->getId() == 68 || $event->getBlock()->getId() == 63){
			$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
			$sign = $event->getLines();
			if($sign[1] === "Children"){
				$msg = $this->getQuestion("children-questions");
				$this->getServer()->broadcastMessage($msg);
			} elseif($sign[1] === "Adult"){
				$msg = $this->getQuestion("adult-questions");
				$this->getServer()->broadcastMessage($msg);
			} elseif($sign[1] === "Funny"){
				$msg = $this->getQuestion("funny-questions");
				$this->getServer()->broadcastMessage($msg);
			} elseif($sign[1] === "Hard"){
				$msg = $this->getQuestion("hard-questions");
				$this->getServer()->broadcastMessage($msg);
			}
		}
	}
	
	public function onSignCreate(SignChangeEvent $event){
		if($event->getBlock()->getId() == 68 || $event->getBlock()->getId() == 63){
			$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
			$sign = $event->getLines();
			if($sign[0] === "[WYR]"){
				if($sign[1] === "children"){
					$event->setLines(0,"[WYR]");
					$event->setLines(1,"Children");
				} elseif($sign[1] === "adult"){
					$event->setLines(0,"[WYR]");
					$event->setLines(1,"Adult");
				} elseif($sign[1] === "funny"){
					$event->setLines(0,"[WYR]");
					$event->setLines(1,"Funny");
				} elseif($sign[1] === "hard"){
					$event->setLines(0,"[WYR]");
					$event->setLines(1,"Hard");
				}
			}
		}
	}
	
	public function onSignTouch(PlayerInteractEvent $event){
		$event->signQuestion();
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
