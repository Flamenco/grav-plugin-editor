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

$twig = $this->grav['twig'];
$manager->registerService("renderer", [
    "caption" => "Fullscreen",
    "scope" => ["editor"],
    "order" => "first",
    "render" => function () use ($twig) {
        return $twig->processTemplate("fullscreen.html.twig", ["targetSelector" => ".editor"]);
    },
]);

$manager->registerService("renderer", [
    "caption" => "Back",
    "scope" => ["editor"],
    "order" => "first",
    "render" => function ($context) use ($twig) {
        return '<a class="button" onclick="window.history.back()"><i class="fa fa-reply"></i>Back</a>';
    }
]);

$manager->registerService("renderer", [
    "caption" => "Save",
    "scope" => ["editor"],
    "order" => "last",
    "render" => function () {
        return "<a class='button' onclick='_doSave(); return false;'><i class='fa fa-save'></i>Save</a>";
    },
]);

$manager->registerService("renderer", [
    "caption" => "Rename",
    "scope" => ["editor"],
    "order" => "after:parent",
    "render" => function () {
        return "<a class='button' onclick='_doRename(); return false;'><i class='fa fa-wrench'></i>Rename</a>";
    },
]);

$manager->registerService("renderer", [
    "caption" => "Move",
    "scope" => ["editor"],
    "order" => "after:parent",
    "render" => function () {
        return "<a class='button' onclick='_doMove(); return false;'><i class='fa fa-plane'></i>Move</a>";
    },
]);

$manager->registerService("renderer", [
    "caption" => "Copy",
    "scope" => ["editor"],
    "order" => "after:parent",
    "render" => function () {
        return "<a class='button' onclick='_doCopy(); return false;'><i class='fa fa-copy'></i>Copy</a>";
    },
]);

$manager->registerService("renderer", [
    "caption" => "Create",
    "scope" => ["editor"],
    "order" => "after:parent",
    "render" => function () {
        return "<a class='button' onclick='_doCreate(); return false;'><i class='fa fa-plus'></i>Create</a>";
    },
]);

$manager->registerService("renderer", [
    "caption" => "Delete",
    "scope" => ["editor"],
    "order" => "last",
    "render" => function () {
        return "<a class='button' onclick='_doConfirm(_doDelete); return false;'><i class='fa fa-trash'></i>Delete</a>";
    },
]);
