/* global process module */

const chalk = require("chalk");
const fancyLog = require("fancy-log");

module.exports.check = function(consts, path) {
  require("dotenv").config({ path: path + "/.env" });

  const missing = [];

  for (const i in consts) {
    const envVar = consts[i];

    if (typeof process.env[i] === "undefined") {
      const str = ["- " + i + ":"];

      if (envVar.type) {
        str.push("(" + envVar.type + ")");
      }

      if (envVar.description) {
        let end = "";

        if (envVar.description.slice(-1) !== ".") {
          end = ".";
        }

        str.push(envVar.description + end);
      }

      if (envVar.values) {
        str.push("Values: " + envVar.values);
      }

      missing.push(str.join(" "));
    }
  }

  if (missing.length > 0) {
    fancyLog();
    fancyLog(chalk.bgRed("                                   "));
    fancyLog(chalk.bgRed("  Missing environment constiables  "));
    fancyLog(chalk.bgRed("                                   "));
    fancyLog();

    for (let i = 0; i < missing.length; i++) {
      fancyLog(missing[i]);
    }

    fancyLog();
    fancyLog(
      chalk.red("Check if your .env file exists and if its content is correct.")
    );
    fancyLog();

    process.exit(1);
  }
};
