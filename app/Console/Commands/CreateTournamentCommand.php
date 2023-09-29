<?php

namespace App\Console\Commands;

use App\Models\Idea;
use App\Models\Tournament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateTournamentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-tournament-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create tournament command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('CreateTournamentCommand Started');

        $ideas = Idea::select(DB::raw('MIN(id) as min_id'))
                ->where('participated', false)
                ->groupBy('email')
                ->pluck('min_id')
                ->toArray();

        if (count($ideas) == 8) {
            Tournament::create([
                'ideas' => $ideas
            ]);

            Idea::whereIn('id', $ideas)->update([
                'participated' => true
            ]);

            Log::info('Created tournament with following ideas:: ', $ideas);
        }

        Log::info('CreateTournamentCommand Ended');
    }
}
