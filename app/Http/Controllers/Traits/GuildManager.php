<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Models\API;
use App\Models\Guild;
use App\Models\Category;
use App\Models\Event;
use App\Models\Page;
use App\Models\Lottery;
use App\Models\LotteryEntry;
use App\Models\LotteryHistory;
use App\Models\Contribute;
use App\Models\User;

trait GuildManager
{

    public function authenticateGuild() {
        $guild = Session::get('guild');
        $this->links = ["news", "pages", "events", "treasury", "lottery", "admin"];
        $this->guildId = $guild->guildId;
        $this->leaderId = $guild->leaderId;
        $this->guild = $guild;
    }

    public function createGuild($guild_id, $leader_id) {
        $guild = new Guild;
        $guild->guild_id = $guild_id;
        $guild->leader_id = $leader_id;
        $guild->save();
        return true;
    }

    public function searchGuild($name) {
        $guild_search = API::get('guild/search?name=' . urlencode($name));
        if(isset($guild_search[0]))
            return $guild_search[0];
        else
            return false;
    }

    public function getGuildInfo() {
        return Guild::where('guild_id', $this->guildId)->get();
    }

    /**
     * Pages
     *
     */

	public function getPageCategories() {
		return Category::where('guild_id', $this->guildId)->get();
	}

	public function getPages() {
		return Page::where('guild_id', $this->guildId)->get();
	}

	public function getPage($slug) {
    	$page = Page::where('slug', $slug)->where('guild_id', $this->guildId)->get();
    	return $page[0];
	}

	public function getNews() {
		$news = Page::where('guild_id', $this->guildId)->where('type_id', 1)->get();
		if(count($news) > 0) {
            foreach($news as &$page) {
                if (strlen($page->content) > 400) {
                    $page->content = substr($page->content, 0, 400) . '... <a href="' . $this->guild->base_link .'/pages/' . $page->id . '">Read More</a>';
                }
            }
			return $news;
		} else {
			return false;
		}
	}

    /**
     * Events
     *
     */
	public function getEvents() {
		return Event::where('guild_id', $this->guildId)->get();
	}

	public function getSpecificEvents($ids) {
		$events = [];
		$ids = explode(',', $ids);
		$end = end($ids);
		$key = key($ids);
		if($end == "") {
			unset($ids[$key]);
		}
		foreach($ids as $id) {
			array_push($events, Event::where('id', $id)->get());
		}
		return $events;
	}

	public function getEvent($id) {
		$event = Event::where('id', $id)->get();
		return $event[0];
	}

	public function getCalendarData($month, $year) {
    	function getDatePart($part, $section) {
			if($section == 0) {
				return date($part);
			} else {
				return $section;
			}
		}

		$days = array();
		$month = getDatePart('m', $month);
		$year = getDatePart('Y', $year);
		$dateParts = $year . '-' . $month . '-01';
		$date = new \DateTime($dateParts);
		$nextMonth = strtotime(date("Y-m-d", strtotime($dateParts)) . "+1 month");
		$prevMonth= strtotime(date("Y-m-d", strtotime($dateParts)) . "-1 month");

		for($d=1; $d<=31; $d++) {
		    $time = mktime(12, 0, 0, $month, $d, $year);
		    if (date('m', $time) == $month)
		        $days[] = date('Y-m-d', $time);
		}

		$data = (object) compact('date', 'days', 'nextMonth', 'prevMonth');
		return $data;
    }

    /**
     * Treasury
     *
     */

    public function getGuildTreasury() {
        $treasury = API::get('guild/' . $this->guildId . '/treasury', 'leader', $this->leaderId);
        $t = [];
        foreach($treasury as $upgrade) {
            $data = $this->getItemFromStorage($upgrade->item_id);
            $count = 0;
            foreach($upgrade->needed_by as $i) {
                $count += $i->count;
            }
            $upgrade->max = $count;
            $upgrade->have = 0;
            $upgrade->perc = $upgrade->count / $upgrade->max * 100;

            // Get percentage bar color
            if($upgrade->perc >= 0 && $upgrade->perc <= 30.99) {
                $upgrade->color = "red";
            } elseif ($upgrade->perc >= 31 && $upgrade->perc <= 50.99) {
                $upgrade->color = "orange";
            } elseif ($upgrade->perc >= 51 && $upgrade->perc <= 75.99) {
                $upgrade->color = "yellow";
            } elseif ($upgrade->perc >= 76 && $upgrade->perc <= 99.99) {
                $upgrade->color = "green";
            } elseif ($upgrade->perc == 100) {
                $upgrade->color = "dullgreen";
            }

            $arr = array_merge((array) $data, (array) $upgrade);
            array_push($t, $arr);
        }
        return $t;
    }

