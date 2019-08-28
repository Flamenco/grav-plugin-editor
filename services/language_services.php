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

/**
 * Language Service API
 *
 * id
 * caption
 * icon
 * dependencies
 * TODO listDirs and listFiles() - currently hardcoded in plugin
 *
 */
{
    $grav = \Grav\Common\Grav::instance();
    $config = $grav['config'];
    $manager = \Twelvetone\Common\ServiceManager::getInstance();

    //TODO make sure we have the correction mode dependencies when all are not enabled.

    if ($config->get("plugins.editor.php_enabled", true)) {
        $manager->registerService("language", [
            "id" => "php",
            "caption" => "PHP",
            "icon" => "fa-php",
            "iconstyle" => "fa",
//            "iconstyle" => "fab",
            "dependencies" => ['plugin://editor/lib/codemirror/mode/clike/clike.js',
                'plugin://editor/lib/codemirror/mode/php/php.js'],
        ]);
    }

    if ($config->get("plugins.editor.js_enabled", true)) {
        $manager->registerService("language", [
            "id" => "js",
            "caption" => "Javascript",
            "icon" => "fa-file-code-o",
            "iconstyle" => "fa",
//            "icon" => "fa-js",
//            "iconstyle" => "fab",
            "dependencies" => ['plugin://editor/lib/codemirror/mode/javascript/javascript.js'],
        ]);
    }

    if ($config->get("plugins.editor.css_enabled", true)) {
        $manager->registerService("language", [
            "id" => "css",
            "caption" => "CSS",
            "icon" => "fa-css3",
            "iconstyle" => "fa",
//            "iconstyle" => "fab",
            "dependencies" => ['plugin://editor/lib/codemirror/mode/css/css.js'],
        ]);
    }

    if ($config->get("plugins.editor.twig_enabled", true)) {
        $manager->registerService("language", [
            "id" => "twig",
            "caption" => "Twig",
            "icon" => "fa-tree",
            "iconstyle" => "fa",
//            "icon" => "fa-symfony",
//            "iconstyle" => "fab",
            "dependencies" => [
                'plugin://editor/lib/codemirror/addons/overlay.js',
                'plugin://editor/lib/codemirror/mode/css/css.js',
                'plugin://editor/lib/codemirror/mode/clike/clike.js',
                'plugin://editor/lib/codemirror/mode/twig/twig.js',
                'plugin://editor/lib/codemirror/mode/htmlmixed/htmlmixed.js',
                'plugin://editor/lib/codemirror/mode/xml/xml.js',
                'plugin://editor/lib/codemirror/mode/javascript/javascript.js',
            ],
        ]);
    }

    if ($config->get("plugins.editor.markdown_enabled", true)) {
        $manager->registerService("language", [
            "id" => "md",
            "caption" => "Markdown",
            "icon" => "fa-hashtag",
            "iconstyle" => "fa",
//            "icon" => "fa-markdown",
//            "iconstyle" => "fab",
            "dependencies" => [
                'plugin://editor/lib/codemirror/addons/overlay.js',
                'plugin://editor/lib/codemirror/mode/css/css.js',
                'plugin://editor/lib/codemirror/mode/clike/clike.js',
                'plugin://editor/lib/codemirror/mode/htmlmixed/htmlmixed.js',
                'plugin://editor/lib/codemirror/mode/xml/xml.js',
                'plugin://editor/lib/codemirror/mode/javascript/javascript.js',
                'plugin://editor/lib/codemirror/mode/markdown/markdown.js',
                'plugin://editor/lib/codemirror/mode/gfm/gfm.js',
                'plugin://editor/lib/codemirror/mode/meta.js',
            ]
        ]);
    }

    if ($config->get("plugins.editor.yaml_enabled", true)) {
        $manager->registerService("language", [
            "id" => "yaml",
            "caption" => "YAML",
            "icon" => "fa-indent",
            'iconstyle' =>  'fa',
            "dependencies" => [
                "dependencies" => ['plugin://editor/lib/codemirror/mode/yacas/yacas.js'],
            ]
        ]);
    }
}

// Do this at the last possible moment to allow all languages to register.
{
    $manager = \Twelvetone\Common\ServiceManager::getInstance();
    $services = $manager->getServices("language");

    if (count($services) > 0) {
        $base = $grav['uri']->rootUrl(false) . '/' . trim($grav['admin']->base, '/');

        $items = [];
        $dependencies = [];
        foreach ($services as $service) {
            $serviceId = $service['id'];
            $items[] = [
                'caption' => $service['caption'],
                'href' => $base . "/editor/$serviceId",
                'icon' =>  $service['icon'] ?: 'fa-edit',
                'iconstyle' =>  $service['iconstyle']
            ];
            foreach ($service['dependencies'] as $dependency) {
                $dependencies[] = $dependency;
            }
        }

        $manager->registerService("action", [
            'render' => function () use (&$items) {
                $twig = \Grav\Common\Grav::instance()['twig'];
                $params = [
                    'caption' => "Edit",
                    'icon' => 'fa-edit',
                    'items' => $items,
                    'selected' => strpos(\Grav\Common\Grav::instance()['uri']->route(), "/editor/") != false
                ];
                    return $twig->processTemplate('partials/nav-dropdown-menu.html.twig', $params);
            },
            'scope' => ['admin:sidebar'],
            'order' => 'after:parent',
            'isSelected' => function ($context) {
                return strpos(\Grav\Common\Grav::instance()['uri']->route(), "/editor/") != false;
            },
        ]);
    }
}

// Ye old list

/**
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/mode/css/css.js') %}#}
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/mode/clike/clike.js') %}#}
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/mode/php/php.js') %}#}
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/mode/twig/twig.js') %}#}
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/mode/htmlmixed/htmlmixed.js') %}#}
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/mode/xml/xml.js') %}#}
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/mode/javascript/javascript.js') %}#}
 * {#{% do assets.addJs('plugin://editor/lib/codemirror/addons/overlay.js') %}#}
 */
