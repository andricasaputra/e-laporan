## Migrations E-operasional procedure

# Migrate users migrations first
* php artisan migrate --path=database/migrations/users

# Then run users seeder
* php artisan db:seed  

# Then migrate e-operasional migrations 
* php artisan migrate --path=database/migrations/e-operasional

* IF YOU NOT FOLLOWING ABOVE INSTRUCTION FOR MIGRATION, THE APP
* GOING TO BREAK :D (FOR E-OPERASIONAL ONLY)

----------------------------------------------------------------------------------------------------------