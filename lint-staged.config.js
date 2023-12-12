export default {
  '**/*.(json|yml|yaml)': (filenames) => {
    const files = filenames.join(' ');
    return [`prettier --write ${files}`];
  },
  '**/*.(js|jsx|cjs|mjs|ts|tsx)': (filenames) => {
    const files = filenames.join(' ');
    return [`eslint --ext .js,.jsx,.cjs,.mjs,.ts,.tsx --fix ${files}`];
  },
  '**/*.(php)': (filenames) => {
    const files = filenames.join(' ');
    return [
      `./vendor/bin/phpstan analyze --memory-limit=4G --ansi ${files}`,
      `./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --ansi ${files}`,
    ];
  },
};
