<?php

declare(strict_types=1);

use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;

return [

    /*
    |--------------------------------------------------------------------------
    | Tenant model
    |--------------------------------------------------------------------------
    */

    'tenant_model' => Tenant::class,

    'id_generator' => Stancl\Tenancy\UUIDGenerator::class,

    /*
    |--------------------------------------------------------------------------
    | Domain model
    |--------------------------------------------------------------------------
    */

    'domain_model' => Domain::class,

    /*
    |--------------------------------------------------------------------------
    | Central domains
    |--------------------------------------------------------------------------
    |
    | Estos dominios pertenecen a la app central.
    | Aquí vive el registro de farmacias.
    |
    */

    'central_domains' => [
        '127.0.0.1',
        'localhost',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenancy bootstrappers
    |--------------------------------------------------------------------------
    */

    'bootstrappers' => [
        Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\FilesystemTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\QueueTenancyBootstrapper::class,
        // Stancl\Tenancy\Bootstrappers\RedisTenancyBootstrapper::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database tenancy config
    |--------------------------------------------------------------------------
    */

    'database' => [

        /*
         * IMPORTANTE:
         * Forzamos pgsql como conexión central para evitar el error:
         * Undefined array key "driver"
         */
        'central_connection' => 'pgsql',

        /*
         * Esta conexión se usa como plantilla para crear y conectar
         * las bases de datos tenant.
         */
        'template_tenant_connection' => 'pgsql',

        /*
         * Si Stancl genera el nombre automático, usará:
         * tenant_ + id
         *
         * En nuestro registro usamos tenancy_db_name personalizado.
         */
        'prefix' => 'tenant_',
        'suffix' => '',

        /*
         * Managers por motor de base de datos.
         */
        'managers' => [
            'sqlite' => Stancl\Tenancy\TenantDatabaseManagers\SQLiteDatabaseManager::class,
            'mysql' => Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager::class,
            'mariadb' => Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager::class,
            'pgsql' => Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLDatabaseManager::class,

            /*
             * Si algún día quieres separar por schemas en PostgreSQL
             * en vez de bases completas, usarías este:
             */
            // 'pgsql' => Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLSchemaManager::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache tenancy config
    |--------------------------------------------------------------------------
    */

    'cache' => [
        'tag_base' => 'tenant',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filesystem tenancy config
    |--------------------------------------------------------------------------
    */

    'filesystem' => [
        'suffix_base' => 'tenant',

        'disks' => [
            'local',
            'public',
            // 's3',
        ],

        'root_override' => [
            'local' => '%storage_path%/app/',
            'public' => '%storage_path%/app/public/',
        ],

        'suffix_storage_path' => true,

        'asset_helper_tenancy' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis tenancy config
    |--------------------------------------------------------------------------
    */

    'redis' => [
        'prefix_base' => 'tenant',

        'prefixed_connections' => [
            // 'default',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */

    'features' => [
        // Stancl\Tenancy\Features\UserImpersonation::class,
        // Stancl\Tenancy\Features\TelescopeTags::class,
        // Stancl\Tenancy\Features\UniversalRoutes::class,
        // Stancl\Tenancy\Features\TenantConfig::class,
        // Stancl\Tenancy\Features\CrossDomainRedirect::class,
        // Stancl\Tenancy\Features\ViteBundler::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenancy routes
    |--------------------------------------------------------------------------
    */

    'routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Tenant migration parameters
    |--------------------------------------------------------------------------
    |
    | Aquí van las migraciones que se ejecutarán dentro de cada base
    | de datos de farmacia.
    |
    */

    'migration_parameters' => [
        '--force' => true,
        '--path' => [database_path('migrations/tenant')],
        '--realpath' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant seeder parameters
    |--------------------------------------------------------------------------
    */

    'seeder_parameters' => [
        '--class' => 'DatabaseSeeder',
        // '--force' => true,
    ],
];