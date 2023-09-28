<?php

namespace App\Console\Commands;

use App\Models\Idea;
use App\Models\Tournament;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RunTournamentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-tournament-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run tournament command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('RunTournamentCommand Started');

        $tournaments = Tournament::whereNull('winner')->get();

        foreach ($tournaments as $tournament) {

            if (empty($tournament->first_phase)) {
                $selectRand4 = collect($tournament->ideas)->random(4)->toArray();
                Tournament::find($tournament->id)->update([
                    'first_phase' => $selectRand4
                ]);
                $this->sendEmail($selectRand4, 'in the top 4');
                Log::info('Random 4 idea selecetd for tournament id:: '.$tournament->id);
                continue;
            }

            if (empty($tournament->second_phase)) {
                $selectRand2 = collect($tournament->first_phase)->random(2)->toArray();
                Tournament::find($tournament->id)->update([
                    'second_phase' => $selectRand2
                ]);
                $this->sendEmail($selectRand2, 'in the top 2');
                Log::info('Random 2 idea selecetd for tournament id:: '.$tournament->id);
                continue;
            }

            if (empty($tournament->winner)) {
                $winner = collect($tournament->second_phase)->random(1)->first();
                Tournament::find($tournament->id)->update([
                    'winner' => $winner
                ]);
                $this->sendEmail([$winner], 'the winner');
                Log::info('Winning idea selecetd for tournament id:: '.$tournament->id);
                continue;
            }
        }

        Log::info('RunTournamentCommand Ended');
    }

    private function sendEmail($ideas, $text) {

        $ideas = Idea::whereIn('id', $ideas)->get();

        foreach ($ideas as $idea) {
            Mail::send('emails.simple', ['name' => $idea->name, 'text' => $text], function($message) use ($idea) {
                $message->to($idea->email, $idea->name)
                    ->subject('Idea Tournament Notification');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
             });
        }
    }
}
