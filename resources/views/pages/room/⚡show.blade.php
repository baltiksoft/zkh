<?php

use App\classes\BInvoiceService;
use App\classes\BMeterReading;
use App\Models\Meter;
use App\Models\Room;
use Livewire\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    // Component parameter
    public Room $room;

    public $name;
    public $address;
    public bool $dialog = false;
    public $currentMeterId = 0;
    public $currentMeterName = null;
    public $currentMeterValue = 0;
    public $currentMeterDate = 'Нет данных';
    public $value = 0;
    public $reported_at;

    public $selectedTab = "meters-tab";

    public function mount(): void
    {
        $this->reported_at = now()->format('Y-m-d');
        $this->fill($this->room);
    }

    public function openDialog($id, $name, $value, $date): void
    {
        $this->currentMeterId = $id;
        $this->currentMeterName = $name;
        $this->currentMeterValue = $value;
        $this->currentMeterDate = $date;
        $this->value = $value;
        $this->dialog = true;
    }

    public function save(BInvoiceService $invoiceService)
    {
        // Динамическая валидация: значение должно быть больше предыдущего
        $this->validate([
            'value' => "required|integer|min:{$this->currentMeterValue}",
            'reported_at' => "required|date",
        ], [
            'value.min' => "Новое показание не может быть меньше предыдущего ({$this->currentMeterValue}³).",
        ]);

        // Проверяем, не подавались ли показания в этом месяце
        /*$currentMonth = \Carbon\Carbon::parse($this->reported_at)->startOfMonth()->toDateString();
           $alreadySubmitted = $this->meter->readings()->where('reported_at', $currentMonth)->exists();

           if ($alreadySubmitted) {
               $this->error('Показания за этот месяц уже отправлены!');
               return;
           }*/

        // Сохраняем показания
        //dd($this->room->latestLease->end_date);
        BMeterReading::saveMeters([
            'lease_id' => $this->room->latestLease?->id,
            'meter_id' => $this->currentMeterId,
            'value' => $this->value,
            'reported_at' => $this->reported_at,
        ]);
        $this->dialog = false;
        $this->success('Показания приняты, счет сформирован!');
        /*  $reading = $this-> meter->readings()->create([
              'reading_value' => $this->reading_value,
              'reported_at' => $currentMonth,
          ]);

          // Автоматически генерируем счет (сервис, который мы писали ранее)
          $invoiceService->generateForReading($reading);

          // Показываем красивое уведомление от Mary UI
          $this->success('Показания приняты, счет сформирован!');

          // Перенаправляем в личный кабинет или очищаем форму
          $this->redirect(route('cabinet'));*/
    }
};
?>

@php
    $headersLease = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'start_date', 'label' => 'Начало', 'format' => ['date', 'd.m.Y']],
        ['key' => 'end_date', 'label' => 'Окончание', 'format' => ['date', 'd.m.Y']],
        ['key' => 'price', 'label' => 'Стоимость', 'format' => ['currency', '2,.', ' ₽']],
        ['key' => 'state', 'label' => 'Состояние']
    ];

    $rowDecorationMeters = [
        'text-gray-400' => fn(Meter $meter) => !$meter->active,
    ];

    $headersMeters = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'name', 'label' => 'Наименование'],
        ['key' => 'number', 'label' => 'Номер'],
        ['key' => 'verification', 'label' => 'Дата след.поверки', 'format' => ['date', 'd.m.Y']],
        ['key' => 'reading', 'label' => 'Посл.показание'],
        ['key' => 'actions', 'label' => 'Действия'],
    ];
@endphp


<div>
    <x-header title="{{ $name }}"/>
    <x-card title="{{ $address }}">
        <x-tabs wire:model="selectedTab">
            <x-tab name="meters-tab" label="Счётчики" icon="s-numbered-list">
                <x-badge value="Счётчики" class="badge-primary font-bold"/>
                <x-table :headers="$headersMeters" :rows="$this->room->meters" :row-decoration="$rowDecorationMeters">
                    @scope('cell_id', $meter)
                    {{ $loop->index+1 }}
                    @endscope
                    @scope('cell_name', $meter)
                    @if($meter->id == 1)
                        <x-icon name="o-light-bulb"/>
                    @elseif($meter->id == 2)
                        <x-icon name="m-light-bulb"/>
                    @elseif($meter->id == 3)
                        <x-icon name="s-cube" class="text-blue-500"/>
                    @elseif($meter->id == 4)
                        <x-icon name="s-cube" class="text-red-500"/>
                    @endif
                    {{ $meter->name }}
                    @endscope
                    @scope('cell_reading', $meter)
                    <div class="font-bold">{{ $meter->latestReading?->value }}</div>
                    <span class="text-xs">{{ $meter->latestReading?->reported_at->format('d.m.Y') }}</span>
                    @endscope
                    @scope('cell_actions', $meter)
                    @if($meter->active)
                        <x-button label="Ввести показание"
                                  wire:click="openDialog({{ $meter->id }}, '{{ $meter->name }}', {{ $meter->latestReading?->value }}, '{{ $meter->latestReading?->reported_at->format('d.m.Y') }}')"/>
                    @endif
                    @endscope
                </x-table>
            </x-tab>
            <x-tab name="tricks-tab" label="Платежи" icon="o-calculator">
                <div>Платежи</div>
            </x-tab>
            <x-tab name="doc-tab" label="Документы" icon="o-document">
                <x-badge value="Договора" class="badge-primary font-bold"/>
                <x-table :headers="$headersLease" :rows="$this->room->leases">
                    @scope('cell_id', $lease)
                    {{ $loop->index+1 }}
                    @endscope
                    @scope('cell_price', $lease)
                    {{ number_format($lease->price, 2, ',', '.') }} ₽
                    @endscope
                    @scope('cell_state', $lease)
                    @if(\Carbon\Carbon::parse($lease->end_date)->isFuture())
                        <x-badge value="Активен" icon="o-check" class="badge-success"/>
                    @else
                        <x-badge value="Окончен" class="badge-soft"/>
                    @endif
                    @endscope
                </x-table>
                @foreach($this->room->leases as $lease)
                    {{ $lease->price }}
                @endforeach
            </x-tab>
        </x-tabs>
    </x-card>

    <x-modal wire:model="dialog" title="Показание счётчика" subtitle="{{ $currentMeterName }}" persistent separator>
        <div class="p-3 mb-6 bg-base-200 rounded-lg text-xs flex justify-between items-center">
            <div>
                <span class="text-gray-500">Предыдущее показание:</span>
                <strong class="text-base ml-1">{{ $currentMeterValue }}</strong>
            </div>
            <div class="text-right">
                <span class="text-gray-500">Дата подачи:</span>
                <strong class="ml-1">{{ $currentMeterDate }}</strong>
            </div>
        </div>
        <x-form wire:submit="save">
            <x-input
                label="Текущее показание счётчика"
                wire:model="value"
                min="{{ $currentMeterValue }}"
                type="number"
                icon="o-arrow-trending-up"
                placeholder="Например: {{ $currentMeterValue + 5 }}"
                hint="Введите целое число без нулей впереди"
                class="text-sm"
            />

            <x-datetime
                label="Дата снятия показаний"
                wire:model="reported_at"
                icon="o-calendar"
                type="date"
                class="text-sm"
            />

            <x-slot:actions>
                <x-button label="Записать" class="btn-primary" type="submit"/>
                <x-button label="Отмена" @click="$wire.dialog = false"/>
            </x-slot:actions>
        </x-form>
    </x-modal>
</div>
