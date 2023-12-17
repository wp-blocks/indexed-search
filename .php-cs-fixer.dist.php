<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

// The rule set contains rules that are incompatible with the version of
// PHP-CS-Fixer that can be installed in the project because of dependencies
// version conflicts. Using a globally installed version of PHP-CS-Fixer
// allows using the latest version of the rules.

$finder = Finder::create()
    ->notPath(['WP_HTML_Tag_Processor.php'])
    ->exclude(['vendor', 'vendor-prod', '_support/_generated', '_wordpress'])
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new Config();

return $config->setRules([
    '@PSR12' => true,
    '@PHP82Migration' => true,

    // Array notation

    'array_indentation' => true,
    'array_syntax' => ['syntax' => 'short'],
    'no_multiline_whitespace_around_double_arrow' => true,
    'trim_array_spaces' => true,
    'whitespace_after_comma_in_array' => ['ensure_single_space' => true],

    // Basic

    'single_quote' => true,
    'octal_notation' => true,
    'no_trailing_comma_in_singleline' => true,
    'single_line_empty_body' => true,

    // Class notation

    'class_attributes_separation' => ['elements' => ['const' => 'one', 'method' => 'one', 'property' => 'one', 'trait_import' => 'none', 'case' => 'none']],
    'no_null_property_initialization' => true,

    // Function notation

    'method_argument_space' => ['attribute_placement' => 'ignore', 'keep_multiple_spaces_after_comma' => true, 'on_multiline' => 'ensure_fully_multiline'],

    // Imports

    'no_unused_imports' => true,

    // Operator

    'unary_operator_spaces' => true,

    // PHPDoc

    'phpdoc_indent' => true,
    'phpdoc_align' => true,
    'phpdoc_separation' => true,

    // White space

    'heredoc_indentation' => ['indentation' => 'same_as_start'],
    'method_chaining_indentation' => true,
    'no_extra_blank_lines' => [
        'tokens' => ['attribute', 'break', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'return', 'square_brace_block', 'switch', 'throw', 'use'],
    ],
    'no_spaces_around_offset' => true,

    'types_spaces' => ['space' => 'none'],
])->setFinder($finder);
