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
//
// Editor Actions
//

$admin_base = $this->grav['uri']->rootUrl(false) . '/' . trim($this->grav['admin']->base, '/');


$langs = $manager->getServices('language');
foreach ($langs as $lang) {
    $icon = $lang['icon'];
    $id = $lang['id'];
    $caption = $lang['caption'];
    $manager->registerService("renderer", [
        "caption" => $caption,
        "scope" => ["editor-list"],
        "order" => "last",
        "render" => function () use ($admin_base, $icon, $id, $caption) {
            $active = basename(\Grav\Common\Grav::instance()['uri']->path()) === $id ? "active" : "";
            return "<a class='button $active' href='$admin_base/editor/$id'; return false;'><i class='fa $icon'></i>$caption</a>";
        },
    ]);
}

$manager->registerService("renderer", [
    "caption" => "Refresh",
    "scope" => ["editor-list"],
    "order" => "last",
    "render" => function () use ($admin_base) {
        return "<a class='button' onclick='window.location.reload(); return false;'><i class='fa fa-refresh'></i>Refresh</a>";
    },
]);
