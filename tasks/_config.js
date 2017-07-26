module.exports = {
  project: {
    devURL: 'localhost:8888/startkit',
    dest: './dist',
  },
  main: {
    css: [
      'assets/styles/main.scss',
    ],
    js: [
      'assets/scripts/main.js',
    ],
  },
  globs: {
    php: './**/*.php',
    styles: 'assets/styles/**/*.{scss,sass}',
    scripts: 'assets/scripts/**/*.js',
    images: 'assets/images/**/*.{png,jpg,gif,svg,ico}',
    icons: 'assets/icons/**/*.svg',
    fonts: 'assets/fonts/**/*.{woff,woff2,ttf,otf}',
  },
  i18n: {
    textDomain: 'startkit',
    dest: './lang',
  },
}
