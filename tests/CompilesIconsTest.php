<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codeat3\BladeDevIcons\BladeDevIconsServiceProvider;

class CompilesIconsTest extends TestCase
{
    /** @test */
    public function it_compiles_a_single_anonymous_component()
    {
        $result = svg('devicon-bulma')->toHtml();

        // Note: the empty class here seems to be a Blade components bug.
        $expected = <<<'SVG'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" fill="currentColor"><path fill="currentColor" d="M59.2 0l40 40-24 24 32 31.9L59.4 128l-40-39.9 7.7-56z"/></svg>
            SVG;


        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_classes_to_icons()
    {
        $result = svg('devicon-bulma', 'w-6 h-6 text-gray-500')->toHtml();
        $expected = <<<'SVG'
            <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" fill="currentColor"><path fill="currentColor" d="M59.2 0l40 40-24 24 32 31.9L59.4 128l-40-39.9 7.7-56z"/></svg>
            SVG;
        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_styles_to_icons()
    {
        $result = svg('devicon-bulma', ['style' => 'color: #555'])->toHtml();


        $expected = <<<'SVG'
            <svg style="color: #555" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" fill="currentColor"><path fill="currentColor" d="M59.2 0l40 40-24 24 32 31.9L59.4 128l-40-39.9 7.7-56z"/></svg>
            SVG;

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_default_class_from_config()
    {
        Config::set('blade-devicons.class', 'awesome');

        $result = svg('devicon-bulma')->toHtml();

        $expected = <<<'SVG'
            <svg class="awesome" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" fill="currentColor"><path fill="currentColor" d="M59.2 0l40 40-24 24 32 31.9L59.4 128l-40-39.9 7.7-56z"/></svg>
            SVG;

        $this->assertSame($expected, $result);

    }

    /** @test */
    public function it_can_merge_default_class_from_config()
    {
        Config::set('blade-devicons.class', 'awesome');

        $result = svg('devicon-bulma', 'w-6 h-6')->toHtml();

        $expected = <<<'SVG'
            <svg class="awesome w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" fill="currentColor"><path fill="currentColor" d="M59.2 0l40 40-24 24 32 31.9L59.4 128l-40-39.9 7.7-56z"/></svg>
            SVG;

        $this->assertSame($expected, $result);

    }

    protected function getPackageProviders($app)
    {
        return [
            BladeIconsServiceProvider::class,
            BladeDevIconsServiceProvider::class,
        ];
    }
}
