<?php declare(strict_types=1);

namespace Plugin\ClearCache\Tasks;

use App\Domain\AbstractTask;
use App\Domain\Service\Task\TaskService;
use App\Domain\Casts\Task\Status as TaskStatus;

class ClearCacheTask extends AbstractTask
{
    public const TITLE = 'Очистка кеша';

    public function execute(array $params = []): \App\Domain\Models\Task
    {
        $default = [];
        $params = array_merge($default, $params);

        return parent::execute($params);
    }

    protected function action(array $args = []): void
    {
        $this->logger->info('ClearCache: remove cache files');
        @exec('rm -rf ' . CACHE_DIR . '/*');

        if ($this->parameter('ClearCachePlugin_tasks', 'off') === 'on') {
            $this->logger->info('ClearCache: remove task data');
            $taskService= $this->container->get(TaskService::class);

            foreach (
                $taskService->read([
                    'status' => [
                        TaskStatus::DONE,
                        TaskStatus::CANCEL,
                        TaskStatus::FAIL,
                        TaskStatus::DELETE,
                    ],
                ]) as $model
            ) {
                $taskService->delete($model);
            }
        }

        if ($this->parameter('ClearCachePlugin_log', 'off') === 'on') {
            $this->logger->info('ClearCache: remove log files');
            @exec('rm -rf ' . LOG_DIR . '/*');
        }

        if ($this->parameter('ClearCachePlugin_search', 'off') === 'on') {
            $this->logger->info('ClearCache: update search index');

            $task = new \App\Domain\Tasks\SearchIndexTask($this->container);
            $task->execute();
            \App\Domain\AbstractTask::worker($task);
        }

        $this->setStatusDone();
    }
}
