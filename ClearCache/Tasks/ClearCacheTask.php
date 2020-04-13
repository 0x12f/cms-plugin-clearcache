<?php

namespace Plugin\ClearCache\Tasks;

use App\Domain\Tasks\Task;

class ClearCacheTask extends Task
{
    public const TITLE = 'Очистка кеша';

    public function execute(array $params = []): \App\Domain\Entities\Task
    {
        $default = [];
        $params = array_merge($default, $params);

        return parent::execute($params);
    }

    protected function action(array $args = [])
    {
        $this->logger->info('ClearCache: remove cache files');
        @exec('rm -rf ' . CACHE_DIR . '/*');

        if ($this->getParameter('ClearCachePlugin_tasks', 'off') === 'on') {
            $this->logger->info('ClearCache: remove task data');
            $taskRepository = $this->entityManager->getRepository(\App\Domain\Entities\Task::class);

            foreach (
                $taskRepository->findBy([
                    'status' => [
                        \App\Domain\Types\TaskStatusType::STATUS_DONE,
                        \App\Domain\Types\TaskStatusType::STATUS_CANCEL,
                        \App\Domain\Types\TaskStatusType::STATUS_FAIL,
                    ],
                ]) as $model
            ) {
                $this->entityManager->remove($model);
            }

            $this->entityManager->flush();
        }

        if ($this->getParameter('ClearCachePlugin_notify', 'off') === 'on') {
            $this->logger->info('ClearCache: remove notify');
            $taskRepository = $this->entityManager->getRepository(\App\Domain\Entities\Notification::class);

            foreach ($taskRepository->findAll() as $model) {
                $this->entityManager->remove($model);
            }

            $this->entityManager->flush();
        }

        if ($this->getParameter('ClearCachePlugin_log', 'off') === 'on') {
            $this->logger->info('ClearCache: remove log files');
            @exec('rm -rf ' . LOG_DIR . '/*');
        }

        $this->setStatusDone();
    }
}
