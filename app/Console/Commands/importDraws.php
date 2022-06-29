<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LottoApi;

class importDraws extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'draw:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importowanie nowych losowań';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'http://www.mbnet.com.pl/dl_plus.txt';
        $datas = explode(PHP_EOL, file_get_contents($url));
        foreach ($datas as $data) {
            $data = explode(' ', $data);
            if(empty($data)) continue;

            $id = (int)rtrim($data[0], '.');
            if(!LottoApi::where('id', $id)->get()->isEmpty()) {
                continue;
            }
            if(!empty($data[1]) && !empty($data[2])) {
                LottoApi::create(['draw_date' => $data[1], 'numbers' => trim($data[2])]);
            }
        }
        return 0;
    }
}
