<div x-data="{
        currentTheme: document.documentElement.getAttribute('data-theme') || 'light'
     }"
     x-init="
        const observer = new MutationObserver(() => {
            currentTheme = document.documentElement.getAttribute('data-theme');
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
     ">
<x-menu activate-by-route>
    {{-- User --}}
    @if($user = auth()->user())
        <x-menu-separator />
        <x-list-item :item="$user" value="name" sub-value="email" link="{{ route('user.profile') }}" no-separator no-hover class="-mx-2 !-my-2 rounded">
            <x-slot:actions>
                <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="{{ __('dashboard.logoff') }}" no-wire-navigate link="{{ route('logout') }}" />
            </x-slot:actions>
        </x-list-item>

        <x-menu-separator />
    @endif
    <div x-data="{
    theme: 'light',
    updateTheme() {
        // Проверяем атрибут, если его нет — localStorage, если и там нет — систему
        this.theme = document.documentElement.getAttribute('data-theme') ||
                     localStorage.getItem('theme') ||
                     (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    }
}"
         x-init="updateTheme()"
         @mary-toggle-theme.window="setTimeout(() => updateTheme(), 50)">

        <x-menu-item @click="$dispatch('mary-toggle-theme')">
            <x-slot:title>
                <div class="flex items-center gap-2">
                    {{-- Иконка теперь живет внутри титула, тут Blade её не трогает --}}
                    <x-icon name="o-sun" x-show="theme !== 'light'" />
                    <x-icon name="o-moon" x-show="theme !== 'dark'" x-cloak />
                    <span x-text="theme !== 'light' ? 'Светлая тема' : 'Темная тема'"></span>
                </div>
            </x-slot:title>
        </x-menu-item>

        {{-- Логика переключения (скрытая) --}}
        <x-theme-toggle class="hidden" />
    </div>
    <x-menu-separator />
    @foreach($menuItems as $item)
        {{-- Проверка прав доступа, если нужно --}}
        @if(!isset($item['permission']) || auth()->user()->can($item['permission']))
            @if(isset($item['children']) && count($item['children']) > 0)
                {{-- Группа меню (раскрывающаяся) --}}
                <x-menu-sub :title="$item['title']" :icon="$item['icon']">
                    @foreach($item['children'] as $child)
                        <x-menu-item
                            :title="$child['title']"
                            :icon="$child['icon']"
                            :link="$child['link']" exact
                        />
                    @endforeach
                </x-menu-sub>
            @else
                <x-menu-item
                    :title="$item['title']"
                    :icon="$item['icon']"
                    :link="$item['link']" exact
                />
            @endif
        @endif
    @endforeach
</x-menu>
</div>
