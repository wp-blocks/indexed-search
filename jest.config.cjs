const jestConfig = {
  verbose: true,
  preset: '@wordpress/jest-preset-default',
  setupFilesAfterEnv: ['@wordpress/jest-console'],
  modulePaths: ['<rootDir>/client'],
  projects: [
    {
      displayName: 'unit',
      testMatch: ['<rootDir>/client/tests/unit/**/*.test.ts'],
    },
  ],
};

module.exports = jestConfig;
