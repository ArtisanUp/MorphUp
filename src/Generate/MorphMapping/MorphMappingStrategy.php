<?php

namespace ArtisanUp\MorphUp\Generate\MorphMapping;

enum MorphMappingStrategy : string
{
    /* Snake case 🐍 the class name only. Models\MyModel becomes my_model */
    case CLASS_NAME_SNAKE = 'class_name_snake';

    /* Snake case 🐍 the full namespace. Models\MyModel becomes models_my_model */
    case FULL_NAMESPACE_SNAKE = 'full_namespace_snake';

    /**
     * Is the strategy safe to use in the case of a model name clash.
     * E.g. two models in different namespaces Staff/User and Customer/User.
     *
     * @return bool
     */
    public function isClashSafe(): bool
    {
        return match ($this) {
            self::CLASS_NAME_SNAKE     => false,
            self::FULL_NAMESPACE_SNAKE => true
        };
    }
}
