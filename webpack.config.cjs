const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaultConfig,
  devtool: 'inline-source-map',
  module: {
    rules: [
      {
        test: /\.[tjmc]sx?$/,
        use: ['babel-loader'],
        exclude: /node_modules/,
      },
    ],
    ...defaultConfig.module,
  },
};
