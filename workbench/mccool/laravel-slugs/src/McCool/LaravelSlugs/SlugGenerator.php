<?php namespace McCool\LaravelSlugs;

class SlugGenerator
{
    protected $model;

    public function __construct(SlugInterface $model)
    {
        $this->model = $model;
    }

    public function updateSlug()
    {
        if ($this->hasSlug() and $this->slugHasntChanged()) {
            return;
        }

        if ($this->hasSlug()) {
            $this->archiveSlug();
        }

        return $this->generateSlug();
    }

    protected function hasSlug()
    {
        return (bool) $this->model->slug;
    }

    protected function slugHasntChanged()
    {
        return $this->model->slug->slug == $this->model->createSlugString();
    }

    protected function archiveSlug()
    {
        $slug = $this->model->slug;

        $slug->primary = 0;
        $slug->save();
    }

    protected function generateSlug()
    {
        $slugString = $this->getUniqueSlugString($this->model->createSlugString());

        $this->removeHistoricalSlug($slugString);

        return Slug::create([
            'slug'       => $slugString,
            'owner_id'   => $this->model->id,
            'owner_type' => get_class($this->model),
            'primary'    => 1,
        ]);
    }

    protected function getUniqueSlugString($slugString)
    {
        $padding = '';
        $slug = '';

        do {
            $slug = $slugString . $padding;

            $slugFound = Slug::where('primary', '=', 1)->where('slug', '=', $slug)->first();

            if ($slugFound) {
                if (empty($padding)) {
                    $padding = 1;
                }

                $padding++;
            }
        } while($slugFound);

        return $slug;
    }

    protected function removeHistoricalSlug($slugString)
    {
        $historicalSlug = Slug::where('slug', '=', $slug)->where('primary', '=', 0)->delete();
    }
}