<?php namespace Lio\BladeParsing;

interface BladeTag
{
    public function getPattern();
    public function getMatchCount($view);
    public function transform($view);
}