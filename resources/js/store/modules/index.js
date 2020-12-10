const requireModule = require.context(".", true, /^((?!index).)*\.js$/);

const modules = {};

requireModule.keys().forEach(filename => {
  const moduleName = filename.replace(/\.js|\.\//g, "");
  modules[moduleName] =
    requireModule(filename).default || requireModule(filename);
});

export default modules;
