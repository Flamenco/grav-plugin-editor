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
 * Helpers For Grav
 */

class GravUtil
{
    static public function isAdminLoggedIn($grav)
    {
        $adminCookie = session_name() . '-admin';
        if (isset($_COOKIE[$adminCookie]) === false) {
            return false;
        }

        // check for existence of a user account
        $account_dir = $file_path = $grav['locator']->findResource('account://');
        $user_check = glob($account_dir . '/*.yaml');

        // If no users found, stop here !!!
        if ($user_check == false || count((array)$user_check) == 0) {
            // dump($plugin->isAdminPath());
            return false;
//            if (!$plugin->isAdminPath()) {
//                return false;
//            }
        }

        $config = $grav['config'];
        $plugins = $config->get('plugins');

        $adminPlugin = isset($plugins['admin']) ? $config->get('plugins.admin') : false;
        $loginPlugin = isset($plugins['login']) ? $config->get('plugins.login') : false;

        //$plugin->adminRoute = $adminPlugin !== false ? $adminPlugin['route'] : $plugin->adminRoute;

        // Works only with the login and admin plugin installed and enabled
        if ($adminPlugin === false || $loginPlugin === false) {
            return false;
        } else {
            if ($adminPlugin['enabled'] === false || $loginPlugin['enabled'] === false) {
                return false;
            }
        }

        return true;
    }
}