# StartKit

A custom WordPress starter theme with a modern asset pipeline.

**StartKit is not meant to be a boilerplate for all-purpose theme development, but rather for custom websites tailored to a specific client. As such it does NOT pass theme check, and is highly opinionated in its features.**

## Features

* CSS: Sass (with Sourcemaps), BEM Classes
* Javascript: ES6 support, Webpack Script Bundling
* Image Optimization
* SVG Icon System
* Live development with Browsersync and Gulp tasks
* Custom Post Type Management
* Translation-ready
* Customizable, modular and performant

## Setup

* clone or download this repo
* `$ rm -rf .git` to remove git history
* edit package.json 
  * change `name`, `author`
  * set `browserslist` to your supported range (see [browserslist](https://github.com/ai/browserslist) for options)
* edit `tasks/_config.js`
  * set `project.devURL` to your local development URL from Vagrant or MAMP. This will be used as a proxy by browsersync to start the dev server. Usually this is something like _yoursite.dev_ or _localhost:8888/yoursite_.
* `$ npm install` to fetch node dependencies

## Folder Structure

```
startkit/
├── assets/               # → Asset directory
│   ├── fonts/            # → Self-hosted fonts
│   ├── icons/            # → SVG icon files
│   ├── images/           # → Theme images and favicons
│   ├── scripts/          # → Theme javascript
│   │   └── main.js       # → Main JS bundle index
│   └── styles/           # → Theme SCSS
│       ├── utils/        # → Variables and mixins
│       ├── base/         # → Common styles (_reset, _typography...)
│       ├── components/   # → BEM components (_header, _post ...)
│       ├── vendor/       # → Third-party imports (e.g. bootstrap)
│       └── main.scss     # → Main CSS bundle index
├── dist/                 # → Asset build directory
├── functions.php         # → Main function index (loads includes)
├── gulpfile.js           # → Gulpfile (loads build tasks)
├── inc/                  # → PHP includes directory
├── index.php             # → WP index template
├── lang/                 # → Translations (.pot files)
├── package.json          # → Node dependencies
├── page.php              # → WP page template
├── screenshot.png        # → Theme screenshot for WP admin
├── single.php            # → WP single post template
├── style.css             # → Theme meta data
├── tasks/                # → Gulp build tasks directory
└── templates/            # → Partial templates (header.php, footer.php)
```

## Includes

StartKit provides a few included PHP files to set the baseline for the theme. These function files are located in the `/inc` directory. All files are namespaced and included in the main `functions.php`.

```
inc
├── base/                 # → Base includes
│   ├── assets.php        # → Enqueue css and js
│   ├── cleanup.php       # → Clean up default WP output in <head>
│   ├── disable.php       # → Disable WP features (XMLRPC, emojis, ...)
│   ├── filters.php       # → Custom WP filters (body_class, excerpt, ...) 
│   ├── icons.php         # → SVG Icon functions
│   ├── misc.php          # → Minor optimizations
│   ├── navigation.php    # → Custom Walker for BEM classes in wp_nav_menu
│   ├── nicesearch.php    # → Better search URLS ('/search/foobar')
│   ├── posttypes.php     # → Helper class to register new post types
│   ├── setup.php         # → Main theme and widget setup
│   ├── titles.php        # → Page title function
│   └── utils.php         # → Dev utilities and helpers
├── custom/               # → Your project-specific includes
└── posttypes/            # → Custom post type includes
    └── foobar.php        # → Example post type
````

It is recommended to put your own custom functions as separate modules in the `/custom` dir, and then add them to the `$theme_includes` array in `functions.php`.

## Development

When developing locally, simply run `gulp` inside the theme root. This prompts a fresh build, starts browsersync and watches the theme for changes. Processed assets land in the `/dist` folder. CSS changes are injected into the page automatically, other changes trigger a reload.

**Make sure your local server is running and the correct `devURL` is set in `tasks/_config.js` before starting gulp.**

### Available Build Tasks

The following commands can be issued in the theme root directory to perform build tasks:

* `gulp` or `gulp watch` - runs browsersync and watches all files for changes
* `gulp build` - cleans `/dist` and rebuilds all assets
* `gulp translate` - generates a new .pot translation file in `/lang`

## CSS Architecture

SCSS Partials
BEM Naming Method, 
Tilde Importer for Sass `@import`s from node_modules
Bootstrap 4

## Javascript Architecture

ES6/Babel, 
Main Bundle imports from src, 
optional Vendor Bundle, 
jQuery external from CDN with fallback

## SVG Icon System

StartKit provides an SVG Sprite with `<symbol>`s which are generated from SVG files placed in `/assets/icons`. The filename maps to the icon's ID. There is a helper function available to generate the corresponding `<use>` markup.

### Example

Add a file `assets/icons/facebook.svg`
```svg
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 ..."/>
</svg>
```
If necessary, manually run `gulp icons` to rebuild the SVG sprite.
Then use this helper function to render the icon on the page:
```php
<?php echo get_icon('facebook'); ?>
```
Icons are styled through the `.icon` class found in `/assets/styles/components/_icon.scss`. Specific icons can be targeted with a BEM modifier class like `.icon--facebook`.

## Translation

If you want to translate your theme, wrap all hard-coded strings in a [gettext](https://codex.wordpress.org/Plugin_API/Filter_Reference/gettext) call. The default textdomain is *'startkit'*, it is recommended to do a find-and-replace for this (including single quotes) after the setup, to change it to your preferred theme name. In that case you also need to adjust the `textdomain` setting in `/tasks/_config.js` and `style.css`.

Running `gulp translate` will then generate a .pot file named after your textdomain that includes all gettext strings. You can use this file with tools like [POedit](https://poedit.net/) to add translations.

## Thanks

StartKit leans heavily on the work provided by these projects:

* [Sage](https://roots.io/sage/) by Roots/Ben Word
* [WP Gulp](https://labs.ahmadawais.com/WPGulp/) by Ahmad Awais
* [Underscores](https://underscores.me/) by Automattic

Thank you!