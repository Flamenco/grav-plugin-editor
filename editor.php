<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2018 TwelveTone LLC
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Grav\Plugin;

require_once "classes/GravUtil.php";

use Grav\Common\Page\Page;
use Grav\Common\Plugin;
use Twelvetone\Common\ServiceManager;

/**
 * Class CSSEditorPlugin
 * @package Grav\Plugin
 */
class EditorPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }

    public function onAdminTwigTemplatePaths($event)
    {
        $manager = ServiceManager::getInstance();

        require_once "services/language_services.php";
        include "services/file_actions.php";
        include "services/file_actions_test.php";
        include "services/list_actions.php";

        $event['paths'] = array_merge($event['paths'], [__DIR__ . '/admin/templates']);
        return $event;
    }

    public function onPageNotFound($e)
    {
        if (!$this->isAdmin()) {
            return false;
        }

        $route = $this->grav['admin']->location . "/" . $this->grav['admin']->route;

        switch ($route) {
            case "editor/js":
            case "editor/css":
            case "editor/php":
            case "editor/twig":
            case "editor/md":
            case "editor/yaml":

                $type = str_replace("editor/", "", $route);
                $page = new Page;
                $path = __DIR__ . "/admin/editor-pages/editor-list-$type.md";
                $page->init(new \SplFileInfo($path));
                $page->template('editor-list');
                $page->slug(basename($route));

                $e->page = $page;
                $e->stopPropagation();
                break;

            case "editor/edit":

                //$uri = $this->$_POST['uri'];
                //BUG 'page' does not work as query parameter name

                if (!isset($_GET['target'])) {
                    $this->grav->redirect("/editor");
                    return "";
                }
                $pageToEdit = $_GET['target'];

//                if (!$pageToEdit) {
//                    $this->grav->redirect("/editor");
//                    return "";
//                }

                if (!is_file($pageToEdit)) {
                    return "<div>The file you have selected to edit was not found.</div>";
                }

                if (!isset($_GET['language'])) {
                    $this->grav->redirect("/editor");
                    return "";
                }

                $this->grav['twig']->twig_vars['pageToEdit'] = $route;
                $page = new Page;
                $path = __DIR__ . "/admin/editor-pages/editor-edit.md";
                $page->init(new \SplFileInfo($path));
                $page->template('editor2');
                $page->slug(basename($route));

                $e->page = $page;
                $e->stopPropagation();
                break;

            case "editor/action":
                $page = new Page;
                $path = __DIR__ . '/admin/editor-pages/editor-action.md';
                $page->init(new \SplFileInfo($path));
//                $page->template('empty');
                $page->slug(basename($route));

                $e->page = $page;
                $e->stopPropagation();
                break;

            default:
                break;
        }
    }

//    public function onAdminMenu()
//    {
//        // The editor CSS is loaded from the twigs.
//        // Also see https://github.com/Flamenco/grav-plugin-core-service-manager/issues/4#issuecomment-386111807
//        $manager = ServiceManager::getInstance();
//
//        $manager->registerService('asset', [
//            'scope' => ['all'],
//            'order' => 'last',
//            'type' => 'css',
//            'url' => 'plugin://editor/assets/editor.css'
//        ]);
//    }

    public function onTwigExtensions()
    {
        require_once(__DIR__ . '/twig/twig-extensions.php');
        $this->grav['twig']->twig->addExtension(new CssEditorTwigExtensions($this->grav));
    }

    public function onPagesInitialized()
    {
        if ($this->isAdmin()) {
            return;
        }

    }

    public function onPluginsInitialized()
    {
        if (!$this->isAdmin()) {
            return;
        }

		if (!$this->grav['core-service-util']->checkPluginDependencies($this)) {
            return;
        }

		$this->grav['core-service-util']->checkAllPluginDependencies();

        $this->enable([
            'onTwigExtensions' => ['onTwigExtensions', 0],
//            'onAdminMenu' => ['onAdminMenu', 0],
            'onAdminTwigTemplatePaths' => ['onAdminTwigTemplatePaths', 0],
            'onPageNotFound' => ['onPageNotFound', 1],
            'onPagesInitialized' => ['onPagesInitialized', 0],
        ]);
    }
}
