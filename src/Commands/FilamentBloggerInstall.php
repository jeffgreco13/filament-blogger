<?php

namespace Jeffgreco13\FilamentBlogger\Commands;

use Illuminate\Console\Command;

class FilamentBloggerInstall extends Command
{
    protected $signature = 'blogger:install';

    protected $description = 'Installs blogger.';

    public function handle()
    {
        $this->line("**********************");
        $this->line("* WELCOME TO BLOGGER *");
        $this->line("**********************");
        $this->warn('Warning: Blogger is very opinionated. Please read the prompts carefully.');
        //
        //
        $this->newLine(3);
        //
        //
        $this->line("***********");
        $this->line("* CURATOR *");
        $this->line("***********");
        $this->line('Blogger uses the great package Curator by Awcodes for the media library.');
        $this->warn('THIS PACKAGE DOES NOT WORK WITH SPATIE MEDIA LIBRARY. If you are using Spatie Media, please do not use this package.');
        if (!$this->confirm('Do you want to continue with the install?',true)) {
            return false;
        }
        $this->call('vendor:publish', [
            "--provider" => "Awcodes\Curator\CuratorServiceProvider",
            "--tag" => "curator-migrations"
        ]);
        //
        //
        $this->newLine(3);
        //
        //
        $this->line("*******************");
        $this->line("* FILAMENT TIPTAP *");
        $this->line("*******************");
        $this->line('Blogger uses another great package by Awcodes, Filament Tiptap Editor.');
        $this->warn('You will need to publish the Filament Tiptap configuration if you would like to use the Tiptap/Curator integration (recommended)');
        if ($this->confirm('Do you want to publish the Tiptap config now?')) {
            $this->callSilent('vendor:publish', [
                "--tag" => "filament-tiptap-editor-config"
            ]);
        }
        //
        //
        $this->newLine(3);
        //
        //
        $this->line("*******************");
        $this->line("* FILAMENT SEO *");
        $this->line("*******************");
        $this->line('Blogger uses Filament SEO by Ralphjsmit to handle all SEO meta data for your posts, and other content as you wish.');
        $this->warn('It is highly recommended that you publish the SEO config and customize it to your liking.');
        if ($this->confirm('Do you want to publish the SEO config now?')) {
            $this->callSilent('vendor:publish', [
                "--tag" => "seo-config"
            ]);
        }
        $this->call('vendor:publish', [
            "--tag" => "seo-migrations"
        ]);
        //
        //
        $this->newLine(3);
        //
        //
        $this->line("**********");
        $this->line("*  TAGS  *");
        $this->line("**********");
        $this->line('This package uses the Spatie Tags Filament Forms plugin. If you have not already installed this plugin, you will need to publish the migration.');
        if ($this->confirm('Do you want to publish the Spatie Tags migrations now?')){
            $this->callSilent('vendor:publish', [
                "--provider" => "Spatie\Tags\TagsServiceProvider",
                "--tag" => "tags-migrations"
            ]);
        }
        //
        //
        $this->newLine(3);
        //
        //
        $this->info('Publishing the Filament Blogger migration.');
        $this->callSilent('vendor:publish', ['--tag' => 'filament-blogger-migrations']);

        $this->info('Filament Blogger installed successfully!');
        if($this->confirm('Do you want to run the migrations now?')){
            $this->info('Running migrations...');
            $this->callSilent('migrate');
        }
        $this->info('Enjoy!');
    }
}
