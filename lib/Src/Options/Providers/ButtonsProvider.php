<?php

namespace Base\Module\Src\Options\Providers;

use Base\Module\Src\Options\Interface\OptionProvider;

class ButtonsProvider implements OptionProvider
{
    private array $buttons = [];
    private string $align = 'left';

    public function getType(): string
    {
        return 'buttons';
    }

    public function render(array $option, string $moduleId): string
    {
        $params = $option['params'] ?? [];
        $buttons = $params['buttons'] ?? $this->buttons;
        $align = $params['align'] ?? $this->align;

        $html = '<tr>';
        $html .= '<td colspan="2">';
        $html .= '<div class="base-module-buttons-option" data-align="' . htmlspecialcharsbx($align) . '">';
        foreach ($buttons as $button) {
            $title = htmlspecialcharsbx((string)($button['title'] ?? ''));
            $js = (string)($button['js'] ?? '');
            $buttonAlign = $button['align'] ?? $align;
            $html .= '<button type="button" class="base-module-buttons-option-btn" data-align="' .
                htmlspecialcharsbx($buttonAlign) . '" data-js="' .
                htmlspecialcharsbx($js) . '">' . $title . '</button>';
        }
        $html .= '</div>';
        $html .= $this->renderStyle();
        $html .= $this->renderScript();
        $html .= '</td>';
        $html .= '</tr>';

        return $html;
    }

    public function save(array $option, string $moduleId, mixed $value): void
    {
        // Ряд кнопок не сохраняет значений.
    }

    public function setButtons(array $buttons): self
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function setAlign(string $align): self
    {
        $this->align = $align;
        return $this;
    }

    public function getParamsToArray(): array
    {
        return [
            'buttons' => $this->buttons,
            'align' => $this->align,
        ];
    }

    private function renderStyle(): string
    {
        return '<style>
.base-module-buttons-option { padding: 8px 0; }
.base-module-buttons-option[data-align="left"] { text-align: left; }
.base-module-buttons-option[data-align="center"] { text-align: center; }
.base-module-buttons-option[data-align="right"] { text-align: right; }
.base-module-buttons-option-btn {
    margin: 0 4px; padding: 4px 14px;
    border: 1px solid #c8c8c8; border-radius: 3px;
    background: #fff; cursor: pointer; font-size: 13px;
}
.base-module-buttons-option-btn[data-align="left"] { float: left; }
.base-module-buttons-option-btn[data-align="right"] { float: right; }
.base-module-buttons-option-btn:hover { background: #f4f4f4; }
</style>';
    }

    private function renderScript(): string
    {
        return '<script>
(function () {
    var buttons = document.querySelectorAll(".base-module-buttons-option-btn");
    for (var i = 0; i < buttons.length; i++) {
        if (buttons[i].getAttribute("data-bind-bound")) {
            continue;
        }
        buttons[i].setAttribute("data-bind-bound", "1");
        buttons[i].addEventListener("click", function () {
            var js = this.getAttribute("data-js");
            if (js) {
                (new Function(js)).call(this);
            }
        });
    }
})();
</script>';
    }
}