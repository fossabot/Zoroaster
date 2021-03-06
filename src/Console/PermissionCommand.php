<?php

    namespace KarimQaderi\Zoroaster\Console;

    use Illuminate\Console\Command;
    use Illuminate\Console\DetectsApplicationNamespace;

    class PermissionCommand extends Command
    {
        use DetectsApplicationNamespace;
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'Zoroaster:Permission';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'نصب مجوز ها';

        /**
         * Execute the console command.
         *
         * @return void
         */
        public function handle()
        {
            $this->comment('Start install Permission');

            config()->set('Zoroaster.permission','true');

            copy(__DIR__ . '/App/Zoroaster/Resources/Permission.stub' , app_path('Zoroaster/Resources/Permission.php'));
            copy(__DIR__ . '/App/Zoroaster/Resources/Role.stub' , app_path('Zoroaster/Resources/Role.php'));

            copy(__DIR__.'/../../database/migrations/2018_12_21_131041_create_permission_tables.php' , database_path('migrations/2018_12_21_131041_create_permission_tables.php'));

            $this->call('migrate');

            $this->info('Permission installed successfully');
        }

    }
