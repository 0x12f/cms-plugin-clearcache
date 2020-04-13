<?php

namespace Plugin\ClearCache;

use App\Application\Plugin;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ClearCachePlugin extends Plugin
{
    const NAME = 'ClearCachePlugin';
    const TITLE = 'ClearCache';
    const DESCRIPTION = 'Плагин для очистки кеш данных';
    const AUTHOR = 'Aleksey Ilyin';
    const AUTHOR_SITE = 'https://site.0x12f.com';

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
    }

    /** @inheritDoc */
    public function before(Request $request, Response $response, string $routeName): Response
    {
        return $response;
    }

    /** @inheritDoc */
    public function after(Request $request, Response $response, string $routeName): Response
    {
        return $response;
    }
}
