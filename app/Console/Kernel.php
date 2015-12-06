<?php

namespace App\Console;

use App\Auction;
use App\Bets;
use App\Bidders;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        
         $schedule->call(function()
        {
            // Ищем аукционы, дата завершения которых подошла к концу
            $auctionsEnd = Auction::where('date_end', '=', Carbon::parse(Carbon::now())->format('Y-m-d H:i'))->where('status', '=', 3)->with('bidders')->get();

            // Если такие аукционы есть
            if($auctionsEnd->count() > 0) {

                foreach ($auctionsEnd as $auction) {

                    // Данные пользователя создавшего аукцион
                    $user = User::find($auction->user);

                    // Определяем победителя по наибольшей ставке
                    $win = Bets::where('auction_id', '=', $auction->id)->orderBy('created_at', 'desc')->first();

                    // Помещаем аукцион в Архив
                    $auction->in_archive = 1;

                    /*
                     * Если победитель есть
                     */
                    if($win) {

                        // Загружаем информацию о победителе
                        $win_user = User::find($win->user_id);

                        // Присваиваем участнику статус "Победитель"
                        $win_status = Bidders::where('auction_id', '=', $auction->id)->where('user_id', '=', $win->user_id)->first();
                        $win_status->status = 2;
                        $win_status->save();

                        // Смена статуса на "Торги відбулися"
                        $auction->status = 7;
                        $auction->final_price = $win->bet; // Окончательная цена
                        $auction->save();

                        // Отправка письма создателю аукциона
                        Mail::queue('emails.auction-end', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'middle_name' => $user->middle_name, 'auction_id' => $auction->id, 'auction_title' => $auction->title, 'auction_cyr' =>  $auction->currency,'auction_status' => 7,
                            'win_first_name' => $win_user->first_name,
                            'win_last_name' => $win_user->last_name,
                            'win_middle_name' => $win_user->middle_name,
                            'win_email' => $win_user->email,
                            'win_phone' => $win_user->phone,
                            'win_cost' => $win->bet
                        ], function($message) use ($user)
                        {
                            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Аукціон завершено');
                        });

                        // Отправка письма победителю аукциона
                        Mail::queue('emails.auction-end-winner', ['first_name' => $win_user->first_name, 'last_name' => $win_user->last_name, 'auction_id' => $auction->id, 'auction_title' => $auction->title, 'auction_cyr' =>  $auction->currency, 'auction_status' => 7,
                            'win_cost' => $win->bet
                        ], function($message) use ($win_user)
                        {
                            $message->to($win_user->email, $win_user->first_name . ' ' . $win_user->last_name)->subject('Аукціон завершено');
                        });

                        // Отправка письма администратору
                        $adminEmail = Config::get('app.admin_email');
                        Mail::queue('emails.auction-end-admin', ['auction_id' => $auction->id, 'auction_title' => $auction->title, 'auction_status' => 7, 'auction_cyr' =>  $auction->currency,
                            'win_first_name' => $win_user->first_name,
                            'win_last_name' => $win_user->last_name,
                            'win_middle_name' => $win_user->middle_name,
                            'win_email' => $win_user->email,
                            'win_phone' => $win_user->phone,
                            'win_cost' => $win->bet
                        ], function($message) use ($adminEmail)
                        {
                            $message->to($adminEmail)->subject('Аукціон завершено');
                        });

                    } else {

                        $auction->status = 8; // Смена статуса на "Торги не відбулися"
                        $auction->save();

                        // Отправка письма создателю аукциона
                        Mail::queue('emails.auction-end', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'middle_name' => $user->middle_name, 'auction_id' => $auction->id, 'auction_title' => $auction->title, 'auction_status' => 8], function($message) use ($user)
                        {
                            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Аукціон завершено');
                        });

                        // Отправка письма администратору
                        $adminEmail = Config::get('app.admin_email');
                        Mail::queue('emails.auction-end-admin', ['auction_id' => $auction->id, 'auction_title' => $auction->title, 'auction_status' => 8], function($message) use ($adminEmail)
                        {
                            $message->to($adminEmail)->subject('Аукціон завершено');
                        });

                    }
                }
            }

        })->everyMinute();


        $schedule->call(function()
        {
            // Ищем аукционы, которые должны начаться
            $auctions = Auction::where('data_start', '=', Carbon::parse(Carbon::now())->format('Y-m-d H:i'))->where('status', '=', 2)->with('bidders')->get();

            // Если количество аукционов больше нуля, выполняем скрипт
            if($auctions->count() > 0) {

                foreach ($auctions as $auction) {
                    $user = User::find($auction->user); // Информация о создателе аукциона
                    // Если к началу аукциона есть участники - выполняем
                    if($auction->bidders->count() > 0) {
                        $array[$auction->id] = [];
                        $bid = [];

                        $auction->status = 3;
                        $auction->save();

                        foreach($auction->bidders as $bidder) {
                            // Если статус участника "Допущено"
                            if($bidder->status == 1) {
                                $array[$auction->id] = array_add($array[$auction->id], 'id', $auction->id);
                                $array[$auction->id] = array_add($array[$auction->id], 'title', $auction->title);
                                array_push($bid, $bidder->user_id);
                            }
                        }

                        $array[$auction->id] = array_add($array[$auction->id], 'bidders', $bid);

                        // Получаем доступ к информации о каждом участнике
                        $users[$auction->id] = User::find($array[$auction->id]['bidders']);

                        foreach($users[$auction->id] as $user)
                        {
                            Mail::queue('emails.auctionstart', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'auction_id' => $auction->id, 'auction_title' => $auction->title], function($message) use ($user)
                            {
                                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Розпочато аукціон');
                            });
                        }
                    } else {
                        $auction->status = 8; // Смена статуса на "Торги не відбулися"
                        $auction->in_archive = 1; // Помещаем аукцион в Архив
                        $auction->save();

                        // Отправка письма создателю аукциона
                        Mail::queue('emails.auction-end', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'middle_name' => $user->middle_name, 'auction_id' => $auction->id, 'auction_title' => $auction->title, 'auction_status' => 8], function($message) use ($user)
                        {
                            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Аукціон завершено');
                        });

                        // Отправка письма администратору
                        $adminEmail = Config::get('app.admin_email');
                        Mail::queue('emails.auction-end-admin', ['auction_id' => $auction->id, 'auction_title' => $auction->title, 'auction_status' => 8], function($message) use ($adminEmail)
                        {
                            $message->to($adminEmail)->subject('Аукціон завершено');
                        });
                    }


                }

           }

        })->everyMinute();

        $schedule->call(function()
        {
            // Ищем аукционы, которые должны начаться через 10 минут
            $auctions = Auction::where('data_start', '=', Carbon::parse(Carbon::now())->addMinutes(10)->format('Y-m-d H:i'))->where('status', '=', 2)->with('bidders')->get();

            // Если количество аукционов больше нуля, выполняем скрипт
            if($auctions->count() > 0) {

                foreach ($auctions as $auction) {
                    // Если к началу аукциона есть участники - выполняем
                    if($auction->bidders->count() > 0) {
                        $array[$auction->id] = [];
                        $bid = [];

                        foreach($auction->bidders as $bidder) {
                            // Если статус участника "Допущено"
                            if($bidder->status == 1) {
                                $array[$auction->id] = array_add($array[$auction->id], 'id', $auction->id);
                                $array[$auction->id] = array_add($array[$auction->id], 'title', $auction->title);
                                array_push($bid, $bidder->user_id);
                            }
                        }

                        $array[$auction->id] = array_add($array[$auction->id], 'bidders', $bid);

                        // Получаем доступ к информации о каждом участнике
                        $users[$auction->id] = User::find($array[$auction->id]['bidders']);

                        foreach($users[$auction->id] as $user)
                        {
                            Mail::queue('emails.auctionstart10', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'auction_id' => $auction->id, 'auction_title' => $auction->title], function($message) use ($user)
                            {
                                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Аукціон розпочнеться через 10 хвилин');
                            });
                        }

                        $user = User::find($auction->user); // Информация о создателе аукциона

                        // Отправка письму о начале через 10 минут создателю аукциона
                        Mail::queue('emails.auctionstart10creator', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'auction_id' => $auction->id, 'auction_title' => $auction->title], function($message) use ($user)
                        {
                                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Ваш аукціон розпочнеться через 10 хвилин');
                        });
                        
                    }

                }

           }

        })->everyMinute();

        /*
         * Ежедневная проверка курса доллара и евро
         * В случае несовпадения курса банка с курсом на сайте - курс изменяется
         */
        $schedule->call(function () {
            $currentUSD = \App\Settings::where(['name' => 'usd_cyr'])->first(); // Текущий курс доллара
            $currentEUR = \App\Settings::where(['name' => 'eur_cyr'])->first(); // Текущий курс евро
            $currentUSDval = $currentUSD->value;
            $currentEURval = $currentEUR->value;

            $get_currency = 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11';
            $currency = file_get_contents($get_currency);
            $currency = json_decode($currency);
            $newCurrencyUSD = number_format($currency[0]->sale, 2, '.', ' '); // Новый курс доллара
            $newCurrencyEUR = number_format($currency[1]->sale, 2, '.', ' '); // Новый курс евро

            if($currentUSDval != $newCurrencyUSD) {
                $currentUSD->value = $newCurrencyUSD;
                $currentUSD->save();
            }

            if($currentEURval != $newCurrencyEUR) {
                $currentEUR->value = $newCurrencyEUR;
                $currentEUR->save();
            }
        })->daily();
}
}