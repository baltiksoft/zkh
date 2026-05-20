<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <x-header title="Личный кабинет"/>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-stat
            title="Фамилия Имя Отчество"
            value="{{ Auth::user()->userDetail ? Auth::user()->userDetail->short_name : Auth::user()->name }}"
            icon="o-user"
            color="text-primary" />
        <x-stat
            title="Паспорт"
            value="{{ Auth::user()->userDetail ? Auth::user()->userDetail->masked_series : '' }}"
            icon="o-document"
            color="text-primary" />

        <x-stat
            title="Вам"
            value="{{ Auth::user()->userDetail->age_with_suffix }}"
            icon="o-calendar"
            color="text-primary" />
    </div>

    @if(count(Auth::user()->userDetail?->rooms ?? []) > 0)

        @forelse(Auth::user()->userDetail?->rooms ?? [] as $room)
            <x-card padding="none" class="overflow-hidden shadow-lg border border-base-200 mt-5">
                <div class="flex flex-col md:flex-row">
                    <!-- Блок с фотографией слева -->
                    <div class="w-full md:w-1/3 min-h-[200px] relative">
                        <img
                            src="https://images.cdn-cian.ru/images/2847219031-1.jpg"
                            alt="Фото помещения"
                            class="w-full h-full object-cover absolute inset-0"
                        />
                    </div>

                    <!-- Блок с текстом справа -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Заголовок (Тип помещения и город) -->
                            <h3 class="text-xl font-bold text-base-content mb-1">
                                {{ $room->name }}
                            </h3>
                            <x-badge value="Активно" class="badge-success text-white badge-sm" />

                            <!-- Описание / Адрес -->
                            <p class="text-base-content/80 text-sm leading-relaxed">
                                {{ $room->address }}
                            </p>
                        </div>

                        <!-- Нижняя панель с кнопками или статусом (опционально) -->
                        <div class="mt-6 flex justify-end gap-2">
                            <x-button label="Подробнее" icon="o-eye" size="sm" class="btn-ghost" />
                            <x-button label="Редактировать" icon="o-pencil" size="sm" class="btn-primary" />
                        </div>
                    </div>
                </div>
            </x-card>

        @empty
            <p class="text-gray-500">Список помещений пуст.</p>
        @endforelse
    @endif
</div>
