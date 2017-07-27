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
│   └── styles/           # → Theme SCSS files
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

Styles are written in SCSS (Sass). Include your partials in `assets/styles`, then @import them in `main.scss`. StartKit provides very little styling out of the box, it is up to you to customize it.

Classnames follow the [BEM naming scheme](http://getbem.com/). Components like `.header` or `.post` typically get their own partial in the `/components` folder. As a convention, partials should be named after the root component class so they can be found easily.

```
assets/styles
├── utils/                # → Utilities (generates no CSS)
│   ├── variables.scss
│   ├── mixins.scss
│   └── functions.scss
├── base/                 # → Common shared styles (global scope)
│   ├── normalize.scss
│   ├── reboot.scss
│   ├── layout.scss
│   ├── typography.scss
│   └── helpers.scss
├── components/           # → Component-specific CSS (BEM scoped)
│   ├── header.scss
│   └── icon.scss   
├── vendor/               # → Third-Party stuff
│   └── bootstrap.scss    # → Imports bootstrap4 partials
└── main.scss             # → Main index
```

### CSS Frameworks

You can add other third-party frameworks in `/styles/vendor/`. It's possible to include packages downloaded via npm if you reference them with a `~` (tilde). 

[Bootstrap 4](https://v4-alpha.getbootstrap.com/) is included as a dependency, but not imported in the main stylesheet. To reduce bloat, it is recommended to seperately import only the parts you need. For example, if you want to use just bootstrap grid:

```scss
/* styles/vendor/_bootstrap.scss */
@import "~bootstrap/scss/grid";
```

All Bootstrap variables and mixins are available, and can be overwritten/extended in StartKit's own `utils/variables` and `utils/mixins` files.

## Javascript Architecture

StartKit supports ES6. It will be transpiled by babel and run through webpack. As the goal is to reduce the number of script requests in WordPress, it is encouraged to write Javascript as modules in `scripts/src/`, which are then imported in `scripts/main.js`. This file serves as the main entry point for webpack. Everything in there is bundled together, minified and output as `dist/main.min.js`.

If you need to define a separate bundle, add a new entry file to `/scripts` and edit `tasks/_config.js` to tell webpack about it:

```js
//_config.js
...
main: {
  css: [
    'assets/styles/main.scss',
  ],
  js: [
    'assets/scripts/main.js',
    //add a new bundle entry file
    'assets/scripts/vendor.js',
  ],
},
...
```

This will then produce a `dist/vendor.min.js` file you need to enqueue in WordPress.
You can find the script enqueue function in `inc/base/assets.php`:

```php
function enqueue() {
  // Enqueue the new bundle
  wp_enqueue_script('vendor_scripts', ASSETS_DIR . '/scripts/vendor.min.js', ['jquery'], null, true);
}
```

### jQuery

Per default, jQuery is included as an external dependency and served via CDN. There is also an automatic local fallback, in case the CDN should be unavailable. You can use jQuery in your scripts with `jQuery` or the `$` alias.

### ESLint

ESLint is available for linting. The default ruleset relies on [eslint-config-airbnb-base](https://www.npmjs.com/package/eslint-config-airbnb-base), feel free to edit this to your preferred coding style in `.eslintrc.json`.

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