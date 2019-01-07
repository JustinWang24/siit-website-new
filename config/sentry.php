<?php

return array(
    'dsn' => env('SENTRY_LARAVEL_DSN','https://8b81080017594933904cb07e01a81b36@sentry.io/1365503'),

    // capture release as git sha
    // 'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),

    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,

    // Capture default user context
    'user_context' => false,
);
