<?php

namespace Jeffgreco13\FilamentBlogger;

use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Camya\Filament\Forms\Components\TitleWithSlugInput;

class FilamentBlogger
{
    protected $titleWithSlugInput = null;
    protected $tagsInput = null;
    protected $tiptapInput = null;
    protected $curatorFeaturedImageInput = null;
    protected $slugPath = 'blog';
    protected $modalWidth = "xl";

    public function getTitleWithSlugInput()
    {
        if (is_null($this->titleWithSlugInput)){
            return TitleWithSlugInput::make(
                urlPath: "/{$this->slugPath}/",
                fieldTitle: 'title',
                fieldSlug: 'slug',
                urlVisitLinkVisible: false,
                titleRules: [
                    'required',
                    'string',
                    'min:3',
                ],
            );
        } else {
            return $this->titleWithSlugInput;
        }
    }

    public function getTagsInput()
    {
        if (is_null($this->tagsInput)){
            return SpatieTagsInput::make('tags')->type('blog');
        } else {
            return $this->tagsInput;
        }
    }

    public function getTiptapInput()
    {
        if (is_null($this->tiptapInput)){
            return TiptapEditor::make('content')
                ->profile('simple')
                ->extraInputAttributes(['style' => 'min-height: 18rem;'])
                ->required();
        } else {
            return $this->tiptapInput;
        }

    }

    public function getCuratorFeaturedImageInput()
    {
        if (is_null($this->curatorFeaturedImageInput)){
            return CuratorPicker::make('featured_image_id')
                ->label('Featured image')
                ->relationship('featuredImage', 'id');
        } else {
            return $this->curatorFeaturedImageInput;
        }

    }

    public function slugPath(string $path)
    {
        $this->slugPath = $path;
    }

    public function getSlugPath()
    {
        return $this->slugPath;
    }

    public function modalWidth(string $w)
    {
        $this->modalWidth = $w;
    }
    public function getModalWidth()
    {
        return $this->modalWidth;
    }
}
