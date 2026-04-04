<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VerifyViteAssets extends Command
{
    protected $signature = 'assets:verify';

    protected $description = 'Check that Vite production assets (public/build) are present and public/hot is absent';

    public function handle(): int
    {
        $manifest = public_path('build/manifest.json');
        $hot = public_path('hot');

        if (file_exists($hot)) {
            $this->error('public/hot exists. Laravel will try to load CSS/JS from the Vite dev server instead of public/build.');
            $this->line('Delete it on the server: rm -f '.public_path('hot'));
            $this->newLine();
        }

        if (! is_file($manifest)) {
            $this->error('Missing: public/build/manifest.json');
            $this->line('Run locally: npm ci && npm run build');
            $this->line('Then upload the entire public/build folder next to public/index.php (same directory as .htaccess).');

            return self::FAILURE;
        }

        $this->info('Found public/build/manifest.json');

        $decoded = json_decode((string) file_get_contents($manifest), true);
        if (! is_array($decoded) || $decoded === []) {
            $this->error('manifest.json is empty or invalid JSON.');

            return self::FAILURE;
        }

        $this->line('Entries: '.count($decoded));

        $cssKey = 'resources/css/app.css';
        if (isset($decoded[$cssKey]['file'])) {
            $file = public_path('build/'.$decoded[$cssKey]['file']);
            if (is_file($file)) {
                $this->info('CSS bundle OK: build/'.$decoded[$cssKey]['file']);
            } else {
                $this->error('Manifest references missing file: build/'.$decoded[$cssKey]['file']);
                $this->line('Re-upload the full build/ folder (including assets/).');

                return self::FAILURE;
            }
        }

        if (! file_exists($hot)) {
            $this->info('public/hot is absent (correct for production).');
        }

        return self::SUCCESS;
    }
}
