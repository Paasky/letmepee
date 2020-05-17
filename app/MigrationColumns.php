<?php

namespace App;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

trait MigrationColumns
{
    /**
     * @param Blueprint $table
     * @return array|ColumnDefinition[]
     */
    public static function coords(Blueprint &$table): array
    {
        return [
            $table->point('coords')->index(),
            $table->decimal('lat', 10, 7)->index(),
            $table->decimal('lng', 10, 7)->index(),
        ];
    }

    public static function description(Blueprint &$table): ColumnDefinition
    {
        return $table->longText('description')->nullable();
    }

    public static function featureId(Blueprint &$table): ColumnDefinition
    {
        return $table->string('feature_id', 255)->index();
    }

    public static function locationId(Blueprint &$table): ColumnDefinition
    {
        return $table->bigInteger('location_id')->index();
    }

    public static function locationTypeId(Blueprint &$table): ColumnDefinition
    {
        return $table->string('location_type_id', 255)->index();
    }

    public static function title(Blueprint &$table): ColumnDefinition
    {
        return $table->string('title', 255);
    }

    public static function userId(Blueprint &$table): ColumnDefinition
    {
        return $table->bigInteger('user_id')->index();
    }
}