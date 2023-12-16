<?php
/*
 * Acceptance suite bootstrap file.
 *
 * This file is loaded AFTER the suite modules are initialized and WordPress has been loaded by the WPLoader module.
 *
 * The initial state of the WordPress site is the one set up by the dump file(s) loaded by the WPDb module, look for the
 * "modules.config.WPDb.dump" setting in the suite configuration file. The database will be dropped after each test
 * and re-created from the dump file(s).
 *
 * You can modify and create new dump files using the `vendor/bin/codecept wp:cli Acceptance <wp-cli command>` command
 * to run WP-CLI commands on the WordPress site and database used by the Acceptance suite.
 * E.g.:
 * `vendor/bin/codecept wp:cli Acceptance db import tests/Support/Data/dump.sql` to load  dump file.
 * `vendor/bin/codecept wp:cli Acceptance plugin activate woocommerce` to activate the WooCommerce plugin.
 * `vendor/bin/codecept wp:cli Acceptance user create alice alice@example.com --role=administrator` to create a new user.
 * `vendor/bin/codecept wp:cli Acceptance db export tests/Support/Data/dump.sql` to update the dump file.
 */
