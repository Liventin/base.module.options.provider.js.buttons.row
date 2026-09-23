# base.module.options.provider.buttons

<table>
<tr>
<td>
<a href="https://github.com/Liventin/base.module">Bitrix Base Module</a>
</td>
</tr>
</table>

install | update

```
"require": {
    "liventin/base.module.options.provider.buttons": "^1.0.0"
}
```
redirect (optional)
```
"extra": {
  "service-redirect": {
    "liventin/base.module.options.provider.buttons": "module.name",
  }
}
```

## Что это

Провайдер опции-ряда кнопок (`type: 'buttons'`). Опция не сохраняет значений;
кнопки рисуются под таблицей (или в любом месте вкладки) с выравниванием и JS-обработчиком
по клику:

```php
$provider = $srvOptions->getProvider('buttons');

return $provider
    ->setAlign('left')             // left | center | right
    ->setButtons([
        [
            'title' => 'Экспорт полей',
            'js'    => 'alert("hello");', // выполняется по клику (в контексте кнопки)
        ],
        [
            'title' => 'Обновить',
            'align' => 'right',     // (опционально) переопределить выравнивание для кнопки
            'js'    => 'BX.reload();',
        ],
    ])
    ->getParamsToArray();
```

### Параметры

- `title` — текст кнопки.
- `js` — JS-код, выполняемый по клику через `new Function(js).call(this)` (в контексте кнопки).
- `align` — (в `setAlign` или на кнопке) `left`/`center`/`right`, по умолчанию `left`.

### Пример опции

```php
class ExportButtons implements Option
{
    public static function getType(): string { return 'buttons'; }

    public static function getParams(): array
    {
        /* @var \Base\Module\Src\Options\Providers\ButtonsProvider $provider */
        $provider = \Base\Module\Service\Container::get(\Base\Module\Service\Options\OptionsService::SERVICE_CODE)
            ->getProvider('buttons');

        return $provider
            ->setAlign('right')
            ->setButtons([
                ['title' => 'Экспорт', 'js' => 'BX.PopupWindowManager.create(...)'],
            ])
            ->getParamsToArray();
    }
}
```

Php Storm Live Template

```
<?php

namespace ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Options;

use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\Options\Option;

class ButtonsSample implements Option
{
    public static function getId(): string
    {
        return 'sample_buttons';
    }

    public static function getName(): string
    {
        return 'Пример кнопок';
    }

    public static function getType(): string
    {
        return 'buttons';
    }

    public static function getTabId(): string
    {
        return TabMain::getId();
    }

    public static function getSort(): int
    {
        return 50;
    }

    public static function getParams(): array
    {
        return [
            'buttons' => [
                ['title' => 'Действие', 'js' => 'alert("click");'],
            ],
            'align' => 'left',
        ];
    }
}
```