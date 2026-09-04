<?php
namespace Popup\Styles;

use SkillDo\Traits\Singleton;

class PopupStyle
{
    use Singleton;

    protected array $styles = [];

    protected array $styleInstances = [];

    public function __construct()
    {
        $this->styles = [
            //Mẫu tự thiết kế bằng Page Builder — để đầu danh sách cho dễ thấy
            'builder' => PopupBuilder::class,
            'default' => PopupDefault::class,
            'style1' => PopupStyle1::class,
            'style2' => PopupStyle2::class,
            'style3' => PopupStyle3::class,
            'style4' => PopupStyle4::class,
            'style5' => PopupStyle5::class,
            'style6' => PopupStyle6::class,
            'style7' => PopupStyle7::class,
            'style8' => PopupStyle8::class,
            'style9' => PopupStyle9::class,
            'style10' => PopupStyle10::class,
            'style11' => PopupStyle11::class,
            'style12' => PopupStyle12::class,
        ];
    }

    public function all(): array
    {
        foreach ($this->styles as $key => $styleClass)
        {
            if(empty($this->styleInstances[$key]))
            {
                $this->styleInstances[$key] = new $styleClass();
            }

            $this->styles[$key] = $this->styleInstances[$key];
        }

        return $this->styles;
    }

    public function keys(): array
    {
        return array_keys($this->styles);
    }

    public function get($key): null|PopupStyleBase
    {
        if(isset($this->styles[$key]))
        {
            if(empty($this->styleInstances[$key]))
            {
                $styleClass = $this->styles[$key];

                $this->styleInstances[$key] = new $styleClass();
            }

            return $this->styleInstances[$key];
        }

        return null;
    }
}