<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| mc:check-fieldtypes — guard against unregistered fieldtypes
|--------------------------------------------------------------------------
|
| A blueprint referencing a fieldtype that is not registered in THIS install
| (e.g. `type: tags`, which has no Fieldtype class here) makes the entries API
| augmentation throw "Fieldtype [x] not found" → a 500 on
| /api/collections/<handle>/entries, which only surfaces on a fresh deploy.
|
| This resolves every blueprint's and fieldset's fields through Statamic's own
| resolver (the exact path the API uses), so an unknown fieldtype fails HERE —
| runnable locally, in CI, or as a provisioner build step — instead of later.
| Exits non-zero when any field cannot be resolved.
*/
Artisan::command('mc:check-fieldtypes', function () {
    $problems = [];

    // Blueprints. There is no BlueprintRepository::all(), so enumerate the
    // blueprint YAML files on disk and resolve each through Statamic's own
    // Blueprint pipeline (setContents → fields()->all()) — the same field
    // resolution the entries-API augmentation runs, so an unregistered fieldtype
    // (e.g. `type: tags`) throws HERE. instantiateFields() forces every field's
    // fieldtype to be constructed, which is what surfaces "Fieldtype [x] not found".
    $blueprintDir = resource_path('blueprints');
    if (is_dir($blueprintDir)) {
        foreach (\Illuminate\Support\Facades\File::allFiles($blueprintDir) as $file) {
            if ($file->getExtension() !== 'yaml') {
                continue;
            }
            $relative = $file->getRelativePathname();
            $handle    = (string) \Illuminate\Support\Str::of($relative)->beforeLast('.yaml')->replace('/', '.');
            try {
                $contents = \Symfony\Component\Yaml\Yaml::parseFile($file->getRealPath()) ?? [];
                \Statamic\Facades\Blueprint::make($handle)
                    ->setContents($contents)
                    ->fields()
                    ->all()
                    ->each(fn ($field) => $field->fieldtype());
            } catch (\Throwable $e) {
                $problems[] = "blueprint '{$relative}': {$e->getMessage()}";
            }
        }
    }

    foreach (\Statamic\Facades\Fieldset::all() as $fieldset) {
        try {
            $fieldset->fields()->all()->each(fn ($field) => $field->fieldtype());
        } catch (\Throwable $e) {
            $problems[] = "fieldset '{$fieldset->handle()}': {$e->getMessage()}";
        }
    }

    if (! empty($problems)) {
        $this->error('Unregistered / unresolvable fieldtypes found:');
        foreach ($problems as $problem) {
            $this->error('  - ' . $problem);
        }
        return 1;
    }

    $this->info('OK — every blueprint/fieldset field uses a registered fieldtype.');
    return 0;
})->purpose('Fail if any blueprint/fieldset uses a fieldtype not registered in this install');
