<?php

interface IView
{
    public function form(int $id = null, string $mode = ''): string;

    public function list(): string;
}