    public function getGuildLog($id = false, $guildId = false) {
        if(!$guildId) {
            $guildId = $this->guildId;
        }
        if($ctb = Contribute::where('guild_id', $guildId)->first()) {
            $cnt = json_decode($ctb->contributors, true);
            $cn = [];
            foreach($cnt as $k => &$c1) {
                $c1['count'] = 0;
                $c1['worth'] = 0;
                $c1['key'] = $k;
            }
            foreach($cnt as &$c2) {
                foreach($c2['items'] as &$t) {
                    $columns = array_column($t['deposits'], 'count');
                    $count = array_sum($columns);
                    $worth = $t['data']['tp_buy_price'] * $count;
                    $t['count'] = $count;
                    $t['worth'] = $worth;
                    $c2['count'] += $count;
                    $c2['worth'] += $worth;
                }
            }
            if($id !== false) {
                return $cnt[$id];
            } else {
                array_multisort(array_column($cnt, 'worth'), SORT_DESC, $cnt);
                return $cnt;
            }
        } else
            return false;
    }

    public function contributorsExist($guildId) {
        $data = Contribute::where('guild_id', $guildId)->get();
        if(!empty($data[0])) {
            return $data[0]['attributes'];
        } else
        return false;
    }

    public function getItemFromStorage($itemId, $tp = false) {
        $items = json_decode(Storage::get('items.cache'), true);
        dd($items);
        $columns = array_column($items, 'id');
        $key = array_search($itemId, $columns);
        $data = $items[$key];
        if($tp) {
            $price = API::get('commerce/prices/' . $itemId);
            if(is_object($price)) {
                $price = $price->buys->unit_price;
            } else {
                $price = 0;
            }
            $data['tp_buy_price'] = $price;
        }
        return $data;
    }

    public function getUpgradesFromStorage() {
        $upgrades = json_decode(Storage::get('upgrades.cache'), true);
        return $upgrades;
    }

	/**
     * Lottery
     *
     */

	public function getLottery($guildId = false) {
		if(!$guildId) {
     		$guildId = $this->guildId;
		}
		$lottery = Lottery::where('guild_id', $guildId)->get();
		if(count($lottery) > 0) {
			$lottery = $lottery[0];
			$lottery->entries = $this->getLotteryEntries($lottery->id);
			$lottery->history = $this->getLotteryHistory($lottery->id);
			return $lottery;
		} else
			return false;
	}

	public function getLotteryEntries($id) {
		$lottery = LotteryEntry::where('lottery_id', $id)->get();
		if(count($lottery) > 0)
			return $lottery;
		else
			return false;
	}

	public function getLotteryHistory($id) {
		$history = LotteryHistory::where('lottery_id', $id)->get();
		if(count($history) > 0)
			return $history;
		else
			return false;
	}

    /**
     * Users
     *
     */

	public function getUsers() {
		$users = API::get('guild/' . $this->guildId . '/members', 'leader', $this->leaderId);
        foreach($users as &$user) {
            if($user->rank == 'invited') {
                unset($user);
            }
        }
        usort($users, function($a, $b) {
            return $a->rank > $b->rank;
        });
		return $users;
	}

  public function getRanks() {
		$ranks = API::get('guild/' . $this->guildId . '/ranks', 'leader', $this->leaderId);
    usort($ranks, function($a, $b) {
        return $a->order - $b->order;
    });
    unset($ranks[0]);
		return $ranks;
	}

	public function getRegisteredUsers($option) {
		$users = [];
		foreach($this->getUsers() as $user) {
			$u = User::where('game_id', $user->name)->get();
			if(count($u) > 0) {
				$user->data = $u[0]['attributes'];
				if($option == 'only') array_push($users, $user);
			}
			$user->registered = count($u);
			if($option == 'all') array_push($users, $user);
		}
		return $users;
	}

	/**
     * Admin
     *
     */

	public function getGuildPermissions($id) {
		$admin = Admin::where('guild_id', $this->guildId)->where('user_id', $id)->get();
		if(count($admin) > 0)
			return $admin[0]['perm'];
		else
			return false;
	}

	public function getInviteCode() {
		$invite = Invite::where('guild_id', $this->guildId)->get();
		if(count($invite) > 0)
			return $invite[0]['code'];
		else
			return false;
	}
}
