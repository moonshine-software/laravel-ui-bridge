# Laravel MoonShine UI Bridge

A lightweight Laravel package that allows you to use [moonshine/ui](https://github.com/moonshine-software/ui) as a standalone UI toolkit — without requiring the full MoonShine admin panel.

## ✨ Features

- Seamless integration of MoonShine UI components into any Laravel app
- Auto-resolves required dependencies and service providers
- Minimal setup, no bloat
- Works great for custom UIs, MVPs, or internal tools

## Installation

```bash
composer require moonshine/ui
```

```bash
composer require moonshine/laravel-ui-bridge
```

## Usage

`welcome.blade.php`

```blade
<x-moonshine::layout>
    <x-moonshine::layout.html :with-alpine-js="true" :with-themes="true">
        <x-moonshine::layout.head>
            <x-moonshine::layout.meta name="csrf-token" :content="csrf_token()"/>
            <x-moonshine::layout.favicon />
            <x-moonshine::layout.assets>
                @vite([
                    'resources/css/main.css',
                    'resources/js/app.js',
                ], 'vendor/moonshine')
            </x-moonshine::layout.assets>
        </x-moonshine::layout.head>

        <x-moonshine::layout.body>
            <x-moonshine::layout.wrapper>
                <x-moonshine::layout.top-bar>
                    <x-moonshine::layout.menu
                        :elements="[
            ['label' => 'Dashboard', 'url' => '/'],
            ['label' => 'Section', 'url' => '/section'],
        ]
    "/>
                </x-moonshine::layout.top-bar>

                <x-moonshine::layout.sidebar :collapsed="true">
                    <x-moonshine::layout.div class="menu-heading">
                        <x-moonshine::layout.div class="menu-heading-logo">
                            <x-moonshine::layout.logo href="/" logo="/logo.png" :minimized="true"/>
                        </x-moonshine::layout.div>

                        <x-moonshine::layout.div class="menu-heading-actions">
                            <x-moonshine::layout.div class="menu-heading-mode">
                                <x-moonshine::layout.theme-switcher/>
                            </x-moonshine::layout.div>
                            <x-moonshine::layout.div class="menu-heading-burger">
                                <x-moonshine::layout.burger/>
                            </x-moonshine::layout.div>
                        </x-moonshine::layout.div>

                    </x-moonshine::layout.div>

                    <x-moonshine::layout.div class="menu" ::class="asideMenuOpen && '_is-opened'">
                        <x-moonshine::layout.menu :elements="[['label' => 'Dashboard', 'url' => '/'], ['label' => 'Section', 'url' => '/section']]"/>
                    </x-moonshine::layout.div>
                </x-moonshine::layout.sidebar>

                <x-moonshine::layout.div class="layout-page">
                    <x-moonshine::layout.header>
                        <x-moonshine::breadcrumbs :items="['#' => 'Home']"/>
                        <x-moonshine::layout.search placeholder="Search" />
                        <x-moonshine::layout.locales :locales="collect()"/>
                    </x-moonshine::layout.header>

                    <x-moonshine::layout.content>
                        <article class="article">
                            <x-moonshine::form
                                name="crud-form"
                                :errors="$errors"
                                precognitive
                            >
                                <x-moonshine::form.input
                                    name="title"
                                    placeholder="Title"
                                    value=""
                                />
                                <x-slot:buttons>
                                    <x-moonshine::form.button type="reset">Cancel</x-moonshine::form.button>
                                    <x-moonshine::form.button class="btn-primary">Submit</x-moonshine::form.button>
                                </x-slot:buttons>
                            </x-moonshine::form>

                            <x-moonshine::table
                                :columns="[
                                    '#', 'First', 'Last', 'Email'
                                ]"
                                                            :values="[
                                    [1, fake()->firstName(), fake()->lastName(), fake()->safeEmail()],
                                    [2, fake()->firstName(), fake()->lastName(), fake()->safeEmail()],
                                    [3, fake()->firstName(), fake()->lastName(), fake()->safeEmail()]
                                ]"
                            />

                            <x-moonshine::alert>Alert</x-moonshine::alert>

                            <x-moonshine::badge color="primary">Primary</x-moonshine::badge>
                            <x-moonshine::badge color="secondary">Secondary</x-moonshine::badge>
                            <x-moonshine::badge color="success">Success</x-moonshine::badge>
                            <x-moonshine::badge color="info">Info</x-moonshine::badge>
                            <x-moonshine::badge color="warning">Warning</x-moonshine::badge>
                            <x-moonshine::badge color="error">Error</x-moonshine::badge>
                            <x-moonshine::badge color="purple">Purple</x-moonshine::badge>
                            <x-moonshine::badge color="pink">Pink</x-moonshine::badge>
                            <x-moonshine::badge color="blue">Blue</x-moonshine::badge>
                            <x-moonshine::badge color="green">Green</x-moonshine::badge>
                            <x-moonshine::badge color="yellow">Yellow</x-moonshine::badge>
                            <x-moonshine::badge color="red">Red</x-moonshine::badge>
                            <x-moonshine::badge color="gray">Gray</x-moonshine::badge>

                            <x-moonshine::boolean :value="true" />
                            <x-moonshine::boolean :value="false" />

                            <x-moonshine::layout.box>
                                {{ 'Hello!' }}
                            </x-moonshine::layout.box>


                            <x-moonshine::card
                                :title="fake()->sentence(3)"
                                :thumbnail="'https://moonshine-laravel.com/images/image_1.jpg'"
                                :url="'https://cutcode.dev'"
                                :subtitle="'test'"
                                :values="['ID' => 1, 'Author' => fake()->name()]">
                                    {{ fake()->text(100) }}
                            </x-moonshine::card>

                            <x-moonshine::carousel    :items="['/images/image_2.jpg','/images/image_1.jpg']"    :alt="fake()->sentence(3)"/>

                            <x-moonshine::collapse    :label="'Title/Slug'">
                                test
                            </x-moonshine::collapse>

                            <x-moonshine::color :color="'red'"/>

                            <x-moonshine::layout.divider/>
                            <x-moonshine::layout.divider/>

                            <x-moonshine::dropdown>
                                <div class="m-4">
                                    Content
                                </div>
                                <x-slot:toggler>Click me</x-slot:toggler>
                            </x-moonshine::dropdown>

                            <x-moonshine::files
                                :files="[
        '/images/thumb_1.jpg',
        '/images/thumb_2.jpg',
        '/images/thumb_3.jpg',
    ]"
                                :download="false"
                            />

                            <x-moonshine::icon icon="users" />

                            <x-moonshine::link-button href="#">
                                Link
                            </x-moonshine::link-button>

                            <x-moonshine::link-native href="#">
                                Link
                            </x-moonshine::link-native>

                            <x-moonshine::metrics.value
                                title="Completed orders"
                                icon="shopping-bag"
                                :value="10"
                                :progress="false"
                            />

                            <x-moonshine::modal title="Title">
                                <div>
                                    Content...
                                </div>
                                <x-slot name="outerHtml">
                                    <x-moonshine::link-button @click.prevent="toggleModal">
                                        Open modal
                                    </x-moonshine::link-button>
                                </x-slot>
                            </x-moonshine::modal>

                            <x-moonshine::off-canvas
                                title="Offcanvas"
                                :left="false"
                            >
                                <x-slot:toggler>
                                    Open
                                </x-slot:toggler>
                                {{ fake()->text() }}
                            </x-moonshine::off-canvas>

                            <x-moonshine::popover title="Popover title" placement="right">
                                <x-slot:trigger>
                                    <button class="btn">Popover</button>
                                </x-slot:trigger>
                                <p>This is a very beautiful popover, show some love.</p>
                                <div class='flex justify-between mt-3'>
                                    <button type='button' class='btn btn-sm'>Skip</button>
                                    <button type='button' class='btn btn-sm btn-primary'>Read More</button>
                                </div>
                            </x-moonshine::popover>
                        </article>
                    </x-moonshine::layout.content>
                </x-moonshine::layout.div>
            </x-moonshine::layout.wrapper>
        </x-moonshine::layout.body>
    </x-moonshine::layout.html>
</x-moonshine::layout>
```
