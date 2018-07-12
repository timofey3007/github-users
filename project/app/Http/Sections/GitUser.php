<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Form\FormElements;

/**
 * Class GitUser
 *
 * @property \App\GitUser $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class GitUser extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = \AdminDisplay::table();

        $display->setColumns([
            \AdminColumn::image('image_path', 'Avatar')->setWidth('100px'),
            \AdminColumn::text('node_id', 'Github node'),
            \AdminColumn::text('login', 'Login'),
        ]);

        $seed_form = new FormElements([
            '<a href="/seed" 
                style="' . (resolve('helper')->seedingIsRunning() ? 'pointer-events: none' : '') . '"
                class="btn btn-primary">Seed github users</a>'
        ]);

        $tabs = \AdminDisplay::tabbed();

        $tabs->appendTab(
            $display,
            'Github users'
        );

        $tabs->appendTab(
            $seed_form,
            'Seed 1000 user from github'
        );


        return $tabs;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = \AdminForm::panel()
            ->addBody([
                \AdminFormElement::text('login', 'Login')->required(),
                \AdminFormElement::image('image_path', 'User avatar'),
                \AdminFormElement::text('node_id', 'Github node')->required(),
                \AdminFormElement::text('url', 'Url')->required(),
                \AdminFormElement::text('github_user_id', 'Github user id')->required(),
                \AdminFormElement::textarea('description', 'Description'),
            ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
