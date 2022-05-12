<?php

namespace Modules\Event\Blocks;

use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class FormSearchEvent extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id' => 'title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __('Title')
                ],
                [
                    'id' => 'sub_title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __('Sub Title')
                ],
                [
                    'id' => 'style',
                    'type' => 'radios',
                    'label' => __('Style Background'),
                    'values' => [
                        [
                            'value' => '',
                            'name' => __("Normal")
                        ],
                        [
                            'value' => 'carousel',
                            'name' => __("Slider Carousel")
                        ]
                    ]
                ],
                [
                    'id' => 'bg_image',
                    'type' => 'uploader',
                    'label' => __('- Layout Normal: Background Image Uploader')
                ],
                [
                    'id' => 'list_slider',
                    'type' => 'listItem',
                    'label' => __('- Layout Slider: List Item(s)'),
                    'title_field' => 'title',
                    'settings' => [
                        [
                            'id' => 'bg_image',
                            'type' => 'uploader',
                            'label' => __('Background Image Uploader')
                        ]
                    ]
                ]
            ],
            'category' => __("Service Event")
        ]);
    }

    public function getName()
    {
        return __('Event: Form Search');
    }

    public function content($model = [])
    {
        $limit_location = 15;
        if (empty(setting_item("event_location_search_style")) or setting_item("event_location_search_style") == "normal") {
            $limit_location = 1000;
        }
        $data = [
            'list_location' => Location::where("status", "publish")->limit($limit_location)->with(['translations'])->get()->toTree(),
            'bg_image_url' => '',
        ];
        $data = array_merge($model, $data);
        if (!empty($model['bg_image'])) {
            $data['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        $data['style'] = $model['style'] ?? "";
        $data['list_slider'] = $model['list_slider'] ?? "";
        return view('Event::frontend.blocks.form-search-event.index', $data);
    }

    public function contentAPI($model = [])
    {
        if (!empty($model['bg_image'])) {
            $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        return $model;
    }
}
