/* global process */
/* eslint-env node */

const webpack = require("webpack");
const fs = require("fs");
const root = fs.realpathSync(process.cwd() + "/../..");

module.exports = APP_ENV => {
  const opts = {
    src: root + "/front/assets",
    dest: root + "/web",
  };

  const plugins = [
    new webpack.DefinePlugin({
      "process.env": { NODE_ENV: JSON.stringify(APP_ENV) },
    }),

    new webpack.LoaderOptionsPlugin({
      minimize: APP_ENV === "prod",
      debug: APP_ENV === "dev",
    }),
  ];

  if (APP_ENV === "prod") {
    plugins.push(
      new webpack.optimize.UglifyJsPlugin({
        sourceMap: true,
        test: [/\.js$/i],
        comments: false,
      })
    );
  }

  return {
    devtool: APP_ENV === "dev" ? "source-map" : false,
    entry: [opts.src + "/js/index.js"],
    output: {
      path: opts.dest + "/assets/js",
      filename: "app.js",
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          use: {
            loader: "babel-loader",
            options: {
              presets: ["env"],
            },
          },
          exclude: /node_modules/,
          enforce: "pre",
        },
        {
          test: /\.(html|gif|png|jpg|jpeg|ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
          loader: "file-loader",
          query: { name: "[name].[ext]" },
        },
      ],
    },
    plugins: plugins,
  };
};
