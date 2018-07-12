<?php

namespace App\Jobs;

use App\Admin\GitUsers\SeedData;
use App\GitUser;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class SeedGithubUsers
 * @package App\Jobs
 */
class SeedGithubUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var SeedData
     */
    private $seed_data;

    /**
     * Create a new job instance.
     *
     * @param SeedData $seed_data
     */
    public function __construct(SeedData $seed_data)
    {
        $this->seed_data = $seed_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = (new Client)->get(
            'https://api.github.com/users',
            [
                $this->getAuthCredentials(),
                'query' => [
                    'since'    => $this->seed_data->getSince(),
                    'per_page' => $this->seed_data->getPerPage(),
                ]
            ]
        )
            ->getBody();

        (new Collection(json_decode($users, true)))
            ->each(function ($github_user) {
                if (!$this->seed_data->canGoFurther()) {
                    return;
                }

                DB::beginTransaction();

                try {
                    GitUser::updateOrCreate(
                        ['github_user_id' => $github_user['id']],
                        [
                            'node_id'    => $github_user['node_id'],
                            'login'      => $github_user['login'],
                            'image_path' => $this->getImageByLink(
                                $github_user['avatar_url'],
                                'public/avatars/'
                            ),
                            'url'        => $github_user['url']
                        ]
                    );

                    DB::commit();

                    $this->seed_data->incrementSince();
                } catch (\Exception $exception) {
                    DB::rollBack();
                }
            });

        if ($this->seed_data->canGoFurther()) {
            $this->nextStep();

            return;
        }

        resolve('helper')->modifySeedQueueStatus(false);
    }

    /**
     * @return array
     */
    private function getAuthCredentials()
    {
        $auth = [];

        if (env('GITHUB_USERNAME')) {
            $auth = [
                'auth' => [
                    env('GITHUB_USERNAME'),
                    env('GITHUB_PASSWORD')
                ]
            ];
        }

        return $auth;
    }

    /**
     * @param $path
     * @param string $base_path
     * @return null|string
     */
    private function getImageByLink($path, $base_path = '')
    {
        $image_parse = parse_url($path);

        $file_name = substr($image_parse['path'], strripos($image_parse['path'], '/') + 1);

        $current_path = $base_path . hash('md5', $file_name) . '.jpg';

        $is_save_success = \Storage::put($current_path, file_get_contents($path));

        return $is_save_success ? \Storage::url($current_path) : null;
    }

    /**
     * Checking for run next step or die.
     */
    public function nextStep()
    {
        self::dispatch($this->seed_data);
    }
}
