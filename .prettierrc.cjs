const prettierConfig = require('@wordpress/prettier-config');

module.exports = {
  ...prettierConfig,
  tabWidth: 2,
  useTabs: false,
  proseWrap: 'never',
  endOfLine: 'lf',
  overrides: [
    {
      files: '*.json',
      options: {
        printWidth: 100,
      },
    },
    {
      files: '*.{yml,yaml}',
      options: {
        singleQuote: false,
        tabWidth: 2,
      },
    },
  ],
};
