<?php declare(strict_types=1);

namespace Plugin\ClearCache;

use App\Domain\AbstractPlugin;
use Psr\Container\ContainerInterface;

class ClearCachePlugin extends AbstractPlugin
{
    const NAME = 'ClearCachePlugin';
    const TITLE = 'Очистка кеш данных';
    const DESCRIPTION = 'Плагин для очистки кеш данных';
    const AUTHOR = 'Aleksey Ilyin';
    const AUTHOR_SITE = 'https://getwebspace.org';
    const VERSION = '2.2.1';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->setTemplateFolder(__DIR__ . '/templates');
        $this->addToolbarItem(['twig' => 'actions.twig']);

        $this->addSettingsField([
            'label' => 'Задачи',
            'description' => 'Включить в чистку информацию о выполненных задачах',
            'type' => 'select',
            'name' => 'tasks',
            'args' => [
                'option' => [
                    'off' => 'Выключена',
                    'on' => 'Включена',
                ],
            ],
        ]);
        $this->addSettingsField([
            'label' => 'Уведомления',
            'description' => 'Включить в чистку старые уведомления',
            'type' => 'select',
            'name' => 'notify',
            'args' => [
                'option' => [
                    'off' => 'Выключена',
                    'on' => 'Включена',
                ],
            ],
        ]);
        $this->addSettingsField([
            'label' => 'Логи',
            'description' => 'Включить в чистку лог файлы',
            'type' => 'select',
            'name' => 'log',
            'args' => [
                'option' => [
                    'off' => 'Выключена',
                    'on' => 'Включена',
                ],
            ],
        ]);
        $this->addSettingsField([
            'label' => 'Обновлять поисковый индекс',
            'description' => 'Включить чтобы обновить индекс после очистки',
            'type' => 'select',
            'name' => 'search',
            'args' => [
                'option' => [
                    'off' => 'Выключена',
                    'on' => 'Включена',
                ],
            ],
        ]);
    }
}
