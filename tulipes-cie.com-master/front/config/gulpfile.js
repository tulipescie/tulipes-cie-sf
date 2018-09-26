/* global process */

const gulp = require("gulp");

// Loading plugins, prevents multiple requires
const $ = require("gulp-load-plugins")({
  pattern: ["*"],
  scope: ["devDependencies"],
});

// Hiding start and end gulp tasks message
$.util.log = $.util.noop;

// checking .env file
require("../lib/checkEnv.js").check(
  {
    APP_ENV: {
      type: "string",
      description: "defines environment",
      values: ["prod", "dev"],
    },
    BS_PROXY_HOST: {
      type: "string",
      description: "defines browserSync proxy host",
    },
    BS_PROXY_PORT: {
      type: "int",
      description: "defines browserSync proxy port",
    },
  },
  process.cwd() + "/../.."
);

// .env APP_DEV shortcut
const isDev = () => {
  return process.env.APP_ENV === "dev";
};

// loading webpack config
const config = require("./webpack.config.js")(process.env.APP_ENV);

// clears terminal in dev env
const clearTerminal = () => {
  if (isDev()) $.clearTerminal();
};

// JavaScript files
gulp.task("build:js", callback => {
  clearTerminal();
  $.fancyLog($.chalk.cyan("-> Building JavaScript..."));

  $.webpack(config, (err, stats) => {
    const jsonStats = stats.toJson({}, true);
    const messages = $.webpackFormatMessages(stats);

    if (messages.errors.length) {
      $.fancyLog($.chalk.red("Failed to compile."));
      $.fancyLog();

      messages.errors.forEach(message => {
        $.fancyLog(message);
        $.fancyLog();
      });

      callback();

      return;
    }

    // Show warnings if no errors were found.
    if (messages.warnings.length) {
      $.fancyLog($.chalk.yellow("Compiled with warnings."));
      $.fancyLog();

      messages.warnings.forEach(message => {
        $.fancyLog(message);
        $.fancyLog();
      });
    }

    $.fancyLog(
      $.chalk.green("Compiled successfuly (" + jsonStats.time + " ms)!")
    );

    $.browserSync.reload();

    callback();
  });
});

// Synchronizes browsers and provides proxy to access website through network
gulp.task("browser-sync", () => {
  $.browserSync.init({
    proxy: process.env.BS_PROXY_HOST,
    port: process.env.BS_PROXY_PORT,
    open: false,
    logPrefix: () => {
      const now = new Date();
      const time =
        "[" +
        $.chalk.grey(
          ("0" + now.getHours()).slice(-2) +
            ":" +
            ("0" + now.getMinutes()).slice(-2) +
            ":" +
            ("0" + now.getSeconds()).slice(-2)
        ) +
        "] BrowserSync: ";

      return time;
    },
    ghostMode: {
      clicks: true,
      forms: false,
      scroll: true,
    },
  });
});

// Building CSS files
gulp.task("build:sass", () => {
  clearTerminal();
  $.fancyLog($.chalk.cyan("-> Building SASS..."));

  gulp
    .src("../assets/sass/index.sass")
    .pipe($.if(isDev(), $.sourcemaps.init()))
    .pipe(
      $.sass({
        outputStyle: isDev() ? "expanded" : "compressed",
      }).on("error", $.sass.logError)
    )
    .pipe(
      $.autoprefixer({
        browsers: ["last 2 versions"],
        cascade: false,
      })
    )
    .pipe($.if(isDev(), $.sourcemaps.write("./")))
    .pipe(gulp.dest("../../web/assets/css"))
    .pipe($.browserSync.stream({ match: "**/*.css" }));

  $.fancyLog($.chalk.green("Built successfuly!"));
});

// watching
gulp.task("watch", ["build"], () => {
  clearTerminal();

  gulp.watch("../assets/sass/**/*.sass", ["build:sass"]);
  gulp.watch("../assets/js/**/*.js", ["build:js"]);
});

// building both sass and js
gulp.task("build", ["build:js", "build:sass"]);

gulp.task("default", ["browser-sync", "watch"]);
