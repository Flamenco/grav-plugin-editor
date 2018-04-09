# Editor Plugin

The **Editor** Plugin is for [Grav CMS](http://github.com/getgrav/grav). 
Edit your Grav source files directly from the browser. CSS, Twig, JS, and PHP are supported.

## Installation

Installing the Editor plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install editor

This will install the Editor plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/editor`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `editor`. You can find these files on [GitHub](https://github.com/twelve-tone-llc/grav-plugin-editor) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/editor
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/editor/editor.yaml` to `user/config/plugins/editor.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

## Usage

To edit CSS files, you must be logged in as administrator or superuser.

* Navigate to _/editor_.  You will see a list of CSS folders for each installed theme.
* Select the CSS file you want to edit.
* An editor page will open allowing you to make changes.
* Press _Save_ to update the file.

See [Official Documentation](https://www.twelvetone.tv/docs/developer-tools/grav-plugins/grav-editor-plugin).

## Credits

Thanks to Grav and CodeMirror for sweet products and platforms.

## To Do

- [ ] Compare changes.
- [x] Use code-mirror editor.
- [x] Confirm save.
- [ ] Optimistic locking.
- [x] Create files.
- [x] Delete files .
- [ ] Create folders.
- [ ] Delete folders.
- [x] Enable / disable languages.
- [x] Put languages in dropdown menu.
- [ ] Remove code-mirror dependency.
- [ ] Pretty print.
- [x] Refactor snackbar.
- [x] Refactor fast-filter.